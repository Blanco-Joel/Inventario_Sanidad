<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Materiales</title>
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

                <div class="input-group">
                    <label for="storage">Localización</label>
                    <select name="storage" id="storage">
                        <option value="">-- Seleccionar --</option>
                        <option value="CAE" {{ old('storage')=='CAE'?'selected':'' }}>CAE</option>
                        <option value="odontologia" {{ old('storage')=='odontologia'?'selected':'' }}>Odontología</option>
                    </select>
                    @error('storage')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <fieldset>
                    <legend>Uso</legend>
                    <div class="input-group">
                        <label for="units_use">Cantidad</label>
                        <input type="number" name="units_use" id="units_use" min="1" value="{{ old('units_use') }}">
                        @error('units_use')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="min_units_use">Cantidad mínima</label>
                        <input type="number" name="min_units_use" id="min_units_use" min="1" value="{{ old('min_units_use') }}">
                        @error('min_units_use')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="cabinet_use">Armario</label>
                        <input type="number" name="cabinet_use" id="cabinet_use" value="{{ old('cabinet_use') }}">
                        @error('cabinet_use')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="shelf_use">Balda</label>
                        <input type="number" name="shelf_use" id="shelf_use" min="1" value="{{ old('shelf_use') }}">
                        @error('shelf_use')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="drawer">Cajón</label>
                        <input type="number" name="drawer" id="drawer" value="{{ old('drawer') }}">
                        @error('drawer')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Reserva</legend>
                    <div class="input-group">
                        <label for="units_reserve">Cantidad</label>
                        <input type="number" name="units_reserve" id="units_reserve" min="1" value="{{ old('units_reserve') }}">
                        @error('units_reserve')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="min_units_reserve">Cantidad mínima</label>
                        <input type="number" name="min_units_reserve" id="min_units_reserve" min="1" value="{{ old('min_units_reserve') }}">
                        @error('min_units_reserve')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="cabinet_reserve">Armario</label>
                        <input type="text" name="cabinet_reserve" id="cabinet_reserve" value="{{ old('cabinet_reserve') }}">
                        @error('cabinet_reserve')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="shelf_reserve">Balda</label>
                        <input type="number" name="shelf_reserve" id="shelf_reserve" min="1" value="{{ old('shelf_reserve') }}">
                        @error('shelf_reserve')
                            <div class="alert-error-uspas">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                <input type="submit" value="Añadir" class="btn btn-warning">
            </form>

            <input type="file" name="file" id="file">

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

            <!-- Mostrar contenido de la cesta -->
            @php
                $basket = json_decode(Cookie::get('materialsAddBasket','[]'), true);
            @endphp

            @if ($basket)
                <h4>Cesta de Materiales:</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">Nombre</th>
                            <th rowspan="2">Descripción</th>
                            <th colspan="5" class="text-center">Uso</th>
                            <th colspan="5" class="text-center">Reserva</th>
                        </tr>
                        <tr>
                            <th>Cantidad</th><th>Mín</th><th>Armario</th><th>Balda</th><th>Cajón</th>
                            <th>Cantidad</th><th>Mín</th><th>Armario</th><th>Balda</th><th>Cajón</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($basket as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['use']['units'] }}</td>
                                <td>{{ $item['use']['min_units'] }}</td>
                                <td>{{ $item['use']['cabinet'] }}</td>
                                <td>{{ $item['use']['shelf'] }}</td>
                                <td>{{ $item['use']['drawer'] }}</td>
                                <td>{{ $item['reserve']['units'] }}</td>
                                <td>{{ $item['reserve']['min_units'] }}</td>
                                <td>{{ $item['reserve']['cabinet'] }}</td>
                                <td>{{ $item['reserve']['shelf'] }}</td>
                                <td>{{ $item['reserve']['drawer'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <br><br>
            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
