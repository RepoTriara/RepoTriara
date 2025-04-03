<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUsersEmail;
use Illuminate\Support\Facades\Log;

class UserSystemController extends Controller
{

    /**
     * Muestra el formulario de registro para usuarios del sistema.
     */
    public function create()
    {
        return view('system_users.add_user'); // Asegúrate de tener esta vista
    }

    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda, filtros y orden
        $search = $request->get('search'); // Búsqueda por nombre, usuario o email
        $role = $request->get('role', 'all'); // Filtro de rol
        $active = $request->get('active', '2'); // Filtro de estado (2 = todos, 1 = activo, 0 = inactivo)
        $orderby = $request->get('orderby', 'timestamp'); // Campo para ordenar, ahora por timestamp
        $order = $request->get('order', 'desc'); // Dirección del orden (de más reciente a más antiguo)
        // Construir la consulta base
        $query = User::query();

        // Filtrar solo usuarios con level 10 u 8
        $query->whereIn('level', [10, 8]);

        // Aplicar búsqueda
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('user', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Aplicar filtro de rol
        if ($role !== 'all') {
            $query->where('level', $role);
        }

        // Aplicar filtro de estado
        if ($active !== '2') {
            $query->where('active', $active);
        }

        // Obtener el total de usuarios filtrados
        $filteredUsersCount = $query->count();

        // Obtener el total de usuarios con level 10 u 8 (sin filtros adicionales)
        $totalUsers = User::whereIn('level', [10, 8])->count();

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

        return view('system_users.manage_users', compact('users', 'totalUsers', 'filteredUsersCount'));
    }

    public function edit($id)
    {
        // Buscar el usuario por ID
        $user = User::findOrFail($id);

        // Retornar la vista de edición con los datos del usuario
        return view('system_users.edit_user', compact('user'));
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
        return redirect()->route('system_users.index');
    }
    /**
     * Maneja el registro de usuarios del sistema.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados desde el formulario
        $request->validate([
            'name' => ['required', 'string', 'max:60','min:5'], 
            'email' => [
            'required',
            'string',
            'email:rfc,dns', // Verifica formato RFC y existencia del dominio
            'max:60',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/',
            'unique:' . User::class
            ],
            'password' => ['required', 'string', 'min:8','regex:/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};:"\\|.<>\/?`~]+$/'],
            'user' => ['required', 'string', 'max:60','min:5', 'unique:tbl_users','regex:/^[a-zA-Z0-9.]+$/u'],
            'level' => ['required', 'in:10,8'], // Validar que level sea 10 o 8
            'notify' => ['nullable', 'boolean'], // Validar que notify sea booleano (0 o 1)
            'active' => ['nullable', 'boolean'], // Validar que active sea booleano (0 o 1)

        ]);

        try {
            // Intentamos crear el nuevo usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user' => $request->user,
                'level' => $request->level,
                'notify' => $request->has('notify') ? 1 : 0, // Convertir a 1 (true) o 0 (false)
                'active' => $request->has('active') ? 1 : 0, // Convertir a 1 (true) o 0 (false)
            ]);

             if ($request->has('welcome_notify')) {
            Mail::to($user->email)->send(new NewUsersEmail($user, $request->password));
         }
            return response()->json([
                'message' => 'Usuario registrado correctamente.',
            ]);
        } catch (\Exception $e) {
            // Si algo falla, devolvemos un mensaje de error en formato JSON
            return response()->json([
                'message' => 'Hubo un problema al registrar el usuario. Inténtalo nuevamente.',
            ], 500); // Código de estado HTTP 500 para errores del servidor
        }
    }

    public function update(Request $request, $id)
{
    // Validar los datos del formulario
    $validated = $request->validate([
        'name' => 'required|string|max:60|min:5',
        'user' => 'required|string|max:60',
        'email' => [
                'required',
                'string',
                'email:rfc,dns', // Verifica formato RFC y existencia del dominio
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/', // Dominios de 2 a 63 caracteres
                'unique:tbl_users,email,' . ($id ?? 'NULL') . ',id'
            ],
        'level' => 'required|in:10,8',
        'password' => ['required', 'string', 'min:8','regex:/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};:"\\|.<>\/?`~]+$/'],

        'active' => 'boolean',
        'notify' => 'boolean', // ✅ Agregado
    ]);

    // Buscar el usuario por su ID
    $user = User::findOrFail($id);

    // Actualizar los datos del usuario
    $user->name = $request->name;
    $user->email = $request->email;
    $user->level = $request->level;
    $user->active = $request->input('active', 0);
    $user->notify = $request->input('notify', 0); // ✅ Si no se envía, se establece en 0

    // Si la contraseña ha sido cambiada, actualizarla
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    // Guardar los cambios
    $user->save();

    return response()->json(['success' => 'Usuario actualizado correctamente.']);
}


}
