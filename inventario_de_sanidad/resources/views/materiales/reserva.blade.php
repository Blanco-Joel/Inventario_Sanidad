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

        @if($materiales->isEmpty())
            <div class="alert alert-warning">No hay materiales en reserva actualmente.</div>
        @else
            <form method="GET" action="{{ route('materiales.tipo', ['tipo' => 'reserva']) }}">
                <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="{{ request('busqueda') }}">
                <button type="submit">Buscar</button>
            </form>
            <br>
            <div class="row">
                @foreach($materiales as $material)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset($material->image_path) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $material->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $material->name }}</h5>
                                <p class="card-text">{{ $material->description }}</p>
                                <ul class="list-unstyled">
                                    <li><strong>Armario:</strong> {{ $material->cabinet }}</li>
                                    <li><strong>Balda:</strong> {{ $material->shelf }}</li>
                                    <li><strong>Unidades:</strong> {{ $material->units }}</li>
                                    <li><strong>Mínimo:</strong> {{ $material->min_units }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('materiales.submenuHistorial') }}" class="btn ">Volver</a>

    </div>
</body>
</html>
