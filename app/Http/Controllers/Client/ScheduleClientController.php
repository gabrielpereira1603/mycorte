<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Company;

class ScheduleClientController extends Controller
{
    public function index($tokenCompany, $collaboratorId)
    {
        // Substitua essa linha pelo código correto para obter o ID da empresa baseado no token
        $company = Company::where('token', $tokenCompany)->first();
        $idCompany = $company->id; // Ajuste conforme necessário

        return view('Client.scheduleClient',[
                'tokenCompany' => $tokenCompany,
                'collaboratorId' => $collaboratorId,
                'idCompany' => $idCompany
            ]
        );
    }
}
