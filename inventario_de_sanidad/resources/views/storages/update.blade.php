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
            a, a:hover, a:visited {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Portal del Departamento de Sanidad</h1>

            <div class="card">
                <div class="header">Menú de {{ Cookie::get('TYPE') === 'admin' ? 'Administrador' : 'Docentes' }} - GESTIONAR ALMACENAMIENTO</div>
                <br>
                <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
                <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

                <h2>Actualizar Datos de Almacenamiento</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Cantidad mínima</th>
                            <th>Armario</th>
                            <th>Balda</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($storages as $material)
                            @php
                                $useRecord = $material->storage->where('storage_type', 'use')->first();
                                $reserveRecord = $material->storage->where('storage_type', 'reserve')->first();
                            @endphp
                            <tr>
                                <td rowspan="2">{{ $material->name }}</td>
                                <td>Uso</td>
                                <td>{{ $useRecord ? $useRecord->units : '-' }}</td>
                                <td>{{ $useRecord ? $useRecord->min_units : '-' }}</td>
                                <td>{{ $useRecord ? $useRecord->cabinet : '-' }}</td>
                                <td>{{ $useRecord ? $useRecord->shelf : '-' }}</td>
                                <td rowspan="2">
                                    <a href="{{ Cookie::get('TYPE') === 'admin' ? route('storages.edit', $material) : route('storages.teacher.edit', $material) }}" class="btn btn-warning">Editar</a>
                                </td>
                            </tr>
                            <tr>
                            <td>Reserva</td>
                                <td>{{ $reserveRecord ? $reserveRecord->units : '-' }}</td>
                                <td>{{ $reserveRecord ? $reserveRecord->min_units : '-' }}</td>
                                <td>{{ $reserveRecord ? $reserveRecord->cabinet : '-' }}</td>
                                <td>{{ $reserveRecord ? $reserveRecord->shelf : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $storages->links() }}
                </div>

                <br>
                <button onclick="window.location.href='{{ Cookie::get('TYPE') === 'admin' ? route('materials.dashboard') : route('welcome_teacher') }}'" class="btn btn-warning">Volver</button>

                <br><br>
                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </body>
</html>
