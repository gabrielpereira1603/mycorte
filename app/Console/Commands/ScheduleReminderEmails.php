<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderEmail;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScheduleReminderEmails extends Command
{
    protected $signature = 'emails:send-reminders';
    protected $description = 'Enviar e-mails de lembrete para schedules';

    public function handle()
    {
        // Define o timezone para São Paulo
        $now = Carbon::now('America/Sao_Paulo');
        $targetTime = $now->copy()->addHour();  // Configura para uma hora a partir de agora

        Log::info("Current DateTime: " . $now->toDateTimeString());
        Log::info("Target Time: " . $targetTime->toDateTimeString());

        // Busca agendamentos para a próxima hora
        $schedules = Schedule::where('scheduled_at', '>=', $now)
            ->where('scheduled_at', '<=', $targetTime)
            ->where('reminderEmailSent', false)
            ->get();

        Log::info("Found Schedules: " . $schedules->count());

        foreach ($schedules as $schedule) {
            Log::info("Dispatching email for schedule ID: " . $schedule->id . " Scheduled At: " . $schedule->scheduled_at);
            SendReminderEmail::dispatch($schedule);
            // Atualizar o agendamento para marcar que o e-mail de lembrete foi enviado
            $schedule->reminderEmailSent = true;
            $schedule->save();
            Log::info("Email dispatched for schedule ID: " . $schedule->id);
        }

        return 0;
    }
}
