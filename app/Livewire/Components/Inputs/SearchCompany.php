<?php

namespace App\Livewire\Components\Inputs;

use Livewire\Component;

class SearchCompany extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="w-full">
            <div class="flex items-center gap-2 p-5" >
                <span class="input-group-text">
                <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" id="search-input" class="w-full" placeholder="Pesquisar...">
            </div>
            <p class="search-info">Você pode buscar por qualquer informação relacionada às empresas parceiras.</p>
            <div id="loading-spinner" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        HTML;
    }
}
