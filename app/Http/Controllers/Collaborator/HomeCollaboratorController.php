<?php

namespace App\Http\Controllers\Collaborator;

use App\Events\MyEvent;
use App\Events\ScheduleCreated;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        // Disparar o evento
        event(new ScheduleCreated($message = 'teste'));
        // Obtém o colaborador logado
        $collaborator = Auth::guard('collaborator')->user();

        // Obtém a data e hora atual no fuso horário de São Paulo
        $now = Carbon::now('America/Sao_Paulo');
        $oneDayLater = $now->copy()->addDay();

        // Obtém os agendamentos que estão dentro do intervalo de 24 horas e com status 'Agendado'
        $schedules = Schedule::where('collaboratorfk', $collaborator->id)
            ->whereDate('date', '>=', $now->toDateString())
            ->whereDate('date', '<=', $oneDayLater->toDateString())
            ->where('statusSchedulefk', 1) // Filtra pelo status 'Agendado'
            ->where(function ($query) use ($now, $oneDayLater) {
                $query->where(function ($subQuery) use ($now, $oneDayLater) {
                    $subQuery->whereBetween('hourStart', [$now->format('H:i:s'), '23:59:59'])
                        ->orWhereBetween('hourFinal', ['00:00:00', $oneDayLater->endOfDay()->format('H:i:s')]);
                })
                    ->orWhere(function ($subQuery) use ($now, $oneDayLater) {
                        $subQuery->where('hourStart', '<=', $oneDayLater->endOfDay()->format('H:i:s'))
                            ->where('hourFinal', '>=', $now->format('H:i:s'));
                    });
            })
            ->with('client', 'services') // Carrega os clientes e serviços relacionados
            ->get();

        // Filtra os agendamentos que já passaram
        $schedules = $schedules->filter(function ($schedule) use ($now) {
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $schedule->date . ' ' . $schedule->hourStart, 'America/Sao_Paulo');
            return $startDateTime->isAfter($now);
        });

        // Calcula o tempo restante até o início de cada agendamento
        foreach ($schedules as $schedule) {
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $schedule->date . ' ' . $schedule->hourStart, 'America/Sao_Paulo');
            $difference = $now->diff($startDateTime);
            $schedule->timeUntilStart = [
                'hours' => $difference->h,
                'minutes' => $difference->i
            ];
        }

        // Verifica se há agendamentos
        $noSchedulesMessage = $schedules->isEmpty() ? 'Não há agendamentos próximos.' : null;

        // Retorna a visão com os agendamentos
        return view('Collaborator.homecollaborator', [
            'tokenCompany' => $tokenCompany,
            'schedules' => $schedules,
            'noSchedulesMessage' => $noSchedulesMessage
        ]);
    }
}
