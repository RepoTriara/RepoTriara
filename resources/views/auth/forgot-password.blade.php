<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Perdi la clave &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
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

<body class="reset-password backend">
    <div class="container-custom">
        <header id="header" class="navbar navbar-static-top navbar-fixed-top header_unlogged">
            <div class="navbar-header text-center">
                <span class="navbar-brand">
                    Repositorio </span>
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
                        <div class="white-box">
                            <div class="white-box-interior">
                                <form action="reset-password.php" name="resetpassword" method="post" role="form">
                                    <fieldset>
                                        <input type="hidden" name="form_type" id="form_type" value="new_request" />

                                        <div class="form-group">
                                            <label for="reset_password_email">E-Mail</label>
                                            <input type="text" name="reset_password_email" id="reset_password_email"
                                                class="form-control" />
                                        </div>

                                        <p>Por favor ingrese su cuenta de E-mail. Usted recibira un link para continuar
                                            el proceso</p>

                                        <div class="inside_form_buttons">
                                            <button type="submit" name="submit"
                                                class="btn btn-wide btn-primary">Solicite una nueva contraseña</button>
                                        </div>
                                    </fieldset>
                                </form>

                                <div class="login_form_links">
                                    <p><a href="{{ route('login') }}" target="_self">Regresar a la pagina anterior.</a>
                                    </p>
                                </div>
                            </div>
                        </div> <!-- container-custom -->
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
            <script src="{{ asset('includes/js/chosen/chosen.jquery.min.js') }}"></script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->

</body>

</html>
