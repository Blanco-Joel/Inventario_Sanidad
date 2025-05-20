@extends('layout.app')

@section('title', 'Edicion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/') }}">
@endpush

@section('content')
<div class="">
    <div class="">
        <div class="">
            <table>
                <thead>
                    <tr>
                        <th>ID Material</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <td>{{ $material->material_id }}</td>
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
                                    <input type="submit" value="Editar" class="btn btn-danger">
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

