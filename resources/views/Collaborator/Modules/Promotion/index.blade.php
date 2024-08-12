<x-layoutCollaborator title="Promoções" :token-company="$tokenCompany">
    <div class="main-title">
        <h4>Promoções de {{ $collaborator->name }}</h4>
    </div>

    @if($promotions->isNotEmpty())
        <div class="card" style="width: 100%;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-tags m-1"></i>
                    <span class="promotions-card-header">Suas Promoções</span>
                </div>
                <button class="btn btn-success add-promotion-btn d-flex align-items-center">
                    <i class="fa-solid fa-plus"></i>
                    <span class="d-none d-sm-inline ms-2">Adicionar Promoção</span>
                </button>
            </div>
            <div class="card-body">
                @foreach($promotions as $promotion)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                        <div class="toast-header">
                            <div class="cardPromotion-info">
                                <i class="fa-solid fa-circle-info"></i>
                                <strong class="me-auto truncate">{{ $promotion->name }}</strong>
                            </div>
                        </div>
                        <div class="toast-body">
                            <div class="promotion-details">
                                <p>
                                    <i class="fa-regular fa-calendar-alt"></i>
                                    Início: {{ \Carbon\Carbon::parse($promotion->dataHourStart)->format('d/m/Y H:i') }}
                                </p>
                                <p>
                                    <i class="fa-regular fa-calendar-alt"></i>
                                    Fim: {{ \Carbon\Carbon::parse($promotion->dataHourFinal)->format('d/m/Y H:i') }}
                                </p>
                                <p>
                                    <i class="fa-solid fa-sack-dollar"></i>
                                    Valor: R$ {{ number_format($promotion->value, 2, ',', '.') }}
                                </p>
                                <p>
                                    <i class="fa-solid fa-toggle-on"></i>
                                    Habilitado:
                                    <input type="checkbox" class="form-check-input" disabled {{ $promotion->enabled ? 'checked' : '' }}>
                                </p>
                            </div>
                            <hr>
                            <div class="box-buttons-promotions">
                                <button class="btn btn-warning edit-promotion-btn" data-promotion-id="{{ $promotion->id }}" data-promotion-name="{{ $promotion->name }}" data-promotion-start="{{ $promotion->dataHourStart }}" data-promotion-end="{{ $promotion->dataHourFinal }}" data-promotion-value="{{ $promotion->value }}" data-promotion-type="{{ $promotion->type }}" data-promotion-enabled="{{ $promotion->enabled }}" data-promotion-services="{{ $promotion->services ? $promotion->services->pluck('id') : '[]' }}">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </button>

                                <button class="btn btn-danger delete-promotion-btn" data-promotion-id="{{ $promotion->id }}" data-promotion-name="{{ $promotion->name }}">
                                    <i class="fa-solid fa-trash"></i>
                                    Deletar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p>Não há promoções cadastradas.</p>
    @endif

    <!-- Modal de Promoção (Adicionar/Editar) -->
    <div id="promotionModal" class="modal fade" tabindex="-1" aria-labelledby="promotionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 450px !important;">
                <div class="modal-header" style="background-color: #3a4976;">
                    <h5 class="modal-title" id="promotionModalLabel" style="color: white;">PROMOÇÃO</h5>
                </div>
                <div class="modal-body mt-3">
                    <form id="promotionForm" method="POST">
                        @csrf
                        <div class="promotionForm-inputs">
                            <input type="hidden" name="promotion_id" id="promotionId">

                            <div class="form-floating mb-1">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="promotionName" placeholder="Nome da Promoção" name="name" autocomplete="off" value="{{ old('name') }}">
                                <label for="promotionName">Nome da Promoção:</label>
                            </div>

                            <div class="form-group mb-1">
                                <small style="color: gray">Data e Hora de Início:</small>
                                <input type="datetime-local" class="form-control @error('dataHourStart') is-invalid @enderror" id="promotionStartDate" placeholder="Data e Hora de Início" name="dataHourStart" autocomplete="off" value="{{ old('dataHourStart') }}">
                            </div>

                            <div class="form-group mb-1">
                                <small style="color: gray">Data e Hora de Término:</small>
                                <input type="datetime-local" class="form-control @error('dataHourFinal') is-invalid @enderror" id="promotionEndDate" placeholder="Data e Hora de Término" name="dataHourFinal" autocomplete="off" value="{{ old('dataHourFinal') }}">
                            </div>

                            <div class="form-group mb-1">
                                <small style="color: gray">Tipo:</small>
                                <select class="form-control @error('type') is-invalid @enderror" id="promotionType" name="type">
                                    <option value="individual">Individual</option>
                                    <option value="combo">Combo</option>
                                </select>
                            </div>

                            <div class="form-group mb-1 individual-service">
                                <small style="color: gray">Serviço:</small>
                                <select class="form-control @error('servicefk') is-invalid @enderror" id="promotionService" name="servicefk">
                                    <option value="">Selecione um Serviço</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-service-value="{{ $service->value }}">
                                            {{ $service->name }} - R$ {{ number_format($service->value, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-1 combo-service d-none">
                                <small style="color: gray">Serviços:</small>
                                <div class="form-check">
                                    @foreach($services as $service)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="services[]" value="{{ $service->id }}"> {{ $service->name }} - R$ {{ number_format($service->value, 2, ',', '.') }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="input-group mt-3">
                                <span class="input-group-text">R$</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('value') is-invalid @enderror" id="promotionValue" placeholder="Valor" name="value" autocomplete="off" value="{{ old('value') }}">
                                    <label for="promotionValue">Valor:</label>
                                </div>
                            </div>

                            <div class="form-check mt-3">
                                <input type="checkbox" class="form-check-input" id="promotionEnabled" name="enabled" value="1" checked>
                                <label for="promotionEnabled" class="form-check-label">Habilitado</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end modalPromotion-buttons">
                            <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal" id="cancel">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="save">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var promotionModal = new bootstrap.Modal(document.getElementById('promotionModal'));

            // Ativa e exibe todos os toasts
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                var bsToast = new bootstrap.Toast(toast, {
                    autohide: false, // O toast não será escondido automaticamente
                });
                bsToast.show(); // Exibe o toast
            });

            // Evento de clique para adicionar uma nova promoção
            document.querySelector('.add-promotion-btn').addEventListener('click', function() {
                clearPromotionForm();
                promotionModal.show();
            });

            // Evento de clique para editar uma promoção
            document.querySelectorAll('.edit-promotion-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var startDateTime = this.getAttribute('data-promotion-start').replace(' ', 'T');
                    var endDateTime = this.getAttribute('data-promotion-end').replace(' ', 'T');

                    document.getElementById('promotionId').value = this.getAttribute('data-promotion-id');
                    document.getElementById('promotionName').value = this.getAttribute('data-promotion-name');
                    document.getElementById('promotionStartDate').value = startDateTime;
                    document.getElementById('promotionEndDate').value = endDateTime;
                    document.getElementById('promotionType').value = this.getAttribute('data-promotion-type');
                    document.getElementById('promotionEnabled').checked = this.getAttribute('data-promotion-enabled') === 'true' || this.getAttribute('data-promotion-enabled') === '1';
                    document.getElementById('promotionValue').value = this.getAttribute('data-promotion-value');

                    if (this.getAttribute('data-promotion-type') === 'individual') {
                        document.querySelector('.individual-service').classList.remove('d-none');
                        document.querySelector('.combo-service').classList.add('d-none');
                        document.getElementById('promotionService').value = this.getAttribute('data-promotion-services').replace(/[\[\]]/g, '');
                    } else {
                        document.querySelector('.individual-service').classList.add('d-none');
                        document.querySelector('.combo-service').classList.remove('d-none');
                        let services = JSON.parse(this.getAttribute('data-promotion-services'));
                        services.forEach(serviceId => {
                            document.querySelector(`input[name="services[]"][value="${serviceId}"]`).checked = true;
                        });
                    }

                    promotionModal.show();
                });
            });

            // Evento de clique para deletar uma promoção
            document.querySelectorAll('.delete-promotion-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var promotionId = this.getAttribute('data-promotion-id');
                    var promotionName = this.getAttribute('data-promotion-name');

                    Swal.fire({
                        title: 'Você tem certeza?',
                        text: `Deseja deletar a promoção "${promotionName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, deletar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Cria um formulário para enviar o ID da promoção
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('collaborator.promotion.delete', ['tokenCompany' => $tokenCompany]) }}";

                            // Adiciona o token CSRF
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            const idPromotion = document.createElement('input');
                            idPromotion.type = 'hidden';
                            idPromotion.name = 'id';
                            idPromotion.value = promotionId;
                            form.appendChild(idPromotion);

                            // Adiciona o método DELETE
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            // Adiciona o formulário ao corpo do documento e o envia
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Mostrar/ocultar campos de serviço com base no tipo de promoção
            document.getElementById('promotionType').addEventListener('change', function() {
                if (this.value === 'individual') {
                    document.querySelector('.individual-service').classList.remove('d-none');
                    document.querySelector('.combo-service').classList.add('d-none');
                    document.getElementById('promotionForm').action = "{{ route('collaborator.promotion.add.individual', ['tokenCompany' => $tokenCompany]) }}";
                } else if (this.value === 'combo') {
                    document.querySelector('.individual-service').classList.add('d-none');
                    document.querySelector('.combo-service').classList.remove('d-none');
                    document.getElementById('promotionForm').action = "{{ route('collaborator.promotion.add.combo', ['tokenCompany' => $tokenCompany]) }}";
                }
            });

            // Função para limpar o formulário de promoção
            function clearPromotionForm() {
                document.getElementById('promotionId').value = '';
                document.getElementById('promotionName').value = '';
                document.getElementById('promotionStartDate').value = '';
                document.getElementById('promotionEndDate').value = '';
                document.getElementById('promotionType').value = 'individual';
                document.getElementById('promotionService').value = '';
                document.querySelectorAll('input[name="services[]"]').forEach(checkbox => checkbox.checked = false);
                document.getElementById('promotionValue').value = '';
                document.getElementById('promotionEnabled').checked = true;
                document.querySelector('.individual-service').classList.remove('d-none');
                document.querySelector('.combo-service').classList.add('d-none');
                document.getElementById('promotionForm').action = "{{ route('collaborator.promotion.add.individual', ['tokenCompany' => $tokenCompany]) }}";
            }
        });
    </script>
</x-layoutCollaborator>
