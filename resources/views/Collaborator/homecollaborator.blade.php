<x-layoutCollaborator title="Início" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Bem-Vindo, {{ $collaborator->name }}!</h4>
    </div>

    <!-- Verifica se há agendamentos -->
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
    </script>
</x-layoutCollaborator>
