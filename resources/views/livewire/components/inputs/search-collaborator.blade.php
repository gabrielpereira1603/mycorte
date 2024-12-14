<div class="w-full p-5 transition-all">
    <h2 class="flex justify-center items-start gap-1.5 mb-5 font-semibold text-primary text-gray-200 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start">
        <x-about-icon width="20px" height="20px"/>
        {{ __('Voçê pode busca um colaborador por qualquer informação do colaborador, Exemplo: Nome, Serviços, Status etc...') }}
    </h2>

    <div class="flex items-center">
        <!-- Ícone com fundo branco -->
        <span class="bg-white border border-gray-300 rounded-l-md p-4 flex items-center text-black">
            <x-search-icon width="16px" height="16px"/>
        </span>
        <!-- Campo de busca -->
        <input type="text" id="search-input"
               class="w-full border border-gray-300 border-l-0 rounded-r-md focus:ring-2 focus:ring-blue-500 focus:outline-none p-3"
               placeholder="Pesquisar por nome, telefone ou serviços..."
               wire:model.live="search"
        >

        <!-- Indicador de Carregamento -->
        <div wire:loading.delay class="absolute right-5 text-gray-600">
            Carregando...
        </div>
    </div>
</div>
