<nav class="navbar navbar-expand-lg" style="background-color: {{ $style->primaryColor ?? 'white' }};">
    <div class="container-fluid">
        <a class="navbar-brand ms-5" href="{{ route('homeclient', ['tokenCompany' => $tokenCompany]) }}">
            <img src="{{ asset('images/logoLetraAzul.png') }}" alt="Logo" width="60" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-center w-100">
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" aria-current="page" href="#" style="color: {{ $style->colorText }}">Início</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" aria-current="page" href="{{ route('mycutsclient', ['tokenCompany' => $tokenCompany]) }}" style="color: {{ $style->colorText }}">Meus Cortes</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" aria-current="page" href="#" style="color: {{ $style->colorText }}">Históricos</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" aria-current="page" href="#" style="color: {{ $style->colorText }}">Como Chegar?</a>
                </li>

            </ul>

            @auth('client')
                {{-- Mostrar header para usuário logado --}}
                @include('Client.Header.buttonTrueLogin', ['tokenCompany' => $tokenCompany])
            @else
                {{-- Mostrar header para usuário não logado --}}
                @include('Client.Header.buttonNotLogin', ['tokenCompany' => $tokenCompany])
            @endauth
        </div>
    </div>
</nav>
