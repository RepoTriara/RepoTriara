<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administraci&oacute;n de usuarios &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
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

<body class="users logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">



        <div class="main_content">
        @include('layouts.app')

            <div class="container-fluid">

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Administración de usuarios</h2>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-12">

                        <div class="form_actions_left">
                            <div class="form_actions_limit_results">
                                <form action="users.php" name="form_search" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search" value="" class="txtfield form_actions_search_box form-control" />
                                    </div>
                                    <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
                                </form>

                                <form action="users.php" name="users_filters" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <select name="role" id="role" class="txtfield form-control">
                                            <option value="all">Todos los roles</option>
                                            <option value="10">Administrador de Accesos</option>
                                            <option value="9">Administrador del sistema</option>
                                            <option value="8">Usuarios del sistema</option>
                                            <option value="7">Cargador</option>
                                        </select>
                                    </div>

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

                        <form action="users.php" name="users_list" method="get" class="form-inline">
                            <div class="form_actions_right">
                                <div class="form_actions">
                                    <div class="form_actions_submit">
                                        <div class="form-group group_float">
                                            <label class="control-label hidden-xs hidden-sm"><i class="glyphicon glyphicon-check"></i> Acciones seleccionadas:</label>
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
                                <p>Encontró: <span>245 usuarios</span></p>
                            </div>

                            <div class="clear"></div>

                            <table id="users_tbl" class="footable table">
                                <thead>
                                    <tr>
                                        <th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all" value="0" /></th>
                                        <th class="active footable-sorted-desc"><a href="https://repo.triara.co/repositorio/users.php?orderby=name&order=desc">Nombre completo</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone"><a href="https://repo.triara.co/repositorio/users.php?orderby=user&order=desc">Ingresar nombre de usuario</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone"><a href="https://repo.triara.co/repositorio/users.php?orderby=email&order=desc">E-Mail</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone"><a href="https://repo.triara.co/repositorio/users.php?orderby=level&order=desc">Rol</a><span class="footable-sort-indicator"></span></th>
                                        <th><a href="https://repo.triara.co/repositorio/users.php?orderby=active&order=desc">Estado</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone"><a href="https://repo.triara.co/repositorio/users.php?orderby=max_file_size&order=desc">Max. tamaño permitido</a><span class="footable-sort-indicator"></span></th>
                                        <th class="active footable-sorted-desc" data-hide="phone,tablet"><a href="https://repo.triara.co/repositorio/users.php?orderby=timestamp&order=desc">Adicionado</a><span class="footable-sort-indicator"></span></th>
                                        <th data-hide="phone">Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table_row">
                                        <td>
                                        </td>
                                        <td>
                                            Administrador CMS</td>
                                        <td>
                                            sharemngr</td>
                                        <td>
                                            smanager.co@claro.com.co</td>
                                        <td>
                                            Administrador de Accesos</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2019/05/13</td>
                                        <td>
                                            <a href="users-edit.php?id=1" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="154" />
                                        </td>
                                        <td>
                                            Adriana Fernanda Amarillo Rojas</td>
                                        <td>
                                            ICF1491A</td>
                                        <td>
                                            adriana.amarillor@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/02/18</td>
                                        <td>
                                            <a href="users-edit.php?id=154" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="139" />
                                        </td>
                                        <td>
                                            Adriana Janeth Avendano Perez</td>
                                        <td>
                                            ECM2198R</td>
                                        <td>
                                            adriana.avendanop.ext@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/02/18</td>
                                        <td>
                                            <a href="users-edit.php?id=139" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="268" />
                                        </td>
                                        <td>
                                            ALBERT ALFREDO ROMERO GOMEZ </td>
                                        <td>
                                            ECM4970C</td>
                                        <td>
                                            albert.romero.ext@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/03/04</td>
                                        <td>
                                            <a href="users-edit.php?id=268" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="357" />
                                        </td>
                                        <td>
                                            Alexander Gomez Manotas</td>
                                        <td>
                                            ECF7383A</td>
                                        <td>
                                            gomezalem@globalhitss.com</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/08/27</td>
                                        <td>
                                            <a href="users-edit.php?id=357" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="602" />
                                        </td>
                                        <td>
                                            Anderson Adrian Martinez Mateus</td>
                                        <td>
                                            45997392</td>
                                        <td>
                                            Anderson.Martinez.Ext@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2024/04/29</td>
                                        <td>
                                            <a href="users-edit.php?id=602" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="359" />
                                        </td>
                                        <td>
                                            Andrea Carolina Amorocho Ortega</td>
                                        <td>
                                            ECM9944E</td>
                                        <td>
                                            andrea.amorochoo.ext@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/08/27</td>
                                        <td>
                                            <a href="users-edit.php?id=359" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="365" />
                                        </td>
                                        <td>
                                            Andrea Lorena Andrade Bautista</td>
                                        <td>
                                            ICF7428A</td>
                                        <td>
                                            andrea.andrade@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/08/27</td>
                                        <td>
                                            <a href="users-edit.php?id=365" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="225" />
                                        </td>
                                        <td>
                                            Andres Enrique Gomez Torres</td>
                                        <td>
                                            EKJ1071A</td>
                                        <td>
                                            andres.gomez@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/02/18</td>
                                        <td>
                                            <a href="users-edit.php?id=225" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
                                        </td>
                                    </tr>
                                    <tr class="table_row_alt">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="376" />
                                        </td>
                                        <td>
                                            Andres Felipe Zapata Realpe</td>
                                        <td>
                                            ECF4676B</td>
                                        <td>
                                            andres.zapatar@claro.com.co</td>
                                        <td>
                                            Usuarios del sistema</td>
                                        <td>
                                            <span class="label label-success">Activo</span>
                                        </td>
                                        <td>
                                            Defecto</td>
                                        <td>
                                            2020/09/09</td>
                                        <td>
                                            <a href="users-edit.php?id=376" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i><span class="button_label">Editar</span></a>
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
                                                    <li><a href="https://repo.triara.co/repositorio/users.php?page=2">2</a></li>
                                                    <li><a href="https://repo.triara.co/repositorio/users.php?page=3">3</a></li>
                                                    <li><a href="https://repo.triara.co/repositorio/users.php?page=4">4</a></li>
                                                    <li class="disabled"><a href="#">...</a></li>
                                                    <li><a href="https://repo.triara.co/repositorio/users.php?page=25">25</a></li>
                                                    <li>
                                                        <a href="https://repo.triara.co/repositorio/users.php?page=2" data-page="next">&rsaquo;</a>
                                                    </li>
                                                    <li>
                                                        <a href="https://repo.triara.co/repositorio/users.php?page=25" data-page="last"><span aria-hidden="true">&raquo;</span></a>
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
