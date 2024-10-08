<?php

namespace App\Http\Controllers\Client\MyCuts;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Company;
use App\Models\Schedule;
use App\Models\StatusSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MyCutsClientController extends Controller
{

    public function index($tokenCompany):View
    {
        $client = Auth::guard('client')->user();

        $company = Company::where('token', $tokenCompany)->first();

        $statusSchedule = StatusSchedule::where('status', 'Agendado')->first();

        $schedules = Schedule::where('clientfk', $client->id)
            ->where('statusSchedulefk', $statusSchedule->id)
            ->with(['services', 'collaborator'])
            ->orderBy('date')
            ->orderBy('hourStart')
            ->get();

        // Busca todos os colaboradores da empresa
        $collaborators = Collaborator::where('companyfk', $company->id)->get();

        return view('Client.mycutsClient', [
            'tokenCompany' => $tokenCompany,
            'schedules' => $schedules,
            'company' => $company,
            'collaborators' => $collaborators // Passa os colaboradores para a view
        ]);
    }
}
