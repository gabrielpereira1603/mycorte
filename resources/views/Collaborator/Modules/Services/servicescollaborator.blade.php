<x-layoutCollaborator title="Serviços" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Seus Serviços</h4>
    </div>

        <!-- Serviços Ativados -->
    @if($servicesEnabled->isNotEmpty())
        <div class="card" style="width: 100%; ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-scissors m-1"></i>
                    <span class="services-card-header">Serviços Ativados</span>
                </div>
                <button class="btn btn-success add-service-btn d-flex align-items-center">
                    <i class="fa-solid fa-plus"></i>
                    <span class="d-none d-sm-inline ms-2">Adicionar Serviço</span>
                </button>
            </div>
            <div class="card-body">
                @foreach($servicesEnabled as $service)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                        <div class="toast-header">
                            <div class="cardService-info">
                                <i class="fa-solid fa-circle-info"></i>
                                <strong class="me-auto truncate">{{ $service->name }}</strong>
                            </div>
                        </div>
                        <div class="toast-body">
                            <div class="service-details">
                                <p>
                                    <i class="fa-regular fa-clock"></i>
                                    Duração: {{ $service->time }}
                                </p>
                                <p>
                                    <i class="fa-solid fa-sack-dollar"></i>
                                    Valor: R$ {{ number_format($service->value, 2, ',', '.') }}
                                </p>
                            </div>
                            <hr>
                            <div class="box-buttons-services">
                                <button class="btn btn-warning edit-service-btn" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" data-service-time="{{ $service->time }}" data-service-value="{{ str_replace('.', ',', $service->value) }}">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </button>

                                <button class="btn btn-danger delete-service-btn" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" data-service-time="{{ $service->time }}" data-service-value="{{ str_replace('.', ',', $service->value) }}">
                                    <i class="fa-solid fa-trash"></i>
                                    Desativar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Serviços Desativados -->
    @if($servicesDisabled->isNotEmpty())
        <div class="card" style="width: 100%; margin-top: 20px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-scissors m-1"></i>
                    <span class="services-card-header">Serviços Desativados</span>
                </div>
            </div>
            <div class="card-body">
                @foreach($servicesDisabled as $service)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                        <div class="toast-header">
                            <div class="cardService-info">
                                <i class="fa-solid fa-circle-info"></i>
                                <strong class="me-auto truncate">{{ $service->name }}</strong>
                            </div>
                        </div>
                        <div class="toast-body">
                            <div class="service-details">
                                <p>
                                    <i class="fa-regular fa-clock"></i>
                                    Duração: {{ $service->time }}
                                </p>
                                <p>
                                    <i class="fa-solid fa-sack-dollar"></i>
                                    Valor: R$ {{ number_format($service->value, 2, ',', '.') }}
                                </p>
                            </div>
                            <hr>
                            <div class="box-buttons-services">
                                <button class="btn btn-warning edit-service-btn" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" data-service-time="{{ $service->time }}" data-service-value="{{ str_replace('.', ',', $service->value) }}">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </button>

                                <button class="btn btn-success active-service-btn" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" data-service-time="{{ $service->time }}" data-service-value="{{ str_replace('.', ',', $service->value) }}">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Ativar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Modal de Serviço (Adicionar/Editar) -->
    <div id="serviceModal" class="modal fade" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 450px !important;">
                <div class="modal-header" style="background-color: #3a4976;">
                    <h5 class="modal-title" id="serviceModalLabel" style="color: white;">SERVIÇO</h5>
                </div>
                <div class="modal-body mt-3">
                    <form id="serviceForm" action="#" method="POST">
                        @csrf
                        <div class="serviceForm-inputs">
                            <input type="hidden" name="service_id" id="serviceId">

                            <div class="form-floating mb-1">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="serviceName" placeholder="Nome do Serviço" name="name" autocomplete="off" value="{{ old('name') }}">
                                <label for="serviceName">Nome Do Serviço:</label>
                            </div>

                            <div class="form-group mb-1">
                                <small style="color: gray">Duração:</small>
                                <input type="time" class="form-control @error('time') is-invalid @enderror" id="serviceTime" placeholder="Duração" name="time" autocomplete="off" value="{{ old('time') }}">
                            </div>

                            <div class="input-group mt-3">
                                <span class="input-group-text">R$</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('value') is-invalid @enderror" id="serviceValue" placeholder="Valor" name="value" autocomplete="off" value="{{ old('value') }}">
                                    <label for="serviceValue">Valor:</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end modalService-buttons">
                            <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal" id="cancel">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="save">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#serviceValue').maskMoney({
                thousands: '.',
                decimal: ',',
                allowZero: true,
                prefix: 'R$ '
            });

            $('#serviceTime').mask('00:00');
        });

        $(document).ready(function() {
            // Inicializar SweetAlert2
            document.querySelectorAll('.delete-service-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-service-id');
                    const serviceName = this.getAttribute('data-service-name');

                    Swal.fire({
                        title: 'Você tem certeza?',
                        text: `Deseja desativar o serviço "${serviceName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, desativar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Cria um formulário para enviar o ID do serviço
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('collaborator.service.delete', ['tokenCompany' => $tokenCompany]) }}";

                            // Adiciona o token CSRF
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            // Adiciona o ID do serviço
                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'service_id';
                            inputId.value = serviceId;
                            form.appendChild(inputId);

                            // Adiciona o formulário ao corpo do documento e o envia
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });

        $(document).ready(function() {
            // Inicializar SweetAlert2
            document.querySelectorAll('.active-service-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-service-id');
                    const serviceName = this.getAttribute('data-service-name');

                    Swal.fire({
                        title: 'Você tem certeza?',
                        text: `Deseja ativar o serviço "${serviceName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, ativar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Cria um formulário para enviar o ID do serviço
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('collaborator.service.active', ['tokenCompany' => $tokenCompany]) }}";

                            // Adiciona o token CSRF
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            // Adiciona o ID do serviço
                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'service_id';
                            inputId.value = serviceId;
                            form.appendChild(inputId);

                            // Adiciona o formulário ao corpo do documento e o envia
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            var serviceModal = new bootstrap.Modal(document.getElementById('serviceModal'));

            // Ativa e exibe todos os toasts
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                var bsToast = new bootstrap.Toast(toast, {
                    autohide: false, // O toast não será escondido automaticamente
                });
                bsToast.show(); // Exibe o toast
            });

            // Evento de clique para adicionar um novo serviço
            document.querySelector('.add-service-btn').addEventListener('click', function() {
                document.getElementById('serviceId').value = ''; // Limpa o campo ID
                document.getElementById('serviceForm').action = "{{ route('collaborator.service.add', ['tokenCompany' => $tokenCompany]) }}";
                document.querySelector('.modal-title').textContent = 'ADICIONAR SERVIÇO';
                clearServiceForm();
                serviceModal.show();
            });

            // Evento de clique para editar um serviço
            document.querySelectorAll('.edit-service-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var duration = this.getAttribute('data-service-time'); // Exemplo: "02:30:00"

                    // Extrai apenas as horas e minutos
                    var timeWithoutSeconds = duration.substring(0, 5); // Resultado: "02:30"

                    document.getElementById('serviceId').value = this.getAttribute('data-service-id');
                    document.getElementById('serviceName').value = this.getAttribute('data-service-name');
                    document.getElementById('serviceTime').value = timeWithoutSeconds; // Atribui o valor ajustado
                    document.getElementById('serviceValue').value = this.getAttribute('data-service-value').replace('.', ',');
                    document.getElementById('serviceForm').action = "{{ route('collaborator.service.edit', ['tokenCompany' => $tokenCompany]) }}";
                    document.querySelector('.modal-title').textContent = 'EDITAR SERVIÇO';
                    serviceModal.show();
                    enableSaveButtonOnAnyChange();
                });
            });

            // Função para habilitar o botão Salvar ao detectar qualquer alteração
            function enableSaveButtonOnAnyChange() {
                var saveButton = document.getElementById('save');
                document.getElementById('serviceName').addEventListener('input', enableSave);
                document.getElementById('serviceTime').addEventListener('input', enableSave);
                document.getElementById('serviceValue').addEventListener('input', enableSave);

                function enableSave() {
                    saveButton.disabled = false;
                    saveButton.style.backgroundColor = "#28a745"; // Verde mais forte
                }
            }

            // Função para limpar o formulário de serviço
            function clearServiceForm() {
                document.getElementById('serviceName').value = '';
                document.getElementById('serviceTime').value = '';
                document.getElementById('serviceValue').value = '';
                document.getElementById('save').disabled = true;
                document.getElementById('save').style.backgroundColor = "#90ee90"; // Verde mais claro
            }

            // Função para verificar se todos os campos estão preenchidos no formulário de adição
            function checkAddForm() {
                var saveButton = document.getElementById('save');

                document.getElementById('serviceName').addEventListener('input', check);
                document.getElementById('serviceTime').addEventListener('input', check);
                document.getElementById('serviceValue').addEventListener('input', check);

                function check() {
                    if (document.getElementById('serviceName').value !== '' &&
                        document.getElementById('serviceTime').value !== '' &&
                        document.getElementById('serviceValue').value !== '') {
                        saveButton.disabled = false;
                        saveButton.style.backgroundColor = "#28a745"; // Verde mais forte
                    } else {
                        saveButton.disabled = true;
                        saveButton.style.backgroundColor = "#90ee90"; // Verde mais claro
                    }
                }
            }

            // Evento de envio do formulário para converter o valor corretamente e verificar campos vazios
            document.getElementById('serviceForm').addEventListener('submit', function(event) {
                var valueField = document.getElementById('serviceValue');
                var value = valueField.value.replace('R$ ', '').replace('.', '').replace(',', '.');
                valueField.value = value;

                // Verificar se algum campo está vazio
                if (document.getElementById('serviceName').value === '' ||
                    document.getElementById('serviceTime').value === '' ||
                    document.getElementById('serviceValue').value === '') {
                    event.preventDefault(); // Impede o envio do formulário
                    alert('Por favor, preencha todos os campos antes de salvar.');
                }
            });

            checkAddForm();

            // Manter o modal aberto e adicionar a classe 'is-invalid' se houver erros
            @if ($errors->any())
            serviceModal.show();
            @foreach ($errors->keys() as $field)
            var fieldElement = document.getElementById('{{ $field }}');
            if (fieldElement) {
                fieldElement.classList.add('is-invalid');
                setTimeout(function() {
                    fieldElement.classList.remove('is-invalid');
                }, 3000); // Remove a classe 'is-invalid' após 3 segundos
            }
            @endforeach
            @endif
        });
    </script>
</x-layoutCollaborator>
