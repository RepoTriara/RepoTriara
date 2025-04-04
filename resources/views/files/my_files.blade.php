<!doctype html>
<html lang="es_CO">
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>Administraci&oacute;n del Sistema &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
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
 
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.css') }}" />
</head>
 
<body class="body logged-in logged-as-client template default-template ">
 
 
 
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
                            <h2 style="color: #333333; font-size: 27px; line-height: 29px; margin: 0 0 35px; letter-spacing: -1px;">{{ isset($pageTitle) ? $pageTitle : 'Mis archivos' }}</h2>
                        </div>
                    </div>
                </div>
 
                <div class="row">
 
                    <div class="col-xs-12">
                        <div id="wrapper">
 
                            <div id="right_column">
 
                                <div class="form_actions_left">
                                    <div class="form_actions_limit_results">
                                        <form action="{{ route('my_files') }}" method="get" class="form-inline">
                                            <input type="hidden" name="cliente_id"
                                                value="{{ request()->get('cliente_id', Auth::user()->id) }}">
                                            <div class="form-group group_float">
                                                <input type="text" name="search" id="search"
                                                    value="{{ request()->get('search') }}" class="form-control"
                                                    placeholder="Buscar por título o descripción">
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                Búsqueda
                                            </button>
                                        </form>
 
                                        <!-- Formulario de filtro de categorías -->
                                        <form action="{{ route('my_files') }}" name="files_filters" method="get"
                                            class="form-inline form_filters">
                                            <!-- Campo oculto para mantener el parámetro cliente_id -->
                                            <input type="hidden" name="cliente_id"
                                                value="{{ request('cliente_id', auth()->user()->id) }}">
                                            <div class="form-group group_float">
                                                <select name="categories[]" class="txtfield form-control">
                                                    <option value="all"
                                                        {{ in_array('all', request()->input('categories', [])) ? 'selected' : '' }}>
                                                        Todas las categorias
                                                    </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ in_array($category->id, request()->input('categories', [])) ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" id="btn_proceed_filter_files"
                                                class="btn btn-sm btn-primary">Filtrar</button>
                                        </form>
                                    </div>
                                </div>
 
                                <form action="{{ route('files.downloadCompresed') }}" name="files_list" method="POST"
                                    class="form-inline">
                                    @csrf
                                    <div class="form_actions_right">
                                        <div class="form_actions">
                                            <div class="form_actions_submit">
                                                <div class="form-group group_float">
                                                    <label class="control-label hidden-xs hidden-sm"><i
                                                            class="glyphicon glyphicon-check"></i> Acciones de archivos
                                                        seleccionados:
                                                    </label>
                                                    <select name="action" id="action" class="txtfield form-control">
                                                        <option value="none">Seleccione la acción</option>
                                                        <option value="zip">Descarga comprimida</option>
                                                    </select>
                                                </div>
                                                <button type="submit" id="do_action"
                                                    class="btn btn-sm btn-primary">Proceder</button>
 
                                            </div>
                                        </div>
                                    </div>
 
 
                                    <div class="right_clear"></div><br />
 
                                    <div class="form_actions_count">
                                        <p>Encontró: <span>{{ $filteredTotal }}</span></p>
                                    </div>
 
 
                                    <div class="right_clear"></div>
 
                                    <table id="files_list" class="footable table default footable-loaded">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="select_all"
                                                        class="footable-sort-indicator" />
                                                </th>
                                                <th
                                                    class="{{ request('orderby') === 'filename' ? 'active footable-sorted-' . request('order') : '' }}">
                                                    <a
                                                        href="{{ route('my_files', array_merge(request()->except('orderby', 'order', 'page'), ['orderby' => 'filename', 'order' => request('orderby') === 'filename' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                                                        Título
                                                        <i
                                                            class="fa fa-sort{{ request('orderby') === 'filename' ? (request('order') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                                    </a>
                                                </th>
                                                <th data-hide="phone">Tipo</th>
                                                <th
                                                    class="{{ request('orderby') === 'description' ? 'active footable-sorted-' . request('order') : '' }}">
                                                    <a
                                                        href="{{ route('my_files', array_merge(request()->except('orderby', 'order', 'page'), ['orderby' => 'description', 'order' => request('orderby') === 'description' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                                                        Descripción
                                                        <i
                                                            class="fa fa-sort{{ request('orderby') === 'description' ? (request('order') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                                    </a>
                                                </th>
                                                <th data-hide="phone">Tamaño</th>
                                                <th
                                                    class="{{ request('orderby') === 'Timestamp' ? 'active footable-sorted-' . request('order') : '' }}">
                                                    <a
                                                        href="{{ route('my_files', array_merge(request()->except('orderby', 'order', 'page'), ['orderby' => 'Timestamp', 'order' => request('orderby') === 'Timestamp' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                                                        Fecha
                                                        <i
                                                            class="fa fa-sort{{ request('orderby') === 'Timestamp' ? (request('order') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                                    </a>
                                                </th>
                                                <th data-hide="phone">Fecha de expiración</th>
                                                <th data-hide="phone">Descarga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($files as $file)
                                                <tr class="table_row">
                                                    <td>
                                                        <input type="checkbox" name="file_ids"
                                                            value="{{ $file->id }}"
                                                            class="footable-sort-indicator">
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('file.directDownload', ['id' => $file->id]) }}">{{ $file->filename }}</a>
                                                        <span class="footable-sort-indicator"></span>
                                                    </td>
                                                    <td>
                                                        <span class="label label-success label_big">
                                                            {{ strtoupper(pathinfo($file->original_url, PATHINFO_EXTENSION)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $file->description ?? 'N/A' }}</td>
                                                    <td>{{ $file->size }}</td>
                                                    <td>{{ $file->timestamp ? $file->timestamp->format('Y/m/d') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($file->formattedExpiryDate)
                                                            <span class="label label-primary label_big">
                                                                <strong>{{ $file->formattedExpiryDate }}</strong>
                                                            </span>
                                                        @else
                                                            <span class="label label-success label_big">Nunca</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('file.directDownload', ['id' => $file->id]) }}"
                                                            class="btn btn-primary">
                                                            Descargar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No se encontraron
                                                        registros.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
 
                                    <div class="container-fluid text-center">
                                        <nav aria-label="Resultados de Navegación">
                                            <div class="pagination_wrapper d-inline-block">
                                                <!-- Renderizar el paginador -->
                                                {{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->links('vendor.pagination.bootstrap-4') : '' }}
                                            </div>
                                        </nav>
 
                                        <div class="d-inline-block" style="margin-top: 10px;">
                                            <form class="form-inline d-inline-block" id="go_to_page_form">
                                                <div class="form-group">
                                                    <label class="control-label hidden-xs hidden-sm">Vaya a:</label>
                                                    <input type="number" class="form-control" style="width: auto;"
                                                        name="page" id="go_to_page"
                                                        value="{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->currentPage() : 1 }}"
                                                        min="1"
                                                        max="{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->lastPage() : 1 }}" />
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default"
                                                        onclick="goToPage()">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
 
 
 
                                </form>
                            </div>
 
                        </div>
                    </div>
                </div>
 
                </form>
 
            </div>
            <!-- right_column -->
            <footer>
                <div id="footer">
                    Claro Colombia </div>
            </footer>
        </div> <!-- wrapper -->
 
 
 
    </div>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
    <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
    <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
    <script src="{{ asset('includes/js/main.js') }}"></script>
    <script src="{{ asset('includes/js/js.functions.php') }}"></script>
    <script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>
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
 
        // Mostrar mensaje si no hay resultados en la búsqueda de archivos
        @if (request('search') && $files->isEmpty())
            showNoResultsMessage('No se encontraron archivos que coincidan con: "{{ request('search') }}"');
        @endif
 
        // Función para manejar la selección/deselección de checkboxes
        function setupCheckboxes() {
            const selectAllCheckbox = document.getElementById('select_all');
            const fileCheckboxes = document.querySelectorAll('input[name="file_ids"]');
 
            if (selectAllCheckbox && fileCheckboxes.length > 0) {
                // Seleccionar/deseleccionar todos
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    fileCheckboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                });
 
                // Actualizar el estado del checkbox "Seleccionar todos" cuando se cambian checkboxes individuales
                fileCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(fileCheckboxes).every(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                    });
                });
            }
        }
 
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar los checkboxes
            setupCheckboxes();
 
            const downloadForm = document.forms['files_list'];
            const delay = 3000;
 
            downloadForm.onsubmit = function(e) {
                const action = document.getElementById('action').value;
 
                if (action === 'zip') {
                    e.preventDefault();
 
                    // Verificar si hay archivos seleccionados
                    const selectedFiles = document.querySelectorAll('input[name="file_ids"]:checked');
                    if (selectedFiles.length === 0) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Por favor selecciona al menos un archivo para descargar',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#2778c4'
                        });
                        return;
                    }
 
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
                        downloadForm.submit();
                    }, delay);
                }
            };
 
            @if (session('success'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2778c4'
                });
            @endif
 
            @if (session('error'))
                Swal.fire({
                    title: 'Error',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2778c4'
                });
            @endif
        });
 
        function goToPage() {
            const pageInput = document.getElementById('go_to_page');
            const page = parseInt(pageInput.value);
            const lastPage = parseInt(
                "{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->lastPage() : 1 }}");
 
            if (isNaN(page) || page < 1 || page > lastPage) {
                Swal.fire({
                    title: 'Página inválida',
                    text: `Por favor, ingresa un número de página entre 1 y ${lastPage}.`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2778c4'
                });
                pageInput.value =
                    "{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->currentPage() : 1 }}";
                return;
            }
 
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
    </script>
 
</body>
 
</html>