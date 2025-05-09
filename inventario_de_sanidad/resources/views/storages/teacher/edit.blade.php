<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar almacenamiento</title>
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
                <div class="header">Menú de Docentes - EDITAR ALMACENAMIENTO</div>
                <br>
                <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
                <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

                <form action="{{ route('storages.subtract.teacher', $material->material_id) }}" method="POST">
                    @csrf

                    <h2>Editar Almacenamiento para: {{ $material->name }}</h2>
                    
                    <h3>Datos para Uso</h3>
                    @php
                        $useRecord = $material->storage->where('storage_type', 'use')->first();
                    @endphp
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input type="number" name="use_units" class="form-control" value="{{ $useRecord->units ?? '-' }}" readonly>
                        @error('use_units')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Cantidad a restar:</label>
                        <input type="number" name="subtract_units" class="form-control" value="0" min="0" max="{{ $useRecord->units }}" required>
                        @error('subtract_units')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Actualizar Almacenamiento</button>
                </form>

                <button onclick="window.location.href='{{ route('storages.updateView') }}'" class="btn btn-warning">Volver</button>

                <!-- Mensajes flash -->
                @if (session('success'))
                    <p class="alert-success">{{ session('success') }}</p>
                @endif

                @if (session('error'))
                    <p class="alert-error-uspas">{{ session('error') }}</p>
                @endif

                @if (session('info'))
                    <p class="alert-error-uspas">{{ session('info') }}</p>
                @endif

                <br><br>
                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </body>
</html>
