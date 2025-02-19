<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Nuevos Archivos Asignados</title>
    <style>
        body {
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 3px 3px 5px #dedede;
        }

        td {
            padding: 20px;
            font-size: 14px;
        }

        h3 {
            font-size: 1.5em;
            font-weight: normal;
            margin-bottom: 10px;
            color: #333333;
        }

        p {
            margin-bottom: 10px;
        }

        .file-list {
            padding: 15px 0;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            margin: 10px 0;
        }

        .file-list ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .file-list li {
            margin-bottom: 5px;
        }

        .footer {
            padding: 20px;
            border-top: 1px dotted #ccc;
            text-align: center;
        }

        .footer img {
            max-width: 150px;
            display: block;
            margin: 0 auto;
        }

        /* Media query para móviles */
        @media only screen and (max-width: 600px) {
            td {
                padding: 15px;
                font-size: 12px;
            }

            h3 {
                font-size: 1.2em;
            }

            .footer img {
                max-width: 120px;
            }
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <h3>Hola, {{ $user->name }}</h3>

                <p>Se te han asignado los siguientes archivos:</p>

                <div class="file-list">
                    <ul>
                        @foreach ($files as $file)
                            <li>📁 {{ $file }}</li>
                        @endforeach
                    </ul>
                </div>

                <p>Puedes acceder a ellos iniciando sesión en el sistema.</p>
                <p>Si prefieres no recibir notificaciones de nuevos archivos, puedes desactivar esta opción en "Mi Cuenta".</p>
                <p>Puedes ver la lista de tus archivos asignados
                    <a href="{{ url('/') }}" target="_blank">Ingresando aquí</a>.
                </p>
            </td>
        </tr>

        <tr>
            <td class="footer">
                <a href="{{ url('/') }}" target="_blank">
                    <img src="{{ asset('img/icon-footer-email.jpg') }}" alt="Logo">
                </a>
            </td>
        </tr>
    </table>
</body>
</html>
