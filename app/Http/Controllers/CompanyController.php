<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Groups; 
use App\Models\User;
use App\Models\TblFile;
use App\Models\TblFileRelation;
use App\Models\TblCategory;
use App\Models\TblCategoryRelation;





class CompanyController extends Controller
{
    // Método para mostrar el formulario de agregar compañía
    public function create()
    {
        // Obtener todos los integrantes de la tabla tbl_members con la información del cliente
        $members = Members::with('client')->get();
        
        // Retornar la vista con los integrantes
        return view('companies.add_company', compact('members'));
    }
   

    public function store(Request $request)
    {
        Log::info('Solicitud recibida', $request->all());
    
        // Convertir el checkbox a un valor booleano
        $request->merge([
            'add_group_form_public' => $request->has('add_group_form_public')
        ]);
    
        // Verificar si el nombre ya existe en la base de datos
        $nombreExistente = DB::table('tbl_groups')->where('name', $request->input('add_group_form_name'))->exists();
    
        if ($nombreExistente) {
            Log::info('El nombre ya existe en la base de datos: ' . $request->input('add_group_form_name'));
            return redirect()->back()
                ->withErrors(['add_group_form_name' => '¡El nombre ya existe en la base de datos!'])
                ->withInput();
        }
    
        // Validar los datos del formulario
        $request->validate([
            'add_group_form_name' => 'required|string|max:255',
            'add_group_form_description' => 'nullable|string',
            'add_group_form_public' => 'nullable|boolean',
            'add_group_form_members' => 'nullable|array',
        ]);
    
        $userId = auth()->id();
    
        // Asignar un valor por defecto a la descripción si está vacía
        $description = $request->input('add_group_form_description');
        if (empty($description)) {
            $description = ''; // Valor predeterminado como cadena vacía
        }
    
        // Crear el grupo
        $group = new \App\Models\Groups();
        $group->created_by = $userId;
        $group->name = $request->input('add_group_form_name');
        $group->description = $description; // Asignar la descripción
        $group->public = $request->input('add_group_form_public', false);
        $group->public_token = substr(Str::uuid()->toString(), 0, 32);
    
    
        if ($group->public) {
            $group->public_token = substr(Str::uuid()->toString(), 0, 32); // Truncar a 32 caracteres
        }
        
    
        Log::info('Datos del grupo antes de guardar', $group->toArray());
    
        // Guardar el grupo en la base de datos
        $group->save();
    
        Log::info('Grupo guardado exitosamente con ID: ' . $group->id);
    
         // **Aquí agregamos el Log para verificar los miembros seleccionados**
    if ($request->has('add_group_form_members')) {
        Log::info('Miembros seleccionados antes de procesar:', $request->input('add_group_form_members'));

        $memberIds = array_unique($request->input('add_group_form_members'));

        // Eliminar todos los miembros asociados a este grupo antes de agregar los nuevos
        Members::where('group_id', $group->id)->delete();

        foreach ($memberIds as $memberId) {
            Members::create([
                'group_id' => $group->id,
                'client_id' => $memberId,
                'added_by' => auth()->user()->name,
            ]);
        }

        Log::info('Miembros asociados al grupo exitosamente');
    }

    return redirect()->route('add_company')->with('success', 'Grupo creado exitosamente.');
}

public function manageCompany(Request $request)
{
    $query = Groups::query();

    // Filtro de búsqueda por nombre del grupo
    if ($request->has('search') && !empty($request->search)) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    // Paginación de resultados
    $groups = $query->paginate(10);
    $groups->withPath(url()->current());

    return view('companies.manage_company', compact('groups'));
}

public function bulkAction(Request $request)
{
    // Verificar los datos recibidos
    Log::info('Datos recibidos en bulkAction:', $request->all());

    $action = $request->input('action');
    $selectedGroups = $request->input('batch');

    if ($action == 'delete' && !empty($selectedGroups)) {
        Groups::whereIn('id', $selectedGroups)->delete();
        return redirect()->back()->with('success', 'Grupos eliminados correctamente.');
    }

    return redirect()->back()->with('error', 'Seleccione una acción válida y al menos un grupo.');
}
public function edit($id)
{
    // Obtener el grupo con sus miembros
    $group = Groups::with('members.client')->findOrFail($id);

    // Obtener los IDs únicos de los miembros actualmente asociados al grupo
    $selectedMembers = $group->members->pluck('client_id')->unique();

    // Obtener todos los clientes disponibles sin duplicados
    $members = User::distinct()->get();

    return view('companies.edit_group', compact('group', 'members', 'selectedMembers'));
}




public function update(Request $request, $id)
{
    // Normalizar el campo 'public' para que sea un booleano
    $request->merge([
        'public' => $request->has('public') ? true : false,
    ]);

    // Validar los datos del formulario
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'add_group_form_description' => 'nullable|string',
            'public' => 'sometimes|boolean',
            'add_group_form_members' => 'nullable|array',
        ]);

        Log::info('Validación exitosa.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Errores de validación:', $e->errors());
        return redirect()->back()->withErrors($e->errors())->withInput();
    }

    // Encontrar el grupo
    $group = Groups::findOrFail($id);

    // Asignar valores al grupo
    $group->name = $request->input('name');
    $group->description = $request->input('add_group_form_description', '') ?? '';
    $group->public = $request->input('public');
    $group->save();

    Log::info('Grupo actualizado correctamente con ID: ' . $group->id);

    // Actualizar los integrantes del grupo (para una relación HasMany)
    if ($request->has('add_group_form_members')) {
        $memberIds = array_unique($request->input('add_group_form_members'));

        // Eliminar los miembros existentes
        $group->members()->delete();

        // Insertar los nuevos miembros
        foreach ($memberIds as $memberId) {
            $group->members()->create([
                'client_id' => $memberId,
                'added_by' => auth()->user()->name,
            ]);
        }

        Log::info('Integrantes actualizados: ' . implode(', ', $memberIds));
    } else {
        // Eliminar todos los integrantes si no se selecciona ninguno
        $group->members()->delete();
        Log::info('Todos los integrantes han sido eliminados.');
    }

    // Redirigir con un mensaje de éxito
 // Redirigir con un mensaje de éxito a la vista de administrar compañías
return redirect()->route('manage_company')->with('success', 'Grupo actualizado correctamente.');

}

public function manageFiles($groupId, Request $request)
{
    $group = Groups::findOrFail($groupId);

    $query = TblFileRelation::where('group_id', $groupId)->with('file');

    // Filtro de búsqueda
    if ($request->has('search') && !empty($request->search)) {
        $query->whereHas('file', function ($q) use ($request) {
            $q->where('filename', 'like', '%' . $request->search . '%');
        });
    }

    // Filtro por estado (oculto/visible/todos)
    if ($request->has('hidden')) {
        if ($request->hidden == '2') {
            // Si es "Todos los estados", no filtrar por 'hidden'
        } else {
            $query->where('hidden', $request->hidden);
        }
    }

    // Paginación de resultados
    $files = $query->paginate(10);

    foreach ($files as $fileRelation) {
        if ($fileRelation->file) {
            // Generar token público si no existe
            if (empty($fileRelation->file->public_token)) {
                $fileRelation->file->public_token = Str::random(32);
                $fileRelation->file->save();
            }
    
            // Calcular tamaño y tipo del archivo
            $filePath = public_path('uploads/' . $fileRelation->file->url);
            $fileRelation->file->size = file_exists($filePath) ? filesize($filePath) : null;
            $fileRelation->file->type = pathinfo($fileRelation->file->filename, PATHINFO_EXTENSION);
    
            // Generar URL de descarga
            $fileRelation->file->downloadUrl = url('download.php?id=' . $fileRelation->file->id . '&token=' . $fileRelation->file->public_token);

    
            // Registrar logs
            \Log::info("Archivo ID: {$fileRelation->file->id}, URL: {$fileRelation->file->download_url}");
        
    
    

            // Determinar si el archivo tiene una fecha de expiración y si ya expiró
            if ($fileRelation->file->expires && $fileRelation->file->expiry_date) {
                $fileRelation->file->isExpired = $fileRelation->file->expiry_date < now();
            } else {
                $fileRelation->file->isExpired = null; // No tiene fecha de expiración
            }
        }
    }

    return view('companies.manage_files', compact('files', 'group'));
}







public function download($id)
{
    // Buscar el archivo en la base de datos
    $fileRelation = TblFileRelation::find($id);

    if (!$fileRelation || !$fileRelation->file) {
        return redirect()->back()->with('error', 'El archivo no existe o no está relacionado.');
    }

    $file = $fileRelation->file;

    // Verificar que la ruta del archivo exista
    $filePath = $file->url;

    if (!\Storage::exists($filePath)) {
        return redirect()->back()->with('error', 'El archivo no está disponible.');
    }

    // Descargar el archivo
    return \Storage::download($filePath, $file->filename);
}
public function editFile($fileId)
{
    $file = TblFile::findOrFail($fileId);

    // Generar token público si no existe
    if (!$file->public_token) {
        $file->public_token = Str::random(32);
        $file->save();
    }

    $clients = User::all(); // Todos los clientes
    $groups = Groups::all(); // Todos los grupos
    $categories = TblCategory::all(); // Todas las categorías

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

    return view('companies.edit_file', compact(
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








public function updateFile(Request $request, $id)
{
    // Validar el formulario
    $request->validate([
        'filename' => 'required|string|max:255',
        'description' => 'nullable|string',
        'expiry_date' => 'nullable|date',
        'expires' => 'boolean',
        'public_allow' => 'boolean',
        'assignments' => 'nullable|array', // Validar asignaciones
        'assignments.*' => 'string', // Cada asignación debe ser un string con prefijo 'client_' o 'group_'
        'categories' => 'nullable|array', // Validar categorías
        'categories.*' => 'integer|exists:tbl_categories,id', // Cada categoría debe ser un ID válido
    ]);

    // Buscar el archivo
    $file = TblFile::findOrFail($id);

    // Actualizar los campos básicos del archivo
    $file->update([
        'filename' => $request->input('filename'),
        'description' => $request->input('description', ''),
        'expiry_date' => $request->input('expires') ? $request->input('expiry_date') : null,
        'expires' => $request->boolean('expires'),
        'public_allow' => $request->boolean('public_allow'),
    ]);

    // **Actualizar asignaciones**
    if ($request->has('assignments')) {
        // Obtener las asignaciones actuales del archivo
        $currentAssignments = TblFileRelation::where('file_id', $file->id)
            ->get(['client_id', 'group_id']);

        // Separar las asignaciones por tipo (clientes y grupos)
        $existingClientIds = $currentAssignments->pluck('client_id')->filter()->toArray();
        $existingGroupIds = $currentAssignments->pluck('group_id')->filter()->toArray();

        // Preparar las nuevas asignaciones del formulario
        $newClientIds = [];
        $newGroupIds = [];
        foreach ($request->input('assignments') as $assignment) {
            if (str_starts_with($assignment, 'client_')) {
                $newClientIds[] = (int) str_replace('client_', '', $assignment);
            } elseif (str_starts_with($assignment, 'group_')) {
                $newGroupIds[] = (int) str_replace('group_', '', $assignment);
            }
        }

        // Determinar las asignaciones a agregar y eliminar
        $clientsToAdd = array_diff($newClientIds, $existingClientIds);
        $groupsToAdd = array_diff($newGroupIds, $existingGroupIds);
        $clientsToRemove = array_diff($existingClientIds, $newClientIds);
        $groupsToRemove = array_diff($existingGroupIds, $newGroupIds);

        // Agregar nuevas asignaciones
        foreach ($clientsToAdd as $clientId) {
            TblFileRelation::create([
                'file_id' => $file->id,
                'client_id' => $clientId,
                'hidden' => 0, // Define explícitamente el valor para el campo hidden
            ]);
        }
        foreach ($groupsToAdd as $groupId) {
            TblFileRelation::create([
                'file_id' => $file->id,
                'group_id' => $groupId,
                'hidden' => 0, // Define explícitamente el valor para el campo hidden
            ]);
        }

        // Eliminar asignaciones que ya no están seleccionadas
        TblFileRelation::where('file_id', $file->id)
            ->whereIn('client_id', $clientsToRemove)
            ->delete();

        TblFileRelation::where('file_id', $file->id)
            ->whereIn('group_id', $groupsToRemove)
            ->delete();
    }

    // **Actualizar categorías**
    TblCategoryRelation::where('file_id', $file->id)->delete();
    if ($request->has('categories')) {
        foreach ($request->input('categories') as $categoryId) {
            TblCategoryRelation::create([
                'file_id' => $file->id,
                'cat_id' => $categoryId,
            ]);
        }
    }

    // Redirigir con mensaje de éxito
    return redirect()->back()->with('success', 'El archivo se ha actualizado correctamente.');
}

public function bulkActionFiles(Request $request, $groupId)
{
    $action = $request->input('action');
    $selectedFiles = $request->input('batch');

    if (!$selectedFiles || $action === 'none') {
        return redirect()->back()->with('error', 'Seleccione una acción válida y al menos un archivo.');
    }

    switch ($action) {
        case 'hide':
            TblFileRelation::whereIn('file_id', $selectedFiles)
                ->where('group_id', $groupId)
                ->update(['hidden' => 1]);
            return redirect()->back()->with('success', 'Archivos ocultados exitosamente.');

        case 'show':
            TblFileRelation::whereIn('file_id', $selectedFiles)
                ->where('group_id', $groupId)
                ->update(['hidden' => 0]);
            return redirect()->back()->with('success', 'Archivos mostrados exitosamente.');

        case 'unassign':
            TblFileRelation::whereIn('file_id', $selectedFiles)
                ->where('group_id', $groupId)
                ->delete();
            return redirect()->back()->with('success', 'Archivos desasignados exitosamente.');

        default:
            return redirect()->back()->with('error', 'Acción no válida.');
    }
}







    



}

