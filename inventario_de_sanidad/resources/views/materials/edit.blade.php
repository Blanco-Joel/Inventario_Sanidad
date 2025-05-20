<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edición de Materiales</title>
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
                <div class="header">Menú de Administrador - EDICIÓN DE MATERIALES</div>
                <br>
                <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
                <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

                <div class="input-group">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Material</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <td>{{ $material->material_id }}</td>
                                        <td>
                                            <input type="text" name="name" id="name" value="{{ $material->name }}">
                                        </td>
                                        <td>
                                            <input type="text" name="description" id="description" value="{{ $material->description }}">
                                        </td>
                                        <td>
                                            <input type="file" name="image" id="image">
                                            <img src="{{ asset('storage/' . ($material->image_path ?? 'no_image.jpg')) }}" style="max-width:100px" alt="">
                                        </td>
                                        <td>
                                            <input type="submit" value="Editar" class="btn btn-danger">
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $materials->links() }}
                    </div>
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
