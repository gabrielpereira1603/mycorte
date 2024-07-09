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

    public $clientName;
    public $recoveryCode;

    public function __construct($clientName, $recoveryCode)
    {
        $this->clientName = $clientName;
        $this->recoveryCode = $recoveryCode;
    }

    public function build()
    {
        return $this->view('emails.passwordReset')
            ->with([
                'clientName' => $this->clientName,
                'recoveryCode' => $this->recoveryCode,
            ])
            ->subject('Recuperação de Senha - MyCorte');
    }
}
