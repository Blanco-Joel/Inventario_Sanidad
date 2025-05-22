@extends('layout.app')

@section('title', 'Edicion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
<div class="">
    <div class="">
        <form action="{{ route('storages.subtract.teacher', $material->material_id) }}" method="POST">
            @csrf

            <h2>Editar Almacenamiento para: {{ $material->name }}</h2>
            
            <h3>Datos para Uso</h3>

            @php
                $useRecord = $material->storage->where('storage_type', 'use')->first();
            @endphp

            <input type="number" placeholder="Cantidad a agregar" name="add_units" class="form-control" value="0" min="0" max="{{ $useRecord->units ?? '-' }}" required>
            @error('use_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
            
             
            <input type="number" placeholder="Cantidad a restar" name="subtract_units" class="form-control" value="0" min="0" max="{{ $useRecord->units ?? '-' }}" required>
            @error('subtract_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
            
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

        <br><br>
        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/') }}"></script>
@endpush

