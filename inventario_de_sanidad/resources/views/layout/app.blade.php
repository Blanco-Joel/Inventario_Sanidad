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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Sección para archivos CSS adicionales por página -->
    @stack('styles')
</head>
<body>
<div class="wrapper">
    <header class="header">
        <!-- Notificaciones -->
        <div>
            <button class="btn btn-secondary" aria-label="Notificaciones">
                <i class="fa-solid fa-bell"></i>
            </button>

            <!-- Notificaciones de alerta -->
            @php
                use App\Models\User;
                use App\Models\Storage;
                use Illuminate\Support\Facades\Cookie;

                $user = User::where('user_id', Cookie::get('USERPASS'))->first();
                $notifications = [];

                if ($user && $user->type === 'admin') {
                    $notifications = Storage::join('materials', 'storages.material_id', '=', 'materials.material_id')
                        ->select('materials.name', 'storages.units', 'storage_type')
                        ->whereColumn('storages.units', '<', 'storages.min_units')
                        ->get();
                }
            @endphp

            @if(count($notifications))
                <div class="notifications-alert">
                    <h4>WARNING</h4>
                    @foreach ($notifications as $warning)
                        <p>{{ $warning->name }} tiene solo {{ $warning->units }} unidad/es en {{ $warning->storage_type == "use" ? "use" : "reserva" }}.</p>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- Informacion del usuario -->
        <div class="user-info">
            <span>{{ Cookie::get('NAME') }}</span>
        </div>

        <!-- LOGOUT -->
        <div class="logout">
            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </header>

    <div class="content-wrapper">
        <!-- Menú lateral (estático) -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <!-- Menú para Administrador -->
                    @if(Cookie::get('TYPE') === 'admin')
                        <li class="{{ request()->routeIs('user.create') ? 'active' : '' }}">
                            <a href="">Gestión de usuarios</a>
                            <ul class="submenu">
                                <li><a href="{{ route('users.usersManagement') }}">Gestión de usuarios</a></li>
                                <li><a href="{{ route('materials.dashboard') }}">Gestión de materiales</a></li>
                                <li><a href="{{ route('historical.historicalSubmenu') }}">Reservas de Materiales</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('material.create') ? 'active' : '' }}">
                            <a href="">Gestión de materiales</a>
                            <ul class="submenu">
                                <li><a href="">Alta de material</a></li>
                                <li><a href="">Baja de material</a></li>
                                <li><a href="">Gestionar almacenamiento</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('reservation.index') ? 'active' : '' }}">
                            <a href="">Reservas de materiales</a>
                            <ul class="submenu">
                                <li><a href="">Materiales en uso</a></li>
                                <li><a href="">Materiales en reserva</a></li>
                                <li><a href="">Historial de modificaciones</a></li>
                            </ul>
                        </li>
                    @endif

                    <!-- Menú para Estudiantes -->
                    @if(Cookie::get('TYPE') === 'student')
                        <li class="">
                            <a href="">Registrar actividad</a>
                        </li>

                        <li class="">
                            <a href="">Historial de actividades</a>
                        </li>
                    @endif

                    <!-- Menú para Docentes -->
                    @if(Cookie::get('TYPE') === 'teacher')
                        <li class="">
                            <a href="">Gestionar almacenamiento</a>
                        </li>

                        <li class="">
                            <a href="">Reservas de materiales</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Contenido principal (cambia según la ruta) -->
        <main class="main-content">

            <!-- Aquí se insertará el contenido dinámico -->
            @yield('content')
        </main>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
