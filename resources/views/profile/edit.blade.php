<!doctype html>
<html lang="es_CO">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Mi cuenta &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />

</head>

<body class="users-edit logged-in logged-as-admin menu_hidden backend">
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
					<span> {{ $user->user }} </span>
				</li>
				<li>
                    <a href="{{ route('profile.edit') }}" class="my_account"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a>
				</li>
				<li>
					<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
<li class="">
	<a href="{{ route('dashboard') }}" class="nav_top_level"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span></a>
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
		<li class="">
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
							<h2>Informacion de perfil</h2>
						</div>
					</div>
				</div>

				<div class="row">

<div class="col-xs-12 col-sm-12 col-lg-6">

	<div class="white-box">
		<div class="white-box-interior">


<form method="post" action="{{ route('profile.update') }}" name="adduser" class="form-horizontal">
    @csrf
    @method('patch')

	<div class="form-group">
		<label for="name" class="col-sm-4 control-label">Nombre</label>
		<div class="col-sm-8">
			<input type="text" name="name" id="name" class="form-control required" placeholder="Nombre completo del usuario" value="{{ $user->name }}" />
		</div>
	</div>

	<div class="form-group">
		<label for="user" class="col-sm-4 control-label">Ingresar nombre de usuario</label>
		<div class="col-sm-8">
			<input type="text" name="user" id="user" placeholder="Usuario de RED" class="form-control " maxlength="60" value="{{ $user->user }}" readonly placeholder="Debe ser alfanumérico" />
		</div>
	</div>

	<div class="form-group">
		<label for="email" class="col-sm-4 control-label">E-Mail</label>
		<div class="col-sm-8">
			<input type="text" name="email" id="email" class="form-control required" value="{{ $user->email }}" placeholder="Debe ser válido y único" />
		</div>
	</div>


	<div class="inside_form_buttons">
		<button type="submit" name="submit" class="btn btn-wide btn-primary">Actualizar cuenta</button>
	</div>

	</form>

		</div>
	</div>
</div>
					</div> <!-- row -->
				</div> <!-- container-fluid -->
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    <div class="white-box">
                        <div class="white-box-interior">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Actualizar contraseña') }}
                                </h2>
                            </header>

                            <form method="post" action="{{ route('password.update') }}" name="updatePassword" class="form-horizontal mt-6 space-y-6">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                    <label for="update_password_current_password" class="col-sm-4 control-label">{{ __('Contraseña actual') }}</label>
                                    <div class="col-sm-8">
                                        <input
                                            type="password"
                                            id="update_password_current_password"
                                            name="current_password"
                                            class="form-control required mt-1 block w-full"
                                            autocomplete="current-password"
                                            placeholder="Ingrese su contraseña actual"
                                        />
                                        @if ($errors->updatePassword->get('current_password'))
                                            <p class="mt-2 text-danger">
                                                {{ $errors->updatePassword->first('current_password') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="update_password_password" class="col-sm-4 control-label">{{ __('Nueva contraseña') }}</label>
                                    <div class="col-sm-8">
                                        <input
                                            type="password"
                                            id="update_password_password"
                                            name="password"
                                            class="form-control required mt-1 block w-full"
                                            autocomplete="new-password"
                                            placeholder="Ingrese su nueva contraseña"
                                        />
                                        @if ($errors->updatePassword->get('password'))
                                            <p class="mt-2 text-danger">
                                                {{ $errors->updatePassword->first('password') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="update_password_password_confirmation" class="col-sm-4 control-label">{{ __('Confirmar nueva contraseña') }}</label>
                                    <div class="col-sm-8">
                                        <input
                                            type="password"
                                            id="update_password_password_confirmation"
                                            name="password_confirmation"
                                            class="form-control required mt-1 block w-full"
                                            autocomplete="new-password"
                                            placeholder="Confirme su nueva contraseña"
                                        />
                                        @if ($errors->updatePassword->get('password_confirmation'))
                                            <p class="mt-2 text-danger">
                                                {{ $errors->updatePassword->first('password_confirmation') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="inside_form_buttons">
                                    <button type="submit" name="submit" class="btn btn-wide btn-primary">
                                        {{ __('Guardar Contraseña') }}
                                    </button>
                                    @if (session('status') === 'password-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600 dark:text-gray-400"
                                        >
                                            {{ __('Guardado.') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



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
