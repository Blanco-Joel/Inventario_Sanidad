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
                <div class="header">Menú de Administrador - EDITAR ALMACENAMIENTO</div>
                <br>
                <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
                <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

                <h2>Editar Almacenamiento para: {{ $material->name }}</h2>
                <form action="{{ route('storages.updateBatch', $material->material_id) }}" method="POST">
                    @csrf
                    
                    <h2>Datos para Uso</h2>
                    @php
                        $useRecord = $material->storage->where('storage_type', 'use')->first();
                    @endphp
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input type="number" name="use_units" class="form-control" value="{{ $useRecord->units ?? '' }}" required>
                        @error('use_units')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Cantidad Mínima:</label>
                        <input type="number" name="use_min_units" class="form-control" value="{{ $useRecord->min_units ?? '' }}" required>
                        @error('use_min_units')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Armario:</label>
                        <input type="number" name="use_cabinet" class="form-control" value="{{ $useRecord->cabinet ?? '' }}" required>
                        @error('use_cabinet')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Balda:</label>
                        <input type="number" name="use_shelf" class="form-control" value="{{ $useRecord->shelf ?? '' }}" required>
                        @error('use_shelf')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr>
                    
                    <!-- Sección para almacenar datos de "Reserva" -->
                    <h2>Datos para Reserva</h2>
                    @php
                        $reserveRecord = $material->storage->where('storage_type', 'reserve')->first();
                    @endphp
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input type="number" name="reserve_units" class="form-control" value="{{ $reserveRecord->units ?? '' }}" required>
                        @error('reserve_units')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Cantidad Mínima:</label>
                        <input type="number" name="reserve_min_units" class="form-control" value="{{ $reserveRecord->min_units ?? '' }}" required>
                        @error('reserve_min_units')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Armario:</label>
                        <input type="number" name="reserve_cabinet" class="form-control" value="{{ $reserveRecord->cabinet ?? '' }}" required>
                        @error('reserve_cabinet')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Balda:</label>
                        <input type="number" name="reserve_shelf" class="form-control" value="{{ $reserveRecord->shelf ?? '' }}" required>
                        @error('reserve_shelf')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <br>
                        <input type="checkbox" id="onlyReserve" name="onlyReserve" value="1">
                        <label for="onlyReserve">Actualizar solamente reserva</label>
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
