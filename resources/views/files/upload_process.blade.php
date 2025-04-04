<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subir archivos &raquo;Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/bootstrap-datepicker/css/datepicker.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/footable/css/footable.core.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/footable.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="upload-process-form logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @if (Auth::user()->level == 0)
            @include('layouts.app_level0')
            @else
            @include('layouts.app')
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Subir archivos</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">

                        @if ($files->isNotEmpty())

                        <h3 class="text-primary">Archivos listos para cargar</h3>
                        <b>
                            <p class="text-muted">
                                Favor, complete la siguiente información para finalizar el proceso de carga.

                                @if(in_array(auth()->user()->level, [8, 10]))
                                Recuerde que "Título", "Asignación" y "Categoría" son campos obligatorios.
                                @elseif(auth()->user()->level == 0)
                                Recuerde que solo el campo "Título" es obligatorio.
                                @endif
                            </p>
                        </b>
                        <!--div class="message message_info"><strong>Notas</strong>: Puedes saltarte la asignación si quiere. Los archivos se conservan y puede añadir a clientes o grupos más tarde.</div-->
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("form").submit(function() {
                                    clean_form(this);

                                    $(this).find('input[name$="[name]"]').each(function() {
                                        is_complete($(this)[0], 'Titulo esta incpmpleto');
                                    });

                                    // show the errors or continue if everything is ok
                                    if (show_form_errors() == false) {
                                        return false;
                                    }

                                });
                            });
                        </script>
                        <form action="{{ route('file.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="container-fluid">
                                @foreach ($files as $file)
                                <!-- Encabezado del archivo -->
                                <div class="file_number"
                                    style="background-color: #000; color: #fff; padding: 10px; border-radius: 5px;">
                                    <p style="margin: 0; font-size: 14px;">
                                        <span class="glyphicon glyphicon-saved" aria-hidden="true"
                                            style="margin-right: 5px;"></span>
                                        {{ $file->name }}
                                    </p>
                                </div>

                                <!-- Contenedor principal -->
                                <div
                                    style="border: 1px solid #ccc; border-radius: 0 0 5px 5px; padding: 20px; margin-bottom: 20px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); background-color: #fff;">
                                    <div class="row">
                                        <!-- Información del archivo -->
                                        <div class="col-sm-6 col-md-3 file-info-container" style="margin-bottom: 20px;">
                                            <h3 style="font-size: 16px; margin-bottom: 15px;">Información de archivo</h3>
                                            <input type="hidden" name="file[{{ $file->id }}][file]" value="{{ $file->file }}" />
                                            <div class="form-group">
                                                <label style="font-weight: bold;">Título</label>
                                                <input type="text" name="file[{{ $file->id }}][name]"
                                                    value="{{ old('file.' . $file->id . '.name', $file->title) }}"
                                                    class="form-control" placeholder="Ingrese aquí el título del archivo" required />
                                            </div>
                                            <div class="form-group">
                                                <label style="font-weight: bold;">Descripción</label>
                                                <textarea name="file[{{ $file->id }}][description]" class="form-control"
                                                    placeholder="Opcionalmente, introduzca aquí una descripción del archivo."
                                                    style="resize: none; width: 100%;">{{ old('file.' . $file->id . '.description', $file->description) }}</textarea>
                                            </div>
                                        </div>

                                        @if (Auth::user()->level == 8 || Auth::user()->level == 10)
                                        <!-- Fecha de expiración y descarga pública -->
                                        <div class="col-sm-6 col-md-3" style="margin-bottom: 20px;">
                                            <h3 style="font-size: 16px; margin-bottom: 15px;">Fecha de
                                                expiración</h3>
                                            <div class="form-group">
                                                <label style="font-weight: bold;">Fecha de
                                                    expiración</label>
                                                <input type="date" class="form-control" readonly
                                                    name="file[{{ $file->id }}][expiry_date]"
                                                    value="{{ old('file.' . $file->id . '.expiry_date', $file->expiry_date ? \Carbon\Carbon::parse($file->expiry_date)->format('Y-m-d') : '') }}" />
                                            </div>
                                            <h3 style="font-size: 16px; margin-bottom: 15px;">Descarga
                                                pública</h3>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"
                                                        name="file[{{ $file->id }}][public]"
                                                        value="1"
                                                        {{ $file->public ? 'checked' : '' }} /> Permitir
                                                    descarga pública.
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"
                                                        name="file[{{ $file->id }}][hidden]"
                                                        value="1"
                                                        {{ $file->hidden ? 'checked' : '' }} /> Carga
                                                    oculta (No se enviarán notificaciones).
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Asignaciones -->
                                        <div class="col-sm-6 col-md-3" style="margin-bottom: 20px;">
                                            <h3 style="font-size: 16px; margin-bottom: 15px;">Asignaciones*
                                            </h3>
                                            <select multiple="multiple"
                                                name="file[{{ $file->id }}][assignments][]"
                                                class="form-control chosen-select" data-type="assignments"
                                                required>
                                                <optgroup label="Clientes">
                                                    @foreach ($users->where('level', 0) as $user)
                                                    <option value="user_{{ $user->id }}"
                                                        {{ in_array($user->id, $file->assignments->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Compañías">
                                                    @foreach ($groups as $group)
                                                    <option value="group_{{ $group->id }}"
                                                        {{ in_array($group->id, $file->assignments->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $group->name }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <div style="margin-top: 10px;">
                                                <a href="#" class="btn btn-xs btn-primary add-all"
                                                    data-type="assignments">Agregar todo</a>
                                                <a href="#"
                                                    class="btn btn-xs btn-primary remove-all"
                                                    data-type="assignments">Borrar todo</a>
                                                <a href="#" class="btn btn-xs btn-danger copy-all"
                                                    data-type="assignments">Copiar la selección a otros
                                                    archivos</a>
                                            </div>
                                        </div>

                                        <!-- Categorías -->
                                        <div class="col-sm-6 col-md-3" style="margin-bottom: 20px;">
                                            <h3 style="font-size: 16px; margin-bottom: 15px;">Categorías*
                                            </h3>
                                            <select multiple="multiple"
                                                name="file[{{ $file->id }}][categories][]"
                                                class="form-control chosen-select" data-type="categories"
                                                required>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, $file->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div style="margin-top: 10px;">
                                                <a href="#" class="btn btn-xs btn-primary add-all"
                                                    data-type="categories">Agregar todo</a>
                                                <a href="#"
                                                    class="btn btn-xs btn-primary remove-all"
                                                    data-type="categories">Borrar todo</a>
                                                <a href="#" class="btn btn-xs btn-danger copy-all"
                                                    data-type="categories">Copiar la selección a otros
                                                    archivos</a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div style="text-align: center; margin-top: 20px;">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                        @elseif ($savedFiles->isNotEmpty())
                        <h3 class="text-primary font-weight-bold">ARCHIVOS SUBIDOS CORRECTAMENTE</h3>

                        <div class="whitebox">
                            <table class="table table-hover table-striped table-bordered table-sortable">
                                <thead>
                                    <tr style="background-color: rgb(235, 240, 245);">
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'filename', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                style="color: black; text-decoration: none !important;">
                                                Título
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'filename' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'description', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                style="color: black; text-decoration: none !important;">
                                                Descripción
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'description' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'original_url', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                style="color: black; text-decoration: none !important;">
                                                Nombre del Archivo
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'original_url' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'hidden', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                style="color: black; text-decoration: none !important;">
                                                Estado
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'hidden' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'file_relations_count', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                style="color: black; text-decoration: none !important;">
                                                Asignaciones
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'file_relations_count' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'public_allow', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                                style="color: black; text-decoration: none !important;">
                                                Público
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'public_allow' ? (request('direction') === 'asc' ? '-up' : '-down') : '' }}"></i>
                                            </a>
                                        </th>
                                        <th style="color: black;">Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($savedFiles as $savedFile)
                                    <tr>
                                        <td>{{ $savedFile->filename }}</td>
                                        <td>{{ $savedFile->description ?? 'Sin descripción' }}</td>
                                        <td>{{ $savedFile->original_url }}</td>
                                        <td>
                                            @php
                                            $isHidden = $savedFile->fileRelations->contains('hidden', true);
                                            @endphp
                                            <span
                                                class="label {{ $isHidden ? 'label-danger' : 'label-success' }}">
                                                {{ $isHidden ? 'Oculto' : 'Visible' }}

                                            </span>
                                        </td>
                                        <td>{{ $savedFile->fileRelations->count() }}</td>
                                        <td>
                                            @if ($savedFile->public_allow)
                                            <button type="button" class="btn btn-primary btn-sm"
                                                data-toggle="modal" data-target="#urlModal"
                                                data-url="{{ route('file.showDownload', ['id' => $savedFile->id, 'token' => $savedFile->public_token]) }}">Público</button>
                                            @else
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                disabled>Privado</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->level == 0)
                                            <a href="{{ route('files.editBasic', $savedFile->id) }}"
                                                class="btn btn-sm btn-primary"><i
                                                    class="fa fa-pencil"></i></a>
                                            @else
                                            <a href="{{ route('files.edit', $savedFile->id) }}"
                                                class="btn btn-sm btn-primary"><i
                                                    class="fa fa-pencil"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @elseif ($archivedFiles->isNotEmpty())
                        {{-- NUEVA SECCIÓN PARA ARCHIVOS GUARDADOS --}}
                        <h3 class="text-primary font-weight-bold">ARCHIVOS GUARDADOS</h3>

                        <div class="whitebox">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="background-color:rgb(52, 10, 218);">
                                        <th style="color: white;">Nombre del Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($archivedFiles as $archivedFile)
                                    <tr>
                                        <td>{{ $archivedFile['filename'] ?? 'Nombre no disponible' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif



                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        let isSaved = false; // Indica si el usuario ha guardado los archivos
                        let isReloading = false; // Indica si la página se está recargando

                        // Guardar la última URL visitada en sessionStorage para detectar cambios de módulo
                        let previousPage = sessionStorage.getItem('lastPage') || '';
                        sessionStorage.setItem('lastPage', window.location.href);

                        // Si la URL anterior es la misma, significa que el usuario solo recargó la página
                        if (previousPage === window.location.href) {
                            isReloading = true;
                        }

                        // Detectar cuando el usuario hace clic en "Guardar"
                        $("form").submit(function() {
                            isSaved = true; // Marcar que los archivos han sido guardados
                        });

                        // Detectar si el usuario cierra la pestaña o cambia de módulo sin guardar
                        window.addEventListener("beforeunload", function(event) {
                            if (!isSaved && !isReloading) {
                                clearTempFiles();
                            }
                        });

                        // Detectar si el usuario navega a otra parte de la aplicación sin guardar
                        $(document).on("click", "a", function(event) {
                            let newPage = $(this).attr("href");

                            // Si el enlace es interno y no es una recarga, eliminar archivos
                            if (newPage && newPage !== "#" && newPage !== window.location.href) {
                                if (!isSaved) {
                                    clearTempFiles();
                                }
                            }
                        });

                        function clearTempFiles() {
                            fetch("{{ route('files.clearTemporaryFiles') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({})
                                }).then(response => response.json())
                                .then(data => console.log("Archivos temporales eliminados:", data.message))
                                .catch(error => console.error("Error al eliminar archivos:", error));
                        }

                        // -----------------------
                        // FUNCIONES EXISTENTES (MANTENIDAS)
                        // -----------------------

                        function sortTable(columnIndex, ascending) {
                            const table = $('.table-sortable tbody');
                            const rows = table.find('tr').toArray();

                            rows.sort(function(a, b) {
                                const cellA = $(a).find('td').eq(columnIndex).text().toLowerCase();
                                const cellB = $(b).find('td').eq(columnIndex).text().toLowerCase();

                                if (cellA < cellB) return ascending ? -1 : 1;
                                if (cellA > cellB) return ascending ? 1 : -1;
                                return 0;
                            });

                            // Reconstruir la tabla con las filas ordenadas
                            rows.forEach(function(row) {
                                table.append(row);
                            });
                        }

                        $('.table-sortable th a').on('click', function(e) {
                            e.preventDefault();

                            const th = $(this).closest('th');
                            const columnIndex = th.index();
                            const currentDirection = th.data('direction') || 'asc';
                            const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

                            $('.table-sortable th i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
                            const icon = newDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down';
                            $(this).find('i').removeClass('fa-sort').addClass(icon);

                            th.data('direction', newDirection);
                            sortTable(columnIndex, newDirection === 'asc');
                        });

                        $('#urlModal').on('show.bs.modal', function(event) {
                            const button = $(event.relatedTarget);
                            const url = button.data('url');

                            console.log('URL enviada al modal:', url);
                            const modal = $(this);
                            modal.find('#publicUrl').val(url);
                        });

                        $('.copy-all').click(function() {
                            if (confirm("¿Copiar la selección a todos los archivos?")) {
                                const type = $(this).data('type');


                                const $currentSelect = $(this).closest('.col-sm-6').find(`select[data-type="${type}"]`);

                                const selected = $currentSelect.val();

                                if (!selected || selected.length === 0) {
                                    alert("No hay elementos seleccionados para copiar.");
                                    return false;
                                }

                                $(`select[data-type="${type}"]`).each(function() {
                                    $(this).val(selected).trigger('chosen:updated');
                                });
                            }

                            return false;
                        });


                        $('.add-all').click(function(e) {
                            e.preventDefault();

                            // Obtener el tipo de selección (assignments o categories)
                            const type = $(this).data('type');

                            // Encontrar el select específico dentro del contenedor del archivo actual
                            const $fileContainer = $(this).closest('.row'); // Buscar el contenedor del archivo
                            const $select = $fileContainer.find(`select[data-type="${type}"]`);

                            // Seleccionar todos los elementos dentro de este select específico
                            $select.find('option').prop('selected', true);

                            // Actualizar el componente Chosen solo para este select
                            $select.trigger('chosen:updated');
                        });


                        $('.remove-all').click(function(e) {
                            e.preventDefault();

                            const type = $(this).data('type');
                            const $fileContainer = $(this).closest('.row');
                            const $select = $fileContainer.find(`select[data-type="${type}"]`);

                            // Eliminar la selección solo para este archivo
                            $select.find('option').prop('selected', false);
                            $select.trigger('chosen:updated');
                        });


                        $('.chosen-select').chosen({
                            width: '100%',
                            no_results_text: 'No se encontraron resultados.',
                            placeholder_text_multiple: 'Seleccione una o más opciones.',
                        });

                    });
                </script>


            </div>
            <footer>
                <div id="footer">Claro Colombia </div>
            </footer>
            <!-- row -->
        </div>
        <!-- container-fluid -->

        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
        <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
        <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
        <script src="{{ asset('includes/js/main.js') }}"></script>
        <script src="{{ asset('includes/js/js.functions.php') }}"></script>
        <script src="{{ asset('includes/js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('includes/js/footable/footable.all.min.js') }}"></script>
        <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('includes/js/ckeditor/ckeditor.js') }}"></script>
    </div>
    <!-- main_content -->
    </div>
    <!-- container-custom -->

    <!-- Modal para mostrar la URL pública -->
    <div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="urlModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="urlModalLabel">URL Pública</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Haga clic para seleccionar y copiar:</p>
                    <textarea id="publicUrl" class="form-control" readonly></textarea>
                    <p class="mt-3">Comparta esta URL para acceder al archivo público.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Asegúrate de incluir SweetAlert2 en tu proyecto -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // Función para mostrar un mensaje de éxito que se cierra automáticamente
        function showSuccessMessage(title, text = '', icon = 'success', timer = 10000) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showConfirmButton: false, // Elimina el botón de confirmación
                timer: timer, // Tiempo antes de que se cierre automáticamente (3000ms)
                timerProgressBar: true, // Muestra la barra de progreso mientras espera
            });
        }

        // Función para mostrar un mensaje de error que se cierra automáticamente
        function showErrorMessage(title, text = '', icon = 'error', timer = 10000) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showConfirmButton: false, // Elimina el botón de confirmación
                timer: timer, // Tiempo antes de que se cierre automáticamente (3000ms)
                timerProgressBar: true, // Muestra la barra de progreso mientras espera
            });
        }

        // Función para mostrar un mensaje de advertencia que se cierra automáticamente
        function showWarningMessage(title, text = '', icon = 'warning', timer = 10000) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showConfirmButton: false, // Elimina el botón de confirmación
                timer: timer, // Tiempo antes de que se cierre automáticamente (3000ms)
                timerProgressBar: true, // Muestra la barra de progreso mientras espera
            });
        }

        function showInfoMessage(title, text = '', icon = 'info', timer = 10000) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showConfirmButton: false, // Elimina el botón de confirmación
                timer: timer, // Tiempo antes de que se cierre automáticamente (3000ms)
                timerProgressBar: true, // Muestra la barra de progreso mientras espera
            });
        }

        // Ejemplo de uso al enviar el formulario
        $('form').submit(function(event) {
            // Aquí puedes añadir lógica de validación o procesamiento
            showSuccessMessage('¡Exito!', 'Los datos han sido guardados correctamente.');
        });

        // Ejemplo para manejar errores al intentar eliminar un archivo
        function deleteFileError() {
            showErrorMessage('Error al eliminar el archivo', 'Hubo un problema al eliminar el archivo, por favor intenta nuevamente.');
        }

        // Ejemplo para mostrar advertencia al no guardar cambios
        function unsavedChangesWarning() {
            showWarningMessage('Cambios no guardados', 'Asegúrate de guardar los cambios antes de abandonar la página.');
        }

        // Ejemplo para mostrar un mensaje de información
        function showInfo() {
            showInfoMessage('Información adicional', 'Este es un mensaje de información adicional.');
        }
    </script>

</body>

</html>