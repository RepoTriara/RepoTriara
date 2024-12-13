<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title>Tablero &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}" />
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
				<div class="system_msg update_msg">
					<div class="row">
						<div class="col-sm-8">
							<strong>Actualización disponible</strong> ProjectSend 1720 has been released
						</div>
						<div class="col-sm-4 text-right">
							<a href="https://www.projectsend.org/download/13240/?tmstv=1733934438" class="btn btn-default btn-xs" target="_blank">Descarga</a> <a href="https://www.projectsend.org/change-log-detail/projectsend-r1720/" target="_blank" class="btn btn-default btn-xs">Changelog</a>
						</div>
					</div>
				</div>

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
							$(document).ready(function() {
								setInterval(function() {
									// Send a keep alive action every 1 minute
									var timestamp = new Date().getTime()
									$.ajax({
										type: 'GET',
										cache: false,
										url: 'public/includes/ajax-keep-alive.php',
										data: 'timestamp=' + timestamp,
										success: function(result) {
											var dummy = result;
										}
									});
								}, 1000 * 60);
							});

							$(function() {
								$("#uploader").pluploadQueue({
									runtimes: 'html5,flash,silverlight,html4',
									url: 'process-upload.php',
									max_file_size: '2048mb',
									chunk_size: '1mb',
									multipart: true,
									filters: [{
										title: "Allowed files",
										extensions: "7z,ace,ai,avi,bin,bmp,bz2,cdr,doc,docm,docx,eps,fla,flv,gif,gz,gzip,htm,html,iso,jpeg,jpg,mp3,mp4,mpg,odt,oog,ppt,pptx,pptm,pps,ppsx,pdf,png,psd,rar,rtf,tar,tif,tiff,tgz,txt,wav,xls,xlsm,xlsx,xz,zip"
									}],
									flash_swf_url: 'includes/plupload/js/plupload.flash.swf',
									silverlight_xap_url: 'includes/plupload/js/plupload.silverlight.xap',
									preinit: {
										Init: function(up, info) {
											$('#uploader_container').removeAttr("title");
										}
									}
									/*
									,init : {
										QueueChanged: function(up) {
											var uploader = $('#uploader').pluploadQueue();
											uploader.start();
										}
									}
									*/
								});

								var uploader = $('#uploader').pluploadQueue();

								$('form').submit(function(e) {

									if (uploader.files.length > 0) {
										uploader.bind('StateChanged', function() {
											if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
												$('form')[0].submit();
											}
										});

										uploader.start();

										$("#btn-submit").hide();
										$(".message_uploading").fadeIn();

										uploader.bind('FileUploaded', function(up, file, info) {
											var obj = JSON.parse(info.response);
											var new_file_field = '<input type="hidden" name="finished_files[]" value="' + obj.NewFileName + '" />'
											$('form').append(new_file_field);
										});

										return false;
									} else {
										alert('Usted debe seleccionar al meno una archivo para cargar.');
									}

									return false;
								});

								window.onbeforeunload = function(e) {
									var e = e || window.event;

									console.log('state? ' + uploader.state);

									// if uploading
									if (uploader.state === 2) {
										//IE & Firefox
										if (e) {
											e.returnValue = 'Are you sure? Files currently being uploaded will be discarded if you leave this page.';
										}

										// For Safari
										return 'Are you sure? Files currently being uploaded will be discarded if you leave this page.';
									}

								};
							});
						</script>

						<form action="upload-process-form.php" name="upload_by_client" id="upload_by_client" method="post" enctype="multipart/form-data">
							<input type="hidden" name="uploaded_files" id="uploaded_files" value="" />
							<div id="uploader">
								<div class="message message_error">
									<p>Su navegador no soporta HTML5, Flash o Silverlight. Por favor, actualicelo o instalar Adobe Flash o Silverlight para continuar.</p>
								</div>
							</div>
							<div class="after_form_buttons">
								<button type="submit" name="Submit" class="btn btn-wide btn-primary" id="btn-submit">Subir archivos</button>
							</div>
							<div class="message message_info message_uploading">
								<p>¡Tus archivos están siendo subidos! Los indicadores de progreso pueden tardar un poco en actualizarse, pero todavía se está trabajando tras bamabalinas.</p>
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
			<script src="{{asset( 'includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			<script src="{{asset('includes/js/flot/jquery.flot.min.js')}}"></script>
			<script src="{{asset('includes/js/flot/jquery.flot.resize.min.js')}}"></script>
			<script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
		</div> <!-- container-custom -->

</body>

</html>