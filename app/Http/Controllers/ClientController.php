<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TblFile;
use App\Models\TblFileRelation;
use App\Models\Members;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUsersEmail;


class ClientController extends Controller
{

    public function create()
    {
        $groups = Groups::all(); // Selecciona únicamente los campos necesarios

        return view('customers.add_client', compact('groups'));
    }

    public function index(Request $request)
    {
        // Obtener parámetros de la solicitud con valores por defecto
         $search = $request->input('search');
        $role = $request->input('role');
        $active = $request->input('active', '2');
        $orderby = $request->input('orderby', 'timestamp');
        $order = $request->input('order', 'desc');

        // Iniciar la consulta
        $query = User::query();

        $query->where('level', 0);

        // Aplicar filtros si existen
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('user', 'like', "%{$search}%");
            });
        }

        if ($active !== '2') {
            $query->where('active', $active);
        }

        // Obtener el total de clientes después de aplicar los filtros
        $filteredClientesCount = $query->count();

        // Aplicar orden y paginación
        $clientes = $query->orderBy($orderby, $order)->paginate(10);

        // Agregar parámetros actuales a los enlaces de paginación
        $clientes->appends([
            'search' => $search,
            'active' => $active,
            'orderby' => $orderby,
            'order' => $order,
        ]);

        $totalCliente = User::where('level', 0)->count();

        foreach ($clientes as $cliente) {
            // Codigo para contar archivos cargas.
            $uploads_count = TblFile::where('uploader', $cliente->user)->count();
            $cliente->uploads_count = $uploads_count > 0 ? $uploads_count : null;

            // Contar los archivos propios del cliente.
            $own_files = TblFileRelation::where('client_id', $cliente->id)
                ->whereNull('group_id')
                ->count();
            $cliente->own_files_count = $own_files > 0 ? $own_files : null;

            // Encontrar todos los grupos a los que pertenece el cliente.
            $found_groups = Members::where('client_id', $cliente->id)
                ->pluck('group_id')
                ->toArray();
            $cliente->group_count = count($found_groups);

            // Inicializar el conteo de archivos de grupos.
            $groups_files = 0;
            if (count($found_groups) > 0) {
                $groups_files = TblFileRelation::whereIn('group_id', $found_groups)
                    ->whereNotNull('group_id')
                    ->count();
            }
            $cliente->group_files_count = $groups_files > 0 ? $groups_files : null;
            $cliente->active_groups = (count($found_groups) > 0) ? implode(',', $found_groups) : '';

            // Determinar el estado de notificaciones del cliente;
            $cliente->notification_status = $cliente->notify ? 'Sí' : 'No';
        }

        // Pasar la variable 'filteredClientesCount' a la vista
        return view('customers.customer_manager', compact('clientes', 'totalCliente', 'filteredClientesCount'));
    }


    public function store(Request $request)
    {


        // Validar los datos del formulario
        $request->validate([

            'name' => ['required', 'string', 'max:60','min:5'], 
            'user' => ['required', 'string', 'max:60','min:5', 'unique:tbl_users','regex:/^[a-zA-Z0-9.]+$/u'],
            'password' => ['required', 'string', 'min:8', 'max:60', 'regex:/^[a-zA-Z0-9!@#$%^&*()_+´\-=\[\]{};:"\'\\\\|,.<>\/?`~]+$/'],
            'email' => [
            'required',
            'string',
            'email:rfc,dns', // Verifica formato RFC y existencia del dominio
            'max:60',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/',
            'unique:' . User::class
            ],
            'address' => ['nullable', 'string', 'max:60','min:5'],
            'phone' => ['nullable','digits_between:7,10'],
            'contact' => ['nullable', 'string','min:5', 'max:60'],
            'max_file_size' => ['nullable', 'required', 'integer', 'min:0', 'max:2048'], // Validación de rango
            'group_request' => ['nullable', 'array'],
            'group_request.*' => ['integer'],
            'active' => ['nullable', 'boolean'],
            'notify' => ['nullable', 'boolean'],
        ]);

        try {

            $user = User::create([
                'name' => $request->name,
                'user' => $request->user,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'contact' => $request->contact,
                'max_file_size' => $request->max_file_size,
                'level' => 0,
                'active' => $request->has('active') ? $request->active : false,
                'notify' => $request->has('notify') ? $request->notify : false,
            ]);

             if ($request->has('welcome_notify')) {
            Mail::to($user->email)->send(new NewUsersEmail($user, $request->password));
            }

            // codigo para asociar al cliente a uno o varios grupos
            if ($request->has('group_request') && count($request->group_request) > 0) {
                foreach ($request->group_request as $groupId) {
                    $member = Members::create([
                        'client_id' => $user->id,
                        'group_id' => $groupId,
                        'added_by' => Auth::user()->id,
                    ]);
                }
            }

            return response()->json(['success' => 'Cliente registrado correctamente.']);
        } catch (\Exception $e) {
            // Puedes registrar el error en los logs para más información.

            // Mensaje genérico para el usuario.
            session()->flash('error', 'Hubo un problema al registrar el cliente. Verifica los datos ingresados o inténtalo nuevamente.');
        }

        return response()->json(['errors' => ['campo' => ['Mensaje de error']]], 422);
    }

    public function bulkAction(Request $request)
    {
        // Validar la acción seleccionada
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'batch' => 'required|array|min:1',
            'batch.*' => 'exists:tbl_users,id',
        ]);

        // Obtener los IDs seleccionados
        $userIds = User::whereIn('id', $request->batch)
            ->where('level', 0) // Filtrar solo clientes
            ->pluck('id');
        if ($userIds->isEmpty()) {
            session()->flash('error', 'No se seleccionaron clientes válidos.');
            return redirect()->route('customer_manager');
        }
        $action = $request->action;

        try {
            $count = count($userIds); // Contar el número de clientes seleccionados

            switch ($action) {
                case 'activate':
                    User::whereIn('id', $userIds)->update(['active' => 1]);
                    session()->flash('success', $count === 1
                        ? 'El cliente ha sido activado correctamente.'
                        : 'Los clientes han sido activados correctamente.');
                    break;
                case 'deactivate':
                    User::whereIn('id', $userIds)->update(['active' => 0]);
                    session()->flash('success', $count === 1
                        ? 'El cliente ha sido desactivado correctamente.'
                        : 'Los clientes han sido desactivados correctamente.');
                    break;
                case 'delete':
                    User::whereIn('id', $userIds)->delete();
                    session()->flash('success', $count === 1
                        ? 'El cliente ha sido eliminado correctamente.'
                        : 'Los clientes han sido eliminados correctamente.');
                    break;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al procesar la acción seleccionada.');
        }

        return redirect()->route('customer_manager');
    }

   // Código para Editar un cliente
public function edit($id)
{
    $client = User::findOrFail($id);
    $groups = Groups::all();
    $associatedGroups = Members::where('client_id', $id)->pluck('group_id')->toArray();

    return view('customers.edit_client', compact('client', 'groups', 'associatedGroups'));
}

public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60', 'min:5'],
            'user' => ['required', 'string', 'max:60','min:5', 'unique:tbl_users,user,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'max:60', 'regex:/^[a-zA-Z0-9!@#$%^&*´()_+\-=\[\]{};:"\'\\\\|,.<>\/?`~]+$/'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns', // Verifica formato RFC y existencia del dominio
                'max:60',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/', // Dominios de 2 a 63 caracteres
                'unique:tbl_users,email,' . ($id ?? 'NULL') . ',id'
            ],
            'address' => ['nullable', 'string', 'max:60','min:5'],
            'phone' => ['nullable', 'digits_between:7,10'],
            'contact' => ['nullable', 'string', 'max:60', 'min:5'],
            'max_file_size' => ['nullable', 'integer', 'required', 'min:0', 'max:2048'],
            'group_request' => ['nullable', 'array'],
            'group_request.*' => ['integer'],
            'active' => ['nullable', 'boolean'],
            'notify' => ['nullable', 'boolean'],
        ]);

        $client = User::findOrFail($id);

        // Actualizar datos del cliente
        $client->name = $request->name;
        $client->email = $request->email;
        $client->user = $request->user;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->contact = $request->contact;
        $client->max_file_size = $request->max_file_size;
        $client->notify = $request->input('notify', 0);
        $client->active = $request->has('active') ? $request->active : $client->active;

        if ($request->filled('password')) {
            $client->password = bcrypt($request->password);
        }

        // Guardar cambios del cliente
        $client->save();

        // Gestión de grupos
        $newGroups = $request->input('group_request', []);
        $currentGroups = Members::where('client_id', $id)->pluck('group_id')->toArray();

        $groupsToRemove = array_diff($currentGroups, $newGroups);
        $groupsToAdd = array_diff($newGroups, $currentGroups);

        // Eliminar asociaciones de grupos
        if (!empty($groupsToRemove)) {
            Members::where('client_id', $id)
                ->whereIn('group_id', $groupsToRemove)
                ->delete();
        }

        // Agregar nuevas asociaciones de grupos
        foreach ($groupsToAdd as $groupId) {
            Members::create([
                'client_id' => $id,
                'group_id' => $groupId,
                'added_by' => Auth::user()->id,
            ]);
        }

        return response()->json(['success' => 'Cliente actualizado correctamente.'], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Hubo un problema al actualizar el cliente.'], 500);
    }
}


}
