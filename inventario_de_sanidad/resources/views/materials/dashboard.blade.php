<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Materiales</title>
    <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Portal del departamento de Sanidad</h1> 

        <div class="card ">
            <div class="header">Menú de Docentes - GESTIÓN DE MATERIALES </div><br>
                <b>Bienvenido/a: </b> {{ Cookie::get('NAME') }}<br><br>
                <b>Identificador Empleado: </b> {{ Cookie::get('USERPASS') }}<br><br>

                <!-- Botones del menú -->
                <button onclick="window.location.href='{{ route('materials.create') }}'" class="btn btn-warning">Dar de alta un material</button>
                <button onclick="window.location.href='{{ route('materials.delete') }}'" class="btn btn-warning">Dar de baja un material</button>
                <button onclick="window.location.href='{{ route('storages.updateView') }}'" class="btn btn-warning">Gestionar almacenamiento</button>
                <button onclick="window.location.href='#'" class="btn btn-warning">Modificar cantidades mínimas</button>
                <br><br>
                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>