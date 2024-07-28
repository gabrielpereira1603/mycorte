<x-layoutCollaborator title="Dashboard" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Dashboard</h4>
    </div>
    <div class="content mt-3">
        <!-- Análise de Melhores Serviços -->
        <div class="chart-container" id="chartContainer1">
            <h5 class="chart-title">Análise de Melhores Serviços</h5>
            <p class="chart-description">Visualize os serviços que seus clientes mais gostam!</p>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date1" placeholder="Início">
                <input type="text" class="datepicker" id="end-date1" placeholder="Fim">
            </div>
            <div class="chart-controls">
                <select class="chart-type" data-chart-id="chart1">
                    <option value="bar">Barra</option>
                    <option value="line">Linha</option>
                    <option value="pie">Pizza</option>
                </select>
            </div>
            <canvas id="chart1"></canvas>
        </div>

        <!-- Análise de Agendamentos -->
        <div class="chart-container" id="chartContainer2">
            <h5 class="chart-title">Análise de Agendamentos Finalizados</h5>
            <p class="chart-description">Visualize a quantidade de agendamentos finalizados em diferentes períodos!</p>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date2" placeholder="Início">
                <input type="text" class="datepicker" id="end-date2" placeholder="Fim">
            </div>
            <div class="chart-controls">
                <select class="chart-type" data-chart-id="chart2">
                    <option value="line">Linha</option>
                    <option value="bar">Barra</option>
                    <option value="pie">Pizza</option>
                </select>
            </div>
            <canvas id="chart2"></canvas>
        </div>

        <!-- Análise de Faturamento -->
{{--        <div class="chart-container" id="chartContainer3">--}}
{{--            <h5 class="chart-title">Análise de Faturamento</h5>--}}
{{--            <p class="chart-description">Visualize detalhadamente o faturamento em diferentes períodos!</p>--}}
{{--            <div class="date-picker-container">--}}
{{--                <input type="text" class="datepicker" id="start-date3" placeholder="Início">--}}
{{--                <input type="text" class="datepicker" id="end-date3" placeholder="Fim">--}}
{{--            </div>--}}
{{--            <div class="chart-controls">--}}
{{--                <select class="chart-type" data-chart-id="chart3">--}}
{{--                    <option value="pie">Pizza</option>--}}
{{--                    <option value="bar">Barra</option>--}}
{{--                    <option value="line">Linha</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <canvas id="chart3"></canvas>--}}
{{--        </div>--}}

        <!-- Análise de Agendamentos Cancelados -->
        <div class="chart-container" id="chartContainer4">
            <h5 class="chart-title">Análise de Agendamentos Cancelados</h5>
            <p class="chart-description">Visualize a quantidade de agendamentos cancelados em diferentes períodos!</p>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date4" placeholder="Início">
                <input type="text" class="datepicker" id="end-date4" placeholder="Fim">
            </div>
            <div class="chart-controls">
                <select class="chart-type" data-chart-id="chart4">
                    <option value="bar">Barra</option>
                    <option value="line">Linha</option>
                    <option value="pie">Pizza</option>
                </select>
            </div>
            <canvas id="chart4"></canvas>
        </div>

        <!-- Análise de Agendamentos Reagendados -->
        <div class="chart-container" id="chartContainer5">
            <h5 class="chart-title">Análise de Agendamentos Reagendados</h5>
            <p class="chart-description">Visualize a quantidade de agendamentos reagendados em diferentes períodos!</p>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date5" placeholder="Início">
                <input type="text" class="datepicker" id="end-date5" placeholder="Fim">
            </div>
            <div class="chart-controls">
                <select class="chart-type" data-chart-id="chart5">
                    <option value="bar">Barra</option>
                    <option value="line">Linha</option>
                    <option value="pie">Pizza</option>
                </select>
            </div>
            <canvas id="chart5"></canvas>
        </div>

        <!-- Análise dos Horários com Mais Agendamentos -->
        <div class="chart-container" id="chartContainer6">
            <h5 class="chart-title">Análise dos Horários com Mais Agendamentos</h5>
            <p class="chart-description">Visualize os horários que seus clientes mais gostam!</p>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date6" placeholder="Início">
                <input type="text" class="datepicker" id="end-date6" placeholder="Fim">
            </div>
            <div class="chart-controls">
                <select class="chart-type" data-chart-id="chart6">
                    <option value="bar">Barra</option>
                    <option value="line">Linha</option>
                    <option value="pie">Pizza</option>
                </select>
            </div>
            <canvas id="chart6"></canvas>
        </div>

        @if($collaborator->role === 'COLLABORATOR')

        @endif

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function(dateText, inst) {
                    const chartId = $(this).closest('.chart-container').find('.chart-type').data('chart-id');
                    fetchAndUpdateChart(chartId);
                }
            });

            const chartConfigs = {
                'chart1': {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Melhores Serviços',
                            data: [],
                            backgroundColor: [],
                            borderColor: [],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                },
                'chart2': {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Agendamentos por Dia',
                            data: [],
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                },
                // 'chart3': {
                //     type: 'pie',
                //     data: {
                //         labels: [],
                //         datasets: [{
                //             label: 'Faturamento',
                //             data: [],
                //             backgroundColor: [],
                //             borderColor: [],
                //             borderWidth: 1
                //         }]
                //     },
                //     options: {
                //         responsive: true
                //     }
                // },
                'chart4': {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Agendamentos Cancelados',
                            data: [],
                            backgroundColor: [],
                            borderColor: [],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                },
                'chart5': {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Agendamentos Reagendados',
                            data: [],
                            backgroundColor: [],
                            borderColor: [],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                },
                'chart6': {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Horários com Mais Agendamentos',
                            data: [],
                            backgroundColor: [],
                            borderColor: [],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            };

            const charts = {};

            Object.keys(chartConfigs).forEach(chartId => {
                const ctx = document.getElementById(chartId).getContext('2d');
                charts[chartId] = new Chart(ctx, chartConfigs[chartId]);
            });

            document.querySelectorAll('.chart-type').forEach(select => {
                select.addEventListener('change', function() {
                    const chartId = this.dataset.chartId;
                    const newType = this.value;
                    const chartConfig = chartConfigs[chartId];
                    const chartCanvas = document.getElementById(chartId);

                    charts[chartId].destroy();
                    chartConfig.type = newType;
                    charts[chartId] = new Chart(chartCanvas, chartConfig);
                    fetchAndUpdateChart(chartId); // Atualiza o gráfico ao mudar o tipo
                });
            });

            function fetchAndUpdateChart(chartId) {
                const startDate = $(`#${chartId}`).closest('.chart-container').find(`#start-date${chartId.charAt(5)}`).datepicker('getDate');
                const endDate = $(`#${chartId}`).closest('.chart-container').find(`#end-date${chartId.charAt(5)}`).datepicker('getDate');

                const formattedStartDate = formatDate(startDate);
                const formattedEndDate = formatDate(endDate);
                const collaboratorId = {{ $collaborator->id }}; // Certifique-se de que $collaboratorId está disponível no contexto
                let url = '';

                switch(chartId) {
                    case 'chart1':
                        url = `{{ env('app_url') }}/api/dashboard/getData/bestServices/${formattedStartDate}/${formattedEndDate}/${collaboratorId}`;
                        break;
                    case 'chart2':
                        url = `{{ env('app_url') }}/api/dashboard/getData/scheduleAnalysis/${formattedStartDate}/${formattedEndDate}/${collaboratorId}`;
                        break;
                    case 'chart3':
                        url = `{{ env('app_url') }}/api/dashboard/getData/revenueAnalysis/${formattedStartDate}/${formattedEndDate}/${collaboratorId}`;
                        break;
                    case 'chart4':
                        url = `{{ env('app_url') }}/api/dashboard/getData/canceledAppointments/${formattedStartDate}/${formattedEndDate}/${collaboratorId}`;
                        break;
                    case 'chart5':
                        url = `{{ env('app_url') }}/api/dashboard/getData/rescheduledAppointments/${formattedStartDate}/${formattedEndDate}/${collaboratorId}`;
                        break;
                    case 'chart6':
                        url = `{{ env('app_url') }}/api/dashboard/getData/timeAnalysis/${formattedStartDate}/${formattedEndDate}/${collaboratorId}`;
                        break;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const chart = charts[chartId];
                        if (data.labels && data.data) {
                            chart.data.labels = data.labels;
                            chart.data.datasets[0].data = data.data;

                            // Gera cores aleatórias
                            const backgroundColors = data.labels.map(() => getRandomColor());
                            const borderColors = data.labels.map(() => getRandomColor());

                            chart.data.datasets[0].backgroundColor = backgroundColors;
                            chart.data.datasets[0].borderColor = borderColors;

                            chart.update();
                        } else {
                            console.error(`Dados inválidos para ${chartId}:`, data);
                        }
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }

            function formatDate(date) {
                if (!date) return '';
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
                const year = date.getFullYear();
                return `${year}-${month}-${day}`;
            }

            function getRandomColor() {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);
                return `rgba(${r}, ${g}, ${b}, 0.6)`;
            }
        });
    </script>
</x-layoutCollaborator>
