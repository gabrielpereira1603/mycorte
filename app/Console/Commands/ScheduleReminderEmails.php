<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderEmail;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScheduleReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar e-mails de lembrete para schedules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $targetTime = $now->addMinutes(30)->toTimeString();

        Log::info("Current DateTime: " . $now->toDateTimeString());
        Log::info("Target Time: " . $targetTime);

        $schedules = Schedule::whereDate('date', $now->toDateString())
            //->whereTime('hourStart', $targetTime)
            //->where('reminderEmailSent', false)
            ->get();

        Log::info("Found Schedules: " . $schedules->count());

        foreach ($schedules as $schedule) {
            Log::info("Dispatching email for schedule ID: " . $schedule->id);
            SendReminderEmail::dispatch($schedule);
        }

        return 0;

    }
}
