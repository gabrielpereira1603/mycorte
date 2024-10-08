<x-layoutCollaborator title="Início" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Bem-Vindo, {{ $collaborator->name }}!</h4>
    </div>

    <div class="card" style="width: 100%; margin: 20px auto;">
        <div class="card-header">
            Próximos Atendimentos
        </div>
        <div class="card-body" id="schedules-container">
            @if(isset($noSchedulesMessage))
                <!-- Exibe mensagem de nenhum agendamento -->
                <div class="no-schedules-message">
                    <img src="{{ asset('images/icons/emojiSadIcon.png') }}" alt="Emoji Triste" width="200">
                    <p style="text-align: center; color: #9C9C9C">Nenhum atendimento nas próximas 24 horas</p>
                </div>
            @else
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
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var soundEnabled = localStorage.getItem('audio-permission') === 'granted';
            var notificationSound = document.getElementById('notification-sound');
            var cancelledSound = document.getElementById('cancelled-sound');
            var reescheduleSound = document.getElementById('reeschedule-sound');

            var collaboratorLogged = {{ $collaborator->id }}; // ID do colaborador


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
            Pusher.logToConsole = false;

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

                var scheduleId = data.schedule.id;
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
                var newSchedule = data.schedule;

                // Converter collaboratorfk para número, se necessário
                var collaboratorFk = Number(newSchedule.collaboratorfk);

                if (collaboratorFk !== collaboratorLogged) {
                    return;
                }

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
                var existingToast = document.querySelector(`.toast[data-schedule-id="${data.schedule.id}"]`);
                if (existingToast) {
                    console.log('Schedule already exists with ID:', data.schedule.id);
                    return;
                }

                // Cria e adiciona um novo toast
                var newToast = document.createElement('div');
                newToast.className = 'toast';
                newToast.role = 'alert';
                newToast.setAttribute('aria-live', 'assertive');
                newToast.setAttribute('aria-atomic', 'true');
                newToast.dataset.scheduleId = data.schedule.id;
                newToast.innerHTML = `
                <div class="toast-header">
                    <img src="${data.client.image}" class="rounded me-2" alt="Foto do Cliente" width="50px" height="50px">
                    <div class="card-info">
                        <strong class="me-auto truncate">${data.client.name}</strong>
                        <div class="card-date">
                            <small>
                                <i class="fa-solid fa-calendar-days"></i>
                                ${data.schedule.date}
                            </small>
                            <small>
                                <i class="fa-regular fa-clock"></i>
                                ${data.schedule.hourStart} - ${data.schedule.hourFinal}
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
                        <button class="btn btn-warning remind-client-btn" data-schedule-id="${data.schedule.id}">
                            <i class="fa-solid fa-bell"></i> Lembrar Cliente
                        </button>
                        <small id="timer-${data.schedule.id}" class="timer"></small>
                    </div>
                </div>
            `;
                container.appendChild(newToast);

                // Adiciona evento de clique ao botão "Lembrar Cliente" do novo toast
                newToast.querySelector('.remind-client-btn').addEventListener('click', function() {
                    var scheduleId = this.getAttribute('data-schedule-id');
                    sendReminderEmail(scheduleId);
                });

                // Inicializa o timer para o novo agendamento
                startTimer(data.schedule.id, data.hoursUntilStart, data.minutesUntilStart);

                var bsToast = new bootstrap.Toast(newToast, {
                    autohide: false,
                });
                bsToast.show();
            });

            channel.bind('reeschedule', function(data) {
                if (soundEnabled) {
                    reescheduleSound.currentTime = reescheduleSound.duration; // Vai para o final do arquivo
                    reescheduleSound.play().catch(function(error) {
                        console.error('Erro ao tentar reproduzir o som de reeschedule:', error);
                    });
                }

                var existingScheduleId = data.existingSchedule.id;
                var scheduleCard = document.querySelector(`.toast[data-schedule-id="${existingScheduleId}"]`);

                if (scheduleCard) {
                    scheduleCard.classList.add('fade-out');
                    setTimeout(function() {
                        scheduleCard.remove();
                        checkForNoSchedules();
                    }, 500); // Tempo de duração da animação
                } else {
                    console.error('No schedule card found for ID:', existingScheduleId);
                }

                var newSchedule = data.schedule;

                // Converter collaboratorfk para número, se necessário
                var collaboratorFk = Number(newSchedule.collaboratorfk);

                if (collaboratorFk !== collaboratorLogged) {
                    return;
                }

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
                var existingToast = document.querySelector(`.toast[data-schedule-id="${newSchedule.id}"]`);
                if (existingToast) {
                    console.log('Schedule already exists with ID:', newSchedule.id);
                    return;
                }

                // Cria e adiciona um novo toast
                var newToast = document.createElement('div');
                newToast.className = 'toast';
                newToast.role = 'alert';
                newToast.setAttribute('aria-live', 'assertive');
                newToast.setAttribute('aria-atomic', 'true');
                newToast.dataset.scheduleId = newSchedule.id;
                newToast.innerHTML = `
                <div class="toast-header">
                    <img src="${data.client.image}" class="rounded me-2" alt="Foto do Cliente" width="50px" height="50px">
                    <div class="card-info">
                        <strong class="me-auto truncate">${data.client.name}</strong>
                        <div class="card-date">
                            <small>
                                <i class="fa-solid fa-calendar-days"></i>
                                ${newSchedule.date}
                            </small>
                            <small>
                                <i class="fa-regular fa-clock"></i>
                                ${newSchedule.hourStart} - ${newSchedule.hourFinal}
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
                        <button class="btn btn-warning remind-client-btn" data-schedule-id="${newSchedule.id}">
                            <i class="fa-solid fa-bell"></i> Lembrar Cliente
                        </button>
                        <small id="timer-${newSchedule.id}" class="timer"></small>
                    </div>
                </div>
            `;
                container.appendChild(newToast);

                // Adiciona evento de clique ao botão "Lembrar Cliente" do novo toast
                newToast.querySelector('.remind-client-btn').addEventListener('click', function() {
                    var scheduleId = this.getAttribute('data-schedule-id');
                    sendReminderEmail(scheduleId);
                });

                // Inicializa o timer para o novo agendamento
                startTimer(newSchedule.id, data.hoursUntilStart, data.minutesUntilStart);

                var bsToast = new bootstrap.Toast(newToast, {
                    autohide: false,
                });
                bsToast.show();
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
                if (!timerElement) {
                    console.error('Element with ID timer-' + scheduleId + ' not found.');
                    return;
                }

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
                        clearInterval(timerInterval); // Para o intervalo quando o tempo acabar
                    }
                }

                updateTimer();
                var timerInterval = setInterval(updateTimer, 1000); // Salva o intervalo para que possa ser limpo
            }


            function sendReminderEmail(scheduleId) {
            Swal.fire({
                title: 'Enviando lembrete...',
                text: 'Por favor, aguarde enquanto enviamos o lembrete ao cliente.',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            fetch(`{{ url('/api/send-reminder') }}/${scheduleId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'O lembrete foi enviado com sucesso.',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao enviar o lembrete. Tente novamente mais tarde.',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao enviar o lembrete. Tente novamente mais tarde.',
                        icon: 'error'
                    });
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
    <audio id="reeschedule-sound" src="{{ asset('Sounds/reeschedule.mp3') }}" preload="auto"></audio>
    <audio id="cancelled-sound" src="{{ asset('Sounds/canceled.mp3') }}" preload="auto"></audio>
    <audio id="notification-sound" src="{{ asset('Sounds/notification.mp3') }}" preload="auto"></audio>
</x-layoutCollaborator>
