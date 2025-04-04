<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                                <input name="password" id="password" maxlength="60"
                                                    class="form-control  password_toggle" type="password" placeholder="Contraseña" />
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
                                                 style="background-color: #004b92; color: white;"
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
                                                <span class="input-group-addon">MB</span>
                                            </div>
                                            <p class="field_note">Ponga 0 como límite predeterminado (2048 MB)</p>
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
                                                Envíe correo de bienvenida
                                            </label>
                                        </div>
                                    </div>




                                    <div class="inside_form_buttons">
                                        <button type="submit" name="submit" id="guardar"
                                            class="btn btn-wide btn-primary">Adicionar usuario</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar estilos dinámicamente
        const style = document.createElement('style');
        style.textContent = `
            .compact-swal {
                max-width: 500px;
                padding: 1em;
            }
            .compact-title {
                text-align: center;
                margin-bottom: 8px !important;
                font-size: 1.3em;
                padding-bottom: 0;
            }
            .compact-content {
                padding: 0 1em;
                margin-top: 5px !important;
            }
            .compact-errors-container {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
            .compact-error-line {
                font-size: 0.95em;
                text-align: left;
                line-height: 1.4;
                display: flex;
                align-items: flex-start;
            }
            .error-number {
                flex-shrink: 0;
                margin-right: 5px;
                font-weight: bold;
            }
            .error-text {
                word-break: break-word;
            }
            .bold-section {
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);

        const form = document.querySelector('form[action="{{ route('users.store') }}"]');
        const button = document.getElementById('guardar');

        if (!button || !form) {
            console.error('Elementos no encontrados');
            return;
        }

        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Mostrar loader
            Swal.fire({
                title: 'Procesando',
                html: 'Por favor espere...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: new FormData(form),
            })
            .then(response => {
                if (response.status === 422) {
                    return response.json().then(data => Promise.reject(data));
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if (data.message) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.close();
                if (error.errors) {
                    let errorIndex = 1;
                    const errorMessages = Object.entries(error.errors)
                        .map(([field, messages]) => {
                            const message = messages[0];
                            const colonIndex = message.indexOf(':');
                            
                            if (colonIndex !== -1) {
                                const beforeColon = message.substring(0, colonIndex);
                                const colon = ':';
                                const afterColon = message.substring(colonIndex + 1);
                                
                                return `
                                    <div class="compact-error-line">
                                        <span class="error-number">${errorIndex++}.</span>
                                        <span class="error-text">
                                            <span class="bold-section">${beforeColon}${colon}</span>${afterColon}
                                        </span>
                                    </div>
                                `;
                            } else {
                                return `
                                    <div class="compact-error-line">
                                        <span class="error-number">${errorIndex++}.</span>
                                        <span class="error-text">${message}</span>
                                    </div>
                                `;
                            }
                        })
                        .join('');

                    Swal.fire({
                        title: 'Errores de validación',
                        html: `<div class="compact-errors-container">${errorMessages}</div>`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2778c4',
                        customClass: {
                            popup: 'compact-swal',
                            title: 'compact-title',
                            htmlContainer: 'compact-content'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: error.message || 'Hubo un problema al registrar el usuario. Verifica los datos ingresados o inténtalo nuevamente.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2778c4'
                    });
                }
            });
        });
    });
</script>

</script>

        </div> <!-- main_content -->
    </div> <!-- container-custom -->


</body>

</html>
