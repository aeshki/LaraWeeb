<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $url = url(route('password.reset', ['token' => $this->token, 'email' => $this->email], false));

        return $this->view('emails.password_reset')
            ->subject('Réinitialisation de votre mot de passe')
            ->with([
                'url' => $url,
                'email' => $this->email,
            ]);
    }
}
