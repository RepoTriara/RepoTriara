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
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
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
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

<div class="col-xs-12">

	<div class="form_actions_left">
        <div class="form_actions_limit_results">
            <!-- Formulario de búsqueda -->
            <form action="{{ route('system_users.index') }}" method="get" class="form-inline">
                <div class="form-group group_float">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="txtfield form_actions_search_box form-control" />
                </div>
                <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">Búsqueda</button>
            </form>

            <!-- Formulario de filtros (roles y estado) -->
            <form action="{{ route('system_users.index') }}" method="get" class="form-inline">
                <div class="form-group group_float">
                    <select name="role" id="role" class="txtfield form-control">
                        <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Todos los roles</option>
                        <option value="10" {{ request('role') == '10' ? 'selected' : '' }}>Administrador de Accesos</option>
                        <option value="8" {{ request('role') == '8' ? 'selected' : '' }}>Usuarios del sistema</option>
                    </select>
                </div>

                <div class="form-group group_float">
                    <select name="active" id="active" class="txtfield form-control">
                        <option value="2" {{ request('active') == '2' ? 'selected' : '' }}>Todos los estados</option>
                        <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" id="btn_proceed_filter_clients" class="btn btn-sm btn-default">Filtrar</button>
            </form>
        </div>
    </div>

	<form action="{{ route('system_users.bulk_action') }}" method="post" class="form-inline">
        @csrf
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
            <p>
                <strong>Encontró:</strong> {{ $filteredUsersCount }}
                {{ Str::plural('usuario', $filteredUsersCount) }} de un total de {{ $totalUsers }}
            </p>
        </div>

		<div class="clear"></div>

		<table id="users_tbl" class="footable table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" /></th>
                    <th class="{{ request('orderby') === 'name' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'name', 'order' => request('orderby') === 'name' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            Nombre Completo
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th class="{{ request('orderby') === 'user' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'user', 'order' => request('orderby') === 'user' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            Ingresar nombre de usuario
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th class="{{ request('orderby') === 'email' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'email', 'order' => request('orderby') === 'email' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            E-mail
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th class="{{ request('orderby') === 'level' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'level', 'order' => request('orderby') === 'level' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            Rol
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th class="{{ request('orderby') === 'active' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'active', 'order' => request('orderby') === 'active' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            Estado
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th class="{{ request('orderby') === 'max_file_size' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'max_file_size', 'order' => request('orderby') === 'max_file_size' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            Max. tamaño permitido
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th class="{{ request('orderby') === 'timestamp' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}" data-hide="phone,tablet">
                        <a href="{{ route('system_users.index', ['orderby' => 'timestamp', 'order' => request('orderby') === 'timestamp' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                            Adicionado
                        </a>
                        <span class="footable-sort-indicator"></span>
                    </th>
                    <th>Comportamiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" name="batch[]" value="{{ $user->id }}" />
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->user }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->level == 10 ? 'Administrador De Accesos' : 'Usuario del sistema' }}
                        </td>
                        <td>
                            <span class="label {{ $user->active ? 'label-success' : 'label-danger' }}">
                                {{ $user->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            @if($user->max_file_size == 0)
                                Defecto
                            @else
                                {{ $user->max_file_size }} MB
                            @endif
                        </td>
                        <td>
                            {{ $user->timestamp ? \Carbon\Carbon::parse($user->timestamp)->format('Y/m/d') : 'No disponible' }}
                        </td>
                        <td>
                            <a href="{{ route('system_users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-pencil"></i>
                                <span class="button_label">Editar</span>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
</table>
<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center">
										<nav aria-label="Resultados de Navegación">
											<div class="pagination_wrapper text-center">
                                                {{ $users->links('pagination::bootstrap-4') }}
                                            </div>
								</nav>

										</div>
							</div>
						</div>	</form>
</div>

					</div> <!-- row -->
				</div> <!-- container-fluid -->

					<footer>
		<div id="footer">
			Claro Colombia		</div>
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
                document.getElementById('select_all').addEventListener('click', function() {
                    // Obtener el estado del checkbox principal
                    var isChecked = this.checked;

                    // Seleccionar todos los checkboxes que están en el grupo 'batch[]'
                    var checkboxes = document.querySelectorAll('input[name="batch[]"]');

                    // Iterar sobre todos los checkboxes y actualizarlos con el mismo estado
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = isChecked;  // Establecer el mismo estado de 'checked'
                    });
                });
            </script>


			</div> <!-- main_content -->
		</div> <!-- container-custom -->

	</body>
</html>
