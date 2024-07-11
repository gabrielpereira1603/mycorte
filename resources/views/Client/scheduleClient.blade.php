<x-layoutClient title="Horários" :tokenCompany="$tokenCompany">
    <script src="{{ asset('js/calendarSchedule/scheduleClient.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var scheduleId = '0'; // Defina o scheduleId se necessário
            var collaboratorId = {{ $collaboratorId }}; // Substitua pelo ID do colaborador
            var companyId = {{ $idCompany }}; // Substitua pelo ID da empresa
            var companyToken = '{{ $tokenCompany }}'; // Substitua pelo token da empresa
            var formAction = '{{ route('dataTransporter') }}'; // Substitua pela rota adequada
            var csrfToken = '{{ csrf_token() }}'; // Token CSRF
            var InsertScheduleController = "{{ route('insertServiceBySchedule', ['tokenCompany' => $tokenCompany]) }}"

            // Inicializa o calendário ao carregar a página
            initializeCalendar(scheduleId, collaboratorId, companyId, companyToken, formAction, csrfToken, InsertScheduleController);
        });
    </script>

    <div style="text-align: center; margin-top: 20px">
        <h1 style="color: black;">Selecione seu horário</h1>
        <p style="color: black;">Basta clicar no horário que esteja disponível</p>
    </div>

    <div class="container-calendar">
        <div id="calendar"></div>
    </div>
</x-layoutClient>
