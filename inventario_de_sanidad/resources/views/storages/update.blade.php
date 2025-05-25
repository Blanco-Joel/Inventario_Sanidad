@extends('layout.app')

@section('title', 'Actualizacion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/update.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
@endpush

@section('content')
<div id="loader-overlay">
    <div class="spinner"></div>
</div>
<div class="">
    <div class="content-wrapper">
        <h2>Gestionar Almacenamiento</h2>
        
        <!-- Buscador -->
        <div class="search-container">
            <input type="text" id="buscarId" placeholder="Buscar..." autocomplete="off">
            <div class="dropdown-container">
                <button type="button" id="filterToggle"><i class="fa-solid fa-filter"></i></button>
                <div id="filterOptions" class="filter-options">
                    <label><input type="radio" name="filtro" value="1" checked>Material</label>
                    <label><input type="radio" name="filtro" value="2">Tipo</label>
                    <label><input type="radio" name="filtro" value="3">Cantidad</label>
                    <label><input type="radio" name="filtro" value="4">Cantidad minima</label>
                    <label><input type="radio" name="filtro" value="5">Armario</label>
                    <label><input type="radio" name="filtro" value="6">Balda</label>
                    <label><input type="radio" name="filtro" value="7">Cajon</label>
                </div>
            </div>
        </div>

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

        <!-- Paginación -->
        <div id="paginacion" class="pagination-controls">
            <div class="pagination-select">
                <label for="regsPorPagina"></label>
                <select id="regsPorPagina">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="pagination-buttons">
                <!-- Botones de paginación se insertarán aquí -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/storagesUpdate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
    <script src="{{ asset('js/tableStorage.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/filterToggle.js') }}"></script>
@endpush

