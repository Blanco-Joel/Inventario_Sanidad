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
            <button class="tab {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" data-tab="tab1">Alta de usuarios</button>
            <button class="tab {{ session('tab') == 'tab2' ? 'active' : '' }}" data-tab="tab2">Baja de usuarios</button>
        </div>
        
        <div class="tab-content {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" id="tab1">
            <form action="{{ route('altaUsers.process') }}" method="POST">
                @csrf
                
                <div class="input-group">
                    <label for="id_usuario">ID Usuario</label>
                    <input type="text" id="id_usuario" name="id_usuario" >
                    @error('id_usuario')
                        <div class="alert-error-uspas">{{ $message }}</div>
                    @enderror
                </div>

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
                    <label for="tipo_usuario">Tipo de Usuario</label>
                    <select id="tipo_usuario" name="tipo_usuario" >
                        <option value="docente">Docente</option>
                        <option value="alumno">Alumno</option>
                    </select>
                </div>

                @if (session('mensaje') && session('tab') == 'tab1')
                    <p>{{ session('mensaje') }}</p>
                @endif

                <button type="submit" class="submit-button">Registrar</button>
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

                <input type="submit" value="Registrarme">
            </form>
        </div>
    </div>

    <div>
        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <script src="{{ asset('js/tabs.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/gestionUsuarios.js') }}" type="text/javascript"></script>
</body>
</html>