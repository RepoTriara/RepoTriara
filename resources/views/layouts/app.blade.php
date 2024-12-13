<div class="main_side_menu">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
    <ul class="main_menu" role="menu">

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
					<span> {{ auth()->user()->user }} </span>
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

        <li class="current_nav">
            <a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level">
                <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span>
            </a>
        </li>
        <li class="separator"></li>
        <li class="has_dropdown">
            <a href="#" class="nav_top_level">
                <i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span>
            </a>
            <ul class="dropdown_content">
                <li>
                    <a href="{{ route('upload') }}"><span class="submenu_label">Subir</span></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('file_manager') }}"><span class="submenu_label">Administrar archivos</span></a>
                </li>
                <li>
                    <a href="{{ route('search_orphan_files') }}"><span class="submenu_label">Buscar archivos huérfanos</span></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="https://repo.triara.co/repositorio/categories.php"><span class="submenu_label">Categorías</span></a>
                </li>
            </ul>
        </li>
        <li class="has_dropdown">
            <a href="#" class="nav_top_level">
                <i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span>
            </a>
            <ul class="dropdown_content">
                <li>
                    <a href="https://repo.triara.co/repositorio/clients-add.php"><span class="submenu_label">Añadir nuevo cliente</span></a>
                </li>
                <li>
                    <a href="{{ route('customer_manager') }}"><span class="submenu_label">Administración de clientes</span></a>
                </li>
                <li class="divider"></li>
            </ul>
        </li>
        <li class="has_dropdown">
            <a href="#" class="nav_top_level">
                <i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañías</span>
            </a>
            <ul class="dropdown_content">
                <li>
                    <a href="https://repo.triara.co/repositorio/groups-add.php"><span class="submenu_label">Añadir nueva compañía</span></a>
                </li>
                <li>
                    <a href="https://repo.triara.co/repositorio/groups.php"><span class="submenu_label">Administrar Compañías</span></a>
                </li>
                <li class="divider"></li>
            </ul>
        </li>

        @if(Auth::user()->level != 8)
        <li class="has_dropdown">
            <a href="#" class="nav_top_level">
                <i class="fa fa-users fa-fw" aria-hidden="true"></i>
                <span class="menu_label">Usuarios del Sistema</span>
            </a>
            <ul class="dropdown_content">
                <li>
                    <a href="https://repo.triara.co/repositorio/users-add.php"><span class="submenu_label">Añadir nuevo usuario</span></a>
                </li>
                <li>
                    <a href="https://repo.triara.co/repositorio/users.php"><span class="submenu_label">Administrar usuarios</span></a>
                </li>
            </ul>
        </li>
        @endif

        <li class="separator"></li>
        <li class="separator"></li>
    </ul>
</div>
