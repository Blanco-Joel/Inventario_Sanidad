@extends('layout.app')

@section('title', 'Materiales en uso')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/') }}">
@endpush

@section('content')
    <div class="">
        <h1 class="">Materiales en uso</h1>

        @if($materials->isEmpty())
            <div class="">No hay materiales en uso actualmente.</div>
        @else
            <form method="GET" action="{{ route('historical.type', ['type' => 'use'])}}">
                <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="{{ request('busqueda') }}">
                <button type="submit">Buscar</button>
            </form>
            <br>
            <div class="">
                @foreach($materials as $material)
                    <div class="">
                        <div class="">
                            <img src="{{ asset($material->image_path) }}" class="" alt="{{ $material->name }}">
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
