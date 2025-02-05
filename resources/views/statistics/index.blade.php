<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div>
        <h3>Estadísticas</h3>
        <button onclick="loadData(15)">15 Días</button>
        <button onclick="loadData(30)">30 Días</button>
        <button onclick="loadData(60)">60 Días</button>
        <canvas id="statisticsChart"></canvas>
    </div>

    <script>
        let chart;

        function loadData(days) {
    $.get('/statistics/data', { days: days }, function(data) {
        const labels = [...new Set([
            ...data.uploadedByClients.map(d => d.date),
            ...data.uploadedByAdminsSystem.map(d => d.date),
            ...data.uploadedByAdminsAccess.map(d => d.date),
            ...data.downloads.map(d => d.date),
            ...data.publicDownloads.map(d => d.date)
        ])].sort();

        const datasets = [
            {
                label: 'Subidos por Clientes',
                data: labels.map(date => data.uploadedByClients.find(d => d.date === date)?.count || 0),
                borderColor: 'cyan',
                fill: false
            },
            {
                label: 'Subidos por Admins de Sistema',
                data: labels.map(date => data.uploadedByAdminsSystem.find(d => d.date === date)?.count || 0),
                borderColor: 'orange',
                fill: false
            },
            {
                label: 'Subidos por Admins de Accesos',
                data: labels.map(date => data.uploadedByAdminsAccess.find(d => d.date === date)?.count || 0),
                borderColor: 'red',
                fill: false
            },
            {
                label: 'Descargas',
                data: labels.map(date => data.downloads.find(d => d.date === date)?.count || 0),
                borderColor: 'blue',
                fill: false
            },
            {
                label: 'Descargas públicas',
                data: labels.map(date => data.publicDownloads.find(d => d.date === date)?.count || 0),
                borderColor: 'yellow',
                fill: false
            }
        ];

        if (chart) chart.destroy();
        const ctx = document.getElementById('statisticsChart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: { labels, datasets },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    });
}
        loadData(15);
    </script>
</body>
</html>
