<x-layoutClient title="Início" :tokenCompany="$tokenCompany">
    <div class="title-home" style="background-color: #3a497684;">
        <h3 style="color: white;">Seja Bem Vindo</h3>
        <p style="color: white;">Escolha o profissional para lhe atender:</p>
    </div>
    <section class="container">
        <div class="row">
            @foreach ($collaborators as $collaborator)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom" style="border: solid black 1px;">
                        <div class="profile-collaborator">
                            <img src="{{ $collaborator->image }}" alt="Profile Picture">
                            <h3 class="mt-2">{{ $collaborator->name }}</h3>
                            <p><strong>Serviços:</strong> <span class="services-tooltip" data-tooltip="{{ $collaborator->formatted_services }}">{{ $collaborator->formatted_services }}</span></p>
                        </div>
                        @if ($collaborator->formatted_promotions)
                            <div class="promotion-label animate__animated animate__pulse">Promoção</div>
                        @endif
                        <div class="status">
                            <div class="status-info">
                                <img class="home-status-icon statusTelefone" width="20px" src="{{ asset('images/icons/iconTelephoneColorMyCorte.png') }}" alt="Telefone">
                                <p style="margin-bottom: 0px; font-size: 14px;">{{ $collaborator->telephone }}</p>
                            </div>
                            <div>
                                <div class="status-info">
                                    <p style="margin-bottom: 0px;">{{ $collaborator->enabled ? 'Disponível' : 'Indisponível' }}</p>
                                    <img class="home-status-icon statusOnOF" width="24px" src="{{ $collaborator->enabled ? asset('images/icons/onlineToggleIcon.png') : asset('images/icons/offlineToggleIcon.png') }}" alt="Status">
                                </div>
                            </div>
                        </div>
                        <div class="buttons-home">
                            <a class="btn btn-dark" href="{{--{{ route('services', ['collaboratorId' => $collaborator->id]) }}--}}">Serviços</a>
                            <a class="btn btn-dark" href="{{ route('scheduleclient', ['tokenCompany' => $tokenCompany, 'collaboratorId' => $collaborator->id]) }}">Horários</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layoutClient>
