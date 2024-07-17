<x-layoutCollaborator title="Início" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Bem-Vindo, {{ $collaborator->name }}!</h4>
    </div>

    @if(isset($noSchedulesMessage))
        <!-- Exibe mensagem de nenhum agendamento -->
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header">
                Próximos Atendimentos
            </div>

            <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <img src="{{ asset('images/icons/emojiSadIcon.png') }}" alt="Emoji Triste" width="200">
                <p style="text-align: center; color: #9C9C9C">Nenhum atendimento nas próximas 24 horas</p>
            </div>
        </div>
    @else
        <!-- Card para Notificações -->
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header">
                Próximos Atendimentos
            </div>
            <div class="card-body" id="schedules-container">
                @foreach($schedules as $schedule)
                    <div class="toast" id="toast-{{ $schedule->id }}" role="alert" aria-live="assertive" aria-atomic="true" data-schedule-id="{{ $schedule->id }}">
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
            var soundEnabled = localStorage.getItem('audio-permission') === 'granted';
            var enableSoundButton = document.getElementById('enable-sound');
            var notificationSound = document.getElementById('notification-sound');
            var cancelledSound = document.getElementById('cancelled-sound');

            function requestAudioPermission() {
                Swal.fire({
                    title: 'Permissão para Notificações',
                    text: "Deseja autorizar o uso de áudio para notificações?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, autorizar',
                    cancelButtonText: 'Não, obrigado',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        notificationSound.play().then(() => {
                            localStorage.setItem('audio-permission', 'granted');
                            soundEnabled = true;
                        }).catch((error) => {
                            console.error('Erro ao solicitar permissão de áudio:', error);
                            localStorage.setItem('audio-permission', 'denied');
                        });
                    } else {
                        localStorage.setItem('audio-permission', 'denied');
                    }
                });
            }

            if (!soundEnabled) {
                requestAudioPermission();
            }

            // Inicializa os toasts existentes
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

            // Inicializa os timers para os agendamentos
            @foreach($schedules as $schedule)
            startTimer('{{ $schedule->id }}', {{ $schedule->timeUntilStart['hours'] }}, {{ $schedule->timeUntilStart['minutes'] }});
            @endforeach

            // Configuração do Pusher
            Pusher.logToConsole = true;

            var pusher = new Pusher('5d7bf54f12d3762e40fb', {
                cluster: 'sa1'
            });

            var channel = pusher.subscribe('schedule');
            channel.bind('cancelled-schedule', function(data) {
                if (soundEnabled) {
                    cancelledSound.currentTime = cancelledSound.duration; // Vai para o final do arquivo
                    cancelledSound.play().catch(function(error) {
                        console.error('Erro ao tentar reproduzir o som de cancelado:', error);
                    });
                }

                var scheduleId = data.scheduleId;
                var scheduleCard = document.querySelector(`.toast[data-schedule-id="${scheduleId}"]`);

                if (scheduleCard) {
                    scheduleCard.classList.add('fade-out');
                    setTimeout(function() {
                        scheduleCard.remove();
                        checkForNoSchedules();
                    }, 500); // Tempo de duração da animação
                } else {
                    console.error('No schedule card found for ID:', scheduleId);
                }
            });

            channel.bind('create-schedule', function(data) {
                if (soundEnabled) {
                    notificationSound.currentTime = notificationSound.duration; // Vai para o final do arquivo
                    notificationSound.play().catch(function(error) {
                        console.error('Erro ao tentar reproduzir o som de notificação:', error);
                    });
                }

                // Verifica se o container existe
                var container = document.getElementById('schedules-container');
                if (!container) {
                    console.error('Element with ID schedules-container not found.');
                    return;
                }

                // Remove a mensagem de "Nenhum atendimento nas próximas 24 horas"
                var noSchedulesMessage = document.querySelector('.no-schedules-message');
                if (noSchedulesMessage) {
                    noSchedulesMessage.remove();
                }

                // Verifica se o agendamento já existe
                var existingToast = document.querySelector(`.toast[data-schedule-id="${data.scheduleId}"]`);
                if (existingToast) {
                    console.log('Schedule already exists with ID:', data.scheduleId);
                    return;
                }

                // Cria e adiciona um novo toast
                var newToast = document.createElement('div');
                newToast.className = 'toast';
                newToast.role = 'alert';
                newToast.setAttribute('aria-live', 'assertive');
                newToast.setAttribute('aria-atomic', 'true');
                newToast.dataset.scheduleId = data.scheduleId;
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
                container.appendChild(newToast);
                var bsToast = new bootstrap.Toast(newToast, {
                    autohide: false,
                });
                bsToast.show();
                startTimer(data.scheduleId, data.scheduleTimeUntilStart.hours, data.scheduleTimeUntilStart.minutes);
            });

            function checkForNoSchedules() {
                var container = document.getElementById('schedules-container');
                if (container && container.children.length === 0) {
                    // Exibe a mensagem de "Nenhum atendimento nas próximas 24 horas"
                    var noSchedulesMessage = document.createElement('div');
                    noSchedulesMessage.className = 'card-body no-schedules-message';
                    noSchedulesMessage.innerHTML = `
                        <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <img src="{{ asset('images/icons/emojiSadIcon.png') }}" alt="Emoji Triste" width="200">
                            <p style="text-align: center; color: #9C9C9C">Nenhum atendimento nas próximas 24 horas</p>
                        </div>
                    `;
                    container.appendChild(noSchedulesMessage);
                }
            }

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
        });
    </script>

    <style>
        .toast {
            transition: opacity 0.5s ease-out;
        }

        .toast.fade-out {
            opacity: 0;
        }
    </style>
    <audio id="cancelled-sound" src="{{ asset('Sounds/canceled.mp3') }}" preload="auto"></audio>
    <audio id="notification-sound" src="{{ asset('Sounds/notification.mp3') }}" preload="auto"></audio>
</x-layoutCollaborator>
