<!doctype html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bienvenido al repositorio de archivos de Claro Datacenter Triara</title>
    <style>
        body {
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 90%; /* Ajusta el ancho para dispositivos móviles */
            max-width: 550px; /* Ancho máximo en pantallas grandes */
            margin: 20px auto; /* Centra el contenedor */
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
            margin-bottom: 20px; /* Espacio entre las credenciales y el resto del texto */
        }

        .credentials strong {
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            border-top: 1px dotted #ccc;
            text-align: center; /* Centra la imagen en el pie de página */
        }

        .footer img {
            display: block;
            margin: 0 auto; /* Centra la imagen horizontalmente */
            max-width: 150px; /* Ajusta el ancho máximo de la imagen */
        }

        /* Media query para hacerlo responsive en pantallas pequeñas */
        @media only screen and (max-width: 600px) {
            .container {
                width: 95%; /* Ocupa casi todo el ancho en pantallas pequeñas */
                margin: 10px auto; /* Reduce el margen en pantallas pequeñas */
            }

            .content {
                padding: 15px; /* Reduce el padding en pantallas pequeñas */
            }

            h3 {
                font-size: 1.5em; /* Ajusta el tamaño de los encabezados */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h3>
                Bienvenido al repositorio de archivos de Claro Datacenter Triara
            </h3>
            <p>Una nueva cuenta se ha creado para usted, desde este momento usted puede
                acceder al sistema con las siguientes credenciales:</p>

            <div class="credentials">
                <p><strong>Usuario:</strong> {{ $user->user }}</p>
                <p><strong>Contraseña:</strong> {{ $password }}</p>
            </div>

            <p>Puede acceder al repositorio a través de la siguiente URL:</p>
            <p><a href="{{ config('app.url') }}" target="_blank">{{ config('app.url') }}</a></p> <p>Para mayor seguridad le recomendamos iniciar sesión y cambiar su contraseña por una nueva.</p>
        </div>
        <div class="footer">
            <a href="{{ config('app.url') }}" target="_blank">
                <img src="{{ asset('img/icon-footer-email.jpg')}}" alt="" >
            </a>
        </div>
    </div>
</body>
</html>
