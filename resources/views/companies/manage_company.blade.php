<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administraci&oacute;n de Compañías &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico')}}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png')}}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js')}}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/footable/css/footable.core.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/footable.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="groups logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')
            <div class="container-fluid"></div>
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>{{ $pageTitle ?? 'Administración de compañías' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_actions_left">
                <div class="form_actions_limit_results">
                    <form action="{{ route('manage_company') }}" method="GET" class="form-inline">
                        <!-- Campo oculto para mantener el filtro del cliente -->
                        @if (request()->has('member'))
                            <input type="hidden" name="member" value="{{ request('member') }}">
                        @endif

                        <div class="form-group group_float">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="form-control" placeholder="Buscar compañía" />
                        </div>
                        <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-primary">Búsqueda</button>
                    </form>
                </div>
            </div>
            <form id="bulkActionForm" action="{{ route('groups.bulk_action') }}" method="post">
                @csrf
                <div class="form_actions_right">
                    <div class="form_actions">
                        <div class="form_actions_submit" style="display: flex; align-items: center;">
                            <label class="control-label hidden-xs hidden-sm" style="margin-right: 10px;">
                                <i class="glyphicon glyphicon-check"></i> Acciones de grupo seleccionadas:
                            </label>
                            <select name="action" id="do_action" class="txtfield form-control"
                                style="width: auto; margin-right: 10px;">
                                <option value="none">Seleccione la acción</option>
                                <option value="delete">Eliminar</option>
                            </select>
                            <button type="submit" id="do_action_button" class="btn btn-sm btn-primary">Proceder</button>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_actions_count">
                    <p class="form_count_total">Total de Compañías: <span>{{ $groups->total() }}</span></p>
                </div>
                <div class="clear"></div>
                <table id="groups_tbl" class="footable table">
                    <thead>
                        <tr>
                            <th class="td_checkbox"><input type="checkbox" id="select_all"></th>
                            <th class="{{ request('sort') === 'name' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                data-hide="phone,tablet">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Nombre de la compañía
                                    <i
                                        class="fa fa-sort{{ request('sort') === 'name' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th class="{{ request('sort') === 'description' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                data-hide="phone,tablet">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'description', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Descripción
                                    <i
                                        class="fa fa-sort{{ request('sort') === 'description' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>Miembros</th>
                            <th>Archivos</th>
                            <th style="text-align: center; width: 110px;"
                                class="{{ request('sort') === 'created_by' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                data-hide="phone,tablet">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_by', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                    style="display: inline-flex; align-items: center; justify-content: center; gap: 5px;">
                                    Creado por
                                    <i
                                        class="fa fa-sort{{ request('sort') === 'created_by' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th class="{{ request('sort') === 'timestamp' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                data-hide="phone,tablet">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'timestamp', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Adicionado
                                    <i
                                        class="fa fa-sort{{ request('sort') === 'timestamp' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                </a>
                            </th>
                            <th>Ver</th>
                            <th>Comportamiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td><input type="checkbox" name="batch[]" value="{{ $group->id }}"></td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->description ?? 'N/A' }}</td>
                                <td>{{ $group->members_count }}</td>
                                <td>{{ $group->file_relations_count ?? 0 }}</td>
                                <td>{{ $group->created_by }}</td>
                                <td>{{ $group->timestamp ?? 'N/A' }}</td>
                                <td>
                                    @if ($group->file_relations_count > 0)
                                        <a href="{{ route('file_manager', ['group_id' => $group->id]) }}"
                                            class="btn btn-primary btn-sm">Archivos</a>
                                    @else
                                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm disabled"
                                            title="No hay archivos">Archivos</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
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
                            <input type="number" class="form-control" style="width: auto;" name="page" id="go_to_page"
                                value="{{ $groups->currentPage() }}" min="1" max="{{ $groups->lastPage() }}" />
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
    <footer>
        <div id="footer">
            Claro Colombia
        </div>
    </footer>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
    <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
    <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
    <script src="{{ asset('includes/js/main.js') }}"></script>
    <script src="{{ asset('includes/js/js.functions.js') }}"></script>
    <script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Agregar estilos dinámicamente
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
        // Función para mostrar mensaje cuando no hay resultados de búsqueda
        function showNoResultsMessage(message) {
            Swal.fire({
                icon: 'info',
                title: 'Búsqueda sin resultados',
                text: message,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#2778c4',
                customClass: {
                    icon: 'custom-search-icon'
                }
            });
        }
        document.getElementById('select_all').addEventListener('click', function () {
            let isChecked = this.checked;
            let checkboxes = document.querySelectorAll('input[name="batch[]"]');

            checkboxes.forEach(function (checkbox) {
                checkbox.checked = isChecked;
            });
        });
        // Mostrar mensaje si no hay resultados en la búsqueda de grupos (compañías)
        @if(request('search') && $groups->isEmpty())
            showNoResultsMessage('No se encontraron compañías que coincidan con: "{{ request('search') }}"');
        @endif



        function goToPage() {
            const pageInput = document.getElementById('go_to_page');
            const page = parseInt(pageInput.value);
            const lastPage = parseInt(
                "{{ $groups instanceof \Illuminate\Pagination\LengthAwarePaginator ? $groups->lastPage() : 1 }}");

            if (isNaN(page) || page < 1 || page > lastPage) {
                Swal.fire({
                    title: 'Página inválida',
                    text: `Por favor, ingresa un número de página entre 1 y ${lastPage}.`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2778c4'
                });
                pageInput.value =
                    "{{ $groups instanceof \Illuminate\Pagination\LengthAwarePaginator ? $groups->currentPage() : 1 }}";
                return;
            }

            if (page) {
                window.location.href = `?page=${page}`;
            }
        }

        $(document).ready(function () {
            $('#urlModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var url = button.data('url'); // Extraer la URL del atributo data-url

                // Depuración: verifica que la URL esté correctamente asignada
                console.log('URL enviada al modal:', url);

                var modal = $(this);
                modal.find('#publicUrl').val(url); // Asignar la URL al textarea
            });
        });

        document.getElementById('bulkActionForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let action = document.getElementById('do_action').value;
            let selectedGroups = document.querySelectorAll('input[name="batch[]"]:checked');

            if (action === 'delete' && selectedGroups.length > 0) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Seleccione al menos un grupo para eliminar.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });

        @if(session('success'))
            Swal.fire({
                title: 'Éxito',
                text: '{{ session('
                success ') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500 // Opcional: cierra automáticamente el mensaje después de 1.5 segundos
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error',
                text: '{{ session('
                error ') }}',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        @endif

    </script>
    <script>document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('go_to_page_groups').addEventListener('click', function () {
                const pageInput = document.getElementById('page_number_groups');
                const page = parseInt(pageInput.value);
                const lastPage = parseInt("{{ $groups instanceof \Illuminate\Pagination\LengthAwarePaginator ? $groups->lastPage() : 1 }}");

                if (isNaN(page) || page < 1 || page > lastPage) {
                    Swal.fire({
                        title: 'Página inválida',
                        text: `Por favor, ingresa un número de página entre 1 y ${lastPage}.`,
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2778c4'
                    });
                    pageInput.value = "{{ $groups->currentPage() }}";
                    return;
                }

                const url = new URL(window.location.href);
                url.searchParams.set('page', page);

                // Mantener parámetros de búsqueda
                const searchInput = document.getElementById('search_groups');
                if (searchInput && searchInput.value.trim() !== '') {
                    url.searchParams.set('search', searchInput.value.trim());
                }

                window.location.href = url.toString();
            });

            // Mantener los parámetros de búsqueda en la navegación de paginación
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const url = new URL(this.href);

                    const searchInput = document.getElementById('search_groups');
                    if (searchInput && searchInput.value.trim() !== '') {
                        url.searchParams.set('search', searchInput.value.trim());
                    }

                    window.location.href = url.toString();
                });
            });
        });
    </script>
    

    <!-- Modal para mostrar la URL pública -->
    <div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="urlModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="urlModalLabel">URL pública</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Click para seleccionar y copiar</p>
                    <textarea id="publicUrl" class="form-control" readonly></textarea>
                    <p class="mt-3">Envíe esta URL a alguien para ver los contenidos permitidos del grupo acorde con
                        su configuración de privacidad.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <p>Favor espere mientras su descarga está lista.</p>
                    <p>Esta operación podría tomar algunos minutos, dependiendo del tamaño de los archivos.</p>
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>