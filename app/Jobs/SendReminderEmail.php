<?php

namespace App\Jobs;

use App\Mail\ReminderEmail;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function handle()
    {
        $schedule = Schedule::with('client')->find($this->schedule->id);
        Log::info($schedule->client->email);

        if ($schedule && $schedule->client) {
            Mail::to($schedule->client->email)->send(new ReminderEmail($schedule));
        } else {
            Log::error("Client not found for schedule ID: {$this->schedule->id}");
        }
        $this->schedule->reminderEmailSent = true;
        $this->schedule->save();
    }
}
