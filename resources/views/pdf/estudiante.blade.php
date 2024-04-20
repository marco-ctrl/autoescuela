@php
    //dd($password, $estudiante, $rol);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>estudiante</title>
</head>
<body>
    <p>{{$estudiante->es_codigo}}</p><br>
    <p>{{$estudiante->es_nombre}}</p><br>
    <p>{{$estudiante->es_correo}}</p><br>
    <p>{{$password}}</p><br>
</body>
</html>