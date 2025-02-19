<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Construir el mensaje de correo electrónico.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Restablecer Contraseña')
                    ->view('emails.reset') // Tu vista personalizada
                    ->with([
                        'token' => $this->token,
                        'email' => $this->email,
                    ]);
    }
}
