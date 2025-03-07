<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $email;
    public $password;

    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Tu nueva contraseña')
                    ->view('emails.password_reset')
                    ->with([
                        'username' => $this->username,
                        'email' => $this->email,
                        'password' => $this->password,
                    ]);
    }
}
