<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar la entrada del usuario
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Buscar el usuario que solicitó el restablecimiento
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Si no se encuentra el usuario, mostrar un error
            return back()->withErrors(['email' => __('No se encontró un usuario con esa dirección de correo electrónico.')]);
        }

        // Generar un token para el restablecimiento de contraseña
        $token = app('auth.password.broker')->createToken($user);

        // Enviar el correo utilizando el Mailable
        Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email));

        // Retornar una respuesta indicando que el enlace fue enviado
        return back()->with('status', __('Si este correo electrónico está registrado, se le ha enviado un enlace de restablecimiento.'));
    }
}
