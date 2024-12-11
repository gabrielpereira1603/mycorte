<?php

namespace App\Livewire\Components\Inputs;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Company;

class SearchCompany extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $currentDateTime = Carbon::now();

        $companies = Company::with(['style', 'promotions' => function ($query) use ($currentDateTime) {
            $query->where('dataHourStart', '<=', $currentDateTime)
                ->where('dataHourFinal', '>=', $currentDateTime);
        }])
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%')
                    ->orWhere('state', 'like', '%' . $this->search . '%')
                    ->orWhere('neighborhood', 'like', '%' . $this->search . '%');
            })
            ->get();
        // Dispara o evento com as empresas filtradas
        $this->dispatch('companiesFiltered', $companies);
    }

    public function render()
    {

        return view('livewire.components.inputs.search-company');
    }
}
