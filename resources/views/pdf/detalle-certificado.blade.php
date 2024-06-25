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
            padding-top: 40px;
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
    </style>
</head>

<body>
    <table class="encabezado">
        <tr>
            <th><img src="{{ $institucion->in_logo }}" width="150" alt="logo" /></th>
            <th>
                <h4>{{ $institucion->in_razon_social }}</h4>
                <h5>{{ $institucion->in_direccion }}<br>
                    Email: {{ $institucion->in_correo }}<br>
                    Telefono: {{ $institucion->in_telefono }}</h5>
            </th>
            <th class="texto-centrado">
                <div style="border-radius: 15%; 
                    background-color: #f2f2f2;
                    padding: 8px">
                    <h4>n° Certificado<br>
                    {{ $programacion['id'] }}</h4>
                </div>
            </th>
        </tr>
    </table>
    <p style="padding-top: 20px; text-align: right; font-size: 10px">Fecha y Hora Impresion: {{ date('d-m-Y H:i:s') }}</p>
    <table class="datos-personales">
        <tr>
            <th colspan="2">{{ $programacion['servicio'] }}</th>
        </tr>
        <tr>
            <td>numero de documento</td>
            <td>{{ $programacion['documento'] }}</td>
        </tr>
        <tr>
            <td>Estudiante</td>
            <td>{{ $programacion['estudiante'] }}</td>
        </tr>
        <tr>
            <td>costo Bs.</td>
            <td>{{ $programacion['costo'] }}</td>
        </tr>
        <tr>
            <td>estado</td>
            <td>{{ $programacion['entregado'] == 0 ? 'Pendiente' : 'Entregado' }}</td>
        </tr>
        <tr>
            <td>fecha de entrega</td>
            <td>{{ $programacion['fecha_entrega']}}
        </tr>
        <tr>
            <td>Usuario que Entrego</td>
            <td>{{ $programacion['usuario_entrega']}}
        </tr>
    </table>
    <table>
        <tr>
            <th colspan="4" class="titulo">Plan de pagos</th>
        </tr>
        <tr>
            <th>nro</th>
            <th>fecha</th>
            <th>cuota</th>
            <th>pagado bs.</th>
        </tr>
        @php
            $numero = 1;
        @endphp
        @foreach ($cuotas as $cuota)
            <tr>
                <td>{{ $numero++ }}</td>
                <td>{{ Carbon::parse($cuota->ct_fecha_pago)->format('d/m/Y') }}</td>
                <td>{{ $cuota->ct_numero }}</td>
                <td>{{ $cuota->ct_importe }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: right;">cancelado Bs</td>
            <td>{{ $programacion['cancelado'] }}</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">saldo Bs</td>
            <td>{{ $programacion['saldo'] }}</td>
        </tr>
    </table>
    <table class="autorizado">
        <tr>
            <th colspan="4">
                ____________________<br>
                pagado por</th>
            <th colspan="3">____________________<br>recibi conforme</th>
        </tr>
        <tr>
            <td><b>CI:<br>Nombre</b></td>
            <td colspan="3">{{ $programacion['documento'] }}<br>
                {{ $programacion['estudiante'] }}
            </td>
            <td><b>CI:<br>Nombre</b></td>
            <td colspan="2">
                {{ $usuario->trabajador->tr_documento }}<br>
                {{ $usuario->trabajador->tr_nombre }}
                {{ $usuario->trabajador->tr_apellido }}
            </td>
        </tr>
    </table>
</body>

</html>
