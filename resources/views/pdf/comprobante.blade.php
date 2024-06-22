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
            /*border: 1px solid #000;*/
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
            padding-top: 40px
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

        .encabezado th {
            background-color: transparent;
            border: none;
            text-align: center;
        }

        .datos {
            padding-bottom: 10px;
            background-color: #f2f2f2d3;
            border-radius: 5%;
            padding-left: 15px;
            padding-right: 15px;
        }

        .datos td {
            border: none;
            text-align: left;
        }

        .total th {
            border: none;
            text-align: right;
            background-color: #fff;
        }

        .total td {
            border: none;
            text-align: center;
        }

        .detalle {
            margin-top: 20px;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 5%;
            padding-left: 15px;
            padding-right: 15px;
        }

        .detalle th {
            /*border: none;*/
            text-align: center;
        }

        .detalle td {
            /*border: none;*/
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
                <div
                    style="border-radius: 15%; 
                    background-color: #f2f2f2;
                    padding: 8px">
                    <h4>n° ticket<br>
                        {{ $informacion->serie }}-{{ $informacion->correlativo }}</h4>
                </div>
            </th>
        </tr>
    </table>
    <p style="padding-top: 20px; text-align: right; font-size: 10px">Fecha y Hora Impresion: {{ date('d-m-Y H:i:s') }}</p>
    <table class="datos">
        @isset($matriculas)
            <tr>
                <td colspan="3"><strong>Señor(a):</strong> {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong>CI:</strong> {{ $matriculas['documento'] }}</td>
            </tr>
            <tr>
                <td><strong>Matricula:</strong> {{ $matriculas['nro_matricula'] }}</td>
                <td><strong>inscripcion: </strong>{{ $matriculas['fecha_inscripcion'] }}</td>
                <td><strong>inicio: </strong>{{ $matriculas['fecha_inicio'] }}</td>
            </tr>
            <tr>
                <td><strong>sede: </strong>{{ $matriculas['sede'] }}</td>
                <td><strong>categoria: </strong>{{ $matriculas['categoria'] }}</td>
                <td><strong>nro cuotas: </strong>{{ $matriculas['numero_cuotas'] }}</td>
            </tr>
            <tr>
                <td><strong>costo: </strong>{{ $matriculas['costo'] }}</td>
                <td colspan="2"><strong>nro Clases: </strong>{{ $matriculas['duracion'] }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Saldo Pendiente: </strong> {{ $matriculas['saldo'] }}</td>
            </tr>
        @endisset
        @isset($programacion)
        <tr>
            <td><strong>Señor(a):</strong> {{ $programacion['estudiante'] }}
            <td><strong>CI:</strong> {{ $programacion['documento'] }}</td>
        </tr>
        <tr>
            <td><strong>costo: </strong>{{ $programacion['costo'] }}</td>
            <td><strong>Saldo Pendiente: </strong> {{ $programacion['saldo'] }}</td>
        </tr>
        @endisset
    </table>
    <table class="detalle">
        <tr>
            <th>nro</th>
            <th>descripcion</th>
            <th>cantidad</th>
            <th>p.u.</th>
            <th>Importe bs.</th>
        </tr>
        <tr>
            <td>1</td>
            <td>{{ $informacion->descripcion }}</td>
            <td>1</td>
            <td>{{ $informacion->monto }}</td>
            <td>{{ $informacion->monto }}</td>
        </tr>
    </table>
    <table class="total">
        <tr>
            <th colspan="4">importe gravado bs/.</th>
            <td>{{ $informacion->monto }}</td>
        </tr>
        <tr>
            <th colspan="4">IVA(16.00%) Bs/. </th>
            <td>--</td>
        </tr>
        <tr>
            <th colspan="4">IMPORTE TOTAL Bs/. </th>
            <td>{{ $informacion->monto }}</td>
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
            @isset($matriculas)
            <td colspan="3">{{ $matriculas['documento'] }}<br>
                {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}
            </td>
            @endisset
            @isset($programacion)
            <td colspan="3">{{ $programacion['documento'] }}<br>
                {{ $programacion['estudiante'] }}
            </td>
            @endisset
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
