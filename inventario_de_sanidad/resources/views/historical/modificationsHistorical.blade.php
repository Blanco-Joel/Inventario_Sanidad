@extends('layout.app')

@section('title', 'Historial de modificaciones')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
    <div class="">
        <h1 class="">Historial de modificaciones</h1>

        <div class="">
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
                            <td>{{ $modification->first_name }}</td>
                            <td>{{ $modification->last_name }}</td>
                            <td>{{ $modification->email }}</td>
                            <td>{{ $modification->user_type }}</td>
                            <td>{{ $modification->action_datetime }}</td>
                            <td>{{ $modification->created_at }}</td>
                            <td>{{ $modification->material_name }}</td>
                            <td>{{ $modification->units }}</td>
                            <td>{{ $modification->action_datetime }}</td>
                            <td>{{ $modification->storage_type == "reserve"? "reserva" : "uso" }}</td>
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
