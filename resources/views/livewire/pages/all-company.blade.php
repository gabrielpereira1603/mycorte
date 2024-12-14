<div>
    <x-slot name="header">
        <h2 class="flex justify-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start">
            <x-barber-icon width="24px" height="24px"/>
            {{ __('Seja Bem-vindo ao MyCorte') }}
        </h2>
    </x-slot>

    <!-- Componente de Busca -->
    <div class="title-home bg-gray-800 rounded-[10px] dark:bg-[#3a497684]">
        <livewire:components.inputs.search-company />
    </div>

    <section class="flex items-center">
        @if ($hasResults)
            <div class="flex justify-center sm:justify-start flex-wrap gap-4" id="company-cards">
            @foreach ($companies as $company)
                <div
                    class="bg-gray-800 rounded-[10px] dark:bg-[#3a497684] transition-all duration-1000 ease-in-out transform opacity-0 scale-90"
                    x-data="{ show: false }"
                    x-init="setTimeout(() => show = true, 100)"
                    x-bind:class="{ 'opacity-100 scale-100': show }"
                >
                <div class="flex flex-col sm:flex sm:flex-col">
                    <!-- Verificação de Promoções -->
                    @if ($company->promotions && $company->promotions->isNotEmpty())
                        <x-promotion-span/>
                    @endif
                    <div class="profile-collaborator flex flex-col items-center p-4 gap-2">
                        <img src="{{ asset('/images/apenasLogo.svg') }}" alt="Profile Picture" class="rounded-[50%]" width="80px" height="80px" style="background: white">
                        <h2 class="flex justify-center items-center gap-1 font-semibold text-xl text-gray-100 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start truncate whitespace-nowrap">
                            <x-barber-icon width="16px" height="16px"/>
                            {{ __($company->name) }}
                        </h2>
                    </div>
                    <div class="status p-4">
                        <ul class="flex flex-col gap-2 ">
                        <li>
                            <h2 class="flex justify-start gap-1 items-center text-gray-100 dark:text-gray-100">
                                <x-city-icon width="16px" height="16px"/>
                                <strong>
                                    Cidade:
                                </strong>
                                {{ __($company->city) }}
                            </h2>
                        </li>
                        <li>

                            <h2 class="flex justify-start gap-1 items-center text-gray-100 dark:text-gray-100">
                                <x-about-icon width="16px" height="16px"/>
                                <strong>
                                    Número:
                                </strong>
                                {{ __($company->number) }}
                            </h2>
                        </li>
                        <li>

                            <h2 class="flex justify-start gap-1 items-center text-gray-100 dark:text-gray-100">
                                <x-street-icon width="16px" height="16px"/>
                                <strong>
                                    Rua:
                                </strong>
                                {{ __($company->road) }}
                            </h2>
                        </li>
                        <li>

                            <h2 class="flex justify-start gap-1 items-center text-gray-100 dark:text-gray-100">
                                <x-state-icon width="16px" height="16px"/>
                                <strong>
                                    Estado:
                                </strong>
                                {{ __($company->state) }}
                            </h2>
                        </li>
                    </ul>
                </div>
                </div>
                    <div class="buttons-home p-3">
                        <x-secondary-button class="flex items-center justify-center gap-1">
                            <x-map-icon width="14px" height="14px"/>
                            {{ __('Localização') }}

                        </x-secondary-button>
                        <a href="{{ route('homeclient', ['tokenCompany' => $company->token]) }}">
                            <x-secondary-button class="flex items-center justify-center gap-1">
                                <x-scheduling-icon width="14px" height="14px"/>
                                {{ __('Agendar') }}
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <div class="flex flex-col items-center justify-center text-center p-6 mt-5 bg-gray-700 rounded-lg shadow-md w-full">
                <x-sad-icon width="48px" height="48px"/>
                <h2 class="mt-4 text-xl font-semibold text-gray-100">{{ __('Nenhuma empresa encontrada') }}</h2>
                <p class="mt-2 text-gray-300">
                    {{ __('Não encontramos resultados para os filtros selecionados. Tente usar outros termos ou ajustar sua pesquisa.') }}
                </p>
            </div>
        @endif
    </section>

</div>

