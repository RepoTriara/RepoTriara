<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administraci&oacute;n de Clientes &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
    <link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
    <script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

    <!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/footable/css/footable.core.css')}}" />

</head>

<body class="clients logged-in logged-as-admin menu_hidden backend">
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
                <li class="separator"></li>
                <li class="has_dropdown ">
                    <a href="#" class="nav_top_level"><i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span></a>
                    <ul class="dropdown_content">
                        <a href="{{ route('upload') }}"><span class="submenu_label">Subir</span></a>
                </li>
                <li class="divider"></li>
                <li class="">
                    <a href="{{ route('file_manager') }}"><span class="submenu_label">Administrar archivos</span></a>
                </li>
                <li class="">
                    <a href="{{ route('search_orphan_files') }}"><span class="submenu_label">Buscar archivos huerfanos</span></a>

                <li class="divider"></li>
                <li class="">
                    <a href="https://repo.triara.co/repositorio/categories.php"><span class="submenu_label">Categorías</span></a>
                </li>
            </ul>
            </li>
            <li class="has_dropdown current_nav">
                <a href="#" class="nav_top_level"><i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span></a>
                <ul class="dropdown_content">
                    <li class="">
                        <a href="{{ route('add_client') }}"><span class="submenu_label">Añadir nuevo cliente</span></a>
                    </li>
                    <li class="current_page">
                        <a href="{{ route('customer_manager') }}"><span class="submenu_label">Administración de clientes</span></a>
                    </li>
                    <li class="divider"></li>
                </ul>
            </li>
            <li class="has_dropdown ">
                <a href="#" class="nav_top_level"><i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañias</span></a>
                <ul class="dropdown_content">
                    <li class="">
                        <a href="{{ route('add_company') }}"><span class="submenu_label">Añadir nueva compañia</span></a>
                    </li>
                    <li class="">
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
            <li class="separator"></li>
            <li class="separator"></li>
            </ul>
        </div>

        <div class="main_content">
            <div class="container-fluid">
                <div class="system_msg update_msg">
                    <div class="row">
                        <div class="col-sm-8">
                            <strong>Actualización disponible</strong> ProjectSend 1720 has been released
                        </div>
                        <div class="col-sm-4 text-right">
                            <a href="https://www.projectsend.org/download/13240/?tmstv=1733950355" class="btn btn-default btn-xs" target="_blank">Descarga</a> <a href="https://www.projectsend.org/change-log-detail/projectsend-r1720/" target="_blank" class="btn btn-default btn-xs">Changelog</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Administración de Clientes</h2>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-12">
                        <div class="form_actions_left">
                            <div class="form_actions_limit_results">
                                <form action="clients.php" name="form_search" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search" value="" class="txtfield form_actions_search_box form-control" />
                                    </div>
                                    <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
                                </form>

                                <form action="clients.php" name="clients_filters" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <select name="active" id="active" class="txtfield form-control">
                                            <option value="2">Todo los estados</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                    <button type="submit" id="btn_proceed_filter_clients" class="btn btn-sm btn-default">Filtrar</button>
                                </form>
                            </div>
                        </div>

                        <form action="clients.php" name="clients_list" method="get" class="form-inline">
                            <div class="form_actions_right">
                                <div class="form_actions">
                                    <div class="form_actions_submit">
                                        <div class="form-group group_float">
                                            <label class="control-label hidden-xs hidden-sm"><i class="glyphicon glyphicon-check"></i> Acciones de cliente seleccionadas:</label>
                                            <select name="action" id="action" class="txtfield form-control">
                                                <option value="none">Seleccione la acción</option>
                                                <option value="activate">Activar</option>
                                                <option value="deactivate">Desactivar</option>
                                                <option value="delete">Eliminar</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="do_action" class="btn btn-sm btn-default">Proceder</button>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>

                            <div class="form_actions_count">
                                <p>Encontró: <span>335 Clientes</span></p>
                            </div>

                            <div class="clear"></div>

                            <table id="clients_tbl" class="footable table">
                                <thead>
                                    <tr>
                                        <th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all" value="0" /></th>
                                        <th class="active footable-sorted-desc"><a href="https://repo.triara.co/repositorio/clients.php?orderby=name&order=desc">Nombre completo</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone,tablet"><a href="https://repo.triara.co/repositorio/clients.php?orderby=user&order=desc">Ingresar nombre de usuario</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone,tablet"><a href="https://repo.triara.co/repositorio/clients.php?orderby=email&order=desc">E-Mail</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone">Cargas</th>
                                        <th data-hide="phone">Archivos: Propios</th>
                                        <th data-hide="phone">Archivos: Grupos</th>
                                        <th><a href="https://repo.triara.co/repositorio/clients.php?orderby=active&order=desc">Estado</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone">Grupos Activos</th>
                                        <th data-hide="phone,tablet">Notificación</th>
                                        <th data-hide="phone"><a href="https://repo.triara.co/repositorio/clients.php?orderby=max_file_size&order=desc">Max. tamaño permitido</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone,tablet"><a href="https://repo.triara.co/repositorio/clients.php?orderby=timestamp&order=desc">Adicionado</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone">Ver</th>
                                        <th data-hide="phone">Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="622" />
                                        </td>
                                        <td>
                                            --</td>
                                        <td>
                                            ANDRES.CORTES</td>
                                        <td>
                                            eror@pluxeegroup.com</td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            Si</td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2024/10/22</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-default disabled">Archivos</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-default disabled">Grupos</a>
                                            <a href="my_files/?client=ANDRES.CORTES" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=622" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="38" />
                                        </td>
                                        <td>
                                            ACH COLOMBIA S A</td>
                                        <td>
                                            eduard.hernandez</td>
                                        <td>
                                            eahernandez@achcolombia.com.co</td>
                                        <td>
                                        </td>
                                        <td>
                                            53</td>
                                        <td>
                                            466</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            2</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2019/11/13</td>
                                        <td>
                                            <a href="manage-files.php?client_id=38" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=38" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=eduard.hernandez" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=38" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="105" />
                                        </td>
                                        <td>
                                            Adrian Gutierrez</td>
                                        <td>
                                            adrian.gutierrez</td>
                                        <td>
                                            adrian.gutierrez@efecty.com.co</td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            67</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2020/02/04</td>
                                        <td>
                                            <a href="manage-files.php?client_id=105" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=105" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=adrian.gutierrez" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=105" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="78" />
                                        </td>
                                        <td>
                                            Adriana Castillo</td>
                                        <td>
                                            adriana.castillo</td>
                                        <td>
                                            adriana.castillo@fiduagraria.gov.co</td>
                                        <td>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                        </td>
                                        <td>
                                            <span class="label label-danger">Inactivo</span>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            Si</td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/01/29</td>
                                        <td>
                                            <a href="manage-files.php?client_id=78" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-default disabled">Grupos</a>
                                            <a href="my_files/?client=adriana.castillo" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=78" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="379" />
                                        </td>
                                        <td>
                                            Adriana Olivero</td>
                                        <td>
                                            adriana.olivero</td>
                                        <td>
                                            oliveroa@uninorte.edu.co</td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            26</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2020/09/14</td>
                                        <td>
                                            <a href="manage-files.php?client_id=379" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=379" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=adriana.olivero" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=379" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="50" />
                                        </td>
                                        <td>
                                            AGAVAL SA _ 11212866</td>
                                        <td>
                                            Oscar.Hernandez</td>
                                        <td>
                                            analistainfraestructura1@agaval.com.co</td>
                                        <td>
                                        </td>
                                        <td>
                                            2</td>
                                        <td>
                                        </td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2020/01/23</td>
                                        <td>
                                            <a href="manage-files.php?client_id=50" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=50" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=Oscar.Hernandez" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=50" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="49" />
                                        </td>
                                        <td>
                                            AGENCIA DE AUTOMOVILES S A</td>
                                        <td>
                                            Carlos.RiosP</td>
                                        <td>
                                            Carlos.Rios@sociabpo.com</td>
                                        <td>
                                        </td>
                                        <td>
                                            187</td>
                                        <td>
                                            123</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2020/01/23</td>
                                        <td>
                                            <a href="manage-files.php?client_id=49" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=49" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=Carlos.RiosP" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=49" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="438" />
                                        </td>
                                        <td>
                                            Alejandro Guerra Guerra</td>
                                        <td>
                                            Alejandro.Guerra</td>
                                        <td>
                                            analistadb@cuerosvelez.com</td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            47</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2021/04/14</td>
                                        <td>
                                            <a href="manage-files.php?client_id=438" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=438" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=Alejandro.Guerra" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=438" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="342" />
                                        </td>
                                        <td>
                                            Alejandro Quintero Andrade</td>
                                        <td>
                                            aquintero</td>
                                        <td>
                                            aquintero@processoft.com.co</td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            132</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2020/07/11</td>
                                        <td>
                                            <a href="manage-files.php?client_id=342" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=342" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=aquintero" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=342" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="495" />
                                        </td>
                                        <td>
                                            Alejandro Ramirez</td>
                                        <td>
                                            aramirez</td>
                                        <td>
                                            wiramirez@keralty.com</td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            216</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            1</td>
                                        <td>
                                            Si</td>
                                        <td>
                                            2048mb</td>
                                        <td>
                                            2022/02/03</td>
                                        <td>
                                            <a href="manage-files.php?client_id=495" class="btn btn-sm btn-primary">Archivos</a>
                                            <a href="groups.php?member=495" class="btn btn-sm btn-primary">Grupos</a>
                                            <a href="my_files/?client=aramirez" class="btn btn-primary btn-sm" target="_blank">Como cliente</a>
                                        </td>
                                        <td>
                                            <a href="clients-edit.php?id=495" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
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
                                                    <li><a href="https://repo.triara.co/repositorio/clients.php?page=2">2</a></li>
                                                    <li><a href="https://repo.triara.co/repositorio/clients.php?page=3">3</a></li>
                                                    <li><a href="https://repo.triara.co/repositorio/clients.php?page=4">4</a></li>
                                                    <li class="disabled"><a href="#">...</a></li>
                                                    <li><a href="https://repo.triara.co/repositorio/clients.php?page=34">34</a></li>
                                                    <li>
                                                        <a href="https://repo.triara.co/repositorio/clients.php?page=2" data-page="next">&rsaquo;</a>
                                                    </li>
                                                    <li>
                                                        <a href="https://repo.triara.co/repositorio/clients.php?page=34" data-page="last"><span aria-hidden="true">&raquo;</span></a>
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
                </div>

            </div> <!-- row -->
        </div> <!-- container-fluid -->

        <footer>
            <div id="footer">
                Claro Colombia </div>
        </footer>

        <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('includes/js/jquery.validations.js')}}"></script>
        <script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
        <script src="{{asset('includes/js/jen/jen.js')}}"></script>
        <script src="{{asset('includes/js/js.cookie.js')}}"></script>
        <script src="{{asset('includes/js/main.js')}}"></script>
        <script src="{{asset('includes/js/js.functions.php')}}"></script>
        <script src="{{asset('includes/js/footable/footable.min.js')}}"></script>
    </div> <!-- main_content -->
    </div> <!-- container-custom -->

</body>

</html>