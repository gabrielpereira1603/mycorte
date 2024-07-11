<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancellationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $clientName;
    public $companyName;

    public function __construct($clientName, $companyName)
    {
        $this->clientName = $clientName;
        $this->companyName = $companyName;
    }

    public function build()
    {
        return $this->view('Emails.cancellation')
            ->with([
                'clientName' => $this->clientName,
                'companyName' => $this->companyName,
            ])
            ->subject('Agendamento Cancelado!');
    }
}
