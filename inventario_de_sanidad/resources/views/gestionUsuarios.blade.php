<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Portal del departamento de Sanidad</title>
    <link rel="stylesheet" href="{{ asset('css/style_gestionUsuarios.css') }}">
</head>
<body>
    <div>
        <div class="tabs">
            <button class="tab {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" data-tab="tab1">Alta de users</button>
            <button class="tab {{ session('tab') == 'tab2' ? 'active' : '' }}" data-tab="tab2">Baja de users</button>
        </div>
        
        <div class="tab-content {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" id="tab1">
            <form action="{{ route('altaUsers.process') }}" method="POST">
                @csrf
                @if (session('mensaje') && session('tab') == 'tab1')
                    <p>{{ session('mensaje') }}</p>
                @endif


                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" >
                    @error('nombre')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" >
                    @error('apellidos')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="email">email</label>
                    <input type="text" id="email" name="email" >
                    @error('email')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="user_type">Tipo de user</label>
                    <select id="user_type" name="user_type" >
                        <option value="teacher">Docente</option>
                        <option value="student">Alumno</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>



                <input type="submit" value="Registrar">
            </form>
        </div>

        <div class="tab-content {{ session('tab') == 'tab2' ? 'active' : '' }}" id="tab2">
            <dialog id="confirmacion">
                <p>¿Estás seguro de que deseas continuar?</p>
                <input type="button" value="Aceptar" name="aceptar" id="aceptar">
                <input type="button" value="Cancelar" name="cancelar" id="cancelar">
            </dialog>
            <form action="{{ route('bajaUsers.process') }}" method="POST" name="registro" id="registrar" >
                @csrf

                @if (session('mensaje') && session('tab') == 'tab2')
                    <p>{{ session('mensaje') }}</p>
                @endif
                <select name="bajaUsersSelect">
                    <option >--Seleccione un usuario--</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id_usuario}}">{{ $user->nombre }} {{ $user->apellidos }} ({{$user->tipo_usuario}})</option>
                        @endforeach      
                </select>
                <input type="submit" value="Dar de baja">
            </form>
        </div>
    </div>

    <div>
        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        <a href="{{ route('welcome_docentes') }}" class="btn ">Volver</a>
    </div>

    <script src="{{ asset('js/tabs.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/gestionUsuarios.js') }}" type="text/javascript"></script>
</body>
</html>
