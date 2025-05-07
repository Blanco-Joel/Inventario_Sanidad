<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Actividad</title>
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
            <div class="header">Menú de Alumno - NUEVA ACTIVIDAD</div>
            <br>
            <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
            <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

            <form action="{{ route('activities.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="description">Descripción de la actividad</label>
                    <textarea name="description" id="description" rows="4" cols="50" required></textarea>
                    @error('description')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="activity_datetime">Fecha y hora:</label>
                    <input type="datetime-local" id="activity_datetime" name="activity_datetime">
                    @error('activity_datetime')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <h4>Materiales utilizados</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Cantidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input list="materials" name="materialName" id="materialName">
                                <datalist id="materials">
                                    @foreach ($materials as $material)
                                        <option data-id="{{ $material->material_id }}" value="{{ $material->name }}">
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <input type="number" name="units" id="units">
                            </td>
                            <td>
                                <button type="button" name="addButton" id="addButton" class="btn btn-warning">Añadir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Hidden que contendrá el JSON de la cesta -->
                <input type="hidden" name="materialsBasketInput" id="materialsBasketInput">

                <input type="submit" value="Crear" class="btn btn-warning">
            </form>

            <button onclick="window.location.href='{{ route('welcome_student') }}'" class="btn btn-warning">Volver</button>

            {{-- Mensajes flash --}}
            @if(session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error-uspas">
                {{ session('error') }}
                </div>
            @endif

            <br><br>
            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
<script src="{{ asset('js/activity.js') }}" type="text/javascript"></script>
</html>
