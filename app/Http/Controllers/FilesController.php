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
use Illuminate\Support\Str;
use App\Models\Members;

class FilesController extends Controller
{
    public function index(Request $request)
{
    // Obtener el ID del cliente desde la query string
    $clientId = $request->query('client_id');

    // Obtener el ID del grupo desde la query string
    $groupId = $request->query('group_id');

    // Obtener el ID de la categoría desde la query string
    $categoryId = $request->query('category_id');

    // Definir la variable $uploaders
    $uploaders = TblFile::select('uploader')->distinct()->pluck('uploader');

    // Contar el total de archivos
    $totalFiles = TblFile::count();

    // Filtrar por cliente
    if ($clientId) {
        // Buscar al cliente con el ID
        $client = User::find($clientId);

        if ($client) {
            $pageTitle = __('Archivos asignados a') . ' ' . $client->name;
            $files = TblFile::whereHas('fileRelations', function ($query) use ($clientId) {
                $query->where('client_id', $clientId);
            })
            ->paginate(10);

            $filteredTotal = $files->total();
            return view('files.file_manager', compact('pageTitle', 'client', 'files', 'uploaders', 'totalFiles', 'filteredTotal'));
        } else {
            $error = __('El cliente no existe');
            return view('files.file_manager', compact('error', 'uploaders', 'totalFiles'));
        }
    }

    // Filtrar por grupo
    elseif ($groupId) {
        $group = Groups::find($groupId);

        if ($group) {
            $pageTitle = __('Archivos asignados al grupo') . ' ' . $group->name;
            $hiddenFilter = $request->query('hidden');
            $searchQuery = $request->query('search');

            $query = TblFile::whereHas('fileRelations', function ($query) use ($groupId) {
                $query->where('group_id', $groupId);
            });

            if ($hiddenFilter !== null) {
                $query->where('hidden', $hiddenFilter);
            }

            if ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            }

            $files = $query->paginate(10)->appends($request->except('page'));
            $filteredTotal = $query->count();
            $totalFiles = $filteredTotal;

            return view('files.file_manager', compact('pageTitle', 'group', 'files', 'uploaders', 'totalFiles', 'filteredTotal'));
        } else {
            $error = __('El grupo no existe');
            return view('files.file_manager', compact('error', 'uploaders', 'totalFiles'));
        }
    }

    // Filtrar por categoría
    elseif ($categoryId) {
        $category = TblCategory::find($categoryId);

        if ($category) {
            $pageTitle = __('Archivos de la categoría') . ' ' . $category->name;

            // Aquí aplicamos el filtrado por categoría
            $files = TblFile::whereHas('categoryRelations', function ($query) use ($categoryId) {
                $query->where('cat_id', $categoryId);  // Cambiado de 'category_id' a 'cat_id'
            })
            ->paginate(10);

            $filteredTotal = $files->total();
            return view('files.file_manager', compact('pageTitle', 'category', 'files', 'uploaders', 'totalFiles', 'filteredTotal'));
        } else {
            $error = __('La categoría no existe');
            return view('files.file_manager', compact('error', 'uploaders', 'totalFiles'));
        }
    }

    // Sin filtros de cliente, grupo ni categoría, mostrar todos los archivos
    else {
        // Si no hay client_id, group_id ni category_id, simplemente mostramos todos los archivos
        $files = TblFile::paginate(10);

        $search = $request->get('search');
        $uploaderFilter = $request->get('uploader');
        $sort = $request->get('sort', 'timestamp');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = ['timestamp', 'filename', 'uploader', 'public_allow', 'download_count'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'timestamp';
        }

        $totalFiles = TblFile::count();

        $query = TblFile::with(['fileRelations', 'downloads']);

        if ($search) {
            $query->where('filename', 'LIKE', "%$search%");
        }

        if ($uploaderFilter) {
            $query->where('uploader', $uploaderFilter);
        }

        if ($sort === 'download_count') {
            $query->withCount('fileRelations as download_count')->orderBy('download_count', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $filteredTotal = $query->count();
        $files = $query->paginate(10)->appends($request->except('page'));

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


    public function download(Request $request)
    {
        $file = TblFile::where('id', $request->id)
                       ->where('public_token', $request->token)
                       ->first();

        if (!$file || !$file->public_allow) {
            abort(403, 'Acceso no permitido.');
        }

        $path = storage_path('app/' . $file->url);

        if (file_exists($path)) {
            return response()->download($path, $file->filename);
        }

        return redirect()->back()->withErrors(['error' => 'El archivo no existe.']);
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

    public function uploadProcess(Request $request)
    {
        try {
            Log::info('Datos recibidos por el controlador:', $request->all());

            $request->validate([
                'file' => 'required|file|max:20480',
                'name' => 'required|string',
            ]);

            $tempDir = storage_path('app/private/uploads/tmp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move($tempDir, $filename);

            if (!$filePath) {
                Log::error('Error al guardar el archivo en el directorio temporal.');
                return response()->json(['error' => 'No se pudo guardar el archivo.'], 500);
            }

            Log::info('Archivo guardado correctamente:', ['path' => $filePath]);

            // Agregar el archivo a la sesión
            $uploadedFiles = session('uploaded_files', []);
            $uploadedFiles[] = $filename;
            session(['uploaded_files' => $uploadedFiles]);

            return response()->json([
                'success' => true,
                'file' => [
                    'name' => $filename,
                    'path' => $filePath,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al procesar los archivos:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al procesar los archivos: ' . $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
{
    try {
        Log::info('Datos recibidos en el controlador store:', $request->all());

        // Validar datos
        $data = $request->validate([
            'file' => 'required|array',
            'file.*.file' => 'required|string',
            'file.*.name' => 'required|string',
            'file.*.categories' => 'required|array',
            'file.*.assignments' => 'required|array',
            'file.*.expiry_date' => 'nullable|date',
            'file.*.description' => 'nullable|string',
            'file.*.public' => 'nullable|boolean',
            'file.*.hidden' => 'nullable|boolean',
        ]);

        $tempDir = storage_path('app/private/uploads/tmp');
        $finalDir = storage_path('app/private/uploads');
        $savedFiles = [];

        // Crear carpeta final si no existe
        if (!file_exists($finalDir)) {
            mkdir($finalDir, 0777, true);
        }

        foreach ($data['file'] as $key => $fileData) {
            $fileData['public'] = isset($fileData['public']) ? (int)$fileData['public'] : 0;
            $fileData['hidden'] = isset($fileData['hidden']) ? (int)$fileData['hidden'] : 0;

            $tempFilePath = $tempDir . DIRECTORY_SEPARATOR . $fileData['file'];

            if (!file_exists($tempFilePath)) {
                Log::warning('Archivo no encontrado en la carpeta temporal:', ['file' => $tempFilePath]);
                continue;
            }

            // Generar un nombre único para el archivo final
            $fileExtension = pathinfo($fileData['file'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '-' . sha1(uniqid() . microtime()) . ($fileExtension ? '.' . $fileExtension : '');
            $finalFilePath = $finalDir . DIRECTORY_SEPARATOR . $uniqueFileName;

            if (!rename($tempFilePath, $finalFilePath)) {
                throw new \Exception('Error al mover el archivo a su ubicación final: ' . $finalFilePath);
            }

            // Preparar datos para la base de datos
            $fileDataForDatabase = [
                'filename' => $fileData['name'],
                'url' => $uniqueFileName,
                'original_url' => preg_replace('/^\d+_/', '', $fileData['file']),
                'description' => $fileData['description'] ?? 'Sin descripción',
                'uploader' => auth()->user()->name ?? 'anónimo',
                'expires' => isset($fileData['expiry_date']) ? 1 : 0,
                'expiry_date' => $fileData['expiry_date'] ?? '2025-01-01 00:00:00',
                'public_allow' => $fileData['public'],
                'hidden' => $fileData['hidden'],
                'public_token' => $fileData['public'] ? bin2hex(random_bytes(16)) : null,
            ];

            $file = TblFile::create($fileDataForDatabase);

            // Guardar relaciones de asignaciones
            foreach ($fileData['assignments'] as $assignment) {
                TblFileRelation::create([
                    'file_id' => $file->id,
                    'client_id' => $assignment,
                    'timestamp' => now(),
                    'hidden' => $fileData['hidden'] ?? 0,
                ]);
            }

            // Guardar relaciones de categorías
            foreach ($fileData['categories'] as $categoryId) {
                TblCategoryRelation::create([
                    'file_id' => $file->id,
                    'cat_id' => $categoryId,
                    'timestamp' => now(),
                ]);
            }

            // Contar relaciones de asignaciones y categorías
            $assignmentsCount = TblFileRelation::where('file_id', $file->id)->count();
            $categoriesCount = TblCategoryRelation::where('file_id', $file->id)->count();

            $file->assignments_count = $assignmentsCount;
            $file->categories_count = $categoriesCount;

            $savedFiles[] = $file->loadCount(['fileRelations', 'categoryRelations']);
        }

        session()->forget('uploaded_files');

        return redirect()->route('files.upload_process.view')->with('savedFiles', $savedFiles);
    } catch (\Exception $e) {
        Log::error('Error al guardar los archivos:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => 'Error al guardar los archivos: ' . $e->getMessage()]);
    }
}

public function uploadProcessView(Request $request)
{
    try {
        // Reconstruir archivos en proceso desde la sesión
        $files = collect();
        $uploadedFiles = session('uploaded_files', []);
        $tempDir = storage_path('app/private/uploads/tmp');

        foreach ($uploadedFiles as $filename) {
            $filePath = $tempDir . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($filePath)) {
                $files->push((object) [
                    'id' => uniqid(),
                    'file' => $filename,
                    'name' => preg_replace('/^\d+_/', '', $filename),
                    'path' => $filePath,
                    'size' => filesize($filePath),
                    'title' => preg_replace('/^\d+_/', '', pathinfo($filePath, PATHINFO_FILENAME)),
                    'description' => 'Sin descripción',
                    'expiry_date' => now()->addYear()->format('Y-m-d'),
                    'public' => false,
                    'assignments' => collect([]),
                    'categories' => collect([]),
                    'hidden' => false,
                ]);
            }
        }

        // Recuperar archivos guardados y archivos archivados de la sesión
        $savedFiles = collect(session('savedFiles', []));
        $archivedFiles = collect(session('archivedFiles', []));

        // Si hay archivos guardados, archívalos y elimina los guardados
        if ($savedFiles->isNotEmpty()) {
            $recentlyArchived = $savedFiles->map(function ($file) {
                return [
                    'filename' => $file['filename'],
                    'description' => $file['description'] ?? 'Sin descripción',
                ];
            });


            $archivedFiles = $recentlyArchived;


            session(['archivedFiles' => $archivedFiles->toArray()]);
            session()->forget('savedFiles');
        }

        // Cargar usuarios y categorías
        $users = User::all();
        $categories = TblCategory::all();

        // Regresar los datos a la vista
        return view('files.upload_process', compact(
            'files',
            'savedFiles',
            'archivedFiles',
            'users',
            'categories'
        ));
    } catch (\Exception $e) {
        Log::error('Error al cargar la vista de proceso de carga:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => 'Error al cargar los archivos para procesar.']);
    }
}


 // codigto de la vista my_files
 public function myFiles(Request $request)
 {
     // Obtener parámetros opcionales de la query string
     $search = $request->query('search');
     $category = $request->query('category', 0);
     $sorts = $request->query('sort', 'timestamp'); // Ordenar por columna predeterminada
     $direction = $request->query('direction', 'asc'); // Dirección predeterminada

     // Definir título de la página
     $pageTitle = __('Administración del Sistema');

     // Obtener el ID del cliente autenticado
     $clientId = $request->query('cliente_id');

     // Obtener IDs de los grupos a los que pertenece el cliente
     $groupIds = Members::where('client_id', $clientId)->pluck('group_id')->toArray();

     // Construir la consulta para los archivos propios del cliente y los de sus grupos
     $filesQuery = TblFile::where(function ($query) use ($clientId, $groupIds) {
         $query->whereHas('fileRelations', function ($subQuery) use ($clientId) {
             $subQuery->where('client_id', $clientId); // Archivos propios del cliente
         })->orWhereHas('fileRelations', function ($subQuery) use ($groupIds) {
             $subQuery->whereIn('group_id', $groupIds); // Archivos de los grupos a los que pertenece
         });
     })
         ->with([
             'groups' => function ($query) {
                 $query->select('tbl_groups.id', 'tbl_groups.description'); // Especificar las columnas para evitar ambigüedad
             }
         ]);

     // Filtrar por búsqueda (título o descripción)
     if ($search) {
         $filesQuery->where(function ($query) use ($search) {
             $query->where('filename', 'like', '%' . $search . '%')
                 ->orWhere('description', 'like', '%' . $search . '%')
                 ->orWhere('timestamp', 'like', '%' . $search . '%');
         });
     }

     // Aplicar ordenación según los parámetros
     $filesQuery->orderBy($sorts, $direction);

     // Obtener los archivos paginados
     $files = $filesQuery->get(); // Traemos todos los archivos sin paginar primero

     // Agregar lógica de expiración y tamaño
     foreach ($files as $file) {
         $filePath = storage_path('app/private/uploads/' . $file->filename); // Ruta del archivo

         if (file_exists($filePath)) {
             $file->size = filesize($filePath); // Tamaño en bytes
         } else {
             $file->size = null; // Archivo no encontrado
         }

         if ($file->expires && $file->expiry_date) {
             $expiryDate = \Carbon\Carbon::parse($file->expiry_date);
             $file->isExpired = $expiryDate->isPast();
             $file->formattedExpiryDate = $expiryDate->format('Y/m/d');
         } else {
             $file->isExpired = false;
             $file->formattedExpiryDate = null;
         }
     }

     // Filtrar los archivos:

     $files = $files->filter(function ($file) use ($clientId) {
         // Mostrar siempre los archivos propios
         if ($file->fileRelations->contains('client_id', $clientId)) {
             return true;
         }
         // Mostrar archivos que no han expirado
         return !$file->isExpired;
     });

     // Obtener el total de archivos que estamos visualizando (después del filtro)
     $filteredTotal = $files->count();

     // Paginación
     $files = new \Illuminate\Pagination\LengthAwarePaginator(
         $files->forPage($request->get('page', 1), 10), // Filtrar solo los archivos de la página actual
         $filteredTotal,
         10,
         $request->get('page', 1),
         ['path' => $request->url(), 'query' => $request->query()]
     );

     // Renderizar la vista dashboard_level0 con los datos necesarios
     return view('files.my_files', compact('pageTitle', 'files', 'filteredTotal'));
 }

 // codigto de la vista manage-files
 public function manageFiles(Request $request)
 {
     // Obtener parámetros opcionales de la query string
     $search = $request->query('search');
     $category = $request->query('category', 0);
     $sorts = $request->query('sort', 'timestamp');
     $direction = $request->query('direction', 'asc');

     // Definir título de la página
     $pageTitle = __('Administración del Sistema');

     // Obtener el ID del cliente autenticado
     $clientId = auth()->user()->id; // Cambia esto según tu implementación de autenticación

     // Construir la consulta para los archivos propios del cliente
     $filesQuery = TblFile::whereHas('fileRelations', function ($subQuery) use ($clientId) {
         $subQuery->where('client_id', $clientId); // Archivos propios del cliente
     });


     // Filtrar por búsqueda (título o descripción)
     if ($search) {
         $filesQuery->where(function ($query) use ($search) {
             $query->where('filename', 'like', '%' . $search . '%')
                 ->orWhere('description', 'like', '%' . $search . '%')
                 ->orWhere('timestamp', 'like', '%' . $search . '%');

         });
     }

     // Aplicar ordenación según los parámetros
     $filesQuery->orderBy($sorts, $direction);

     // Obtener el total de archivos antes de la paginación
     $filteredTotal = $filesQuery->count();

     // Obtener los archivos paginados
     $files = $filesQuery->paginate(10);

     return view('files.manage-files', compact('pageTitle', 'files', 'filteredTotal'));
 }




















}
