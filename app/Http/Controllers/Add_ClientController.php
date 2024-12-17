<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener este modelo
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Exception;

class Add_ClientController extends Controller
{
    public function create()
    {   
        $groups = Groups::all(); // Asegúrate de importar el modelo correspondiente.
       return view('add_client', compact('groups'));
        // Muestra la vista del formulario
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user' => ['required', 'string', 'max:60', 'unique:tbl_users'], // Validación del campo user
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:32'],
            'contact' => ['nullable', 'string', 'max:255'],
            'max_file_size' => ['nullable', 'integer', 'min:0'],
            /*'group_request' => ['nullable', 'array'],*/
            /*'active' => ['nullable', 'boolean'],*/
            /*'notify' => ['nullable', 'boolean'],*/
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

                /*'active' => $request->active,*/
                /*'notify' => $request->notify,*/
                /*'group_request' => $request->group_request,*/
            ]);
            session()->flash('success', 'cliente registrado correctamente');
        } catch (\Exception $e) {
            // Si algo falla, mostramos un mensaje de error
            session()->flash('error', 'Hubo un problema al registrar el usuario. Inténtalo nuevamente.');
        }
        return back();
    }
}
