<?php

namespace App\Http\Controllers\Client\ServiceBySchedule;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;

class ServiceByScheduleController extends Controller
{
    public function index($tokenCompany,$collaboratorId)
    {
        $data = session('dynamicData');

        if (empty($data)) {
            return redirect()->route('scheduleclient',
                ['tokenCompany' => $tokenCompany,
                'collaboratorId' => $collaboratorId])
                ->withErrors('A sessão expirou ou é inválida. Por favor, selecione um horário novamente.');
        }

        $collaborator = Collaborator::where('id', $collaboratorId)->first();

        $services = $collaborator->service;

        return view('Client.serviceFromSchedule', compact('data'),
            [
                'tokenCompany' => $tokenCompany,
                'collaborator' => $collaborator,
                'services' => $services
            ]
        );
    }
}
