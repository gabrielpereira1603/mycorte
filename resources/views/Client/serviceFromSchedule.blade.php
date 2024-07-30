<x-layoutClient :tokenCompany="$tokenCompany">
    <section class="service-section">
        <div class="service-title">
            <div class="service-logoCollaborator">
                <img src="{{ $collaborator->image }}" alt="Perfil Colaborador">
                <h1>{{ $collaborator->name }}</h1>
            </div>
            <div class="service-profileCollaborator">
                <h5 class="service-info">
                    <span class="iconService">
                        <img src="{{ asset('images/icons/horarioIcon.png') }}" alt="Icon Horário">
                    </span>
                    <strong>Horário:</strong>
                    {{ $data['start'] }} | {{ $data['end'] }}
                </h5>
                <h5 class="service-info">
                    <span class="iconService">
                        <img src="{{ asset('images/icons/calendarioIcon.png') }}" alt="Icon Data">
                    </span>
                    <strong>Data: </strong>{{ $data['date'] }}
                </h5>
            </div>
            <div class="service-buttons">
                <a class="btn btn-danger" href="{{ $redirectButton }}"><i class="fa-solid fa-triangle-exclamation"></i> {{ $redirectMessage }}</a>
            </div>
        </div>
    </section>

    <h1 style="text-align: center; margin-bottom: 30px;">Selecione os serviços:</h1>
    <form>
        <input type="hidden" name="start" value="start">
        <input type="hidden" name="end" value="end">
        <input type="hidden" name="date" value="date">

        <div class="main-services">
            <div class="option">
                @foreach($services as $service)
                    @php
                        // Verifica se há uma promoção para o serviço
                        $promotion = $promotions->firstWhere('servicefk', $service->id);
                    @endphp
                    <div class="option-info">
                        <h5 class="option-name text-truncate">
                            <span class="icon-option">
                                <img class="service-icon unselected" src="{{ asset('images/icons/barbeiro.png') }}" alt="Logo Service" width="50">
                            </span>
                            <span class="service-name">{{ $service->name }}</span>
                        </h5>
                        <div class="option-checkBox toggle-checkbox">
                            <span class="option-price price-value">
                                @if($promotion)
                                    <span class="price-original">R$ {{ number_format($service->value, 2, ',', '.') }}</span>
                                    <span class="price-promotion">R$ {{ number_format($promotion->value, 2, ',', '.') }}</span>
                                @else
                                    R$ {{ number_format($service->value, 2, ',', '.') }}
                                @endif
                            </span>
                            <input type="checkbox" class="service-checkbox" id="{{ $service->name }}" data-price="{{ $promotion ? $promotion->value : $service->value }}" value="{{ $service->id }}" name="services[]">
                            <label for="{{ $service->name }}"></label>
                        </div>
                    </div>
                    <div class="divider-service">
                        <div></div>
                    </div>
                @endforeach

                <div class="total-price">
                    <h5 class="total-price-text">
                        <span class="total-price-span">
                            <img class="total-price-icon" src="{{ asset('images/icons/barbeiro.png') }}" alt="Logo Service" width="50">
                        </span>
                        Total:
                    </h5>
                    <div class="mount-price">
                        <span class="total">R$ 00,00</span>
                    </div>
                </div>

                @php
                    $onClick = auth()->guard('client')->check() ? 'openConfirmScheduleModal(event)' : 'openLoginModal(event)';
                @endphp
                <div class="button-agendar">
                    <button class="btn btn-primary" id="scheduleButton" type="button" onclick="{{ $onClick }}">Agendar Serviço</button>
                </div>
            </div>
        </div>

        <input type="hidden" id="totalPrice" name="totalPrice" value="">
    </form>


    <div class="modal fade seminor-login-modal" data-backdrop="static" id="modalSingup-ServiceFromSchedule">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 450px !important;">
                <div class="modal-body seminor-login-modal-body">
                    <h5 class="modal-title text-center">Crie sua conta agora</h5>
                    <form class="seminor-login-form" id="singupForm-serviceFromSchedule" method="post" action="{{ route('singupclient.post', ['tokenCompany' => $tokenCompany]) }}">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" required>
                            <label class="form-control-placeholder" >Nome</label>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" name="email" required>
                            <label class="form-control-placeholder" >Email</label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="telephone" required>
                            <label class="form-control-placeholder" >Telefone</label>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="password" required>
                            <label class="form-control-placeholder" >Senha</label>
                        </div>

                        <div class="form-group forgot-pass-fau text-center ">
                            <a href="/terms-conditions/" class="text-secondary">
                                Ao clicar em "Registre-se" você está aceitando os<br>
                                <span class="text-primary-fau">Termos e Condições</span>
                            </a>
                        </div>

                        <div class="btn-check-log">
                            <button type="submit" class="btn-check-login">
                                <span id="singupButtonContent-ServiceFromSchedule">Registre-se</span>
                                <span id="singupLoader-ServiceFromSchedule" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" style="color: inherit"></span>
                                <span id="singupLoadingText-ServiceFromSchedule" class="ml-2 d-none">Carregando...</span>
                            </button>

                        </div>

                        <div class="forgot-pass-fau text-center pt-3" >
                            <a href="#" class="text-secondary ms-3" onclick="openLoginModal(event)">Entar?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade seminor-login-modal" data-backdrop="static" id="modalLogin-ServiceFromSchedule">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 450px !important;">
                <div class="modal-body seminor-login-modal-body">
                    <h5 class="modal-title text-center">Entrar</h5>
                    <form id="loginForm-serviceFromSchedule" class="seminor-login-form" method="post" action="{{ route('loginclient.post', ['tokenCompany' => $tokenCompany]) }}">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                        <div class="form-group">
                            <input type="email" class="form-control" required name="email">
                            <label class="form-control-placeholder">Email</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" required name="password">
                            <label class="form-control-placeholder">Senha</label>
                        </div>

                        <div class="btn-check-log">
                            <button id="loginButton" type="submit" class="btn-check-login">
                                <span id="loginButtonContent-ServiceFromSchedule">Entrar</span>
                                <span id="loginLoader-ServiceFromSchedule" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" style="color: inherit"></span>
                                <span id="loginLoadingText-ServiceFromSchedule" class="ml-2 d-none">Carregando...</span>
                            </button>
                        </div>

                        <div class="forgot-pass-fau text-center pt-3" >
                            <a class="text-secondary" onclick="">Esqueceu a senha?</a>
                            <a href="#" class="text-secondary ms-3" onclick="openSingupModal(event)">Criar Conta?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade service-fromSchedule" data-backdrop="static" id="modalConfirm-ServiceFromSchedule">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 450px !important;">
                <div class="modal-body">
                    <h5 class="modal-title text-center mb-2">Confirme o agendamento</h5>
                    <form id="modalForm-serviceFromSchedule" method="post" action="{{ $data['redirectController'] }}" style="padding-top: 10px">
                        @csrf
                        <input type="hidden" name="scheduleId" value="{{ $data['scheduleId'] }}">
                        <input type="hidden" name="start" value="{{ $data['start'] }}">
                        <input type="hidden" name="end" value="{{ $data['end'] }}">
                        <input type="hidden" name="date" value="{{ $data['date'] }}">
                        <input type="hidden" name="tokenCompany" value="{{ $tokenCompany }}">
                        <input type="hidden" name="idCollaborator" value="{{ $collaborator->id }}">
                        <input type="hidden" name="totalPriceModal" id="totalPriceModal" value="">
                        <input type="hidden" name="selectedServicesModal" id="selectedServicesModal" value="">

                        <div class="displaySchedule">
                            <div class="dataDisplay">
                            <span class="iconService">
                                <img src="{{ asset('images/icons/calendarioIcon.png') }}" alt="Icon Data">
                            </span>
                                <p>Data do agendamento: <span style="background-color: rgba(58,73,118,0.31); padding: 4px; border-radius: 5px; border: 1px solid black">{{ $data['date'] }}</span></p>
                            </div>

                            <div class="timeDisplay">
                                <div class="startEndDisplay">
                                <span class="iconService">
                                    <img src="{{ asset('images/icons/horarioIcon.png') }}" alt="Icon Horário">
                                </span>
                                    <p>Hora de Início: <span style="background-color: rgba(58,73,118,0.31); padding: 4px; border-radius: 5px; border: 1px solid black">{{ $data['start'] }}</span></p>
                                </div>

                                <div class="startEndDisplay">
                                <span class="iconService">
                                    <img src="{{ asset('images/icons/horarioIcon.png') }}" alt="Icon Horário">
                                </span>
                                    <p>Hora de Fim: <span style="background-color: rgba(58,73,118,0.31); padding: 4px; border-radius: 5px; border: 1px solid black">{{ $data['end'] }}</span></p>
                                </div>
                            </div>

                            <!-- Adicione esta área para mostrar os serviços selecionados e o preço total -->
                            <div id="selectedServicesDisplay"></div>

                            <div class="total-price-display mb-4">
                                <strong>Total: R$ <span id="displayTotalPrice">0.00</span></strong>
                            </div>
                        </div>

                        <div class="btn-check-log" id="boxButton-InsertSchedule">
                            <button id="insertScheduleButton" type="submit" class="btn btn-success">
                                <span id="insertScheduleButtonContent-ServiceFromSchedule">Confirmar</span>
                                <span id="insertSchedule-ServiceFromSchedule" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" style="color: inherit"></span>
                                <span id="insertScheduleLoadingText-ServiceFromSchedule" class="ml-2 d-none">Carregando...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var totalPrice = 0;
            var selectedServices = [];


            //load no botao de login do modal
            $('#loginForm-serviceFromSchedule').on('submit', function(event) {
                // Mostra o texto "Carregando..." e o spinner de carregamento
                $('#loginButtonContent-ServiceFromSchedule').addClass('d-none');
                $('#loginLoader-ServiceFromSchedule').removeClass('d-none');
                $('#loginLoadingText-ServiceFromSchedule').removeClass('d-none');
            });

            //load no botao de singup do modal
            $('#singupForm-serviceFromSchedule').on('submit', function(event) {
                // Mostra o texto "Carregando..." e o spinner de carregamento
                $('#singupButtonContent-ServiceFromSchedule').addClass('d-none');
                $('#singupLoader-ServiceFromSchedule').removeClass('d-none');
                $('#singupLoadingText-ServiceFromSchedule').removeClass('d-none');
            });

            //load no botao de confirmal servicos e horarios do modal
            $('#modalForm-serviceFromSchedule').on('submit', function(event) {
                // Mostra o texto "Carregando..." e o spinner de carregamento
                $('#insertScheduleButtonContent-ServiceFromSchedule').addClass('d-none');
                $('#insertSchedule-ServiceFromSchedule').removeClass('d-none');
                $('#insertScheduleLoadingText-ServiceFromSchedule').removeClass('d-none');
            });

            // Função para atualizar o total
            function updateTotal() {
                var totalElement = document.querySelector('.mount-price .total');
                var totalPriceInput = document.getElementById('totalPrice');
                totalElement.textContent = 'R$ ' + totalPrice.toFixed(2);
                totalPriceInput.value = totalPrice.toFixed(2);
            }

            // Função para atualizar os serviços selecionados no modal
            function updateModalInputs() {
                var selectedServicesInput = document.getElementById('selectedServicesModal');
                var totalPriceModalInput = document.getElementById('totalPriceModal');

                // Ajuste aqui para enviar apenas os IDs dos serviços selecionados
                var serviceIds = selectedServices.map(service => service.id);
                selectedServicesInput.value = serviceIds.join(','); // Envio dos IDs separados por vírgula

                totalPriceModalInput.value = totalPrice.toFixed(2);

                // Atualiza a exibição dos serviços selecionados e do preço total no modal
                var selectedServicesDisplay = document.getElementById('selectedServicesDisplay');
                var displayTotalPrice = document.getElementById('displayTotalPrice');
                selectedServicesDisplay.innerHTML = '';
                selectedServices.forEach(function(service) {
                    var serviceElement = document.createElement('p');
                    serviceElement.className = 'selected-service-item';
                    serviceElement.innerHTML = '<img src="https://i.postimg.cc/8c08m66C/select-Icon.png" class="selected-service-icon" /> ' + service.name + ': <span class="service-price">R$ ' + service.price.toFixed(2) + '</span>';
                    selectedServicesDisplay.appendChild(serviceElement);
                });
                displayTotalPrice.textContent = 'R$ ' + totalPrice.toFixed(2);
            }


            // Função para salvar os serviços selecionados no localStorage
            function saveSelectedServices() {
                localStorage.setItem('selectedServices', JSON.stringify(selectedServices));
            }

            // Função para carregar os serviços selecionados do localStorage, se existirem
            function loadSelectedServices() {
                var savedServices = localStorage.getItem('selectedServices');
                if (savedServices) {
                    selectedServices = JSON.parse(savedServices);
                    $('.service-checkbox').each(function() {
                        var checkbox = $(this);
                        var checkboxId = checkbox.val();
                        var serviceExists = selectedServices.some(function(service) {
                            return service.id == checkboxId;
                        });
                        var $icon = checkbox.closest('.option-info').find('.service-icon');

                        if (serviceExists) {
                            checkbox.prop('checked', true);
                            $icon.removeClass('unselected').addClass('selected');
                        } else {
                            checkbox.prop('checked', false);
                            $icon.removeClass('selected').addClass('unselected');
                        }
                    });
                    calculateTotalPrice();
                }
            }

            // Função para calcular o preço total com base nos serviços marcados
            function calculateTotalPrice() {
                totalPrice = 0;
                selectedServices = [];
                $('.service-checkbox:checked').each(function() {
                    var price = parseFloat($(this).attr('data-price'));
                    var name = $(this).attr('id');
                    var id = $(this).val();
                    totalPrice += price;
                    selectedServices.push({
                        id: id,
                        name: name,
                        price: price
                    });
                });
                updateTotal();

                if (totalPrice > 0) {
                    // Habilita o botão de agendar se algum serviço estiver selecionado
                    $('#scheduleButton').prop('disabled', false);
                } else {
                    // Desabilita o botão de agendar se nenhum serviço estiver selecionado
                    $('#scheduleButton').prop('disabled', true);
                }
            }

            // Evento de mudança nos checkboxes
            $('.service-checkbox').on('change', function() {
                var $checkbox = $(this);
                var price = parseFloat($checkbox.attr('data-price'));
                var name = $checkbox.attr('id');
                var id = $checkbox.val();
                var $icon = $checkbox.closest('.option-info').find('.service-icon');
                var $label = $checkbox.siblings('label');

                if ($checkbox.is(':checked')) {
                    selectedServices.push({
                        id: id,
                        name: name,
                        price: price
                    });
                    $icon.removeClass('unselected').addClass('selected animate__animated animate__bounceIn');
                    $label.addClass('checked');
                } else {
                    selectedServices = selectedServices.filter(function(service) {
                        return service.id !== id;
                    });
                    $icon.removeClass('selected animate__animated animate__bounceIn').addClass('unselected');
                    $label.removeClass('checked');
                }

                saveSelectedServices(); // Salvar no localStorage sempre que houver mudança
                calculateTotalPrice();
            });

            // Carregar serviços selecionados do localStorage ao carregar a página
            loadSelectedServices();

            // Função para abrir o modal de login
            window.openLoginModal = function(event) {
                event.preventDefault();
                updateModalInputs(); // Atualizar os inputs do modal
                $('#modalSingup-ServiceFromSchedule').modal('hide'); // Fecha o modal de singup
                $('#modalLogin-ServiceFromSchedule').modal('show'); // Mostrar o modal de login
            }

            // Função para abrir o modal de singup
            window.openSingupModal = function(event) {
                event.preventDefault();
                updateModalInputs(); // Atualizar os inputs do modal
                $('#modalLogin-ServiceFromSchedule').modal('hide'); // Fecha o modal de login
                $('#modalSingup-ServiceFromSchedule').modal('show'); // Mostrar o modal de login
            }

            // Função para abrir o modal de confirmação de agendamento
            window.openConfirmScheduleModal = function(event) {
                event.preventDefault();
                updateModalInputs(); // Atualizar os inputs do modal
                $('#modalConfirm-ServiceFromSchedule').modal('show'); // Mostrar o modal de confirmação de agendamento
            }

            // Evento de clique no botão fechar do modal
            $('.close').on('click', function() {
                $('#modalLogin-ServiceFromSchedule').modal('hide');
            });

            $('#modalForm-serviceFromSchedule').on('submit', function(event) {
                // Limpa apenas os itens relacionados aos serviços selecionados no localStorage
                localStorage.removeItem('selectedServices');

                // Desativa todos os checkboxes
                $('.service-checkbox').prop('checked', false);

                // Limpa o localStorage antes de enviar o formulário
                localStorage.clear();
            });
        });

    </script>
</x-layoutClient>
