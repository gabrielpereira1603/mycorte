<div>

    <x-slot name="header">
        <h2 class="flex justify-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start">
            <x-barber-icon width="24px" height="24px"/>
            {{ __('Seja Bem-vindo a') }} {{ $company->name }} {{ __(', Escolha o profissional para lhe atender:') }}
        </h2>

    </x-slot>
    <div class="title-home bg-gray-800 rounded-[10px] dark:bg-[#3a497684]">
        <livewire:components.inputs.search-collaborator :tokenCompany="$company->token" />
    </div>

    <section class="flex items-center">
        <div class="flex justify-center sm:justify-start flex-wrap gap-4">
            @foreach ($collaborators as $collaborator)
                <div class="col-md-6 col-lg-4">
                    <div
                        class="h-[35 0px] w-[300px] bg-gray-800 rounded-[10px] dark:bg-[#3a497684] transition-all duration-1000 ease-in-out transform opacity-0 scale-90"
                        x-data="{ show: false }"
                        x-init="setTimeout(() => show = true, 100)"
                        x-bind:class="{ 'opacity-100 scale-100': show }"
                    >

                        <div class="flex flex-col items-center p-4 gap-2">
                            <img src="{{ $collaborator->image }}" alt="Profile Picture" class="rounded-[50%]" style="background: white; width: 70px; height: 70px">

                            <h2 class="flex justify-center text-ellipsis overflow-hidden items-center gap-1 font-semibold text-xl text-gray-100 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start truncate whitespace-nowrap">
                                <x-barber-icon width="16px" height="16px"/>
                                {{ __($collaborator->name) }}
                            </h2>

                            <!-- Serviços formatadoos por , -->
                            <h2 class="flex justify-start gap-1 items-center text-gray-100 dark:text-gray-100 relative" x-data="{ show: false }">
                                <span
                                    class="truncate max-w-[250px] text-ellipsis overflow-hidden whitespace-nowrap cursor-pointer"
                                    @mouseenter="show = true"
                                    @mouseleave="show = false"
                                >
                                    <strong>Serviços:</strong>
                                    {{ $collaborator->formatted_services }}
                                </span>

                                <!-- Caixa de hover dos Seriços -->
                                <div
                                    x-show="show"
                                    class="absolute left-0 top-6 w-[300px] max-w-xs p-2 text-sm text-gray-100 bg-gray-700 rounded shadow-lg transition-transform duration-300"
                                    x-transition:enter="transform scale-90 opacity-0"
                                    x-transition:enter-end="transform scale-100 opacity-100"
                                    x-transition:leave="transform scale-100 opacity-100"
                                    x-transition:leave-end="transform scale-90 opacity-0"
                                    style="display: none;"
                                >
                                    {{ $collaborator->formatted_services }}
                                </div>
                            </h2>

                        </div>

                        @if ($collaborator->formatted_promotions)
                            <x-promotion-span/>
                        @endif

                        <div class="flex items-center justify-center gap-10">

                            <h2 class="flex hover:underline cursor-pointer justify-start gap-1 items-center text-gray-100 dark:text-gray-100">
                                <x-phone-icon width="16px" height="16px"/>
                                {{ $collaborator->telephone }}
                            </h2>

                            <h2 class="flex justify-start gap-1 items-center text-gray-100 dark:text-gray-100">
                                @if($collaborator->enabled)
                                    <x-on-icon width="16px" height="16px" color="green"/>
                                @else
                                    <x-off-icon width="16px" height="16px" color="red"/>
                                @endif
                                {{ $collaborator->enabled ? 'Disponível' : 'Indisponível' }}
                            </h2>
                        </div>
                        <div class="flex items-center justify-center w-full gap-3 mt-3 pb-3">
                            <a class="btn btn-dark" href="">
                                <x-secondary-button class="flex items-center gap-1.5">
                                    <x-cut-icon width="14px" height="14px" color="currentColor"/>
                                    Serviços
                                </x-secondary-button>
                            </a>
                            <a href="{{ route('scheduleclient', ['tokenCompany' => $company->token, 'collaboratorId' => $collaborator->id]) }} ">
                                <x-secondary-button class="flex items-center gap-1.5">
                                    <x-schedule-icon width="14px" height="14px" color="currentColor"/>
                                    Horários
                                </x-secondary-button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
