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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Estilos para SweetAlert2
    const style = document.createElement('style');
    style.textContent = `
        .compact-swal {
            max-width: 500px;
            padding: 1em;
        }
        .compact-title {
            text-align: center;
            margin-bottom: 8px !important;
            font-size: 1.3em;
            padding-bottom: 0;
        }
        .compact-content {
            padding: 0 1em;
            margin-top: 5px !important;
        }
        .compact-errors-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .compact-error-line {
            font-size: 0.95em;
            text-align: left;
            line-height: 1.4;
            display: flex;
            align-items: flex-start;
        }
        .error-number {
            flex-shrink: 0;
            margin-right: 5px;
            font-weight: bold;
        }
        .error-text {
            word-break: break-word;
        }
        .bold-section {
            font-weight: bold;
        }
        .success-swal {
            max-width: 450px;
            padding: 1.5em;
        }
        .success-title {
            text-align: center;
            margin-bottom: 10px !important;
            font-size: 1.4em;
            color: #2778c4;
        }
    `;
    document.head.appendChild(style);

    // Mensaje de éxito
    @if (session()->has('success'))
        Swal.fire({
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#2778c4',
            customClass: {
                popup: 'success-swal',
                title: 'success-title'
            }
        });
    @endif

    // Mensajes de error
    @if ($errors->any())
        @php
            $errorIndex = 1;
            $errorMessages = '';
            foreach ($errors->getMessages() as $field => $messages) {
                foreach ($messages as $message) {
                    $colonIndex = strpos($message, ':');
                    if ($colonIndex !== false) {
                        $beforeColon = substr($message, 0, $colonIndex);
                        $afterColon = substr($message, $colonIndex + 1);
                        $errorMessages .= '
                            <div class="compact-error-line">
                                <span class="error-number">'.$errorIndex++.'.</span>
                                <span class="error-text">
                                    <span class="bold-section">'.$beforeColon.':</span>'.$afterColon.'
                                </span>
                            </div>
                        ';
                    } else {
                        $errorMessages .= '
                            <div class="compact-error-line">
                                <span class="error-number">'.$errorIndex++.'.</span>
                                <span class="error-text">'.$message.'</span>
                            </div>
                        ';
                    }
                }
            }
        @endphp

        Swal.fire({
            title: 'Errores de validación',
            html: `<div class="compact-errors-container"><?php echo $errorMessages; ?></div>`,
            icon: 'error',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#2778c4',
            customClass: {
                popup: 'compact-swal',
                title: 'compact-title',
                htmlContainer: 'compact-content'
            }
        });
    @endif
</script>

        </div> <!-- main_content -->
    </div> <!-- container-custom -->

</body>

</html>
