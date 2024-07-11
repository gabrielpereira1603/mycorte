<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;

    public function __construct($clientName)
    {
        $this->clientName = $clientName;
    }

    public function build()
    {
        return $this->view('Emails.welcome')
            ->with([
                'clientName' => $this->clientName,
            ])
            ->subject('Bem-vindo ao MyCorte!');
    }
}
