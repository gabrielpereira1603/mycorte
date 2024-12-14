<?php

namespace App\Livewire\Components\Inputs;

use App\Models\Collaborator;
use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;

class SearchCollaborator extends Component
{
    public $search = '';
    public $tokenCompany = '';

    public function mount($tokenCompany)
    {
        $this->tokenCompany = $tokenCompany;
    }
    public function updatedSearch()
    {
        $currentDateTime = Carbon::now();

        $company = Company::where('token', $this->tokenCompany)->first();

        if (!$company) {
            return;
        }

        $collaborators = Collaborator::with([
            'service' => function ($query) {
                if ($this->search) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                }
            },
            'promotion' => function ($query) use ($currentDateTime) {
                $query->where('dataHourStart', '<=', $currentDateTime)
                    ->where('dataHourFinal', '>=', $currentDateTime);

                if ($this->search) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                }
            }
        ])
            ->where('companyfk', $company->id)
            ->when($this->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('telephone', 'like', '%' . $search . '%');
                });
            })
            ->get();

        foreach ($collaborators as $collaborator) {
            $collaborator->formatted_services = $collaborator->service->pluck('name')->implode(', ');
            $collaborator->formatted_promotions = $collaborator->promotion->pluck('name')->implode(', ');
        }

        // Dispara o evento com as empresas filtradas
        $this->dispatch('collaboratorsFiltered', $collaborators);
    }

    public function render()
    {
        return view('livewire.components.inputs.search-collaborator');
    }
}
