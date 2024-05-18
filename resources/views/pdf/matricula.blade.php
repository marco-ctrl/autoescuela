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
                    <h4>n° matricula<br>
                    {{ $matriculas['nro_matricula'] }}</h4>
                </div>
            </th>
        </tr>
    </table>
    <table class="datos-personales">
        <tr>
            <th colspan="3" class="titulo">datos personales</th>
        </tr>
        <tr>
            <td>fecha de inscripcion</td>
            <td>{{ $matriculas['fecha_inscripcion'] }}</td>
            <td rowspan="7"><img src="{{ $matriculas['foto'] }}" width="200" /></td>
        </tr>
        <tr>
            <td>numero de documento CI</td>
            <td>{{ $matriculas['documento'] }}</td>
        </tr>
        <tr>
            <td>fecha de nacimiento</td>
            <td>{{ $matriculas['fecha_nacimiento'] }}</td>
        </tr>
        <tr>
            <td>edad</td>
            <td>{{ $matriculas['edad'] }}</td>
        </tr>
        <tr>
            <td>apellido</td>
            <td>{{ $matriculas['apellidos'] }}</td>
        </tr>
        <tr>
            <td>nombre</td>
            <td>{{ $matriculas['nombres'] }}</td>
        </tr>
        <tr>
            <td>sede</td>
            <td>{{ $matriculas['sede'] }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th colspan="7" class="titulo">acuerdo de inscripcion</th>
        </tr>
        <tr>
            <th>curso</th>
            <th>cat.</th>
            <th>clases</th>
            <th>costo</th>
            <th>inicio</th>
            <th>cuota</th>
            <th>pagado bs.</th>
        </tr>
        @foreach ($cuotas as $cuota)
            <tr>
                <td>{{ $matriculas['curso'] }}</td>
                <td>{{ $matriculas['categoria'] }}</td>
                <td>{{ $matriculas['duracion'] }}</td>
                <td>{{ $matriculas['costo'] }}</td>
                <td>{{ $matriculas['fecha_inicio'] }}</td>
                <td>{{ $cuota->ct_numero }}</td>
                <td>{{ $cuota->ct_importe }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align: right;">cancelado Bs</td>
            <td>{{ $matriculas['cancelado'] }}</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right;">saldo Bs</td>
            <td>{{ $matriculas['saldo'] }}</td>
        </tr>
        <tr>
            <th colspan="7">detalle</th>
        </tr>
        <tr>
            <td colspan="7">{{ $matriculas['detalle'] }}</td>
        </tr>
    </table>
    <br><br><br>
    <table class="autorizado">
        <tr>
            <th colspan="4">
                ____________________<br>
                pagado por</th>
            <th colspan="3">____________________<br>recibi conforme</th>
        </tr>
        <tr>
            <td><b>CI:<br>Nombre</b></td>
            <td colspan="3">{{ $matriculas['documento'] }}<br>
                {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}
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
