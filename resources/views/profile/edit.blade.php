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
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css"
        href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/main.min.css') }}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/mobile.min.css') }}" />
</head>

<body class="users-edit logged-in logged-as-admin menu_hidden backend">
    <div class="container-custom">
        @if (Auth::user()->level == 0)
            @include('layouts.app_level0')
        @else
            @include('layouts.app')
        @endif

        <div class="main_content">
            <div class="container-fluid">

                <div class="row">
                    <div id="section_title">
                        <div class="col-xs-12">
                            <h2>Información de perfil</h2>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-lg-6">

                        <div class="white-box">
                            <div class="white-box-interior">


                                <form method="post" action="{{ route('profile.update') }}" name="adduser"
                                    class="form-horizontal">
                                    @csrf
                                    @method('patch')

                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Nombre</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name" id="name"
                                                class="form-control required" placeholder="Nombre completo del usuario"
                                                value="{{ $user->name }}" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="user" class="col-sm-4 control-label">Ingresar nombre de
                                            usuario</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="user" id="user"
                                                placeholder="Usuario de RED" class="form-control " maxlength="60"
                                                value="{{ $user->user }}" readonly
                                                placeholder="Debe ser alfanumérico" />
                                        </div>
                                    </div>

                                    <!-- Simplificar el campo de actualización de contraseña -->
                                    <div class="form-group">
                                        <label for="password" class="col-sm-4 control-label">Nueva contraseña</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input name="password" id="password"
                                                    class="form-control password_toggle" type="password"
                                                    maxlength="60" />
                                                <div class="input-group-btn password_toggler">
                                                    <button type="button" class="btn pass_toggler_show"><i
                                                            class="glyphicon glyphicon-eye-open"></i></button>
                                                </div>
                                            </div>
                                            <button type="button" name="generate_password" id="generate_password"
                                                class="btn btn-default btn-sm btn_generate_password" data-ref="password"
                                                data-min="20" data-max="20">Generar</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label">E-Mail</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="email" id="email"
                                                class="form-control required" value="{{ $user->email }}"/>
                                        </div>
                                    </div>

                                    @if (Auth::user()->level == 0)
                                        <div class="form-group">
                                            <label for="address" class="col-sm-4 control-label">Dirección</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="address" id="address"
                                                    class="form-control" value="{{ $user->address }}" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone" class="col-sm-4 control-label">Teléfono</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="phone" id="phone"
                                                    class="form-control" value="{{ $user->phone }}"
                                                    placeholder="Solo números, sin espacios ni caracteres especiales" /> 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="notify"
                                                class="col-sm-4 control-label">Notificaciones</label>
                                            <div class="col-sm-8">
                                                <!-- Campo oculto para asegurar que se envíe "0" si el checkbox no está marcado -->
                                                <input type="hidden" name="notify" value="0">
                                                <input type="checkbox" name="notify" id="notify" value="1"
                                                    {{ old('notify', $user->notify) == 1 ? 'checked' : '' }}>
                                                <label for="notify">Recibir notificaciones</label>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="inside_form_buttons">
                                        <button type="submit" name="submit"
                                            class="btn btn-wide btn-primary">Actualizar cuenta</button>
                                    </div>

                                </form>

                            </div>
                        </div>
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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Mensaje de éxito
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#2778c4'
        });
    @endif

   @if ($errors->any())
    let errorMessages = '';
    let uniqueErrors = {};

    // Procesar errores
    @foreach ($errors->getMessages() as $field => $messages)
        uniqueErrors['{{ $field }}'] = [];
        @foreach ($messages as $message)
            
            // SECCIÓN MODIFICADA: Manejo especial para campos
            @if ($field == 'phone')
                // Mensaje personalizado para errores de teléfono
                uniqueErrors['{{ $field }}'].push('El teléfono debe ser solo números, entre 7 y 10 dígitos.');
            @elseif ($field == 'email')
                // Manejo especial para errores de email - priorizar mensaje de formato
                if ('{{ $message }}'.includes('formato') || '{{ $message }}'.includes('formato')) {
                    uniqueErrors['{{ $field }}'] = ['El formato del correo electrónico no es válido.'];
                } else if (uniqueErrors['{{ $field }}'].length === 0) {
                    uniqueErrors['{{ $field }}'].push('{{ $message }}');
                }
                
            @else
                // Mantener otros mensajes de error como están
                if (!uniqueErrors['{{ $field }}'].includes('{{ $message }}')) {
                    uniqueErrors['{{ $field }}'].push('{{ $message }}');
                }
            @endif
        @endforeach
    @endforeach

        // Construir bloque de mensajes
        let allMessages = [];
        for (const [field, messages] of Object.entries(uniqueErrors)) {
            allMessages = allMessages.concat(messages);
        }
        errorMessages = allMessages.join('<br>');

        // Estilos personalizados (modificación mínima)
        const style = document.createElement('style');
        style.textContent = `
               .custom-swal-popup {
                max-width: 95% !important;
                width: 500px !important;
                min-height: 180px !important;
                padding: 15px !important;
            }
            .custom-swal-title {
                text-align: center !important;
                width: 100% !important;
                font-size: 20px !important;
                margin-bottom: 10px !important;
                font-weight: bold !important;
            }
            .custom-swal-html {
                width: 100% !important;
                font-size: 14px !important;
                text-align: center !important; /* CENTRADO */
                padding: 0 10px !important;
                margin-top: 0 !important;
                line-height: 1.2 !important;
                white-space: nowrap !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important; /* CENTRADO */
            }
            .custom-swal-confirm {
                margin-top: 10px !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                font-size: 14px !important;
            }
            .swal2-warning-custom {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 50px !important;
                height: 50px !important;
                font-size: 30px !important;
                font-weight: bold !important;
                color: #facea8 !important;
                border: 2px solid #f8bb86 !important;
                border-radius: 50% !important;
                margin: 0 auto 10px auto !important;
            }
        `;
        
        document.head.appendChild(style);
          
        // Mostrar alerta
        Swal.fire({
            icon: 'warning',
            title: '<span class="custom-swal-title">Errores en el formulario</span>',
            html: `<div class="custom-swal-html">${errorMessages}</div>`,
            confirmButtonText: 'Corregir',
            confirmButtonColor: '#2778c4',
            customClass: {
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                htmlContainer: 'custom-swal-html',
                confirmButton: 'custom-swal-confirm'
            }
        });
    @endif
</script>

        </div> <!-- main_content -->
    </div> <!-- container-custom -->

</body>

</html>
