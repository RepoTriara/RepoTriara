<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administración de Categorías &raquo; Repositorio</title>
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

<body class="categories logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')
            <div class="container-fluid">

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Administración de Categorías</h2>
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
                            <!-- Formulario de búsqueda -->
                            <form action="{{ route('categories.index') }}" method="get" class="form-inline">
                                <div class="form-group group_float">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        class="txtfield form_actions_search_box form-control" />
                                </div>
                                <button type="submit" id="btn_proceed_search"
                                    class="btn btn-sm btn-default">Búsqueda</button>
                            </form>

                            <div class="form_actions">
                                <div class="form_actions_count">
                                    <p>Encontró: <span>{{ $totalCategories }} categorías</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="form_actions_right">
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Agregar Categoría
                            </a>

                            <!-- Solo un botón para eliminar seleccionadas o una sola categoría -->
                            <button type="button" id="btn_delete_selected" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Eliminar Seleccionadas
                            </button>
                        </div>

                        <div class="clear"></div>

                        <form action="{{ route('categories.bulk_delete') }}" method="POST" id="bulk_delete_form">
                            @csrf
                            @method('DELETE')

                            <table id="categories_tbl" class="footable table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all" /></th>
                                        <th>
                                            <a
                                                href="{{ route('categories.index', ['orderby' => 'name', 'order' => request('orderby') === 'name' && request('order') === 'asc' ? 'desc' : 'asc']) }}">
                                                Nombre
                                            </a>
                                            <span class="footable-sort-indicator"></span>
                                        </th>
                                        <th>Descripción</th>
                                        <th>Archivos</th> <!-- Nueva columna para mostrar la cantidad de archivos -->
                                        <th>Ver</th> <!-- Nueva columna para Ver -->
                                        <th>Comportamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td><input type="checkbox" name="categories[]"
                                                    value="{{ $category->id }}" /></td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td> <span class="label label-success">{{ $category->files_count }}</span>
                                            </td> <!-- Mostrar cantidad de archivos -->
                                            <td>
                                                <a href="{{ route('files.index', ['category_id' => $category->id]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Ver Archivos
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay categorías registradas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <nav aria-label="Resultados de Navegación">
                                        <div class="pagination_wrapper text-center">
                                            {{ $categories->links('pagination::bootstrap-4') }}
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!-- row -->
            </div> <!-- container-fluid -->

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
            <script src="{{ asset('includes/js/js.functions.php') }}"></script>
            <script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>
            <script>
                // Seleccionar/Deseleccionar todos los checkboxes
                $('#select_all').on('click', function() {
                    $('input[name="categories[]"]').prop('checked', this.checked);
                });

                // Función para eliminar las categorías seleccionadas
                $('#btn_delete_selected').on('click', function() {
                    // Verificar si se han seleccionado categorías
                    var selectedCategories = $('input[name="categories[]"]:checked');
                    if (selectedCategories.length === 0) {
                        alert('Por favor, seleccione al menos una categoría para eliminar.');
                        return;
                    }

                    // Confirmación antes de enviar el formulario
                    if (confirm('¿Estás seguro de eliminar las categorías seleccionadas?')) {
                        $('#bulk_delete_form').submit();
                    }
                });
            </script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->
</body>

</html>
