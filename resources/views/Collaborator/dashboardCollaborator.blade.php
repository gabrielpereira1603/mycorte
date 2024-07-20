<x-layoutCollaborator title="Dashboard" :tokenCompany="$tokenCompany">
    <div class="main-title">
        <h4>Dashboard</h4>
    </div>
    <div class="content">
        <div class="chart-container">
            <h5 class="chart-title">Gráfico de Barras</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
            </div>
            <canvas id="barChart"></canvas>
        </div>
        <div class="chart-container">
            <h5 class="chart-title">Gráfico de Linhas</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
            </div>
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-container">
            <h5 class="chart-title">Gráfico de Pizza</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
            </div>
            <canvas id="pieChart"></canvas>
        </div>
        <div class="chart-container">
            <h5 class="chart-title">Gráfico de Radar</h5>
            <div class="date-picker-container">
                <input type="text" class="datepicker" placeholder="Início">
                <input type="text" class="datepicker" placeholder="Fim">
            </div>
            <canvas id="radarChart"></canvas>
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

            // Gráfico de barras
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
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
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de linhas
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
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
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de pizza
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
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
            });

            // Gráfico de radar
            const radarCtx = document.getElementById('radarChart').getContext('2d');
            new Chart(radarCtx, {
                type: 'radar',
                data: {
                    labels: ['Running', 'Swimming', 'Eating', 'Cycling'],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [20, 10, 4, 2],
                        fill: true,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                        pointBackgroundColor: 'rgb(255, 99, 132)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(255, 99, 132)'
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
</x-layoutCollaborator>
