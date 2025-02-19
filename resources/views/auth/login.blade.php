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

                                        <!-- Campo de contraseña -->
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror" required
                                                aria-describedby="passwordHelp" />
                                            <small id="passwordHelp" class="form-text text-muted">
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

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.classList.add('btn-disabled'); // Deshabilitar el botón
                submitBtn.textContent = ''; // Limpiar el texto del botón
                submitBtn.classList.add('loading'); // Agregar la animación

                // Simular un retraso de 3 segundos antes de enviar el formulario
                setTimeout(function () {
                    submitBtn.classList.remove('loading'); // Detener la animación
                    submitBtn.textContent = 'Ingresar'; // Restaurar el texto del botón
                    submitBtn.classList.remove('btn-disabled'); // Habilitar el botón
                    document.getElementById('loginForm').submit(); // Enviar el formulario
                }, 3000); // Retraso de 3 segundos
            });
        </script>
    </div>
</body>

</html>
