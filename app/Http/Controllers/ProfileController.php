<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de edición del perfil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información del perfil del usuario.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // Guardar los campos adicionales
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        // Mensaje de éxito
        session()->flash('success', 'Perfil actualizado correctamente.');

        return Redirect::route('profile.edit');
    }
}
