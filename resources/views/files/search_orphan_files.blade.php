<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buscar archivos huerfanos &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
    <link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
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

<body class="upload-import-orphans logged-in logged-as-admin menu_hidden backend">
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
                            <a href="{{ route('add_company') }}"><span class="submenu_label">Añadir nueva compañia</span></a>
                        </li>
                        <li class="">
                            <a href="{{ route('manage_company')}} "><span class="submenu_label">Administrar Compañias</span></a>
                        </li>
                        <li class="divider"></li>

                    </ul>
                </li>
                <li class="separator"></li>
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
                            <a href="https://www.projectsend.org/download/13240/?tmstv=1733947130" class="btn btn-default btn-xs" target="_blank">Descarga</a> <a href="https://www.projectsend.org/change-log-detail/projectsend-r1720/" target="_blank" class="btn btn-default btn-xs">Changelog</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Buscar archivos huerfanos</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#upload_by_ftp").submit(function() {
                                var checks = $("td>input:checkbox").serializeArray();

                                if (checks.length == 0) {
                                    alert('Favor seleccione al menos un archivo para proceder.');
                                    return false;
                                }
                            });

                            /**
                             * Only select the current file when clicking an "edit" button
                             */
                            $('.btn-edit-file').click(function(e) {
                                $('#select_all').prop('checked', false);
                                $('td .select_file_checkbox').prop('checked', false);
                                $(this).parents('tr').find('td .select_file_checkbox').prop('checked', true);
                                $('#upload-continue').click();
                            });

                        });
                    </script>
                    <div class="alert alert-warning">Esta lista muestra unicamente los archivos permitidos según sus permisos. Si el tipo de archivo que necesita agregar, no está listado aquí, agregue la extensión en "Extensiones de archivo permitidas" en la página de opciones.</div>
                    <div class="col-xs-12">
                        <div class="form_actions_limit_results">
                            <form action="upload-import-orphans.php" name="form_search" method="get" class="form-inline">
                                <div class="form-group group_float">
                                    <input type="text" name="search" id="search" value="" class="txtfield form_actions_search_box form-control" />
                                </div>
                                <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
                            </form>
                        </div>

                        <div class="form_actions_count">
                            <p class="form_count_total">Mostrando: <span>7 Archivos</span></p>
                        </div>


                        <form action="upload-process-form.php" name="upload_by_ftp" id="upload_by_ftp" method="post" enctype="multipart/form-data">
                            <table id="add_files_from_ftp" class="footable table" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th class="td_checkbox" data-sortable="false"><input type="checkbox" name="select_all" id="select_all" value="0" /></th>
                                        <th data-sort-initial="true">Nombre del archivo</th>
                                        <th data-type="numeric" data-hide="phone">Tamaño del archivo</th>
                                        <th data-type="numeric" data-hide="phone">Ultima modificación</th>
                                        <th>Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-etb.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-etb.pdf</td>
                                        <td data-value="375028">
                                            366.24 KB</td>
                                        <td data-value="1733498843">
                                            2024/12/06</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-fiduprevisora.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-fiduprevisora.pdf</td>
                                        <td data-value="656810">
                                            641.42 KB</td>
                                        <td data-value="1733868502">
                                            2024/12/10</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-kyndryl-ibm.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-kyndryl-ibm.pdf</td>
                                        <td data-value="391580">
                                            382.4 KB</td>
                                        <td data-value="1733506941">
                                            2024/12/06</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-processa.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-processa.pdf</td>
                                        <td data-value="603864">
                                            589.71 KB</td>
                                        <td data-value="1733507137">
                                            2024/12/06</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-servicios-de-activos-especiales-sae.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-servicios-de-activos-especiales-sae.pdf</td>
                                        <td data-value="649152">
                                            633.94 KB</td>
                                        <td data-value="1733869021">
                                            2024/12/10</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-telefonica.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-telefonica.pdf</td>
                                        <td data-value="358575">
                                            350.17 KB</td>
                                        <td data-value="1733507829">
                                            2024/12/06</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" name="add[]" class="batch_checkbox select_file_checkbox" value="informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-zenlayer.pdf" />
                                        </td>
                                        <td>
                                            informe-mensual-reportes-de-carga-y-temperatura-noviembre-2024-zenlayer.pdf</td>
                                        <td data-value="675650">
                                            659.81 KB</td>
                                        <td data-value="1733869373">
                                            2024/12/10</td>
                                        <td>
                                            <button type="button" name="file_edit" class="btn btn-primary btn-sm btn-edit-file"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav aria-label="Resultados de Navegación">
                                <div class="pagination_wrapper text-center">
                                    <ul class="pagination hide-if-no-paging"></ul>
                                </div>
                            </nav>
                            <div class="alert alert-info">Tenga en cuenta que los archivos seran renombrados, sí contienen caracteres invalidos.</div>
                            <div class="after_form_buttons">
                                <button type="submit" class="btn btn-wide btn-primary" id="upload-continue">Continuar</button>
                            </div>
                        </form>
                    </div>

                </div> <!-- row -->
            </div> <!-- container-fluid -->

            <footer>
                <div id="footer">
                    Claro Colombia </div>
            </footer>
            <script src="{{asset('includes/js/footable/footable.all.min.js')}}"></script>
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