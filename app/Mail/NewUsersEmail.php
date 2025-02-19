<?php

namespace App\Mail;

use App\Models\User; // Importa el modelo User
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUsersEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Propiedad para almacenar el usuario
    public $password; // Propiedad para almacenar la contraseña

    public function __construct(User $user, $password) // Recibe el usuario y la contraseña
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido/a a nuestra plataforma', // Asunto más descriptivo
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newusersemail', // Usa la vista creada (debe existir resources/views/emails/new_user.blade.php)
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
