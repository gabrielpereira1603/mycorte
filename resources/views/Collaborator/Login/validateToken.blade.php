<x-layoutLoginCollaborator title="Código de Acesso" :tokenCompany="$tokenCompany">
    <style>
        .token-input-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }
        .token-input {
            width: 3rem;
            height: 3rem;
            text-align: center;
            font-size: 2rem;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .token-dash {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
    <form class="main-form" id="loginForm" method="post" action="{{ route('validateTokenForgotPasswordCollaborator', ['tokenCompany' => $tokenCompany]) }}">
        @csrf
        <div class="title-form">
            <h3>Código de acesso</h3>
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

            <label for="token" class="form-label" style="text-align: center; color: gray; font-size: 16px">O código foi enviado em seu e-mail</label>
            <div class="token-input-group" id="token">
                <input type="text" class="token-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" name="token_part1[]" required>
                <input type="text" class="token-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" name="token_part1[]" required>
                <input type="text" class="token-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" name="token_part1[]" required>
                <span class="token-dash">-</span>
                <input type="text" class="token-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" name="token_part2[]" required>
                <input type="text" class="token-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" name="token_part2[]" required>
                <input type="text" class="token-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" name="token_part2[]" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn" onclick="handleLogin()">Validar Código</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const inputs = document.querySelectorAll('.token-input');

            // Adiciona o evento de input para movimentar o foco automaticamente
            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Adiciona o evento de colagem
                input.addEventListener('paste', (e) => {
                    const pastedData = e.clipboardData.getData('text').replace(/\D/g, ''); // Remove caracteres não numéricos
                    const totalInputs = inputs.length;

                    // Preenche os campos com os dados colados
                    for (let i = 0; i < totalInputs; i++) {
                        if (i < pastedData.length) {
                            inputs[i].value = pastedData[i];
                            if (i < totalInputs - 1) {
                                inputs[i + 1].focus();
                            }
                        } else {
                            inputs[i].value = '';
                        }
                    }

                    // Impede o comportamento padrão da colagem
                    e.preventDefault();
                });
            });
        });
    </script>

</x-layoutLoginCollaborator>
