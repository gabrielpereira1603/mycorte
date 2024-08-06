<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TotalScheduleApiController extends Controller
{
    public function getTotalSchedule($collaboratorId, $startDate, $endDate)
    {
        $schedules = Schedule::where('collaboratorfk', $collaboratorId)
            ->whereBetween('date', [$startDate, $endDate])
            ->with(['client', 'services', 'collaborator'])
            ->get();

        return response()->json($schedules);
    }
}
