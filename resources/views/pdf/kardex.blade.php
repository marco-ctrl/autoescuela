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
            <th colspan="8" class="titulo">datos del alumno</th>
        </tr>
        <tr>
            <td colspan="6"><b>kardex: </b>{{ $matriculas['nro_kardex'] }}</td>
            <td colspan="2" rowspan="4"><img src="{{ $matriculas['foto'] }}" width="100" /></td>
        </tr>
        <tr>
            <td colspan="3"><b>apellido paterno: </b>{{ $matriculas['ape_paterno'] }}</td>
            <td colspan="3"><b>edad</b> {{ $matriculas['edad'] }}</td>
        </tr>
        <tr>
            <td colspan="3"><b>apellido materno: </b>{{ $matriculas['ape_materno'] }}</td>
            <td colspan="3"><b>c.i.:</b> {{ $matriculas['documento'] }}</td>
        </tr>
        <tr>
            <td colspan="3"><b>nombre: </b>{{ $matriculas['nombres'] }}</td>
            <td colspan="3"><b>telefono:</b> {{ $matriculas['celular'] }}</td>
        </tr>
        <tr>
            <th colspan="8"><b>categorias</b></th>
        </tr>
        <tr>
            <td colspan="4"><b>oficina: </b>{{ $matriculas['sede'] }}</td>
            <td colspan="4"><b>categoria: </b>{{ $matriculas['categoria'] }}</td>
        </tr>
        <tr>
            <th colspan="8" class="titulo">acuerdo inscripcion</th>
        </tr>
        <tr>
            <th colspan="2">tipo curso</th>
            <th>fecha evaluacion</th>
            <th colspan="2">fecha</th>
            <th>costo</th>
            <th>nro clases</th>
            <th>pago faltante</th>
        </tr>
        <tr>
            <td colspan="2">{{ $matriculas['curso'] }}</td>
            <td>{{ $matriculas['fecha_evaluacion'] }}</td>
            <td colspan="2">{{ $matriculas['fecha_inscripcion'] }}</td>
            <td>{{ $matriculas['costo'] }}</td>
            <td>{{ $matriculas['duracion'] }}</td>
            <td>cancelado</td>
        </tr>
        <tr>
            <th colspan="8" class="titulo">plan de pagos</th>
        </tr>
        <tr>
            <th>fecha</th>
            <th>Nro recibo</th>
            <th>cuota</th>
            <th>monto</th>
            <th>nro factura</th>
            <th>curso</th>
            <th>oficina</th>
            <th>secretaria</th>
        </tr>
        @foreach ($cuotas as $cuota)
            <tr>
                <td>{{ $cuota->ct_fecha_pago }}</td>
                <td></td>
                <td>{{ $cuota->ct_numero }}</td>
                <td>{{ $cuota->ct_importe }}</td>
                <td></td>
                <td>{{ $matriculas['curso'] }}</td>
                <td>{{ $matriculas['sede'] }}</td>
                <td>{{ $cuota->pagoCuota->usuario->trabajador->tr_nombre }}</td>
            </tr>
        @endforeach
        <tr><th colspan="8" class="titulo">lista de clases</th></tr>
        <tr>
          <th>nro clase</th>
          <th>fecha</th>
          <th>hora</th>
          <th>instructor</th>
          <th>cat.</th>
          <th>comentario</th>
          <th>observacion</th>
          <th>usuario</th>
        </tr>
        @php
          $numeroClases = 1;
        @endphp
        @foreach ($horarios as $horario)
          <tr>
            <td>{{ $numeroClases }}</td>
            <td>{{ $horario['fecha'] }}</td>
            <td>{{ $horario['hora_inicio'] }}</td>
            <td>{{ $horario['docente'] }}</td>
            <td>{{ $matriculas['categoria'] }}</td>
            <td>{{ $horario['comentario'] }}</td>
            <td>{{ $horario['observacion'] }}</td>
            <td></td>
          </tr>
          @php
            $numeroClases++;
          @endphp
        @endforeach
    </table>
</body>

</html>
