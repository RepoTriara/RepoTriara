<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administraci&oacute;n de usuarios &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/footable/css/footable.core.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/footable.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
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
                                <!-- Formulario de búsqueda -->
                                <form action="{{ route('system_users.index') }}" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search"
                                            value="{{ request('search') }}" placeholder="Buscar usuario"
                                            class="form-control" />
                                    </div>
                                    <button type="submit" id="btn_proceed_search"
                                        class="btn btn-sm btn-primary">Búsqueda</button>
                                </form>

                                <!-- Formulario de filtros (roles y estado) -->
                                <form action="{{ route('system_users.index') }}" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <select name="role" id="role" class="txtfield form-control">
                                            <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>
                                                Todos los roles</option>
                                            <option value="10" {{ request('role') == '10' ? 'selected' : '' }}>
                                                Administrador de Accesos</option>
                                            <option value="8" {{ request('role') == '8' ? 'selected' : '' }}>
                                                Usuarios del sistema</option>
                                        </select>
                                    </div>

                                    <div class="form-group group_float">
                                        <select name="active" id="active" class="txtfield form-control">
                                            <option value="2" {{ request('active') == '2' ? 'selected' : '' }}>
                                                Todos los estados</option>
                                            <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>
                                                Activo</option>
                                            <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>
                                                Inactivo</option>
                                        </select>
                                    </div>

                                    <button type="submit" id="btn_proceed_filter_clients"
                                        class="btn btn-sm btn-primary">Filtrar</button>
                                </form>
                            </div>
                        </div>

                        <form action="{{ route('system_users.bulk_action') }}" method="post" class="form-inline">
                            @csrf
                            <div class="form_actions_right">
                                <div class="form_actions">
                                    <div class="form_actions_submit">
                                        <div class="form-group group_float">
                                            <label class="control-label hidden-xs hidden-sm"><i
                                                    class="glyphicon glyphicon-check"></i> Acciones
                                                seleccionadas:</label>
                                            <select name="action" id="action" class="txtfield form-control">
                                                <option value="none">Seleccione la acción</option>
                                                <option value="activate">Activar</option>
                                                <option value="deactivate">Desactivar</option>
                                                <option value="delete">Eliminar</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="do_action"
                                            class="btn btn-sm btn-primary">Proceder</button>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>

                            <div class="form_actions_count">
                               @if (request()->has('client_id'))
                                    <p>
                                         Total de usuarios: {{ $filteredUsersCount }}

                                    </p>
                                @elseif (request()->has('search') || request()->has('role'))
                                    <p>
                                         Total de usuarios: {{ $filteredUsersCount }}

                                    </p>
                                @else
                                    <p>
                                        Total de usuarios: {{ $totalUsers }}

                                    </p>
                                @endif
                            </div>

                            <div class="clear"></div>

                            <table id="users_tbl" class="footable table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all" /></th>
                                       <!-- Nombre Completo -->
<th class="{{ request('orderby') === 'name' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'name' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'name', 'order' => (request('orderby') === 'name' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
        Nombre Completo
    </a>
    <span class="footable-sort-indicator"></span>
</th>

<!-- Usuario -->
<th class="{{ request('orderby') === 'user' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'user' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'user', 'order' => (request('orderby') === 'user' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
        Ingresar nombre de usuario
    </a>
    <span class="footable-sort-indicator"></span>
</th>

<!-- E-mail -->
<th class="{{ request('orderby') === 'email' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'email' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'email', 'order' => (request('orderby') === 'email' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
        E-mail
    </a>
    <span class="footable-sort-indicator"></span>
</th>

<!-- Rol -->
<th class="{{ request('orderby') === 'level' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'level' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'level', 'order' => (request('orderby') === 'level' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
        Rol
    </a>
    <span class="footable-sort-indicator"></span>
</th>

<!-- Estado -->
<th class="{{ request('orderby') === 'active' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'active' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'active', 'order' => (request('orderby') === 'active' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
        Estado
    </a>
    <span class="footable-sort-indicator"></span>
</th>

<!-- Max. tamaño -->
<th class="{{ request('orderby') === 'max_file_size' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'max_file_size' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'max_file_size', 'order' => (request('orderby') === 'max_file_size' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
        Max. tamaño permitido
    </a>
    <span class="footable-sort-indicator"></span>
</th>

<!-- Adicionado -->
<th class="{{ request('orderby') === 'timestamp' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'timestamp' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('system_users.index', ['orderby' => 'timestamp', 'order' => (request('orderby') === 'timestamp' && request('order') === 'asc') ? 'desc' : 'asc']) }}">
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
                                                <span
                                                    class="label {{ $user->active ? 'label-success' : 'label-danger' }}">
                                                    {{ $user->active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($user->max_file_size == 0)
                                                    Defecto
                                                @else
                                                    {{ $user->max_file_size }} MB
                                                @endif
                                            </td>
                                            <td>
                                                {{ $user->timestamp ? \Carbon\Carbon::parse($user->timestamp)->format('Y/m/d') : 'No disponible' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('system_users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                    <span class="button_label">Editar</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hay usuarios registrados.</td>
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
                                        <div class="d-inline-block" style="margin-top: 10px;">
                                            <form class="form-inline d-inline-block" id="go_to_page_form_users">
                                                <div class="form-group">
                                                    <label class="control-label hidden-xs hidden-sm">Vaya a:</label>
                                                    <input type="number" class="form-control"
                                                        style="width: 4em !important;" name="page"
                                                        id="go_to_page_users"
                                                        value="{{ $users instanceof \Illuminate\Pagination\LengthAwarePaginator ? $users->currentPage() : 1 }}"
                                                        min="1"
                                                        max="{{ $users instanceof \Illuminate\Pagination\LengthAwarePaginator ? $users->lastPage() : 1 }}" />
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default"
                                                        onclick="goToPageUsers()">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </button>
                                                </div>
                                            </form>
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
                    Claro Colombia
                </div>
            </footer>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
            <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
            <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
            <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
            <script src="{{ asset('includes/js/main.js') }}"></script>
            <script src="{{ asset('includes/js/js.functions.php') }}"></script>
            <script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>
            <script>
                document.getElementById('select_all').addEventListener('click', function() {
                    var isChecked = this.checked;
                    var checkboxes = document.querySelectorAll('input[name="batch[]"]');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = isChecked;
                    });
                });

               function goToPageUsers() {
    const pageInput = document.getElementById('go_to_page_users');
    const page = parseInt(pageInput.value);
    const lastPage = parseInt("{{ $users instanceof \Illuminate\Pagination\LengthAwarePaginator ? $users->lastPage() : 1 }}");

    if (isNaN(page) || page < 1 || page > lastPage) {
        Swal.fire({
            title: 'Página inválida',
            text: `Por favor, ingresa un número de página entre 1 y ${lastPage}.`,
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#2778c4'
        });
        pageInput.value = "{{ $users instanceof \Illuminate\Pagination\LengthAwarePaginator ? $users->currentPage() : 1 }}"; // Optionally reset the input
        return;
    }

    const url = new URL(window.location.href);
    url.searchParams.set('page', page);
    window.location.href = url.toString();
}
                document.addEventListener('DOMContentLoaded', function () {
                    // Mostrar mensaje si no hay resultados en la búsqueda
                    @if(request()->has('search') && $users->isEmpty())
                                Swal.fire({
                                    title: 'Búsqueda sin resultados',
                                    text: 'No se encontraron usuarios que coincidan con "{{ request('search') }}"',
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    customClass: {
                                        icon: 'custom-search-icon'
                                    }
                                });

                                // Estilo personalizado para el icono
                                const style = document.createElement('style');
                                style.innerHTML = `
                            .custom-search-icon {
                                color: #facea8 !important;
                                border: 2px solid #f8bb86 !important;
                                border-radius: 50%;
                            }
                        `;
                                document.head.appendChild(style);
                    @endif

                    document.querySelector('form[action="{{ route('system_users.bulk_action') }}"]').addEventListener('submit', function (e) {
                        var action = document.getElementById('action').value;
                        var selectedUsers = [];

                        document.querySelectorAll('input[name="batch[]"]:checked').forEach(function (checkbox) {
                            selectedUsers.push(checkbox.value);
                        });

                          if (action === 'none') {
                            e.preventDefault();
                            Swal.fire({
                                title: 'Error',
                                text: 'Debes seleccionar una acción para proceder.',
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#2778c4'

                            });
                            return;
                        }


                        if (action === 'delete' && selectedUsers.length > 0) {
                            e.preventDefault();

                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "¡No podrás revertir esta acción!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.submit();
                                }
                            });
                        } else if (action === 'delete' && selectedUsers.length === 0) {
                            e.preventDefault();
                            Swal.fire('Error', 'Debes seleccionar al menos un usuario para eliminar.', 'error');
                        }
                    });

                     @if(session('success'))
                        Swal.fire({
                            title: 'Éxito',
                            text: '{{ session('success') }}',
                            icon: 'success',
                            timer: 3000, // Se cierra automáticamente después de 3 segundos
                            showConfirmButton: false // No muestra el botón "OK"
                        });
                    @endif
                });
            </script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->
</body>

</html>
