<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrar archivos para la compañia {{ $group->name }} &raquo; Repositorio</title>

    <link rel="shortcut icon" type="image/x-icon" href="https://repo.triara.co/repositorio/favicon.ico" />
    <link rel="icon" type="image/png" href="https://repo.triara.co/repositorio/img/favicon/favicon-32.png"
        sizes="32x32">
    <link rel="apple-touch-icon" href="https://repo.triara.co/repositorio/img/favicon/favicon-152.png" sizes="152x152">
    <script type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/jquery.1.12.4.min.js"></script>

    <!--[if lt IE 9]>
  <script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
  <script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
 <![endif]-->

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
                            <h2>Administrar archivos para el Grupo {{ $group->name }}</h2>

                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif


                <div class="row">

                    <div class="col-xs-12">
                        <div class="form_actions_left">
                            <div class="form_actions_limit_results">
                                <form action="{{ route('files.manage', $group->id) }}" method="GET"
                                    class="form-inline">
                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search"
                                            value="{{ request('search') }}"
                                            class="txtfield form_actions_search_box form-control"
                                            placeholder="Buscar archivo" />
                                    </div>
                                    <button type="submit" id="btn_proceed_search"
                                        class="btn btn-sm btn-default">Búsqueda</button>
                                </form>


                                <form action="{{ route('files.manage', $group->id) }}" method="GET"
                                    class="form-inline form_filters">
                                    <div class="form-group group_float">
                                        <select name="hidden" id="hidden" class="txtfield form-control">
                                            <option value="2" {{ request('hidden') == '2' ? 'selected' : '' }}>
                                                Todos los estados</option>
                                            <option value="0" {{ request('hidden') == '0' ? 'selected' : '' }}>
                                                Visible</option>
                                            <option value="1" {{ request('hidden') == '1' ? 'selected' : '' }}>
                                                Oculto</option>
                                        </select>
                                    </div>
                                    <button type="submit" id="btn_proceed_filter_clients"
                                        class="btn btn-sm btn-default">Filtrar</button>
                                </form>

                            </div>
                        </div>


                        <form action="{{ route('files.group-bulk-action', $group->id) }}" method="POST"
                            id="bulkActionForm">
                            @csrf
                            <div class="form_actions_right">
                                <div class="form_actions">
                                    <div class="form_actions_submit" style="display: flex; align-items: center;">
                                        <label class="control-label hidden-xs hidden-sm" style="margin-right: 10px;">
                                            <i class="glyphicon glyphicon-check"></i> Acciones de archivos
                                            seleccionados:
                                        </label>
                                        <select name="action" id="action" class="txtfield form-control"
                                            style="width: auto; margin-right: 10px;">
                                            <option value="none">Seleccione la acción</option>
                                            <option value="hide">Ocultar</option>
                                            <option value="show">Mostrar</option>
                                            <option value="unassign">Desasignar</option>
                                        </select>
                                        <button type="submit" id="do_action"
                                            class="btn btn-sm btn-default">Proceder</button>
                                    </div>
                                </div>
                            </div>

                            <div class="clear"></div>

                            <!-- Mostrar el total de archivos -->
                            <div class="form_actions_count">
                                <p class="form_count_total">Total de archivos: <span>{{ $files->total() }}</span></p>
                            </div>

                            <div class="clear"></div>

                            <table id="files_tbl" class="footable table">
                                <thead>
                                    <tr>
                                        <th class="td_checkbox"><input type="checkbox" id="select_all"></th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'timestamp', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Adicionado
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'timestamp' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Tipo</th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'filename', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Título
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'filename' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Tamaño</th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'uploader', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Cargador
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'uploader' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'public_allow', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Permisos públicos
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'public_allow' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Expira</th>
                                        <th>Estado</th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'download_count', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Cantidad de descargas
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'download_count' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $fileRelation)
                                        <tr>
                                            <td><input type="checkbox" name="batch[]"
                                                    value="{{ $fileRelation->file_id }}"></td>
                                            <td>{{ $fileRelation->timestamp ? $fileRelation->timestamp->format('Y/m/d') : 'N/A' }}
                                            </td>
                                            <td>{{ $fileRelation->file ? pathinfo($fileRelation->file->original_url, PATHINFO_EXTENSION) : 'N/A' }}
                                            </td>
                                            <td>
                                                @if ($fileRelation->file)
                                                    <a
                                                        href="{{ route('files.download', $fileRelation->file_id) }}">{{ $fileRelation->file->filename }}</a>
                                                @else
                                                    No disponible
                                                @endif
                                            </td>
                                            <td>{{ $fileRelation->file && isset($fileRelation->file->size) ? number_format($fileRelation->file->size / 1024, 2) . ' KB' : 'Desconocido' }}
                                            </td>
                                            <td>{{ $fileRelation->file->uploader ?? 'N/A' }}</td>
                                            <td>
                                                @if ($fileRelation->file && $fileRelation->file->public_allow)
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal" data-target="#urlModal"
                                                        data-url="{{ url('download.php?id=' . $fileRelation->file->id . '&token=' . $fileRelation->file->public_token) }}">
                                                        Descarga
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        disabled>Privado</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($fileRelation->file && $fileRelation->file->expires)
                                                    @if (\Carbon\Carbon::parse($fileRelation->file->expiry_date)->isPast())
                                                        <span class="label label-danger">Expiró</span>
                                                    @else
                                                        <span class="label label-success">Válido</span>
                                                    @endif
                                                @else
                                                    <span class="label label-default">No expira</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="label {{ $fileRelation->hidden ? 'label-danger' : 'label-success' }}">
                                                    {{ $fileRelation->hidden ? 'Oculto' : 'Visible' }}
                                                </span>
                                            </td>
                                            <td>{{ $fileRelation->download_count ?? 0 }} veces</td>
                                            <td>
                                                @if ($fileRelation->file)
                                                    <a href="{{ route('companies.files.edit', $fileRelation->file_id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>



                        < <div class="container-fluid text-center">
                            <nav aria-label="Resultados de Navegación">
                                <div class="pagination_wrapper d-inline-block">
                                    {{ $files->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </nav>

                            <div class="d-inline-block" style="margin-top: 10px;">
                                <form class="form-inline d-inline-block">
                                    <div class="form-group">
                                        <label class="control-label hidden-xs hidden-sm">Vaya a:</label>
                                        <input type="number" class="form-control" style="width: auto;"
                                            name="page" id="go_to_page" value="{{ $files->currentPage() }}"
                                            min="1" max="{{ $files->lastPage() }}" />
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
                Claro Colombia </div>
        </footer>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
        <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
        <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
        <script src="{{ asset('includes/js/main.js') }}"></script>
        <script src="{{ asset('includes/js/js.functions.php') }}"></script>
        <script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>
    </div>
    </div>
    <script>
        document.getElementById('select_all').addEventListener('click', function() {
            let isChecked = this.checked;
            let checkboxes = document.querySelectorAll('input[name="batch[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        function goToPage() {
            let page = document.getElementById('go_to_page').value;
            if (page) {
                window.location.href = `?page=${page}`;
            }
        }

        function confirmAction() {
            const selectedAction = document.getElementById('action').value;
            const selectedFiles = document.querySelectorAll('input.batch_checkbox:checked').length;

            if (selectedAction === 'unassign') {
                if (selectedFiles === 0) {
                    alert('No hay archivos seleccionados para desasignar.');
                    return false;
                }

                return confirm(
                    `Está a punto de retirar ${selectedFiles} archivo(s) desde esta cuenta. ¿Está seguro de continuar?`);
            }

            return true; // Para otras acciones, no se requiere confirmación
        }

        document.getElementById('bulkActionForm').addEventListener('submit', function(event) {
            const action = document.getElementById('action').value;
            const selectedFiles = document.querySelectorAll('input[name="batch[]"]:checked');

            if (action === 'none' || selectedFiles.length === 0) {
                event.preventDefault();
                alert('Seleccione una acción válida y al menos un archivo.');
                return;
            }

            if (action === 'unassign') {
                event.preventDefault(); // Detener el envío del formulario inicialmente

                // Crear el mensaje personalizado para la acción "desasignar"
                const message =
                    `Está a punto de retirar ${selectedFiles.length} archivo(s) de esta cuenta. ¿Está seguro de continuar?`;

                // Actualizar el contenido del modal
                document.getElementById('confirmationMessage').innerText = message;

                // Mostrar el modal
                $('#confirmationModal').modal('show');

                // Manejar la confirmación en el modal
                document.getElementById('confirmAction').onclick = function() {
                    document.getElementById('bulkActionForm').submit(); // Enviar el formulario
                };
            }
        });

        // Seleccionar o deseleccionar todos los checkboxes
        document.getElementById('select_all').addEventListener('click', function() {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll('input[name="batch[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        $(document).ready(function() {
            // Manejar la apertura del modal y pasar la URL al textarea
            $('#urlModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var url = button.data('url'); // Extraer la URL del atributo data-url
                var modal = $(this);

                // Asignar la URL al textarea del modal
                modal.find('#publicUrl').val(url);

                // Seleccionar automáticamente el texto al abrir el modal
                modal.find('#publicUrl').click(function() {
                    $(this).select();
                });
            });
        });
    </script>


    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmación de Acción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmationMessage">¿Está seguro de realizar esta acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmAction" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

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
