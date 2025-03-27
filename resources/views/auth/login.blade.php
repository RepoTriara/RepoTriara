<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inicie Sesi&oacute;n &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/social-login.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/styles.css') }}" />


</head>

<body class="body login backend">
    <div class="container-custom">
        <header id="header" class="navbar navbar-static-top navbar-fixed-top header_unlogged">
            <div class="navbar-header text-center">
                <span class="navbar-brand">
                    Repositorio
                </span>
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
                        <!-- Manejo de errores de validación -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="white-box">
                            <div class="white-box-interior">
                                <!-- Mensajes de éxito o error generales -->
                                <div class="ajax_response alert"></div>

                                <!-- Formulario de inicio de sesión -->
                                <form method="POST" action="{{ route('login') }}" id="loginForm">
                                    @csrf
                                    <input type="hidden" name="do" value="login">
                                    <fieldset>
                                        <!-- Campo de correo electrónico o usuario -->
                                        <div class="form-group">
                                            <label for="login">E-Mail o Usuario</label>
                                            <input type="text" name="login" id="login"
                                                value="{{ old('login') }}"
                                                class="form-control @error('login') is-invalid @enderror" required
                                                autofocus aria-describedby="loginHelp" />
                                            <small id="loginHelp" class="form-text text-muted">
                                                Ingrese su correo electrónico o nombre de usuario.
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password" required class="form-control" autocomplete="new-password" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default toggle-password" data-target="#password">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </span>
                                            </div>
                                             <small id="loginHelp" class="form-text text-muted">
                                                Ingrese su contraseña.
                                            </small>
                                        </div>
                                        <!-- Botón de envío -->
                                        <div class="inside_form_buttons">
                                            <button type="submit" id="submitBtn"
                                                class="btn btn-wide btn-primary">Ingresar</button>
                                        </div>
                                    </fieldset>
                                </form>

                                <!-- Enlaces adicionales -->
                                <div class="login_form_links">
                                    <p id="reset_pass_link">
                                        ¿Olvidó su contraseña? <a href="{{ route('password.request') }}">Cámbiela
                                            aquí.</a>
                                    </p>
                                    <p>
                                        Si necesitas una cuenta, por favor radica tu solicitud a través de nuestros
                                        canales de soporte técnico.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- container-fluid -->
            </div> <!-- main_content -->
        </div> <!-- container-custom -->

        <footer>
            <div id="footer">
                Claro Colombia
            </div>
        </footer>

        <!-- Modal de Carga -->
        <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <!-- Barra de Progreso -->
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- Texto de Carga -->
                        <p class="mt-3">Iniciando sesión, por favor espere...</p>
                        <!-- Botón ficticio dentro del modal -->
                        <button class="btn modal-btn mt-3" disabled>Iniciando...</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
        <script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
        <script src="{{ asset('includes/js/jen/jen.js') }}"></script>
        <script src="{{ asset('includes/js/js.cookie.js') }}"></script>
        <script src="{{ asset('includes/js/main.js') }}"></script>
        <script src="{{ asset('includes/js/js.functions.php') }}"></script>
        <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
        <script>
            // Script para manejar la animación y el retraso
            document.getElementById('loginForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Evitar el envío inmediato del formulario

                // Mostrar el modal de carga
                $('#loadingModal').modal('show');

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.classList.add('btn-disabled'); // Deshabilitar el botón
                submitBtn.textContent = ''; // Limpiar el texto del botón
                submitBtn.classList.add('loading'); // Agregar la animación

                // Animación de la barra de progreso
                let progress = 0;
                const progressBar = $('.progress-bar');
                const interval = setInterval(function () {
                    progress += 10; // Incrementar el progreso
                    progressBar.css('width', progress + '%').attr('aria-valuenow', progress);

                    if (progress >= 100) {
                        clearInterval(interval); // Detener la animación

                        // Restaurar el botón y ocultar el modal después de 3 segundos
                        setTimeout(function () {
                            submitBtn.classList.remove('loading'); // Detener la animación
                            submitBtn.textContent = 'Ingresar'; // Restaurar el texto del botón
                            submitBtn.classList.remove('btn-disabled'); // Habilitar el botón

                            // Ocultar el modal de carga
                            $('#loadingModal').modal('hide');

                            // Enviar el formulario
                            document.getElementById('loginForm').submit();
                        }, 500); // Retraso breve antes de enviar el formulario
                    }
                }, 300); // Intervalo de tiempo para la animación
            });

            $(document).ready(function () {
                $('.toggle-password').on('click', function () {
                    var target = $(this).data('target');
                    var input = $(target);
                    var icon = $(this).find('i');

                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        input.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            });
        </script>
    </div>
</body>

</html>
