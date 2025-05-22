@extends('layout.app')

@section('title', 'Actualizacion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
<div class="">
    <div class="">
        <h2>Actualizar Datos de Almacenamiento</h2>
        
        <!-- Paginación -->
        <form>
            <input type="text" id="buscarId" placeholder="Buscar..." >
            
            <label>
                <input type="radio" name="regs" value="10" checked>10 registros
            </label>

            <label>
                <input type="radio" name="regs" value="20">20 registros
            </label>
            
            <label>
                <input type="radio" name="regs" value="30">30 registros
            </label>

            <label>
                <input type="radio" name="regs" value="40">40 registros
            </label>
            
            <label>
                <input type="radio" name="regs" value="50">50 registros
            </label>
            
            <label>
                <input type="radio" name="regs" value="60">60 registros
            </label>
        </form>


        <table class="table">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Cantidad mínima</th>
                    <th>Armario</th>
                    <th>Balda</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/storagesUpdate.js') }}" type="text/javascript"></script>
@endpush

