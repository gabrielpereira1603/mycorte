<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index($tokenCompany)
    {
        $today = Carbon::today()->format('Y-m-d');

        $scheduleData = $this->getScheduleData($today, $today);

        $dates = $scheduleData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        });
        $counts = $scheduleData->pluck('count');

        return view('Collaborator.dashboardCollaborator', [
            'tokenCompany' => $tokenCompany,
            'dates' => $dates,
            'counts' => $counts,
            'startDate' => Carbon::today()->format('d-m-Y'),
            'endDate' => Carbon::today()->format('d-m-Y')
        ]);
    }

    public function getScheduleData($startDate, $endDate)
    {
        return DB::table('schedule')
            ->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as count'))
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function fetchScheduleData(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

        $scheduleData = $this->getScheduleData($startDate, $endDate);

        $dates = $scheduleData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        });
        $counts = $scheduleData->pluck('count');

        return response()->json([
            'dates' => $dates,
            'counts' => $counts
        ]);
    }


}
