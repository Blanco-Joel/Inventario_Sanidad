@extends('layout.app')

@section('title', 'Materiales en reserva')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/') }}">
@endpush

@section('content')
    <div class="">
        <h1 class="">Materiales en Reserva</h1>

        @if($materials->isEmpty())
            <div class="alert alert-warning">No hay materiales en reserva actualmente.</div>
        @else
            <form method="GET" action="{{ route('historical.type', ['type' => 'reserve']) }}">
                <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="{{ request('busqueda') }}">
                <button type="submit">Buscar</button>
            </form>
            <br>
            <div class="">
                @foreach($materials as $material)
                    <div class="">
                        <div class="">
                            <img src="{{ asset($material->image_path) }}" class="" style="height: 200px; object-fit: cover;" alt="{{ $material->name }}">
                            <div class="">
                                <h5 class="">{{ $material->name }}</h5>
                                <p class="">{{ $material->description }}</p>
                                <ul class="">
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
        
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/') }}"></script>
@endpush

