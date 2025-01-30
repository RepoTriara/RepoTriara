<!doctype html>
<html lang="es_CO">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>Información de archivo &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico')}}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png')}}" sizes="152x152">
    <script src="{{ asset('includes/js/jquery.1.12.4.min.js')}}"></script>
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/social-login.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.bootstrap.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css')}}" />
</head>
 
<body class="download logged-in logged-as-admin backend">
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
                    <div class="col-xs-12 col-sm-12 col-lg-6 col-lg-offset-3">
                        <div class="row">
                            <div class="col-xs-12 branding_unlogged">
                                <img src="{{ asset('img/custom/logo/logo-claro.png')}}" alt="Repositorio" />
                            </div>
                        </div>
                        <div class="white-box">
                            <div class="white-box-interior">
                                <div class="text-center">
                                    <h3>Información de archivo</h3>
                                </div>
 
                                @if(isset($error))
                                    <!-- Si hay un error, mostrar el mensaje de acceso denegado -->
                                    <div class="alert alert-danger">
                                        <strong>Acceso Denegado:</strong> {{ $error }}
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p>El siguiente archivo está listo para descargar:</p>
                                        <h3>{{ $file->filename }}</h3>
                                        <div class="download_description">
                                            Cordial saludo <br />
                                        </div>
 
                                        <!-- Mostrar el original_url sin interacción -->
                                        <p><strong>URL Original:</strong> {{ $file->original_url }}</p>
 
                                        <a href="{{ route('file.directDownload', ['id' => $file->id]) }}" class="btn btn-primary">
                                            Descargar archivo
                                        </a>
                                    </div>
                                @endif
 
                            </div>
                        </div>
 
                        <div class="login_form_links">
                            <p><a href="{{ route('login') }}" target="_self">Regrese al sitio de inicio</a></p>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container-fluid -->
 
            <footer>
                <div id="footer">
                    Claro Colombia
                </div>
            </footer>
 
            <script src="https://repo.triara.co/repositorio/assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/jquery.validations.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/jquery.psendmodal.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/jen/jen.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/js.cookie.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/main.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/js.functions.php"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/chosen/chosen.jquery.min.js"></script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->
</body>
</html