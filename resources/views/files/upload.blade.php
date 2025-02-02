<!DOCTYPE html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Subir archivos &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png" sizes="32x32') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png" sizes="152x152') }}">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="upload-from-computer logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @if (Auth::user()->level == 0)
                @include('layouts.app_level0')
            @else
                @include('layouts.app')
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Subir archivos</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <p>
                        <div class="alert alert-info">Haz clic en Añadir archivos para seleccionar todos los archivos
                            que quieras subir, y luego haga clic en continuar. En el siguiente paso, podrá establecer un
                            nombre y descripción de cada archivo cargado. Recuerde que el tamaño maximo permitido por
                            archivo (en mb.) es <strong>2048</strong></div>
                        </p>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                var totalFiles = 0; // Contador para archivos que se están subiendo
                                var uploadedFiles = 0; // Contador para archivos subidos correctamente
                                var isUploading = false; // Variable para rastrear si se está subiendo algún archivo

                                var uploader = $("#uploader").pluploadQueue({
                                    runtimes: 'html5,flash,silverlight,html4',
                                    url: '{{ route('files.upload_process') }}',
                                    max_file_size: '2048mb',
                                    chunk_size: '1mb', // Ajusta el tamaño de los fragmentos a 1 MB
                                    multipart: true,
                                    multipart_params: {
                                        _token: '{{ csrf_token() }}',
                                    },
                                    filters: [{
                                        title: "Archivos permitidos",
                                        extensions: "7z,ace,ai,avi,bin,bmp,bz2,cdr,doc,docm,docx,eps,fla,flv,gif,gz,gzip,htm,html,iso,jpeg,jpg,mp3,mp4,mpg,odt,oog,ppt,pptx,pptm,pps,ppsx,pdf,png,psd,rar,rtf,tar,tif,tiff,tgz,txt,wav,xls,xlsm,xlsx,xz,zip",
                                    }],
                                    init: {
                                        FilesAdded: function(up, files) {
                                            totalFiles += files
                                            .length; // Aumentamos el total de archivos que se van a subir
                                            console.log("Archivos añadidos: ", files);
                                            $('#btn-submit').prop('disabled', false);
                                        },
                                        BeforeUpload: function(up, file) {
                                            isUploading = true; // Comienza la subida
                                            console.log("Subiendo archivo:", file.name);
                                        },
                                        FileUploaded: function(up, file, info) {
                                            console.log("Archivo subido:", file.name);
                                            console.log("Respuesta del servidor:", info.response);
                                            var response = JSON.parse(info.response);

                                            if (response.success) {
                                                uploadedFiles++; // Aumentamos el contador de archivos subidos correctamente
                                                // Si todos los archivos han sido subidos, realizamos la redirección
                                                if (uploadedFiles === totalFiles) {
                                                    isUploading = false; // Termina la subida
                                                    // Realizar la redirección a la vista upload_process
                                                    window.location.href = response.redirect;
                                                }
                                            }
                                        },
                                        UploadComplete: function(up, files) {
                                            console.log("Todos los archivos subidos.");
                                            isUploading = false; // Termina la subida
                                            $('#btn-submit').prop('disabled', true); // Deshabilitar el botón de envío
                                            up
                                        .stop(); // Detener el cargador (en caso de que haya más fragmentos por cargar)
                                        },
                                        Error: function(up, err) {
                                            console.error("Error en la carga:", err.message);
                                            alert("Error en la carga: " + err.message);
                                        }
                                    }
                                });

                                var uploaderInstance = $("#uploader").pluploadQueue();

                                $('#btn-submit').on('click', function(e) {
                                    e.preventDefault();

                                    // Comienza la carga de archivos solo si hay archivos para cargar
                                    if (uploaderInstance.files.length > 0) {
                                        uploaderInstance.start(); // Comienza la carga de archivos
                                    } else {
                                        alert('Por favor, selecciona al menos un archivo para subir.');
                                    }
                                });

                                // Deshabilitar el botón de envío si no hay archivos
                                $('#btn-submit').prop('disabled', true);

                                // Evento beforeunload para mostrar un aviso si el usuario intenta salir durante la subida
                                window.addEventListener('beforeunload', function(event) {
                                    if (isUploading) {
                                        event.preventDefault();
                                        event.returnValue =
                                            '¿Estás seguro de que quieres salir? Perderás el progreso de la subida de archivos.';
                                    }
                                });
                            });
                        </script>

                        <form action="{{ route('files.upload_process') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Input de archivos oculto -->
                            <input type="file" name="uploaded_files[]" id="uploaded_files" multiple
                                style="display: none;">

                            <!-- Plupload -->
                            <div id="uploader">
                                <div class="message message_error">
                                    <p>Su navegador no soporta HTML5, Flash o Silverlight. Por favor, actualícelo o
                                        instale Adobe Flash o Silverlight para continuar.</p>
                                </div>
                            </div>

                            <div class="after_form_buttons">
                                <button type="button" name="Submit" class="btn btn-wide btn-primary"
                                    id="btn-submit">Subir archivos</button>
                            </div>
                        </form>
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
            <script src="{{ asset('includes/js/browserplus-min.js') }}"></script>
            <script src="{{ asset('includes/plupload/js/plupload.full.js') }}"></script>
            <script src="{{ asset('includes/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js') }}"></script>
        </div> <!-- main_content -->
    </div> <!-- container-custom -->

</body>

</html>
