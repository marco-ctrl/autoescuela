<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante</title>

    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            text-transform: capitalize;
            width: 70mm;
            margin-left: 20px;
        }

        header {
            text-align: center;
            margin-top: 20px;
        }

        header img {
            width: 100px;
        }

        header .titulo {
            font-size: 12px;
            font-weight: bold;
        }

        header .ticket {
            border-radius: 15%;
            background-color: #f2f2f2;
            padding: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .fecha-impresion {
            text-align: right;
            font-size: 8px;
            margin-right: 10px;
        }

        .datos {
            background-color: #f2f2f2;
            padding: 8px;
            border-radius: 10%;
            margin: 10px 0;
            width: 100%;
            font-size: 10px;
        }

        .datos th {
            text-align: left;
        }

        .datos th td {
            padding: 8px;
        }

        .detalle,
        .total {
            width: 70mm;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .detalle th,
        .detalle td,
        .total th,
        .total td {
            border: none;
            padding: 5px;
            font-size: 10px;
        }

        .detalle th {
            background-color: #f2f2f2;
        }

        .detalle td {
            text-align: center;
        }

        .total th {
            text-align: right;
        }

        .total td {
            text-align: center;
        }

        footer {
            text-align: center;
            border-top: 1px solid #000;
            font-size: 12px;
        }

        footer div {
            padding-top: 30px;
        }

        footer .leyenda {
            padding-top: 40px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $institucion->in_logo }}" width="150" alt="logo" />
        <p class="titulo">{{ $institucion->in_razon_social }}
            {{ $institucion->in_direccion }}
            Email: {{ $institucion->in_correo }} <br>
            Telefono: {{ $institucion->in_telefono }}
        </p>
        <p class="ticket">n° matricula<br>
            {{ $matriculas['nro_matricula'] }}</h4>
    </header>
    <main>
        <p class="fecha-impresion">Fecha de impresion:{{ date('d/m/Y H:i:s') }}</p>
        <table class="datos">
            <tr>
                <th>Sede</th>
                <th>{{ $matriculas['sede'] }}</th>
            </tr>
            <tr>
                <th colspan="2">Datos Personales</th>
            </tr>
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
        </table>
        <table class="detalle">
            <tr>
                <th colspan="2">acuerdo de inscripcion</th>
            </tr>
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
                <th>costo curso bs.</th>
                <td>{{ $matriculas['costo_curso'] }}</td>
            </tr>
            <tr>
                <th>costo eva. bs.</th>
                <td>{{ $matriculas['costo_evaluacion'] }}</td>
            </tr>
            <tr>
                <th>costo total bs.</th>
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
                <th>pagado bs.</th>
                <td>{{ $cuota->ct_importe }}</td>
            </tr>
            <tr>
                <th>cancelado bs.</th>
                <td>{{ $matriculas['cancelado'] }}</td>
            </tr>
            <tr>
                <th>saldo Bs.</th>
                <td>{{ $matriculas['saldo'] }}</td>
            </tr>
            <tr>
                <th colspan="2">detalle</th>
            </tr>
            <tr>
                <td colspan="2">{{ $matriculas['detalle'] }}</td>
            </tr>
        </table>

    </main>
    <footer>
        <div>
            <p>____________________<br>pagado por</p>
            @isset($matriculas)
                <p>CI: {{ $matriculas['documento'] }}</p>
                <p>Nombre: {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}</p>
            @endisset
            @isset($programacion)
                <p>CI: {{ $programacion['documento'] }}</p>
                <p>Nombre: {{ $programacion['estudiante'] }}</p>
            @endisset
        </div>

        <div>
            <p>____________________<br>recibi conforme</p>
            <p>CI: {{ $usuario->trabajador->tr_documento }}<br>
                Nombre: {{ $usuario->trabajador->tr_nombre }} {{ $usuario->trabajador->tr_apellido }}
            </p>
        </div>
        <div class="leyenda">
            <p>Gracias por Confiar en Nosotros <br>
                {{ $institucion->in_razon_social }}</p>
        </div>
    </footer>

    <hr>
    <header>
        <img src="{{ $institucion->in_logo }}" width="150" alt="logo" />
        <p class="titulo">{{ $institucion->in_razon_social }}
            {{ $institucion->in_direccion }}
            Email: {{ $institucion->in_correo }} <br>
            Telefono: {{ $institucion->in_telefono }}
        </p>
        <p class="ticket">n° matricula<br>
            {{ $matriculas['nro_matricula'] }}</h4>
    </header>
    <main>
        <p class="fecha-impresion">Fecha de impresion:{{ date('d/m/Y H:i:s') }}</p>
        <table class="datos">
            <tr>
                <th>Sede</th>
                <th>{{ $matriculas['sede'] }}</th>
            </tr>
            <tr>
                <th colspan="2">Datos Personales</th>
            </tr>
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
        </table>
        <table class="detalle">
            <tr>
                <th colspan="2">acuerdo de inscripcion</th>
            </tr>
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
                <th>costo curso bs.</th>
                <td>{{ $matriculas['costo_curso'] }}</td>
            </tr>
            <tr>
                <th>costo eva. bs.</th>
                <td>{{ $matriculas['costo_evaluacion'] }}</td>
            </tr>
            <tr>
                <th>costo total bs.</th>
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
                <th>pagado bs.</th>
                <td>{{ $cuota->ct_importe }}</td>
            </tr>
            <tr>
                <th>cancelado bs.</th>
                <td>{{ $matriculas['cancelado'] }}</td>
            </tr>
            <tr>
                <th>saldo Bs.</th>
                <td>{{ $matriculas['saldo'] }}</td>
            </tr>
            <tr>
                <th colspan="2">detalle</th>
            </tr>
            <tr>
                <td colspan="2">{{ $matriculas['detalle'] }}</td>
            </tr>
        </table>

    </main>
    <footer>
        <div>
            <p>____________________<br>pagado por</p>
            @isset($matriculas)
                <p>CI: {{ $matriculas['documento'] }}</p>
                <p>Nombre: {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}</p>
            @endisset
            @isset($programacion)
                <p>CI: {{ $programacion['documento'] }}</p>
                <p>Nombre: {{ $programacion['estudiante'] }}</p>
            @endisset
        </div>
        <div class="leyenda">
            <p>Gracias por Confiar en Nosotros <br>
                {{ $institucion->in_razon_social }}</p>
        </div>
    </footer>
</body>

</html>
