<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/allCompany.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>MyCorte</title>
</head>
<body>
<header>
    <nav class="nav-allcompany">
        <img src="{{ asset('favicon.png') }}" alt="Logo MyCuts">
    </nav>
</header>

<div class="title-home" style="background-color: #3a497684;">
    <h3 style="color: white;">Seja Bem Vindo ao MyCorte</h3>
    <p style="color: white;">Essas são as empresas parceiras:</p>
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

<div class="container mt-4">
    <div class="input-group">
        <span class="input-group-text">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="text" id="search-input" class="form-control" placeholder="Pesquisar...">
    </div>
    <p class="search-info">Você pode buscar por qualquer informação relacionada às empresas parceiras.</p>
    <div id="loading-spinner" class="d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>


<section class="container mt-4">
    <div class="row" id="company-cards">
        @foreach ($companies as $company)
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom" style="border: solid black 1px;">
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


<div id="localizationModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-myaccount-localization" style="max-width: 450px !important;">
            <div class="header-modal-localization" style="background-color: #3a4976;">
                <p class="title-localization" style="color: white;">LOCALIZAÇÃO DA EMPRESA</p>
            </div>
            <div class="body-localizacao">
                <div id="map-container" style="height: 400px;"></div>
                <div class="buttons-modalLocalization">
                    <button type="button" class="btn btn-primary" id="exitModalLocalization">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="goMaps">Ir Para o Maps</button>
                </div>
            </div>
        </div>
    </div>
</div>


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

@include('Client.Footer.footerClient')

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
                        <p><a href="#" id="show-all-companies" style="text-decoration: underline;">Ver todas disponíveis...</a></p>
                    `);
                        $('#show-all-companies').click(function(e) {
                            e.preventDefault();
                            window.location.href = "{{ route('allCompany') }}"; // Recarregar a página na rota allCompany
                        });
                    } else {
                        $.each(data, function(key, company) {
                            var card = `
                            <div class="col-md-6 col-lg-4">
                                <div class="card card-custom" style="border: solid black 1px;">
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
                                        <a class="btn btn-dark" href="">Endereço</a>
                                        <a class="btn btn-dark" href="{{ route('homeclient', ['tokenCompany' => '` + company.token + `']) }}">Agendar</a>
                                    </div>
                                </div>
                            </div>
                        `;
                            $('#company-cards').append(card);
                        });
                    }
                    $('#loading-spinner').addClass('d-none');  // Esconder o spinner
                },
                error: function() {
                    $('#loading-spinner').addClass('d-none');  // Esconder o spinner em caso de erro
                }
            });
        }, 300);

        $('#search-input').on('keyup', function() {
            const query = $(this).val();
            if (query.length === 0) {
                window.location.reload(); // Reload page to show all companies
            } else {
                fetchCompanies(query);
            }
        });
    });


</script>
</body>
</html>
