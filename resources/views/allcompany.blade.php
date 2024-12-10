<x-guest-layout>
    <x-slot name="header">
        <h2 class="flex justify-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight sm:flex sm:items-center sm:justify-start">
            <x-barber-icon widht="24px" height="24px"/>
            {{ __('Seja Bem vindo ao MyCorte') }}
        </h2>
    </x-slot>
    <div class="title-home bg-[#3a497684] rounded-[10px]">
        <livewire:components.inputs.search-company />
    </div>

    <div class="alert-container">
        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-regular fa-circle-check"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p style="margin-bottom: 5px;"><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
    </div>



    <section class="container mt-4">
        <div class="row" id="company-cards">
            @foreach ($companies as $company)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom">
                        @if ($company->promotions->isNotEmpty())
                            <div class="promotion-label animate__animated animate__pulse">Promoção</div>
                        @endif
                        <div class="profile-collaborator">
                            <img src="{{ $company->style->logo }}" alt="Profile Picture">
                            <h3 class="mt-2">{{ $company->name }}</h3>
                        </div>
                        <div class="status">
                            <ul class="list-address">
                                <li><strong>Cidade:</strong><a> {{ $company->city }}</a></li>
                                <li><strong>Número:</strong><a> {{ $company->number }}</a></li>
                                <li><strong>Bairro:</strong><a> {{ $company->neighborhood }}</a></li>
                                <li><strong>Estado:</strong><a> {{ $company->state }}</a></li>
                            </ul>
                        </div>
                        <div class="buttons-home">
                            <button class="btn btn-dark btn-map" data-bs-toggle="modal" data-bs-target="#localizationModal" data-localization="{{ $company->localization }}">Localização</button>
                            <a class="btn btn-dark" href="{{ route('homeclient', ['tokenCompany' => $company->token]) }}">Agendar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

{{--    <div id="localizationModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered">--}}
{{--            <div class="modal-content modal-myaccount-localization" style="max-width: 450px !important;">--}}
{{--                <div class="header-modal-localization" style="background-color: #3a4976;">--}}
{{--                    <p class="title-localization" style="color: white;">LOCALIZAÇÃO DA EMPRESA</p>--}}
{{--                </div>--}}
{{--                <div class="body-localizacao">--}}
{{--                    <div id="map-container" style="height: 400px;"></div>--}}
{{--                    <div class="buttons-modalLocalization">--}}
{{--                        <button type="button" class="btn btn-primary" id="exitModalLocalization">Fechar</button>--}}
{{--                        <button type="submit" class="btn btn-primary" id="goMaps">Ir Para o Maps</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>    <div id="localizationModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered">--}}
{{--            <div class="modal-content modal-myaccount-localization" style="max-width: 450px !important;">--}}
{{--                <div class="header-modal-localization" style="background-color: #3a4976;">--}}
{{--                    <p class="title-localization" style="color: white;">LOCALIZAÇÃO DA EMPRESA</p>--}}
{{--                </div>--}}
{{--                <div class="body-localizacao">--}}
{{--                    <div id="map-container" style="height: 400px;"></div>--}}
{{--                    <div class="buttons-modalLocalization">--}}
{{--                        <button type="button" class="btn btn-primary" id="exitModalLocalization">Fechar</button>--}}
{{--                        <button type="submit" class="btn btn-primary" id="goMaps">Ir Para o Maps</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <script>
        $(document).ready(function() {
            // Inicializa o modal do Bootstrap
            const modalElement = document.getElementById('localizationModal');
            const modal = new bootstrap.Modal(modalElement, {
                keyboard: false
            });

            // Abre o modal e define o conteúdo do mapa
            $('.btn-map').click(function() {
                var localization = $(this).data('localization');
                $('#map-container').html(localization);
                modal.show();
            });

            // Fecha o modal ao clicar no botão "Fechar"
            $('#exitModalLocalization').click(function() {
                modal.hide();
            });

            // Abre o Google Maps em uma nova aba ao clicar no botão "Ir Para o Maps"
            $('#goMaps').click(function() {
                var mapUrl = $('#map-container').find('iframe').attr('src');
                if (mapUrl) {
                    window.open(mapUrl, '_blank');
                }
            });

            // Fecha o modal ao clicar fora do conteúdo do modal
            $(window).click(function(event) {
                if ($(event.target).is(modalElement)) {
                    modal.hide();
                }
            });
        });
    </script>


    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f544d27515.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this, args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            const fetchCompanies = debounce(function(query) {
                $('#loading-spinner').removeClass('d-none');  // Mostrar o spinner

                $.ajax({
                    url: "{{ route('search.companies') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        $('#company-cards').html('');
                        if (data.length === 0) {
                            $('#company-cards').html(`
                            <p>Nenhuma empresa encontrada</p>
                            <p><a href="#" id="show-all-companies" style="text-decoration: underline; color: blue;">Mostrar todas as empresas</a></p>
                            `);
                        } else {
                            $.each(data, function(index, company) {
                                $('#company-cards').append(`
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-custom">
                                            ${company.promotions.length ? '<div class="promotion-label animate__animated animate__pulse">Promoções</div>' : ''}
                                            <div class="profile-collaborator">
                                                <img src="${company.style.logo}" alt="Profile Picture">
                                                <h3 class="mt-2">${company.name}</h3>
                                            </div>
                                            <div class="status">
                                                <ul class="list-address">
                                                    <li><strong>Cidade:</strong><a> ${company.city}</a></li>
                                                    <li><strong>Número:</strong><a> ${company.number}</a></li>
                                                    <li><strong>Bairro:</strong><a> ${company.neighborhood}</a></li>
                                                    <li><strong>Estado:</strong><a> ${company.state}</a></li>
                                                </ul>
                                            </div>
                                            <div class="buttons-home">
                                                <button class="btn btn-dark btn-map" data-bs-toggle="modal" data-bs-target="#localizationModal" data-localization="${company.localization}">Localização</button>
                                                <a class="btn btn-dark" href="{{ route('homeclient', ['tokenCompany' => '` + company.token + `']) }}">Agendar</a>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        }
                        $('#loading-spinner').addClass('d-none');  // Ocultar o spinner
                    },
                    error: function() {
                        $('#company-cards').html('<p>Erro ao buscar empresas. Tente novamente.</p>');
                        $('#loading-spinner').addClass('d-none');  // Ocultar o spinner
                    }
                });
            }, 500);

            $('#search-input').on('input', function() {
                fetchCompanies($(this).val());
            });

            $('#show-all-companies').click(function(e) {
                e.preventDefault();
                $('#search-input').val('');
                fetchCompanies('');
            });
        });
    </script>
</x-guest-layout>
