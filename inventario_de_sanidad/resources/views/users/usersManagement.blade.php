@extends('layout.app')

@section('title', 'Gestión de usuarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style_userManagement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="tabs">
        <button class="tab {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" data-tab="tab1">Alta de usuarios </button>
        <button class="tab {{ session('tab') == 'tab2' ? 'active' : '' }}" data-tab="tab2">Control de usuarios </button>
    </div>
    
    <!-- TAB 1 -->
    <div class="tab-content {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" id="tab1">
        <form action="{{ route('altaUsers.process') }}" method="POST">
            @csrf

            @if (session('mensaje') && session('tab') == 'tab1')
                <p>{{ session('mensaje') }}</p>
            @endif

            <h1>Alta de usuarios</h1>

            <h4>Introduce los datos de los usuarios que deseas registrar.</h4><br>

            <input type="text" id="nombre" name="nombre" placeholder="Nombre">
            @error('nombre')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos">
            @error('apellidos')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        
            <input type="text" id="email" name="email" placeholder="Email">
            @error('email')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        
            <select id="user_type" name="user_type" placeholder="Tipo de usuario">
                <option value="teacher">Docente</option>
                <option value="student">Alumno</option>
                <option value="admin">Administrador</option>
            </select>
            
            <input class="btn btn-primary" type="submit" value="Registrar">
        </form>
    </div>

    <!-- TAB 2 -->
    <div class="tab-content {{ session('tab') == 'tab2' ? 'active' : '' }}" id="tab2">
        <dialog id="confirmacion">
            <p>¿Estás seguro de que deseas eliminar el usuario seleccionado?</p>
            <input type="button" class="btn btn-success" value="Aceptar" id="aceptar">
            <input type="button" class="btn btn-danger" value="Cancelar" id="cancelar">
        </dialog>

        @if (session('mensaje') && session('tab') == 'tab2')
            <p>{{ session('mensaje') }}</p>
        @endif
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
        <form class="search-form">
            <div class="search-container">
                <input type="text" id="buscarId" placeholder="Buscar...">
                <div class="dropdown-container">
                    
                    <button type="button" id="filterToggle"><i class="fa-solid fa-filter"></i></button>
                    
                    <div id="filterOptions" class="filter-options">
                        <label><input type="radio" name="filtro" value="1" checked>Nombre</label>
                        <label><input type="radio" name="filtro" value="2">Apellidos</label>
                        <label><input type="radio" name="filtro" value="3">Email</label>
                        <label><input type="radio" name="filtro" value="4">Tipo de usuario</label>
                        <label><input type="radio" name="filtro" value="5">Fecha de alta</label>
                    </div>
                </div>
            </div>
        </form>
<div class="table-wrapper">

        <table id="tabla-usuarios" class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Tipo de usuario</th>
                    <th>Fecha de alta</th>
                    <th colspan="2">Acciones</th>
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
    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/usersManagement.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('filterToggle');
            const optionsBox = document.getElementById('filterOptions');

            toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            optionsBox.style.display = optionsBox.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', (e) => {
            if (!e.target.closest('.dropdown-container')) {
                optionsBox.style.display = 'none';
            }
            });
        });
    </script>
    <script src="{{ asset('js/tableUser.js') }}"></script>
@endpush
