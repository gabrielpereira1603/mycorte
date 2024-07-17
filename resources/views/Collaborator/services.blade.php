<x-layoutCollaborator title="Serviços" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Seus Serviços</h4>
    </div>

    @if($services->isEmpty())
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header">
                Serviços
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                <img src="{{ asset('images/icons/emojiSadIcon.png') }}" alt="Emoji Triste" width="200">
                <p style="text-align: center; color: #9C9C9C">Nenhum serviço disponível</p>
            </div>
        </div>
    @else
        <div class="card" style="width: 100%; margin: 20px auto;">
            <div class="card-header">
                Serviços
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
                                    Valor: R$ {{ $service->value }}
                                </p>
                            </div>
                            <div class="box-buttons">
                                <button class="btn btn-primary edit-service-btn" data-service-id="{{ $service->id }}">
                                    <i class="fa-solid fa-pen"></i> Editar Serviço
                                </button>
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

            // Adiciona evento de clique aos botões "Editar Serviço"
            var editServiceButtons = document.querySelectorAll('.edit-service-btn');
            editServiceButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var serviceId = this.getAttribute('data-service-id');
                    window.location.href = `/services/${serviceId}/edit`;
                });
            });
        });
    </script>
</x-layoutCollaborator>
