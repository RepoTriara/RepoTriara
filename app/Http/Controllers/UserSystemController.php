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




    public function index()
    {
        // Obtener todos los usuarios (puedes agregar filtros o paginación si es necesario)
        $users = User::all();  // O puedes usar paginate() para paginación

        return view('manage_users', compact('users'));
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







}
