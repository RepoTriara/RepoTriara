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
        <div class="main_content">
            @include('layouts.app')
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Administración de Grupos</h2>
                        </div>
                    </div>
                </div>

                <div class="form_actions_left">
    <div class="form_actions_limit_results">
        <form action="{{ route('manage_company') }}" method="get" class="form-inline">
            <div class="form-group group_float">
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="txtfield form_actions_search_box form-control" placeholder="Buscar grupo" />
            </div>
            <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
        </form>
    </div>
</div>


<form action="{{ route('groups.bulk_action') }}" method="post" class="form-inline">
    @csrf
    <div class="form_actions_right">
        <div class="form_actions">
            <div class="form_actions_submit">
                <div class="form-group group_float">
                    <label class="control-label hidden-xs hidden-sm">
                        <i class="glyphicon glyphicon-check"></i> Acciones de grupo seleccionadas:
                    </label>
                    <select name="action" id="action" class="txtfield form-control">
                        <option value="none">Seleccione la acción</option>
                        <option value="delete">Eliminar</option>
                    </select>
                </div>
                <button type="submit" id="do_action" class="btn btn-sm btn-default">Proceder</button>
            </div>
        </div>
    </div>
</form>


                <div class="row">
                    <div class="col-xs-12">
                        <table id="groups_tbl" class="footable table">
                            <thead>
                                <tr>
                                    <th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all" value="0" /></th>
                                    <th>Nombre del grupo</th>
                                    <th>Descripción</th>
                                    <th>Miembros</th>
                                    <th>Archivos</th>
                                    <th>Público</th>
                                    <th>Creado por</th>
                                    <th>Adicionado</th>
                                    <th>Ver</th>
                                    <th>Comportamiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $group)
                                    <tr class="{{ $loop->even ? 'table_row_alt' : 'table_row' }}">
                                        <td>
                                            <input type="checkbox" class="batch_checkbox" name="batch[]" value="{{ $group->id }}" />
                                        </td>
                                        <td>{{ $group->name }}</td>
                                        <td>{{ $group->description ?? 'N/A' }}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>
                                            @if ($group->public)
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Público</a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm disabled" title="">Privado</a>
                                            @endif
                                        </td>
                                        <td>{{ $group->created_by }}</td>
                                        <td>{{ $group->timestamp ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ url('manage-files.php?group_id=' . $group->id) }}" class="btn btn-primary btn-sm">Archivos</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('groups-edit.php?id=' . $group->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil"></i><span class="button_label">Editar</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="container-fluid text-center">
                            <nav aria-label="Resultados de Navegación">
                                <div class="pagination_wrapper d-inline-block">
                                    {{ $groups->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </nav>

                            <div class="d-inline-block" style="margin-top: 10px;">
                                <form class="form-inline d-inline-block">
                                    <div class="form-group">
                                        <label class="control-label hidden-xs hidden-sm">Vaya a:</label>
                                        <input type="number" class="form-control" style="width: auto;" name="page" id="go_to_page" value="{{ $groups->currentPage() }}" min="1" max="{{ $groups->lastPage() }}" />
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" onclick="goToPage()">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <div id="footer">
                    Claro Colombia
                </div>
            </footer>
	<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('includes/js/jquery.validations.js')}}"></script>
			<script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
			<script src="{{asset('includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			<script src="{{asset('includes/js/footable/footable.min.js')}}"></script>
            <script>
			</div> <!-- main_content -->
		</div> <!-- container-custom -->


		<script>
    function goToPage() {
        let page = document.getElementById('go_to_page').value;
        if (page) {
            window.location.href = `?page=${page}`;
        }
    }
</script>

	</body>
</html>