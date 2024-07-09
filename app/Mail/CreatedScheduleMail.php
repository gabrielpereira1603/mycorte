<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreatedScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $scheduleDate;
    public $scheduleStartTime;
    public $scheduleEndTime;
    public $collaboratorName;
    public $companyName;

    public function __construct($clientName, $scheduleDate, $scheduleStartTime, $scheduleEndTime, $collaboratorName, $companyName)
    {
        $this->clientName = $clientName;
        $this->scheduleDate = $scheduleDate;
        $this->scheduleStartTime = $scheduleStartTime;
        $this->scheduleEndTime = $scheduleEndTime;
        $this->collaboratorName = $collaboratorName;
        $this->companyName = $companyName;
    }

    public function build()
    {
        return $this->view('emails.createdSchedule')
            ->with([
                'clientName' => $this->clientName,
                'scheduleDate' => $this->scheduleDate,
                'scheduleStartTime' => $this->scheduleStartTime,
                'scheduleEndTime' => $this->scheduleEndTime,
                'collaboratorName' => $this->collaboratorName,
                'companyName' => $this->companyName,
            ])
            ->subject('Agendamento Confirmado!');
    }
}
