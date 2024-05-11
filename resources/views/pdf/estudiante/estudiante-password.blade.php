<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estudiante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        img {
            width: 150px;
            height: auto;
            margin-top: 20px;
        }
        main {
            margin: 0 auto;
            width: 80%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            text-align: left;
            background-color: #f2f2f2;
        }
        td {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <header>
        <h1>Credenciales</h1>
        <img src="{{ $estudiante->es_foto }}" alt="foto estudiante">
    </header>
    <main>
        <table>
            <tr>
                <td>Carnet: </td>
                <td>{{ $estudiante->es_documento }}</td>
            </tr>
            <tr>
                <td>Nombre: </td>
                <td>{{ $estudiante->es_nombre }}</td>
            </tr>
            <tr>
                <td>Apellido: </td>
                <td>{{ $estudiante->es_apellido }}</td>
            </tr>
            <tr>
                <td>Correo: </td>
                <td>{{ $user->us_correo }}</td>
            </tr>
            <tr>
                <td>Contrasena: </td>
                <td>{{ $pass['password'] }}</td>
            </tr>
        </table>
    </main>
</body>
</html>