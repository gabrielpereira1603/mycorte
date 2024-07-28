<?php

namespace App\Http\Controllers\Collaborator\Modules\Services;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesCollaboratorController extends Controller
{
    public function services($tokenCompany)
    {
        $collaborator = Auth::guard('collaborator')->user();

        // Filtra os serviços habilitados
        $servicesEnabled = Service::where('collaboratorfk', $collaborator->id)
            ->where('enabled', true) // Adiciona a condição para serviços habilitados
            ->get();

        $servicesDisabled = Service::where('collaboratorfk', $collaborator->id)
            ->where('enabled', false) // Adiciona a condição para serviços habilitados
            ->get();


        return view('Collaborator.Modules.Services.servicescollaborator', [
            'tokenCompany' => $tokenCompany,
            'servicesEnabled' => $servicesEnabled,
            'servicesDisabled' => $servicesDisabled,
            'collaborator' => $collaborator
        ]);
    }
    public function addService(Request $request, $tokenCompany)
    {
        $request->validate([
            'name' => 'required|string|max:255|not_in:0', // Verifica que o nome não está vazio
            'time' => 'required|string|max:255|not_in:00:00', // Verifica que o tempo não é 00:00
            'value' => 'required|numeric|min:0.01' // Verifica que o valor é numérico e maior que 0
        ]);

        $collaborator = Auth::guard('collaborator')->user();

        $service = new Service();
        $service->name = $request->name;
        $service->time = $request->time;
        $service->value = $request->value;
        $service->collaboratorfk = $collaborator->id;
        $service->save();

        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço adicionado com sucesso!');
    }

    public function editService(Request $request, $tokenCompany)
    {
        $request->validate([
            'service_id' => 'required|exists:service,id',
            'name' => 'required|string|max:255|not_in:0', // Verifica que o nome não está vazio
            'time' => 'required|string|max:255|not_in:00:00', // Verifica que o tempo não é 00:00
            'value' => 'required|numeric|min:0.01' // Verifica que o valor é numérico e maior que 0
        ]);

        $service = Service::find($request->service_id);
        $service->name = $request->name;
        $service->time = $request->time;
        $service->value = $request->value;
        $service->save();

        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function deleteService(Request $request, $tokenCompany)
    {
        $serviceId = $request->input('service_id');

        $service = Service::find($serviceId);
        if ($service) {
            $service->update(['enabled' => false]); // ou true para reativar
        }

        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço desativado com sucesso.');
    }

    public function activeService(Request $request, $tokenCompany)
    {
        $serviceId = $request->input('service_id');

        $service = Service::find($serviceId);
        if ($service) {
            $service->update(['enabled' => true]); // ou true para reativar
        }

        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço ativado com sucesso.');
    }
}
