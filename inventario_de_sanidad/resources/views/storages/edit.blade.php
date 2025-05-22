@extends('layout.app')

@section('title', 'Edicion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
<div class="container">
    <form action="{{ route('storages.updateBatch', $material) }}" method="POST">
        @csrf

        <h2>Editar Almacenamiento para: {{ $material->name }}</h2>

        @php
            $useRecord = $material->storage->where('storage_type', 'use')->first();
            $currentLocation = $useRecord->storage ?? ''; // 'CAE' o 'odontologia'
        @endphp

        <div class="form-group">
            <label for="storage">Localización:</label>
            <select name="storage" id="storage">
                <option value="CAE" {{ $currentLocation == 'CAE' ? 'selected' : '' }}>CAE</option>
                <option value="odontologia" {{ $currentLocation == 'odontologia' ? 'selected' : '' }}>Odontología</option>
            </select>
            @error('storage')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        
        <h3>Datos para Uso</h3>
        @php
            $useRecord = $material->storage->where('storage_type', 'use')->first();
        @endphp
        <div class="form-group">
            <label>Cantidad:</label>
            <input type="number" name="use_units" class="form-control" value="{{ $useRecord->units ?? '-' }}" required>
            @error('use_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Cantidad Mínima:</label>
            <input type="number" name="use_min_units" class="form-control" value="{{ $useRecord->min_units ?? '-' }}" required>
            @error('use_min_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Armario:</label>
            <input type="number" name="use_cabinet" class="form-control" value="{{ $useRecord->cabinet ?? '-' }}" required>
            @error('use_cabinet')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Balda:</label>
            <input type="number" name="use_shelf" class="form-control" value="{{ $useRecord->shelf ?? '-' }}" required>
            @error('use_shelf')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Cajón:</label>
            <input type="number" name="drawer" class="form-control" value="{{ $useRecord->drawer ?? '-' }}" required>
            @error('drawer')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        
        <hr>
        
        <!-- Sección para almacenar datos de "Reserva" -->
        <h3>Datos para Reserva</h3>
        @php
            $reserveRecord = $material->storage->where('storage_type', 'reserve')->first();
        @endphp
        <div class="form-group">
            <label>Cantidad:</label>
            <input type="number" name="reserve_units" class="form-control" value="{{ $reserveRecord->units ?? '' }}" required>
            @error('reserve_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Cantidad Mínima:</label>
            <input type="number" name="reserve_min_units" class="form-control" value="{{ $reserveRecord->min_units ?? '' }}" required>
            @error('reserve_min_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Armario:</label>
            <input type="text" name="reserve_cabinet" class="form-control" value="{{ $reserveRecord->cabinet ?? '' }}" required>
            @error('reserve_cabinet')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Balda:</label>
            <input type="number" name="reserve_shelf" class="form-control" value="{{ $reserveRecord->shelf ?? '' }}" required>
            @error('reserve_shelf')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>
        
        <div>
            <br>
            <input type="checkbox" id="onlyReserve" name="onlyReserve" value="1">
            <label for="onlyReserve">Actualizar solamente reserva</label>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Actualizar Almacenamiento</button>
    </form>

    <!-- Mensajes flash -->
    @if (session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p class="alert-error-uspas">{{ session('error') }}</p>
    @endif

    @if (session('info'))
        <p class="alert-error-uspas">{{ session('info') }}</p>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/') }}"></script>
@endpush
