<x-layoutCollaborator title="Dashboard" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Dashboard</h4>
    </div>
    <div class="content">
        <div class="chart-container" id="chartContainer1">
            <h5 class="chart-title">Análise de Melhores Serviços</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date" placeholder="Início" value="{{ $startDate }}">
                <input type="text" class="datepicker" id="end-date" placeholder="Fim" value="{{ $endDate }}">
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
        <div class="chart-container" id="chartContainer2">
            <h5 class="chart-title">Análise de Agendamentos</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date2" placeholder="Início" value="{{ $startDate }}">
                <input type="text" class="datepicker" id="end-date2" placeholder="Fim" value="{{ $endDate }}">
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
        <div class="chart-container" id="chartContainer3">
            <h5 class="chart-title">Análise de Faturamento</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" id="start-date3" placeholder="Início" value="{{ $startDate }}">
                <input type="text" class="datepicker" id="end-date3" placeholder="Fim" value="{{ $endDate }}">
            </div>
            <div class="chart-controls">
                <select class="chart-type" data-chart-id="chart3">
                    <option value="pie">Pizza</option>
                    <option value="bar">Barra</option>
                    <option value="line">Linha</option>
                </select>
            </div>
            <canvas id="chart3"></canvas>
        </div>
    </div>

    <!-- Incluindo jQuery e jQuery UI para Datepicker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Incluindo Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function() {
                    fetchAndUpdateChart();
                }
            });

            const chartConfigs = {
                'chart1': {
                    type: 'bar',
                    data: {
                        labels: @json($dates),
                        datasets: [{
                            label: 'Agendamentos por Dia',
                            data: @json($counts),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
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
                    type: 'line',
                    data: {
                        labels: @json($dates),  // Updated to use $dates
                        datasets: [{
                            label: 'Agendamentos por Dia',
                            data: @json($counts),  // Updated to use $counts
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
                'chart3': {
                    type: 'pie',
                    data: {
                        labels: @json($dates),  // Updated to use $dates
                        datasets: [{
                            label: 'Agendamentos por Dia',
                            data: @json($counts),  // Updated to use $counts
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
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
                });
            });

            function fetchAndUpdateChart() {
                const startDate = $('#start-date').datepicker('getDate');
                const endDate = $('#end-date').datepicker('getDate');

                const formattedStartDate = $.datepicker.formatDate('yy-mm-dd', startDate);
                const formattedEndDate = $.datepicker.formatDate('yy-mm-dd', endDate);

                $.ajax({
                    url: '{{ route('collaborator.dashboard.fetchScheduleData') }}',
                    method: 'POST',
                    data: {
                        start_date: formattedStartDate,
                        end_date: formattedEndDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        Object.keys(chartConfigs).forEach(chartId => {
                            const chartConfig = chartConfigs[chartId];
                            chartConfig.data.labels = data.dates;
                            chartConfig.data.datasets[0].data = data.counts;
                            charts[chartId].update();
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        });
    </script>

</x-layoutCollaborator>
