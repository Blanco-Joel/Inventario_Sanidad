<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baja de Materiales</title>
    <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">
    <style>
        table, th, td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Portal del Departamento de Sanidad</h1>

        <div class="card">
            <div class="header">Menú de Docentes - BAJA DE MATERIALES</div>
            <br>
            <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
            <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

            <!-- Formulario para agregar material a la cesta -->

            <div class="input-group">
                <table>
                    <thead>
                        <tr>
                            <th>ID Material</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>{{ $material->material_id }}</td>
                                <td>{{ $material->name }}</td>
                                <td>{{ $material->description }}</td>
                                <td>
                                    <form action="{{ route('materials.destroy', $material) }}" method="POST">
                                        @csrf
                                        <input type="submit" value="Eliminar" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <br>
            <button onclick="window.location.href='{{ route('materials.dashboard') }}'" class="btn btn-warning">Volver</button>

            <!-- Mensajes flash -->
            @if (session('success'))
                <p class="alert-success">{{ session('success') }}</p>
            @endif

            @if (session('error'))
                <p class="alert-error-uspas">{{ session('error') }}</p>
            @endif

            <br><br>
            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
