<?php

namespace App\Http\Controllers\Client\ServiceBySchedule;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Promotion;
use Carbon\Carbon;

class ServiceByScheduleController extends Controller
{
    public function index($tokenCompany, $collaboratorId)
    {
        $data = session('dynamicData');
        if (empty($data)) {
            return redirect()->route('scheduleclient', [
                'tokenCompany' => $tokenCompany,
                'collaboratorId' => $collaboratorId
            ])->withErrors('A sessão expirou ou é inválida. Por favor, selecione um horário novamente.');
        }

        $collaborator = Collaborator::where('id', $collaboratorId)->first();
        $enabledServices = $collaborator->enabledServices;

        // Obtendo promoções relacionadas aos serviços habilitados e válidas no momento atual
        $currentDateTime = Carbon::now();
        $promotions = Promotion::whereIn('servicefk', $enabledServices->pluck('id'))
            ->where('dataHourStart', '<=', $currentDateTime)
            ->where('dataHourFinal', '>=', $currentDateTime)
            ->get();

        // Definindo valores padrão
        $redirectMessageButton = "Voltar aos Horários";
        $redirectButton = route('scheduleclient', ['tokenCompany' => $tokenCompany, 'collaboratorId' => $collaboratorId]); // URL padrão caso não haja redirecionamento específico

        // Verificando se "redirectController" está presente e tem o valor específico
        if (isset($data['redirectController']) &&
            $data['redirectController'] === "http://127.0.0.1:8000/client/reschedule/fee0bdf87366430b6302536ca9f84772305b5cef15859ac9e531328f2deeb390") {
            $redirectMessageButton = "Voltar aos Agendamentos";
            $redirectButton = route('mycutsclient', ['tokenCompany' => $tokenCompany]);
        }

        return view('Client.serviceFromSchedule', compact('data'), [
            'tokenCompany' => $tokenCompany,
            'collaborator' => $collaborator,
            'services' => $enabledServices,
            'promotions' => $promotions, // Passando promoções para a view
            'redirectButton' => $redirectButton,
            'redirectMessage' => $redirectMessageButton,
        ]);
    }

}
