<div>
    <x-slot name="header">
        <h2 class="flex justify-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start">
            <x-barber-icon width="24px" height="24px"/>
            {{ __('Seja Bem-vindo ao MyCorte') }}
        </h2>
    </x-slot>

    <!-- Componente de Busca -->
    <div class="title-home bg-[#3a497684] rounded-[10px]">
        <livewire:components.inputs.search-company />
    </div>

    <section class="container mt-4">
        <div class="row" id="company-cards">
            @foreach ($companies as $company)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom">
                        <!-- Verificação de Promoções -->
                        @if ($company->promotions && $company->promotions->isNotEmpty())
                            <div class="promotion-label animate__animated animate__pulse">Promoção</div>
                        @endif
                        <div class="profile-collaborator">
                            <img src="{{ $company->style->logo }}" alt="Profile Picture">
                            <h3 class="mt-2">{{ $company->name }}</h3>
                        </div>
                        <div class="status">
                            <ul class="list-address">
                                <li><strong>Cidade:</strong> {{ $company->city }}</li>
                                <li><strong>Número:</strong> {{ $company->number }}</li>
                                <li><strong>Bairro:</strong> {{ $company->neighborhood }}</li>
                                <li><strong>Estado:</strong> {{ $company->state }}</li>
                            </ul>
                        </div>
                        <div class="buttons-home">
                            <button class="btn btn-dark btn-map" data-bs-toggle="modal" data-bs-target="#localizationModal" data-localization="{{ $company->localization }}">Localização</button>
                            <a class="btn btn-dark" href="{{ route('homeclient', ['tokenCompany' => $company->token]) }}">Agendar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
