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

    public $client;
    public $schedule;
    public $collaborator;
    public $company;
    public $formatedData;

    public function __construct($client, $schedule, $collaborator, $company, $formatedData)
    {
        $this->client = $client;
        $this->schedule = $schedule;
        $this->collaborator = $collaborator;
        $this->company = $company;
        $this->formatedData = $formatedData;
    }

    public function build()
    {
        return $this->view('Emails.reschedule')
            ->with([
                'clientName' => $this->client->name,
                'companyName' => $this->company->name,
                'newScheduleDate' => $this->formatedData,
                'newScheduleStartTime' => $this->schedule->hourStart,
                'newScheduleEndTime' => $this->schedule->hourFinal,
                'collaboratorName' => $this->collaborator->name,
            ])
            ->subject('Reagendamento Confirmado - MyCorte');
    }

}
