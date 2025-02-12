<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Categoría &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png" sizes="32x32') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png" sizes="152x152') }}">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="category-create logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')

            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Editar Categoría</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-6">
                        <div class="white-box">
                            <div class="white-box-interior">

                                <!-- Formulario para editar categoría -->
                                <form method="POST" action="{{ route('categories.update', $category->id) }}"
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Nombre</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name" id="name"
                                                class="form-control required" placeholder="Nombre de la categoría"
                                                value="{{ old('name', $category->name) }}" />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="parent" class="col-sm-4 control-label">Categoría Padre</label>
                                        <div class="col-sm-8">
                                            <select name="parent" id="parent" class="form-control">
                                                <option value="">Seleccione una categoría padre</option>
                                                @foreach ($categories as $parentCategory)
                                                    <option value="{{ $parentCategory->id }}"
                                                        {{ old('parent', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                                        {{ $parentCategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="col-sm-4 control-label">Descripción</label>
                                        <div class="col-sm-8">
                                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="inside_form_buttons">
                                        <button type="submit" name="submit"
                                            class="btn btn-wide btn-primary">Actualizar Categoría</button>
                                    </div>
                                </form>

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

        </div> <!-- main_content -->
    </div> <!-- container-custom -->

    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
    <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
    <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
    <script src="{{ asset('includes/js/main.js') }}"></script>
    <script src="{{ asset('includes/js/js.functions.php') }}"></script>
    <!-- Asegúrate de incluir SweetAlert2 en tu proyecto -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        // Verificar si hay un mensaje de éxito en la sesión
        @if(session('sweetalert'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('sweetalert') }}",
                showConfirmButton: false, // Sin botón de confirmación
                timer: 3000, // Desaparece después de 5 segundos
            });
        @endif

        // Capturar errores de validación y mostrarlos con SweetAlert2
        @if ($errors->any())
            let errorMessage = "";
            @foreach ($errors->all() as $error)
                errorMessage += "{{ $error }}\n";
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                showConfirmButton: true, // Con botón de confirmación
                confirmButtonText: 'Aceptar'
            });
        @endif
    });
</script>
</body>

</html>