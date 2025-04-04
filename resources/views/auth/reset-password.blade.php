<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Restablecer Contraseña &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/social-login.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="reset-password backend">
    <div class="container-custom">
        <header id="header" class="navbar navbar-static-top navbar-fixed-top header_unlogged">
            <div class="navbar-header text-center">
                <span class="navbar-brand">Repositorio</span>
            </div>
        </header>

        <div class="main_content_unlogged">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-4 col-lg-offset-4">
                        <div class="row">
                            <div class="col-xs-12 branding_unlogged">
                                <img src="{{ asset('img/custom/logo/logo-claro.png') }}" alt="Repositorio" />
                            </div>
                        </div>

                        <!-- Se eliminaron los bloques de alerta HTML en favor de SweetAlert2 -->

                        <div class="white-box">
                            <div class="white-box-interior">
                                <!-- Formulario de restablecimiento de contraseña -->
                                <form method="POST" action="{{ route('password.store') }}">
                                    @csrf

                                    <!-- Token de restablecimiento -->
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <fieldset>
                                        <!-- Correo Electrónico -->
                                        <div class="form-group">
                                            <label for="email">Correo Electrónico</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $request->email) }}" required autofocus
                                                class="form-control" autocomplete="username" />
                                        </div>

                                        <!-- Nueva Contraseña -->
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password" required
                                                    class="form-control" autocomplete="new-password" maxlength="60" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default toggle-password" data-target="#password">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Confirmar Contraseña -->
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmar Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control" autocomplete="new-password" maxlength="60" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default toggle-password" data-target="#password_confirmation">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="inside_form_buttons text-center">
                                            <button type="submit" class="btn btn-wide btn-primary">
                                                Restablecer Contraseña
                                            </button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div> <!-- Fin white-box -->
                    </div>
                </div> <!-- Fin row -->
            </div> <!-- Fin container-fluid -->

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
           <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Insertar estilos personalizados para SweetAlert2
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

        // Si existen errores de validación, construir el listado enumerado
        @if ($errors->any())
            let errorIndex = 1;
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                @php
                    $colonPos = strpos($error, ':');
                @endphp
                @if ($colonPos !== false)
                    @php
                        $beforeColon = trim(substr($error, 0, $colonPos));
                        $colon = ':';
                        $afterColon = substr($error, $colonPos + 1);
                    @endphp
                    errorMessages += `<div class="compact-error-line">
                        <span class="error-number">${errorIndex++}.</span>
                        <span class="error-text">
                            <span class="bold-section">{!! addslashes($beforeColon . $colon) !!}</span>{!! addslashes($afterColon) !!}
                        </span>
                    </div>`;
                @else
                    errorMessages += `<div class="compact-error-line">
                        <span class="error-number">${errorIndex++}.</span>
                        <span class="error-text">{!! addslashes($error) !!}</span>
                    </div>`;
                @endif
            @endforeach

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
        @endif

        // Si existe un mensaje de éxito en la sesión, se muestra
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session("status") }}',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#2778c4'
            });
        @endif

        // Agregar funcionalidad al botón de toggle para visualizar/ocultar la contraseña
        $('.toggle-password').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var input = $(target);
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            } else {
                input.attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i>');
            }
        });

        // Evitar que se ingresen espacios en los campos de contraseña
        $('input[type="password"]').on('keypress', function(e) {
            if(e.which === 32) { // Código de la tecla espacio
                e.preventDefault();
            }
        });
    });
</script>
        </div> <!-- Fin main_content_unlogged -->
    </div> <!-- Fin container-custom -->
</body>

</html>
