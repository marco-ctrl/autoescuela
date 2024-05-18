<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pago Docente</title>
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
    <header>
        <table class="encabezado">
            <tr>
                <th><img src="{{ $institucion->in_logo }}" width="150" alt="logo" /></th>
                <th>
                    <h4>{{ $institucion->in_razon_social }}</h4>
                    <h5>{{ $institucion->in_direccion }}<br>
                        Email: {{ $institucion->in_correo }}<br>
                        Telefono: {{ $institucion->in_telefono }}</h5>
                </th>
            </tr>
        </table>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th colspan="5">
                        {{ $pagoDocente->pd_descripcion . ' - ' . $pagoDocente->docente->do_nombre . ' ' . $pagoDocente->docente->do_apellido }}
                    </th>
                </tr>
                <tr>
                    <td colspan="2">documento</td>
                    <th colspan="3">{{ $pagoDocente->docente->do_documento }}</th>
                </tr>
                <tr>
                    <td colspan="2">precio por hora Bs.</td>
                    <th colspan="3">{{ $pagoDocente->docente->do_pago_hora }}</th>
                </tr>
                <tr>
                    <td colspan="2">horas pagadas</td>
                    <th colspan="3">{{ $pagoDocente->pd_horas_pagadas }}</th>
                </tr>
                <tr>
                    <td colspan="2">horas pendientes por pagar</td>
                    <th colspan="3">{{ $pagoDocente->pd_horas_pendiente }}</th>
                </tr>
                <tr>
                    <td colspan="2">Monto Total a pagar bs.</td>
                    <th colspan="3">{{ $pagoDocente->pd_monto_total }}</th>
                </tr>
                <tr>
                    <td colspan="5"><b>detalle</b></td>
                </tr>
                <tr>
                    <th>codigo</th>
                    <th>fecha pago</th>
                    <th>fecha clases</th>
                    <th>usuario</th>
                    <th>pago por hora bs.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $detalle = json_decode($pagoDocente->pd_fecha_hora);
                @endphp
                @foreach ($detalle as $item)
                    <tr>
                        <td>{{ $item->codigo_horario }}</td>
                        <td>{{ $item->fecha_pago }}</td>
                        <td>{{ $item->fecha_hora }}</td>
                        <td>{{ $item->usuario }}</td>
                        <td>{{ $item->pago_hora }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total bs.: </th>
                    <td>{{ $pagoDocente->pd_monto_total }}</td>
                </tr>
            </tfoot>
        </table>
        <div style="padding-left: 40px; padding-top: 50px;">
            <table class="autorizado">
                <tr>
                    <th colspan="2">____________________<br>recibi conforme</th>
                </tr>
                <tr>
                    <td style="width: 50px"><b>CI:<br>Nombre:</b></td>
                    <td>
                        {{ $pagoDocente->docente->do_documento }}<br>
                        {{ $pagoDocente->docente->do_nombre }}
                        {{ $pagoDocente->docente->do_apellido }}
                    </td>
                </tr>
            </table>
        </div>
        
    </main>
</body>

</html>
