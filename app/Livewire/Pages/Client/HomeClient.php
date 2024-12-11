<?php

namespace App\Livewire\Pages\Client;

use App\Models\Collaborator;
use App\Models\Company;
use App\Models\Promotion;
use Carbon\Carbon;
use Livewire\Component;

class HomeClient extends Component
{
    public Company $company;
    public $collaborator;

    public function mount($tokenCompany)
    {
        $this->company = Company::where('token', $tokenCompany)->first();

        if (!$this->company) {
            $this->dispatch('companiesFiltered', 'Empresa não encontrada');
            abort(404, 'Empresa não encontrada');
        }

        $collaborators = Collaborator::with('service')
        ->where('companyfk', $this->company->id)
        ->get();

        foreach ($collaborators as $collaborator) {
            $services = $collaborator->service->pluck('name')->implode(', ');
            $collaborator->formatted_services = $services;

            $currentDateTime = Carbon::now();
            $promotions = Promotion::where('collaboratorfk', $collaborator->id)
                ->where('dataHourStart', '<=', $currentDateTime)
                ->where('dataHourFinal', '>=', $currentDateTime)
                ->pluck('name')
                ->implode(', ');

           $collaborator->formatted_promotions = $promotions;
        }

        $this->collaborator = $collaborators;
    }

    public function render()
    {
        return view('livewire.pages.client.home-client', [
            'company' => $this->company,
            'collaborators' => $this->collaborator
        ])->layout('layouts.guest');
    }
}
