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
                        <div class="info-schedule">
                            <div class="title-card-myCuts">
                                <span class="icon-infoChedule-mycuts">
                                    <img src="{{ asset('images/icons/calendarioIcon.png') }}" alt="Icone de Calendario" width="20px">
                                </span>
                                <h4>Agendamento em {{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }} às {{ $schedule->hourStart }}</h4>
                            </div>
                            <p><strong>Hora de Término:</strong> {{ $schedule->hourFinal }}</p>
                            <p><strong>Status:</strong> Agendado</p>
                            <p><strong>Colaborador:</strong> {{ $schedule->collaborator->name }}</p>
                            <p><strong>Empresa:</strong> {{ $schedule->company->name }}</p>
                        </div>
                        <div class="services-schedule">
                            <h5>Serviços:</h5>
                            <ul style="margin-top: 0">
                                @foreach($schedule->services as $service)
                                    <li>{{ $service->name }} - R$ {{ number_format($service->value, 2, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="map-container">
                            <p class="map-title">Como Chegar:</p>
                            {!! $company->localization !!}
                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <script>
        function cancelAppointment(scheduleId) {
        }

        function rescheduleAppointment(scheduleId) {
        }
    </script>
</x-layoutClient>
<div class="action-buttons">
    <button type="button" class="btn btn-danger" onclick="cancelAppointment({{ $schedule->id }})">Cancelar</button>
    <button type="button" class="btn btn-warning" onclick="rescheduleAppointment({{ $schedule->id }})">Reagendar</button>
</div>
