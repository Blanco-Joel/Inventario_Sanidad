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
                <button class="tab active" data-tab="tab1">Alta de usuarios</button>
                <button class="tab" data-tab="tab2">Baja de usuarios</button>
            </div>
            
            <div class="tab-content active" id="tab1">
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

                    <button type="submit" class="submit-button">Registrar</button>
                </form>

            </div>
            <div class="tab-content" id="tab2">
                Contenido de la pestaña 2
            </div>
        </div>
        <div>
            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
    <script src="{{ asset('js/tabs.js') }}" type="text/javascript"></script>

    </body>
</html>