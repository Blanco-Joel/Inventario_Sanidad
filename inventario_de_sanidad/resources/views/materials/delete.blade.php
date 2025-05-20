@extends('layout.app')

@section('title', 'Baja de materiales')

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
                                <td>{{ $material->material_id }}</td>
                                <td>{{ $material->name }}</td>
                                <td>{{ $material->description }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . ($material->image_path ?? 'no_image.jpg')) }}" style="max-width:100px" alt="">
                                </td>
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
                {{-- Enlaces de paginación --}}
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
