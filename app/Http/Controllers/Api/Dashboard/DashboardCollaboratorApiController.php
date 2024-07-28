<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardCollaboratorApiController extends Controller
{
    public function fetchBestServicesData($startDate, $endDate, $collaboratorId)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $services = DB::table('schedule_service')
            ->where('id', $collaboratorId)
            ->join('service', 'schedule_service.service_id', '=', 'service.id')
            ->select('service.name', DB::raw('COUNT(*) as count'))
            ->whereBetween('schedule_service.created_at', [$startDate, $endDate])
            ->groupBy('service.name')
            ->orderBy('count', 'desc')
            ->get();

        $labels = $services->pluck('name');
        $data = $services->pluck('count');

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function fetchScheduleAnalysisData($startDate, $endDate, $collaboratorId)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        // Obter o ID do status "Finalizado"
        $finalizedStatus = DB::table('status_schedule')
            ->where('status', 'Finalizado')
            ->first();

        if (!$finalizedStatus) {
            return response()->json(['error' => 'Status "Finalizado" não encontrado.'], 500);
        }

        $finalizedStatusId = $finalizedStatus->id;

        $daysOfWeek = DB::table('schedule')
            ->select(DB::raw('DAYOFWEEK(date) as day_of_week'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$startDate, $endDate])
            ->where('collaboratorfk', $collaboratorId)
            ->where('statusSchedulefk', $finalizedStatusId) // Adiciona a condição para status "Finalizado"
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->get();

        $labels = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];
        $data = array_fill(0, 7, 0);

        foreach ($daysOfWeek as $day) {
            $data[$day->day_of_week - 1] = $day->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }


    // Método não implementado para análise de faturamento
    public function fetchRevenueAnalysisData($startDate, $endDate, $collaboratorId)
    {
        return response()->json([
            'message' => 'Este endpoint ainda não está implementado.'
        ]);
    }

    public function fetchCanceledAppointmentsData($startDate, $endDate, $collaboratorId)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        // Obter o ID do status "Cancelado"
        $canceledStatus = DB::table('status_schedule')
            ->where('status', 'Cancelado')
            ->first();

        if (!$canceledStatus) {
            return response()->json(['error' => 'Status "Cancelado" não encontrado.'], 500);
        }

        $canceledStatusId = $canceledStatus->id;

        $daysOfWeek = DB::table('schedule')
            ->select(DB::raw('DAYOFWEEK(date) as day_of_week'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$startDate, $endDate])
            ->where('collaboratorfk', $collaboratorId)
            ->where('statusSchedulefk', $canceledStatusId) // Adiciona a condição para status "Cancelado"
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->get();

        $labels = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];
        $data = array_fill(0, 7, 0);

        foreach ($daysOfWeek as $day) {
            $data[$day->day_of_week - 1] = $day->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function fetchRescheduledAppointmentsData($startDate, $endDate, $collaboratorId)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        // Obter o ID do status "Reagendado"
        $rescheduledStatus = DB::table('status_schedule')
            ->where('status', 'Reagendado')
            ->first();

        if (!$rescheduledStatus) {
            return response()->json(['error' => 'Status "Reagendado" não encontrado.'], 500);
        }

        $rescheduledStatusId = $rescheduledStatus->id;

        $daysOfWeek = DB::table('schedule')
            ->select(DB::raw('DAYOFWEEK(date) as day_of_week'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$startDate, $endDate])
            ->where('collaboratorfk', $collaboratorId)
            ->where('statusSchedulefk', $rescheduledStatusId) // Adiciona a condição para status "Reagendado"
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->get();

        $labels = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];
        $data = array_fill(0, 7, 0);

        foreach ($daysOfWeek as $day) {
            $data[$day->day_of_week - 1] = $day->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function fetchTimeAnalysisData($startDate, $endDate, $collaboratorId)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $times = DB::table('schedule')
            ->select(DB::raw('CONCAT(hourStart, "-", hourFinal) as time_range'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$startDate, $endDate])
            ->where('collaboratorfk', $collaboratorId) // Filtra pelo colaborador
            ->groupBy('time_range')
            ->orderBy('count', 'desc')
            ->get();

        $labels = $times->pluck('time_range');
        $data = $times->pluck('count');

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }




}
