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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener la altura del contenido
            const contentHeight = document.body.scrollHeight;
            // Convertir la altura a milímetros (1 px = 0.264583 mm)
            const contentHeightMm = contentHeight * 0.264583;
            //{matricula}/{user}/{height}
            window.location.href = '/api/pdf/render/horario-matricula/' + {{$matriculas['id']}} +'/' + {{ $usuario->us_codigo }} +'/' + contentHeightMm;
        });
    </script>
</head>

<body>
    <header>
        <table>
            <tr>
                <td>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}"
                            alt="" style="width: 20mm;">
                </td>
                <th>
                    <p class="titulo">ESCUELA DE CONDUCCION <br> {{$institucion->in_razon_social}}</p>
                </th>
            </tr>
        </table>
    </header>
    <main>
        <p class="fecha-impresion">Fecha y Hora Impresion: {{ date('d/m/Y H:i:s') }}</p>
        <div class="datos">
            <p><strong>Nombre: </strong>{{ $matriculas['nombres'] }} {{ $matriculas['ape_paterno'] }}
                {{ $matriculas['ape_materno'] }}</p>
            <p><strong>Categoria: </strong>{{ $matriculas['categoria'] }}</p>
            <p><strong>Costo Curso: </strong>{{ $matriculas['costo_curso'] }}Bs.</p>
            <p><strong>Costo Evaluacion: </strong>{{ $matriculas['costo_evaluacion'] }} Bs.</p>
            <p><strong>Costo Total: </strong>{{ $matriculas['costo'] }} Bs.</p>
            <p><strong>Cancelado: </strong>{{ $matriculas['cancelado'] }} Bs.</p>
            <p><strong>Saldo: </strong>{{ $matriculas['saldo'] }} Bs.</p>
        </div>
        <table class="detalle">
            <tr>
                <th colspan="2" class="titulo">lista de clases</th>
            </tr>
            <tr>
                <th>nro clase</th>
                <th>dia fecha y Hora</th>
            </tr>
            @php
                $numeroClases = 1;
            @endphp
            @foreach ($horarios as $horario)
                <tr>
                    <td>{{ $numeroClases }}</td>
                    <td> {{ $horario['dia'] }}
                        {{ $horario['fecha'] }}
                        {{ $horario['hora_inicio'] }} -
                        {{ $horario['hora_fin'] }}
                </tr>
                @php
                    $numeroClases++;
                @endphp
            @endforeach
        </table>
        <table class="detalle">
            <tr>
                <th colspan="3" class="titulo">plan de pagos</th>
            </tr>
            <tr>
                <th>cuota</th>
                <th>fecha</th>
                <th>monto</th>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach ($cuotas as $cuota)
                <tr>
                    <td>{{ $cuota->ct_numero }}</td>
                    <td>{{ Carbon::parse($cuota->ct_fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ $cuota->ct_importe }}</td>
                </tr>
                @php
                    $total += $cuota->ct_importe;
                @endphp
            @endforeach
            <tr>
                <td colspan="2" class="total">Total</td>
                <td>{{ $total }}</td>
            </tr>
        </table>
    </main>
</body>

</html>
