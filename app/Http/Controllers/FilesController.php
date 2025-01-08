<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblFile;
use App\Models\TblFileRelation;
use Illuminate\Support\Facades\Log;
use App\Models\Groups; 
use App\Models\User;
use App\Models\TblCategory;
use App\Models\TblCategoryRelation;
use ZipArchive;

class FilesController extends Controller
{
    public function index(Request $request)
{
    $search = $request->get('search');
    $uploaderFilter = $request->get('uploader');
    $sort = $request->get('sort', 'timestamp'); // Ordenar por 'timestamp' por defecto
    $direction = $request->get('direction', 'asc'); // Dirección ascendente por defecto

    // Validar las columnas permitidas para ordenar
    $allowedSorts = ['timestamp', 'filename', 'uploader', 'public_allow', 'download_count'];
    if (!in_array($sort, $allowedSorts)) {
        $sort = 'timestamp'; // Valor por defecto si la columna no es válida
    }

    // Total general de archivos
    $totalFiles = TblFile::count();

    // Construir la consulta con los filtros
    $query = TblFile::with(['fileRelations', 'downloads']);

    if ($search) {
        $query->where('filename', 'LIKE', "%$search%");
    }

    if ($uploaderFilter) {
        $query->where('uploader', $uploaderFilter);
    }

    // Manejar la ordenación por `download_count`
    if ($sort === 'download_count') {
        $query->withCount('fileRelations as download_count')->orderBy('download_count', $direction);
    } else {
        // Aplicar la ordenación regular
        $query->orderBy($sort, $direction);
    }

    // Total de archivos después de aplicar filtros
    $filteredTotal = $query->count();

    // Paginación con filtros incluidos
    $files = $query->paginate(10)->appends($request->except('page'));

    // Obtener los cargadores únicos
    $uploaders = TblFile::select('uploader')->distinct()->pluck('uploader');

    return view('files.file_manager', compact('files', 'uploaders', 'totalFiles', 'filteredTotal', 'sort', 'direction'));
}



    public function downloadCompressed(Request $request)
{
    $fileIds = $request->input('batch');
    if (!$fileIds || count($fileIds) === 0) {
        return redirect()->back()->with('error', 'Debe seleccionar al menos un archivo para descargar.');
    }

    $files = TblFile::whereIn('id', $fileIds)->get();

    if ($files->isEmpty()) {
        return redirect()->back()->with('error', 'No se encontraron archivos para descargar.');
    }

    // Crear un archivo ZIP
    $zipFileName = 'archivos_seleccionados_' . time() . '.zip';
    $zipFilePath = storage_path($zipFileName);
    $zip = new ZipArchive;

    if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $filePath = storage_path('app/' . $file->url);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $file->filename);
            }
        }
        $zip->close();
    } else {
        return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
    }

    // Descargar el archivo ZIP y eliminarlo después
    return response()->download($zipFilePath)->deleteFileAfterSend(true);
}
    

    




    public function bulkAction(Request $request)
    {
        Log::info('Datos recibidos en bulkAction:', $request->all());
        $action = $request->input('action');
        $fileIds = $request->input('batch');
    
        if (!$fileIds || $action === 'none') {
            return redirect()->back()->with('error', 'Seleccione una acción válida y al menos un archivo.');
        }
    
        // Lógica para procesar las acciones
        switch ($action) {
            case 'hide':
                TblFileRelation::whereIn('file_id', $fileIds)->update(['hidden' => 1]);
                return redirect()->back()->with('success', 'Archivos ocultados exitosamente.');
            case 'show':
                TblFileRelation::whereIn('file_id', $fileIds)->update(['hidden' => 0]);
                return redirect()->back()->with('success', 'Archivos visibles nuevamente.');
            case 'delete':
                TblFileRelation::whereIn('file_id', $fileIds)->delete();
                TblFile::whereIn('id', $fileIds)->delete();
                return redirect()->back()->with('success', 'Archivos eliminados correctamente.');
            default:
                return redirect()->back()->with('error', 'Seleccione una acción válida.');
        }
    }
    

    public function download($id)
    {
        $file = TblFile::findOrFail($id);

        if (!$file) {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

        return response()->download(storage_path('app/' . $file->url), $file->filename);
    }

    public function edit($fileId)
    {
        $file = TblFile::findOrFail($fileId);

        // Generar token público si no existe
        if (!$file->public_token) {
            $file->public_token = Str::random(32);
            $file->save();
        }

        $clients = User::all();
        $groups = Groups::all();
        $categories = TblCategory::all();

        $selectedAssignments = TblFileRelation::where('file_id', $fileId)
            ->whereNotNull('client_id')
            ->pluck('client_id')
            ->toArray();

        $selectedGroups = TblFileRelation::where('file_id', $fileId)
            ->whereNotNull('group_id')
            ->pluck('group_id')
            ->toArray();

        $selectedCategories = TblCategoryRelation::where('file_id', $fileId)
            ->pluck('cat_id')
            ->toArray();

        return view('files.file_edit', compact(
            'file',
            'clients',
            'groups',
            'categories',
            'selectedAssignments',
            'selectedGroups',
            'selectedCategories',
            'fileId'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'expires' => 'boolean',
            'public_allow' => 'boolean',
            'assignments' => 'nullable|array',
            'assignments.*' => 'string',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:tbl_categories,id',
        ]);

        $file = TblFile::findOrFail($id);

        $file->update([
            'filename' => $request->input('filename'),
            'description' => $request->input('description') ?? '',
            'expiry_date' => $request->input('expires') ? $request->input('expiry_date') : null,
            'expires' => $request->boolean('expires'),
            'public_allow' => $request->boolean('public_allow'),
        ]);

        TblCategoryRelation::where('file_id', $file->id)->delete();

        if ($request->has('categories')) {
            foreach ($request->input('categories') as $categoryId) {
                TblCategoryRelation::create([
                    'file_id' => $file->id,
                    'cat_id' => $categoryId,
                ]);
            }
        }

        return redirect()->route('files.edit', $id)->with('success', 'El archivo se ha actualizado correctamente.');
    }
}