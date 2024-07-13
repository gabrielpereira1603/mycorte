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
            ->whereHas('statusSchedule', function ($query) {
                $query->where('status', '!=', 'Agendado');
            })
            ->with(['services', 'collaborator', 'statusSchedule'])
            ->orderBy('date', 'desc')
            ->orderBy('hourStart', 'desc')
            ->get();

        return view('Client.myhistoriccutsClient', ['tokenCompany' => $tokenCompany, 'schedules' => $schedules, 'company' => $company]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $client = Auth::guard('client')->user();

        $schedules = Schedule::where('clientfk', $client->id)
            ->whereDoesntHave('statusSchedule', function ($query) {
                $query->where('status', 'Agendado');
            })
            ->where(function ($q) use ($query) {
                $q->where('date', 'like', '%' . $query . '%')
                    ->orWhere('hourStart', 'like', '%' . $query . '%')
                    ->orWhereHas('collaborator', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('company', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->with(['services', 'collaborator', 'statusSchedule'])
            ->orderBy('date', 'desc')
            ->orderBy('hourStart', 'desc')
            ->get();

        return response()->json($schedules);
    }

}
