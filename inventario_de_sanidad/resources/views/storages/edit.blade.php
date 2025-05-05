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
                        <label>Cantidad (Uso):</label>
                        <input type="number" name="use_quantity" class="form-control" 
                            value="{{ $useRecord ? $useRecord->quantity : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Cantidad Mínima (Uso):</label>
                        <input type="number" name="use_min_quantity" class="form-control" 
                            value="{{ $useRecord ? $useRecord->min_quantity : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Armario (Uso):</label>
                        <input type="number" name="use_cabinet" class="form-control" 
                            value="{{ $useRecord ? $useRecord->cabinet : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Balda (Uso):</label>
                        <input type="number" name="use_shelf" class="form-control" 
                            value="{{ $useRecord ? $useRecord->shelf : '' }}" required>
                    </div>
                    
                    <hr>
                    
                    <!-- Sección para almacenar datos de "Reserva" -->
                    <h2>Datos para Reserva</h2>
                    @php
                        $reserveRecord = $material->storage->where('storage_type', 'reserve')->first();
                    @endphp
                    <div class="form-group">
                        <label>Cantidad (Reserva):</label>
                        <input type="number" name="reserve_quantity" class="form-control" 
                            value="{{ $reserveRecord ? $reserveRecord->quantity : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Cantidad Mínima (Reserva):</label>
                        <input type="number" name="reserve_min_quantity" class="form-control" 
                            value="{{ $reserveRecord ? $reserveRecord->min_quantity : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Armario (Reserva):</label>
                        <input type="number" name="reserve_cabinet" class="form-control" 
                            value="{{ $reserveRecord ? $reserveRecord->cabinet : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Balda (Reserva):</label>
                        <input type="number" name="reserve_shelf" class="form-control" 
                            value="{{ $reserveRecord ? $reserveRecord->shelf : '' }}" required>
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
