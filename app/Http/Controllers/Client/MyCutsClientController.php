<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\StatusSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyCutsClientController extends Controller
{

    public function index($tokenCompany):View
    {
        $client = Auth::guard('client')->user();

        $statusSchedule = StatusSchedule::where('status', 'Agendado')->first();

        $schedules = Schedule::where('clientfk', $client->id)
            ->where('statusSchedulefk', $statusSchedule->id)
            ->with('services')
            ->get();

        return view('Client.mycutsClient', ['tokenCompany' => $tokenCompany, 'schedules' => $schedules]);
    }
}
