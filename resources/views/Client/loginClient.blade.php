<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/client/loginClient.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Entrar</title>
</head>
<body>
<main>
    <section class="form-section">
        <img src="{{ asset('images/logoLetraAzul.png') }}" alt="Logo">
        <h2>Acesse sua conta</h2>
        <form method="post" action="{{ route('loginclient.post', ['tokenCompany' => $tokenCompany]) }}">
            @csrf
            <div class="input-wrapper">
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

                <label for="email">Email</label>
                <div class="input-content">
                    <input type="email" id="email" placeholder="jhon@email.com" name="email" value="{{ old('email') }}">
                    <div class="icon">
                        <img src="{{ asset('images/icons/iconEmail.svg') }}" alt="Email Icon">
                    </div>
                </div>
            </div>
            <div class="input-wrapper">
                <label for="password">Sua Senha</label>
                <div class="input-content">
                    <input type="password" id="password" placeholder="******" name="password">
                    <div class="icon">
                        <img src="{{ asset('images/icons/iconPassword.svg') }}" alt="Password Icon">
                    </div>
                </div>
            </div>
            <span>Recuperar Senha?</span>
            <div class="btn-wrapper">
                <button class="button btn-primary" type="submit" id="submitBtn" onclick="handleLogin()">
                    Entrar Agora
                </button>
                <div class="divider">
                    <div></div>
                    <span class="divider-text">OU</span>
                    <div></div>
                </div>
                <a class="button btn-secondary" href="{{ route('singupclient', ['tokenCompany' => $tokenCompany]) }}" id="singupBtn" onclick="handleLink('singupBtn')">Cadastre-se Agora</a>
            </div>
        </form>
    </section>
    <section class="main-section">
        <h1>Com o <span>My Corte,</span></h1>
        <h5>seu cabelo sempre
            <span>em dia</span>
            , no <span>horário certo</span>
            , sem dor de cabeça <span>
            nem agonia!</span>
        </h5>
        <img src="{{ asset('images/sapiens/cutSappiensLogin.svg') }}" alt="Background">
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="{{ asset('js/sweetAlert/alerts.js') }}"></script>
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
