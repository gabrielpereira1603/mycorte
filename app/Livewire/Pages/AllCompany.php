<?php

namespace App\Livewire\Pages;

use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

class AllCompany extends Component
{
    public $companies = [];

    #[On('companiesFiltered')]
    public function handleCompaniesFiltered($companies)
    {
        if (is_array($companies)) {
            $this->companies = collect($companies)->map(function ($company) {
                return Company::find($company['id']);
            });
        } else {
            $this->companies = $companies;
        }

    }
    public function render()
    {
        $currentDateTime = Carbon::now();

        if (empty($this->companies)) {
            $this->companies = Company::with(['style', 'promotions' => function ($query) use ($currentDateTime) {
                $query->where('dataHourStart', '<=', $currentDateTime)
                    ->where('dataHourFinal', '>=', $currentDateTime);
            }])->get();
        }

        return view('livewire.pages.all-company', [
            'companies' => $this->companies,
            'hasResults' => $this->companies->isNotEmpty(),
        ])->layout('layouts.guest');
    }

}
