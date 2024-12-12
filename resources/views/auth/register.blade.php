<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Registre una nueva cuenta &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/social-login.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}" />
</head>

<body class="register backend">
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
								<img src="{{asset('img/custom/logo/logo-claro.png')}}" alt="Repositorio" />
							</div>
						</div>
						<div class="white-box">
							<div class="white-box-interior">
								<script type="text/javascript">
									$(document).ready(function() {
										$("form").submit(function() {
											clean_form(this);

											is_complete(this.add_client_form_name, 'Llene el nombre');
											is_complete(this.add_client_form_user, 'Complete el usuario');
											is_complete(this.add_client_form_email, 'Llene el correo electrónico');
											is_length(this.add_client_form_user, 5, 60, 'Usuario Longitug debe estar entre 5 y 60 longitud de caracteres');
											is_email(this.add_client_form_email, 'Correo electrónico no válido');
											is_alpha_or_dot(this.add_client_form_user, 'El usuario debe ser alfanumérico y puede contener (a-z,A-Z,0-9,.).');
											is_number(this.add_client_form_maxfilesize, 'El tamaño deñ archivo debe ser un valor entero');

											is_complete(this.add_client_form_pass, 'Complete la contraseña');
											is_length(this.add_client_form_pass, 5, 60, 'Contraseña Longitug debe estar entre 5 y 60 longitud de caracteres');
											is_password(this.add_client_form_pass, 'Su clave puede unicamente contener letras, numeros y los siguientes caracteres: ` ! \" ? $ ? % ^ & * ( ) _ - + = { [ } ] : ; @ ~ # | < , > . ? \' / \\ ');

											if (show_form_errors() == false) {
												return false;
											}
										});
									});
								</script>
								<form method="POST" action="{{ route('register') }}" class="form-horizontal">
									@csrf

									<div class="form-group">
										<label for="name" class="col-sm-4 control-label">Nombre</label>
										<div class="col-sm-8">
											<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Su nombre completo" required>
											@error('name')
											<div class="text-danger mt-2">{{ $message }}</div>
											@enderror
										</div>
									</div>

									<div class="form-group">
										<label for="user" class="col-sm-4 control-label">Nombre de Usuario</label>
										<div class="col-sm-8">
											<input type="text" name="user" id="user" class="form-control" value="{{ old('user') }}" placeholder="Debe ser alfanumérico" required>
											@error('user')
											<div class="text-danger mt-2">{{ $message }}</div>
											@enderror
										</div>
									</div>

									<div class="form-group">
										<label for="email" class="col-sm-4 control-label">Correo Electrónico</label>
										<div class="col-sm-8">
											<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Ingrese un correo válido" required>
											@error('email')
											<div class="text-danger mt-2">{{ $message }}</div>
											@enderror
										</div>
									</div>

									<div class="form-group">
										<label for="password" class="col-sm-4 control-label">Contraseña</label>
										<div class="col-sm-8">
											<input type="password" name="password" id="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
											@error('password')
											<div class="text-danger mt-2">{{ $message }}</div>
											@enderror
										</div>
									</div>

									<div class="form-group">
										<label for="password_confirmation" class="col-sm-4 control-label">Confirmar Contraseña</label>
										<div class="col-sm-8">
											<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repite tu contraseña" required>
										</div>
									</div>

									<div class="form-group">
										<label for="phone" class="col-sm-4 control-label">Teléfono</label>
										<div class="col-sm-8">
											<input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="Opcional">
										</div>
									</div>

									<div class="form-group">
										<label for="address" class="col-sm-4 control-label">Dirección</label>
										<div class="col-sm-8">
											<input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="Opcional">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-8">
											<button type="submit" class="btn btn-primary">Registrar</button>
										</div>
									</div>
								</form>



								<div class="login_form_links">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<footer>
				<div id="footer">Claro Colombia 2024</div>
			</footer>
			@if ($errors->has('name'))
			<div class="text-danger">{{ $errors->first('name') }}</div>
			@endif

			<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('includes/js/jquery.validations.js')}}"></script>
			<script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
			<script src="{{asset('includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			<script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
		</div>
	</div>
</body>

</html>
