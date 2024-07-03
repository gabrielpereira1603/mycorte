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

        <!-- Mensagem de Sucesso -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mensagem de Erro -->
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="post" action="{{ route('loginclient.post') }}">
            @csrf
            <div class="input-wrapper">
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
                <button class="button btn-primary" type="submit">
                    Entrar Agora
                </button>
                <div class="divider">
                    <div></div>
                    <span class="divider-text">OU</span>
                    <div></div>
                </div>
                <a class="button btn-secondary" href="">Cadastre-se Agora</a>
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
<!--StyleHeader-->
<script src="https://kit.fontawesome.com/f544d27515.js" crossorigin="anonymous"></script>
</body>
</html>
