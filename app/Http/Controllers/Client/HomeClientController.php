<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Company;
use App\Models\Promotion;
use Carbon\Carbon;
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

        // Buscar todos os colaboradores com seus serviços
        $collaborators = Collaborator::with('service')
            ->where('companyfk', $company->id) // Filtrar pelos colaboradores da empresa encontrada
            ->get();

        // Formatando os serviços de cada colaborador em uma string separada por vírgulas
        foreach ($collaborators as $collaborator) {
            $services = $collaborator->service->pluck('name')->implode(', ');
            $collaborator->formatted_services = $services;

            // Buscar promoções válidas para o colaborador
            $currentDateTime = Carbon::now();
            $promotions = Promotion::where('collaboratorfk', $collaborator->id)
                ->where('dataHourStart', '<=', $currentDateTime)
                ->where('dataHourFinal', '>=', $currentDateTime)
                ->pluck('name')
                ->implode(', ');

            $collaborator->formatted_promotions = $promotions;
        }

        return view('Client.homeClient', [
            'tokenCompany' => $tokenCompany,
            'collaborators' => $collaborators,
        ]);
    }


}
