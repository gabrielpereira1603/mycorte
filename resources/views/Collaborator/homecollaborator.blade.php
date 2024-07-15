<x-layoutCollaborator title="Início" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Bem Vindo {{$collaborator->name}}</h4>
    </div>

    <!-- Verifica se há agendamentos -->
    @if(isset($noSchedulesMessage))
        <div class="alert alert-info">
            <i class="bi bi-sad"></i> {{ $noSchedulesMessage }}
        </div>
    @else
        <!-- Card para Notificações -->
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header">
                Próximos Atendimentos
            </div>
            <div class="card-body">
                @foreach($schedules as $schedule)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="{{ $schedule->client->image }}" class="rounded me-2" alt="Foto do Cliente" width="50px" height="50px">
                            <div class="card-info">
                                <strong class="me-auto truncate">{{ $schedule->client->name }}</strong>
                                <div class="card-date">
                                    <small>
                                        <i class="fa-solid fa-calendar-days"></i>
                                        {{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }}
                                    </small>
                                    <small>
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $schedule->hourStart }} - {{ $schedule->hourFinal }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="toast-body">
                            @foreach($schedule->services as $service)
                                <div class="value-service">
                                    <p>
                                        <i class="fa-solid fa-scissors"></i>
                                        Serviço: {{ $service->name }}
                                    </p>
                                    <p>
                                        <i class="fa-solid fa-sack-dollar"></i>
                                        Valor: R$ {{ $service->value }}
                                    </p>
                                </div>
                                <hr>
                            @endforeach
                            <div class="box-buttons">
                                <button class="btn btn-warning"><i class="fa-solid fa-bell"></i> Lembrar Cliente</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Inclua o JavaScript do Bootstrap -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                var bsToast = new bootstrap.Toast(toast, {
                    autohide: false,
                });
                bsToast.show();
            });
        });
    </script>
</x-layoutCollaborator>
