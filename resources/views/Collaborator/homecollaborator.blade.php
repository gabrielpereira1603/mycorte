<x-layoutCollaborator title="Início" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Bem-Vindo, {{ $collaborator->name }}!</h4>
    </div>

    @if(isset($noSchedulesMessage))
    <div class="card" style="width: 100%; margin: 20px auto;">
        <div class="card-header">
            Próximos Atendimentos
        </div>

        <div class="card-body" style="display: flex; flex-direction: column;justify-content: center;align-items: center">
            <img src="{{ asset('images/icons/emojiSadIcon.png') }}" alt="Emoji Triste" width="200">
            <p style="text-align: center; color: #9C9C9C">Nenhum atendimento nas proximas 24 horas</p>
        </div>
        @else
            <!-- Card para Notificações -->
            <div class="card" style="width: 100%; margin: 20px auto;">
                <div class="card-header">
                    Próximos Atendimentos
                </div>
                <div class="card-body" id="schedules-container">
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
                                    <button class="btn btn-warning remind-client-btn" data-schedule-id="{{ $schedule->id }}">
                                        <i class="fa-solid fa-bell"></i> Lembrar Cliente
                                    </button>

                                    <small id="timer-{{ $schedule->id }}" class="timer"></small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toasts = document.querySelectorAll('.toast');
                toasts.forEach(function(toast) {
                    var bsToast = new bootstrap.Toast(toast, {
                        autohide: false,
                    });
                    bsToast.show();
                });

                // Adiciona evento de clique aos botões "Lembrar Cliente"
                var remindClientButtons = document.querySelectorAll('.remind-client-btn');
                remindClientButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var scheduleId = this.getAttribute('data-schedule-id');
                        sendReminderEmail(scheduleId);
                    });
                });

                // Inicializa os timers
                @foreach($schedules as $schedule)
                startTimer('{{ $schedule->id }}', {{ $schedule->timeUntilStart['hours'] }}, {{ $schedule->timeUntilStart['minutes'] }});
                @endforeach

                // Configuração do Pusher
                Pusher.logToConsole = true;

                var pusher = new Pusher('5d7bf54f12d3762e40fb', {
                    cluster: 'sa1'
                });

                var channel = pusher.subscribe('my-channel');
                channel.bind('my-event', function(data) {
                    console.log('Event received:', data);

                    // Cria e adiciona um novo toast
                    var newToast = document.createElement('div');
                    newToast.className = 'toast';
                    newToast.role = 'alert';
                    newToast.setAttribute('aria-live', 'assertive');
                    newToast.setAttribute('aria-atomic', 'true');
                    newToast.innerHTML = `
                        <div class="toast-header">
                            <img src="${data.clientImage}" class="rounded me-2" alt="Foto do Cliente" width="50px" height="50px">
                            <div class="card-info">
                                <strong class="me-auto truncate">${data.clientName}</strong>
                                <div class="card-date">
                                    <small>
                                        <i class="fa-solid fa-calendar-days"></i>
                                        ${data.scheduleDate}
                                    </small>
                                    <small>
                                        <i class="fa-regular fa-clock"></i>
                                        ${data.scheduleStartHour} - ${data.scheduleEndHour}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="toast-body">
                            ${data.services.map(service => `
                                <div class="value-service">
                                    <p>
                                        <i class="fa-solid fa-scissors"></i>
                                        Serviço: ${service.name}
                                    </p>
                                    <p>
                                        <i class="fa-solid fa-sack-dollar"></i>
                                        Valor: R$ ${service.value}
                                    </p>
                                </div>
                                <hr>
                            `).join('')}
                            <div class="box-buttons">
                                <button class="btn btn-warning remind-client-btn" data-schedule-id="${data.scheduleId}">
                                    <i class="fa-solid fa-bell"></i> Lembrar Cliente
                                </button>
                                <small id="timer-${data.scheduleId}" class="timer"></small>
                            </div>
                        </div>
                    `;
                    document.getElementById('schedules-container').appendChild(newToast);

                    // Inicializa o novo toast
                    var bsToast = new bootstrap.Toast(newToast, {
                        autohide: false,
                    });
                    bsToast.show();

                    // Inicializa o timer para o novo agendamento
                    startTimer(data.scheduleId, data.hoursUntilStart, data.minutesUntilStart);
                });

                channel.bind('pusher:subscription_succeeded', function() {
                    console.log('Subscription succeeded');
                });

                channel.bind('pusher:subscription_error', function(status) {
                    console.error('Subscription error:', status);
                });
            });

            function startTimer(scheduleId, hours, minutes) {
                var timerElement = document.getElementById('timer-' + scheduleId);
                var totalMinutes = (hours * 60) + minutes;
                var timer = totalMinutes * 60;

                function updateTimer() {
                    var hours = Math.floor(timer / 3600);
                    var minutes = Math.floor((timer % 3600) / 60);
                    var seconds = timer % 60;

                    timerElement.innerText = `Faltam ${hours}h ${minutes}m ${seconds}s`;

                    if (timer > 0) {
                        timer--;
                    } else {
                        timerElement.innerText = "Começando agora";
                    }
                }

                updateTimer();
                setInterval(updateTimer, 1000);
            }

            function sendReminderEmail(scheduleId) {
                fetch(`/send-reminder/${scheduleId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        scheduleId: scheduleId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Lembrete enviado com sucesso!');
                        } else {
                            alert('Falha ao enviar lembrete.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }
        </script>
    </div>
</x-layoutCollaborator>
