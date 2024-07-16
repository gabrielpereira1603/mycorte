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
                            <button type="button" class="btn btn-warning"
                                    data-schedule-id="{{ $schedule->id }}"
                                    data-collaborator-id="{{ $schedule->collaborator->id }}"
                                    data-company-id="{{ $schedule->company->id }}"
                                    data-company-token="{{ $tokenCompany }}"
                                    onclick="showRescheduleOptions(this)">Reagendar
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Modal -->
    <div id="rescheduleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleModalLabel">Reagendar Horário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="calendar" class="text-center"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Selecionar Colaborador -->
    <div id="selectCollaboratorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="selectCollaboratorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectCollaboratorModalLabel">Selecionar Colaborador</h5>
                    <button type="button" id="exitModalCollaborator" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="selectCollaboratorForm">
                        <div class="collaborator-list">
                            @foreach($collaborators as $collaborator)
                                <div class="collaborator-item" data-collaborator-id="{{ $collaborator->id }}">
                                    <img src="{{ $collaborator->image }}" class="collaborator-img" alt="{{ $collaborator->name }}" width="50px" height="50px">
                                    <span class="collaborator-name">{{ $collaborator->name }}</span>
                                    <input type="radio" name="collaborator" value="{{ $collaborator->id }}" class="collaborator-radio" style="display:none;">
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 d-flex justify-content-end button-box">
                            <button type="button" class="btn btn-success" onclick="proceedToReschedule()">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        function showRescheduleOptions(button) {
            Swal.fire({
                title: 'Reagendar',
                text: "Você quer reagendar com o mesmo colaborador ou escolher um novo?",
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Mesmo Colaborador',
                denyButtonText: 'Outro Colaborador',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    openRescheduleModal(button);
                } else if (result.isDenied) {
                    openSelectCollaboratorModal(button);
                }
            });
        }

        function openRescheduleModal(button) {
            var scheduleId = button.getAttribute('data-schedule-id');
            var collaboratorId = button.getAttribute('data-collaborator-id');
            var companyId = button.getAttribute('data-company-id');
            var companyToken = button.getAttribute('data-company-token');
            var formAction = '{{ route('dataTransporter') }}';
            var csrfToken = "{{ csrf_token() }}";
            var rescheduleController = "{{ route('rescheduleclient', ['tokenCompany' => $tokenCompany]) }}";

            $('#rescheduleModal').modal('show');

            var script = document.createElement('script');
            script.src = "{{ asset('js/calendarSchedule/scheduleClient.js') }}";
            script.onload = function() {
                initializeCalendar(scheduleId, collaboratorId, companyId, companyToken, formAction, csrfToken, rescheduleController);
            };
            document.head.appendChild(script);
        }

        function openSelectCollaboratorModal(button) {
            var scheduleId = button.getAttribute('data-schedule-id');
            var companyId = button.getAttribute('data-company-id');
            var companyToken = button.getAttribute('data-company-token');

            // Armazenar os dados no modal para uso posterior
            var selectCollaboratorModal = $('#selectCollaboratorModal');
            selectCollaboratorModal.data('scheduleId', scheduleId);
            selectCollaboratorModal.data('companyId', companyId);
            selectCollaboratorModal.data('companyToken', companyToken);

            $('#selectCollaboratorModal').modal('show');
        }

        function proceedToReschedule() {
            var selectedCollaborator = document.querySelector('input[name="collaborator"]:checked');
            if (selectedCollaborator) {
                var scheduleId = $('#selectCollaboratorModal').data('scheduleId');
                var companyId = $('#selectCollaboratorModal').data('companyId');
                var companyToken = $('#selectCollaboratorModal').data('companyToken');
                var collaboratorId = selectedCollaborator.value;

                // Fechar modal de seleção de colaborador
                $('#selectCollaboratorModal').modal('hide');

                // Abrir modal de reagendamento com o novo colaborador
                var rescheduleButton = document.querySelector(`button[data-schedule-id="${scheduleId}"]`);
                rescheduleButton.setAttribute('data-collaborator-id', collaboratorId);
                openRescheduleModal(rescheduleButton);
            } else {
                Swal.fire('Selecione um colaborador', '', 'warning');
            }
        }

        // Adiciona evento para fechar o modal quando o botão é clicado
        document.addEventListener('DOMContentLoaded', function() {
            var closeButton = document.querySelector('#rescheduleModal .modal-header button.close');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    $('#rescheduleModal').modal('hide');
                });
            }

            var closeButtonCollaboratorModal = document.querySelector('#selectCollaboratorModal .modal-header button.close');
            if (closeButtonCollaboratorModal) {
                closeButtonCollaboratorModal.addEventListener('click', function() {
                    $('#selectCollaboratorModal').modal('hide');
                });
            }

            // Adiciona evento de clique em cada item de colaborador
            document.querySelectorAll('.collaborator-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    // Desmarcar todos os outros inputs
                    document.querySelectorAll('.collaborator-radio').forEach(function(input) {
                        input.checked = false;
                    });

                    // Seleciona o input de colaborador correspondente
                    var collaboratorId = this.getAttribute('data-collaborator-id');
                    var input = document.querySelector('.collaborator-radio[value="' + collaboratorId + '"]');
                    if (input) {
                        input.checked = true;
                    }
                });
            });

            // Fechar o modal ao clicar fora dele
            $('#selectCollaboratorModal').on('click', function(e) {
                if (e.target === this) {
                    $('#selectCollaboratorModal').modal('hide');
                }
            });

            document.querySelectorAll('.collaborator-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    // Desmarcar todos os outros inputs
                    document.querySelectorAll('.collaborator-radio').forEach(function(input) {
                        input.checked = false;
                    });

                    // Remover a classe selected de todos os itens
                    document.querySelectorAll('.collaborator-item').forEach(function(div) {
                        div.classList.remove('selected');
                    });

                    // Adicionar a classe selected ao item clicado
                    this.classList.add('selected');

                    // Marcar o input correspondente
                    var collaboratorId = this.getAttribute('data-collaborator-id');
                    var input = document.querySelector('.collaborator-radio[value="' + collaboratorId + '"]');
                    if (input) {
                        input.checked = true;
                        input.style.display = 'block'; // Garanta que o input esteja visível
                    }
                });
            });
        });

        // Adiciona evento para fechar o modal quando clicar fora dele
        $('#rescheduleModal').on('click', function(e) {
            if (e.target === this) {
                $('#rescheduleModal').modal('hide');
            }
        });

    </script>
</x-layoutClient>
