<!doctype html>
<html lang="es_CO">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Tablero &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/mobile.min.css')}}">

    <!-- JavaScript -->
	<script src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->
</head>
<body class="home logged-in logged-as-admin dashboard hide_title menu_hidden backend">
	<div class="container-custom">
		<header id="header" class="navbar navbar-static-top navbar-fixed-top">
			<ul class="nav pull-left nav_toggler">
				<li>
					<a href="#" class="toggle_main_menu">
                        <i class="fa fa-bars" aria-hidden="true"></i><span>Menú alternativo</span>
                    </a>
				</li>
			</ul>

			<div class="navbar-header">
				<span class="navbar-brand">
                    <a href="https://www.projectsend.org/" target="_blank">Repositorio</a>
                </span>
			</div>

			<ul class="nav pull-right nav_account">
				<li id="header_welcome">
					<span>Cristian Camilo Diaz Ramirez</span>
				</li>
				<li>
					<a href="{{route('profile.edit')}}" class="my_account">
                        <i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta
                    </a>
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
                <li class="current_nav">
                    <a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level">
                        <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span>
                    </a>
                </li>
				<li class="separator"></li>
                <!-- Archivos -->
                <li class="has_dropdown">
					<a href="#" class="nav_top_level">
                        <i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span>
                    </a>
					<ul class="dropdown_content">
						<li><a href="https://repo.triara.co/repositorio/upload-from-computer.php"><span class="submenu_label">Subir</span></a></li>
						<li class="divider"></li>
						<li><a href="https://repo.triara.co/repositorio/manage-files.php"><span class="submenu_label">Administrar archivos</span></a></li>
						<li><a href="https://repo.triara.co/repositorio/upload-import-orphans.php"><span class="submenu_label">Buscar archivos huerfanos</span></a></li>
						<li class="divider"></li>
						<li><a href="https://repo.triara.co/repositorio/categories.php"><span class="submenu_label">Categorías</span></a></li>
					</ul>
				</li>
				<li class="separator"></li>
                <!-- Clientes -->
				<li class="has_dropdown">
					<a href="#" class="nav_top_level">
                        <i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span>
                    </a>
					<ul class="dropdown_content">
						<li><a href="https://repo.triara.co/repositorio/clients-add.php"><span class="submenu_label">Añadir nuevo cliente</span></a></li>
						<li><a href="https://repo.triara.co/repositorio/clients.php"><span class="submenu_label">Administración de clientes</span></a></li>
						<li class="divider"></li>
					</ul>
				</li>
                <!-- Compañias -->
                <li class="has_dropdown">
					<a href="#" class="nav_top_level">
                        <i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañias</span>
                    </a>
					<ul class="dropdown_content">
						<li><a href="https://repo.triara.co/repositorio/groups-add.php"><span class="submenu_label">Añadir nueva compañia</span></a></li>
						<li><a href="https://repo.triara.co/repositorio/groups.php"><span class="submenu_label">Administrar Compañias</span></a></li>
						<li class="divider"></li>
					</ul>
				</li>
                <!-- Usuarios del Sistema -->
                <li class="has_dropdown">
					<a href="#" class="nav_top_level">
                        <i class="fa fa-users fa-fw" aria-hidden="true"></i><span class="menu_label">Usuarios del Sistema</span>
                    </a>
					<ul class="dropdown_content">
						<li><a href="https://repo.triara.co/repositorio/users-add.php"><span class="submenu_label">Añadir nuevo usuario</span></a></li>
						<li><a href="https://repo.triara.co/repositorio/users.php"><span class="submenu_label">Administrar usuarios</span></a></li>
					</ul>
				</li>
			</ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">
				<div class="row" id="section_title">
					<div class="col-xs-12">
						<h2>Tablero</h2>
					</div>
				</div>
				<!-- Content area for widgets and statistics -->
			</div>
		</div>
	</div>
</body>
</html>
