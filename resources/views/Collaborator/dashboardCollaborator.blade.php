<x-layoutCollaborator title="Dashboard" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Dashboard</h4>
    </div>
    <div class="content">
        <div class="chart-container" id="chartContainer1">
            <h5 class="chart-title">Análise de Melhores Serviços</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
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
            <h5 class="chart-title">Analise de Agendamentos</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
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
            <h5 class="chart-title">Analise de Faturamento</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
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
                dateFormat: 'dd-mm-yy'
            });

            const chartConfigs = {
                'chart1': {
                    type: 'bar',
                    data: {
                        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                        datasets: [{
                            label: '# of Votes',
                            data: [12, 19, 3, 5, 2, 3],
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
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'Sales',
                            data: [65, 59, 80, 81, 56, 55, 40],
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
                        labels: ['Red', 'Blue', 'Yellow'],
                        datasets: [{
                            label: 'Population',
                            data: [300, 50, 100],
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

                    chartConfig.type = newType;

                    charts[chartId].destroy();
                    charts[chartId] = new Chart(chartCanvas.getContext('2d'), chartConfig);
                });
            });
        });
    </script>
</x-layoutCollaborator>
