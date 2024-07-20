<x-layoutCollaborator title="Serviços" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Seus Serviços</h4>
    </div>

    @if($services->isEmpty())
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header">
                Serviços
                <button class="btn btn-success add-service-btn">
                    <i class="fa-solid fa-plus"></i> Adicionar Serviço
                </button>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                <img src="{{ asset('images/icons/emojiSadIcon.png') }}" alt="Emoji Triste" width="200">
                <p style="text-align: center; color: #9C9C9C">Nenhum serviço disponível</p>
            </div>
        </div>
    @else
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header d-flex justify-content-between align-items-center">
                Serviços
                <button class="btn btn-success add-service-btn">
                    <i class="fa-solid fa-plus"></i> Adicionar Serviço
                </button>
            </div>
            <div class="card-body">
                @foreach($services as $service)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <div class="card-info">
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
                            <div class="box-buttons">
                                <button class="btn btn-primary edit-service-btn" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" data-service-time="{{ $service->time }}" data-service-value="{{ str_replace('.', ',', $service->value) }}">
                                    <i class="fa-solid fa-pen"></i> Editar Serviço
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Modal de Edição de Serviço -->
    <div id="serviceEditModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-myaccount-editBiografia" style="max-width: 450px !important;">
                <div class="header-modal-Biografia" style="background-color: #3a4976;">
                    <button class="close-editBiografia">&times;</button>
                    <p class="title-editBiografiaModal" style="color: white;">EDITAR SERVIÇO</p>
                </div>
                <div class="body-editBiografiaModal">
                    <form id="editServiceForm" action="{{ route('collaborator.service.edit', ['tokenCompany' => $tokenCompany]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" id="serviceId">
                        <div class="form-group">
                            <label for="editServiceName">Nome do Serviço:</label>
                            <input type="text" id="editServiceName" class="form-control" name="name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="editServiceTime">Duração:</label>
                            <input type="text" id="editServiceTime" class="form-control" name="time" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="editServiceValue">Valor:</label>
                            <input type="text" id="editServiceValue" class="form-control" name="value" autocomplete="off">
                        </div>

                        <div class="buttons-modalBiografia">
                            <button type="button" class="btn btn-danger" id="cancelEditService">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="saveEditService" disabled>Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Adição de Serviço -->
    <div id="serviceAddModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-myaccount-editBiografia" style="max-width: 450px !important;">
                <div class="header-modal-Biografia" style="background-color: #3a4976;">
                    <button class="close-addBiografia">&times;</button>
                    <p class="title-addBiografiaModal" style="color: white;">ADICIONAR SERVIÇO</p>
                </div>
                <div class="body-editBiografiaModal">
                    <form id="addServiceForm" action="{{ route('collaborator.service.add', ['tokenCompany' => $tokenCompany]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="addServiceName">Nome do Serviço:</label>
                            <input type="text" id="addServiceName" class="form-control" name="name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="addServiceTime">Duração:</label>
                            <input type="text" id="addServiceTime" class="form-control" name="time" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="addServiceValue">Valor:</label>
                            <input type="text" id="addServiceValue" class="form-control" name="value" autocomplete="off">
                        </div>

                        <div class="buttons-modalBiografia">
                            <button type="button" class="btn btn-danger" id="cancelAddService">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="saveAddService" disabled>Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                var bsToast = new bootstrap.Toast(toast, {
                    autohide: false,
                });
                bsToast.show();
            });

            // Adiciona evento de clique aos botões "Editar Serviço"
            var editServiceButtons = document.querySelectorAll('.edit-service-btn');
            editServiceButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var serviceId = this.getAttribute('data-service-id');
                    var serviceName = this.getAttribute('data-service-name');
                    var serviceTime = this.getAttribute('data-service-time');
                    var serviceValue = this.getAttribute('data-service-value');

                    document.getElementById('serviceId').value = serviceId;
                    document.getElementById('editServiceName').value = serviceName;
                    document.getElementById('editServiceTime').value = serviceTime;
                    document.getElementById('editServiceValue').value = serviceValue.replace(',', '.');

                    var modal = new bootstrap.Modal(document.getElementById('serviceEditModal'));
                    modal.show();

                    checkForChanges();
                });
            });

            // Adiciona evento de clique ao botão "Adicionar Novo Serviço"
            var addServiceButton = document.querySelector('.add-service-btn');
            addServiceButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(document.getElementById('serviceAddModal'));
                modal.show();
                clearAddServiceForm();
            });

            // Fecha o modal de adicionar ao clicar no botão "Cancelar"
            document.getElementById('cancelAddService').addEventListener('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('serviceAddModal'));
                modal.hide();
            });

            // Fecha o modal de adicionar ao clicar no "X"
            document.querySelector('.close-addBiografia').addEventListener('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('serviceAddModal'));
                modal.hide();
            });

            // Fecha o modal de editar ao clicar no botão "Cancelar"
            document.getElementById('cancelEditService').addEventListener('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('serviceEditModal'));
                modal.hide();
            });

            // Fecha o modal de editar ao clicar no "X"
            document.querySelector('.close-editBiografia').addEventListener('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('serviceEditModal'));
                modal.hide();
            });

            // Verifica mudanças nos campos do formulário de edição
            function checkForChanges() {
                var originalServiceName = document.getElementById('editServiceName').value;
                var originalServiceTime = document.getElementById('editServiceTime').value;
                var originalServiceValue = document.getElementById('editServiceValue').value;

                var saveButton = document.getElementById('saveEditService');

                document.getElementById('editServiceName').addEventListener('input', check);
                document.getElementById('editServiceTime').addEventListener('input', check);
                document.getElementById('editServiceValue').addEventListener('input', check);

                function check() {
                    if (document.getElementById('editServiceName').value !== originalServiceName ||
                        document.getElementById('editServiceTime').value !== originalServiceTime ||
                        document.getElementById('editServiceValue').value !== originalServiceValue) {
                        saveButton.disabled = false;
                        saveButton.style.backgroundColor = "#28a745"; // Verde mais forte
                    } else {
                        saveButton.disabled = true;
                        saveButton.style.backgroundColor = "#90ee90"; // Verde mais claro
                    }
                }
            }

            // Função para limpar os campos do formulário de adição
            function clearAddServiceForm() {
                document.getElementById('addServiceName').value = '';
                document.getElementById('addServiceTime').value = '';
                document.getElementById('addServiceValue').value = '';
                document.getElementById('saveAddService').disabled = true;
                document.getElementById('saveAddService').style.backgroundColor = "#90ee90"; // Verde mais claro
            }

            // Função para verificar se todos os campos estão preenchidos no formulário de adição
            function checkAddForm() {
                var saveButton = document.getElementById('saveAddService');

                document.getElementById('addServiceName').addEventListener('input', check);
                document.getElementById('addServiceTime').addEventListener('input', check);
                document.getElementById('addServiceValue').addEventListener('input', check);

                function check() {
                    if (document.getElementById('addServiceName').value !== '' &&
                        document.getElementById('addServiceTime').value !== '' &&
                        document.getElementById('addServiceValue').value !== '') {
                        saveButton.disabled = false;
                        saveButton.style.backgroundColor = "#28a745"; // Verde mais forte
                    } else {
                        saveButton.disabled = true;
                        saveButton.style.backgroundColor = "#90ee90"; // Verde mais claro
                    }
                }
            }

            checkAddForm();
        });
    </script>

    <!-- Adicione máscaras aos campos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#editServiceTime, #addServiceTime').mask('00:00');
            $('#editServiceValue, #addServiceValue').mask('0000.00', {reverse: true});
        });
    </script>
</x-layoutCollaborator>
