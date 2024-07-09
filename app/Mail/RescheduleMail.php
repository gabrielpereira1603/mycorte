<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RescheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $companyName;
    public $newScheduleDate;
    public $newScheduleStartTime;
    public $newScheduleEndTime;
    public $collaboratorName;

    public function __construct($clientName, $companyName, $newScheduleDate, $newScheduleStartTime, $newScheduleEndTime, $collaboratorName)
    {
        $this->clientName = $clientName;
        $this->companyName = $companyName;
        $this->newScheduleDate = $newScheduleDate;
        $this->newScheduleStartTime = $newScheduleStartTime;
        $this->newScheduleEndTime = $newScheduleEndTime;
        $this->collaboratorName = $collaboratorName;
    }

    public function build()
    {
        return $this->view('emails.reschedule')
            ->with([
                'clientName' => $this->clientName,
                'companyName' => $this->companyName,
                'newScheduleDate' => $this->newScheduleDate,
                'newScheduleStartTime' => $this->newScheduleStartTime,
                'newScheduleEndTime' => $this->newScheduleEndTime,
                'collaboratorName' => $this->collaboratorName,
            ])
            ->subject('Reagendamento Confirmado - MyCorte');
    }

}
