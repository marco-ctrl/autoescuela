<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
                    <th colspan="11">{{ $datos != null ? $datos[0]->titulo : 'No se encontraron datos que mostrar' }}
                    </th>
                </tr>
                <tr>
                    <th>HORA</th>
                    <th>MATRICULA</th>
                    <th>SALDO BS.</th>
                    <th>CC</th>
                    <th>CI</th>
                    <th>ESTUDIANTE</th>
                    <th>CAT</th>
                    <th>CURSO</th>
                    <th>NRO</th>
                    <th>OBSERVACIONES</th>
                    <th>FIRMA</th>
                </tr>
            </thead>
            <tbody>
                @if ($datos != null)
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->hora }}</td>
                            <td>{{ $item->matricula }}</td>
                            <td style="color: {{ $item->textColor == 'text-danger' ? 'red' : 'green' }}">
                                {{ $item->saldo }}</td>
                            <td>{{ $item->sede }}</td>
                            <td>{{ $item->ci }}</td>
                            <td>{{ $item->estudiante }}</td>
                            <td>{{ $item->categoria }}</td>
                            <td>{{ $item->curso }}</td>
                            <td>{{ $item->numero }}</td>
                            <td>{{ $item->observacion }}</td>
                            <td>{{ $item->firma }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="11">NO HAY DATOS DISPONIBLE QUE MOSTRAR</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </main>
</body>

</html>
