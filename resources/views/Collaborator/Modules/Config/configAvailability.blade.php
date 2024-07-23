<x-layoutCollaborator title="Configurações de Disponibilidade" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4 style="color: white;">Disponibilidades de {{ $collaborator->name }}</h4>
    </div>

    <small class="card-subtitle mb-2 text-muted custom-text">
        Importante: Não é permitido criar dois dias da semana iguais ou dias da semana inexistentes. Qualquer alteração nos horários afetará seu calendário de agendamento. Por favor, revise todas as mudanças cuidadosamente antes de salvar.
    </small>

    <div class="card mt-4">
        <div class="cardAvailability-body">
            @foreach($availability as $day)
                <div class="preview-availability">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <div class="calendar-day">
                                <img src="{{ asset('images/icons/calendarioIcon.png') }}" width="20" alt="Calendario Icon">
                                <h2>{{ $day->workDays }}</h2>
                            </div>
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-cell">
                                <p>
                                    <i class="fa-solid fa-play"></i>
                                    Início do expediente: <strong>{{ $day->hourStart }}</strong>
                                </p>

                                <p>
                                    <i class="fa-solid fa-stop"></i>
                                    Fim do expediente: <strong>{{ $day->hourFinal }}</strong>
                                </p>
                            </div>

                            <div class="calendar-cell">
                                <p>
                                    <i class="fa-solid fa-burger"></i>
                                    Início do almoço: <strong>{{ $day->lunchTimeStart }}</strong>
                                </p>

                                <p>
                                    <i class="fa-solid fa-burger"></i>
                                    Fim do almoço: <strong>{{ $day->lunchTimeFinal }}</strong>
                                </p>
                            </div>

                            <p class="interval-p">
                                <i class="fa-solid fa-retweet"></i>
                                Tempo de intervalo entre cada serviço: <strong>{{ $day->hourServiceInterval }}</strong>
                            </p>

                        </div>
                    </div>
                </div>
                <div class="box-button">
                    <button class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                        Excluir
                    </button>
                    <button class="btn btn-warning edit-availability" data-id="{{ $day->id }}" data-start="{{ $day->hourStart }}" data-end="{{ $day->hourFinal }}" data-start-lunch="{{ $day->lunchTimeStart }}" data-end-lunch="{{ $day->lunchTimeFinal }}" data-interval="{{ $day->hourServiceInterval }}" data-workday="{{ $day->workDays }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Editar
                    </button>
                </div>
            @endforeach

            {{ $availability->links('vendor.pagination.custom') }}
        </div>
    </div>

    <div class="box-button">
        <button class="btn btn-success" id="openCreateAvailabilityModal">
            <i class="fa-solid fa-circle-plus"></i>
            Cadastrar
        </button>
    </div>

    <div id="createAvailabilityModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-createAvailability" style="max-width: 450px !important;">
                <div class="header-modal-createAvailability" style="background-color: #3a4976;">
                    <button class="close-createAvailability">&times;</button>
                    <p class="title-createAvailability" style="color: white;">CADASTRAR NOVA DISPONIBILIDADE</p>
                </div>
                <div class="body-createAvailability">
                    <form id="createAvailability" action="" method="POST">
                        @csrf
                        <input type="hidden" name="tokenCompany" value="{{ $tokenCompany }}">
                        <input type="hidden" id="availabilityId" name="availabilityId" value="">

                        <div class="form-group">
                            <label for="newStartWork">Início do expediente:</label>
                            <input type="time" id="newStartWork" class="form-control" name="startWork" value="" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="newEndWork">Fim do expediente:</label>
                            <input type="time" id="newEndWork" class="form-control" name="endWork" value="" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="newStartLunch">Início do almoço:</label>
                            <input type="time" id="newStartLunch" class="form-control" name="startLunch" value="" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="newEndLunch">Fim do almoço:</label>
                            <input type="time" id="newEndLunch" class="form-control" name="endLunch" value="" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="newServiceInterval">Tempo de intervalo entre cada serviço:</label>
                            <input type="time" id="newServiceInterval" class="form-control" name="serviceInterval" value="" autocomplete="new-password">
                        </div>

                        <p style="margin-bottom: 0px; font-style: italic; font-size: 11px; color: gray;">
                            <strong>OBS:</strong> após alterar os dados para confirmar alteração será necessário que confirme seu login por segurança.
                        </p>

                        <div class="buttons-modalCreateAvailability">
                            <button type="button" class="btn btn-primary" id="cancelCreate">Cancelar Cadastro</button>
                            <button type="submit" class="btn btn-primary" id="create">Salvar Cadastro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const openModalButton = document.getElementById('openCreateAvailabilityModal');
            const createAvailabilityModal = document.getElementById('createAvailabilityModal');
            const closeModalButton = document.querySelector('.close-createAvailability');
            const cancelCreateButton = document.getElementById('cancelCreate');
            const form = document.getElementById('createAvailability');
            const title = document.querySelector('.title-createAvailability');

            openModalButton.addEventListener('click', () => {
                form.action = "";
                title.textContent = 'CADASTRAR NOVA DISPONIBILIDADE';
                document.getElementById('availabilityId').value = '';
                form.reset();
                createAvailabilityModal.style.display = 'block';
            });

            document.querySelectorAll('.edit-availability').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const start = button.getAttribute('data-start');
                    const end = button.getAttribute('data-end');
                    const startLunch = button.getAttribute('data-start-lunch');
                    const endLunch = button.getAttribute('data-end-lunch');
                    const interval = button.getAttribute('data-interval');
                    const workDay = button.getAttribute('data-workday');

                    form.action = ``;
                    title.textContent = 'EDITAR DISPONIBILIDADE: '+ workDay;
                    document.getElementById('availabilityId').value = id;
                    document.getElementById('newStartWork').value = start;
                    document.getElementById('newEndWork').value = end;
                    document.getElementById('newStartLunch').value = startLunch;
                    document.getElementById('newEndLunch').value = endLunch;
                    document.getElementById('newServiceInterval').value = interval;

                    createAvailabilityModal.style.display = 'block';
                });
            });

            closeModalButton.addEventListener('click', () => {
                createAvailabilityModal.style.display = 'none';
            });

            cancelCreateButton.addEventListener('click', () => {
                createAvailabilityModal.style.display = 'none';
            });

            window.addEventListener('click', (event) => {
                if (event.target == createAvailabilityModal) {
                    createAvailabilityModal.style.display = 'none';
                }
            });
        });
    </script>

</x-layoutCollaborator>
