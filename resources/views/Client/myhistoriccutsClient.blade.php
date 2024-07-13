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
                <div id="loading-spinner" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
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
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this, args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            const fetchSchedules = debounce(function(query) {
                $('#loading-spinner').removeClass('d-none');  // Mostrar o spinner
                $('#search-input').prop('disabled', true);    // Desativar o campo de entrada

                $.ajax({
                    url: "{{ route('search.schedules') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        renderSchedules(data);
                    },
                    error: function() {
                        handleAjaxError();
                    }
                });
            }, 300);

            const fetchAllSchedules = function() {
                $('#loading-spinner').removeClass('d-none');  // Mostrar o spinner
                $('#search-input').prop('disabled', true);    // Desativar o campo de entrada

                $.ajax({
                    url: "{{ route('all.schedules', ['tokenCompany' => $tokenCompany]) }}",
                    type: "GET",
                    success: function(data) {
                        renderSchedules(data);
                    },
                    error: function() {
                        handleAjaxError();
                    }
                });
            };

            function renderSchedules(data) {
                $('#schedules-container').html('');
                if (data.length === 0) {
                    $('#schedules-container').html('<p>Nenhum agendamento encontrado</p>');
                } else {
                    $.each(data, function(key, schedule) {
                        var scheduleCard = `
                    <div class="schedule-card">
                        <!-- Estrutura do card de agendamento -->
                        <h4>${schedule.client_name}</h4>
                        <p>${schedule.date}</p>
                        <p>${schedule.service}</p>
                    </div>
                `;
                        $('#schedules-container').append(scheduleCard);
                    });
                }
                $('#loading-spinner').addClass('d-none');  // Esconder o spinner
                $('#search-input').prop('disabled', false); // Ativar o campo de entrada
            }

            function handleAjaxError() {
                $('#loading-spinner').addClass('d-none');  // Esconder o spinner em caso de erro
                $('#search-input').prop('disabled', false); // Ativar o campo de entrada
                $('#schedules-container').html('<p>Ocorreu um erro ao carregar os agendamentos.</p>');
            }

            $('#search-input').on('keyup', function() {
                const query = $(this).val();
                const filter = $('#filter-select').val();
                if (filter !== 'all') {
                    fetchSchedules(query);
                }
            });

            $('#filter-select').on('change', function() {
                const filter = $(this).val();
                if (filter === 'all') {
                    $('#search-input').prop('disabled', true);  // Desativar o campo de entrada
                    fetchAllSchedules();
                } else {
                    $('#search-input').prop('disabled', false); // Ativar o campo de entrada
                    const query = $('#search-input').val();
                    fetchSchedules(query);
                }
            });

            // Carregar todos os agendamentos ao carregar a página, sem mostrar o spinner
            $('#search-input').prop('disabled', true); // Desativar o campo de entrada
            fetchAllSchedules();
        });


    </script>
</x-layoutClient>
