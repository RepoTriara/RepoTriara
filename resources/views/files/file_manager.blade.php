<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar Archivos &raquo; Repositorio</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="https://repo.triara.co/repositorio/img/favicon/favicon-32.png"
        sizes="32x32">
    <link rel="apple-touch-icon" href="https://repo.triara.co/repositorio/img/favicon/favicon-152.png" sizes="152x152">
    <script type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/jquery.1.12.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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

<body class="manage-files logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>{{ isset($pageTitle) ? $pageTitle : 'Administrar archivos' }}</h2>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12">
                        <div class="form_actions_left">
                            <div class="form_actions_limit_results">
                                <!-- Formulario de búsqueda -->
                                <!-- Formulario de búsqueda unificado -->
                                <form action="{{ route('file_manager') }}" method="GET" class="form-inline">
                                    <!-- Campos ocultos para mantener los filtros activos -->
                                    @if (request()->has('client_id'))
                                        <input type="hidden" name="client_id" value="{{ request('client_id') }}">
                                    @endif

                                    @if (request()->has('group_id'))
                                        <input type="hidden" name="group_id" value="{{ request('group_id') }}">
                                    @endif

                                    @if (request()->has('category_id'))
                                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    @endif

                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search"
                                            placeholder="Buscar archivos{{ isset($entityType) ? '  ' . $entityType : '' }}"
                                            value="{{ request('search') }}" class="form-control">
                                    </div>
                                    <button type="submit" id="btn_proceed_search"
                                        class="btn btn-sm btn-primary">Búsqueda</button>
                                </form>

                                @if (isset($group))
                                    <!-- Filtro por estado del archivo para el grupo -->
                                @elseif (request()->has('category_id'))
                                    <!-- Filtrado por categoría -> solo se muestra el campo de estado -->
                                    <form action="{{ route('file_manager') }}" method="GET"
                                        class="form-inline form_filters m3-4">
                                        @if (request()->has('client_id'))
                                            <input type="hidden" name="client_id" value="{{ request('client_id') }}">
                                        @endif
                                        @if (request()->has('group_id'))
                                            <input type="hidden" name="group_id" value="{{ request('group_id') }}">
                                        @endif
                                        @if (request()->has('category_id'))
                                            <input type="hidden" name="category_id"
                                                value="{{ request('category_id') }}">
                                        @endif

                                        <div class="form-group ">
                                            <select name="hidden" id="hidden" class="txtfield form-control">
                                                <option value="2"
                                                    {{ request('hidden') == '2' ? 'selected' : '' }}>Todos los estados
                                                </option>
                                                <option value="0"
                                                    {{ request('hidden') == '0' ? 'selected' : '' }}>Visible</option>
                                                <option value="1"
                                                    {{ request('hidden') == '1' ? 'selected' : '' }}>Oculto</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="btn_proceed_filter_clients"
                                            class="btn btn-sm btn-primary">Filtrar</button>
                                    </form>
                                @else
                                    <!-- Filtro normal: se muestran ambos campos, excepto el de cargador cuando se filtra por cliente o grupo -->
                                    <form action="{{ route('file_manager') }}" method="GET"
                                        class="form-inline form_filters">
                                        @if (request()->has('client_id'))
                                            <input type="hidden" name="client_id" value="{{ request('client_id') }}">
                                        @endif
                                        @if (request()->has('group_id'))
                                            <input type="hidden" name="group_id" value="{{ request('group_id') }}">
                                        @endif

                                        @if (!request()->has('client_id') && !request()->has('group_id'))
                                            <div class="form-group group_float">
                                                <select name="uploader" id="uploader" class="txtfield form-control">
                                                    <option value="">Todos los cargadores</option>
                                                    @foreach ($uploaders as $uploader)
                                                        <option value="{{ $uploader }}"
                                                            {{ request('uploader') == $uploader ? 'selected' : '' }}>
                                                            {{ $uploader }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button style="margin-right: 10px; type="submit"
                                                id="btn_proceed_filter_clients"
                                                class="btn btn-sm btn-primary">Filtrar</button>
                                        @endif

                                        <div class="form-group group_float">
                                            <select name="hidden" id="hidden" class="txtfield form-control">
                                                <option value="2"
                                                    {{ request('hidden') == '2' ? 'selected' : '' }}>Todos los estados
                                                </option>
                                                <option value="0"
                                                    {{ request('hidden') == '0' ? 'selected' : '' }}>Visible</option>
                                                <option value="1"
                                                    {{ request('hidden') == '1' ? 'selected' : '' }}>Oculto</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="btn_proceed_filter_clients"
                                            class="btn btn-sm btn-primary">Filtrar</button>
                                    </form>
                                @endif

                            </div>
                        </div>

                        <form action="{{ route('files.bulk-action') }}" method="POST" id="bulkActionForm">

                            @csrf
                            <div class="form_actions_right">
                                <div class="form_actions">
                                    <div class="form_actions_submit" style="display: flex; align-items: center;">

                                        <select name="action" id="action" class="txtfield form-control">
                                            <option value="none">Seleccione la acción</option>
                                            <option value="delete">Eliminar</option>
                                            <option value="zip">Descarga comprimida</option>
                                        </select>
                                        <button type="submit" id="do_action"
                                            class="btn btn-sm btn-primary">Proceder</button>
                                    </div>
                                </div>
                            </div>


                            <div class="clear"></div>

                            <div class="form_actions_count">
                                @if (request()->has('client_id'))
                                    <p class="form_count_total">Total de archivos del cliente:
                                        <span>{{ $filteredTotal }}</span>
                                    </p>
                                @elseif (request()->has('group_id'))
                                    <p class="form_count_total">Total de archivos en el grupo:
                                        <span>{{ $filteredTotal }}</span>
                                    </p>
                                @elseif (request()->has('category_id'))
                                    <p class="form_count_total">Total de archivos en la categoría:
                                        <span>{{ $filteredTotal }}</span>
                                    </p>
                                @elseif(request()->has('search') || request()->has('uploader'))
                                    <p class="form_count_total">Resultados filtrados:
                                        <span>{{ $filteredTotal }}</span>
                                    </p>
                                @else
                                    <p class="form_count_total">Total de archivos:
                                        <span>{{ $totalFiles }}</span>
                                    </p>
                                @endif
                            </div>


                            <div class="clear"></div>

                            <table id="files_tbl" class="footable table">
                                <thead>
                                    <tr>
                                        <th class="td_checkbox"><input type="checkbox" id="select_all"></th>
                                        <th
                                            class="{{ request('sort') === 'timestamp' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'timestamp', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="{{ request('sort') === 'timestamp' ? 'active-sort' : '' }}">
                                                Adicionado
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'timestamp' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Tipo</th>
                                        <th
                                            class="{{ request('sort') === 'filename' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'filename', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="{{ request('sort') === 'filename' ? 'active-sort' : '' }}">
                                                Título
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'filename' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Tamaño</th>
                                        <th
                                            class="{{ request('sort') === 'uploader' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'uploader', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="{{ request('sort') === 'uploader' ? 'active-sort' : '' }}">
                                                Cargador
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'uploader' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Asignado</th>
                                        <th
                                            class="{{ request('sort') === 'public_allow' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'public_allow', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="{{ request('sort') === 'public_allow' ? 'active-sort' : '' }}">
                                                Permisos públicos
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'public_allow' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Estado</th>
                                        <th>Expira</th>
                                        <th
                                            class="{{ request('sort') === 'download_count' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'download_count', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="{{ request('sort') === 'download_count' ? 'active-sort' : '' }}">
                                                Total descargas
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'download_count' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <!-- Nueva columna para el estado -->

                                        <th>Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($files as $file)
                                        <tr>
                                            <td><input type="checkbox" name="batch[]" value="{{ $file->id }}">
                                            </td>
                                            <td>{{ $file->timestamp ? $file->timestamp->format('Y/m/d') : 'N/A' }}</td>
                                            <td>{{ pathinfo($file->original_url, PATHINFO_EXTENSION) }}</td>
                                            <td><a
                                                    href="{{ route('file.directDownload', ['id' => $file->id]) }}">{{ $file->filename }}</a>
                                            </td>
                                            <td>{{ $file->size }}</td>
                                            <td>{{ $file->uploader ?? 'Desconocido' }}</td>
                                            <td>
                                                @if ($file->fileRelations->isNotEmpty())
                                                    <span class="label label-success">Si</span>
                                                @else
                                                    <span class="label label-danger">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($file->public_allow)
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal" data-target="#urlModal"
                                                        data-url="{{ route('file.showDownload', ['id' => $file->id, 'token' => $file->public_token]) }}">
                                                        Descarga
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        disabled>Privado</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($file->fileRelations->isNotEmpty())
                                                    @if ($file->fileRelations->first()->hidden == 1)
                                                        <span class="label label-danger">Oculto</span>
                                                    @else
                                                        <span class="label label-success">Visible</span>
                                                    @endif
                                                @else
                                                    <span class="label label-default">No asignado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($file->expires && $file->expiry_date)
                                                    @php
                                                        $expiryDate = \Carbon\Carbon::parse($file->expiry_date);
                                                    @endphp
                                                    @if ($expiryDate->isPast())
                                                        <span class="label label-danger"
                                                            style="display: block; text-align: center;">
                                                            Expiró en<br>
                                                            <strong>{{ $expiryDate->format('Y/m/d') }}</strong>
                                                        </span>
                                                    @else
                                                        <span class="btn btn-info disabled btn-sm"
                                                            style="display: block; text-align: center;">
                                                            Expira en<br>
                                                            <strong>{{ $expiryDate->format('Y/m/d') }}</strong>
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="btn btn-success disabled btn-sm">No expira</span>
                                                @endif
                                            </td>
                                            <td>{{ $file->downloads->count() }} veces</td>
                                            <td><a href="{{ route('files.edit', $file->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13">No hay archivos subidos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>

                        <div class="container-fluid text-center">
                            <nav aria-label="Resultados de Navegación">
                                <div class="pagination_wrapper d-inline-block">
                                    {{ $files->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </nav>
                            <div class="d-inline-block" style="margin-top: 10px;">
                                <form class="form-inline d-inline-block" id="go_to_page_form_files">
                                    <div class="form-group">
                                        <label class="control-label hidden-xs hidden-sm">Vaya a:</label>
                                        <input type="number" class="form-control" style="width: 4em !important;"
                                            name="page" id="go_to_page_files"
                                            value="{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->currentPage() : 1 }}"
                                            min="1"
                                            max="{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->lastPage() : 1 }}" />
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" onclick="goToPageFiles()">
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
        </div>


        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
        <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
        <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
        <script src="{{ asset('includes/js/main.js') }}"></script>
        <script src="{{ asset('includes/js/js.functions.php') }}"></script>
        <script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>

    </div>

    <script>
        document.getElementById('select_all').addEventListener('click', function() {
            let isChecked = this.checked;
            let checkboxes = document.querySelectorAll('input[name="batch[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });



        $(document).ready(function() {
            $('#urlModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);
                modal.find('#publicUrl').val(url);
                modal.find('#publicUrl').click(function() {
                    $(this).select();
                });
            });
        });

        function goToPageFiles() {
            const page = document.getElementById('go_to_page_files').value;
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
    </script>
    <script>
        document.getElementById('select_all').addEventListener('click', function() {
            let isChecked = this.checked;
            let checkboxes = document.querySelectorAll('input[name="batch[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });



        $(document).ready(function() {
            $('#urlModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);
                modal.find('#publicUrl').val(url);
                modal.find('#publicUrl').click(function() {
                    $(this).select();
                });
            });
        });

        function goToPageFiles() {
            const pageInput = document.getElementById('go_to_page_files');
            const page = parseInt(pageInput.value);
            const lastPage = parseInt(
                "{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->lastPage() : 1 }}"
            ); // Assuming $files is relevant here

            if (isNaN(page) || page < 1 || page > lastPage) {
                Swal.fire({
                    title: 'Página inválida',
                    text: `Por favor, ingresa un número de página entre 1 y ${lastPage}.`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2778c4'
                });
                pageInput.value =
                    "{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->currentPage() : 1 }}"; // Optionally reset the input
                return;
            }

            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }

        function goToPageClientes() {
            const form = document.getElementById('go_to_page_form_clientes');
            const page = document.getElementById('go_to_page_clientes').value;
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadForm = document.getElementById('bulkActionForm');
            const delay = 3000; // Tiempo de espera (en milisegundos)

            // Mostrar mensaje si no hay resultados en la búsqueda
            @if (request()->has('search') && $files->isEmpty())
                Swal.fire({
                    title: 'Búsqueda sin resultados',
                    text: 'No se encontraron archivos que coincidan con "{{ request('search') }}"' +
                        '@if (request()->has('client_id')) para este cliente' +
                        '@elseif (request()->has('group_id')) en esta compañía' +
                        '@elseif (request()->has('category_id')) en esta categoría' +
                        '@endif',
                    icon: 'info',
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        icon: 'custom-search-icon'
                    }
                });

                // Añadir estilos al icono
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

            downloadForm.onsubmit = function(e) {
                const action = document.getElementById('action').value;
                const selectedFiles = document.querySelectorAll('input[name="batch[]"]:checked');

                if (action === 'none' || selectedFiles.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'No se ha seleccionado ningún archivo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                if (action === 'delete') {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: `Está a punto de eliminar ${selectedFiles.length} archivos. Esta acción no se puede deshacer.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            downloadForm.submit();
                        }
                    });
                } else if (action === 'zip') {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Por favor, espera',
                        html: `
                        <p>Estamos procesando tu descarga comprimida...</p>
                        <div style="margin-top: 10px;">
                            <img src="https://i.gifer.com/ZZ5H.gif" alt="Cargando..." width="50">
                        </div>
                    `,
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        Swal.close();
                        e.target.submit();
                    }, delay);
                }
            };

            // Verificar si hay un mensaje de éxito o error desde el backend
            @if (session('success'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: '{{ session('
                                                    success ') }}',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            @elseif (session('error'))
                Swal.fire({
                    title: 'Error',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            // Funcionalidad para seleccionar todos los checkboxes
            document.getElementById('select_all').addEventListener('click', function() {
                var isChecked = this.checked;
                var checkboxes = document.querySelectorAll('input[name="file_ids[]"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
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
                    <p class="mt-3">Envíe esta URL a alguien para que descargue el archivo sin necesidad de
                        registrarse o iniciar sesión.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
