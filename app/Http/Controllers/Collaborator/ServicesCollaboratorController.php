<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesCollaboratorController extends Controller
{
    public function services($tokenCompany)
    {
        $collaborator = Auth::guard('collaborator')->user();

        $services = Service::where('collaboratorfk', $collaborator->id)->get();

        return view('Collaborator.servicescollaborator', [
            'tokenCompany' => $tokenCompany,
            'services' => $services,
            'collaborator' => $collaborator
        ]);
    }

    public function addService(Request $request, $tokenCompany)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'value' => 'required|numeric'
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
            'name' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'value' => 'required|numeric' // Agora validando como numéricoxw
        ]);

        $service = Service::find($request->service_id);
        $service->name = $request->name;
        $service->time = $request->time;
        $service->value = $request->value;
        $service->save();

        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço atualizado com sucesso!');
    }

}
