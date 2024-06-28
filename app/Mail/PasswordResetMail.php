<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(config('auth.passwords.users.expire')),
            [
                'token' => $this->token,
                'email' => $this->email
            ]
        );

        return $this->view('emails.password-reset')
            ->subject('[DIGISTOCK] Redefinição de Senha')
            ->with([
                'url' => $url,
            ]);
    }
}
