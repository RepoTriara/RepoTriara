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


        @include('layouts.app_level0')


        <div class="main_content">
            <div class="container-fluid">

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Administrar archivos</h2>
                        </div>
                    </div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row">

                    <div class="col-xs-12">
                        <div class="form_actions_left">
                            <div class="form_actions_limit_results">
                                <form action="{{ route('manage-files') }}" name="form_search" method="get"
                                    class="form-inline">
                                    <div class="form-group group_float">
                                        <input type="text" name="search" id="search"
                                            value="{{ request()->get('search') }}"
                                            class="form-control"
                                            placeholder="Buscar por título o descripción" />
                                    </div>
                                    <button type="submit" id="btn_proceed_search" class="btn btn-sm btn-primary">
                                        Búsqueda
                                    </button>
                                </form>

                            </div>
                        </div>


                        <form action="manage-files.php" name="files_list" method="get" class="form-inline">

                            <div class="clear"></div>

                            <div class="form_actions_count">
                                <p>Encontró: <span>{{ $filteredTotal }}</span></p>
                            </div>

                            <div class="clear"></div>

                            <table id="files_list" class="footable table default footable-loaded">
                                <thead>
                                    <tr>
                                        <th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all"
                                                value="0" /></th>
                                        <th
                                            class="{{ request('sort') === 'timestamp' ? 'active footable-sorted-' . request('direction') : '' }}">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'timestamp', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Adicionado
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'timestamp' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                            </a>
                                        </th>

                                        <th data-hide="phone">Tipo</th>

                                        <th
                                            class="{{ request('sort') === 'filename' ? 'active footable-sorted-' . request('direction') : '' }}">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'filename', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Título
                                                <i
                                                    class="fa fa-sort{{ request('sort') === 'filename' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
                                            </a>
                                        </th>


                                        <th data-hide="phone">Tamaño</th>


                                        <th data-hide="phone">Comportamiento</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($files as $file)
                                        <tr class="table_row">
                                            <td><input type="checkbox" name="batch[]" value="{{ $file->id }}"></td>

                                            <td>{{ $file->timestamp ? $file->timestamp->format('Y/m/d') : 'N/A' }}
                                            </td>
                                            <td>

                                                {{ strtoupper(pathinfo($file->original_url, PATHINFO_EXTENSION)) }}

                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('file.directDownload', ['id' => $file->id]) }}">{{ $file->filename }}</a>
                                            </td>

                                            <td>{{ $file->size }}</td>

                                            <td><a href="{{ route('files.editBasic', $file->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No se encontraron registros.</td>
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
                        </div>
                    </div>

                </div> <!-- row -->
            </div> <!-- container-fluid -->

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
        </div> <!-- main_content -->
    </div> <!-- container-custom -->
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

    // Mostrar mensaje si no hay resultados en la búsqueda de archivos
    @if(request('search') && $files->isEmpty())
        showNoResultsMessage('No se encontraron archivos que coincidan con: "{{ request('search') }}"');
    @endif

    // Seleccionar/Deseleccionar todos los checkboxes
    document.getElementById('select_all').addEventListener('click', function() {
        let isChecked = this.checked;
        let checkboxes = document.querySelectorAll('input[name="batch[]"]');

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });

    @if(session('error'))
    Swal.fire({
        title: 'Error',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2778c4'
    });
    @endif
</script>
</body>

</html>
