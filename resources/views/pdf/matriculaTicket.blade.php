<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            text-transform: uppercase;
            margin: 0;
            padding: 0;
        }

        #contenedor {
            width: 70mm;
            /* Ancho del papel en rollo (en mm) */
            margin: 0;
        }

        #encabezado {
            text-align: center;
            margin-bottom: 10px;
        }

        #informacion {
            margin-bottom: 10px;
        }

        .detalle {
            border-collapse: collapse;
            width: 100%;
        }

        .detalle th,
        .detalle td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .acuerdo td {
            text-align: center;
        }

        #pie {
            text-align: center;
            margin-top: 10px;
            padding-bottom: 20px
        }
        .autorizado{
            padding: 20px;
        }
    </style>
</head>

<body>

    <div id="contenedor">

        <div id="encabezado">
            <img src="{{ $institucion->in_logo }}" width="150" alt="logo" />
            <h3>{{ $institucion->in_razon_social }}</h3>
            <h4>{{ $institucion->in_direccion }}<br>
                Email: {{ $institucion->in_correo }}<br>
                Telefono: {{ $institucion->in_telefono }}</h4>
            <h4>{{ $matriculas['nro_matricula'] }}</h4>
        </div>
         <table class="detalle">
            <thead>
                <tr>
                    <th colspan="2">{{ $matriculas['sede'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">Datos Personales</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>fecha de inscripcion</td>
                    <td>{{ $matriculas['fecha_inscripcion'] }}</td>
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
            </tbody>
        </table>
        <table class="detalle acuerdo">
            <thead>
                <tr>
                    <th colspan="2">acuerdo de inscripcion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>curso</th>
                    <td>{{ $matriculas['curso'] }}</td>
                </tr>
                <tr>
                    <th>categoria</th>
                    <td>{{ $matriculas['categoria'] }}</td>
                </tr>
                <tr>
                    <th>clases</th>
                    <td>{{ $matriculas['duracion'] }}</td>
                </tr>
                <tr>
                    <th>costo</th>
                    <td>{{ $matriculas['costo'] }}</td>
                </tr>
                <tr>
                    <th>inicio</th>
                    <td>{{ $matriculas['fecha_inicio'] }}</td>
                </tr>
                @php
                    $i = count($cuotas) - 1;
                    $cuota = $cuotas[$i];
                @endphp
                <tr>
                    <th>cuota</th>
                    <td>{{ $cuota->ct_numero }}</td>
                </tr>
                <tr>
                    <th>pagado</th>
                    <td>{{ $cuota->ct_importe }}</td>
                </tr>
                <tr>
                    <th>saldo Bs.</th>
                    <td>{{ $matriculas['saldo'] }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">detalle</th>
                </tr>
                <tr>
                    <td colspan="2">{{ $matriculas['detalle'] }}</td>
                </tr>
            </tfoot>
        </table>
        <table class="autorizado">
            <tr>
                <th colspan="2">
                    ______________________<br>
                    pagado por</th>
            </tr>
            <tr>
                <td><b>CI:<br>Nombre</b></td>
                <td colspan="3">{{ $matriculas['documento'] }}<br>
                    {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}
                </td>
            </tr>
        </table>
        <table class="autorizado">
            <tr>
                <th colspan="2">____________________<br>recibi conforme</th>
            </tr>
            <tr>
                <td><b>CI:<br>Nombre</b></td>
                <td colspan="2">
                    {{ $usuario->trabajador->tr_documento }}<br>
                    {{ $usuario->trabajador->tr_nombre }}
                    {{ $usuario->trabajador->tr_apellido }}
                </td>
            </tr>
        </table>
        <div id="pie">
            <p>Gracias por Confiar en Nosotros <br>
                {{ $institucion->in_razon_social }}</p>
        </div>
        <hr>
        <div id="encabezado">
            <img src="{{ $institucion->in_logo }}" width="150" alt="logo" />
            <h3>{{ $institucion->in_razon_social }}</h3>
            <h4>{{ $institucion->in_direccion }}<br>
                Email: {{ $institucion->in_correo }}<br>
                Telefono: {{ $institucion->in_telefono }}</h4>
            <h4>{{ $matriculas['nro_matricula'] }}</h4>
        </div>
         <table class="detalle">
            <thead>
                <tr>
                    <th colspan="2">{{ $matriculas['sede'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">Datos Personales</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>fecha de inscripcion</td>
                    <td>{{ $matriculas['fecha_inscripcion'] }}</td>
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
            </tbody>
        </table>
        <table class="detalle acuerdo">
            <thead>
                <tr>
                    <th colspan="2">acuerdo de inscripcion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>curso</th>
                    <td>{{ $matriculas['curso'] }}</td>
                </tr>
                <tr>
                    <th>categoria</th>
                    <td>{{ $matriculas['categoria'] }}</td>
                </tr>
                <tr>
                    <th>clases</th>
                    <td>{{ $matriculas['duracion'] }}</td>
                </tr>
                <tr>
                    <th>costo</th>
                    <td>{{ $matriculas['costo'] }}</td>
                </tr>
                <tr>
                    <th>inicio</th>
                    <td>{{ $matriculas['fecha_inicio'] }}</td>
                </tr>
                @php
                    $i = count($cuotas) - 1;
                    $cuota = $cuotas[$i];
                @endphp
                <tr>
                    <th>cuota</th>
                    <td>{{ $cuota->ct_numero }}</td>
                </tr>
                <tr>
                    <th>pagado</th>
                    <td>{{ $cuota->ct_importe }}</td>
                </tr>
                <tr>
                    <th>saldo Bs.</th>
                    <td>{{ $matriculas['saldo'] }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">detalle</th>
                </tr>
                <tr>
                    <td colspan="2">{{ $matriculas['detalle'] }}</td>
                </tr>
            </tfoot>
        </table>
        <table class="autorizado">
            <tr>
                <th colspan="2">____________________<br>recibi conforme</th>
            </tr>
            <tr>
                <td><b>CI:<br>Nombre</b></td>
                <td colspan="2">
                    {{ $usuario->trabajador->tr_documento }}<br>
                    {{ $usuario->trabajador->tr_nombre }}
                    {{ $usuario->trabajador->tr_apellido }}
                </td>
            </tr>
        </table>
        <div id="pie">
            <p>Gracias por Confiar en Nosotros <br>
                {{ $institucion->in_razon_social }}</p>
        </div>
    </div>
</body>

</html>
