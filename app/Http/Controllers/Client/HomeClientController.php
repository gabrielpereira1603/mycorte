<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Company;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class HomeClientController extends Controller
{
    public function index($tokenCompany): View|Factory|Application
    {
        // Encontrar o ID da empresa pelo token
        $company = Company::where('token', $tokenCompany)->first();

        if (!$company) {
            abort(404, 'Empresa não encontrada');
        }

        // Buscar todos os colaboradores com seus serviços e promoções
        $collaborators = Collaborator::with('service', 'promotion') // Assumindo que você tem uma relação 'promotion' no modelo Collaborator
        ->where('companyfk', $company->id) // Filtrar pelos colaboradores da empresa encontrada
        ->get();

        // Formatando os serviços de cada colaborador em uma string separada por vírgulas
        foreach ($collaborators as $collaborator) {
            $services = $collaborator->service->pluck('name')->implode(', ');
            $collaborator->formatted_services = $services;

            // Adicionando as promoções
            $promotions = $collaborator->promotion->pluck('description')->implode(', '); // ou outra lógica para exibir promoções
            $collaborator->formatted_promotions = $promotions;
        }

        return view('Client.homeClient', [
            'tokenCompany' => $tokenCompany,
            'collaborators' => $collaborators,
        ]);
    }

}
