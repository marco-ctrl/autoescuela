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

        .fecha-impresion{
            text-align: right; 
            font-size: 12px;
            margin-right: 10px;
        }

        .datos {
            background-color: #f2f2f2;
            padding: 8px;
            border-radius: 10%;
            text-align: left;
            margin: 10px 0;
            width: 95%;
        }

        .datos p {
            font-size: 12px;
        }

        .datos p span {
            font-weight: bold;
        }

        .datos p span:first-child {
            margin-right: 10px;
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
        footer div{
            padding-top: 40px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('hola mundo')
            // Obtener la altura del contenido
            const contentHeight = document.body.scrollHeight;
            // Convertir la altura a milímetros (1 px = 0.264583 mm)
            const contentHeightMm = contentHeight * 0.264583;
            window.location.href = '/public/api/pdf/comprobante-egreso-ticket/' + {{$comprobante->cp_codigo}} +'/' + {{ $usuario->us_codigo }} +'/' + contentHeightMm;
        });
    </script>
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
            <h4>egreso n° {{$comprobante->cp_correlativo}}</h4>
        </div>
    </header>
    <main>
        <p class="fecha-impresion">Fecha de impresion:{{ date('d/m/Y H:i:s') }}</p>
        <div class="datos">
            <p><strong>Señor(a):</strong> {{ $informacion->persona ?? 'Sin Asignar' }}</p>
            <p><strong>Fecha Emision:</strong>
                {{ Carbon\Carbon::parse($comprobante->cp_fecha_cobro)->format('d/m/Y H:i:s') }}
            </p>
        </div>
        <table class="detalle">
            <tr>
                <th>nro</th>
                <th>descripcion</th>
                <th>cantidad</th>
                <th>p.u.</th>
                <th>Importe bs.</th>
            </tr>

            @php
                $num = 1;
                $total = 0;
            @endphp
            @foreach ($informacion->detalle as $item)
                @php
                    $subtotal = $item->Cantidad * $item->Precio;
                @endphp
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $item->Producto }}</td>
                    <td>{{ $item->Cantidad }}</td>
                    <td>{{ $item->Precio }}</td>
                    <td>{{ $subtotal }}</td>
                </tr>
                @php
                    $num++;
                    $total += $subtotal;
                @endphp
            @endforeach

        </table>
        <table class="total">
            <tr>
                <th colspan="4">importe gravado bs/.</th>
                <td>{{ $total }}</td>
            </tr>
            <tr>
                <th colspan="4">IVA(16.00%) Bs/. </th>
                <td>--</td>
            </tr>
            <tr>
                <th colspan="4">IMPORTE TOTAL Bs/. </th>
                <td>{{ $total }}</td>
            </tr>
        </table>
    </main>
    <footer>
        <div>
            <p>____________________<br>pagado por</p>
            <p>Nombre: {{ $informacion->persona ?? 'Sin Asignar' }}</p>
        </div>

        <div>
            <p>____________________<br>recibi conforme</p>
            <p>CI: {{ $usuario->trabajador->tr_documento }}<br>
                Nombre: {{ $usuario->trabajador->tr_nombre }} {{ $usuario->trabajador->tr_apellido }}
            </p>
        </div>
        <p class="leyenda"></p>
    </footer>

</body>

</html>
