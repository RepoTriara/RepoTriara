<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administraci&oacute;n del Sistema &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
    <link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
    <script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
    <!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

    <link rel="stylesheet" media="all" type="text/css"
        href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/footable/css/footable.core.css')}}" />

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.css')}}" />
</head>

<body class="body logged-in logged-as-client template default-template hide_title menu_hidden backend">
    <div class="container-custom">


        @if(Auth::user()->level == 0)
            @include('layouts.app_level0')
        @else
            @include('layouts.app')
        @endif


        <div class="main_content">
            <div class="container-fluid">

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Administración del Sistema</h2>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-12">
                        <div id="wrapper">

                            <div id="right_column">

                                <div class="form_actions_left">
                                    <div class="form_actions_limit_results">
                                        <form action="{{ route('my_files') }}" name="form_search" method="get"
                                            class="form-inline">
                                            <div class="form-group group_float">
                                                <input type="text" name="search" id="search"
                                                    value="{{ request()->get('search') }}"
                                                    class="txtfield form_actions_search_box form-control"
                                                    placeholder="Buscar por título o descripción" />
                                            </div>
                                            <button type="submit" id="btn_proceed_search"
                                                class="btn btn-sm btn-default">
                                                Búsqueda
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <form action="" name="files_list" method="get" class="form-inline">
                                    <div class="form_actions_right">
                                        <div class="form_actions">
                                            <div class="form_actions_submit">
                                                <div class="form-group group_float">
                                                    <label class="control-label hidden-xs hidden-sm"><i
                                                            class="glyphicon glyphicon-check"></i> Acciones de archivos
                                                        seleccionados:</label>
                                                    <select name="action" id="action" class="txtfield form-control">
                                                        <option value="none">Seleccione la acción</option>
                                                        <option value="zip">Descarga comprimida</option>
                                                    </select>
                                                </div>
                                                <button type="submit" id="do_action"
                                                    class="btn btn-sm btn-default">Proceder</button>
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
                                                <th class="td_checkbox"><input type="checkbox" name="select_all"
                                                        id="select_all" value="0" /></th>


                                                <th class="{{ request('orderby') === 'filename' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                                    data-hide="phone,tablet">
                                                    <a
                                                        href="{{ route('my_files', ['orderby' => 'filename', 'order' => request('orderby') === 'filename' && request('order') === 'asc' ? 'desc' : 'asc']) }}">Titulo</a>
                                                    <span class="footable-sort-indicator"></span>
                                                </th>

                                                <th data-hide="phone">Tipo</th>

                                                <th class="{{ request('orderby') === 'description' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                                    data-hide="phone,tablet">
                                                    <a
                                                        href="{{ route('my_files', ['orderby' => 'description', 'order' => request('orderby') === 'description' && request('order') === 'asc' ? 'desc' : 'asc']) }}">Descripción</a>
                                                    <span class="footable-sort-indicator"></span>
                                                </th>

                                                <th data-hide="phone">Tamaño</th>

                                                <th class="{{ request('orderby') === 'Timestamp' ? 'footable-sorted-desc footable-visible footable-sorted-active active' : 'footable-visible' }}"
                                                    data-hide="phone,tablet">
                                                    <a
                                                        href="{{ route('my_files', ['orderby' => 'Timestamp', 'order' => request('orderby') === 'Timestamp' && request('order') === 'asc' ? 'desc' : 'asc']) }}">Fecha</a>
                                                    <span class="footable-sort-indicator"></span>
                                                </th>

                                                <th data-hide="phone">Fecha de expiración</th>

                                                <th data-hide="phone,tablet">Image preview</th>

                                                <th data-hide="phone">Descarga</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($files as $file)
                                                <tr class="table_row">
                                                    <td><input type="checkbox" name="batch[]" value="{{ $file->id }}"></td>
                                                    <td>
                                                        <a href="{{ route('files.download', $file->id) }}">{{ $file->filename
                                                            }}</a>
                                                    </td>
                                                    <td>
                                                        <span class="label label-success label_big">
                                                            {{ strtoupper(pathinfo($file->original_url, PATHINFO_EXTENSION)) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <!-- Aquí accedemos directamente al campo description -->
                                                        {{ $file->description ?? 'N/A' }}
                                                        <!-- Muestra N/A si no hay descripción -->
                                                    </td>
                                                    <td>{{ $file->size ? number_format($file->size / 1024, 2) . ' KB' : '-' }}
                                                    </td>

                                                    <td>{{ $file->timestamp ? $file->timestamp->format('Y/m/d') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($file->formattedExpiryDate)
                                                            <span class="label label-primary label_big">

                                                                <strong>{{ $file->formattedExpiryDate }}</strong>
                                                            </span>
                                                        @else
                                                            <span class="label label-success label_big">
                                                                Nunca
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td></td>
                                                    <td class="text-center">
                                                        <a href="{{ url('repositorio/process.php', ['do' => 'download', 'id' => $file->id]) }}"
                                                            class="btn btn-primary btn-sm btn-wide" target="_blank">
                                                            Descargar </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <nav aria-label="Resultados de Navegación">
                                                    <!-- Renderizar el paginador -->
                                                    {{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->appends(request()->query())->links('pagination::bootstrap-4') : '' }}
                                                </nav>
                                                <div style="margin-top: 50px;"></div>

                                                <div class="form-group">
                                                    <label class="control-label hidden-xs hidden-sm">Valla a:</label>
                                                    <form method="GET" action="{{ request()->url() }}"
                                                        id="go_to_page_form">
                                                        <!-- Enviar el número de página -->
                                                        <input type="text" class="form-control" name="page"
                                                            id="go_to_page"
                                                            value="{{ $files instanceof \Illuminate\Pagination\LengthAwarePaginator ? $files->currentPage() : 1 }}" />
                                                    </form>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="form-control" form="go_to_page_form">
                                                        <span aria-hidden="true" class="glyphicon glyphicon-ok"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div> <!-- right_column -->
                        </div> <!-- wrapper -->

                        <footer>
                            <div id="footer">
                                Claro Colombia </div>
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
                    <script>
                        document.getElementById('select_all').addEventListener('click', function () {
                            // Obtener el estado del checkbox principal
                            var isChecked = this.checked;

                            // Seleccionar todos los checkboxes que están en el grupo 'batch[]'
                            var checkboxes = document.querySelectorAll('input[name="batch[]"]');

                            // Iterar sobre todos los checkboxes y actualizarlos con el mismo estado
                            checkboxes.forEach(function (checkbox) {
                                checkbox.checked = isChecked;
                            });
                        });
                    </script>
</body>

</html>