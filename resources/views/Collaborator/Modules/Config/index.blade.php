<x-layoutCollaborator title="Configurações" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4 style="color: white">Configurações</h4>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
        <div class="col">
            <div class="card cardAvailability">
                <div class="cardAvailability-header">
                    <h5 class="card-title">
                        <span>
                            <img src="{{ asset('images/icons/tempo-de-trabalhoIcon.png') }}" alt="Icone de Disponibilidade" width="30px">
                        </span>
                        Configurações de Disponibilidade
                        <hr style="margin: 8px 0px">
                    </h5>
                </div>
                <div class="cardAvailability-body">
                    <small class="card-subtitle mb-2 text-muted">
                        Módulo onde você pode alterar: <strong style="text-decoration: underline;font-style: italic;">
                            Horário de Entrada e Saída,
                            Horário de Almoço,
                            Dias da Semana Trabalhados e
                            Intervalo de tempo entre cada serviço.
                        </strong>
                    </small>
                    <form method="get" class="cardAvailability-form">
                        <a href="{{ route('config.availability.edit', ['tokenCompany' => $tokenCompany]) }}" class="btn btn-warning">
                            <span style="margin-right: 5px;"></span>
                            Editar Disponibilidade
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card cardAvailability">
                <div class="cardAvailability-header">
                    <h5 class="card-title">
                        <span>
                            <img src="{{ asset('images/icons/intervalIcon.png') }}" alt="Icone de Intervalo" width="30px">
                        </span>
                        Configurações de Intervalos
                        <hr style="margin: 8px 0px">
                    </h5>
                </div>
                <div class="cardAvailability-body">
                    <small class="card-subtitle mb-2 text-muted">
                        Módulo onde você pode: <strong style="text-decoration: underline;font-style: italic;">
                            Alterar, Cadastrar e Excluir seus Intervalos.
                        </strong>
                    </small>
                    <form method="get" class="cardAvailability-form">
                        <a href="{{ route('config.availability.edit', ['tokenCompany' => $tokenCompany]) }}" class="btn btn-warning">
                            <span style="margin-right: 5px;"></span>
                            Editar Disponibilidade
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layoutCollaborator>
