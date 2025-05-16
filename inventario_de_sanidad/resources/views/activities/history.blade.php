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
            <div class="header">Menú de Alumno - HISTORIAL ACTIVIDAD</div>
            <br>
            <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
            <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

            <h2>Mis Actividades</h2>

        @forelse($activities as $activity)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $activity->created_at->format('d/m/Y H:i') }}  
                </div>
                <div class="card-body">
                    <p><strong>Descripción:</strong> {{ $activity->description }}</p>

                    @if($activity->materials->isEmpty())
                    <p><em>No se usaron materiales.</em></p>
                    @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Material</th>
                            <th>Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activity->materials as $material)
                            <tr>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->pivot->units }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        @empty
            <p>No has registrado ninguna actividad aún.</p>
        @endforelse

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
</html>
