<!doctype html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Restablecer Contraseña &raquo; Repositorio</title>
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
            margin-top: 0;
            margin-bottom: 20px;
            color: #333333;
        }
        p {
            margin-bottom: 15px;
            line-height: 1.5;
            color: #555555;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
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
            <h3>Restablecer tu Contraseña</h3>
            <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el siguiente enlace para continuar:</p>
            <p>
                <a href="{{ url(route('password.reset', ['token' => $token, 'email' => $email])) }}">
                    Restablecer Contraseña
                </a>
            </p>
            <p>Si no solicitaste este cambio, simplemente ignora este correo.</p>
        </div>
        <div class="footer">
            <a href="{{ config('app.url') }}" target="_blank">
                <img src="{{ asset('img/icon-footer-email.jpg')}}" alt="Repositorio">
            </a>
        </div>
    </div>
</body>
</html>
