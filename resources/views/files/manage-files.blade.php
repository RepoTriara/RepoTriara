<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Administraci&oacute;n del Sistema &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" media="all" type="text/css"
		href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/footable/css/footable.core.css')}}" />

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />

</head>

<body class="manage-files logged-in logged-as-admin menu_hidden backend">
	<div class="container-custom">
		

    @include('layouts.app_level0')


		<div class="main_content">
			<div class="container-fluid">

				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Administrar archivos</h2>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-xs-12">
						<div class="form_actions_left">
							<div class="form_actions_limit_results">
								<form action="{{ route('manage-files') }}" name="form_search" method="get"
									class="form-inline">
									<div class="form-group group_float">
										<input type="text" name="search" id="search"
											value="{{ request()->get('search') }}"
											class="txtfield form_actions_search_box form-control"
											placeholder="Buscar por título o descripción" />
									</div>
									<button type="submit" id="btn_proceed_search" class="btn btn-sm btn-default">
										Búsqueda
									</button>
								</form>

							</div>
						</div>


						<form action="manage-files.php" name="files_list" method="get" class="form-inline">

							<div class="clear"></div>

							<div class="form_actions_count">
                                        <p>Encontró: <span>{{ $filteredTotal }}</span></p>
                                    </div>

							<div class="clear"></div>

							<table id="files_list" class="footable table default footable-loaded">
								<thead>
									<tr>
										<th class="td_checkbox"><input type="checkbox" name="select_all" id="select_all"
												value="0" /></th>
										<th
											class="active {{ request('sort') === 'timestamp' ? 'footable-sorted-' . request('direction') : '' }}">
											<a
												href="{{ request()->fullUrlWithQuery(['sort' => 'timestamp', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
												Adicionado
											</a>
											<span class="footable-sort-indicator"></span>
										</th>

										<th data-hide="phone">Tipo</th>

										<th>
											<a
												href="{{ request()->fullUrlWithQuery(['sort' => 'filename', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
												Título
												<i
													class="fa fa-sort{{ request('sort') === 'filename' ? (request('direction') === 'asc' ? '-asc' : '-desc') : '' }}"></i>
											</a>
										</th>


										<th data-hide="phone">Tamaño</th>


										<th data-hide="phone">Comportamiento</th>

									</tr>
								</thead>
								<tbody>
									@foreach ($files as $file)
										<tr class="table_row">
											<td><input type="checkbox" name="batch[]" value="{{ $file->id }}"></td>

											<td>{{ $file->timestamp ? $file->timestamp->format('Y/m/d') : 'N/A' }}
											</td>
											<td>

													{{ strtoupper(pathinfo($file->original_url, PATHINFO_EXTENSION)) }}

											</td>
											<td>
												<a href="{{ route('files.download', $file->id) }}">{{ $file->filename
													}}</a>
											</td>


											<td>{{ $file->size ? number_format($file->size / 1024, 2) . ' KB' : '-' }}
											</td>


											<td><a href="{{ route('files.edit', $file->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</form>
                        
					</div>

				</div> <!-- row -->
			</div> <!-- container-fluid -->

			<footer>
				<div id="footer">
					Claro Colombia </div>
			</footer>
			<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
			<script src="{{ asset('includes/js/jquery.validations.js') }}"></script>
			<script src="{{ asset('includes/js/jquery.psendmodal.js') }}"></script>
			<script src="{{ asset('includes/js/jen/jen.js') }}"></script>
			<script src="{{ asset('includes/js/js.cookie.js') }}"></script>
			<script src="{{ asset('includes/js/main.js') }}"></script>
			<script src="{{ asset('includes/js/js.functions.php') }}"></script>
			<script src="{{ asset('includes/js/footable/footable.min.js') }}"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->

</body>

</html>
