<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $recoveryCode;


    public function __construct($name, $recoveryCode)
    {
        $this->name = $name;
        $this->recoveryCode = $recoveryCode;
    }

    public function build()
    {
        return $this->view('Emails.passwordReset')
            ->with([
                'clientName' => $this->name,
                'recoveryCode' => $this->recoveryCode,
            ])
            ->subject('Recuperação de Senha - MyCorte');
    }
}
