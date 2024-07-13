<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/collaborator/loginCollaborator.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Entrar</title>
</head>
    <body>
        <main>
            <div class="main-login">

                <div class="main-logo">
                    <img src="{{ asset('images/logoLetraBranca.png') }}" alt="Logo MyCorte" width="200">
                </div>

                <form class="main-form" method="post" action="{{ route('logincollaborator.post',['tokenCompany' => $tokenCompany]) }}">
                    @csrf
                    <div class="title-form">
                        <h3>Entrar</h3>
                    </div>

                    <div class="mb-3">
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                <i class="fa-solid fa-triangle-exclamation"></i> {{ Session::get('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fa-regular fa-circle-check"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <p style="margin-bottom: 5px;"><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</p>
                                </div>
                            @endforeach
                        @endif
                        <label for="identifier" class="form-label">E-mail ou Telefone</label>
                        <input type="text" class="form-control" id="identifier" placeholder="Digite seu e-mail ou telefone" name="identifier" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" placeholder="Digite sua senha" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Entrar</button>

                    <a class="resetPassword" href="#" onclick="openResetPasswordModal()">Esqueceu a senha?</a>
                </form>
            </div>
        </main>
        <script>
            function openResetPasswordModal() {
                Swal.fire({
                    title: 'Redefinir Senha',
                    text: 'Por favor, insira seu e-mail para redefinir sua senha.',
                    input: 'email',
                    inputLabel: 'Seu e-mail',
                    inputPlaceholder: 'Digite seu e-mail aqui',
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Você precisa inserir um e-mail!';
                        }
                        // Validar se o e-mail é válido (opcional)
                        if (!/\S+@\S+\.\S+/.test(value)) {
                            return 'Por favor, insira um e-mail válido!';
                        }
                    },
                    customClass: {
                        container: 'swal2-container' // Adiciona uma classe personalizada para garantir que o SweetAlert2 não afete o layout
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redireciona para a rota de redefinição de senha com o e-mail
                        window.location.href = `/password/reset?email=${encodeURIComponent(result.value)}`;
                    }
                });
            }
        </script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/f544d27515.js" crossorigin="anonymous"></script>

        <script>
            // Set a timeout to hide the alerts after 10 seconds
            window.setTimeout(function() {
                // Select all alerts and fade them out
                document.querySelectorAll('.alert').forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease-in-out';
                    alert.style.opacity = '0';
                    // After the fade out transition is complete, remove the alert from the DOM
                    setTimeout(function() {
                        alert.remove();
                    }, 500); // Wait for the fade out transition to finish
                });
            }, 10000); // 10000 milliseconds = 10 seconds

            function handleLogin() {
                document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm" style="color: white !important;" role="status" aria-hidden="true"></span> Carregando...';
                document.getElementById('loginForm').submit();
            }

            function handleLink(buttonId) {
                document.getElementById(buttonId).innerHTML = '<span class="spinner-border spinner-border-sm" style="color: inherit !important;" role="status" aria-hidden="true"></span> Carregando...';
            }
        </script>
    </body>
</html>
