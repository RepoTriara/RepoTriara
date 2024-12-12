
<!doctype html>
<html lang="es_CO">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Administraci&oacute;n de Grupos &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="https://repo.triara.co/repositorio/favicon.ico" />
<link rel="icon" type="image/png" href="https://repo.triara.co/repositorio/img/favicon/favicon-32.png" sizes="32x32">
<link rel="apple-touch-icon" href="https://repo.triara.co/repositorio/img/favicon/favicon-152.png" sizes="152x152">
	<script type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/jquery.1.12.4.min.js"></script>

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
</head>

<body class="groups logged-in logged-as-admin menu_hidden backend">
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
<li class="">
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
			<a href="{{ route('add_client') }}"><span class="submenu_label">Añadir nuevo cliente</span></a>
		</li>

		<li class="">
		<a href="{{ route('customer_manager') }}"><span class="submenu_label">Administración de clientes</span></a>
		</li>

		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown current_nav">
	<a href="#" class="nav_top_level"><i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañias</span></a>
	<ul class="dropdown_content">
    <li class="">
    <a href="{{ route('add_company') }}"><span class="submenu_label">Añadir nueva compañia</span></a>
</li>
		<li class="current_page">
			<a href="{{ route('manage_company') }}"><span class="submenu_label">Administrar Compañias</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-users fa-fw" aria-hidden="true"></i><span class="menu_label">Usuarios del Sistema</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/users-add.php"><span class="submenu_label">Añadir nuevo usuario</span></a>
		</li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/users.php"><span class="submenu_label">Administrar usuarios</span></a>
		</li>
	</ul>
</li>
<li class="separator"></li><li class="separator"></li></ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">
				
				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Administración de Grupos</h2>
						</div>
					</div>
				</div>

				<div class="row">

<div class="col-xs-12">


	<div class="form_actions_left">
		<div class="form_actions_limit_results">
				<form action="groups.php" name="form_search" method="get" class="form-inline">
				<div class="form-group group_float">
			<input type="text" name="search" id="search" value="" class="txtfield form_actions_search_box form-control" />
		</div>
		<button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
	</form>
		</div>
	</div>

	<form action="groups.php" name="groups_list" method="get" class="form-inline">
				<div class="form_actions_right">
			<div class="form_actions">
				<div class="form_actions_submit">
					<div class="form-group group_float">
						<label class="control-label hidden-xs hidden-sm"><i class="glyphicon glyphicon-check"></i> Acciones de grupo seleccionadas:</label>
						<select name="action" id="action" class="txtfield form-control">
																<option value="none">Seleccione la acción</option>
																<option value="delete">Eliminar</option>
													</select>
					</div>
					<button type="submit" id="do_action" class="btn btn-sm btn-default">Proceder</button>
				</div>
			</div>
		</div>
		<div class="clear"></div>

		<div class="form_actions_count">
			<p>Encontró: <span>348 grupos</span></p>
		</div>

		<div class="clear"></div>

		<table id="groups_tbl" class="footable table">
<thead>
<tr><th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all" value="0" /></th><th class="active footable-sorted-desc"><a href="https://repo.triara.co/repositorio/groups.php?orderby=name&order=desc">Nombre del grupo</a><span class="footable-sort-indicator"></span></th><th data-hide="phone"><a href="https://repo.triara.co/repositorio/groups.php?orderby=description&order=desc">Descripción</a><span class="footable-sort-indicator"></span></th><th>Miembros</th><th data-hide="phone">Archivos</th><th><a href="https://repo.triara.co/repositorio/groups.php?orderby=active&order=desc">Público</a><span class="footable-sort-indicator"></span></th><th data-hide="phone"><a href="https://repo.triara.co/repositorio/groups.php?orderby=created_by&order=desc">Creado por</a><span class="footable-sort-indicator"></span></th><th data-hide="phone"><a href="https://repo.triara.co/repositorio/groups.php?orderby=timestamp&order=desc">Adicionado</a><span class="footable-sort-indicator"></span></th><th data-hide="phone">Ver</th><th data-hide="phone">Comportamiento</th></tr>
</thead>
<tbody>
<tr class="table_row">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="348" />
</td>
<td>
5D DISEADORES ASOCIADOS LTDA_830076030-N_11897354</td>
<td>
</td>
<td>
10</td>
<td>
</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
sharemngr</td>
<td>
2020/01/27</td>
<td>
<a href="#" class="btn btn-default disabled btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=348" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row_alt">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="338" />
</td>
<td>
A TODA HORA ATH_800143407-1_19385</td>
<td>
</td>
<td>
11</td>
<td>
51</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
sharemngr</td>
<td>
2020/01/27</td>
<td>
<a href="manage-files.php?group_id=338" class="btn btn-primary btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=338" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="88" />
</td>
<td>
A.C.H. COLOMBIA S.A._830078512-6_127110</td>
<td>
</td>
<td>
11</td>
<td>
3</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
viviana.bajonero</td>
<td>
2019/11/13</td>
<td>
<a href="manage-files.php?group_id=88" class="btn btn-primary btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=88" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row_alt">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="104" />
</td>
<td>
ABB LTDA_860003563-9_34635</td>
<td>
</td>
<td>
10</td>
<td>
2</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
sharemngr</td>
<td>
2020/01/24</td>
<td>
<a href="manage-files.php?group_id=104" class="btn btn-primary btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=104" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="232" />
</td>
<td>
ACCESS TEAM S A S_800212722-1_18843</td>
<td>
</td>
<td>
16</td>
<td>
62</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
sharemngr</td>
<td>
2020/01/27</td>
<td>
<a href="manage-files.php?group_id=232" class="btn btn-primary btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=232" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row_alt">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="289" />
</td>
<td>
ADCAP COLOMBIA SA COMISIONISTAS DE BOLSDA_890931609-9_11012</td>
<td>
</td>
<td>
10</td>
<td>
</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
sharemngr</td>
<td>
2020/01/27</td>
<td>
<a href="#" class="btn btn-default disabled btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=289" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="368" />
</td>
<td>
AEXPRESS S.A</td>
<td>
</td>
<td>
10</td>
<td>
25</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
Catherine.velascog</td>
<td>
2021/08/06</td>
<td>
<a href="manage-files.php?group_id=368" class="btn btn-primary btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=368" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row_alt">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="96" />
</td>
<td>
AGAVAL S.A_890903995-8_ 11212866</td>
<td>
</td>
<td>
11</td>
<td>
</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
derrick.davis</td>
<td>
2020/01/23</td>
<td>
<a href="#" class="btn btn-default disabled btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=96" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="50" />
</td>
<td>
AGENCIA DE AUTOMOVILES S.A._890900016-9_27943</td>
<td>
</td>
<td>
11</td>
<td>
123</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
operador1</td>
<td>
2019/08/05</td>
<td>
<a href="manage-files.php?group_id=50" class="btn btn-primary btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=50" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
<tr class="table_row_alt">
<td>
<input type="checkbox" class="batch_checkbox" name="batch[]" value="276" />
</td>
<td>
AGROAVICOLA SAN MARINO LTDA_830016868-7_12041214</td>
<td>
</td>
<td>
10</td>
<td>
</td>
<td>
<a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a></td>
<td>
sharemngr</td>
<td>
2020/01/27</td>
<td>
<a href="#" class="btn btn-default disabled btn-sm">Archivos</a></td>
<td>
<a href="groups-edit.php?id=276" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
</td>
</tr>
</tbody>
</table>
<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center">
										<nav aria-label="Resultados de Navegación">
											<div class="pagination_wrapper">
												<ul class="pagination"><li class="active"><a href="#">1</a></li><li><a href="https://repo.triara.co/repositorio/groups.php?page=2">2</a></li><li><a href="https://repo.triara.co/repositorio/groups.php?page=3">3</a></li><li><a href="https://repo.triara.co/repositorio/groups.php?page=4">4</a></li><li class="disabled"><a href="#">...</a></li><li><a href="https://repo.triara.co/repositorio/groups.php?page=35">35</a></li><li>
										<a href="https://repo.triara.co/repositorio/groups.php?page=2" data-page="next">&rsaquo;</a>
									</li>
									<li>
										<a href="https://repo.triara.co/repositorio/groups.php?page=35" data-page="last"><span aria-hidden="true">&raquo;</span></a>
									</li>				</ul>
									</div>
								</nav><div class="form-group">
									<label class="control-label hidden-xs hidden-sm">Valla a:</label>
                                    <input type="text" class="form-control" name="page" id="go_to_page" value="1" />
								</div>
								<div class="form-group">
									<button type="submit" class="form-control"><span aria-hidden="true" class="glyphicon glyphicon-ok"></span></button>
								</div>		</div>
							</div>
						</div>	</form>
	
</div>

					</div> <!-- row -->
				</div> <!-- container-fluid -->

					<footer>
		<div id="footer">
			Claro Colombia		</div>
	</footer>
			<script src="https://repo.triara.co/repositorio/assets/bootstrap/js/bootstrap.min.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jquery.validations.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jquery.psendmodal.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jen/jen.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/js.cookie.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/main.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/js.functions.php"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/footable/footable.min.js"></script>
			</div> <!-- main_content -->
		</div> <!-- container-custom -->

	</body>
</html>