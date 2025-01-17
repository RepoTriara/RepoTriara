<div class="main_side_menu">
	<ul class="main_menu" role="menu">
		<li class="">
			<a href="{{ asset('upload-from-computer.php" class="nav_top_level')}}"><i class="fa fa-cloud-upload fa-fw"
					aria-hidden="true"></i><span class="menu_label">Subir</span></a>
		</li>
		<li class="">
			<a href="{{ asset('manage-files')}}" class="nav_top_level"><i class="fa fa-file fa-fw"
					aria-hidden="true"></i><span class="menu_label">Administrar archivos</span></a>
		</li>
		<li class="">
			<a href="{{ asset('my_files') }}" class="nav_top_level')}}"><i class="fa fa-th-list fa-fw"
					aria-hidden="true"></i><span class="menu_label">ver mis archivos</span></a>
		</li>
	</ul>
	<header id="header" class="navbar navbar-static-top navbar-fixed-top">
		<ul class="nav pull-left nav_toggler">
			<li>
				<a href="#" class="toggle_main_menu"><i class="fa fa-bars" aria-hidden="true"></i><span>Menú
						alternativo</span></a>
			</li>
		</ul>

		<div class="navbar-header">
			<span class="navbar-brand"><a href="https://www.projectsend.org/" target="_blank"></a> Repositorio</span>
		</div>

		<ul class="nav pull-right nav_account">
			<li id="header_welcome">
			<span>{{ auth()->user()->name }}</span>
			</li>
			<li>
				<a href="{{route('profile.edit')}}" class="my_account"><i class="fa fa-user-circle"
						aria-hidden="true"></i> Mi cuenta</a>
			</li>
			<li>
				<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesión
				</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			</li>

			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
			</li>
		</ul>
	</header>
</div>