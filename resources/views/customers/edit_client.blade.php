<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar cliente &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <!--[if lt IE 9]>
  <script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
  <script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
 <![endif]-->

    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/footable.css') }}" />

</head>

<body class="add_client logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">

        <div class="main_content">
            @include('layouts.app')
            <div class="container-fluid"></div>
            <div class="row">
                <div id="section_title">
                    <div class="col-xs-12">
                        <h2>Editar cliente</h2>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    <div class="white-box">
                        <div class="white-box-interior">

                            <form method="POST" action="{{ route('customer_manager.update', $client->id) }}"
                                class="form-horizontal">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name" class="col-sm-4 control-label">Nombre</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" id="name"
                                            class="form-control required" placeholder="Nombre completo del usuario"
                                            value="{{ old('name', $client->name) }}" />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user" class="col-sm-4 control-label">Ingresar nombre de
                                        usuario</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="user" id="user" placeholder="Usuario de RED"
                                            class="form-control required" maxlength="60"
                                            value="{{ old('user', $client->user) }}"
                                            placeholder="Debe ser alfanumérico" />
                                        @error('user')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="add_client_form_pass" class="col-sm-4 control-label">Contraseña</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input name="password" id="password" class="form-control password_toggle"
                                                type="password" maxlength="60" value="" />
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="input-group-btn password_toggler">
                                                <button type="button" class="btn pass_toggler_show"><i
                                                        class="glyphicon glyphicon-eye-open"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" name="generate_password" id="generate_password"
                                            class="btn btn-default btn-sm btn_generate_password"
                                            data-ref="add_client_form_pass" data-min="20"
                                            data-max="20">Generar</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label">E-Mail</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="email" id="email"
                                            class="form-control required" value="{{ old('email', $client->email) }}"
                                            placeholder="Debe ser válido y único" required />
                                        @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-4 control-label">Dirección</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="{{ old('address', $client->address) }}" placeholder="Opcional" />
                                        @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-sm-4 control-label">Teléfono</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ old('phone', $client->phone) }}" placeholder="Opcional" />
                                        @error('phone')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact" class="col-sm-4 control-label">Nombre de contacto
                                        interno</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="contact" id="contact" class="form-control"
                                            value="{{ old('contact', $client->contact) }}" />
                                        @error('contact')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="add_client_form_maxfilesize" class="col-sm-4 control-label">Máximo
                                        tamaño de subida</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" name="max_file_size" id="max_file_size"
                                                class="form-control"
                                                value="{{ old('max_file_size', $client->max_file_size) }}" required />
                                            <span class="input-group-addon">mb</span>
                                            @error('max_file_size')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <p class="field_note">Ponga 0 como limite predeterminado (2048 mb)</p>
                                    </div>
                                </div>

                                <div class="form-group assigns">
                                    <label for="group_request" class="col-sm-4 control-label">Grupos</label>
                                    <div class="col-sm-8">
                                        <select multiple="multiple" name="group_request[]" id="group-select"
                                            class="form-control chosen-select"
                                            data-placeholder="Seleccione una o mas opciones. Escriba para buscar">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ in_array($group->id, $associatedGroups) ? 'selected' : '' }}>
                                                    {{ $group->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <label for="active">
                                            <input type="checkbox" name="active" id="active" value="1"
                                                {{ old('active', $client->active) == 1 ? 'checked' : '' }} /> Activo
                                            (usuario puede
                                            ingresar al sistema)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <label for="add_client_form_notify_upload">
                                            <input type="checkbox" name="notify" id="notify" value="1"
                                                {{ old('notify', $client->notify) == 1 ? 'checked' : '' }}> Notificar
                                            nuevos
                                            archivos por correo </label>
                                        @error('notify_upload')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="inside_form_buttons">
                                    <button type="submit" id="guardar" name="submit"
                                        class="btn btn-wide btn-primary">Actualizar cliente</button>
                                </div>
                                <div class="alert alert-info">La información de cuenta será enviada al correo
                                    electrónico suministrado </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.chosen-select').chosen({
                    no_results_text: "No se encontraron resultados para",
                    width: "100%"
                });
            });
        </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('guardar');

        if (!button) {
            console.error('No se encontró el botón "Actualizar cliente"');
            return;
        }

        button.addEventListener('click', function(e) {
            e.preventDefault();

            const form = button.closest('form');
            if (!form) {
                console.error('Formulario no encontrado');
                return;
            }

            // Función para validar campos con SweetAlert2
            function validateForm() {
                let errors = [];

                if ($("#name").val().trim() === '') {
                    errors.push({ field: 'Nombre', message: 'Complete el nombre.' });
                }
                if ($("#user").val().trim() === '') {
                    errors.push({ field: 'Ingresar nombre de usuario', message: 'Complete el usuario.' });
                }
                if ($("#email").val().trim() === '') {
                    errors.push({ field: 'Correo Electrónico', message: 'Complete el correo electrónico.' });
                }
                if ($("#user").val().length < 5 || $("#user").val().length > 60) {
                    errors.push({ field: 'Ingresar nombre de usuario', message: 'Debe tener entre 5 y 60 caracteres.' });
                }
                if (!/^[a-zA-Z0-9.]+$/.test($("#user").val())) {
                    errors.push({ field: 'Ingresar nombre de usuario', message: 'Debe ser alfanumérico y puede contener (a-z, A-Z, 0-9, .).' });
                }
                if (!/^\S+@\S+\.\S+$/.test($("#email").val())) {
                    errors.push({ field: 'E-Mail', message: 'Formato no válido.' });
                }

                // Validación del campo "Máximo tamaño de subida"
                let maxFileSize = $("#max_file_size").val().trim();
                if (maxFileSize === '') {
                    errors.push({ field: 'Máximo tamaño de subida', message: 'Este campo es obligatorio.' });
                } else if (isNaN(maxFileSize) || maxFileSize < 0 || maxFileSize > 2048) {
                    errors.push({ field: 'Máximo tamaño de subida', message: 'El valor debe ser un número entre 0 y 2048 mb.' });
                }

                if (errors.length > 0) {
                    let errorHtml = errors.map((error, index) =>
                        `<div style="margin-bottom: 10px;"><b>${index + 1}. ${error.field}:</b> ${error.message}</div>`
                    ).join('');

                    Swal.fire({
                        title: 'Errores de validación',
                        html: `<div style="text-align: left;">${errorHtml}</div>`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                    });
                    return false;
                }
                return true;
            }

            // Si la validación del frontend falla, se detiene el proceso
            if (!validateForm()) return;

            // Enviar la solicitud AJAX si todo está correcto
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: new FormData(form),
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    let errorMessages = Object.entries(data.errors).map(([field, messages], index) =>
                        `<div style="margin-bottom: 10px;"><b>${index + 1}. ${field}:</b> ${messages.join(', ')}</div>`
                    ).join('');

                    Swal.fire({
                        title: 'Errores de validación',
                        html: `<div style="text-align: left;">${errorMessages}</div>`,
                        icon: 'error',
                        confirmButtonText: 'aceptar',
                    });
                } else if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.success,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al actualizar el cliente.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
            });
        });
    });
</script>







    </div> <!-- main_content -->
    </div> <!-- container-custom -->

</body>

</html>
