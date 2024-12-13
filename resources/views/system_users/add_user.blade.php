
<!doctype html>
<html lang="es_CO">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Agregue nuevos usuarios &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png" sizes="32x32')}}">
<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png" sizes="152x152')}}">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

				<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
			<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
			<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
			<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
</head>

<body class="users-add logged-in logged-as-admin menu_hidden backend">
	<div class="container-custom">
		<header id="header" class="navbar navbar-static-top navbar-fixed-top">
			<ul class="nav pull-left nav_toggler">
				<li>
					<a href="#" class="toggle_main_menu"><i class="fa fa-bars" aria-hidden="true"></i><span>Menú alternativo</span></a>
				</li>
			</ul>

			<div class="navbar-header">
				<span class="navbar-brand"><a href="https://www.projectsend.org/" target="_blank"></a> Repositorio</span>
			</div>

			<ul class="nav pull-right nav_account">
				<li id="header_welcome">
					<span> Erika Julieth Galindez Quinaya</span>
				</li>
				<li>
										<a href="https://repo.triara.co/repositorio/users-edit.php?id=626" class="my_account"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a>
				</li>
				<li>
					<a href="https://repo.triara.co/repositorio/process.php?do=logout" ><i class="fa fa-sign-out" aria-hidden="true"></i> Salir</a>
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
<li class="">
	<a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span></a>
</li>
<li class="separator"></li><li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/upload-from-computer.php"><span class="submenu_label">Subir</span></a>
		</li>
		<li class="divider"></li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/manage-files.php"><span class="submenu_label">Administrar archivos</span></a>
		</li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/upload-import-orphans.php"><span class="submenu_label">Buscar archivos huerfanos</span></a>
		</li>
		<li class="divider"></li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/categories.php"><span class="submenu_label">Categorías</span></a>
		</li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/clients-add.php"><span class="submenu_label">Añadir nuevo cliente</span></a>
		</li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/clients.php"><span class="submenu_label">Administración de clientes</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañias</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/groups-add.php"><span class="submenu_label">Añadir nueva compañia</span></a>
		</li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/groups.php"><span class="submenu_label">Administrar Compañias</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown current_nav">
	<a href="#" class="nav_top_level"><i class="fa fa-users fa-fw" aria-hidden="true"></i><span class="menu_label">Usuarios del Sistema</span></a>
	<ul class="dropdown_content">
		<li class="current_page">
			<a href="https://repo.triara.co/repositorio/users-add.php"><span class="submenu_label">Añadir nuevo usuario</span></a>
		</li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/users.php"><span class="submenu_label">Administrar usuarios</span></a>
		</li>
	</ul>
</li>
<li class="separator"></li><li class="separator"></li></ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">
				
				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Agregue nuevos usuarios</h2>
						</div>
					</div>
				</div>

				<div class="row">
<div class="col-xs-12 col-sm-12 col-lg-6">
	<div class="white-box">
		<div class="white-box-interior">
		
						
			
<script type="text/javascript">
	$(document).ready(function() {
		$("form").submit(function() {
			clean_form(this);

			is_complete(this.add_user_form_name,'Llene el nombre');
			is_complete(this.add_user_form_user,'Complete el usuario');
			is_complete(this.add_user_form_email,'Llene el correo electrónico');
			is_complete(this.add_user_form_level,'Nivel de usuario no fue especificado');
			is_length(this.add_user_form_user,5,60,'Usuario Longitug debe estar entre 5 y 60 longitud de caracteres');
			is_email(this.add_user_form_email,'Correo electrónico no válido');
			is_alpha_or_dot(this.add_user_form_user,'El usuario debe ser alfanumérico y puede contener (a-z,A-Z,0-9,.).');
			is_number(this.add_user_form_maxfilesize,'El tamaño deñ archivo debe ser un valor entero');
			
			
//						is_complete(this.add_user_form_pass,'Complete la contraseña');
						//is_complete(this.add_user_form_pass2,'la verificación de la contraseña n fue completa');
//						is_length(this.add_user_form_pass,5,60,'Contraseña Longitug debe estar entre 5 y 60 longitud de caracteres');
//						is_password(this.add_user_form_pass,'Su clave puede unicamente contener letras, numeros y los siguientes caracteres: ` ! \" ? $ ? % ^ & * ( ) _ - + = { [ } ] : ; @ ~ # | < , > . ? \' / \\ ');
						//is_match(this.add_user_form_pass,this.add_user_form_pass2,'La contraseña no coincide ');

			
			// show the errors or continue if everything is ok
			if (show_form_errors() == false) { return false; }
		});
	});
</script>

<form action="users-add.php" name="adduser" method="post" class="form-horizontal">
	<div class="form-group">
		<label for="add_user_form_name" class="col-sm-4 control-label">Nombre</label>
		<div class="col-sm-8">
			<input type="text" name="add_user_form_name" id="add_user_form_name" class="form-control required" placeholder="Nombre completo del usuario" value="" />
		</div>
	</div>

	<div class="form-group">
		<label for="add_user_form_user" class="col-sm-4 control-label">Ingresar nombre de usuario</label>
		<div class="col-sm-8">
			<input type="text" name="add_user_form_user" id="add_user_form_user" placeholder="Usuario de RED" class="form-control required" maxlength="60" value=""  placeholder="Debe ser alfanumérico" />
		</div>
	</div>

	<div class="form-group">
		<label for="add_user_form_pass" class="col-sm-4 control-label">Contraseña</label>
		<div class="col-sm-8">
			<div class="input-group">
				<!--input name="add_user_form_pass" id="add_user_form_pass" class="form-control  password_toggle" type="password" maxlength="" /-->
				<input name="add_user_form_pass" id="add_user_form_pass" class="form-control  password_toggle" type="password"/>
				<div class="input-group-btn password_toggler">
					<button type="button" class="btn pass_toggler_show"><i class="glyphicon glyphicon-eye-open"></i></button>
				</div>
			</div>
			<button type="button" name="generate_password" id="generate_password" class="btn btn-default btn-sm btn_generate_password" data-ref="add_user_form_pass" data-min="20" data-max="20">Generar</button>
					</div>
	</div>

	<div class="form-group">
		<label for="add_user_form_email" class="col-sm-4 control-label">E-Mail</label>
		<div class="col-sm-8">
			<input type="text" name="add_user_form_email" id="add_user_form_email" class="form-control required" value="" placeholder="Debe ser válido y único" />
		</div>
	</div>

					<div class="form-group">
				<label for="add_user_form_level" class="col-sm-4 control-label">Rol</label>
				<div class="col-sm-8">
					<select name="add_user_form_level" id="add_user_form_level" class="form-control">
						<option value="10" >Administrador de Accesos</option>
						<!--option value="9" >Administrador del sistema</option-->
						<option value="8" >Usuarios del sistema</option>
						<!--option value="7" >Cargador</option-->
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="add_user_form_maxfilesize" class="col-sm-4 control-label">Máximo tamaño de subida</label>
				<div class="col-sm-8">
					<div class="input-group">
						<input value="0" type="text" name="add_user_form_maxfilesize" id="add_user_form_maxfilesize" class="form-control"  readonly value="" />
						<span class="input-group-addon">mb</span>
					</div>
					<p class="field_note">Ponga 0 como limite predeterminado (2048 mb)</p>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-4">
					<label for="add_user_form_active">
						<input type="checkbox" name="add_user_form_active" id="add_user_form_active" checked="checked" /> Activo (usuario puede ingresar al sistema)					</label>
				</div>
			</div>

			
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<label for="add_user_form_notify_account">
								<input type="checkbox" name="add_user_form_notify_account" id="add_user_form_notify_account" checked="checked" /> Envíe correo de bienvenida							</label>
						</div>
					</div>
			
		
	<div class="inside_form_buttons">
		<button type="submit" name="submit" class="btn btn-wide btn-primary">Adicionar Usuario</button>
	</div>

	<div class="alert alert-info">La información de cuenta será enviada al correo electrónico suministrado </div></form>

		</div>
	</div>
</div>

					</div> <!-- row -->
				</div> <!-- container-fluid -->

					<footer>
		<div id="footer">
			Claro Colombia		</div>
	</footer>
			<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('includes/js/jquery.validations.js')}}"></script>
			<script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
			<script src="{{asset('includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			</div> <!-- main_content -->
		</div> <!-- container-custom -->

	</body>
</html>
