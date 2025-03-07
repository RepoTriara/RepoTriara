<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\PasswordResetMail;

class ResetUserPasswords extends Command
{
    protected $signature = 'users:reset-passwords';
    protected $description = 'Resetea todas las contraseñas de los usuarios y genera un archivo TXT con los nuevos datos';

    public function handle()
    {
        $usuarios = User::all(); // Obtener todos los usuarios
        $data = "Usuario,Correo,Nueva Contraseña\n";

        foreach ($usuarios as $usuario) {
            $nuevaPassword = bin2hex(random_bytes(4)); // Genera una contraseña de 8 caracteres
            $usuario->password = Hash::make($nuevaPassword);
            $usuario->save();

            // Validar username y email
            $username = $usuario->name ?? 'SIN_USERNAME';
            $email = $usuario->email ?? null;

          if ($email) {
             Mail::to($email)->send(new PasswordResetMail($username, $email, $nuevaPassword));
           }

            $data .= "{$username},{$email},{$nuevaPassword}\n";
        }

        Storage::put('usuarios_reset.txt', $data);
        $this->info('Contraseñas reseteadas, correos enviados y archivo generado en storage/app/usuarios_reset.txt');
    }
}
