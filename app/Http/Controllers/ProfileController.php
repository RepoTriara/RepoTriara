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
   public function update(ProfileUpdateRequest $request)
{
    $user = $request->user();
    $validatedData = $request->validated();

    if (array_key_exists('password', $validatedData) && $validatedData['password'] === null) {
        unset($validatedData['password']);
    }

    $user->fill($validatedData);

    // Guardar los campos adicionales
    $user->address = $request->input('address');
    $user->phone = $request->input('phone');

    // Si se proporciona una nueva contraseña, actualizarla
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    $user->save();

    // Verificar si la solicitud espera JSON y responder apropiadamente
    if ($request->expectsJson()) {
        return response()->json(['message' => 'Perfil actualizado correctamente.'], 200);
    }

    // Mensaje de éxito para peticiones normales (no JSON)
    return Redirect::route('profile.edit')->with('success', 'Perfil actualizado correctamente.');
}

}
