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
            <button class="tab {{ session('tab', 'tab1') == 'tab1' ? 'active' : '' }}" data-tab="tab1">Alta de usuarios </button>
            <button class="tab {{ session('tab') == 'tab2' ? 'active' : '' }}" data-tab="tab2">Control de usuarios </button>
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

            <dialog id="confirmacionAdmin">
                <p>Introduzca sus credenciales<br> de administrador.</p>
                <p id="errorAdmin"></p>
                <form id="confirmacion">
                    <input type="text" id="adminUser" name="adminUser" ><br>
                    <input type="password" id="adminPass" name="adminPass" ><br>

                    <input type="submit" value="Aceptar" name="aceptar" id="aceptar">
                    <input type="submit" value="Cancelar" name="cancelar" id="cancelar">
                </form>
            </dialog>
            @if (session('mensaje') && session('tab') == 'tab2')
                    <p>{{ session('mensaje') }}</p>
            @endif
            <form>
                <input type="text" id="buscarId" placeholder="Buscar..." >

                <label><input type="radio" name="filtro" value="1" checked>Nombre</label>
                <label><input type="radio" name="filtro" value="2">Apellidos</label>
                <label><input type="radio" name="filtro" value="3">Email</label>
                <label><input type="radio" name="filtro" value="4">Tipo de usuario</label>
                <label><input type="radio" name="filtro" value="5">Última modificación</label>
                <label><input type="radio" name="filtro" value="6">Fecha de alta</label>
            </form><br>

            <table id="tabla-usuarios" border="1">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">Nombre</th>
                            <th onclick="sortTable(1)">Apellidos</th>
                            <th onclick="sortTable(2)">Email</th>
                            <th onclick="sortTable(3)">Tipo de usuario</th>
                            <th onclick="sortTable(4)">Última modificación</th>
                            <th onclick="sortTable(5)">Fecha de alta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $usuario)
                            <tr>
                                <td id="{{ $usuario->first_name }}">{{ $usuario->first_name }}</td>
                                <td id="{{ $usuario->last_name }}">{{ $usuario->last_name }}</td>
                                <td id="{{ $usuario->email }}">{{ $usuario->email }}</td>
                                <td id="{{ $usuario->user_type }}">{{ $usuario->user_type }}</td>
                                <td id="{{ $usuario->last_modified }}">{{ $usuario->last_modified }}</td>
                                <td id="{{ $usuario->created_at }}">{{ $usuario->created_at }}</td>
                                <td>
                                    <form id="btn-ver-{{$usuario->user_id}}"> 
                                    <b>************</b>
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 17" fill="black" width="20px" height="20px">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13c-3.03 0-5.5-2.47-5.5-5.5S8.97 6.5 12 6.5s5.5 2.47 5.5 5.5-2.47 5.5-5.5 5.5zm0-9a3.5 3.5 0 100 7 3.5 3.5 0 000-7z"/>
                                        </svg>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('bajaUsers.process') }}" method="POST" name="registro" id="btn-delete-{{$usuario->user_id}}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$usuario->user_id}}" >

                                        <button  type="submit"   style="background: none; border: none; cursor: pointer;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m5 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                            </svg>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <!-- <form action="{{ route('bajaUsers.process') }}" method="POST" name="registro" id="registrar" >
                @csrf


                <select name="bajaUsersSelect">
                    <option >--Seleccione un usuario--</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id_usuario}}">{{ $user->nombre }} {{ $user->apellidos }} ({{$user->tipo_usuario}})</option>
                        @endforeach      
                </select>
                <input type="submit" value="Dar de baja">
            </form> -->
        </div>
    </div>

    <div>
        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
        <a href="{{ route('welcome_admin') }}" class="btn ">Volver</a>
    </div>

    <script src="{{ asset('js/tabs.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/gestionUsuarios.js') }}" type="text/javascript"></script>
</body>
</html>
