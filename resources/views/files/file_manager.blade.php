<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Administrar archivos &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/footable/css/footable.core.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
</head>

<body class="manage-files logged-in logged-as-admin menu_hidden backend">
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
					<a href="{{ route('profile.edit') }}" class="my_account"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a>
				</li>
				<li>
<<<<<<< HEAD
					<a href="https://repo.triara.co/repositorio/process.php?do=logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Salir</a>
=======
					<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
>>>>>>> 9a9bc567e73f904c9c7f633faeaca8cb98e15022
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
<<<<<<< HEAD
				<li class="">
					<a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span></a>
				</li>
				<li class="separator"></li>
				<li class="has_dropdown current_nav">
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
							<a href="{{ route('add_client') }}"><span class="submenu_label">Añadir nuevo cliente</span></a>
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
				<li class="separator"></li>
				<li class="separator"></li>
			</ul>
=======
<li class="">
	<a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span></a>
</li>
<li class="separator"></li><li class="has_dropdown current_nav">
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
    <a href="{{ route('companies.add') }}"><span class="submenu_label">Añadir nueva compañia</span></a>
</li>
<li class="">
        <a href="{{ route('companies.manage') }}"><span class="submenu_label">Administrar Compañias</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="separator"></li><li class="separator"></li></ul>
>>>>>>> 9a9bc567e73f904c9c7f633faeaca8cb98e15022
		</div>

		<div class="main_content">
			<div class="container-fluid">

				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Administrar archivos</h2>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-xs-12">
						<div class="form_actions_left">
							<div class="form_actions_limit_results">
								<form action="manage-files.php" name="form_search" method="get" class="form-inline">
									<div class="form-group group_float">
										<input type="text" name="search" id="search" value="" class="txtfield form_actions_search_box form-control" />
									</div>
									<button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
								</form>

								<form action="manage-files.php" name="files_filters" method="get" class="form-inline form_filters">
									<div class="form-group group_float">
										<select name="uploader" id="uploader" class="txtfield form-control">
											<option value="0">Cargador</option>
											<option value="45644670">45644670</option>
											<option value="45997392">45997392</option>
											<option value="45998677">45998677</option>
											<option value="46020158">46020158</option>
											<option value="46034707">46034707</option>
											<option value="alberto.martinez">alberto.martinez</option>
											<option value="andres.quinterov">andres.quinterov</option>
											<option value="CARLOS.AREVALO.G">CARLOS.AREVALO.G</option>
											<option value="carlos.diazt.ext">carlos.diazt.ext</option>
											<option value="Catherine.velascog">Catherine.velascog</option>
											<option value="CGD01">CGD01</option>
											<option value="david.castrillonb">david.castrillonb</option>
											<option value="derrick.davis">derrick.davis</option>
											<option value="dherrera.sos">dherrera.sos</option>
											<option value="Diana.rodriguezt">Diana.rodriguezt</option>
											<option value="Dylanr">Dylanr</option>
											<option value="EAN7196A">EAN7196A</option>
											<option value="ec0583o">ec0583o</option>
											<option value="EC0630L">EC0630L</option>
											<option value="EC1798N">EC1798N</option>
											<option value="EC2131A">EC2131A</option>
											<option value="ec2518c">ec2518c</option>
											<option value="EC4543G">EC4543G</option>
											<option value="EC5025C">EC5025C</option>
											<option value="EC5087E">EC5087E</option>
											<option value="EC5946E">EC5946E</option>
											<option value="EC6393P">EC6393P</option>
											<option value="EC6788K">EC6788K</option>
											<option value="EC9034O">EC9034O</option>
											<option value="ECF0160D">ECF0160D</option>
											<option value="ECF0271A">ECF0271A</option>
											<option value="ECF0304C">ECF0304C</option>
											<option value="ECF0427A">ECF0427A</option>
											<option value="ECF0576D">ECF0576D</option>
											<option value="ECF1006A">ECF1006A</option>
											<option value="ECF1221B">ECF1221B</option>
											<option value="ECF1915B">ECF1915B</option>
											<option value="ECF2304E">ECF2304E</option>
											<option value="ECF2615B">ECF2615B</option>
											<option value="ECF2914C">ECF2914C</option>
											<option value="ECF3020A">ECF3020A</option>
											<option value="ECF3808C">ECF3808C</option>
											<option value="ecf4050a">ecf4050a</option>
											<option value="ECF4676B">ECF4676B</option>
											<option value="ECF5070A">ECF5070A</option>
											<option value="ECF5245B">ECF5245B</option>
											<option value="ECF6424D">ECF6424D</option>
											<option value="ECF6876D">ECF6876D</option>
											<option value="ECF6922A">ECF6922A</option>
											<option value="ECF6952A">ECF6952A</option>
											<option value="ECF7383A">ECF7383A</option>
											<option value="ECF7630D">ECF7630D</option>
											<option value="ECF7912A">ECF7912A</option>
											<option value="ECF9001B">ECF9001B</option>
											<option value="ECF9760A">ECF9760A</option>
											<option value="ECF9969A">ECF9969A</option>
											<option value="ecm0437f">ecm0437f</option>
											<option value="ECM0896G">ECM0896G</option>
											<option value="ECM1100L">ECM1100L</option>
											<option value="ECM1309E">ECM1309E</option>
											<option value="ECM1472I">ECM1472I</option>
											<option value="ECM1707I">ECM1707I</option>
											<option value="ECM2312I">ECM2312I</option>
											<option value="ECM2946L">ECM2946L</option>
											<option value="ECM3139G">ECM3139G</option>
											<option value="ECM3261E">ECM3261E</option>
											<option value="ECM3983F">ECM3983F</option>
											<option value="ECM4014G">ECM4014G</option>
											<option value="ECM4377F">ECM4377F</option>
											<option value="ECM4970C">ECM4970C</option>
											<option value="ECM5254D">ECM5254D</option>
											<option value="ECM5317G">ECM5317G</option>
											<option value="ECM5449F">ECM5449F</option>
											<option value="ECM5642I">ECM5642I</option>
											<option value="ECM5865F">ECM5865F</option>
											<option value="ECM5983I">ECM5983I</option>
											<option value="ECM6000G">ECM6000G</option>
											<option value="ECM6201F">ECM6201F</option>
											<option value="ECM6232G">ECM6232G</option>
											<option value="ECM6431F">ECM6431F</option>
											<option value="ECM6591C">ECM6591C</option>
											<option value="ECM6653B">ECM6653B</option>
											<option value="ECM6753G">ECM6753G</option>
											<option value="ECM7406S">ECM7406S</option>
											<option value="ECM8046H">ECM8046H</option>
											<option value="ECM8193I">ECM8193I</option>
											<option value="ECM8683H">ECM8683H</option>
											<option value="ECM8851G">ECM8851G</option>
											<option value="ECM9034K">ECM9034K</option>
											<option value="ECM9322G">ECM9322G</option>
											<option value="EIQ3951A">EIQ3951A</option>
											<option value="EKE6877A">EKE6877A</option>
											<option value="EKH0301A">EKH0301A</option>
											<option value="EKH3958A">EKH3958A</option>
											<option value="elkin.saenz.ext">elkin.saenz.ext</option>
											<option value="elu0116a">elu0116a</option>
											<option value="elu1858a">elu1858a</option>
											<option value="emily.guirales">emily.guirales</option>
											<option value="francisco.Fuentesp.Ext">francisco.Fuentesp.Ext</option>
											<option value="francisco.mosquera.ext">francisco.mosquera.ext</option>
											<option value="ICF2402A">ICF2402A</option>
											<option value="ICM1648A">ICM1648A</option>
											<option value="integracion">integracion</option>
											<option value="ITOPS">ITOPS</option>
											<option value="ivand.aparicior">ivand.aparicior</option>
											<option value="javier.correa">javier.correa</option>
											<option value="johan.rodriguez">johan.rodriguez</option>
											<option value="Jorge.Ruiz.Ext">Jorge.Ruiz.Ext</option>
											<option value="juan.munevar">juan.munevar</option>
											<option value="juan.nogueraa.ext">juan.nogueraa.ext</option>
											<option value="JulianaSanchez02">JulianaSanchez02</option>
											<option value="karol.mayorga">karol.mayorga</option>
											<option value="leonel.ramirez.ext">leonel.ramirez.ext</option>
											<option value="lorena.puertos">lorena.puertos</option>
											<option value="luz.villar">luz.villar</option>
											<option value="maria.ruizr">maria.ruizr</option>
											<option value="mccastellanosz">mccastellanosz</option>
											<option value="Miguel.Urrea.Ext">Miguel.Urrea.Ext</option>
											<option value="operador1">operador1</option>
											<option value="operador2">operador2</option>
											<option value="operador3">operador3</option>
											<option value="PRUB01">PRUB01</option>
											<option value="prueba">prueba</option>
											<option value="rafael.ojito">rafael.ojito</option>
											<option value="sharemngr">sharemngr</option>
											<option value="SPEEDY1">SPEEDY1</option>
											<option value="system">system</option>
											<option value="viviana.bajonero">viviana.bajonero</option>
											<option value="viviana.tovarc">viviana.tovarc</option>
											<option value="william.fierro">william.fierro</option>
											<option value="william1">william1</option>
											<option value="wilson.sanchez">wilson.sanchez</option>
											<option value="yair.franco">yair.franco</option>
										</select>
									</div>
									<button type="submit" id="btn_proceed_filter_clients" class="btn btn-sm btn-default">Filtrar</button>
								</form>
							</div>
						</div>


						<form action="manage-files.php" name="files_list" method="get" class="form-inline">
							<div class="form_actions_right">
								<div class="form_actions">
									<div class="form_actions_submit">
										<div class="form-group group_float">
											<label class="control-label hidden-xs hidden-sm"><i class="glyphicon glyphicon-check"></i> Acciones de archivos seleccionados:</label>
											<select name="action" id="action" class="txtfield form-control">
												<option value="none">Seleccione la acción</option>
												<option value="delete">Eliminar</option>
												<option value="zip">Descarga comprimida</option>
											</select>
										</div>
										<button type="submit" id="do_action" class="btn btn-sm btn-default">Proceder</button>
									</div>
								</div>
							</div>

							<div class="clear"></div>

							<div class="form_actions_count">
								<p class="form_count_total">Encontró: <span>21448 Archivos</span></p>
							</div>

							<div class="clear"></div>

							<table id="files_tbl" class="footable table">
								<thead>
									<tr>
										<th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all" value="0" /></th>
										<th class="active footable-sorted-desc" data-hide="phone"><a href="https://repo.triara.co/repositorio/manage-files.php?orderby=timestamp&order=desc">Adicionado</a><span class="footable-sort-indicator"></span></th>
										<th data-hide="phone,tablet">Tipo</th>
										<th><a href="https://repo.triara.co/repositorio/manage-files.php?orderby=filename&ordeorder=desc">Título</a><span class="footable-sort-indicator"></span></th>
										<th>tamaño</th>
										<th data-hide="phone,tablet"><a href="https://repo.triara.co/repositorio/manage-files.php?orderby=uploader&order=desc">Cargador</a><span class="footable-sort-indicator"></span></th>
										<th data-hide="phone">Asignado</th>
										<th data-hide="phone"><a href="https://repo.triara.co/repositorio/manage-files.php?orderby=public_allow&order=desc">Permisos públicoas</a><span class="footable-sort-indicator"></span></th>
										<th data-hide="phone">Expira</th>
										<th data-hide="phone"><a href="https://repo.triara.co/repositorio/manage-files.php?orderby=download_count&order=desc">Total descargas</a><span class="footable-sort-indicator"></span></th>
										<th data-hide="phone">Comportamiento</th>
									</tr>
								</thead>
								<tbody>
									<tr class="table_row">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21791" />
										</td>
										<td>
											2024/12/11</td>
										<td>
											xlsx</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21791" target="_blank">6-informe-medios-magnticos-respaldos-semanales-mensuales-mes-noviembre-2024</a>
										</td>
										<td>
											20.6 KB</td>
										<td>
											ECF5245B</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21791" data-token="yaVUYtjQLUif6BZAhoo2tPm4IgOWN7GZ">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/11</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21791" class="btn-default disabled btn btn-sm" title="6-informe-medios-magnticos-respaldos-semanales-mensuales-mes-noviembre-2024">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21791" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row_alt">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21792" />
										</td>
										<td>
											2024/12/11</td>
										<td>
											xlsx</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21792" target="_blank">7-informe-medios-magnticos-mensual-noviembre-2024</a>
										</td>
										<td>
											32.08 KB</td>
										<td>
											ECF5245B</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21792" data-token="MOwUj9jI7ZZ1lrVkFGepridTar1iesfy">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/11</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21792" class="btn-default disabled btn btn-sm" title="7-informe-medios-magnticos-mensual-noviembre-2024">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21792" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21790" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21790" target="_blank">informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-fundacion-mundo-mujer</a>
										</td>
										<td>
											970.73 KB</td>
										<td>
											Miguel.Urrea.Ext</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21790" data-token="WLsISkmXBEStpb76LRZGhA7PRnQPE27E">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21790" class="btn-default disabled btn btn-sm" title="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-fundacion-mundo-mujer">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21790" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row_alt">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21789" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21789" target="_blank">informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-servicios-de-activos-especiales-sae 1</a>
										</td>
										<td>
											633.94 KB</td>
										<td>
											Miguel.Urrea.Ext</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21789" data-token="4iw1ORusNDLZwgsz5KBBW8c8V0dO0om6">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21789" class="btn-default disabled btn btn-sm" title="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-servicios-de-activos-especiales-sae 1">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21789" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21788" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21788" target="_blank">informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-exito-triara</a>
										</td>
										<td>
											704.88 KB</td>
										<td>
											Miguel.Urrea.Ext</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21788" data-token="rpTXgotCnO94wlzP9SWymF75rNWa4gA9">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21788" class="btn-default disabled btn btn-sm" title="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-exito-triara">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21788" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row_alt">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21787" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21787" target="_blank">informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-deceval</a>
										</td>
										<td>
											627.65 KB</td>
										<td>
											Miguel.Urrea.Ext</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21787" data-token="OCnysiHoGTCWzcsTY7LJhBiUjfBae1Wy">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21787" class="btn-default disabled btn btn-sm" title="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-deceval">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21787" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21786" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21786" target="_blank">informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-cifin-asobancaria</a>
										</td>
										<td>
											1.08 MB</td>
										<td>
											Miguel.Urrea.Ext</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21786" data-token="5H5yNmsMGgnlr2rdIAXGNrNRT6M5qu9R">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21786" class="btn-default disabled btn btn-sm" title="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-cifin-asobancaria">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21786" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row_alt">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21785" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21785" target="_blank">informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-fiduprevisora 1</a>
										</td>
										<td>
											641.42 KB</td>
										<td>
											Miguel.Urrea.Ext</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21785" data-token="M4XpFV8YrIE19A75wFXTDNgWwIOMNycW">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21785" class="btn-default disabled btn btn-sm" title="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-fiduprevisora 1">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21785" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21784" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											pdf</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21784" target="_blank">informe-mensual-servicios-postales 472 apps 06-nov-al-06-dic 2024</a>
										</td>
										<td>
											1.76 MB</td>
										<td>
											46020158</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21784" data-token="04vPnyxqkX3hFNIUccKmZyc6sazeJbNR">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21784" class="btn-default disabled btn btn-sm" title="informe-mensual-servicios-postales 472 apps 06-nov-al-06-dic 2024">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21784" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
										</td>
									</tr>
									<tr class="table_row_alt">
										<td>
											<input type="checkbox" class="batch_checkbox" name="batch[]" value="21783" />
										</td>
										<td>
											2024/12/10</td>
										<td>
											xlsx</td>
										<td class="file_name">
											<a href="https://repo.triara.co/repositorio/process.php?do=download&amp;id=21783" target="_blank">informe-mensual-active-directory-472 06-nov-al-06-de-dic 2024</a>
										</td>
										<td>
											995.42 KB</td>
										<td>
											46020158</td>
										<td>
											<span class="label label-success">Si</span>
										</td>
										<td class="col_visibility">
											<a href="javascript:void(0);" class="btn btn-primary btn-sm public_link" data-type="file" data-id="21783" data-token="X0EZeY9n3RxZujh2GQmtb10eGC76ZYMB">Descarga</a>
										</td>
										<td>
											<a href="javascript:void(0);" class="btn btn-info disabled btn-sm" rel="" title="">Expira en 2025/12/10</a>
										</td>
										<td>
											<a href="https://repo.triara.co/repositorio/download-information.php?id=21783" class="btn-default disabled btn btn-sm" title="informe-mensual-active-directory-472 06-nov-al-06-de-dic 2024">0 Descargas</a>
										</td>
										<td>
											<a href="edit-file.php?file_id=21783" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
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
													<li><a href="https://repo.triara.co/repositorio/manage-files.php?page=2">2</a></li>
													<li><a href="https://repo.triara.co/repositorio/manage-files.php?page=3">3</a></li>
													<li><a href="https://repo.triara.co/repositorio/manage-files.php?page=4">4</a></li>
													<li class="disabled"><a href="#">...</a></li>
													<li><a href="https://repo.triara.co/repositorio/manage-files.php?page=2145">2145</a></li>
													<li>
														<a href="https://repo.triara.co/repositorio/manage-files.php?page=2" data-page="next">&rsaquo;</a>
													</li>
													<li>
														<a href="https://repo.triara.co/repositorio/manage-files.php?page=2145" data-page="last"><span aria-hidden="true">&raquo;</span></a>
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
					</div>

				</div> <!-- row -->
			</div> <!-- container-fluid -->

			<footer>
				<div id="footer">
					Claro Colombia </div>
			</footer>
			<script src="{{asset('includes/js/footable/footable.min.js')}}"></script>
			<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('includes/js/jquery.validations.js')}}"></script>
			<script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
			<script src="{{asset( 'includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			<script src="{{asset('includes/js/flot/jquery.flot.min.js')}}"></script>
			<script src="{{asset('includes/js/flot/jquery.flot.resize.min.js')}}"></script>
			<script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->

</body>

</html>