<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Subir archivos &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png" sizes="32x32')}}">
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png" sizes="152x152')}}">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
</head>

<body class="upload-from-computer logged-in logged-as-admin menu_hidden backend">
	<div class="container-custom">



		<div class="main_content">
		@include('layouts.app')

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
						<div class="alert alert-info">Haz clic en Añadir archivos para seleccionar todos los archivos que quieras subir, y luego haga clic en continuar. En el siguiente paso, podrá establecer un nombre y descripción de cada archivo cargado. Recuerde que el tamaño maximo permitido por archivo (en mb.) es <strong>2048</strong></div>
						</p>

						<script type="text/javascript">
    $(document).ready(function () {
    var uploader = $("#uploader").pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: '{{ route('files.upload_process') }}', // Asegúrate de que apunte al controlador correcto
        max_file_size: '2048mb',
        chunk_size: '1mb', // Divide los archivos en fragmentos de 1 MB
        multipart: true,
        multipart_params: {
            _token: '{{ csrf_token() }}', // Token CSRF para seguridad
        },
        filters: [
            {
                title: "Archivos permitidos",
                extensions: "pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip",
            },
        ],
        init: {
            FilesAdded: function (up, files) {
                console.log("Archivos añadidos: ", files);
                $('#btn-submit').prop('disabled', false);
            },
            BeforeUpload: function (up, file) {
                console.log("Subiendo archivo:", file.name);
            },
            FileUploaded: function (up, file, info) {
                console.log("Archivo subido:", file.name);
            },
            UploadComplete: function (up, files) {
                alert("Todos los archivos han sido subidos correctamente.");
                console.log("Archivos subidos:", files);

                window.location.href = '{{ route("files.upload_process.view") }}';
            },
            Error: function (up, err) {
                console.error("Error en la subida:", err);
                alert("Error en la subida: " + err.message);
            }
        }
    });

    var uploaderInstance = $("#uploader").pluploadQueue();

    $('#btn-submit').on('click', function (e) {
        e.preventDefault();

        if (uploaderInstance.files.length > 0) {
            uploaderInstance.start();
        } else {
            alert('Por favor, selecciona al menos un archivo para subir.');
        }
    });

    window.onbeforeunload = function (e) {
        if (uploaderInstance.state === 2) {
            return 'Los archivos que se están subiendo se perderán si abandonas esta página.';
        }
    };

    $('#btn-submit').prop('disabled', true);
});

</script>



<form action="{{ route('files.upload_process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Input de archivos oculto -->
    <input type="file" name="uploaded_files[]" id="uploaded_files" multiple style="display: none;">

    <!-- Plupload -->
    <div id="uploader">
        <div class="message message_error">
            <p>Su navegador no soporta HTML5, Flash o Silverlight. Por favor, actualícelo o instale Adobe Flash o Silverlight para continuar.</p>
        </div>
    </div>

    <div class="after_form_buttons">
        <button type="button" name="Submit" class="btn btn-wide btn-primary" id="btn-submit">Subir archivos</button>
    </div>
</form>



					</div>

				</div> <!-- row -->
			</div> <!-- container-fluid -->

			<footer>
				<div id="footer">
					Claro Colombia </div>
			</footer>
			<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('includes/js/jquery.validations.js')}}"></script>
			<script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
			<script src="{{asset('includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			<script src="{{asset('includes/js/browserplus-min.js')}}"></script>
			<script src="{{asset('includes/plupload/js/plupload.full.js')}}"></script>
			<script src="{{asset('includes/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js')}}"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->

</body>

</html>
