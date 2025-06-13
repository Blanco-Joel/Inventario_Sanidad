@extends('layout.app')

@section('title', 'Edicion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/storages/editMaterialTeacher.css') }}">
@endpush

@section('content')
<div class="">
    <div class="edit-container">
        @php
            $useRecord = $material->storage->where('storage_type', 'use')->where('storage',$currentLocation)->first();
        @endphp
        <form action="{{ route('storages.subtract.teacher', [$material->material_id, $currentLocation]) }}" method="POST">
            @csrf

            <h1>Editar Almacenamiento para: {{ $material->name }} / {{ $currentLocation == "CAE" ? "CAE" : "Odontología" }}</h1>

            <div class="form-group">
                <label for="use_units">Unidades en Uso</label>
                <input id="use_units" type="number" name="use_units" class="form-control input-gray" value="{{ $useRecord->units ?? '0' }}" readonly>
            </div>
            @error('use_units')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="subtract_units">Unidades a restar</label>
                <input id="subtract_units" type="number" placeholder="Cantidad a restar" name="subtract_units" class="form-control" value="0" min="0" max="{{ $useRecord->units ?? '0' }}" required>
            </div>
            
            <br>
            <div class="form-actions">
                <input type="submit" value="Actualizar Almacenamiento" class="btn btn-primary">
                <a href="{{ route('storages.updateView') }}" class="btn btn-danger">Cancelar</a>
            </div>
            <br>
        </form>

        <!-- Mensajes flash -->
        @if (session('success'))
            <p class="alert-success">{{ session('success') }}</p>
        @endif

        <!-- Mensajes de error -->
        @if (session('error'))
            <p class="alert-error-uspas">{{ session('error') }}</p>
        @endif

        <!-- Info -->
        @if (session('info'))
            <p class="alert-error-uspas">{{ session('info') }}</p>
        @endif

        @error('subtract_units')
            <p class="alert-error-uspas">{{ $message }}</p>
        @enderror
    </div>
</div>
@endsection


