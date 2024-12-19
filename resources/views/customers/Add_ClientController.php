<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Add_ClientController extends Controller
{
    public function create()
    {

        return view('add_client', compact(''));
    }

    public function index(Request $request)
{
    // Obtener parámetros de la solicitud con valores por defecto
    $search = $request->input('search');
    $role = $request->input('role');
    $active = $request->input('active', '2');
    $orderby = $request->input('orderby', 'name');
    $order = $request->input('order', 'asc');
 
    // Iniciar la consulta
    $query = User::query();
 
    // Aplicar filtros si existen
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('user', 'like', "%{$search}%");
        });
    }
 
    if ($active !== '2') {
        $query->where('active', $active);
    }
 
    // Aplicar orden y paginación
    $users = $query->orderBy($orderby, $order)->paginate(10);
 
    // Agregar parámetros actuales a los enlaces de paginación
    $users->appends([
        'search' => $search,
        'role' => $role,
        'active' => $active,
        'orderby' => $orderby,
        'order' => $order,
    ]);
 
    $totalUsers = User::count();
 
    // Retornar vista con datos
    return view('customers.customer_manager', compact('users'));
}

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user' => ['required', 'string', 'max:60', 'unique:tbl_users'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:32'],
            'contact' => ['nullable', 'string', 'max:255'],
            'max_file_size' => ['nullable', 'integer', 'min:0'],
            'group_request' => ['nullable', 'array'], // Validar que sea un array
            'group_request.*' => ['integer'], // Validar que cada valor sea un entero            'active' => ['nullable', 'boolean'],
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
                'active' => $request->active,
                'notify' => $request->notify,
                /*'group_request' => $request->group_request,*/
            ]);

            // Guardar los grupos asociados
            if ($request->has('group_request')) {
                // Si tienes una relación muchos a muchos:
                $user->groups()->sync($request->group_request);
            }

            session()->flash('success', 'cliente registrado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al registrar el clientye. Inténtalo nuevamente.');
        }
        return back();
    }

    public function bulkAction(Request $request)
    {
        // Validar la acción seleccionada
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'batch' => 'required|array|min:1',
            'batch.*' => 'exists:tbl_users,id', // Validar que los IDs sean válidos
        ]);

        // Obtener los IDs seleccionados
        $userIds = $request->batch;
        $action = $request->action;

        try {
            // Dependiendo de la acción seleccionada, procesar
            switch ($action) {
                case 'activate':
                    User::whereIn('id', $userIds)->update(['active' => 1]);
                    session()->flash('success', 'Usuarios activados correctamente.');
                    break;

                case 'deactivate':
                    User::whereIn('id', $userIds)->update(['active' => 0]);
                    session()->flash('success', 'Usuarios desactivados correctamente.');
                    break;

                case 'delete':
                    User::whereIn('id', $userIds)->delete();
                    session()->flash('success', 'Usuarios eliminados correctamente.');
                    break;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al procesar la acción seleccionada.');
        }

        // Redirigir de vuelta con el mensaje
        return redirect()->route('customers.index');
    }
}
