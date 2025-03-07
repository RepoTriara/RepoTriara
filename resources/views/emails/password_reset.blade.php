<!doctype html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 90%;
            max-width: 550px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 3px 3px 5px #dedede;
        }

        .content {
            padding: 20px;
        }

        h3 {
            font-size: 19px;
            font-weight: normal;
            margin-bottom: 20px;
            margin-top: 0;
            color: #333333;
        }

        .credentials {
            margin-bottom: 20px;
        }

        .credentials strong {
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            border-top: 1px dotted #ccc;
            text-align: center;
        }

        .footer img {
            display: block;
            margin: 0 auto;
            max-width: 150px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 95%;
                margin: 10px auto;
            }

            .content {
                padding: 15px;
            }

            h3 {
                font-size: 1.5em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h3>
                Restablecimiento de Contraseña
            </h3>
            <p>Hola, <strong>{{ $username }}</strong></p>
            <p>Tu contraseña ha sido restablecida. Aquí están tus nuevas credenciales:</p>

            <div class="credentials">
                <p><strong>Correo:</strong> {{ $email }}</p>
                <p><strong>Nueva Contraseña:</strong> {{ $password }}</p>
            </div>

            <p>Puedes acceder al sistema con el siguiente enlace:</p>
            <p><a href="{{ url('/') }}" target="_blank">Ingresando aquí</a>.</p>
            <p>Por seguridad, te recomendamos cambiar esta contraseña después de iniciar sesión.</p>
        </div>
        <div class="footer">
            <a href="{{ url('/') }}" target="_blank">
                <img src="{{ url('img/icon-footer-email.jpg') }}" alt="Claro">
            </a>
        </div>
    </div>
</body>
</html>
