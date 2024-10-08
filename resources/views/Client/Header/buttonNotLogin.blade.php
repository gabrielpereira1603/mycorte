<form class="d-flex form-header">
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 mb-2">
        <button type="button" class="btn btn-success d-flex align-items-center justify-content-center no-wrap flex-grow-1 mb-sm-0" id="btn-login-header" data-bs-toggle="modal" data-bs-target="#sem-login" style="margin-bottom: 0px;">
            <i class="fa-solid fa-right-to-bracket me-2"></i>
            Entrar
        </button>
        <div class="divider">
            <div></div>
            <span>ou</span>
            <div></div>
        </div>
        <button type="button" class="btn btn-success d-flex align-items-center justify-content-center no-wrap flex-grow-1 mt-sm-0" id="btn-singup-header" data-bs-toggle="modal" data-bs-target="#sem-reg">
            <i class="fa-solid fa-user-plus me-2"></i>
            Registrar-se
        </button>
    </div>
</form>

<!-- The Modal -->
<div class="modal fade seminor-login-modal" data-backdrop="static" id="sem-reg">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="max-width: 450px !important;">
            <div class="modal-body seminor-login-modal-body">
                <h5 class="modal-title text-center">Crie sua conta agora</h5>
                <form class="seminor-login-form" id="singupForm" method="post" action="{{ route('singupclient.post', ['tokenCompany' => $tokenCompany]) }}">
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
                        <a href="{{ route('terms-of-use') }}" class="text-secondary">
                            Ao clicar em "Registre-se" você está aceitando os<br>
                            <span class="text-primary-fau">Termos e Condições</span>
                        </a>
                    </div>

                    <div class="btn-check-log">
                        <button type="submit" class="btn-check-login">
                            <span id="singupButtonContent">Registre-se</span>
                            <span id="singupLoader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" style="color: inherit"></span>
                            <span id="singupLoadingText" class="ml-2 d-none">Carregando...</span>
                        </button>

                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#singupForm').on('submit', function(event) {
                                // Mostra o texto "Carregando..." e o spinner de carregamento
                                $('#singupButtonContent').addClass('d-none');
                                $('#singupLoader').removeClass('d-none');
                                $('#singupLoadingText').removeClass('d-none');
                            });
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seminor-login-modal" data-backdrop="static" id="sem-login">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="max-width: 450px !important;">
            <div class="modal-body seminor-login-modal-body">
                <h5 class="modal-title text-center">Entrar</h5>
                <form id="loginForm" class="seminor-login-form" method="post" action="{{ route('loginclient.post', ['tokenCompany' => $tokenCompany]) }}">
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
                            <span id="loginButtonContent">Entrar</span>
                            <span id="loginLoader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" style="color: inherit"></span>
                            <span id="loginLoadingText" class="ml-2 d-none">Carregando...</span>
                        </button>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#loginForm').on('submit', function(event) {
                                // Mostra o texto "Carregando..." e o spinner de carregamento
                                $('#loginButtonContent').addClass('d-none');
                                $('#loginLoader').removeClass('d-none');
                                $('#loginLoadingText').removeClass('d-none');
                            });
                        });
                    </script>
                    <div class="forgot-pass-fau text-center pt-3">
                        <a href="#" class="text-secondary">Esqueceu a Senha?</a>
                    </div>
                    <div class="forgot-pass-fau text-center pt-3">
                        <a href="#" class="text-secondary"> Você é um colaborador?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<style>
    .seminor-login-modal-body .close{
        position: relative;
        top: -45px;
        left: 10px;
        color: #1cd8ad;

    }
    .seminor-login-modal-body .close{
        opacity:0.75;
    }

    .seminor-login-modal-body .close:focus, .seminor-login-modal-body .close:hover {
        color: #39e8b0;
        opacity: 1;
        text-decoration: none;
        outline:0;
    }

    .seminor-login-modal .modal-dialog .modal-content{
        border-radius:0px;
    }

    /* form animation */
    .seminor-login-form .form-group {
        position: relative;
        margin-bottom: 1.5em !important;
    }
    .seminor-login-form .form-control{
        border: 0px solid #ced4da !important;
        border-bottom:1px solid #adadad !important;
        border-radius:0 !important;
    }
    .seminor-login-form .form-control:focus, .seminor-login-form .form-control:active{
        outline:none !important;
        outline-width: 0;
        border-color: #adadad !important;
        box-shadow: 0 0 0 0.2rem transparent;
    }
    *:focus {
        outline: none;
    }
    .seminor-login-form{
        padding: 2em 0 0;
    }

    .form-control-placeholder {
        position: absolute;
        top: 0;
        padding: 7px 0 0 13px;
        transition: all 200ms;
        opacity: 0.5;
        border-top: 0px;
        border-left: 0;
        border-right: 0;
    }

    .form-control:focus + .form-control-placeholder,
    .form-control:valid + .form-control-placeholder {
        font-size: 75%;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
        opacity: 1;
    }

    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .checkmark-box {
        position: absolute;
        top: -5px;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #adadad;
    }
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 40px;
        margin-bottom: 20px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        line-height: 1.1;
    }
    .container-checkbox input:checked ~ .checkmark-box:after {
        color: #fff;
    }
    .container-checkbox input:checked ~ .checkmark-box:after {
        display: block;
    }
    .container-checkbox .checkmark-box:after {
        left: 10px;
        top: 4px;
        width: 7px;
        height: 15px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .checkmark:after, .checkmark-box:after {
        content: "";
        position: absolute;
        display: none;
    }
    .container-checkbox input:checked ~ .checkmark-box {
        background-color: #3A4976;
        border: 0px solid transparent;
    }
    .btn-check-log .btn-check-login {
        font-size: 16px;
        padding: 10px 0;
        border-radius: 5px;
    }

    button.btn-check-login:hover {
        color: #fff;
        background-color: #3A4976;
        border: 2px solid #3A4976;
        border-radius: 5px;
    }
    .btn-check-login {
        color: #3A4976;
        background-color: transparent;
        border: 2px solid #3A4976;
        transition: all ease-in-out .3s;
        border-radius: 5px;
    }
    .btn-check-login {
        display: inline-block;
        padding: 12px 0;
        margin-bottom: 0;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border-radius: 0;
        width: 100%;
    }

    .forgot-pass-fau a {
        text-decoration: none !important;
        font-size: 14px;
    }
    .text-primary-fau {
        color: #1959a2;
    }

    .select-form-control-placeholder{
        font-size: 100%;
        padding: 7px 0 0 13px;
        margin: 0;
    }
</style>
