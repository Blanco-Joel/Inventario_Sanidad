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

    <script src="{{ asset('js/darkmode.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<div class="wrapper">
    <header class="header">
        <!-- Logo -->
        <div class="logo">
            <!--<img src="{{ asset('img/logo.png') }}" alt="logo">  -->
        </div>

        <div class="header-right">
            <!-- DarkMode Toggle -->
            <button class="btn btn-outline btn-notifications" id="theme-switch" type="button">
                <i class="fa-solid fa-sun"></i>
                <i class="fa-solid fa-moon"></i>
            </button>

            <!-- Notificaciones de alerta -->
            @php
                use App\Models\User;
                use App\Models\Storage;
                use Illuminate\Support\Facades\Cookie;

                $user = User::where('user_id', Cookie::get('USERPASS'))->first();
                
                $notifications = collect();

                if ($user && $user->user_type === 'admin') {
                    $notifications = Storage::join('materials', 'storages.material_id', '=', 'materials.material_id')
                        ->select('materials.name', 'storages.units', 'storage_type')
                        ->whereColumn('storages.units', '<', 'storages.min_units')
                        ->get();
                }
            @endphp

            <!-- Notificaciones -->
            <div>
                <div class="notifications-alert">
                    <button id="btn-notifications" class="btn btn-primary btn-notifications">
                        <i class="fa-solid fa-bell"></i>
                        @if($notifications->isNotEmpty())
                            <span id="notification-count" class="notification-count">{{ $notifications->count() }}</span>
                        @endif
                    </button>
                </div>

                <div id="notifications-list" class="notifications-list">
                    @if($notifications->isNotEmpty())
                        @foreach ($notifications as $warning)
                            <p>{{$warning->name}} tiene solo {{$warning->units}} unidad/es en {{$warning->storage_type ==  "use" ? "uso" : "reserva"}}.</p>
                        @endforeach
                    @else
                        <p>No hay notificaciones</p>
                    @endif
                </div>

            </div>

            <!-- Contenedor del usuario -->
            <div class="user-dropdown">
                <!-- Info del usuario -->
                <div class="user-info" id="user-info-toggle">
                    <i class="fa-solid fa-user"></i>
                    <span>{{ Cookie::get('NAME') }}</span>
                </div>

                <!-- Logout oculto por defecto -->
                <div class="logout" id="logout-section" style="display: none;">
                    <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </header>

    <div class="content-wrapper">

        <!-- Menú lateral (estático) -->
        <aside class="sidebar">
            <!-- Menú  -->
            <nav>
                <ul>
                    <!-- Menú para Administrador -->
                    @if(Cookie::get('TYPE') === 'admin')
                        <li class="has-submenu">
                            <a href="">
                                <i class="fa-solid fa-user"></i>
                                <span class="link-text">Gestión de usuarios</span>
                                <i class="fa-solid fa-chevron-down arrow-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('users.usersManagement') }}">
                                        <i class="fa-solid fa-users-gear"></i>
                                        <span class="link-text">Gestión de usuarios </span>   
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="">
                                <i class="fa-solid fa-clipboard-list"></i>
                                <span class="link-text">Gestión de materiales</span>
                                <i class="fa-solid fa-chevron-down arrow-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('materials.create') }}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span class="link-text"> Alta de material </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('materials.delete') }}">
                                        <i class="fa-solid fa-minus"></i>
                                        <span class="link-text"> Baja de material </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('storages.updateView') }}">
                                        <i class="fa-solid fa-box-archive"></i>
                                        <span class="link-text"> Gestionar almacenamiento </span>
                                    </a>
                                </li>  
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <span class="link-text">Reservas de materiales</span>
                                <i class="fa-solid fa-chevron-down arrow-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('historical.historicalSubmenu') }}">
                                        <i class="fa-solid fa-book-bookmark"></i>
                                        <span class="link-text"> Submenu </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('historical.type', ['type' => 'use']) }}">
                                        <i class="fa-solid fa-book-open"></i>
                                        <span class="link-text"> Materiales en uso </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('historical.type', ['type' => 'reserve']) }}">
                                        <i class="fa-solid fa-boxes-packing"></i>
                                        <span class="link-text"> Materiales en reserva </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('historical.modificationsHistorical') }}">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        <span class="link-text"> Historial de modificaciones </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <!-- Menú para Estudiantes -->
                    @if(Cookie::get('TYPE') === 'student')
                        <li>
                            <a href="">
                                <i class="fa-solid fa-pen"></i>
                                <span class="link-text">Registrar actividad</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span class="link-text">Historial de actividades </span>
                            </a>
                        </li>
                    @endif

                    <!-- Menú para Docentes -->
                    @if(Cookie::get('TYPE') === 'teacher')
                        <li>
                            <a href="">
                                <i class="fa-solid fa-box-archive"></i>
                                <span class="link-text"> Gestionar almacenamiento </span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <span class="link-text"> Reservas de materiales </span>
                            </a>
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
    
    @stack('scripts')
</body>
</html>
