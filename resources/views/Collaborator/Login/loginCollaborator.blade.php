
<x-layoutLoginCollaborator title="Entrar" :tokenCompany="$tokenCompany">

    <form class="main-form" id="loginForm" method="post" action="{{ route('logincollaborator.post',['tokenCompany' => $tokenCompany]) }}">
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
            <div class="password-wrapper">
                <input type="password" class="form-control" id="password" placeholder="Digite sua senha" name="password" required>
                <span class="toggle-password" onclick="togglePassword('password', 'eye-icon')">
                    <i class="fa-solid fa-eye" id="eye-icon"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn" onclick="handleLogin()">Entrar</button>

        <a class="resetPassword" href="#" onclick="openResetPasswordModal()">Esqueceu a senha?</a>
    </form>
</x-layoutLoginCollaborator>
