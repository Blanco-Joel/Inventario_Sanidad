@extends('layout.app')

@section('title', 'Historial de modificaciones')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modifications.css') }}">
@endpush

@section('content')
    <div class="history-container">
        <h1 class="history-title">Historial de modificaciones</h1>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Nombre</th>
                        <th onclick="sortTable(1)">Apellidos</th>
                        <th onclick="sortTable(2)">Email</th>
                        <th onclick="sortTable(3)">Tipo de usuario</th>
                        <th onclick="sortTable(4)">Última modificación</th>
                        <th onclick="sortTable(5)">Fecha de alta</th>
                        <th onclick="sortTable(6)">Material</th>
                        <th onclick="sortTable(7)">Unidades modificadas</th>
                        <th onclick="sortTable(8)">Fecha de acción</th>
                        <th onclick="sortTable(9)">Tipo de almacenamiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modifications as $modification)
                        <tr>
                            <td data-label="Nombre">{{ $modification->first_name }}</td>
                            <td data-label="Apellidos">{{ $modification->last_name }}</td>
                            <td data-label="Email">{{ $modification->email }}</td>
                            <td data-label="Tipo de usuario">{{ $modification->user_type }}</td>
                            <td data-label="Fecha de alta">{{ $modification->action_datetime }}</td>
                            <td data-label="Fecha de creación">{{ $modification->created_at }}</td>
                            <td data-label="Nombre del material">{{ $modification->material_name }}</td>
                            <td data-label="Unidades modificadas">{{ $modification->units }}</td>
                            <td data-label="Fecha de acción">{{ $modification->action_datetime }}</td>
                            <td data-label="Tipo de almacenamiento">{{ $modification->storage_type == "reserve"? "reserva" : "uso" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/') }}"></script>
@endpush
