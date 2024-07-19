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

}
