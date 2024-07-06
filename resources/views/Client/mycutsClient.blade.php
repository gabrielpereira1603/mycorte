<x-layoutClient title="Meus Cortes" :tokenCompany="$tokenCompany">
    <div class="profile-name">
        <h3>Meus Agendamentos</h3>
    </div>

    <section class="section-myCuts">
        <div class="main-myCuts">
            @if($schedules->isEmpty())
                <p class="no-schedules">Você não tem agendamentos.</p>
            @else
                @foreach($schedules as $schedule)
                    <div class="card-schedule">
                        <div class="status-banner">Agendado</div>
                        <div class="info-schedule">
                            <div class="title-card-myCuts">
                                <span class="icon-infoChedule-mycuts">
                                    <img src="{{ asset('images/icons/calendarioIcon.png') }}" alt="Icone de Calendario" width="20px">
                                </span>
                                <h4>Agendamento em {{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }} às {{ $schedule->hourStart }}</h4>
                            </div>
                            <p><strong>Hora de Término:</strong> {{ $schedule->hourFinal }}</p>
                            <p><strong>Profissional:</strong> {{ $schedule->collaborator->name }}</p>
                            <p><strong>Empresa:</strong> {{ $schedule->company->name }}</p>
                        </div>
                        <div class="services-schedule">
                            <h5>Serviços:</h5>
                            <ul>
                                @foreach($schedule->services as $service)
                                    <li>{{ $service->name }} - R$ {{ number_format($service->value, 2, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="map-container">
                            <p class="map-title">Como Chegar:</p>
                            {!! $company->localization !!}
                        </div>
                        <div class="action-buttons">
                            <form id="cancel-form-{{ $schedule->id }}" action="{{ route('cancel.schedule', ['tokenCompany' => $tokenCompany, 'scheduleId' => $schedule->id]) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <button type="button" class="btn btn-danger" onclick="confirmCancel({{ $schedule->id }})">Cancelar</button>
                            <button type="button" class="btn btn-warning" onclick="rescheduleAppointment({{ $schedule->id }})">Reagendar</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCancel(scheduleId) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você realmente deseja cancelar este agendamento?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, cancelar!',
                cancelButtonText: 'Não, manter'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-form-' + scheduleId).submit();
                }
            });
        }

        function rescheduleAppointment(scheduleId) {
            // Função para reagendar o agendamento
        }
    </script>
</x-layoutClient>
