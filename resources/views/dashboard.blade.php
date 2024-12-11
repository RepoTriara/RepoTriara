<!doctype html>
<html lang="es_CO">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Tablero &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
</head>

<body class="home logged-in logged-as-admin dashboard hide_title menu_hidden backend">
	<div class="container-custom">
		<header id="header" class="navbar navbar-static-top navbar-fixed-top">
			<ul class="nav pull-left nav_toggler">
				<li>
					<a href="#" class="toggle_main_menu"><i class="fa fa-bars" aria-hidden="true"></i><span>Menú alternativo</span></a>
				</li>
			</ul>

			<div class="navbar-header">
				<span class="navbar-brand"><a href="https://www.projectsend.org/" target="_blank"></a> Repositorio</span>
			</div>

			<ul class="nav pull-right nav_account">
				<li id="header_welcome">
					<span> Cristian Camilo Diaz Ramirez</span>
				</li>
				<li>
					<a href="{{ route('profile.edit') }}" class="my_account"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a>
				</li>
				<li>
					<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
<li class="current_nav">
	<a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span></a>
</li>
<li class="separator"></li><li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span></a>
	<ul class="dropdown_content">
		<li>
		<a href="{{ route('upload') }}"><span class="submenu_label">Subir</span></a>
		</li>
		<li class="divider"></li>
		<li class="">
			<a href="{{ route('file_manager') }}"><span class="submenu_label">Administrar archivos</span></a>
		</li>
		<li class="">
			<a href="{{ route('search_orphan_files') }}"><span class="submenu_label">Buscar archivos huerfanos</span></a>
		</li>
		<li class="divider"></li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/categories.php"><span class="submenu_label">Categorías</span></a>
		</li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/clients-add.php"><span class="submenu_label">Añadir nuevo cliente</span></a>
		</li>
		<li class="">
			<a href="{{ route('customer_manager') }}"><span class="submenu_label">Administración de clientes</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañias</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/groups-add.php"><span class="submenu_label">Añadir nueva compañia</span></a>
		</li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/groups.php"><span class="submenu_label">Administrar Compañias</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>

@if(Auth::user()->level != 8)
    <li class="has_dropdown">
        <a href="#" class="nav_top_level">
            <i class="fa fa-users fa-fw" aria-hidden="true"></i>
            <span class="menu_label">Usuarios del Sistema</span>
        </a>
        <ul class="dropdown_content">
            <li class="">
                <a href="https://repo.triara.co/repositorio/users-add.php">
                    <span class="submenu_label">Añadir nuevo usuario</span>
                </a>
            </li>
            <li class="">
                <a href="https://repo.triara.co/repositorio/users.php">
                    <span class="submenu_label">Administrar usuarios</span>
                </a>
            </li>
        </ul>
    </li>
@endif

<li class="separator"></li><li class="separator"></li></ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">

				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Tablero</h2>
						</div>
					</div>
				</div>

				<div class="row">
	<div class="col-sm-8">
		<div class="row">
			<div class="col-sm-12 container_widget_statistics">
						<div class="widget">
			<h4>Estadisticas</h4>
			<div class="widget_int widget_statistics">
				<div class="stats_change_days">
												<a href="#" class="stats_days btn btn-sm btn-default btn-inverse" data-days="15">
								15 Dias							</a>
												<a href="#" class="stats_days btn btn-sm btn-default " data-days="30">
								30 Dias							</a>
												<a href="#" class="stats_days btn btn-sm btn-default " data-days="60">
								60 Dias							</a>
									</div>
				<ul class="graph_legend">
											<li class="legend_color legend_color1" style="border-top:5px solid #0094bb;">
							<div class="ref_color"></div>
							Subidos por usuarios						</li>
											<li class="legend_color legend_color2" style="border-top:5px solid #86ae00;">
							<div class="ref_color"></div>
							Subidos por Administradores						</li>
											<li class="legend_color legend_color3" style="border-top:5px solid #f2b705;">
							<div class="ref_color"></div>
							Descargas						</li>
											<li class="legend_color legend_color4" style="border-top:5px solid #1ec4a7;">
							<div class="ref_color"></div>
							Descargas públicas						</li>
									</ul>

				<div class="statistics_graph"></div>
			</div>
		</div>
	<script type="text/javascript">
		$(document).ready(function(e) {
	var d5 = [[1732597200000,2],[1732683600000,1],[1732770000000,5],[1732856400000,6],[1732942800000,0],[1733029200000,0],[1733115600000,18],[1733202000000,2],[1733288400000,12],[1733374800000,53],[1733461200000,60],[1733547600000,2],[1733634000000,12],[1733720400000,10],[1733806800000,2]];
var d6 = [[1732597200000,0],[1732683600000,1],[1732770000000,0],[1732856400000,0],[1732942800000,0],[1733029200000,0],[1733115600000,2],[1733202000000,0],[1733288400000,0],[1733374800000,0],[1733461200000,0],[1733547600000,0],[1733634000000,0],[1733720400000,2],[1733806800000,0]];
var d8 = [[1732597200000,6],[1732683600000,4],[1732770000000,19],[1732856400000,1],[1732942800000,0],[1733029200000,0],[1733115600000,17],[1733202000000,10],[1733288400000,6],[1733374800000,5],[1733461200000,9],[1733547600000,0],[1733634000000,0],[1733720400000,8],[1733806800000,5]];
var d37 = [[1732597200000,1],[1732683600000,0],[1732770000000,0],[1732856400000,0],[1732942800000,0],[1733029200000,0],[1733115600000,0],[1733202000000,0],[1733288400000,0],[1733374800000,0],[1733461200000,0],[1733547600000,0],[1733634000000,0],[1733720400000,0],[1733806800000,1]];

			function showTooltip(x, y, contents) {
				$('<div id="stats_tooltip">' + contents + '</div>').css( {
					top: y + 5,
					left: x + 5,
				}).appendTo("body").fadeIn(200);
			}

			var previousPoint = null;
			$(".statistics_graph").bind("plothover", function (event, pos, item) {
				$("#x").text(pos.x.toFixed(2));
				$("#y").text(pos.y.toFixed(2));

					if (item) {
						if (previousPoint != item.dataIndex) {
							previousPoint = item.dataIndex;

							$("#stats_tooltip").remove();
							var x = item.datapoint[0].toFixed(2),
								y = item.datapoint[1].toFixed(2);

							showTooltip(item.pageX, item.pageY,
										item.series.label + ": " + y);
						}
					}
					else {
						$("#stats_tooltip").remove();
						previousPoint = null;
					}
			});

			var options = {
				grid: {
					hoverable: true,
					borderWidth: 0,
					color: "#666",
					labelMargin: 10,
					axisMargin: 0,
					mouseActiveRadius: 10
				},
				series: {
					lines: {
						show: true,
						lineWidth: 2
					},
					points: {
						show: true,
						radius: 3,
						symbol: "circle",
						fill: true
					}
				},
				xaxis: {
					mode: "time",
					minTickSize: [1, "day"],
					timeformat: "%d/%m",
					labelWidth: "30"
				},
				yaxis: {
					min: 0,
					tickDecimals:0
				},
				legend: {
					margin: 10,
					sorted: true,
					show: false
				},
				colors: ["#0094bb","#86ae00","#f2b705","#1ec4a7"]
			};

			$.plot(
				$(".statistics_graph"), [
												{
								data: d5,
								label: 'Subidos por usuarios'
							}
					,							{
								data: d6,
								label: 'Subidos por Administradores'
							}
					,							{
								data: d8,
								label: 'Descargas'
							}
					,							{
								data: d37,
								label: 'Descargas públicas'
							}
									], options
			);
		});
	</script>

			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
							</div>
					</div>
	</div>

				

	<script type="text/javascript">
		$(document).ready(function(){
			/** STATISTICS */
			function ajax_widget_statistics( days ) {
				var target = $('.statistics_graph');
				target.html('<div class="loading-graph">'+
								'<img src="https://repo.triara.co/repositorio//img/ajax-loader.gif" alt="Loading" />'+
							'</div>'
						);
				$.ajax({
					url: 'https://repo.triara.co/repositorio/includes/widgets/statistics.php',
					data: { days:days, ajax_call:true },
					success: function(response){
								target.html(response);
							},
					cache:false
				});
			}

			$('.stats_days').click(function(e) {
				e.preventDefault();

				if ($(this).hasClass('btn-inverse')) {
					return false;
				}
				else {
					var days = $(this).data('days');
					$('.stats_days').removeClass('btn-inverse');
					$(this).addClass('btn-inverse');
					ajax_widget_statistics(days);
				}
			});

			ajax_widget_statistics(15);

			/** ACTION LOG */
			function ajax_widget_log( action ) {
				var target = $('.activities_log');
				target.html('<div class="loading-graph">'+
								'<img src="https://repo.triara.co/repositorio//img/ajax-loader.gif" alt="Loading" />'+
							'</div>'
						);
				$.ajax({
					url: 'https://repo.triara.co/repositorio/includes/widgets/actions-log.php',
					data: { action:action, ajax_call:true },
					success: function(response){
								target.html(response);
							},
					cache:false
				});
			}

			// Generate the action log
			$('.log_action').click(function(e) {
				e.preventDefault();

				if ($(this).hasClass('btn-inverse')) {
					return false;
				}
				else {
					var action = $(this).data('action');
					$('.log_action').removeClass('btn-inverse');
					$(this).addClass('btn-inverse');
					ajax_widget_log(action);
				}
			});

			ajax_widget_log();
		});
	</script>

					</div> <!-- row -->
				</div> <!-- container-fluid -->

					<footer>
		<div id="footer">
			Claro Colombia		</div>
	</footer>
			<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/flot/excanvas.js"></script><![endif]-->
			<script src="https://repo.triara.co/repositorio/assets/bootstrap/js/bootstrap.min.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jquery.validations.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jquery.psendmodal.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jen/jen.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/js.cookie.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/main.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/js.functions.php"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/flot/jquery.flot.min.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/flot/jquery.flot.resize.min.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/flot/jquery.flot.time.min.js"></script>
			</div> <!-- main_content -->
		</div> <!-- container-custom -->

	</body>
</html>
