<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TblFile;
use App\Models\TblFileRelation;
use App\Models\Groups;
use App\Models\User;
use App\Models\TblCategory;
use App\Models\TblCategoryRelation;
use ZipArchive;
use Illuminate\Support\Str;
use App\Models\Members;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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

      // Filtrar por cliente, grupo o categoría
if ($clientId || $groupId || $categoryId) {
    if ($clientId) {
        $entity = User::find($clientId);
        $entityType = 'cliente';
        $pageTitle = __('Archivos asignados a') . ' ' . $entity->name;
        $query = TblFile::whereHas('fileRelations', function ($query) use ($clientId) {
            $query->where('client_id', $clientId);
        });
    } elseif ($groupId) {
        $entity = Groups::find($groupId);
        $entityType = 'grupo';
        $pageTitle = __('Archivos asignados al grupo') . ' ' . $entity->name;
        $query = TblFile::whereHas('fileRelations', function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        });
    } elseif ($categoryId) {
        $entity = TblCategory::find($categoryId);
        $entityType = 'categoría';
        $pageTitle = __('Archivos de la categoría') . ' ' . $entity->name;
        $query = TblFile::whereHas('categoryRelations', function ($query) use ($categoryId) {
            $query->where('cat_id', $categoryId);
        });

    }

    if ($entity) {
        $files = $query->paginate(10);
        $filteredTotal = $files->total();

        foreach ($files as $file) {
            // Asignar el nombre del archivo almacenado a partir de la columna 'url'
            $file->stored_filename = $file->url;

            // Ruta del archivo en la carpeta de almacenamiento privado
            $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
            $publicFilePath = storage_path('app/public/uploads/' . $file->stored_filename);

            // Convertir las rutas a formatos absolutos
            $realPrivatePath = realpath($privateFilePath);
            $realPublicPath = realpath($publicFilePath);

            // Verificar primero en privado, luego en público
            if ($realPrivatePath && file_exists($realPrivatePath)) {

                // Obtener y formatear tamaño
                $file->size = $this->getFormattedFileSize($realPrivatePath);
            } elseif ($realPublicPath && file_exists($realPublicPath)) {

                // Obtener y formatear tamaño
                $file->size = $this->getFormattedFileSize($realPublicPath);
            } else {
                $file->size = '--';
            }
        }

        return view('files.file_manager', compact('pageTitle', 'entity', 'entityType', 'files', 'uploaders', 'totalFiles', 'filteredTotal'));
    } else {
        $error = __('El ' . $entityType . ' no existe');
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

    foreach ($files as $file) {
        // Asignar el nombre del archivo almacenado a partir de la columna 'url'
        $file->stored_filename = $file->url;

        // Ruta del archivo en la carpeta de almacenamiento privado
        $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
        $publicFilePath = storage_path('app/public/uploads/' . $file->stored_filename);

        // Convertir las rutas a formatos absolutos
        $realPrivatePath = realpath($privateFilePath);
        $realPublicPath = realpath($publicFilePath);

        // Verificar primero en privado, luego en público
        if ($realPrivatePath && file_exists($realPrivatePath)) {

            // Obtener y formatear tamaño
            $file->size = $this->getFormattedFileSize($realPrivatePath);
        } elseif ($realPublicPath && file_exists($realPublicPath)) {

            // Obtener y formatear tamaño
            $file->size = $this->getFormattedFileSize($realPublicPath);
        } else {
            $file->size = '--';
        }
    }

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

    // Descargar cada archivo seleccionado individualmente
    foreach ($files as $file) {
        $filePath = storage_path('app/' . $file->url);
        if (file_exists($filePath)) {
            return response()->download($filePath, $file->filename);
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el archivo ' . $file->filename . '.');
        }
    }
}



    public function bulkAction(Request $request)
{
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
            $files = TblFile::whereIn('id', $fileIds)->get();
 
            foreach ($files as $file) {
                $filePath = storage_path('app/private/uploads/' . $file->url);
 
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            TblFileRelation::whereIn('file_id', $fileIds)->delete();
            TblCategoryRelation::whereIn('file_id', $fileIds)->delete();
            TblFile::whereIn('id', $fileIds)->delete();
            return redirect()->back()->with('success', 'Archivos eliminados correctamente.');
        case 'zip':
            // Llamada al método de descarga comprimida, asegurándose de que el parámetro sea el correcto
            $request->merge(['file_ids' => $fileIds]); // Añadir file_ids al request
            return $this->downloadCompresed($request);
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

     public function editBasic($fileId)
    {
         $file = TblFile::findOrFail($fileId);

        // Generar token público si no existe
        if (!$file->public_token) {
            $file->public_token = Str::random(32);
            $file->save();
        }

        $selectedGroups = TblFileRelation::where('file_id', $fileId)
            ->whereNotNull('group_id')
            ->pluck('group_id')
            ->toArray();

          return view('files.edit-file', compact(    'file','selectedGroups','fileId'));
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

    // Determinar desde qué vista se envió el formulario
    $viewType = $request->input('viewType'); // Puede ser 'edit' o 'editBasic'

    if ($viewType === 'edit') {
        return redirect()->route('files.edit', $id)->with('success', 'El archivo se ha actualizado correctamente.');
    } elseif ($viewType === 'editBasic') {
        $selectedGroups = TblFileRelation::where('file_id', $file->id)
            ->whereNotNull('group_id')
            ->pluck('group_id')
            ->toArray();

            return view('files.edit-file', [
                'file' => $file,
                'selectedGroups' => $selectedGroups,
                'fileId' => $id,
                'success' => 'El archivo se ha actualizado correctamente.',
            ]);

        }

    // Actualizar asignaciones
    TblFileRelation::where('file_id', $file->id)->delete();

    if ($request->has('assignments')) {
        foreach ($request->input('assignments') as $assignment) {
            if (Str::startsWith($assignment, 'user_')) {
                $userId = Str::after($assignment, 'user_');
                TblFileRelation::create([
                    'file_id' => $file->id,
                    'client_id' => $userId,
                    'timestamp' => now(),
                    'hidden' => 0,
                ]);
            } elseif (Str::startsWith($assignment, 'group_')) {
                $groupId = Str::after($assignment, 'group_');
                TblFileRelation::create([
                    'file_id' => $file->id,
                    'group_id' => $groupId,
                    'timestamp' => now(),
                    'hidden' => 0,
                ]);
            }
        }
    }

    // Actualizar categorías
    TblCategoryRelation::where('file_id', $file->id)->delete();

    if ($request->has('categories')) {
        foreach ($request->input('categories') as $categoryId) {
            TblCategoryRelation::create([
                'file_id' => $file->id,
                'cat_id' => $categoryId,
            ]);
        }
    }
    
    
    return redirect()->route('files.edit', parameters: $file->id)->with('success', 'El archivo se ha actualizado correctamente.');
}


    public function resetUploadSession()
    {

        $uploadSessionId = session('upload_session_id');
        if ($uploadSessionId) {

            session()->forget("uploaded_files_$uploadSessionId");
            session()->forget('upload_session_id');
        }
    }


    public function uploadView(Request $request)
    {

        $this->resetUploadSession();

        return view('files.upload');
    }


public function uploadProcess(Request $request)
{
    try {
        $request->validate([
            'file' => 'required|file|max:20480',
            'name' => 'required|string',
            'chunk' => 'nullable|integer',
            'chunks' => 'nullable|integer',
        ]);

        $tempDir = storage_path('app/private/uploads/tmp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $file = $request->file('file');
        $chunk = $request->input('chunk', 0);
        $chunks = $request->input('chunks', 1);
        $fileName = $request->input('name');

        // Ruta del archivo PART único
        $partFilePath = $tempDir . DIRECTORY_SEPARATOR . $fileName . '.part';

        // Abrir el archivo PART en modo de escritura binaria (append)
        $out = fopen($partFilePath, $chunk == 0 ? 'wb' : 'ab');

        // Leer el contenido del fragmento y escribirlo en el archivo PART
        $in = fopen($file->getPathname(), 'rb');
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        fclose($in);
        fclose($out);

        // Si es el último fragmento, renombrar el archivo PART al nombre final
        if ($chunk == $chunks - 1) {
            $finalFilePath = $tempDir . DIRECTORY_SEPARATOR . $fileName;
            rename($partFilePath, $finalFilePath);

            // Guardar el archivo en la sesión
            $uploadSessionId = session('upload_session_id', Str::uuid()->toString());
            session(['upload_session_id' => $uploadSessionId]);

            $uploadedFiles = session("uploaded_files_$uploadSessionId", []);
            $uploadedFiles[] = $fileName;
            session(["uploaded_files_$uploadSessionId" => $uploadedFiles]);

            return response()->json([
                'success' => true,
                'redirect' => route('files.upload_process.view')
            ], 200);
        }

        return response()->json(['success' => true], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function store(Request $request)
{
    try {
        $rules = [
            'file' => 'required|array',
            'file.*.file' => 'required|string',
            'file.*.name' => 'required|string',
            'file.*.description' => 'nullable|string',
        ];

        if (Auth::user()->level != 0) {
            $rules = array_merge($rules, [
                'file.*.categories' => 'required|array',
                'file.*.assignments' => 'required|array',
                'file.*.expiry_date' => 'nullable|date',
                'file.*.public' => 'nullable|boolean',
                'file.*.hidden' => 'nullable|boolean',
            ]);
        }

        $data = $request->validate($rules);

        $tempDir = storage_path('app/private/uploads/tmp');
        $finalDir = storage_path('app/private/uploads');
        $savedFiles = [];

        if (!file_exists($finalDir)) {
            mkdir($finalDir, 0777, true);
        }

        foreach ($data['file'] as $key => $fileData) {
            $fileData['public'] = isset($fileData['public']) ? (int) $fileData['public'] : 0;
            $fileData['hidden'] = isset($fileData['hidden']) ? (int) $fileData['hidden'] : 0;

            // Verificar si el cliente tiene el rol 0 y ajustar la fecha de expiración
            if (Auth::user()->level == 0) {
                $fileData['expiry_date'] = Carbon::now()->addYear();
            }

            $tempFilePath = $tempDir . DIRECTORY_SEPARATOR . $fileData['file'];

            if (!file_exists($tempFilePath)) {
                continue;
            }

            $fileExtension = pathinfo($fileData['file'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '-' . sha1(uniqid() . microtime()) . ($fileExtension ? '.' . $fileExtension : '');
            $finalFilePath = $finalDir . DIRECTORY_SEPARATOR . $uniqueFileName;

            if (!rename($tempFilePath, $finalFilePath)) {
                throw new \Exception('Error al mover el archivo a su ubicación final: ' . $finalFilePath);
            }

            $fileDataForDatabase = [
                'filename' => $fileData['name'],
                'url' => $uniqueFileName,
                'original_url' => preg_replace('/^\d+_/', '', $fileData['file']),
                'description' => $fileData['description'] ?? 'Sin descripción',
                'uploader' => Auth::user()->name ?? 'anónimo',
                'expires' => isset($fileData['expiry_date']) ? 1 : 0,
                'expiry_date' => $fileData['expiry_date'] ?? null,
                'public_allow' => $fileData['public'],
                'hidden' => $fileData['hidden'],
                'public_token' => $fileData['public'] ? bin2hex(random_bytes(16)) : null,
            ];

            $file = TblFile::create($fileDataForDatabase);

            if (Auth::user()->level == 0) {
                // Asignar automáticamente el archivo al usuario autenticado si su nivel es 0
                TblFileRelation::create([
                    'file_id' => $file->id,
                    'client_id' => Auth::user()->id,
                    'timestamp' => now(),
                    'hidden' => $fileData['hidden'] ?? 0,
                ]);
            }

            if (Auth::user()->level != 0) {
                foreach ($fileData['assignments'] as $assignment) {
                    if (Str::startsWith($assignment, 'user_')) {
                        $userId = Str::after($assignment, 'user_');
                        TblFileRelation::create([
                            'file_id' => $file->id,
                            'client_id' => $userId,
                            'timestamp' => now(),
                            'hidden' => $fileData['hidden'] ?? 0,
                        ]);
                    } elseif (Str::startsWith($assignment, 'group_')) {
                        $groupId = Str::after($assignment, 'group_');
                        TblFileRelation::create([
                            'file_id' => $file->id,
                            'group_id' => $groupId,
                            'timestamp' => now(),
                            'hidden' => $fileData['hidden'] ?? 0,
                        ]);
                    }
                }

                foreach ($fileData['categories'] as $categoryId) {
                    TblCategoryRelation::create([
                        'file_id' => $file->id,
                        'cat_id' => $categoryId,
                        'timestamp' => now(),
                    ]);
                }
            }

            $assignmentsCount = TblFileRelation::where('file_id', $file->id)->count();
            $categoriesCount = TblCategoryRelation::where('file_id', $file->id)->count();

            $file->assignments_count = $assignmentsCount;
            $file->categories_count = $categoriesCount;

            $savedFiles[] = $file->loadCount(['fileRelations', 'categoryRelations']);
        }

        session(['savedFiles' => $savedFiles]);

        return redirect()->route('files.upload_process.view');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error al guardar los archivos: ' . $e->getMessage()]);
    }
}

   public function uploadProcessView(Request $request)
{
    try {
        $uploadSessionId = session('upload_session_id');
        $uploadedFiles = session("uploaded_files_$uploadSessionId", []);
        $files = collect();
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

        $savedFiles = collect(session('savedFiles', []));
        $archivedFiles = collect(session("archivedFiles_$uploadSessionId", []));

        if ($savedFiles->isNotEmpty()) {
            $recentlyArchived = $savedFiles->map(function ($file) {
                return [
                    'filename' => $file['filename'],
                    'description' => $file['description'] ?? 'Sin descripción',
                ];
            });

            $archivedFiles = $recentlyArchived;

            session(["archivedFiles_$uploadSessionId" => $archivedFiles]);

            session()->forget('savedFiles');
        }

        $users = User::all();
        $groups = Groups::all(); // Obtener todos los grupos-compañías
        $categories = TblCategory::all();

        return view('files.upload_process', compact('files', 'savedFiles', 'archivedFiles', 'users', 'groups', 'categories'));
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error al cargar los archivos para procesar.']);
    }
}



   public function myFiles(Request $request)
    {
        // Obtener parámetros opcionales de la query string
        $search = $request->query('search');
        $category = $request->query('categories', []);
        $sortColumn = $request->query('orderby', 'timestamp'); // Predeterminadamente 'timestamp'
        $sortDirection = $request->query('order', 'asc');

        // Validar que la columna a ordenar sea válida para evitar inyección SQL
        $allowedColumns = ['filename', 'description', 'timestamp'];
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 'timestamp';
        }
        // Definir título de la página
        $pageTitle = __('Administración del Sistema');

        // Obtener el ID del cliente autenticado
        $clientId = $request->query('cliente_id', Auth::user()->id);

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

        // Filtrar por categoría si está seleccionada
        if (!empty($selectedCategories)) {
            $filesQuery->whereHas('categoryRelations', function ($query) use ($selectedCategories) {
                $query->whereIn('cat_id', $selectedCategories);
            });
        }

        // Filtrar por búsqueda (título o descripción)
        if ($search) {
            $filesQuery->where(function ($query) use ($search) {
                $query->where('filename', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('timestamp', 'like', '%' . $search . '%');
            });
        }

        // Aplicar ordenación según los parámetros
        $filesQuery->orderBy($sortColumn, $sortDirection);

        // Obtener los archivos paginados
        $files = $filesQuery->get(); // Traemos todos los archivos sin paginar primero


        foreach ($files as $file) {
            // Asignar el nombre del archivo almacenado a partir de la columna 'url'
            $file->stored_filename = $file->url;

            // Ruta del archivo en la carpeta de almacenamiento privado
            $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
            $publicFilePath = storage_path('app/public/uploads/' . $file->stored_filename); // Ruta de archivos públicos

            // Convertir las rutas a formatos absolutos
            $realPrivatePath = realpath($privateFilePath);
            $realPublicPath = realpath($publicFilePath);

            // Verificar primero en privado, luego en público
            if ($realPrivatePath && file_exists($realPrivatePath)) {

                // Obtener y formatear tamaño
                $file->size = $this->getFormattedFileSize($realPrivatePath);
            } elseif ($realPublicPath && file_exists($realPublicPath)) {

                // Obtener y formatear tamaño
                $file->size = $this->getFormattedFileSize($realPublicPath);
            } else {
                $file->size = '--';
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

        // Obtener las categorías asociadas a los archivos visibles
        $categoryIds = TblCategoryRelation::whereIn('file_id', $files->pluck('id'))
            ->pluck('cat_id')
            ->unique();

        $categories = TblCategory::whereIn('id', $categoryIds)->get();

        if ($request->has('categories')) {
            $selectedCategories = $request->input('categories', []);
            // Verificar si se ha seleccionado "Categorias"
            if (!in_array('all', $selectedCategories)) {
                // Filtrar los archivos según las categorías seleccionadas
                $files = $files->filter(function ($file) use ($selectedCategories) {
                    return $file->categoryRelations->whereIn('cat_id', $selectedCategories)->isNotEmpty();
                });
            }
        }


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
        return view('files.my_files', compact('pageTitle', 'files', 'filteredTotal', 'categories'));
    }




    // codigto de la vista manage-files
   public function manageFiles(Request $request)
{
    // Obtener parámetros opcionales de la query string
    $search = $request->query('search');
    $category = $request->query('category', 0);
    $sorts = $request->query('sort', 'timestamp');
    $direction = $request->query('direction', 'asc');
    $orderby = $request->input('orderby', 'filename');
    $order = $request->input('order', 'asc');

    // Definir título de la página
    $pageTitle = __('Administración del Sistema');

    // Obtener el ID del cliente autenticado
    $clientId = Auth::id(); // Cambia esto según tu implementación de autenticación

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

    $filesQuery->orderBy($sorts, $direction);

    // Obtener el total de archivos antes de la paginación
    $filteredTotal = $filesQuery->count();

    // Obtener los archivos paginados
    $files = $filesQuery->paginate(10);

    foreach ($files as $file) {
        // Asignar el nombre del archivo almacenado a partir de la columna 'url'
        $file->stored_filename = $file->url;

        // Ruta del archivo en la carpeta de almacenamiento privado
        $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
        $publicFilePath = storage_path('app/public/uploads/' . $file->stored_filename); // Ruta de archivos públicos

        // Convertir las rutas a formatos absolutos
        $realPrivatePath = realpath($privateFilePath);
        $realPublicPath = realpath($publicFilePath);

        // Verificar primero en privado, luego en público
        if ($realPrivatePath && file_exists($realPrivatePath)) {
            // Obtener y formatear tamaño
            $file->size = $this->getFormattedFileSize($realPrivatePath);
        } elseif ($realPublicPath && file_exists($realPublicPath)) {
            // Obtener y formatear tamaño
            $file->size = $this->getFormattedFileSize($realPublicPath);
        } else {
            $file->size = '--';
        }
    }

    return view('files.manage-files', compact('pageTitle', 'files', 'filteredTotal'));
}

    private function getFormattedFileSize($filePath)
    {
        $fileSize = filesize($filePath);
        if ($fileSize === false) {
            return 'Error al obtener tamaño';
        }

        // Formatear tamaño (KB, MB, etc.)
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $unitIndex = 0;
        while ($fileSize >= 1024 && $unitIndex < count($units) - 1) {
            $fileSize /= 1024;
            $unitIndex++;
        }

        return round($fileSize, 2) . ' ' . $units[$unitIndex];
    }
  public function directDownload($id)
    {
        // Buscar el archivo por su ID
        $file = TblFile::find($id);
 
        if (!$file) {
            return back()->with(['error' => 'El archivo no existe.']);
        }
 
        // Verificar si el archivo es público
        if (!$file->public_allow) {
            return back()->with(['error' => 'Este archivo no está disponible para descarga pública.']);
        }
 
        $url = $file->url;
        if (empty($url)) {
            return back()->with(['error' => 'El archivo no tiene una URL asociada.']);
        }
 
        // Ruta del archivo en el almacenamiento privado
        $path = storage_path('app/private/uploads/' . $url);
 
        // Verificar si el archivo existe en la ruta
        if (!file_exists($path)) {
            return back()->with(['error' => 'El archivo no está disponible para descargar.'], 404);
        }
 
        // Obtener la extensión original del archivo
        $fileExtension = pathinfo($url, PATHINFO_EXTENSION);
 
        // Obtener el contenido del archivo
        $fileContent = file_get_contents($path);
 
        // Retornar la respuesta para la descarga
        return response()->make($fileContent, 200, [
            'Content-Type' => mime_content_type($path), // Obtener el tipo MIME del archivo
            'Content-Disposition' => 'attachment; filename="' . $file->filename . '.' . $fileExtension . '"', // Mantener la extensión original
            'Content-Length' => strlen($fileContent),
        ]);
    }

     public function downloadCompresed(Request $request)
    {
        $fileIds = $request->input('file_ids'); // Array de IDs de archivos seleccionados

        if (empty($fileIds)) {
            // Manejar el caso en que no se seleccionen archivos
            return back()->with(['error' => 'No se ha seleccionado ningún archivo.']);
        }

        // Obtener el primer archivo seleccionado para usar su nombre
        $firstFile = TblFile::find($fileIds[0]);
        if (count($fileIds) == 1) {
            $zipFileName = $firstFile ? $firstFile->filename . '.zip' : 'archivos_comprimidos.zip';
        } else {
            $zipFileName = 'archivos_' . substr($firstFile->filename, 0, 10) . '_y_mas.zip';
        }
        $zipFilePath = storage_path('app/private/uploads/' . $zipFileName);

        $zip = new ZipArchive();

        // Intentar crear el archivo ZIP
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with(['error' => 'No se pudo crear el archivo ZIP.']);
        }

        $missingFiles = []; // Array para almacenar los archivos faltantes

        foreach ($fileIds as $fileId) {
            $file = TblFile::find($fileId); // Buscar el archivo por su ID

            if ($file) {
                $filePath = storage_path('app/private/uploads/' . $file->url); // Ruta del archivo

                if (file_exists($filePath)) {
                    $relativeName = basename($filePath); // Nombre relativo del archivo
                    $zip->addFile($filePath, $relativeName); // Agregar el archivo al ZIP
                } else {
                    // Si el archivo no se encuentra, agregarlo al array de archivos faltantes
                    $missingFiles[] = $file->url;
                }
            }
        }

        $zip->close(); // Cerrar el archivo ZIP

        // Verificar si hubo archivos faltantes
        if (!empty($missingFiles)) {
            $missingCount = count($missingFiles);
            $message = $missingCount === 1
                ? 'El archivo ' . $missingFiles[0] . ' no existe.'
                : 'Algunos de los archivos no existen: ' . implode(', ', $missingFiles);

            return back()->with('error', $message);
        }

        // Verificar si el archivo ZIP existe antes de intentar descargarlo
        if (!file_exists($zipFilePath)) {
            return back()->with(['error' => 'El archivo ZIP no se pudo generar.']);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
    public function showDownloadView($id, $token)
    {
        // Buscar el archivo por ID
        $file = TblFile::find($id);
 
        if (!$file || $file->public_token !== $token) {
            return back()->with(['error' => 'El enlace de descarga es inválido o ha expirado.']);
        }
 
        // Verificar si el archivo es público
        if ($file->public_allow == 0) {
            return view('files.download', [
                'file' => $file,
                'error' => 'No tienes permisos para acceder a este archivo.'
            ]);
        }
 
        // Si el archivo es público, muestra la vista de descarga normal
        return view('files.download', compact('file'));
    }
}
