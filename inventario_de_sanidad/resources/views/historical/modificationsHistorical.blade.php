@extends('layout.app')

@section('title', 'Historial de modificaciones')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modifications.css') }}">
@endpush

@section('content')
    <div class="history-container">
        <h1 class="history-title">Historial de modificaciones</h1>
        <form>
            <input type="text" id="buscarId" placeholder="Buscar..." >
            <label><input type="radio" name="regs" value="10" checked>10 registros</label>
            <label><input type="radio" name="regs" value="20">20 registros</label>
            <label><input type="radio" name="regs" value="30">30 registros</label>
            <label><input type="radio" name="regs" value="40">40 registros</label>
            <label><input type="radio" name="regs" value="50">50 registros</label>
            <label><input type="radio" name="regs" value="60">60 registros</label>
        </form>
        <label><input type="radio" name="filtro" value="1" checked>Nombre</label>
        <label><input type="radio" name="filtro" value="2">Apellidos</label>
        <label><input type="radio" name="filtro" value="3">Email</label>
        <label><input type="radio" name="filtro" value="4">Tipo de usuario</label>
        <label><input type="radio" name="filtro" value="5">Material</label>
        <label><input type="radio" name="filtro" value="6">Unidades modificadas</label>
        <label><input type="radio" name="filtro" value="7">Tipo de almacenamiento</label>
        <label><input type="radio" name="filtro" value="8">Fecha de modificación</label>
        <div class="">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Tipo de usuario</th>
                        <th>Material</th>
                        <th>Unidades modificadas</th>
                        <th>Tipo de almacenamiento</th>
                        <th>Fecha de modificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // @foreach ($modifications as $modification)
                    //     <tr>
                    //         <td data-label="Nombre">{{ $modification->first_name }}</td>
                    //         <td data-label="Apellidos">{{ $modification->last_name }}</td>
                    //         <td data-label="Email">{{ $modification->email }}</td>
                    //         <td data-label="Tipo de usuario">{{ $modification->user_type }}</td>
                    //         <td data-label="Fecha de alta">{{ $modification->action_datetime }}</td>
                    //         <td data-label="Fecha de creación">{{ $modification->created_at }}</td>
                    //         <td data-label="Nombre del material">{{ $modification->material_name }}</td>
                    //         <td data-label="Unidades modificadas">{{ $modification->units }}</td>
                    //         <td data-label="Fecha de acción">{{ $modification->action_datetime }}</td>
                    //         <td data-label="Tipo de almacenamiento">{{ $modification->storage_type == "reserve"? "reserva" : "uso" }}</td>
                    //     </tr>
                    // @endforeach
                    ?>
                </tbody>
            </table>
        </div>
        <div id="paginacion" class="pagination-controls">
        <!-- Aquí se inyectarán los botones de paginación desde JS -->
    </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/historicalFunctions.js') }}"></script>
    <script src="{{ asset('js/tableHistorical.js') }}"></script>
@endpush
