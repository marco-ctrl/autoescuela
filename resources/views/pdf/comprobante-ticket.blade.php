<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Autoescuela</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            text-transform: capitalize;
            width: 80mm;
            margin-right: 5px;
            padding: 0;
        }

        header {
            text-align: center;
            padding-bottom: 20px;
            margin-top: 20px;
        }

        header img {
            width: 100px;
        }

        header h4,
        header h5 {
            margin: 5px 0;
        }

        .ticket-info {
            background-color: #f2f2f2;
            padding: 8px;
            border-radius: 10%;
            text-align: center;
            margin: 10px 0;
        }

        .fecha-impresion {
            text-align: right;
            font-size: 12px;
            margin-right: 10px;
        }

        .datos {
            background-color: #f2f2f2;
            padding: 8px;
            border-radius: 10%;
            margin: 10px 0;
            width: 100%;
            font-size: 12px;
        }

        .datos th {
            text-align: left;
        }

        .datos th td {
            padding: 8px;
        }

        .detalle,
        .total {
            width: 80mm;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .detalle th,
        .detalle td,
        .total th,
        .total td {
            border: none;
            padding: 5px;
            font-size: 12px;
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
            padding-top: 10px;
            margin-top: 10px;
            font-size: 12px;
        }

        footer div {
            padding-top: 40px;
        }

        footer .leyenda {
            padding-top: 60px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $institucion->in_logo }}" width="150" alt="logo" />
        <h4>{{ $institucion->in_razon_social }}</h4>
        <h5>
            {{ $institucion->in_direccion }}
            Email: {{ $institucion->in_correo }} <br>
            Telefono: {{ $institucion->in_telefono }}
        </h5>
        <div
            style="border-radius: 15%; 
                    background-color: #f2f2f2;
                    padding: 8px">
            <h4>n° ticket<br>
                {{ $informacion->serie }}-{{ $informacion->correlativo }}</h4>
        </div>
    </header>
    <main>
        <p class="fecha-impresion">Fecha de impresion:{{ date('d/m/Y H:i:s') }}</p>
        <table class="datos">
            <tr>
                <th>Fecha Emision:</th>
                <td>
                    {{ Carbon\Carbon::parse($comprobante->cp_fecha_cobro)->format('d/m/Y H:i:s') }}
                </td>
            </tr>
            @isset($matriculas)
                <tr>
                    <th>Señor(a):</th>
                    <td>
                        {{ $matriculas['nombres'] }} {{ $matriculas['apellidos'] }}
                    </td>
                </tr>
                <tr>
                    <th>CI:</th>
                    <td>{{ $matriculas['documento'] }}</td>
                </tr>
                <tr>
                    <th>Matricula:</th>
                    <td>{{ $matriculas['nro_matricula'] }}</td>
                </tr>
                <tr>
                    <th>inscripcion: </th>
                    <td>{{ $matriculas['fecha_inscripcion'] }}</td>
                </tr>
                <tr>
                    <th>inicio: </th>
                    <td>{{ $matriculas['fecha_inicio'] }}</td>
                </tr>
                <tr>
                    <th>sede: </th>
                    <td>{{ $matriculas['sede'] }}</td>
                </tr>
                <tr>
                    <th>categoria: </th>
                    <td>{{ $matriculas['categoria'] }}</td>
                </tr>
                <tr>
                    <th>nro cuotas: </th>
                    <td>{{ $matriculas['numero_cuotas'] }}</td>
                </tr>
                <tr>
                    <th>costo: </th>
                    <td>{{ $matriculas['costo'] }}</td>
                </tr>
                <tr>
                    <th>nro Clases: </th>
                    <td>{{ $matriculas['duracion'] }}</td>
                </tr>
                <tr>
                    <th>Saldo Pendiente: </th>
                    <td>{{ $matriculas['saldo'] }}</td>
                </tr>
            @endisset
            @isset($programacion)
                <tr>
                    <th>Señor(a):</th>
                    <td>
                        {{ $programacion['estudiante'] }}
                    </td>
                </tr>
                <tr>
                    <th>CI:</th>
                    <td>{{ $programacion['documento'] }}</td>
                </tr>
                <tr>
                    <th>costo: </th>
                    <td>{{ $programacion['costo'] }}</td>
                </tr>
                <tr>
                    <th>Saldo Pendiente: </th>
                    <td>{{ $programacion['saldo'] }}</td>
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
                <th colspan="4">IMPORTE TOTAL Bs/. </th>
                <td>{{ $informacion->monto }}</td>
            </tr>
            <tr>
                <th colspan="4">saldo Bs.: </th>
                @isset($matriculas)
                    <td>{{ $matriculas['saldo'] }}</td>
                @endisset
                @isset($programacion)
                    <td>{{ $programacion['saldo'] }}</td>
                @endisset

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

</body>

</html>
