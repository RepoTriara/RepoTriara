<!doctype html>
<html lang="es_CO">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Subir archivos &raquo;Repositorio</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>
        <link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
        <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
        <script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/bootstrap-datepicker/css/datepicker.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/footable/css/footable.core.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}"/>
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}"/>
    </head>
    <body class="upload-process-form logged-in logged-as-admin menu_hidden backend">
        <div class="container-custom">
            <div class="main_content">
                @include('layouts.app')
                <div class="container-fluid">
                    <div class="row">
                        <div id="section_title">
                            <div class="col-xs-12">
                                <h2>Subir archivos</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Archivos listos para cargar</h3>
                            <b>
                                <p>Favor, complete la siguiente información para finalizar el proceso de carga. Recuerde que "Título" "Asignacion" y "Categoria" son campos obligatorios</p>
                            </b>
                            <!--div class="message message_info"><strong>Notas</strong>: Puedes saltarte la asignación si quiere. Los archivos se conservan y puede añadir a clientes o grupos más tarde.</div-->
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("form").submit(function() {
                                        clean_form(this);

                                        $(this).find('input[name$="[name]"]').each(function() {
                                            is_complete($(this)[0], 'Titulo esta incpmpleto');
                                        });

                                        // show the errors or continue if everything is ok
                                        if (show_form_errors() == false) {
                                            return false;
                                        }

                                    });
                                });
                            </script>
                            <form action="{{ route('file.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
        @foreach ($files as $file)
            <div class="file_editor f_e_odd">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="file_number">
                            <p>
                                <span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
                                {{ $file->name }} <!-- Muestra el nombre del archivo -->
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row edit_files">
                    <div class="col-sm-12">
                        <div class="row edit_files_blocks">
                            <div class="col-sm-6 col-md-3 column">
                                <div class="file_data">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>Información de archivo</h3>
                                            <input type="hidden" name="file[{{ $file->id }}][original]" value="{{ $file->name }}"/>
                                            <input type="hidden" name="file[{{ $file->id }}][file]" value="{{ $file->name }}"/>
                                            <div class="form-group">
                                                <label>Título</label>
                                                <input type="text" name="file[{{ $file->id }}][name]" value="{{ old('file.' . $file->id . '.name', $file->title) }}" class="form-control file_title" placeholder="Ingrese aquí el titulo de archivo requerido." required/>
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea name="file[{{ $file->id }}][description]" class="form-control" placeholder="Opcionalmente, introduzca aquí una descripción para el archivo.">{{ old('file.' . $file->id . '.description', $file->description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 column_even column">
                                <div class="file_data">
                                    <h3>Fecha de expiración</h3>
                                    <div class="form-group">
                                        <label for="file[{{ $file->id }}][expires_date]">Fecha de expiración</label>
                                        <div class="input-group date-container">
                                            <input type="text" class="form-control" readonly name="file[{{ $file->id }}][expiry_date]" value="{{ old('file.' . $file->id . '.expiry_date', $file->expiry_date ? \Carbon\Carbon::parse($file->expiry_date)->format('d-m-Y') : '') }}" />
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label for="exp_checkbox_{{ $file->id }}">
                                            <input type="hidden" name="file[{{ $file->id }}][expires]" value="1" checked="checked"/>
                                        </label>
                                    </div>
                                    <div class="divider"></div>
                                    <h3>Descarga pública</h3>
                                    <div class="checkbox">
                                        <label for="pub_checkbox_{{ $file->id }}">
                                            <input type="checkbox" name="file[{{ $file->id }}][public]" value="1" {{ $file->public ? 'checked' : '' }} /> Permite la descarga pública de este archivo.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 assigns column">
                                <div class="file_data">
                                    <h3>ASIGNACIONES*</h3>
                                    <label>Seleccione el cliente al que pertenece:</label>
                                    <select multiple="multiple" name="file[{{ $file->id }}][assignments][]" class="form-control chosen-select" data-placeholder="Seleccione una o más opciones." required>
                                        <optgroup label="Clientes">
                                            @foreach ($users as $user)
                                                <option value="c{{ $user->id }}" {{ in_array($user->id, $file->assignments->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $user->user }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <div class="list_mass_members">
                                        <a href="#" class="btn btn-xs btn-primary add-all" data-type="assigns">Agregue todo</a>
                                        <a href="#" class="btn btn-xs btn-primary remove-all" data-type="assigns">Borre todo</a>
                                        <a href="#" class="btn btn-xs btn-danger copy-all" data-type="assigns">Copiar la selección a otros archivos</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 categories column">
                                <div class="file_data">
                                    <h3>CATEGORÍAS*</h3>
                                    <label>Agregar a :</label>
                                    <select multiple="multiple" name="file[{{ $file->id }}][categories][]" class="form-control chosen-select" data-placeholder="Seleccione una o más opciones." required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, $file->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="list_mass_members">
                                        <a href="#" class="btn btn-xs btn-primary add-all" data-type="categories">Agregue todo</a>
                                        <a href="#" class="btn btn-xs btn-primary remove-all" data-type="categories">Borre todo</a>
                                        <a href="#" class="btn btn-xs btn-danger copy-all" data-type="categories">Copiar la selección a otros archivos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="after_form_buttons">
        <button type="submit" name="submit" class="btn btn-wide btn-primary" id="upload-continue">Guardar</button>
    </div>
</form>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('.copy-all').click(function() {
                                    if (confirm("¿Copiar la selección a todos los archivos?")) {
                                        var type = $(this).data('type');
                                        var selector = $(this).closest('.' + type).find('select');

                                        var selected = new Array();
                                        $(selector).find('option:selected').each(function() {
                                            selected.push($(this).val());
                                        });

                                        $('.' + type + ' .chosen-select').each(function() {
                                            $(this).find('option').each(function() {
                                                if ($.inArray($(this).val(), selected) === -1) {
                                                    $(this).removeAttr('selected');
                                                } else {
                                                    $(this).attr('selected', 'selected');
                                                }
                                            });
                                        });
                                        $('select').trigger('chosen:updated');
                                    }

                                    return false;
                                });

                                // Autoclick the continue button
                                //$('#upload-continue').click();
                            });
                        </script>
                    </div>
                    <!-- row -->
                </div>
                <!-- container-fluid -->
                <footer>
                    <div id="footer">Claro Colombia		</div>
                </footer>
                <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
                <script src="{{asset('includes/js/jquery.validations.js')}}"></script>
                <script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
                <script src="{{asset('includes/js/jen/jen.js')}}"></script>
                <script src="{{asset('includes/js/js.cookie.js')}}"></script>
                <script src="{{asset('includes/js/main.js')}}"></script>
                <script src="{{asset('includes/js/js.functions.php')}}"></script>
                <script src="{{asset('includes/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
                <script src="{{asset('includes/js/footable/footable.all.min.js')}}"></script>
                <script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
                <script src="{{asset('includes/js/ckeditor/ckeditor.js')}}"></script>
            </div>
            <!-- main_content -->
        </div>
        <!-- container-custom -->
    </body>
</html>
