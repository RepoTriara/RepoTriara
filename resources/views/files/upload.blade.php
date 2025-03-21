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
                            nombre y descripción de cada archivo cargado. Recuerde que el tamaño máximo permitido por
                            archivo (en MB.) es <strong>2048</strong>. Además, los archivos expirarán un año posterior a
                            la fecha de subida.</div>
                        </p>
                     <script type="text/javascript">
    $(document).ready(function() {
        var totalFiles = 0; // Contador para archivos que se están subiendo
        var uploadedFiles = []; // Array para almacenar los nombres de los archivos subidos correctamente
        var isUploading = false; // Variable para rastrear si se está subiendo algún archivo
        var uploadSessionId = '{{ session('upload_session_id') }}';

        // Obtener el tamaño máximo permitido para el usuario (en MB)
        var maxFileSizeMB = {{ Auth::user()->max_file_size > 0 ? Auth::user()->max_file_size : 2048 }};
        var maxFileSizeBytes = maxFileSizeMB * 1024 * 1024; // Convertir MB a Bytes

        var uploader = $("#uploader").pluploadQueue({
            runtimes: 'html5,flash,silverlight,html4',
            url: '{{ route('files.upload_process') }}',
            max_file_size: '9999mb', // Desactivamos la validación interna de Plupload
            chunk_size: '1mb',
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
                    var validFiles = [];

                    $.each(files, function(i, file) {
                        if (file.size > maxFileSizeBytes) {
                            alert("El archivo '" + file.name + "' supera el tamaño máximo permitido de " + maxFileSizeMB + " MB.");
                            up.removeFile(file); // Elimina el archivo antes de que Plupload lo procese
                        } else {
                            validFiles.push(file);
                        }
                    });

                    if (validFiles.length > 0) {
                        totalFiles += validFiles.length;
                        $('#btn-submit').prop('disabled', false);

                        if (!uploadSessionId) {
                            uploadSessionId = generateUploadSessionId();
                            saveUploadSessionId(uploadSessionId);
                        }
                    }
                },
                BeforeUpload: function(up, file) {
                    isUploading = true;
                    up.settings.multipart_params.upload_session_id = uploadSessionId; // Add session ID to params
                    console.log("Subiendo archivo:", file.name);
                },
                FileUploaded: function(up, file, info) {
                    console.log("Archivo subido:", file.name);
                    console.log("Respuesta del servidor:", info.response);
                    var response = JSON.parse(info.response);

                    if (response.success) {
                        uploadedFiles.push(file.name); // Store the name of the successfully uploaded file
                        if (uploadedFiles.length === totalFiles) {
                            isUploading = false;
                            window.location.href = response.redirect;
                        }
                    }
                },
                UploadComplete: function(up, files) {
                    console.log("Todos los archivos subidos.");
                    isUploading = false;
                    $('#btn-submit').prop('disabled', true);
                    up.stop();
                },
                Error: function(up, err) {
                    console.error("Error en la carga:", err.message);
                    alert("Error en la carga: " + err.message);
                    isUploading = false;
                    clearTempFiles(uploadSessionId, uploadedFiles); // Clean even on error
                }
            }
        });

        var uploaderInstance = $("#uploader").pluploadQueue();

        $('#btn-submit').on('click', function(e) {
            e.preventDefault();

            if (uploaderInstance.files.length > 0) {
                uploaderInstance.start();
            } else {
                alert('Por favor, selecciona al menos un archivo para subir.');
            }
        });

        $('#btn-submit').prop('disabled', true);

        function generateUploadSessionId() {
            return 'upload_' + Date.now();
        }

        function saveUploadSessionId(id) {
            $.ajax({
                url: '/save-upload-session-id', // Your route to save the session ID
                type: 'POST',
                data: {
                    upload_session_id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
            });
        }

        function clearTempFiles(sessionId, uploadedFiles = []) {
            if (!sessionId) return;

            fetch("{{ route('files.clearTemporaryFiles') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    upload_session_id: sessionId,
                    uploaded_files: uploadedFiles // Send the array of uploaded file names
                })
            })
            .then(response => response.json())
            .then(data => console.log("Archivos temporales eliminados:", data.message))
            .catch(error => console.error("Error al eliminar archivos:", error));
        }

        $('#btn-cancel').on('click', function(e) {
            e.preventDefault();
            if (isUploading) {
                uploaderInstance.stop();
                isUploading = false;
            }
            clearTempFiles(uploadSessionId, uploadedFiles); // Clean on cancel
            $('#btn-submit').prop('disabled', true);
            setTimeout(function() {
                location.reload(); // Recargar la página después de un pequeño retraso
            }, 1000); // 1 segundo de retraso
        });

        window.addEventListener('beforeunload', function(event) {
            if (isUploading) {
                event.preventDefault();
                event.returnValue = '¿Estás seguro de que quieres salir? Perderás el progreso de la subida de archivos.';
                clearTempFiles(uploadSessionId, uploadedFiles); // Clean on unload
            }
        });
    });
</script>


                        <form action="{{ route('files.upload_process') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Input de archivos oculto -->
    <input type="file" name="uploaded_files[]" id="uploaded_files" multiple style="display: none;">
                            <!-- Plupload -->
                            <div id="uploader">
                                <div class="message message_error">
                                    <p>Su navegador no soporta HTML5, Flash o Silverlight. Por favor, actualícelo o
                                        instale Adobe Flash o Silverlight para continuar.</p>
                                </div>
                            </div>

                            <div class="after_form_buttons">
        <button type="button" name="Submit" class="btn btn-wide btn-primary" id="btn-submit">Subir archivos</button>
        <button type="button" name="Cancel" class="btn btn-wide btn-secondary" id="btn-cancel">Cancelar</button>
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
