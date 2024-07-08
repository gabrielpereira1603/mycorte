<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ScheduleApiController extends Controller
{
    public function getScheduleData($date, $companyId, $collaboratorId): JsonResponse
    {
        try {
            $schedules = Schedule::with('statusSchedule')
                ->where('date', $date)
                ->where('companyfk', $companyId)
                ->where('collaboratorfk', $collaboratorId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ]);
        } catch (\Exception $e) {
            // Log do erro para análise posterior
            Log::error('Erro ao buscar os dados de agendamento: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar os dados de agendamento.'
            ], 500);
        }
    }
}
