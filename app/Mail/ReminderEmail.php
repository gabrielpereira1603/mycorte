<?php

namespace App\Mail;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $schedule;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminder_schedule_email')
            ->with([
                'clientName' => $this->schedule->client->name,
                'scheduleDate' => $this->schedule->date,
                'scheduleStartTime' => $this->schedule->hourStart,
                'scheduleEndTime' => $this->schedule->hourFinal,
                'collaboratorName' => $this->schedule->collaborator->name,
                'companyName' => $this->schedule->company->name,
            ]);
    }
}
