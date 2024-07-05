<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleApiController extends Controller
{
    public function getScheduleData($date, $companyId, $collaboratorId): JsonResponse
    {
        try {
            $schedules = Schedule::where('date', $date)
                ->where('companyfk', $companyId)
                ->where('collaboratorfk', $collaboratorId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar os dados de agendamento.'
            ], 100);
        }
    }

}
