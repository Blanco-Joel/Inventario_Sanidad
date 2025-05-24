@extends('layout.app')

@section('title', 'Actualizacion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/update.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
@endpush

@section('content')
{{-- <div id="loader-overlay">
    <div class="spinner"></div>
</div> --}}
<div class="container">
    <div class="content-wrapper">
        <h2>Gestionar Almacenamiento</h2>
        
        <!-- Paginación -->
        <form>
            <input type="text" id="buscarId" placeholder="Buscar..." >
            <label><input type="radio" name="regs" value="10" checked>10 registros</label>
            <label><input type="radio" name="regs" value="20">20 registros</label>
            <label><input type="radio" name="regs" value="30">30 registros</label>
            <label><input type="radio" name="regs" value="40">40 registros</label>
            <label><input type="radio" name="regs" value="50">50 registros</label>
            <label><input type="radio" name="regs" value="60">60 registros</label>
        </form>
        <label><input type="radio" name="filtro" value="1" checked>Material</label>
        <label><input type="radio" name="filtro" value="2">Descripción</label>
        <label><input type="radio" name="filtro" value="3">Cantidad</label>
        <label><input type="radio" name="filtro" value="4">Mínima</label>
        <label><input type="radio" name="filtro" value="5">Armario</label>
        <label><input type="radio" name="filtro" value="6">Balda</label>

<div class="table-wrapper">

        <table class="table">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Cantidad mínima</th>
                    <th>Armario</th>
                    <th>Balda</th>
                    <th>Cajón</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <div id="paginacion" class="pagination-controls">
            <!-- Aquí se inyectarán los botones de paginación desde JS -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/storagesUpdate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/tableStorage.js') }}" type="text/javascript"></script>
@endpush

