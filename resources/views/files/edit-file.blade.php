<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Editar archivo &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>

    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/bootstrap-datepicker/css/datepicker.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />

</head>

<body class="edit-file logged-in logged-as-admin menu_hidden backend">

    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app_level0')
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Editar archivo</h2>
                            <!-- Mostrar mensaje de éxito -->
                            @if (!empty($success))
                                <div class="alert alert-success">
                                    {{ $success }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12">
                        <form action="{{ route('files.update', ['id' => $fileId]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="container-fluid">
                                <div class="file_editor f_e_odd">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="file_number">
                                                <p>
                                                    <span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
                                                    {{ $file->filename ?? 'Nombre del archivo no disponible' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row edit_files">
                                        <div class="col-sm-12">
                                            <div class="row edit_files_blocks">
                                                <div class="col-sm-12 col-md-12 column">
                                                    <div class="file_data">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <h3>Información de archivo</h3>
                                                                <div class="form-group">
                                                                    <label>Título</label>
                                                                    <input type="text" name="filename"
                                                                        value="{{ old('filename', $file->filename ?? '') }}"
                                                                        class="form-control file_title" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Descripción</label>
                                                                    <textarea name="description" class="form-control">{{ old('description', $file->description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="after_form_buttons">
                                                <a href="{{ route('manage-files') }}" name="cancel"
                                                    class="btn btn-default btn-wide">Cancelar</a>
                                                <input type="hidden" name="viewType" value="editBasic">
                                                <button type="submit" id="guardar" name="submit"
                                                    class="btn btn-wide btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
            <footer>
                <div id="footer">Claro Colombia</div>
            </footer>
            <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
            <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
            <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
            <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
            <script src="{{ asset('includes/js/main.js') }}"></script>
            <script src="{{ asset('includes/js/js.functions.php') }}"></script>
            <script src="{{ asset('includes/js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
            <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
            <script src="{{ asset('includes/js/ckeditor/ckeditor.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.getElementById('guardar').addEventListener('click', function(event) {
                    event.preventDefault(); // Evita el envío inmediato del formulario
                    // Envía el formulario utilizando AJAX (Fetch API)
                    fetch(event.target.closest('form').action, {
                        method: 'POST',
                        body: new FormData(event.target.closest('form'))
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                title: '¡Guardado!',
                                text: 'Los cambios se han guardado correctamente.',
                                icon: 'success',
                                timer: 2000, // El mensaje se quitará automáticamente después de 2 segundos
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al guardar los cambios.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al guardar los cambios.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                });
            </script>

        </div>
    </div>
</body>

</html>
