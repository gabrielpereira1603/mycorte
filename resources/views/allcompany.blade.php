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
    </head>
    <body>
        <header>
            <nav class="nav-allcompany">
                <img src="{{ asset('favicon.png') }}" alt="Logo MyCuts">
            </nav>
        </header>

        <div class="title-home" style="background-color: #3a497684;">
            <h3 style="color: white;">Seja Bem Vindo ao MyCuts</h3>
            <p style="color: white;">Essas são as empresas parceiras</p>
        </div>

        <div class="container mt-4">
            <div class="input-group">
        <span class="input-group-text">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
                <input type="text" id="search-input" class="form-control" placeholder="Pesquisar...">
            </div>
            <p class="search-info">Você pode buscar por qualquer informação relacionada às empresas parceiras.</p>
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
                                <a class="btn btn-dark" href="">Endereço</a>
                                <a class="btn btn-dark" href="{{ route('homeclient', ['tokenCompany' => $company->token]) }}">Agendar</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

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

        @include('Client.Footer.footerClient')

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/f544d27515.js" crossorigin="anonymous"></script>

        <script>
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this, args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            $(document).ready(function() {
                const fetchCompanies = debounce(function(query) {
                    $.ajax({
                        url: "{{ route('search.companies') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#company-cards').html('');
                            if (data.length === 0) {
                                $('#company-cards').html('<p>Nenhuma empresa encontrada</p>');
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
