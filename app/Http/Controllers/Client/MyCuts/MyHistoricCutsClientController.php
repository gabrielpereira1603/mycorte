<?php

namespace App\Http\Controllers\Client\MyCuts;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyHistoricCutsClientController extends Controller
{
    public function index($tokenCompany): View
    {
        $client = Auth::guard('client')->user();

        $company = Company::where('token', $tokenCompany)->first();

        $schedules = Schedule::where('clientfk', $client->id)
            ->with(['services', 'collaborator', 'statusSchedule'])
            ->orderBy('date', 'desc')
            ->orderBy('hourStart', 'desc')
            ->get();

        return view('Client.myhistoriccutsClient', ['tokenCompany' => $tokenCompany, 'schedules' => $schedules, 'company' => $company]);
    }

}
