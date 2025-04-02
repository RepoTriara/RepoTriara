<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Nueva Categoría &raquo; Repositorio</title>
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
                            <h2>Crear nueva categoría</h2>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-6">
                        <div class="white-box">
                            <div class="white-box-interior">

                                <!-- Formulario para crear categoría -->
                                <form method="POST" action="{{ route('categories.store') }}" class="form-horizontal">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Nombre</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name" id="name"
                                                class="form-control required" placeholder="Nombre de la categoría"
                                                value="{{ old('name') }}" />
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
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('parent') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
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
                                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="inside_form_buttons">
                                        <button type="submit" name="submit" class="btn btn-wide btn-primary">Guardar
                                            Categoría</button>
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
    $(document).ready(function () {
        $("form").submit(function (event) {
            event.preventDefault(); // Evita la recarga de la página

            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.success,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('categories.create') }}";
                        });
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';

                    $.each(errors, function (key, value) {
                        errorMessages += '<li>' + value + '</li>';
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: '<ul>' + errorMessages + '</ul>',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2778c4'
                    });
                }
            });
        });
    });
</script>

</body>

</html>
