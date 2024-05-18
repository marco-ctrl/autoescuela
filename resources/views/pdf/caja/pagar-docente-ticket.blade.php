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

        .autorizado {
            padding: 20px;
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
            <tr>
                <th colspan="2">
                    {{ $pagoDocente->pd_descripcion }} <br>
                    {{ $pagoDocente->docente->do_nombre . ' ' . $pagoDocente->docente->do_apellido }}
                    <br>
                </th>
            </tr>
            <tr>
                <td>documento</td>
                <th>{{ $pagoDocente->docente->do_documento }}</th>
            </tr>
            <tr>
                <td>precio por hora Bs.</td=>
                <th>{{ $pagoDocente->docente->do_pago_hora }}</th>
            </tr>
            <tr>
                <td>horas pagadas</td>
                <th>{{ $pagoDocente->pd_horas_pagadas }}</th>
            </tr>
            <tr>
                <td>horas pendientes por pagar</tdpan=>
                <th>{{ $pagoDocente->pd_horas_pendiente }}</th>
            </tr>
            <tr>
                <td>Total a pagar bs.</td>
                <th>{{ $pagoDocente->pd_monto_total }}</th>
            </tr>
        </table>
        <div style="padding-left: 10px; padding-top: 20px;">
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
