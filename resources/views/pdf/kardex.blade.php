@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-transform: capitalize;
            font-size: 12px;
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
    </style>
</head>

<body>
    <table>
        <tr>
            <th colspan="4" class="titulo">datos del alumno</th>
        </tr>
        <tr>
            <td colspan="2"><b>kardex: </b>{{ $matriculas['nro_kardex'] }}</td>
            <td colspan="2" rowspan="4"><img src="{{ $matriculas['foto'] }}" width="100" /></td>
        </tr>
        <tr>
            <td><b>apellido paterno: </b>{{ $matriculas['ape_paterno'] }}</td>
            <td><b>edad</b> {{ $matriculas['edad'] }}</td>
        </tr>
        <tr>
            <td><b>apellido materno: </b>{{ $matriculas['ape_materno'] }}</td>
            <td><b>c.i.:</b> {{ $matriculas['documento'] }}</td>
        </tr>
        <tr>
            <td><b>nombre: </b>{{ $matriculas['nombres'] }}</td>
            <td><b>telefono:</b> {{ $matriculas['celular'] }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th colspan="2">categorias</th>
        </tr>
        <tr>
            <td><b>oficina: </b>{{ $matriculas['sede'] }}</td>
            <td><b>categoria: </b>{{ $matriculas['categoria'] }}</td>
        </tr>
        
    </table>
    <table>
        <tr>
            <th colspan="6" class="titulo">acuerdo inscripcion</th>
        </tr>
        <tr>
            <th>tipo curso</th>
            <th>fecha evaluacion</th>
            <th>fecha</th>
            <th>costo</th>
            <th>nro clases</th>
            <th>pago faltante</th>
        </tr>
        <tr>
            <td>{{ $matriculas['curso'] }}</td>
            <td>{{ $matriculas['fecha_evaluacion'] }}</td>
            <td>{{ $matriculas['fecha_inscripcion'] }}</td>
            <td>{{ $matriculas['costo'] }}</td>
            <td>{{ $matriculas['duracion'] }}</td>
            <td>{{ $matriculas['saldo'] }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th colspan="8" class="titulo">plan de pagos</th>
        </tr>
        <tr>
            <th>fecha</th>
            {{--<th>Nro recibo</th>--}}
            <th>cuota</th>
            <th>monto</th>
            <th>nro factura</th>
            <th>curso</th>
            <th>oficina</th>
            <th>usuario</th>
        </tr>
        @foreach ($cuotas as $cuota)
            <tr>
                <td>{{ Carbon::parse($cuota->ct_fecha_pago)->format('d/m/Y') }}</td>
                {{--<td>{{ $cuota->pagoCuota->comprobante->cp_correlativo }}</td>--}}
                <td>{{ $cuota->ct_numero }}</td>
                <td>{{ $cuota->ct_importe }}</td>
                <td></td>
                <td>{{ $matriculas['curso'] }}</td>
                <td>{{ $matriculas['sede'] }}</td>
                <td>
                    {{ $cuota->pagoCuota->usuario->trabajador->tr_nombre }}
                    {{ $cuota->pagoCuota->usuario->trabajador->tr_apellido }}
                </td>
            </tr>
        @endforeach
    </table>
    <table>
        <tr>
            <th colspan="8" class="titulo">lista de clases</th>
        </tr>
        <tr>
            <th>nro clase</th>
            <th>fecha</th>
            <th>hora ini.</th>
            <th>hora fin</th>
            <th>instructor</th>
            <th>tema</th>
            <th>nota</th>
            <th>asistencia</th>
        </tr>
        @php
            $numeroClases = 1;
        @endphp
        @foreach ($horarios as $horario)
            @php
                $color = $horario['asistencia'] == 1 ? 'green' : 'red';
            @endphp
            <tr>
                <td>{{ $numeroClases }}</td>
                <td>{{ $horario['fecha'] }}</td>
                <td>{{ $horario['hora_inicio'] }}</td>
                <td>{{ $horario['hora_final'] }}</td>
                <td>{{ $horario['docente'] }}</td>
                <td>{{ $horario['tema'] }}</td>
                <td>{{ $horario['nota'] }}</td>
                <td style="color: {{ $color }};">{{ $horario['asistencia'] == 1 ? 'Asistencia' : 'Falta'}}</td>
            </tr>
            @php
                $numeroClases++;
            @endphp
        @endforeach
    </table>
</body>

</html>
