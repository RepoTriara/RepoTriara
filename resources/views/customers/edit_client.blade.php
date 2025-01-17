<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agregar cliente &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<script type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/jquery.1.12.4.min.js"></script>
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}" />
	<link rel="stylesheet" media="all" type="text/css"
		href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />

</head>

<body class="add_client logged-in logged-as-admin menu_hidden backend">
	<div class="container-custom">

		<div class="main_content">
			@include('layouts.app')
			<div class="container-fluid"></div>
			<div class="row">
				<div id="section_title">
					<div class="col-xs-12">
						<h2>Editar cliente</h2>
					</div>
				</div>
			</div>
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-6">
					<div class="white-box">
						<div class="white-box-interior">
							<script type="text/javascript">
								$(document).ready(function () {
									$("form").submit(function () {
										clean_form(this);
										is_complete(this.add_client_form_name, 'Llene el nombre');
										is_complete(this.add_client_form_user, 'Complete el usuario');
										is_complete(this.add_client_form_email, 'Llene el correo electrónico');
										is_length(this.add_client_form_user, 5, 60, 'Usuario Longitug debe estar entre 5 y 60 longitud de caracteres');
										is_email(this.add_client_form_email, 'Correo electrónico no válido');
										is_alpha_or_dot(this.add_client_form_user, 'El usuario debe ser alfanumérico y puede contener (a-z,A-Z,0-9,.).');
										is_number(this.add_client_form_maxfilesize, 'El tamaño deñ archivo debe ser un valor entero');
										is_complete(this.add_client_form_pass, 'Complete la contraseña');
										//is_complete(this.add_client_form_pass2,'la verificación de la contraseña n fue completa');
										is_length(this.add_client_form_pass, 5, 60, 'Contraseña Longitug debe estar entre 5 y 60 longitud de caracteres');
										is_password(this.add_client_form_pass, 'Su clave puede unicamente contener letras, numeros y los siguientes caracteres: ` ! \" ? $ ? % ^ & * ( ) _ - + = { [ } ] : ; @ ~ # | < , > . ? \' / \\ ');
										//is_match(this.add_client_form_pass,this.add_client_form_pass2,'La contraseña no coincide ');
										// show the errors or continue if everything is ok
										if (show_form_errors() == false) {
											return false;
										}
									});
								});
							</script>
							<form method="POST" action="{{ route('customer_manager.update', $client->id) }}"
								class="form-horizontal">
								@csrf
								@method('PUT')

								<div class="form-group">
									<label for="name" class="col-sm-4 control-label">Nombre</label>
									<div class="col-sm-8">
										<input type="text" name="name" id="name" class="form-control required"
											placeholder="Nombre completo del usuario"
											value="{{ old('name', $client->name) }}" />
										@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group">
									<label for="user" class="col-sm-4 control-label">Ingresar nombre de usuario</label>
									<div class="col-sm-8">
										<input type="text" name="user" id="user" placeholder="Usuario de RED"
											class="form-control required" maxlength="60"
											value="{{ old('user', $client->user) }}"
											placeholder="Debe ser alfanumérico" />
										@error('user')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group">
									<label for="add_client_form_pass" class="col-sm-4 control-label">Contraseña</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input name="password" id="password" class="form-control password_toggle"
												type="password" maxlength="60"
												value=""  />
											@error('password')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
											<div class="input-group-btn password_toggler">
												<button type="button" class="btn pass_toggler_show"><i
														class="glyphicon glyphicon-eye-open"></i></button>
											</div>
										</div>
										<button type="button" name="generate_password" id="generate_password"
											class="btn btn-default btn-sm btn_generate_password"
											data-ref="add_client_form_pass" data-min="20" data-max="20">Generar</button>
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-4 control-label">E-Mail</label>
									<div class="col-sm-8">
										<input type="text" name="email" id="email" class="form-control required"
											value="{{ old('email', $client->email) }}"
											placeholder="Debe ser válido y único" required />
										@error('email')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
								</div>

								<div class="form-group">
									<label for="address" class="col-sm-4 control-label">Dirección</label>
									<div class="col-sm-8">
										<input type="text" name="address" id="address" class="form-control"
											value="{{ old('address', $client->address) }}" placeholder="Opcional" />
										@error('address')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-4 control-label">Teléfono</label>
									<div class="col-sm-8">
										<input type="text" name="phone" id="phone" class="form-control"
											value="{{ old('phone', $client->phone) }}" placeholder="Opcional"
											 />
										@error('phone')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group">
									<label for="contact" class="col-sm-4 control-label">Nombre de contacto
										interno</label>
									<div class="col-sm-8">
										<input type="text" name="contact" id="contact" class="form-control"
											value="{{ old('contact', $client->contact) }}"  />
										@error('contact')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group">
									<label for="add_client_form_maxfilesize" class="col-sm-4 control-label">Máximo
										tamaño de subida</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" name="max_file_size" id="max_file_size"
												class="form-control"
												value="{{ old('max_file_size', $client->max_file_size) }}" required />
											<span class="input-group-addon">mb</span>
											@error('max_file_size')
												<div class="text-danger mt-2">{{ $message }}</div>
											@enderror
										</div>
										<p class="field_note">Ponga 0 como limite predeterminado (2048 mb)</p>
									</div>
								</div>

								<div class="form-group assigns">
									<label for="group_request" class="col-sm-4 control-label">Grupos</label>
									<div class="col-sm-8">
										<select multiple="multiple" name="group_request[]" id="group-select"
											class="form-control chosen-select"
											data-placeholder="Seleccione una o mas opciones. Escriba para buscar">
											@foreach ($groups as $group)
												<option value="{{ $group->id }}" {{ in_array($group->id, $associatedGroups) ? 'selected' : '' }}>
													{{ $group->name }}
												</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-4">
										<label for="active">
											<input type="checkbox" name="active" id="active" value="1" {{ old('active', $client->active) == 1 ? 'checked' : '' }} /> Activo (usuario puede
											ingresar al sistema)
										</label>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-4">
										<label for="add_client_form_notify_upload">
											<input type="checkbox" name="notify" id="notify" value="1" {{old('notify', $client->notify) == 0 ? 'checked' : ''}}> Notificar nuevos
											archivos por correo </label>
										@error('notify_upload')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
								</div>

								<div class="inside_form_buttons">
									<button type="submit" name="submit" class="btn btn-wide btn-primary">Actualizar
										cliente</button>
								</div>
								<div class="alert alert-info">La información de cuenta será enviada al correo
									electrónico suministrado </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
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
		<script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
		<script>
			$(document).ready(function () {
				$('.chosen-select').chosen({
					no_results_text: "No se encontraron resultados para",
					width: "100%"
				});
			});
		</script>
	</div> <!-- main_content -->
	</div> <!-- container-custom -->

</body>

</html>
