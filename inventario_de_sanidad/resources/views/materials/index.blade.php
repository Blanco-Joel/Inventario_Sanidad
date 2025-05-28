@extends('layout.app')

@section('title', 'Gestión de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    @php
    //<link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    @endphp
    
@endpush

@section('content')
<div id="loader-overlay">
    <div class="spinner"></div>
</div> 
<div class="container">
    <div class="content-wrapper">
        <h2>Gestión de materiales</h2>
        <form>
            <input type="text" id="buscarId" placeholder="Buscar..." autocomplete="off">
            <label><input type="radio" name="regs" value="10" checked>10 registros</label>
            <label><input type="radio" name="regs" value="20">20 registros</label>
            <label><input type="radio" name="regs" value="30">30 registros</label>
            <label><input type="radio" name="regs" value="40">40 registros</label>
            <label><input type="radio" name="regs" value="50">50 registros</label>
            <label><input type="radio" name="regs" value="60">60 registros</label>
        </form>
        <label><input type="radio" name="filtro" value="1" checked>Nombre</label>
        <label><input type="radio" name="filtro" value="2">Descripción</label>
        <label><input type="radio" name="filtro" value="3">Imagen</label>

        <div class="">
            <dialog id="confirmacion">
                <p>¿Estás seguro de que deseas eliminar el usuario seleccionado?</p>
                <input type="button" class="btn btn-success" value="Aceptar" id="aceptar">
                <input type="button" class="btn btn-danger" value="Cancelar" id="cancelar">
            </dialog>
            <div class="table-wrapper">
                <table class="table custom-scroll">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>{{ $material->name }}</td>
                                <td>{{ $material->description }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . ($material->image_path ?? 'no_image.jpg')) }}" style="max-width:100px" alt="">
                                </td>
                                <td>
                                    <a href="{{ route('materials.edit', $material->material_id) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('materials.destroy', $material->material_id) }}" method="POST">
                                        @csrf
                                        <input type="submit" value="Eliminar" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $materials->links() }}
            </div>
        </div>

        <!-- Mensajes flash -->
        @if (session('success'))
            <p class="alert-success">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="alert-error-uspas">{{ session('error') }}</p>
        @endif

        <div id="paginacion" class="pagination-controls">
            <!-- Aquí se inyectarán los botones de paginación desde JS -->
        </div>
</div>
@endsection

@push('scripts')
    @php
    //<script src="{{ asset('js/materialEdit.js') }}"></script>
    //<script src="{{ asset('js/loader.js') }}"></script>
    //<script src="{{ asset('js/tableMaterial.js') }}"></script>
    @endphp
@endpush

