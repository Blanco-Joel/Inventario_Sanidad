@extends('layout.app')

@section('title', 'Editar Material')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/createMaterial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
<div class="material-form-wrapper">
    <h1>Editar Material</h1>

    <form action="{{ route('materials.update', $material->material_id) }}" method="POST" enctype="multipart/form-data" class="material-form">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $material->name) }}">
            @error('name')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" rows="3">{{ old('description', $material->description) }}</textarea>
            @error('description')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group file-upload">
            <label for="image" class="btn btn-primary">Cambiar Imagen</label>
            <input type="file" name="image" id="image" class="file-upload-input" onchange="previewImage(event, '#imgPreview')">
            <img id="imgPreview"
                 src="{{ asset('storage/' . ($material->image_path ?? 'no_image.jpg')) }}"
                 alt="Previsualización"
                 style="max-width: 150px; display: block; margin-top: 10px;">
            @error('image')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <input type="submit" value="Actualizar" class="btn btn-success">
            <a href="{{ route('materials.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>

    {{-- Flash messages --}}
    @if (session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p class="alert-error-uspas">{{ session('error') }}</p>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/previewImage.js') }}"></script>
    <script>
        // Mostrar nombre de archivo si quieres
        document.getElementById("image").addEventListener("change", function () {
            const fileName = this.files[0]?.name || "Ningún archivo seleccionado";
            // podrías inyectar el nombre en un span si lo necesitas
        });
    </script>
@endpush
