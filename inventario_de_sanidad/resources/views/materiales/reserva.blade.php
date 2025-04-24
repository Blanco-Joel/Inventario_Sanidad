<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materiales en Reserva</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Materiales en Reserva</h1>

        @if($materialesReserva->isEmpty())
            <div class="alert alert-warning">No hay materiales en reserva actualmente.</div>
        @else
            <form method="GET" action="{{ route('materiales.reserva') }}">
                <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="{{ request('busqueda') }}">
                <button type="submit">Buscar</button>
            </form>
            <br>
            <div class="row">
                @foreach($materialesReserva as $material)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset($material->ruta_imagen) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $material->nombre }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $material->nombre }}</h5>
                                <p class="card-text">{{ $material->descripcion }}</p>
                                <ul class="list-unstyled">
                                    <li><strong>Armario:</strong> {{ $material->armario }}</li>
                                    <li><strong>Balda:</strong> {{ $material->balda }}</li>
                                    <li><strong>Unidades:</strong> {{ $material->unidades }}</li>
                                    <li><strong>Mínimo:</strong> {{ $material->min_unidades }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
