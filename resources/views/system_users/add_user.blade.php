<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Agregue nuevos usuarios &raquo; Repositorio</title>
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

<body class="users-add logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')

            <div class="container-fluid">

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Agregue nuevos usuarios</h2>
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



                                <form method="POST" action="{{ route('users.store') }}" class="form-horizontal">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Nombre</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name" id="name"
                                                class="form-control required" placeholder="Nombre completo del usuario"
                                                value="" />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="user" class="col-sm-4 control-label">Ingresar nombre de
                                            usuario</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="user" id="user"
                                                placeholder="Usuario de RED" class="form-control required"
                                                maxlength="60" value="" placeholder="Debe ser alfanumérico" />
                                            @error('user')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="add_user_form_pass"
                                            class="col-sm-4 control-label">Contraseña</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <!--input name="add_user_form_pass" id="add_user_form_pass" class="form-control  password_toggle" type="password" maxlength="" /-->
                                                <input name="password" id="password"
                                                    class="form-control  password_toggle" type="password" />
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
                                                data-ref="add_user_form_pass" data-min="20"
                                                data-max="20">Generar</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label">E-Mail</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="email" id="email"
                                                class="form-control required" value=""
                                                placeholder="Debe ser válido y único" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="level" class="col-sm-4 control-label">Rol</label>
                                        <div class="col-sm-8">
                                            <select name="level" id="level" class="form-control">
                                                <option value="10">Administrador de Accesos</option>

                                                <option value="8">Usuarios del sistema</option>

                                            </select>
                                            @error('level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="max_file_size" class="col-sm-4 control-label">Máximo tamaño de
                                            subida</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input value="0" type="text" name=""
                                                    id="max_file_size" class="form-control" readonly
                                                    value="" />
                                                <span class="input-group-addon">mb</span>
                                            </div>
                                            <p class="field_note">Ponga 0 como limite predeterminado (2048 mb)</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-4">
                                            <label for="active">
                                                <input type="checkbox" name="active" id="active" value="1"
                                                    {{ old('active', 1) ? 'checked' : '' }} /> Activo (usuario puede
                                                ingresar al sistema)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-4">
                                            <label for="notify">
                                                <input type="checkbox" name="welcome_notify" id="welcome_notify" value="1" checked/>
                                                Envie correo de bienvenida
                                            </label>
                                        </div>
                                    </div>




                                    <div class="inside_form_buttons">
                                        <button type="submit" name="submit" id="guardar"
                                            class="btn btn-wide btn-primary">Adicionar Usuario</button>
                                    </div>

                                    <div class="alert alert-info">La información de cuenta será enviada al correo
                                        electrónico suministrado </div>
                                </form>

                            </div>
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
             <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('guardar');

        if (!button) {
            console.error('No se encontró el botón "Adicionar Usuario"');
            return;
        }

        button.addEventListener('click', function (e) {
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
                    errors.push({ field: 'Ingresar nombre de usuario', message: 'Debe ser alfanumérico, no puede tener espacios y puede contener (a-z, A-Z, 0-9, .).' });
                }
                if (!/^\S+@\S+\.\S+$/.test($("#email").val())) {
                    errors.push({ field: 'E-Mail', message: 'Formato no válido.' });
                }

                // Agregar validadores adicionales
                if ($("#password").val().trim() === '') {
                    errors.push({ field: 'Contraseña', message: 'Complete la contraseña.' });
                }
                if ($("#password").val().length < 5 || $("#password").val().length > 60) {
                    errors.push({ field: 'Contraseña', message: 'Contraseña Longitug debe estar entre 5 y 60 longitud de caracteres.' });
                }
                if (!/^[a-zA-Z0-9`!"?$%^&*()_+\-={}[\]:;@~#|<,>.?\'/\\]*$/.test($("#password").val())) {
                    errors.push({ field: 'Contraseña', message: 'Su clave puede unicamente contener letras, numeros y los siguientes caracteres: ` ! \" ? $ ? % ^ & * ( ) _ - + = { [ } ] : ; @ ~ # | < , > . ? \' / \\ ' });
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
                    ).join('<br>');

                    Swal.fire({
                        title: 'Errores de validación',
                        html: `<div style="text-align: left;">${errorHtml}</div>`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar',                        
                        confirmButtonColor: '#2778c4',

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
                        // Si hay errores de validación del servidor
                        let errorMessages = Object.entries(data.errors).map(([field, messages], index) =>
                            `<div style="margin-bottom: 10px;"><b>${index + 1}. ${field}:</b> ${messages.join(', ')}</div>`
                        ).join('<br>');

                        Swal.fire({
                            title: 'Errores de validación',
                            html: `<div style="text-align: left;">${errorMessages}</div>`,
                            icon: 'error',
                            confirmButtonText: 'Aceptar',                        
                            confirmButtonColor: '#2778c4',

                        });
                    } else if (data.message) {
                        // Si hay un mensaje de éxito
                        Swal.fire({
                            title: '¡Éxito!',
                            text: data.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.reload(); // Recargar la página después de 2 segundos
                        });
                    } else {
                        // Si no hay mensaje de éxito ni errores, mostrar un error genérico
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al registrar el cliente.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar', 
                            confirmButtonColor: '#2778c4',

                        });
                    }
                })
                .catch(error => {
                    // Si hay un error en la solicitud AJAX
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al procesar la solicitud.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',                         
                        confirmButtonColor: '#2778c4',

                    });
                });
        });
    });
</script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->


</body>

</html>
