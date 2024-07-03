<form id="logout-form" action="{{ route('logoutclient', ['tokenCompany' => $tokenCompany]) }}" method="POST" style="display: none;">
    @csrf
</form>

<form class="d-flex form-header">
    @csrf
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 mb-2">
        <a type="button" href="#"
           class="btn btn-success d-flex align-items-center justify-content-center no-wrap flex-grow-1 mb-sm-0" id="btn-login-header" style="margin-bottom: 0px;">
            <i class="fa-solid fa-user me-2"></i> <!-- Ícone com margin à direita -->
            Minha Conta
        </a>
        <div class="divider">
            <div></div>
            <span>ou</span>
            <div></div>
        </div>
        <button type="button" class="btn btn-danger d-flex align-items-center justify-content-center no-wrap flex-grow-1 mt-sm-0" id="btn-logout">
            <i class="fa-solid fa-door-open me-2"></i> <!-- Ícone com margin à direita -->
            Sair
        </button>
    </div>
</form>

<script>
    document.getElementById('btn-logout').addEventListener('click', function() {
        Swal.fire({
            title: "Você tem certeza?",
            text: "Você não poderá reverter isso!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, sair!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Submeter o formulário de logout
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
