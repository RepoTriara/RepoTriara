<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Adicionar compañias de clientes &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/favicon-152.png') }}" sizes="152x152">
    <script type="text/javascript" src="{{ asset('includes/js/jquery.1.12.4.min.js') }}"></script>

    <!--[if lt IE 9]>
        <script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
        <script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('includes/js/chosen/chosen.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('includes/js/chosen/chosen.bootstrap.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="groups-add logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @include('layouts.app')

            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Adicionar compañia de clientes</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-6">
                        <div class="white-box">
                            <div class="white-box-interior">

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @else
                                    <form action="{{ route('company.store') }}" name="addgroup" method="POST"
                                        class="form-horizontal">
                                        @csrf <!-- Token CSRF necesario para formularios POST -->

                                        <div class="form-group">
                                            <label for="add_group_form_name" class="col-sm-4 control-label">Nombre de la
                                                compañía</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="add_group_form_name"
                                                    id="add_group_form_name" class="form-control required"
                                                    value="{{ old('add_group_form_name') }}" />
                                                @error('add_group_form_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="add_group_form_description"
                                                class="col-sm-4 control-label">Descripción</label>
                                            <div class="col-sm-8">
                                                <textarea name="add_group_form_description" id="add_group_form_description" class="ckeditor form-control">
            {{ old('add_group_form_description') }}
        </textarea>
                                                @error('add_group_form_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group assigns">
                                            <label for="add_group_form_members"
                                                class="col-sm-4 control-label">Integrantes</label>
                                            <div class="col-sm-8">
                                                <select multiple="multiple" id="members-select"
                                                    class="form-control chosen-select" name="add_group_form_members[]"
                                                    data-placeholder="Seleccione una o más opciones. Escriba para buscar">
                                                    @foreach ($members as $member)
                                                        <option value="{{ $member->id }}">{{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="inside_form_buttons">
                                            <button type="submit" name="submit" class="btn btn-wide btn-primary">Crear
                                                grupo</button>
                                        </div>
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container-fluid -->

            <footer>
                <div id="footer">
                    Claro Colombia
                </div>
            </footer>

            <script src="https://repo.triara.co/repositorio/assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/jquery.validations.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/jquery.psendmodal.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/jen/jen.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/js.cookie.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/main.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/js.functions.php"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/chosen/chosen.jquery.min.js"></script>
            <script src="https://repo.triara.co/repositorio/includes/js/ckeditor/ckeditor.js"></script>
            
        </div> <!-- main_content -->
    </div> <!-- container-custom -->
</body>

</html>
