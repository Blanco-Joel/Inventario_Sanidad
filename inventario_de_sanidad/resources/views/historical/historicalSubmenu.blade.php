@extends('layout.app')

@section('title', 'Historial de Materiales')

@push('styles')
    
@endpush

@section('content')
    <div>
        <h1>Portal del departamento de Sanidad</h1> 
        <div>
            <div>Menú de administradores </div>
            <div id="name"><b>Bienvenido/a: </b> {{ Cookie::get('NAME') }}</div>
            <b>Identificador Empleado: </b> {{ Cookie::get('USERPASS') }}
            <!-- Botones del menú -->
            <button onclick="window.location.href='{{ route('historical.type', ['type' => 'use']) }}'" class="btn btn-primary">Materiales en uso</button>
            <button onclick="window.location.href='{{ route('historical.type', ['type' => 'reserve']) }}'" class="btn btn-primary">Materiales en reserva</button>
            <button onclick="window.location.href='{{ route('historical.modificationsHistorical') }}'" class="btn btn-primary">Historial de modificaciones</button>
        </div>
    </div>
@endsection

@push('scripts')
    
@endpush

</html>