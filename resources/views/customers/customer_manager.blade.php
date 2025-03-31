<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administración de Clientes &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">

    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/footable.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/footable/css/footable.core.css') }}" />
</head>

<body class="clients logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')

            <div class="container-fluid">
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
                                <form action="{{ route('customer_manager') }}" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search"
                                            value="{{ request('search') }}" placeholder="Buscar cliente"
                                            class="form-control" />
                                    </div>
                                    <button type="submit" id="btn_proceed_search"
                                        class="btn btn-sm btn-primary">Búsqueda</button>
                                </form>

                                <form action="{{ route('customer_manager') }}" method="get" class="form-inline">
                                    <div class="form-group group_float">
                                        <select name="active" id="active" class="txtfield form-control">
                                            <option value="2" {{ request('active') == '2' ? 'selected' : '' }}>
                                                Todo los estados</option>
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

                        <form action="{{ route('customers.bulk_Action') }}" name="clients_list" method="post"
                            class="form-inline">
                            @csrf
                            <div class="form_actions_right">
                                <div class="form_actions">
                                    <div class="form_actions_submit">
                                        <div class="form-group group_float">
                                            <label class="control-label hidden-xs hidden-sm"><i
                                                    class="glyphicon glyphicon-check"></i> Acciones de cliente
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
                                @if (request()->has('search') || request()->has('category') || request()->has('client_id'))
                                    <p>
                                        Total de clientes: {{ $filteredClientesCount }}
                                    </p>
                                @else
                                    <p>
                                        Total de clientes:{{ $filteredClientesCount }}
                                    </p>
                                @endif
                            </div>

                            <table id="users_tbl" class="footable table default footable-loaded ">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all" class="footable-sort-indicator" />
                                        </th>

                                       <th class="{{ request('orderby') === 'name' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'name' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('customer_manager', ['orderby' => 'name', 'order' => (request('orderby') === 'name' && request('order') === 'asc') ? 'desc' : 'asc']) }}">Nombre Completo</a>
    <span class="footable-sort-indicator"></span>
</th>

                                        <th class="{{ request('orderby') === 'user' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'user' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('customer_manager', ['orderby' => 'user', 'order' => (request('orderby') === 'user' && request('order') === 'asc') ? 'desc' : 'asc']) }}">Usuario</a>
    <span class="footable-sort-indicator"></span>
</th>
                                        <th class="{{ request('orderby') === 'email' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'email' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('customer_manager', ['orderby' => 'email', 'order' => (request('orderby') === 'email' && request('order') === 'asc') ? 'desc' : 'asc']) }}">E-mail</a>
    <span class="footable-sort-indicator"></span>
</th>

                                        <th data-hide="phone">Cargas</th>

                                        <th data-hide="phone">Archivos Propios</th>

                                        <th data-hide="phone">Archivos Grupos</th>

                                        <th class="{{ request('orderby') === 'active' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'active' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('customer_manager', ['orderby' => 'active', 'order' => (request('orderby') === 'active' && request('order') === 'asc') ? 'desc' : 'asc']) }}">Estado</a>
    <span class="footable-sort-indicator"></span>
</th>

                                        <th data-hide="phone">Grupos Activos</th>
                                        <th data-hide="phone,tablet">Notificación</th>
                                        <th class="{{ request('orderby') === 'max_file_size' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'max_file_size' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('customer_manager', ['orderby' => 'max_file_size', 'order' => (request('orderby') === 'max_file_size' && request('order') === 'asc') ? 'desc' : 'asc']) }}">Max. tamaño</a>
    <span class="footable-sort-indicator"></span>
</th>
                                        <th class="{{ request('orderby') === 'timestamp' ? (request('order') === 'asc' ? 'footable-sorted-asc' : 'footable-sorted-desc') : '' }} footable-visible {{ request('orderby') === 'timestamp' ? 'footable-sorted-active active' : '' }}"
    data-hide="phone,tablet">
    <a href="{{ route('customer_manager', ['orderby' => 'timestamp', 'order' => (request('orderby') === 'timestamp' && request('order') === 'asc') ? 'desc' : 'asc']) }}">Adicionado</a>
    <span class="footable-sort-indicator"></span>
</th>
                                        <th>Ver</th>
                                        <th>Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clientes as $client)
                                        <tr>
                                            <td><input type="checkbox" name="batch[]" value="{{ $client->id }}" />
                                            </td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->user }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->uploads_count }}</td>
                                            <td>{{ $client->own_files_count }}</td>
                                            <td>{{ $client->group_files_count }}</td>
                                            <td><span
                                                    class="label {{ $client->active ? 'label-success' : 'label-danger' }}">{{ $client->active ? 'Activo' : 'Inactivo' }}</span>
                                            </td>
                                            <td>
                                                @if ($client->group_count > 0)
                                                    {{ $client->group_count }}
                                                @endif
                                            </td>
                                            <td>{{ $client->notification_status }}</td>
                                            <td>
                                                @if ($client->max_file_size == 0)
                                                    Defecto @else{{ $client->max_file_size }} MB
                                                @endif
                                            </td>
                                            <td>{{ $client->timestamp ? \Carbon\Carbon::parse($client->timestamp)->format('Y/m/d') : 'No disponible' }}
                                            </td>

                                            <td>
                                                @if ($client->own_files_count > 0 || $client->group_files_count > 0)
                                                    <a href="{{ route('file_manager', ['client_id' => $client->id]) }}"
                                                        class="btn btn-primary">
                                                        {{ __('Archivos') }}
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn disabled-btn"
                                                        tabindex="-1">
                                                        {{ __('Archivos') }}
                                                    </a>
                                                @endif

                                                @if ($client->group_count > 0)
                                                    <a href="{{ route('manage_company', ['member' => $client->id]) }}"
                                                        class="btn btn-primary">
                                                        {{ __('Grupos') }}
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn disabled-btn"
                                                        tabindex="-1">
                                                        {{ __('Grupos') }}
                                                    </a>
                                                @endif

                                                @if ($client->own_files_count)
                                                    <a href="{{ route('my_files', ['cliente_id' => $client->id]) }}"
                                                        class="btn btn-primary">
                                                        {{ __('Como cliente') }}
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn disabled-btn"
                                                        tabindex="-1">
                                                        {{ __('Como cliente') }}
                                                    </a>
                                                @endif

                                            </td>

                                            <td><a href="{{ route('customer_manager.edit', ['id' => $client->id]) }}"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i>
                                                    <span class="button_label">Editar</span>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13">No hay clientes registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <nav aria-label="Resultados de Navegación">
                                            <div class="pagination_wrapper text-center">
                                                {{ $clientes instanceof \Illuminate\Pagination\LengthAwarePaginator ? $clientes->links('pagination::bootstrap-4') : '' }}
                                            </div>
                                        </nav>
                                        <div style="margin-top: 50px;"></div>

                                        <div class="d-inline-block" style="margin-top: 10px;">
                                            <form class="form-inline d-inline-block" id="go_to_page_form_clientes">
                                                <div class="form-group">
                                                    <label class="control-label hidden-xs hidden-sm">Vaya a:</label>
                                                    <input type="number" class="form-control"
                                                        style="width: 4em !important;" name="page"
                                                        id="go_to_page_clientes"
                                                        value="{{ $clientes instanceof \Illuminate\Pagination\LengthAwarePaginator ? $clientes->currentPage() : 1 }}"
                                                        min="1"
                                                        max="{{ $clientes instanceof \Illuminate\Pagination\LengthAwarePaginator ? $clientes->lastPage() : 1 }}" />
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default"
                                                        onclick="goToPageClientes()">
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
                </div>
            </div>

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

    function goToPageClientes() {
        // Obtener el valor ingresado en el campo "Vaya a:"
        const pageInput = document.getElementById('go_to_page_clientes');
        const page = parseInt(pageInput.value, 10);

        // Obtener el número total de páginas disponibles
        const lastPage =
            {{ $clientes instanceof \Illuminate\Pagination\LengthAwarePaginator ? $clientes->lastPage() : 1 }};

        // Validar si la página ingresada está dentro del rango válido
        if (isNaN(page) || page < 1 || page > lastPage) {
            // Mostrar SweetAlert indicando que la página no existe
            Swal.fire({
                title: 'Página inválida',
                text: `Por favor, ingresa un número de página entre 1 y ${lastPage}.`,
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Limpiar el campo de entrada después del error
                pageInput.value = '';
            });
            return;
        }

        // Redirigir al usuario a la página seleccionada
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        window.location.href = url.toString();
    }

   // Función para mostrar mensaje cuando no hay resultados de búsqueda
    function showNoResultsMessage(searchTerm) {
        // Crear y agregar estilos personalizados para el icono
        const style = document.createElement('style');
        style.innerHTML = `
            .custom-search-icon {
                color: #facea8 !important;
                border: 2px solid #f8bb86 !important;
                border-radius: 50%;
                padding: 10px;
                background-color: #fff8ee;
                
            }
        `;
        document.head.appendChild(style);

        Swal.fire({
            title: 'Búsqueda sin resultados',
            text: `No se encontraron clientes que coincidan con: "${searchTerm}"`,
            icon: 'info',
            confirmButtonText: 'Aceptar',
            customClass: {
                icon: 'custom-search-icon'
            }
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar si hay término de búsqueda y no hay resultados
        @if(request('search') && $clientes->isEmpty())
            showNoResultsMessage('{{ request('search') }}');
        @endif

        document.querySelector('form[name="clients_list"]').addEventListener('submit', function(e) {
            var action = document.getElementById('action').value;
            var selectedClients = [];

            document.querySelectorAll('input[name="batch[]"]:checked').forEach(function(checkbox) {
                selectedClients.push(checkbox.value);
            });

            if (action === 'none') {
                e.preventDefault();
                Swal.fire({
                    title: 'Error',
                    text: 'Debes seleccionar una acción para proceder.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            if (action === 'delete' && selectedClients.length > 0) {
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
            } else if (action === 'delete' && selectedClients.length === 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error',
                    text: 'Debes seleccionar al menos un cliente para eliminar.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                    
                });
            }
        });

        @if (session('success'))
            Swal.fire({
                title: 'Éxito',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        @endif
    });
</script>

        </div> <!-- main_content -->
    </div> <!-- container-custom -->
</body>

</html>
