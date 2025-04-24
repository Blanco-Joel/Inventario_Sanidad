<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baja de Materiales</title>
    <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">
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
            <form action="{{ route('add.process') }}" method="POST">
                @csrf
                <div class="input-group">
                    <select name="material" id="material">
                        <option value="">-- Seleccionar material --</option>
                        @foreach ($materiales as $material)
                            <option value="{{ $material->id_material }}">{{ $material->nombre }} -> {{ $material->descripcion }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="submit" value="Añadir" class="btn btn-warning">
            </form>

            <!-- Formulario para confirmar el alta de materiales guardados en la cesta -->
            <form action="{{ route('bajaMaterial.process') }}" method="POST">
                @csrf
                <input type="submit" value="Baja" class="btn btn-warning">
            </form>

            <button onclick="window.location.href='{{ route('gestionMateriales') }}'" class="btn btn-warning">Volver</button>

            <!-- Mensajes flash -->
            @if (session('success'))
                <p class="alert-success">{{ session('success') }}</p>
            @endif

            @if (session('error'))
                <p class="alert-error-uspas">{{ session('error') }}</p>
            @endif

            <!-- Mostrar el contenido de la cookie de la cesta. Se decodifica el JSON y se presenta de forma estructurada. -->
            @php
                $cesta = Cookie::get('cestaMaterialesBaja', '[]');
                $cestaArray = json_decode($cesta, true);
            @endphp

            @if (!empty($cestaArray) && is_array($cestaArray))
                <h4>Cesta de Materiales:</h4>
                <ul>
                    @foreach ($cestaArray as $item)
                        <li>
                            <strong>ID:</strong> {{ $item['id_material'] }}
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
