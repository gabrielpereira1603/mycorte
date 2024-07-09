<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Register your commands here
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $today = now()->toDateString();
            $now = now();
            $nowPlus30Minutes = now()->addMinutes(30);

            $schedules = Schedule::where('date', $today)->get();

            foreach ($schedules as $schedule) {
                $scheduleStartDateTime = $schedule->date->setTimeFrom($schedule->hourStart);

                if ($scheduleStartDateTime->isAfter($now) && $scheduleStartDateTime->isBefore($nowPlus30Minutes) && !$schedule->reminderEmailSent) {
                    dispatch(new \App\Jobs\SendReminderEmail($schedule));
                    $schedule->reminderEmailSent = true;
                    $schedule->save();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
