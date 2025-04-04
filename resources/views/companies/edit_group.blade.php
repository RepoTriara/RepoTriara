<!doctype html>
<html lang="es_CO">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Compañia de Clientes &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>

    <!-- Incluir CSS de Bootstrap, font-awesome y Chosen (los mismos que en add_company) -->
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
</head>
<body class="groups-edit logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')

            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Editar compañia de clientes</h2>
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
                                @endif

                                <form action="{{ route('groups.update', $group->id) }}" method="POST" class="form-horizontal">
                                    @csrf
                                    @method('PUT')

                                    <!-- Nombre del grupo -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Nombre del grupo</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $group->name) }}" required />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Descripción del grupo -->
                                    <div class="form-group">
                                        <label for="add_group_form_description" class="col-sm-4 control-label">Descripción</label>
                                        <div class="col-sm-8">
                                            <!-- Elimina espacios extra dentro del textarea -->
                                            <textarea name="add_group_form_description" id="add_group_form_description" class="form-control">{!! old('add_group_form_description', $group->description) !!}</textarea>
                                            @error('add_group_form_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Integrantes (filtrados para mostrar solo usuarios de level 0) -->
                                    <div class="form-group assigns">
                                        <label for="add_group_form_members" class="col-sm-4 control-label">Integrantes</label>
                                        <div class="col-sm-8">
                                            <select multiple="multiple" id="members-select" class="form-control chosen-select" name="add_group_form_members[]" data-placeholder="Seleccione una o más opciones. Escriba para buscar">
                                                @foreach ($members as $member)
                                                    @if ($member->level == 0)
                                                        <option value="{{ $member->id }}" {{ $selectedMembers->contains($member->id) ? 'selected' : '' }}>
                                                            {{ $member->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Botón de guardar cambios -->
                                    <div class="inside_form_buttons">
                                        <button type="submit" class="btn btn-wide btn-primary">Guardar cambios</button>
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
            <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
            <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
            <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
            <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
            <script src="{{ asset('includes/js/main.js') }}"></script>
            <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
            <script src="{{ asset('includes/js/ckeditor/ckeditor.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
            $(document).ready(function() {
                // Inicializar Chosen con las mismas opciones que en add_company
                $('.chosen-select').chosen({
                    width: "100%",
                    no_results_text: "No se encontró esta opción",
                    placeholder_text_multiple: "Seleccione una o más opciones. Escriba para buscar"
                });

                // Inicializar CKEditor en el textarea
                CKEDITOR.replace('add_group_form_description');

                // Función para mostrar mensajes de éxito con SweetAlert2
                function showSuccessMessage(message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
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
                $('form').on('submit', function(e) {
                    e.preventDefault(); // Evitar el envío tradicional del formulario

                    // Actualizar el contenido de CKEditor al textarea
                    for (var instance in CKEDITOR.instances) {
                        if (CKEDITOR.instances.hasOwnProperty(instance)) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                    }

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                showSuccessMessage(response.success);
                            } else if (response.error) {
                                showErrorMessage(response.error);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON.error) {
                                let errorMessages = Object.entries(xhr.responseJSON.error)
                                    .map(([field, messages]) => `<b>${field}:</b> ${messages.join(', ')}`)
                                    .join('<br>');
                                showErrorMessage(errorMessages);
                            } else {
                                showErrorMessage('Hubo un problema al procesar la solicitud.');
                            }
                        }
                    });
                });
            });
            </script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->
</body>
</html>
