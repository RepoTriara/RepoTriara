<!doctype html>
<html lang="es_CO">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Editar archivo &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://repo.triara.co/repositorio/favicon.ico" />
    <link rel="icon" type="image/png" href="https://repo.triara.co/repositorio/img/favicon/favicon-32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="https://repo.triara.co/repositorio/img/favicon/favicon-152.png" sizes="152x152">
    <script type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/jquery.1.12.4.min.js"></script>

    <!--[if lt IE 9]>
        <script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
        <script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/bootstrap-datepicker/css/datepicker.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
</head>

<body class="edit-file logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        <div class="main_content">
            @if(Auth::user()->level == 0)
                @include('layouts.app_level0')
            @else
                @include('layouts.app')
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Editar archivos</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="container-fluid">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('files.update', ['id' => $fileId]) }}" method="POST" name="edit_file" id="edit_file">
                                @csrf
                                @method('PUT')

                                <div class="container-fluid">
                                    <div class="file_editor f_e_odd">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="file_number">
                                                    <p>
                                                        <span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
                                                        {{ $file->filename ?? 'Nombre del archivo no disponible' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row edit_files">
                                            <div class="col-sm-12">
                                                <div class="row edit_files_blocks">
                                                    <!-- Información de archivo -->
                                                    <div class="col-sm-6 col-md-3 column">
                                                        <div class="file_data">
                                                            <h3>Información de archivo</h3>
                                                            <div class="form-group">
                                                                <label>Título</label>
                                                                <input type="text" name="filename" value="{{ old('filename', $file->filename ?? '') }}" class="form-control file_title" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Descripción</label>
                                                                <textarea name="description" class="form-control">{{ old('description', $file->description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(Auth::user()->level == 8 || Auth::user()->level == 10)
                                                    <!-- Fecha de expiración -->
                                                    <div class="col-sm-6 col-md-3 column_even column">
                                                        <div class="file_data">
                                                            <h3>Fecha de expiración</h3>
                                                            <div class="form-group">
                                                                <label for="file_expiry_date">Seleccione una fecha</label>
                                                                <div class="input-group date-container">
                                                                    <input type="text" id="file_expiry_date" name="expiry_date" value="{{ old('expiry_date', $file->expiry_date ? \Carbon\Carbon::parse($file->expiry_date)->format('Y-m-d') : '') }}" class="form-control" {{ old('expires', $file->expires ?? 0) == 1 ? '' : 'readonly' }} />
                                                                    <div class="input-group-addon">
                                                                        <i class="glyphicon glyphicon-time"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox">
                                                                <label for="exp_checkbox">
                                                                    <input type="checkbox" id="exp_checkbox" name="expires" value="1" {{ old('expires', $file->expires ?? 0) == 1 ? 'checked' : '' }}>
                                                                    El archivo expira en
                                                                </label>
                                                            </div>

                                                            <div class="divider"></div>
                                                            <h3>Descarga pública</h3>
                                                            <div class="checkbox">
                                                                <label for="pub_checkbox">
                                                                    <input type="checkbox" name="public_allow" value="1" {{ $file->public_allow ? 'checked' : '' }} /> Permite la descarga pública de este archivo.
                                                                </label>
                                                            </div>

                                                            <div class="divider"></div>
                                                            <h3>URL pública</h3>
                                                            <div class="public_url">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" readonly>
                                                                        {{ $file->public_allow ? url('download.php?id=' . $file->id . '&token=' . $file->public_token) : 'La descarga pública está deshabilitada para este archivo.' }}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-3 assigns column">
                                                        <div class="file_data">
                                                            <h3>Asignaciones</h3>
                                                            <label>Asigne este archivo a:</label>
                                                            <select multiple="multiple" name="assignments[]" class="form-control chosen-select" data-placeholder="Seleccione una o más opciones. Escriba para buscar">
                                                                <optgroup label="Clientes">
                                                                    @foreach ($clients as $client)
                                                                        <option value="client_{{ $client->id }}" {{ in_array($client->id, $selectedAssignments) ? 'selected' : '' }}>
                                                                            {{ $client->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Grupos">
                                                                    @foreach ($groups as $group)
                                                                        <option value="group_{{ $group->id }}" {{ in_array($group->id, $selectedGroups) ? 'selected' : '' }}>
                                                                            {{ $group->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>

                                                            <div class="list_mass_members">
                                                                <a href="#" class="btn btn-xs btn-primary add-all" data-type="assigns">Agregar todo</a>
                                                                <a href="#" class="btn btn-xs btn-primary remove-all" data-type="assigns">Borrar todo</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-3 categories column">
                                                        <div class="file_data">
                                                            <h3>Categorías</h3>
                                                            <label>Agregar a:</label>
                                                            <select multiple="multiple" name="categories[]" class="form-control chosen-select" data-placeholder="Seleccione una o más opciones.">
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="list_mass_members">
                                                                <a href="#" class="btn btn-xs btn-primary add-all" data-type="categories">Agregar todo</a>
                                                                <a href="#" class="btn btn-xs btn-primary remove-all" data-type="categories">Borrar todo</a>
                                                            </div>
                                                        </div>

                                                        <div class="divider"></div>
                                                        <div class="checkbox">
                                                            <label for="hid_checkbox">
                                                                <input type="checkbox" id="hid_checkbox" name="file[1][hidden]" value="1" /> Marcar como oculto (no se enviaran notificaciones) para clientes y grupos nuevos.
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label for="hid_existing_checkbox">
                                                                <input type="checkbox" id="hid_existing_checkbox" name="file[1][hideall]" value="1" /> Ocultar a todos los clientes y grupos ya asignados.
                                                            </label>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="after_form_buttons">
                                    <a href="{{ route('file_manager') }}" name="cancel" class="btn btn-default btn-wide">Cancelar</a>
                                    <button type="submit" name="submit" class="btn btn-wide btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                var userLevel = {{ Auth::user()->level }};

                                $("form").submit(function(event) {
                                    clean_form(this);

                                    $(this).find('input[name$="[name]"]').each(function() {
                                        is_complete($(this)[0], 'Titulo esta incpmpleto');
                                    });

                                    // show the errors or continue if everything is ok
                                    if (show_form_errors() == false) {
                                        return false;
                                    }

                                    // Redirigir según el nivel del usuario
                                    if (userLevel == 0) {
                                        event.preventDefault();
                                        window.location.href = '{{ route("manage-files") }}';
                                    }
                                });

                                // Manejar el clic en el botón "Cancelar"
                                $('a[name="cancel"]').click(function(event) {
                                    if (userLevel == 0) {
                                        event.preventDefault();
                                        window.location.href = '{{ route("manage-files") }}';
                                    }
                                });
                            });
                        </script>
                    </div> <!-- row -->
                </div> <!-- container-fluid -->

                <footer>
                    <div id="footer">
                        Claro Colombia
                    </div>
                </footer>
                <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
                <script src="{{asset('includes/js/jquery.validations.js')}}"></script>
                <script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
                <script src="{{asset('includes/js/jen/jen.js')}}"></script>
                <script src="{{asset('includes/js/js.cookie.js')}}"></script>
                <script src="{{asset('includes/js/main.js')}}"></script>
                <script src="{{asset('includes/js/js.functions.php')}}"></script>
                <script src="{{asset('includes/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
                <script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
                <script src="{{asset('includes/js/ckeditor/ckeditor.js')}}"></script>
            </div> <!-- main_content -->
        </div> <!-- container-custom -->

        <script>
            $(document).ready(function() {
                $(".chosen-select").chosen({
                    width: "100%",
                    no_results_text: "No se encontraron resultados.",
                    placeholder_text_multiple: "Seleccione una o más opciones.",
                    search_contains: true, // Permite buscar en cualquier parte del texto
                    max_selected_options: null // Permite un número ilimitado de selecciones
                });

                // Función para seleccionar todas las opciones en un select
                $(".add-all").on("click", function(e) {
                    e.preventDefault();
                    const type = $(this).data("type");
                    $(`select[data-type="${type}"] option:not(:disabled)`)
                        .prop("selected", true)
                        .trigger("chosen:updated");
                });

                // Función para deseleccionar todas las opciones en un select
                $(".remove-all").on("click", function(e) {
                    e.preventDefault();
                    const type = $(this).data("type");
                    $(`select[data-type="${type}"] option:not(:disabled)`)
                        .prop("selected", false)
                        .trigger("chosen:updated");
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                // Gestión del checkbox de Fecha de expiración
                const expCheckbox = document.getElementById("exp_checkbox");
                const expiryDateField = document.getElementById("expiry_date");

                // Estado inicial
                if (!expCheckbox.checked) {
                    expiryDateField.setAttribute("disabled", "disabled");
                }

                expCheckbox.addEventListener("change", function() {
                    if (this.checked) {
                        expiryDateField.removeAttribute("disabled");
                    } else {
                        expiryDateField.setAttribute("disabled", "disabled");
                        expiryDateField.value = ""; // Limpia el campo si se deselecciona
                    }
                });

                // Gestión del checkbox de Descarga pública
                const publicCheckbox = document.getElementById("public_checkbox");

                publicCheckbox.addEventListener("change", function() {
                    if (this.checked) {
                        console.log("Descarga pública habilitada.");
                    } else {
                        console.log("Descarga pública deshabilitada.");
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const expCheckbox = document.getElementById('exp_checkbox');
                const expiryDateField = document.getElementById('file_expiry_date');

                // Estado inicial
                if (!expCheckbox.checked) {
                    expiryDateField.setAttribute('readonly', 'readonly');
                }

                expCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        expiryDateField.removeAttribute('readonly');
                    } else {
                        expiryDateField.setAttribute('readonly', 'readonly');
                        expiryDateField.value = ''; // Limpia el campo si se deselecciona
                    }
                });
            });
        </script>
    </div>
</body>

</html>
