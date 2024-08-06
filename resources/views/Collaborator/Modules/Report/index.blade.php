<x-layoutCollaborator title="Relatórios" :token-company="$tokenCompany">
    <div class="main-title">
        <h4>Relatórios</h4>
    </div>

    <p style="color: gray; font-size: 0.9rem; margin: 6px; text-align: center;">
        <i class="fa-solid fa-circle-info"></i>
        Você pode buscar no campo de busca o tipo de relatório que desejar, qualquer informação referente ao relatório trazera ele para você.
    </p>

    <div class="search-container">
        <input type="text" id="search-input" placeholder="Digite o tipo de relatório..."  autocomplete="off"/>
    </div>

    <section class="report-main">
        <div class="card-report">
            <div class="card-report-header">
                <i class="fa-regular fa-file-lines" style="margin: 6px; color: rgba(73, 69, 79, 1);"></i>
                <p>Relatório Total de Agendamento</p>
            </div>
            <div class="report-description">
                <small style="color: rgba(73, 69, 79, 1);">
                    Com este relatório você pode visualizar o total de agendamento por dia, semana e mês.
                </small>
            </div>

            <div class="buttons-report mt-1 mb-1">
                <a class="btn btn-secondary" href="{{ route('report.totalschedule', ['tokenCompany' => $tokenCompany]) }}">Gerar Relatório</a>
            </div>
        </div>

        <!-- Adicione mais cartões de relatório conforme necessário -->
        <div class="card-report">
            <div class="card-report-header">
                <i class="fa-regular fa-file-lines" style="margin: 6px; color: rgba(73, 69, 79, 1);"></i>
                <p>Relatório Financeiro</p>
            </div>
            <div class="report-description">
                <small style="color: rgba(73, 69, 79, 1);">
                    Este relatório mostra os dados financeiros por período.
                </small>
            </div>

            <div class="buttons-report mt-1 mb-1">
                <a class="btn btn-secondary">Gerar Relatório</a>
            </div>
        </div>
    </section>

    <style>
        .card-report {
            width: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;

            background-color: #E0E0E0;
            border-radius: 12px;
            border: solid 1px rgba(189, 189, 189, 0.74);
            padding: 6px;

            /* Adicione a transição para suavizar o efeito */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-report:hover {
            /* Efeito de movimentação e sombra ao passar o mouse */
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .search-container {
            margin-bottom: 20px;
        }

        #search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('input', function () {
                const filter = searchInput.value.toLowerCase();
                const reports = document.querySelectorAll('.card-report');

                reports.forEach(report => {
                    const title = report.querySelector('.card-report-header p').textContent.toLowerCase();
                    if (title.includes(filter)) {
                        report.style.display = '';
                    } else {
                        report.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-layoutCollaborator>
