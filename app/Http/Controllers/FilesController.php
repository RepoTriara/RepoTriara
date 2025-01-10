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
    // Obtener el ID del cliente desde la query string
    $clientId = $request->query('client_id');
    
    // Obtener el ID del grupo desde la query string
    $groupId = $request->query('group_id');
    
    // Definir la variable $uploaders
    $uploaders = TblFile::select('uploader')->distinct()->pluck('uploader');
    
    // Contar el total de archivos
    $totalFiles = TblFile::count();  // Esto contará todos los archivos disponibles
    
    if ($clientId) {
        // Buscar al cliente con el ID
        $client = User::find($clientId); // Asegúrate de que `User` sea el modelo correcto
    
        if ($client) {
            // Cambiar el título de la página
            $pageTitle = __('Archivos asignados a') . ' ' . $client->name;
    
            // Obtener los archivos asignados al cliente con relaciones
            $files = TblFile::whereHas('fileRelations', function ($query) use ($clientId) {
                $query->where('client_id', $clientId);
            })
            ->paginate(10);
    
            $filteredTotal = $files->total();  // El total de archivos filtrados
            
            return view('files.file_manager', compact('pageTitle', 'client', 'files', 'uploaders', 'totalFiles', 'filteredTotal'));
        } else {
            // Si el cliente no existe, devolver error
            $error = __('El cliente no existe');
            return view('files.file_manager', compact('error', 'uploaders', 'totalFiles'));
        }
    }elseif ($groupId) {
        // Buscar el grupo con el ID
        $group = Groups::find($groupId); // Asegúrate de que `Groups` sea el modelo correcto
        
        if ($group) {
            // Cambiar el título de la página
            $pageTitle = __('Archivos asignados al grupo') . ' ' . $group->name;
    
            // Obtener el valor del filtro "hidden" de la query string
            $hiddenFilter = $request->query('hidden');
            
            // Obtener el valor de la búsqueda
            $searchQuery = $request->query('search');
    
            // Obtener los archivos asignados al grupo con relaciones, y aplicar la paginación
            $query = TblFile::whereHas('fileRelations', function ($query) use ($groupId) {
                $query->where('group_id', $groupId); // Filtrar archivos por group_id
            });
    
            // Si el filtro 'hidden' está presente, aplicar el filtro adicional
            if ($hiddenFilter !== null) {
                $query->where('hidden', $hiddenFilter);
            }
    
            // Si la búsqueda está presente, aplicar el filtro de búsqueda
            if ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%'); // Filtrar por el nombre del archivo
            }
    
            // Paginación de archivos filtrados
            $files = $query->paginate(10)->appends($request->except('page')); // Mantener otros parámetros de la query string
            
            // Contar el total de archivos filtrados por group_id, 'hidden', y búsqueda
            $filteredTotal = $query->count();  // Contar los archivos filtrados
    
            // Contar los archivos del grupo, no todos los archivos
            $totalFiles = $filteredTotal; // Cambiar $totalFiles para reflejar solo los archivos del grupo
    
            // Obtener los cargadores únicos
            $uploaders = TblFile::select('uploader')->distinct()->pluck('uploader');
    
            return view('files.file_manager', compact('pageTitle', 'group', 'files', 'uploaders', 'totalFiles', 'filteredTotal'));
        } else {
            // Si el grupo no existe, devolver error
            $error = __('El grupo no existe');
            return view('files.file_manager', compact('error', 'uploaders', 'totalFiles'));
        }
    }
    
    
    else {
        // Si no hay client_id ni group_id en la query string, devolver los cargadores únicos y archivos paginados
        $files = TblFile::paginate(10);

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
