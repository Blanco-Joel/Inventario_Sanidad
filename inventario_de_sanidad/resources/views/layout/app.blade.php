<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Sanidad')</title>

    <!-- Estilos globales -->
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    <!-- Sección para archivos CSS adicionales por página -->
    @stack('styles')
</head>
<body>
<div class="wrapper">
        <!-- Menú lateral (estático) -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <!-- Menú para Administrador -->
                    @if(Auth::user()->role == 'admin')
                        <li class="{{ request()->routeIs('user.create') ? 'active' : '' }}">
                            <a href="{{ route('user.create') }}">Gestión de usuarios</a>
                            <ul class="submenu">
                                <li><a href="{{ route('user.create') }}">Alta de usuarios</a></li>
                                <li><a href="{{  }}">Control</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('material.create') ? 'active' : '' }}">
                            <a href="{{ route('material.create') }}">Gestión de materiales</a>
                            <ul class="submenu">
                                <li><a href="{{ route('material.create') }}">Alta de material</a></li>
                                <li><a href="{{ route('material.delete') }}">Baja de material</a></li>
                                <li><a href="{{ route('material.storage') }}">Gestionar almacenamiento</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('reservation.index') ? 'active' : '' }}">
                            <a href="{{ route('reservation.index') }}">Reservas de materiales</a>
                            <ul class="submenu">
                                <li><a href="{{ route('reservation.used') }}">Materiales en uso</a></li>
                                <li><a href="{{ route('reservation.reserved') }}">Materiales en reserva</a></li>
                                <li><a href="{{ route('reservation.history') }}">Historial de modificaciones</a></li>
                            </ul>
                        </li>
                    @endif

                    <!-- Menú para Estudiantes -->
                    @if(Auth::user()->role == 'student')
                        <li class="{{ request()->routeIs('activity.register') ? 'active' : '' }}">
                            <a href="{{ route('activity.register') }}">Registrar actividad</a>
                        </li>

                        <li class="{{ request()->routeIs('activity.history') ? 'active' : '' }}">
                            <a href="{{ route('activity.history') }}">Historial de actividades</a>
                        </li>
                    @endif

                    <!-- Menú para Docentes -->
                    @if(Auth::user()->role == 'teacher')
                        <li class="{{ request()->routeIs('storage.manage') ? 'active' : '' }}">
                            <a href="{{ route('storage.manage') }}">Gestionar almacenamiento</a>
                        </li>

                        <li class="{{ request()->routeIs('reservation.index') ? 'active' : '' }}">
                            <a href="{{ route('reservation.index') }}">Reservas de materiales</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Contenido principal (cambia según la ruta) -->
        <main class="main-content">
            <!-- Header (estático) -->
            <header>
                <div class="user-info">
                    <span>Bienvenido, {{ Auth::user()->name }}</span>
                    <!-- Aquí puedes poner notificaciones y otras cosas -->
                </div>
            </header>

            <!-- Aquí se insertará el contenido dinámico -->
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
