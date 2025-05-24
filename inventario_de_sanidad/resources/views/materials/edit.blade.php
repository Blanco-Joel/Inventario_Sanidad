@extends('layout.app')

@section('title', 'Edicion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="content-wrapper">
        <h2>Edición de materiales</h2>
        
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
                                <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <td>
                                        <input type="text" name="name" id="name" value="{{ $material->name }}">
                                    </td>
                                    <td>
                                        <input type="text" name="description" id="description" value="{{ $material->description }}">
                                    </td>
                                    <td>
                                        <input type="file" name="image" id="image">
                                        <img src="{{ asset('storage/' . ($material->image_path ?? 'no_image.jpg')) }}" style="max-width:100px" alt="">
                                    </td>
                                    
                                    <td>
                                        <input type="submit" value="Editar" class="btn btn-primary">
                                        
                                    </td>

                                </form>
                                <td>
                                    <form action="{{ route('materials.destroy', $material) }}" method="POST">
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
        {{-- @if (session('success'))
            <p class="alert-success">{{ session('success') }}</p>
        @endif --}}

        @if (session('error'))
            <p class="alert-error-uspas">{{ session('error') }}</p>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/') }}"></script>
@endpush

