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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Members;
use App\Models\TblDownload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Mail\NewFiles;
use Illuminate\Support\Facades\Mail;


class FilesController extends Controller
{
    public function index(Request $request)
{
    // Obtener parámetros desde la query string
    $clientId = $request->query('client_id');
    $groupId = $request->query('group_id');
    $categoryId = $request->query('category_id');
    $search = $request->get('search');
    $uploaderFilter = $request->get('uploader');
    $sort = $request->get('sort', 'timestamp'); // Orden por defecto: timestamp
    $direction = $request->get('direction', 'desc'); // Dirección por defecto: descendente

    // Obtener lista de uploaders distintos y total de archivos
    $uploaders = TblFile::select('uploader')->distinct()->pluck('uploader');
    $totalFiles = TblFile::count();

    // Inicializar consulta
    $query = TblFile::query();

    // Filtrar por cliente, grupo o categoría
    if ($clientId || $groupId || $categoryId) {
        $entity = null; // Inicializar variable

        if ($clientId) {
            $entity = User::find($clientId);
            $entityType = 'cliente';
            $pageTitle = __('Archivos asignados a') . ' ' . ($entity->name ?? '');
            $query->whereHas('fileRelations', fn($q) => $q->where('client_id', $clientId));
        } elseif ($groupId) {
            $entity = Groups::find($groupId);
            $entityType = 'grupo';
            $pageTitle = __('Archivos asignados al grupo') . ' ' . ($entity->name ?? '');
            $query->whereHas('fileRelations', fn($q) => $q->where('group_id', $groupId));
        } elseif ($categoryId) {
            $entity = TblCategory::find($categoryId);
            $entityType = 'categoría';
            $pageTitle = __('Archivos de la categoría') . ' ' . ($entity->name ?? '');
            $query->whereHas('categoryRelations', fn($q) => $q->where('cat_id', $categoryId));
        }

        if (!$entity) {
            return view('files.file_manager', [
                'error'      => __('El ' . $entityType . ' no existe'),
                'uploaders'  => $uploaders,
                'totalFiles' => $totalFiles
            ]);
        }

        // Obtener archivos paginados
        $files = $query->paginate(10)->appends($request->except('page'));

        // Definir $filteredTotal usando el total de registros del paginador
        $filteredTotal = $files->total();

        // Asignar tamaño de archivo (según tu método)
        $this->assignFileSizes($files);

        return view('files.file_manager', compact(
            'pageTitle',
            'entity',
            'entityType',
            'files',
            'uploaders',
            'totalFiles',
            'filteredTotal'
        ));
    }

    // Si no hay filtros de cliente, grupo o categoría, obtener todos los archivos
    $query->with(['fileRelations', 'downloads']);

    // Aplicar filtros adicionales
    if ($search) {
        $query->where('filename', 'LIKE', "%$search%");
    }

    if ($uploaderFilter) {
        $query->where('uploader', $uploaderFilter);
    }

    // Aplicar ordenación
    if ($sort === 'download_count') {
        $query->withCount('downloads as download_count')->orderBy('download_count', $direction);
    } else {
        $query->orderBy($sort, $direction);
    }

    // Obtener el total de archivos filtrados
    $filteredTotal = $query->count();

    // Paginación de archivos
    $files = $query->paginate(10)->appends($request->except('page'));

    // Asignar tamaño de archivos
    $this->assignFileSizes($files);

    return view('files.file_manager', compact(
        'files',
        'uploaders',
        'totalFiles',
        'filteredTotal',
        'sort',
        'direction'
    ));
}


/**
 * Asigna el tamaño y nombre de los archivos en la colección dada.
 */
private function assignFileSizes($files)
{
    foreach ($files as $file) {
        $file->stored_filename = $file->url;

        $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
        $publicFilePath = storage_path('app/public/uploads/' . $file->stored_filename);

        $realPrivatePath = realpath($privateFilePath);
        $realPublicPath = realpath($publicFilePath);

        if ($realPrivatePath && file_exists($realPrivatePath)) {
            $file->size = $this->getFormattedFileSize($realPrivatePath);
        } elseif ($realPublicPath && file_exists($realPublicPath)) {
            $file->size = $this->getFormattedFileSize($realPublicPath);
        } else {
            $file->size = '--';
        }
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



    public function editBasic($fileId)
    {
        $user = Auth::user();

        $file = TblFile::findOrFail($fileId);


        if ($file->uploader !== $user->user) {
            return redirect()->route('manage-files')->with('error', 'No tienes permiso para editar este archivo.');
        }

        // Generar token público si no existe
        if (!$file->public_token) {
            $file->public_token = Str::random(32);
            $file->save();
        }

        $selectedGroups = TblFileRelation::where('file_id', $fileId)
            ->whereNotNull('group_id')
            ->pluck('group_id')
            ->toArray();

        return view('files.edit-file', compact('file', 'selectedGroups', 'fileId'));
    }

    public function update(Request $request, $id)
    {
        $file = TblFile::findOrFail($id);

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all(['filename', 'description', 'expires', 'public_allow', 'expiry_date']));
        }

        // **MODIFICACIÓN CRUCIAL:  Solo procesar 'expires' y 'expiry_date' SI se envían en la solicitud**
        if ($request->has('expires')) {
            if ($request->boolean('expires')) {
                $expiryDate = $request->input('expiry_date');

                if (empty($expiryDate)) {
                    return redirect()->back()->withErrors(['expiry_date' => 'La fecha de expiración es requerida.'])->withInput($request->all());
                }

                $expiryDate = Carbon::parse($expiryDate);
                $maxExpiryDate = $file->timestamp->copy()->addYear(); // Un año desde la creación

                if ($expiryDate->greaterThan($maxExpiryDate)) {
                    return redirect()->back()->withErrors(['expiry_date' => 'La fecha de expiración no puede ser mayor a un año desde la fecha de creación.'])->withInput($request->all());
                }

                if ($expiryDate->lessThan($file->timestamp)) {
                    return redirect()->back()->withErrors(['expiry_date' => 'La fecha de expiración no puede ser anterior a la fecha de creación del archivo.'])->withInput($request->all());
                }

                $file->expiry_date = $expiryDate;
                $file->expires = true; // Si expiry date se establece, expires debe ser true
            } else {
                $file->expiry_date = null;
                $file->expires = false; // Si expires se desactiva, debe ser false
            }
        } // **FIN de la MODIFICACIÓN CRUCIAL:  Ya no hay bloque 'else' incondicional para 'expires'**


        $file->filename = $request->input('filename');
        $file->description = $request->input('description') ?? '';
        // **Ya NO establecemos $file->expires ni $file->expiry_date aquí de forma incondicional**
        $file->public_allow = $request->boolean('public_allow');
        $file->save();

        // Determinar desde qué vista se envió el formulario
        $viewType = $request->input('viewType');

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
            $hideAll = $request->input('file.1.hideall', 0);
            foreach ($request->input('assignments') as $assignment) {
                if (Str::startsWith($assignment, 'user_')) {
                    $userId = Str::after($assignment, 'user_');
                    TblFileRelation::create([
                        'file_id' => $file->id,
                        'client_id' => $userId,
                        'timestamp' => now(),
                        'hidden' => $hideAll,
                    ]);
                } elseif (Str::startsWith($assignment, 'group_')) {
                    $groupId = Str::after($assignment, 'group_');
                    TblFileRelation::create([
                        'file_id' => $file->id,
                        'group_id' => $groupId,
                        'timestamp' => now(),
                        'hidden' => $hideAll,
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

        return redirect()->route('files.edit', $file->id)->with('success', 'El archivo se ha actualizado correctamente.');
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
            $user = Auth::user();
            $maxSize = $user->max_file_size > 0 ? $user->max_file_size * 1024 * 1024 : 2048 * 1024 * 1024; // Convertir MB a Bytes

            $request->validate([
                'file' => "required|file|max:$maxSize",
                'name' => 'required|string',
                'chunk' => 'nullable|integer',
                'chunks' => 'nullable|integer',
            ], [
                'file.max' => 'El archivo supera el tamaño máximo permitido de ' . ($user->max_file_size ?: 2048) . ' MB.'
            ]);

            $tempDir = storage_path('app/private/uploads/tmp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $file = $request->file('file');
            $chunk = $request->input('chunk', 0);
            $chunks = $request->input('chunks', 1);
            $fileName = $request->input('name');

            $partFilePath = $tempDir . DIRECTORY_SEPARATOR . $fileName . '.part';

            $out = fopen($partFilePath, $chunk == 0 ? 'wb' : 'ab');
            $in = fopen($file->getPathname(), 'rb');
            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }
            fclose($in);
            fclose($out);

            if ($chunk == $chunks - 1) {
                $finalFilePath = $tempDir . DIRECTORY_SEPARATOR . $fileName;
                rename($partFilePath, $finalFilePath);

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
        $clientsToNotify = [];

        if (!file_exists($finalDir)) {
            mkdir($finalDir, 0777, true);
        }

        foreach ($data['file'] as $fileData) {
            $fileData['public'] = isset($fileData['public']) ? (int) $fileData['public'] : 0;
            $fileData['hidden'] = isset($fileData['hidden']) ? (int) $fileData['hidden'] : 0;

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

            $file = TblFile::create([
                'filename' => $fileData['name'],
                'url' => $uniqueFileName,
                'original_url' => preg_replace('/^\d+_/', '', $fileData['file']),
                'description' => $fileData['description'] ?? 'Sin descripción',
                'uploader' => Auth::user()->user ?? 'anónimo',
                'expires' => isset($fileData['expiry_date']) ? 1 : 0,
                'expiry_date' => $fileData['expiry_date'] ?? null,
                'public_allow' => $fileData['public'],
                'hidden' => $fileData['hidden'],
                'public_token' => $fileData['public'] ? bin2hex(random_bytes(16)) : null,
            ]);

            $assignedClients = [];

            if (Auth::user()->level == 0) {
                TblFileRelation::create([
                    'file_id' => $file->id,
                    'client_id' => Auth::user()->id,
                    'timestamp' => now(),
                    'hidden' => $fileData['hidden'] ?? 0,
                ]);

                $assignedClients[] = Auth::user();
            }

            if (Auth::user()->level != 0) {
                foreach ($fileData['assignments'] as $assignment) {
                    if (Str::startsWith($assignment, 'user_')) {
                        $userId = Str::after($assignment, 'user_');
                        $user = User::find($userId);

                        if ($user && $user->level == 0) {
                            $assignedClients[] = $user;
                        }

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

            foreach ($assignedClients as $client) {
                Log::info('Verificando notificación', [
                    'usuario' => $client->email,
                    'notificaciones' => $client->notify,
                    'archivo' => $file->filename,
                    'oculto' => $fileData['hidden']
                ]);

                if ($client->notify == 1 && $fileData['hidden'] == 0) {
                    $clientsToNotify[$client->id]['user'] = $client;
                    $clientsToNotify[$client->id]['files'][] = $file->filename;
                }
            }

            $savedFiles[] = $file->loadCount(['fileRelations', 'categoryRelations']);
        }

        foreach ($clientsToNotify as $clientData) {
            Mail::to($clientData['user']->email)->send(new NewFiles($clientData['user'], $clientData['files']));
        }

        session(['savedFiles' => $savedFiles]);
        sleep(1); // Esperar un segundo para asegurar que los archivos se guarden correctamente
        return redirect()->route('files.upload_process.view');
    } catch (\Exception $e) {
        Log::error('Error al guardar los archivos', ['error' => $e->getMessage()]);
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

    public function clearTemporaryFiles(Request $request)
    {
        try {
            // Verificar si hay sesión de carga activa
            $uploadSessionId = session('upload_session_id');
            if (!$uploadSessionId) {
                return response()->json(['message' => 'No hay sesión de carga activa.'], 200);
            }

            // Obtener archivos temporales guardados en sesión
            $uploadedFiles = session("uploaded_files_$uploadSessionId", []);
            $tempDir = storage_path('app/private/uploads/tmp');

            foreach ($uploadedFiles as $filename) {
                $filePath = $tempDir . DIRECTORY_SEPARATOR . $filename;
                if (file_exists($filePath)) {
                    unlink($filePath); // Eliminar archivo
                }

                // Eliminar archivos .part asociados
                $partFiles = glob($tempDir . DIRECTORY_SEPARATOR . $filename . '.*.part');
                foreach ($partFiles as $partFile) {
                    if (file_exists($partFile)) {
                        unlink($partFile); // Eliminar archivo .part
                    }
                }
            }

            // Eliminar archivos .part huérfanos (sin un archivo principal)
            $orphanPartFiles = glob($tempDir . DIRECTORY_SEPARATOR . '*.part');
            foreach ($orphanPartFiles as $orphanPartFile) {
                if (file_exists($orphanPartFile)) {
                    unlink($orphanPartFile); // Eliminar archivo .part huérfano
                }
            }

            // Limpiar la sesión
            session()->forget("uploaded_files_$uploadSessionId");
            session()->forget('upload_session_id');

            return response()->json(['message' => 'Archivos temporales eliminados correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al limpiar archivos temporales: ' . $e->getMessage()], 500);
        }
    }

    public function myFiles(Request $request)
{
    // Obtener parámetros opcionales de la query string
    $search = $request->query('search');
    $selectedCategories = $request->query('categories', []); // Usamos $selectedCategories
    $sortColumn = $request->query('orderby', 'timestamp'); // Predeterminadamente 'timestamp'
    $sortDirection = $request->query('order', 'asc');

    // Validar que la columna a ordenar sea válida para evitar inyección SQL
    $allowedColumns = ['filename', 'description', 'timestamp'];
    if (!in_array($sortColumn, $allowedColumns)) {
        $sortColumn = 'timestamp';
    }

    // Definir título de la página
    $pageTitle = __('Administración del Sistema');

    // Obtener el ID del cliente (si no se pasa, se usa el del usuario autenticado)
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
            $query->select('tbl_groups.id', 'tbl_groups.description'); // Evitar ambigüedad
        },
        'fileRelations' // Necesario para filtrar los que están ocultos
    ]);

    // Filtrar por categoría si se han seleccionado
    if (!empty($selectedCategories)) {
        $filesQuery->whereHas('categoryRelations', function ($query) use ($selectedCategories) {
            $query->whereIn('cat_id', $selectedCategories);
        });
    }

    // Filtrar por búsqueda (por filename, description o timestamp)
    if ($search) {
        $filesQuery->where(function ($query) use ($search) {
            $query->where('filename', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('timestamp', 'like', '%' . $search . '%');
        });
    }

    // Excluir archivos ocultos: si alguna relación tiene hidden = 1, se descarta el archivo
    $filesQuery->whereDoesntHave('fileRelations', function ($q) {
        $q->where('hidden', 1);
    });

    // Aplicar ordenación
    $filesQuery->orderBy($sortColumn, $sortDirection);

    // Obtener los archivos (sin paginar aún)
    $files = $filesQuery->get();

    // Asignar propiedades adicionales a cada archivo
    foreach ($files as $file) {
        // Usar el valor de 'url' como nombre almacenado
        $file->stored_filename = $file->url;

        // Rutas de almacenamiento (privado y público)
        $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
        $publicFilePath  = storage_path('app/public/uploads/' . $file->stored_filename);

        // Obtener las rutas reales
        $realPrivatePath = realpath($privateFilePath);
        $realPublicPath  = realpath($publicFilePath);

        // Asignar tamaño del archivo
        if ($realPrivatePath && file_exists($realPrivatePath)) {
            $file->size = $this->getFormattedFileSize($realPrivatePath);
        } elseif ($realPublicPath && file_exists($realPublicPath)) {
            $file->size = $this->getFormattedFileSize($realPublicPath);
        } else {
            $file->size = '--';
        }

        // Procesar la fecha de expiración
        if ($file->expires && $file->expiry_date) {
            $expiryDate = \Carbon\Carbon::parse($file->expiry_date);
            $file->isExpired = $expiryDate->isPast();
            $file->formattedExpiryDate = $expiryDate->format('Y/m/d');
        } else {
            $file->isExpired = false;
            $file->formattedExpiryDate = null;
        }
    }

    // Filtrar los archivos: mostrar siempre los archivos propios y, para los demás, sólo los que no han expirado
    $files = $files->filter(function ($file) use ($clientId) {
        if ($file->fileRelations->contains('client_id', $clientId)) {
            return true;
        }
        return !$file->isExpired;
    });

    // Obtener las categorías asociadas a los archivos visibles
    $categoryIds = TblCategoryRelation::whereIn('file_id', $files->pluck('id'))
        ->pluck('cat_id')
        ->unique();
    $categories = TblCategory::whereIn('id', $categoryIds)->get();

    // Si se han enviado categorías en el request, filtrar los archivos según las seleccionadas
    if ($request->has('categories')) {
        if (!in_array('all', $selectedCategories)) {
            $files = $files->filter(function ($file) use ($selectedCategories) {
                return $file->categoryRelations->whereIn('cat_id', $selectedCategories)->isNotEmpty();
            });
        }
    }

    // Total de archivos después de aplicar los filtros
    $filteredTotal = $files->count();

    // Paginación manual de los resultados
    $files = new \Illuminate\Pagination\LengthAwarePaginator(
        $files->forPage($request->get('page', 1), 10), // Archivos de la página actual
        $filteredTotal,
        10,
        $request->get('page', 1),
        ['path' => $request->url(), 'query' => $request->query()]
    );

    // Renderizar la vista con los datos necesarios
    return view('files.my_files', compact('pageTitle', 'files', 'filteredTotal', 'categories'));
}





    // codigto de la vista manage-files
    public function manageFiles(Request $request)
{
    // Obtener parámetros opcionales de la query string
    $search    = $request->query('search');
    $category  = $request->query('category', 0);
    $sorts     = $request->query('sort', 'timestamp');
    $direction = $request->query('direction', 'asc');
    $orderby   = $request->input('orderby', 'filename');
    $order     = $request->input('order', 'asc');

    // Definir título de la página
    $pageTitle = __('Administración del Sistema');

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Construir la consulta para los archivos subidos por el usuario autenticado
    $filesQuery = TblFile::where('uploader', $user->user); // Filtrar por 'uploader' = nombre del usuario

    // Filtrar por búsqueda (título, descripción o timestamp)
    if ($search) {
        $filesQuery->where(function ($query) use ($search) {
            $query->where('filename', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('timestamp', 'like', '%' . $search . '%');
        });
    }

    // Filtrar por categoría (si se pasa un valor distinto de 0)
    if ($category && $category != 0) {
        $filesQuery->whereHas('categoryRelations', function($query) use ($category) {
            $query->where('cat_id', $category);
        });
    }

    // Excluir archivos ocultos (aquellos que tengan hidden = 1 en alguna relación)
    $filesQuery->whereDoesntHave('fileRelations', function ($q) {
        $q->where('hidden', 1);
    });

    // Ordenar los archivos
    $filesQuery->orderBy($sorts, $direction);

    // Obtener el total de archivos después de aplicar los filtros, antes de la paginación
    $filteredTotal = $filesQuery->count();

    // Obtener los archivos paginados
    $files = $filesQuery->paginate(10);

    // Procesar cada archivo para asignarle el tamaño formateado
    foreach ($files as $file) {
        // Asignar el nombre almacenado a partir de la columna 'url'
        $file->stored_filename = $file->url;

        // Rutas de almacenamiento (privado y público)
        $privateFilePath = storage_path('app/private/uploads/' . $file->stored_filename);
        $publicFilePath  = storage_path('app/public/uploads/' . $file->stored_filename);

        // Convertir las rutas a formatos absolutos
        $realPrivatePath = realpath($privateFilePath);
        $realPublicPath  = realpath($publicFilePath);

        // Verificar primero en privado, luego en público
        if ($realPrivatePath && file_exists($realPrivatePath)) {
            $file->size = $this->getFormattedFileSize($realPrivatePath);
        } elseif ($realPublicPath && file_exists($realPublicPath)) {
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
        $file = TblFile::find($id);

        if (!$file) {
            return back()->with(['error' => 'El archivo no existe.']);
        }

        $url = $file->url;
        if (empty($url)) {
            return back()->with(['error' => 'El archivo no tiene una URL asociada.']);
        }

        $path = storage_path('app/private/uploads/' . $url);

        if (!file_exists($path)) {
            return back()->with(['error' => 'El archivo no está disponible para descargar.']);
        }

        // Verifica si el archivo ha expirado usando el campo expiry_date
        if ($file->expiry_date && $file->expiry_date < now()) {
            return back()->with(['error' => 'El archivo ha expirado y ya no está disponible para descarga.']);
        }


        $download = new TblDownload();
        $download->file_id = $id;

        // Check if the user is authenticated. If not, set anonymous to 1.
        if (Auth::check()) {
            $download->user_id = Auth::id();
            $download->anonymous = 0; // Explicitly set to 0 for logged-in users
        } else {
            $download->user_id = null; // Or perhaps a specific guest user ID if you have one
            $download->anonymous = 1;
        }

        $download->remote_ip = request()->ip();
        $download->timestamp = now();
        $download->save();

        $fileExtension = pathinfo($url, PATHINFO_EXTENSION);
        $fileName = $file->filename . '.' . $fileExtension;

        return response()->streamDownload(function () use ($path) {
            $stream = fopen($path, 'rb');
            while ($chunk = fread($stream, 4096)) {
                echo $chunk;
                flush();
            }
            fclose($stream);
        }, $fileName, [
            'Content-Type' => mime_content_type($path),
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

        // Verificar si el archivo existe y el token es válido
        if (!$file || $file->public_token !== $token) {
            return view('files.download', ['error' => 'El enlace de descarga es inválido o ha expirado.']);
        }

        // Verificar si el archivo es público
        if ($file->public_allow == 0) {
            return view('files.download', ['error' => 'No tienes permisos para acceder a este archivo.']);
        }

        // Verificar si el archivo ha expirado
        if ($file->expiry_date !== null && $file->expiry_date < now()) {
            return view('files.download', ['error' => 'El archivo ha expirado y ya no está disponible para descarga.']);
        }

        // Si el archivo es público, no ha expirado y el usuario tiene permisos, mostrar la vista de descarga
        return view('files.download', compact('file'));
    }
}
