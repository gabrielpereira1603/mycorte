<x-layoutClient title="Histórico de Agendamentos" :tokenCompany="$tokenCompany">
    <div class="profile-name">
        <h3>Histórico de Agendamentos</h3>
    </div>

    <section class="section-myCuts">
        <div class="main-myCuts">
            <div class="container mt-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="search-input" class="form-control" placeholder="Pesquisar...">
                    <div class="input-group-append">
                        <select id="filter-select" class="form-select">
                            <option value="all">Todas</option>
                            <option value="date-range">Intervalo de Datas</option>
                            <option value="professional">Profissional</option>
                            <option value="company">Empresa</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
                <p class="search-info">Você pode buscar por qualquer informação relacionada aos agendamentos.</p>
            </div>

            @if($schedules->isEmpty())
                <p class="no-schedules">Você não tem histórico de agendamentos.</p>
            @else
                @foreach($schedules as $schedule)
                    <div class="card-schedule">
                        <div class="status-banner
                                    {{ $schedule->statusSchedule->status === 'Cancelado' ? 'status-cancelled' : '' }}
                                    {{ $schedule->statusSchedule->status === 'Finalizado' ? 'status-completed' : '' }}
                                    {{ $schedule->statusSchedule->status === 'Reagendado' ? 'status-rescheduled' : '' }}">
                            {{ $schedule->statusSchedule->status }}
                        </div>
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
                    </div>
                @endforeach
            @endif
        </div>
    </section>
    <script>
        $(document).ready(function() {
            const fetchSchedules = debounce(function(query, filter) {
                $.ajax({
                    url: "{{ route('search.schedules') }}",
                    type: "GET",
                    data: { query: query, filter: filter },
                    success: function(data) {
                        $('.main-myCuts').html('');
                        if (data.length === 0) {
                            $('.main-myCuts').html('<p>Nenhum agendamento encontrado</p>');
                        } else {
                            $.each(data, function(key, schedule) {
                                var card = `
                                <div class="card-schedule">
                                    <div class="status-banner
                                                ${schedule.statusSchedule.status === 'Cancelado' ? 'status-cancelled' : ''}
                                                ${schedule.statusSchedule.status === 'Finalizado' ? 'status-completed' : ''}
                                                ${schedule.statusSchedule.status === 'Reagendado' ? 'status-rescheduled' : ''}">
                                        ${schedule.statusSchedule.status}
                                    </div>
                                    <div class="info-schedule">
                                        <div class="title-card-myCuts">
                                            <span class="icon-infoChedule-mycuts">
                                                <img src="{{ asset('images/icons/calendarioIcon.png') }}" alt="Icone de Calendario" width="20px">
                                            </span>
                                            <h4>Agendamento em ${schedule.date} às ${schedule.hourStart}</h4>
                                        </div>
                                        <p><strong>Hora de Término:</strong> ${schedule.hourFinal}</p>
                                        <p><strong>Profissional:</strong> ${schedule.collaborator.name}</p>
                                        <p><strong>Empresa:</strong> ${schedule.company.name}</p>
                                    </div>
                                    <div class="services-schedule">
                                        <h5>Serviços:</h5>
                                        <ul>
                                            ${schedule.services.map(service => `
                                                <li>${service.name} - R$ ${service.value}</li>
                                            `).join('')}
                                        </ul>
                                    </div>
                                </div>
                            `;
                                $('.main-myCuts').append(card);
                            });
                        }
                    }
                });
            }, 300);

            function fetchAllSchedules() {
                fetchSchedules('', 'all');
            }

            $('#search-input').on('keyup', function(e) {
                const query = $(this).val();
                const filter = $('#filter-select').val();
                if (e.key === 'Enter' && filter === 'all') {
                    fetchSchedules(query, filter);
                }
            });

            $('#filter-select').on('change', function() {
                const filter = $(this).val();
                if (filter === 'all') {
                    fetchAllSchedules();
                }
            });

            // Initial load for "Todas" filter
            fetchAllSchedules();
        });
    </script>
</x-layoutClient>
