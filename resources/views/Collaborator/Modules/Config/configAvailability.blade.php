<x-layoutCollaborator title="Configurações de Disponibilidade" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Configurações de Disponibilidade</h4>
    </div>

    <div class="card mt-4">
        <div class="cardAvailability-header">
            <i class="fa-solid fa-business-time"></i>
            Configurações de Disponibilidade
        </div>

        <div class="cardAvailability-body">
            @foreach($availability as $day)
                <div class="preview-availability">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <div class="calendar-day">{{ $day->workDays }}</div>
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-cell">
                                <p><strong>Início: {{ $day->hourStart }}</strong></p>
                                <p><strong>Fim: {{ $day->hourFinal }}</strong></p>
                                <p>Almoço: {{ $day->lunchTimeStart }} - {{ $day->lunchTimeFinal }}</p>
                                <p>Intervalo de Serviço: {{ $day->hourServiceInterval }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $availability->links('vendor.pagination.custom') }} <!-- Paginação -->
        </div>
    </div>
</x-layoutCollaborator>
