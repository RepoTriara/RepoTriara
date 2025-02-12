<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tablero &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="home logged-in logged-as-admin dashboard hide_title menu_hidden backend">

    <div class="container-custom">


        <div class="main_content">
            @include('layouts.app')
            <div class="container-fluid">
                <div class="widget">
                    <h4>Estadísticas</h4>
                    <div class="widget_int widget_statistics">
                        <div class="stats_change_days">
                            <button class="stats_days btn btn-sm btn-default " onclick="loadData(15)">15 Días</button>
                            <button class="stats_days btn btn-sm btn-default " onclick="loadData(30)">30 Días</button>
                            <button class="stats_days btn btn-sm btn-default " onclick="loadData(60)">60 Días</button>
                        </div>
                        <div style="width: 100%; height: 400px;">
                            <canvas id="statisticsChart"></canvas>
                        </div>

                    </div>

                    <script>
                        let chart;

                        function loadData(days) {
                            // Remover la clase 'active' de todos los botones
                            $('.stats_days').removeClass('active');

                            // Agregar la clase 'active' al botón pulsado
                            $(`.stats_days:contains(${days} Días)`).addClass('active');

                            $.get('/statistics/data', {
                                days: days
                            }, function(data) {
                                if (!data || !data.uploadedCounts || !data.downloads || !data.publicDownloads) {
                                    console.error("Datos inválidos recibidos:", data);
                                    return;
                                }

                                const labels = [...new Set(data.uploadedCounts.map(d => d.date))].sort();

                                const datasets = [{
                                        label: 'Subidos por Clientes',
                                        data: labels.map(date => data.uploadedCounts.find(d => d.date === date)
                                            ?.uploaded_by_clients || 0),
                                        borderColor: '#0094BB',
                                        fill: false
                                    },
                                    {
                                        label: 'Subidos por Admins de Sistema',
                                        data: labels.map(date => data.uploadedCounts.find(d => d.date === date)
                                            ?.uploaded_by_admins_system || 0),
                                        borderColor: 'red',
                                        fill: false
                                    },
                                    {
                                        label: 'Subidos por Admins de Accesos',
                                        data: labels.map(date => data.uploadedCounts.find(d => d.date === date)
                                            ?.uploaded_by_admins_access || 0),
                                        borderColor: '#86AE00',
                                        fill: false
                                    },
                                    {
                                        label: 'Descargas',
                                        data: labels.map(date => data.downloads.find(d => d.date === date)?.count || 0),
                                        borderColor: '#F2B705',
                                        fill: false
                                    },
                                    {
                                        label: 'Descargas públicas',
                                        data: labels.map(date => data.publicDownloads.find(d => d.date === date)?.count || 0),
                                        borderColor: '#1EC4A7',
                                        fill: false
                                    }
                                ];

                                if (chart) {
                                    chart.destroy();
                                }

                                const ctx = document.getElementById('statisticsChart').getContext('2d');
                                chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels,
                                        datasets
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                console.error("Error al obtener los datos:", textStatus, errorThrown);
                            });
                        }

                        // Ejecutar cuando la página cargue
                        $(document).ready(function() {
                            loadData(15);
                            $('.stats_days:contains(15 Días)').addClass('active'); // Marcar el botón inicial
                        });
                    </script>

                  


                </div> <!-- container-fluid -->

                <footer>
                    <div id="footer">
                        Claro Colombia
                    </div>
                </footer>

                <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
                <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
                <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
                <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
                <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
                <script src="{{ asset('includes/js/main.js') }}"></script>
                <script src="{{ asset('includes/js/js.functions.php') }}"></script>
                <script src="{{ asset('includes/js/flot/jquery.flot.min.js') }}"></script>
                <script src="{{ asset('includes/js/flot/jquery.flot.resize.min.js') }}"></script>
                <script src="{{ asset('includes/js/flot/jquery.flot.time.min.js') }}"></script>
            </div> <!-- main_content -->
        </div> <!-- container-custom -->

</body>

</html>
