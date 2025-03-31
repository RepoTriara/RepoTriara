<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adicionar compañias de clientes &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>

    <!--[if lt IE 9]>
        <script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
        <script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="groups-add logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')

            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Adicionar compañía de clientes</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-6">
                        <div class="white-box">
                            <div class="white-box-interior">
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @else
                                <form action="{{ route('company.store') }}" name="addgroup" method="POST" class="form-horizontal">
                                    @csrf <!-- Token CSRF necesario para formularios POST -->

                                    <div class="form-group">
                                        <label for="add_group_form_name" class="col-sm-4 control-label">Nombre de la compañía</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="add_group_form_name" id="add_group_form_name" class="form-control required" value="{{ old('add_group_form_name') }}" />
                                            @error('add_group_form_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="add_group_form_description" class="col-sm-4 control-label">Descripción</label>
                                        <div class="col-sm-8">
                                            <!-- Se eliminan espacios extra en el textarea -->
                                            <textarea name="add_group_form_description" id="add_group_form_description" class="ckeditor form-control">{{ old('add_group_form_description') }}</textarea>
                                            @error('add_group_form_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group assigns">
                                        <label for="add_group_form_members" class="col-sm-4 control-label">Integrantes</label>
                                        <div class="col-sm-8">
                                            <select multiple="multiple" id="members-select" class="form-control chosen-select" name="add_group_form_members[]" data-placeholder="Seleccione una o más opciones. Escriba para buscar">
                                                @foreach ($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="inside_form_buttons">
                                        <button type="submit" name="submit" class="btn btn-wide btn-primary">Crear grupo</button>
                                    </div>
                                </form>
                                @endif
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
            <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
            <script src="{{ asset('includes/js/ckeditor/ckeditor.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                $(document).ready(function() {
                    // Inicializar el select con Chosen
                    $("#members-select").chosen({
                        width: "100%",
                        no_results_text: "No se encontró esta opción",
                        placeholder_text_multiple: "Seleccione una o más opciones. Escriba para buscar"
                    });

                    // Inicializar CKEditor en el textarea (sin espacios extra)
                    CKEDITOR.replace('add_group_form_description');

                    // Función para mostrar mensajes de éxito con SweetAlert2
                    function showSuccessMessage(message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: message,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#2778c4'

                        }).then(() => {
                            // Recargar la página después de mostrar el mensaje de éxito
                            window.location.reload();
                        });
                    }

                    // Función para mostrar mensajes de error con SweetAlert2
                    function showErrorMessage(message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#2778c4'

                        });
                    }

                    // Manejar el envío del formulario vía AJAX
                    $('form[name="addgroup"]').on('submit', function(e) {
                        e.preventDefault(); // Evitar el envío tradicional del formulario


                        // Actualizar el contenido de CKEditor al textarea
                        for (var instance in CKEDITOR.instances) {
                            if (CKEDITOR.instances.hasOwnProperty(instance)) {
                                CKEDITOR.instances[instance].updateElement();
                            }
                        }
                        // (Opcional) Verificar en consola que se envía el HTML formateado
                        console.log("Contenido del editor:", $("#add_group_form_description").val());

                        // Enviar la solicitud AJAX
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    showSuccessMessage(response.success);
                                } else if (response.error) {
                                    showErrorMessage(response.error);
                                }
                            },
                            error: function(xhr) {
                                // Manejar errores de validación del servidor
                                if (xhr.status === 400 && xhr.responseJSON.error) {
                                    showErrorMessage(xhr.responseJSON.error);
                                } else {
                                    showErrorMessage("El campo nombre es obligatorio y no puede quedar vacío.");
                                }
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>