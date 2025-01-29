<div class="main_side_menu">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />

    <ul class="main_menu" role="menu">

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
                    <a href="https://www.projectsend.org/" target="_blank"></a> Repositorio
                </span>
            </div>

            <ul class="nav pull-right nav_account">
                <li id="header_welcome">
                    <span>{{ auth()->user()->name }}</span>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="my_account">
                        <i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta
                    </a>
                </li>
                <li>
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>Salir
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </header>

        <li class="{{ request()->routeIs('dashboard') ? 'current_nav' : '' }}">
            <a href="{{ route('dashboard') }}" class="nav_top_level">
                <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span>
            </a>
        </li>

        <li class="separator"></li>

        <li
            class="has_dropdown {{ request()->routeIs('upload') || request()->routeIs('file_manager') || request()->routeIs('search_orphan_files') || request()->routeIs('categories.index') || request()->routeIs('categories.edit') || request()->routeIs('categories.create') || request()->routeIs('search_orphan_files') || request()->routeIs('categories.index') || request()->routeIs('categories.edit') || request()->routeIs('files.upload_process.view') || request()->routeIs('files.edit') ? 'current_nav' : '' }}">

            <a href="#" class="nav_top_level">
                <i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span>
            </a>
            <ul class="dropdown_content">
                <li><a href="{{ route('upload') }}"><span class="submenu_label">Subir</span></a></li>

                <li><a href="{{ route('file_manager') }}"><span class="submenu_label">Administrar archivos</span></a>
                </li>
                @if (Auth::user()->level != 8)
                    <li><a href="{{ route('categories.index') }}"><span class="submenu_label">Categorias</span></a>
                    </li>
                @endif
            </ul>
        </li>

        <li
            class="has_dropdown {{ request()->routeIs('add_client') || request()->routeIs('customer_manager') || request()->routeIs('customer_manager.edit') ? 'current_nav' : '' }}">
            <a href="#" class="nav_top_level">
                <i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span>
            </a>
            <ul class="dropdown_content">
                <li><a href="{{ route('add_client') }}"><span class="submenu_label">Añadir nuevo cliente</span></a>
                </li>
                <li><a href="{{ route('customer_manager') }}"><span class="submenu_label">Administración de
                            clientes</span></a></li>
            </ul>
        </li>

        <li
            class="has_dropdown {{ request()->routeIs('add_company') || request()->routeIs('manage_company') || request()->routeIs('groups.edit') ? 'current_nav' : '' }}">
            <a href="#" class="nav_top_level">
                <i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañías</span>
            </a>
            <ul class="dropdown_content">
                <li><a href="{{ route('add_company') }}"><span class="submenu_label">Añadir nueva compañía</span></a>
                </li>
                <li><a href="{{ route('manage_company') }}"><span class="submenu_label">Administrar
                            compañías</span></a></li>
            </ul>
        </li>

        @if (Auth::user()->level != 8)
            <li
                class="has_dropdown {{ request()->routeIs('add_user') || request()->routeIs('manage_users') || request()->routeIs('system_users.edit') ? 'current_nav' : '' }}">
                <a href="#" class="nav_top_level">
                    <i class="fa fa-users fa-fw" aria-hidden="true"></i><span class="menu_label">Usuarios del
                        Sistema</span>
                </a>
                <ul class="dropdown_content">
                    <li><a href="{{ route('add_user') }}"><span class="submenu_label">Añadir nuevo usuario</span></a>
                    </li>
                    <li><a href="{{ route('manage_users') }}"><span class="submenu_label">Administrar
                                usuarios</span></a></li>
                </ul>
            </li>
        @endif

        <li class="separator"></li>
        <li class="separator"></li>
    </ul>
</div>
