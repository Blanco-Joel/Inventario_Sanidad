<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Portal del departamento de Sanidad</title>
    <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">

</head>
<body>
    <dialog id="firstLogDialog" >
        <div  class="text-center" >
            <h3>Cambiar Contraseña</h3>
            <p>En el primer ingrso a la página se ha<br> de cambiar la contraseña.</p>
            <form id="FirstLogForm"  action="{{ route('changePasswordFirstLog') }}" method="POST">
                @csrf

                <label for="newPassword">Nueva Contraseña</label><br>
                <input type="password" id="newPassword" name="newPassword" ><br><br>
            
                <label for="confirmPassword">Confirmar Nueva Contraseña</label><br>
                <input type="password" id="confirmPassword" name="confirmPassword" ><br><br>
                
                <p id="error"></p>
                <button type="submit">Cambiar Contraseña</button>
            </form>
        </div>
    </dialog>
    <div class="container">
        <h1 class="text-center">Portal del departamento de Sanidad</h1> 
        
        <div class="card ">
            <div class="header">Menú de administradores </div><br>
                <div id="name"><b>Bienvenido/a: </b> {{ Cookie::get('NAME') }}</div><br><br>
                <b>Identificador Empleado: </b> {{ Cookie::get('USERPASS') }}<br><br>
                @if (session('mensaje'))
                    <p>{{ session('mensaje') }}</p>
                @endif
                <!-- Botones del menú -->
                <button onclick="window.location.href='{{ route('users.usersManagement') }}'" class="btn btn-warning">Gestión de usuarios</button>
                <button onclick="window.location.href='{{ route('materials.dashboard') }}'" class="btn btn-warning">Gestión de materiales</button>
                <button onclick="window.location.href='{{ route('historical.historicalSubmenu') }}'" class="btn btn-warning">Reservas de Materiales</button>
                <br><br>

                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
                @if($data->isNotEmpty())
                    <h4>WARNING</h4>
                    @foreach ($data as $warning)
                        <p>{{$warning->name}} tiene solo {{$warning->units}} unidad/es en {{$warning->storage_type ==  "use" ? "uso" : "reserva";}}.</p>
                    @endforeach
                @endif
        </div>
        
    </div>
</body>
<script src="{{ asset('js/firstWelcome.js') }}" type="text/javascript"></script>

</html>
