<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardCollaboratorApiController extends Controller
{
    public function fetchBestServicesData($startDate, $endDate, $collaboratorId)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $services = DB::table('schedule_service')
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

        $daysOfWeek = DB::table('schedule')
            ->select(DB::raw('DAYOFWEEK(date) as day_of_week'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$startDate, $endDate])
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
}
