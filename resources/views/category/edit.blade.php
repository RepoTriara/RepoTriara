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

                <!-- Mostrar errores de validación -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Mostrar mensaje de éxito -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    $(document).ready(function() {
        // Función para mostrar el mensaje de éxito
        function showSuccessMessage(message) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: message,
                confirmButtonText: 'OK'
            });
        }
// Función para mostrar el mensaje de error
        function showErrorMessage(messages) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `<ul>${messages.map(message => `<li>${message}</li>`).join('')}</ul>`,
                confirmButtonText: 'OK'
            });
        }

        // Mostrar mensajes de error al cargar la página
        if ({{ $errors->any() ? 'true' : 'false' }}) {
            let errorMessages = {!! json_encode($errors->all()) !!};
            showErrorMessage(errorMessages);
        }

        // Mostrar mensajes de éxito o error al enviar el formulario
        $('form').submit(function(event) {
            // Validar el formulario aquí
            clean_form(this);

            $(this).find('input[name$="[name]"]').each(function() {
                is_complete($(this)[0], 'Título está incompleto');
            });

            // Mostrar los errores o continuar si todo está bien
            if (show_form_errors() == false) {
                showErrorMessage('Hay errores en el formulario. Por favor, corrígelos.');
                return false; // Impedir el envío del formulario
            } else {
                // Permitir que el formulario se envíe normalmente
                showSuccessMessage('Categoría actualizada exitosamente.');
                return true; // Permitir el envío del formulario
            }
        });

        // Manejar el clic en el botón "Cancelar"
        $('a[name="cancel"]').click(function(event) {
            event.preventDefault();
            showSuccessMessage('Operación cancelada.');
            window.location.href = '{{ route('categories.index') }}';
        });
    });
</script>


</body>

</html>
