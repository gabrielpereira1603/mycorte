<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        // Obtém o colaborador logado
        $collaborator = Auth::guard('collaborator')->user();

        // Obtém a data e hora atual
        $now = Carbon::now('America/Sao_Paulo'); // Ajuste o fuso horário conforme necessário
        $oneDayLater = $now->copy()->addDay();


        // Obtém os agendamentos que estão dentro do intervalo de 24 horas
        $schedules = Schedule::where('collaboratorfk', $collaborator->id)
            ->whereDate('date', '>=', $now->toDateString())
            ->whereDate('date', '<=', $oneDayLater->toDateString())
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

        // Verifica se há agendamentos
        if ($schedules->isEmpty()) {
            return view('Collaborator.homecollaborator', [
                'tokenCompany' => $tokenCompany,
                'noSchedulesMessage' => 'Não há agendamentos próximos.'
            ]);
        }

        // Retorna a visão com os agendamentos
        return view('Collaborator.homecollaborator', [
            'tokenCompany' => $tokenCompany,
            'schedules' => $schedules
        ]);
    }
}
