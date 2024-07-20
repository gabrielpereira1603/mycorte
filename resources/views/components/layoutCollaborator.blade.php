<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
        <link rel="stylesheet" href="{{ asset('css/collaborator/headerCollaborator.css') }}">
        <link rel="stylesheet" href="{{ asset('css/collaborator/homeCollaborator.css') }}">
        <link rel="stylesheet" href="{{ asset('css/collaborator/servicesCollaborator.css') }}">
        <link rel="stylesheet" href="{{ asset('css/collaborator/dashboardCollaborator.css') }}">
        <link rel="stylesheet" href="{{ asset('css/collaborator/configurations/configCollaborator.css') }}">

        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>{{ $title ?? 'MyCorte' }}</title>
        <style>
            .alert-container {
                position: fixed;
                top: 70px; /* Ajuste conforme necessário */
                right: 20px;
                z-index: 9999;
                width: 300px; /* Defina um tamanho fixo para o alerta */
            }
            .alert {
                width: 100%;
            }
        </style>
    </head>

    <body style="margin-left: 100px; padding: 16px">
        @include('Collaborator.Header.headerCollaborador', ['tokenCompany' => $tokenCompany])

        <div class="alert-container">
            <!-- Alert Section -->
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
        {{ $slot }}

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/f544d27515.js" crossorigin="anonymous"></script>

        <script>
            // Set a timeout to hide the alerts after 10 seconds
            window.setTimeout(function() {
                // Select all alerts and fade them out
                document.querySelectorAll('.alert').forEach(function(alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    alert.style.opacity = '0';
                    // After the fade out transition is complete, remove the alert from the DOM
                    setTimeout(function() {
                        alert.remove();
                    }, 500); // Wait for the fade out transition to finish
                });
            }, 10000); // 10000 milliseconds = 10 seconds
        </script>
    </body>
</html>
