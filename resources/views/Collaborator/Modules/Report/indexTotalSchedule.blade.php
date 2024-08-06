<x-layoutCollaborator title="Relatório Total Agendamentos" :token-company="$tokenCompany">
    <div class="main-title">
        <h4>Relatório Total de Agendamentos</h4>
    </div>

    <p style="color: gray; font-size: 0.9rem; text-align: center;">
        <i class="fa-solid fa-circle-info"></i>
        Assim que você preencher as informações, o relatório será gerado automaticamente em uma tabela, com a opção de exportá-lo em PDF.
    </p>

    <style>
        .custom-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-bottom: transparent;

        }

        .dataTables_filter {
            padding: 20px;
        }

        .custom-table thead th {
            background-color: #3a4976;
            color: white;
            text-align: center;
        }

        .custom-table tr th {
            font-size: 12px;
            width: 0px;
            font-weight: 500;
        }

        .custom-table th {
            font-size: 1rem;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .custom-table tbody tr:hover {
            background-color: #ddd;
        }

        .custom-table tbody td {
            padding: 8px;
            text-align: left;
        }

        .custom-dt-buttons {
            margin-bottom: 10px;
        }
    </style>

    <section class="main-total-schedule">
        <form id="reportForm">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue" value="{{ $collaborator->name }}" disabled>
                        <label for="floatingInputValue">Colaborador:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="startDate" placeholder="Data de Início">
                        <label for="startDate">Data de Início:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="endDate" placeholder="Data de Fim">
                        <label for="endDate">Data de Fim:</label>
                    </div>
                </div>
            </div>
        </form>

        <div id="spinner" style="display: none; text-align: center;">
            <i class="fa fa-spinner fa-spin"></i> Gerando relatório...
        </div>

        <div id="reportTable" style="display: none;">

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const reportTable = document.getElementById('reportTable');
            const spinner = document.getElementById('spinner');

            function fetchReportData() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const collaboratorId = {{ $collaborator->id }};
                const apiUrl = `{{ env('APP_URL') }}/api/totalschedule/${collaboratorId}/${startDate}/${endDate}`;

                if (startDate && endDate) {
                    spinner.style.display = 'block';
                    reportTable.style.display = 'none';

                    fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            generateReportTable(data);
                            spinner.style.display = 'none';
                            reportTable.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error fetching report data:', error);
                            spinner.style.display = 'none';
                        });
                }
            }

            function generateReportTable(data) {
                // Clear previous table content
                reportTable.innerHTML = '';

                // Create the table
                const tableWrapper = document.createElement('div');
                tableWrapper.classList.add('table-responsive');

                const table = document.createElement('table');
                table.classList.add('custom-table', 'table-striped', 'table-hover');

                // Create table headers
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');

                const headers = [
                    { text: 'Cliente', icon: 'fa-user' },
                    { text: 'Serviços', icon: 'fa-concierge-bell' },
                    { text: 'Horário de Início', icon: 'fa-clock' },
                    { text: 'Horário de Fim', icon: 'fa-clock' },
                    { text: 'Data', icon: 'fa-calendar' },
                    { text: 'Valor Total', icon: 'fa-dollar-sign' },
                    { text: 'Colaborador', icon: 'fa-user-tie' }
                ];

                headers.forEach(header => {
                    const th = document.createElement('th');
                    th.innerHTML = `<i class="fa ${header.icon}"></i> ${header.text}`;
                    headerRow.appendChild(th);
                });

                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Create table body
                const tbody = document.createElement('tbody');

                data.forEach(item => {
                    const row = document.createElement('tr');

                    const clientName = item.client ? item.client.name : '';
                    const services = item.services.map(service => service.name).join(', ');
                    const startTime = item.hourStart;
                    const endTime = item.hourFinal;
                    const date = item.date;
                    const totalPrice = item.totalPrice;
                    const collaboratorName = item.collaborator ? item.collaborator.name : '';

                    const rowData = [clientName, services, startTime, endTime, date, totalPrice, collaboratorName];

                    rowData.forEach(cellData => {
                        const td = document.createElement('td');
                        td.textContent = cellData;
                        row.appendChild(td);
                    });

                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                tableWrapper.appendChild(table);
                reportTable.appendChild(tableWrapper);

                // Initialize DataTables
                $(table).DataTable({
                    dom: '<"custom-dt-buttons"B>frtip',
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: 'Exportar para PDF',
                            customize: function (doc) {
                                doc.content.splice(0, 1, {
                                    text: 'Relatório Total de Agendamentos',
                                    style: 'header'
                                });
                                doc.styles.tableHeader = {
                                    fillColor: '#F3F3F3',
                                    color: '#000',
                                    alignment: 'center',
                                    bold: true
                                };
                            }
                        }
                    ],
                    responsive: true,
                    paging: true,
                    searching: true,
                    ordering: true
                });
            }

            startDateInput.addEventListener('change', fetchReportData);
            endDateInput.addEventListener('change', fetchReportData);
        });
    </script>
</x-layoutCollaborator>
