<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Administraci&oacute;n del Sistema &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/footable/css/footable.core.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('templates/default/main.css')}}" />
</head>

<body class="body logged-in logged-as-client template default-template hide_title menu_hidden backend">
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
					<span> user</span>
				</li>
				<li>
					<a href="{{route('profile.edit')}}" class="my_account"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a>
				</li>
				<li>
					<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						<i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesión
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
				<li class="">
					<a href="https://repo.triara.co/repositorio/upload-from-computer.php" class="nav_top_level"><i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i><span class="menu_label">Subir</span></a>
				</li>
				<li class="">
					<a href="https://repo.triara.co/repositorio/manage-files.php" class="nav_top_level"><i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Administrar archivos</span></a>
				</li>
				<li class="">
					<a href="https://repo.triara.co/repositorio/my_files/" class="nav_top_level"><i class="fa fa-th-list fa-fw" aria-hidden="true"></i><span class="menu_label">ver mis archivos</span></a>
				</li>
			</ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">

				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Administración del Sistema</h2>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-xs-12">
						<div id="wrapper">

							<div id="right_column">

								<div class="form_actions_left">
									<div class="form_actions_limit_results">
										<form action="" name="form_search" method="get" class="form-inline">
											<div class="form-group group_float">
												<input type="text" name="search" id="search" value="" class="txtfield form_actions_search_box form-control" />
											</div>
											<button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
										</form>

										<form action="" name="files_filters" method="get" class="form-inline form_filters">
											<div class="form-group group_float">
												<select name="category" id="category" class="txtfield form-control">
													<option value="0">All categories</option>
													<option value='6'>Servicios Administrados</option>
													<option value='13'>&#160;&#160;&#160;&#160;Monitoreo y Gesti&oacute;n</option>
													<option value='14'>Servicios de Seguridad</option>
												</select>
											</div>
											<button type="submit" id="btn_proceed_filter_files" class="btn btn-sm btn-default">Filtrar</button>
										</form>
									</div>
								</div>

								<form action="" name="files_list" method="get" class="form-inline">
									<div class="form_actions_right">
										<div class="form_actions">
											<div class="form_actions_submit">
												<div class="form-group group_float">
													<label class="control-label hidden-xs hidden-sm"><i class="glyphicon glyphicon-check"></i> Acciones de archivos seleccionados:</label>
													<select name="action" id="action" class="txtfield form-control">
														<option value="none">Seleccione la acción</option>
														<option value="zip">Descarga comprimida</option>
													</select>
												</div>
												<button type="submit" id="do_action" class="btn btn-sm btn-default">Proceder</button>
											</div>
										</div>
									</div>

									<div class="right_clear"></div><br />

									<div class="form_actions_count">
										<p class="form_count_total">Encontró: <span>17 Archivos</span></p>
									</div>

									<div class="right_clear"></div>

									<table id="files_list" class="footable table">
										<thead>
											<tr>
												<th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all" value="0" /></th>
												<th><a href="https://repo.triara.co/repositorio/my_files?orderby=filename&order=desc">Título</a><span class="footable-sort-indicator"></span></th>
												<th data-hide="phone">Tipo</th>
												<th class="description" data-hide="phone"><a href="https://repo.triara.co/repositorio/my_files?orderby=description&order=desc">Descripción</a><span class="footable-sort-indicator"></span></th>
												<th data-hide="phone">tamaño</th>
												<th class="active footable-sorted-desc"><a href="https://repo.triara.co/repositorio/my_files?orderby=timestamp&order=desc">Fecha</a><span class="footable-sort-indicator"></span></th>
												<th data-hide="phone">Fecha de expiración</th>
												<th data-hide="phone,tablet">Image preview</th>
												<th data-hide="phone">Descarga</th>
											</tr>
										</thead>
										<tbody>
											<tr class="table_row">
												<td>
													<input type="checkbox" name="files[]" value="18358" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=18358" target="_blank"><strong>fortiweb-web-application-analysis-report-agua-2024-01-01-1742 158899</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">pdf</span>
												</td>
												<td class="description">
													COMISI&amp;Oacute;N DE REGULACI&amp;Oacute;N DE AGUA - FIREWALL</td>
												<td>
													244.91 KB</td>
												<td>
													2024/01/05</td>
												<td>
													<span class="label label-primary label_big">2025/01/05</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=18358" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row_alt">
												<td>
													<input type="checkbox" name="files[]" value="18321" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=18321" target="_blank"><strong>fortiweb-web-application-analysis-report-agua-2023-12-02-0246 150277 1</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">pdf</span>
												</td>
												<td class="description">
													COMISI&amp;Oacute;N DE REGULACI&amp;Oacute;N DE AGUA_NOVIEMBRE</td>
												<td>
													249.87 KB</td>
												<td>
													2024/01/03</td>
												<td>
													<span class="label label-primary label_big">2025/01/03</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=18321" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row">
												<td>
													<input type="checkbox" name="files[]" value="584" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=584" target="_blank"><strong>favicon</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">png</span>
												</td>
												<td class="description">
													prueba2</td>
												<td>
													-</td>
												<td>
													2020/03/03</td>
												<td>
													<span class="label label-success label_big">Nunca</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=584" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row_alt">
												<td>
													<input type="checkbox" name="files[]" value="585" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=585" target="_blank"><strong>21</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">jpg</span>
												</td>
												<td class="description">
													integracion</td>
												<td>
													-</td>
												<td>
													2020/03/03</td>
												<td>
													<span class="label label-success label_big">Nunca</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=585" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row">
												<td>
													<input type="checkbox" name="files[]" value="583" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=583" target="_blank"><strong>kallsonys</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">png</span>
												</td>
												<td class="description">
													prueba integration</td>
												<td>
													-</td>
												<td>
													2020/03/03</td>
												<td>
													<span class="label label-success label_big">Nunca</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=583" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row_alt">
												<td>
													<input type="checkbox" name="files[]" value="579" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=579" target="_blank"><strong>uuu</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">jpg</span>
												</td>
												<td class="description">
												</td>
												<td>
													-</td>
												<td>
													2020/03/02</td>
												<td>
													<span class="label label-success label_big">Nunca</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=579" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row">
												<td>
													<input type="checkbox" name="files[]" value="566" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=566" target="_blank"><strong>export-4</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">txt</span>
												</td>
												<td class="description">
													pruebas</td>
												<td>
													-</td>
												<td>
													2020/02/24</td>
												<td>
													<span class="label label-success label_big">Nunca</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=566" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
											<tr class="table_row_alt">
												<td>
													<input type="checkbox" name="files[]" value="10" class="batch_checkbox" />
												</td>
												<td class="file_name">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=10" target="_blank"><strong>logstokio</strong></a>
												</td>
												<td class="extra">
													<span class="label label-success label_big">zip</span>
												</td>
												<td class="description">
												</td>
												<td>
													-</td>
												<td>
													2019/06/13</td>
												<td>
													<span class="label label-success label_big">Nunca</span>
												</td>
												<td class="extra">
												</td>
												<td class="text-center">
													<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=10" class="btn btn-primary btn-sm btn-wide" target="_blank">Descargar</a>
												</td>
											</tr>
										</tbody>
									</table>
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-12 text-center">
												<nav aria-label="Resultados de Navegación">
													<div class="pagination_wrapper">
														<ul class="pagination">
															<li class="active"><a href="#">1</a></li>
															<li><a href="https://repo.triara.co/repositorio/my_files?page=2">2</a></li>
															<li>
																<a href="https://repo.triara.co/repositorio/my_files?page=2" data-page="next">&rsaquo;</a>
															</li>
															<li>
																<a href="https://repo.triara.co/repositorio/my_files?page=2" data-page="last"><span aria-hidden="true">&raquo;</span></a>
															</li>
														</ul>
													</div>
												</nav>
												<div class="form-group">
													<label class="control-label hidden-xs hidden-sm">Valla a:</label>
													<input type="text" class="form-control" name="page" id="go_to_page" value="1" />
												</div>
												<div class="form-group">
													<button type="submit" class="form-control"><span aria-hidden="true" class="glyphicon glyphicon-ok"></span></button>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div> <!-- right_column -->
						</div> <!-- wrapper -->

						<footer>
							<div id="footer">
								Claro Colombia </div>
						</footer>

					</div>
					<script src="https://repo.triara.co/repositorio/assets/bootstrap/js/bootstrap.min.js"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/jquery.validations.js"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/jquery.psendmodal.js"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/jen/jen.js"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/js.cookie.js"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/main.js"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/js.functions.php"></script>
					<script src="https://repo.triara.co/repositorio/includes/js/footable/footable.min.js"></script>
</body>

</html>