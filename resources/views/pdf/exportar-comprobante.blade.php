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
            font-size: 10px;
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
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .subtitulo {
            font-size: 10px;
            font-weight: bold;
        }

        .texto {
            font-size: 10px;
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
                    <h4>{{ $institucion->in_razon_social }}<br>
                    Comprobantes de ingresos<br>
                    Desde: {{ Carbon::parse($fechas['desde'])->format('d/m/Y') }}
                        - Hasta: {{ Carbon::parse($fechas['hasta'])->format('d/m/Y') }}</h4>
                </th>
            </tr>
        </table>
    </header>
    <main>
        <p style="font-size: 10px;">Fecha y hora de impresion: {{ date('d/m/Y H:i:s') }}</p>
        <table>
            <tr>
                <th colspan="7">detalle ingresos</th>
            </tr>
            <tr>
                <th>nro.</th>
                <th>fecha</th>
                <th>documento</th>
                <th>detalle</th>
                <th>usuario</th>
                <th>estudiante</th>
                <th>monto bs.</th>
            </tr>
            @php
                $total = 0;
                $num = 0;
            @endphp
            @foreach ($ingresos as $ingreso)
                @php
                    $total += $ingreso['monto'];
                    $num++;
                @endphp
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $ingreso['fecha'] }}</td>
                    <td>{{ $ingreso['documento'] }}</td>
                    <td>{{ $ingreso['detalle'] }}</td>
                    <td>{{ $ingreso['usuario'] }}</td>
                    <td>{{ $ingreso['estudiante'] }}</td>
                    <td>{{ $ingreso['monto'] }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="6">Total Bs.:</th>
                <td>{{ $total }}</td>
            </tr>
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
