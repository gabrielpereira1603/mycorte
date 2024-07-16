<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CaptureEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $capturedEmail;

    public function __construct($capturedEmail)
    {
        $this->capturedEmail = $capturedEmail;
    }

    public function build()
    {
        return $this->view('Emails.capture')
            ->with(['capturedEmail' => $this->capturedEmail])
            ->subject('Solicitação de Contato.');
    }
}
