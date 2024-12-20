<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    $orderby = $request->get('orderby', 'name'); // Campo para ordenar
    $order = $request->get('order', 'asc'); // Dirección del orden

    // Construir la consulta base
    $query = User::query();

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

    // Contar el total de usuarios (sin filtros)
    $totalUsers = User::count();

    return view('system_users.manage_users', compact('users', 'totalUsers'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tbl_users'],
            'password' => ['required', 'string', 'min:8'],
            'user' => ['required', 'string', 'max:60','unique:tbl_users'],
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

            // Si todo va bien, mostramos el mensaje de éxito
            session()->flash('success', 'Usuario registrado correctamente');

        } catch (\Exception $e) {
            // Si algo falla, mostramos un mensaje de error
            session()->flash('error', 'Hubo un problema al registrar el usuario. Inténtalo nuevamente.');
        }

        // Volver a la misma vista con los errores (si los hay)
        return back();

    }


    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|string|max:60',
            'email' => 'required|email|max:255|unique:tbl_users,email,' . $id, // Ignora el correo del usuario actual
            'level' => 'required|in:10,8',  // Asegúrate de que 'level' sea uno de los valores válidos
            'password' => 'nullable|string|min:8', // Si no se cambia la contraseña, no es obligatorio
            'active' => 'boolean',
        ]);

        // Buscar el usuario por su ID
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;  // Cambiar 'role' por 'level'
        $user->active = $request->input('active', 0); // Si no se envía, establecer en 0

        // Si la contraseña ha sido cambiada, actualizarla
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Guardar los cambios
        $user->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('system_users.index')->with('success', 'Usuario actualizado correctamente.');
    }






}
