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
        // Obtém o colaborador logado
        $collaborator = Auth::guard('collaborator')->user();

        // Obtém os serviços do colaborador logado
        $services = Service::where('collaboratorfk', $collaborator->id)->get();

        // Retorna a visão com os serviços
        return view('Collaborator.servicescollaborator', [
            'tokenCompany' => $tokenCompany,
            'services' => $services,
            'collaborator' => $collaborator
        ]);
    }

    public function addService(Request $request, $tokenCompany)
    {
        // Valida os dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'value' => 'required|numeric' // Agora validando como numérico
        ]);

        // Obtém o colaborador logado
        $collaborator = Auth::guard('collaborator')->user();

        // Cria um novo serviço
        $service = new Service();
        $service->name = $request->name;
        $service->time = $request->time;
        $service->value = $request->value;
        $service->collaboratorfk = $collaborator->id;
        $service->save();

        // Redireciona de volta para a página de serviços com uma mensagem de sucesso
        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço adicionado com sucesso!');
    }

    public function editService(Request $request, $tokenCompany)
    {
        // Valida os dados do formulário
        $request->validate([
            'service_id' => 'required|exists:service,id',
            'name' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'value' => 'required|numeric' // Agora validando como numérico
        ]);

        // Obtém o serviço e atualiza os dados
        $service = Service::find($request->service_id);
        $service->name = $request->name;
        $service->time = $request->time;
        $service->value = $request->value;
        $service->save();

        // Redireciona de volta para a página de serviços com uma mensagem de sucesso
        return redirect()->route('servicescollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Serviço atualizado com sucesso!');
    }

}
