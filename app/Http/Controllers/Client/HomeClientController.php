<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Company;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomeClientController extends Controller
{
    public function index($tokenCompany): View|Factory|Application
    {
        // Encontrar o ID da empresa pelo token
        $company = Company::where('token', $tokenCompany)->first();

        if (!$company) {
            abort(404, 'Empresa não encontrada');
        }

        // Buscar todos os colaboradores com seus serviços
        $collaborators = Collaborator::with('service')
            ->where('companyfk', $company->id) // Filtrar pelos colaboradores da empresa encontrada
            ->get();

        // Formatando os serviços de cada colaborador em uma string separada por vírgulas
        foreach ($collaborators as $collaborator) {
            $services = $collaborator->service->pluck('name')->implode(', ');
            $collaborator->formatted_services = $services;
        }

        // Debug para verificar os colaboradores e serviços
        // var_dump($collaborators);

        return view('Client.homeClient', [
            'tokenCompany' => $tokenCompany,
            'collaborators' => $collaborators,
        ]);
    }
}
