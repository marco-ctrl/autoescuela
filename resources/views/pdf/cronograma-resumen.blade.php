@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Autoescuela</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-transform: capitalize;
            font-size: 14px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .titulo {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .subtitulo {
            font-size: 10px;
            font-weight: bold;
        }

        .texto {
            font-size: 12px;
            font-weight: normal;
        }

        .texto-centrado {
            text-align: center;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        h1 {
            text-align: center;
        }

        h2 {
            text-align: left;
        }

        .autorizado {
            border-collapse: collapse;
        }

        .autorizado th {
            background-color: transparent;
            border: none;
            text-align: left;
        }

        .autorizado td {
            border: none;
            text-align: left;
        }

        .datos-personales th {
            text-align: center;
        }

        .datos-personales td {
            text-align: left;
        }

        .encabezado th {
            background-color: transparent;
            border: none;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #f2f2f2;
            text-align: center;
            line-height: 35px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <header>
        <table class="encabezado">
            <tr>
                <th><img src="{{ $institucion->in_logo }}" width="150" alt="logo" /></th>
                <th>
                    <h4>{{ $institucion->in_razon_social }}</h4>
                    <h3>Cronograma Resumen</h3>
                </th>
            </tr>
        </table>
    </header>
    <main>
        <table>
            <tr>
                <th>ASISTENCIA</th>
                <th>HORA INICIO</th>
                <th>HORA FINAL</th>
                <th>CLASE</th>
                <th>CURSO</th>
                <th>DIA</th>
                <th>ESTUDIANTE</th>
                <th>INSTRUCTOR</th>
            </tr>
            @foreach ($cronogramas as $cronograma)
                <tr>
                    <td>{{ $cronograma['asistencia'] }}</td>
                    <td>{{ $cronograma['hora_inicio'] }}</td>
                    <td>{{ $cronograma['hora_fin'] }}</td>
                    <td>{{ $cronograma['clase'] }}</td>
                    <td>{{ $cronograma['curso'] }}</td>
                    <td>{{ $cronograma['dia'] }}</td>
                    <td>{{ $cronograma['estudiante'] }}</td>
                    <td>{{ $cronograma['instructor'] }}</td>
                </tr>
            @endforeach
        </table>
        <div style="padding-left: 40px; padding-top: 50px;">
            <table class="autorizado">
                <tr>
                    <th colspan="2">____________________<br>Autorizado por</th>
                </tr>
                <tr>
                    <td style="width: 50px"><b>Nombre:</b></td>
                    <td>
                        {{ $usuario->trabajador->tr_nombre }}
                        {{ $usuario->trabajador->tr_apellido }}
                    </td>
                </tr>
            </table>
        </div>
    </main>
</body>

</html>
