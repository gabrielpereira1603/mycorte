<x-layoutLoginCollaborator title="Código de Acesso" :tokenCompany="$tokenCompany">
    <form class="main-form" id="loginForm" method="post" action="{{ route('resetPasswordCollaborator.post', ['tokenCompany' => $tokenCompany]) }}">

        @csrf
        <div class="title-form">
            <h3>Alterar Senha</h3>
            <p>A senha deve ter no mínimo 8 caracteres</p>
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

            <label for="password" class="form-label">Nova senha</label>
            <div class="password-wrapper">
                <input type="password" class="form-control" id="new_password" placeholder="Digite sua nova senha" name="password" required>
                <span class="toggle-password" onclick="togglePassword('new_password', 'eye-icon-new')">
                    <i class="fa-solid fa-eye" id="eye-icon-new"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirme a senha</label>
            <div class="password-wrapper">
                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirme sua senha" name="password_confirmation" required>
                <span class="toggle-password" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')">
                    <i class="fa-solid fa-eye" id="eye-icon-confirm"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn" onclick="handleLogin()">Alterar Senha</button>
    </form>
</x-layoutLoginCollaborator>
