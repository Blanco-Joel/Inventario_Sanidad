<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Materiales</title>
    <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Portal del Departamento de Sanidad</h1>

        <div class="card">
            <div class="header">Menú de Administrador - ALTA DE MATERIALES</div>
            <br>
            <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
            <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

            <!-- Formulario para agregar material a la cesta -->
            <form action="{{ route('materials.basket.create') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="name">Nombre del material</label>
                    <input type="text" name="name" id="name" placeholder="Catéter" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" rows="4" cols="50" placeholder="Un catéter es...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <fieldset>
                    <legend>Uso</legend>
                    <div class="input-group">
                        <label for="quantity_use">Cantidad</label>
                        <input type="number" name="quantity_use" id="quantity_use" min="1">
                    </div>

                    <div class="input-group">
                        <label for="min_quantity_use">Cantidad mínima</label>
                        <input type="number" name="min_quantity_use" id="min_quantity_use" min="1">
                    </div>

                    <div class="input-group">
                        <label for="cabinet_use">Armario</label>
                        <input type="number" name="cabinet_use" id="cabinet_use" min="1">
                    </div>

                    <div class="input-group">
                        <label for="shelf_use">Balda</label>
                        <input type="number" name="shelf_use" id="shelf_use" min="1">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Reserva</legend>
                    <div class="input-group">
                        <label for="quantity_reserve">Cantidad</label>
                        <input type="number" name="quantity_reserve" id="quantity_reserve" min="1">
                    </div>

                    <div class="input-group">
                        <label for="min_quantity_reserve">Cantidad mínima</label>
                        <input type="number" name="min_quantity_reserve" id="min_quantity_reserve" min="1">
                    </div>

                    <div class="input-group">
                        <label for="cabinet_reserve">Armario</label>
                        <input type="number" name="cabinet_reserve" id="cabinet_reserve" min="1">
                    </div>

                    <div class="input-group">
                        <label for="shelf_reserve">Balda</label>
                        <input type="number" name="shelf_reserve" id="shelf_reserve" min="1">
                    </div>
                </fieldset>

                <input type="submit" value="Añadir" class="btn btn-warning">
            </form>

            <!-- Formulario para confirmar el alta de materiales guardados en la cesta -->
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <input type="submit" value="Alta" class="btn btn-warning">
            </form>

            <button onclick="window.location.href='{{ route('materials.dashboard') }}'" class="btn btn-warning">Volver</button>

            <!-- Mensajes flash -->
            @if (session('success'))
                <p class="alert-success">{{ session('success') }}</p>
            @endif

            @if (session('error'))
                <p class="alert-error-uspas">{{ session('error') }}</p>
            @endif

            <!-- Mostrar el contenido de la cookie de la cesta. Se decodifica el JSON y se presenta de forma estructurada. -->
            @php
                $basket = Cookie::get('materialsAddBasket', '[]');
                $basket = json_decode($basket, true);
            @endphp

            @if (!empty($basket) && is_array($basket))
                <h4>Cesta de Materiales:</h4>
                <ul>
                    @foreach ($basket as $materialData)
                        <li>
                            <strong>Nombre:</strong> {{ $materialData['name'] }}<br>
                            <strong>Descripción:</strong> {{ $materialData['description'] }}<br><br>
                            
                            <strong>Almacenamiento para Uso:</strong>
                            <ul>
                                <li><strong>Cantidad:</strong> {{ $materialData['use']['quantity'] }}</li>
                                <li><strong>Cantidad mínima:</strong> {{ $materialData['use']['min_quantity'] }}</li>
                                <li><strong>Armario:</strong> {{ $materialData['use']['cabinet'] }}</li>
                                <li><strong>Balda:</strong> {{ $materialData['use']['shelf'] }}</li>
                            </ul>
                            
                            <strong>Almacenamiento para Reserva:</strong>
                            <ul>
                                <li><strong>Cantidad:</strong> {{ $materialData['reserve']['quantity'] }}</li>
                                <li><strong>Cantidad mínima:</strong> {{ $materialData['reserve']['min_quantity'] }}</li>
                                <li><strong>Armario:</strong> {{ $materialData['reserve']['cabinet'] }}</li>
                                <li><strong>Balda:</strong> {{ $materialData['reserve']['shelf'] }}</li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>La cesta de materiales está vacía.</p>
            @endif

            <br><br>
            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
