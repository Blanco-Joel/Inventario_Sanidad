<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar almacenamiento</title>
        <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">
        <style>
            table, th, td {
                border: 1px solid;
            }
            a, a:hover, a:visited {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Portal del Departamento de Sanidad</h1>

            <div class="card">
                <div class="header">Menú de {{ Cookie::get('TYPE') === 'admin' ? 'Administrador' : 'Docentes' }} - GESTIONAR ALMACENAMIENTO</div>
                <br>
                <b>Bienvenido/a:</b> {{ Cookie::get('NAME') }}<br><br>
                <b>Identificador Empleado:</b> {{ Cookie::get('USERPASS') }}<br><br>

                <h2>Actualizar Datos de Almacenamiento</h2>
                <form>
                <input type="text" id="buscarId" placeholder="Buscar..." >
                
                <label><input type="radio" name="regs" value="10" checked>10 registros</label>
                <label><input type="radio" name="regs" value="20">20 registros</label>
                <label><input type="radio" name="regs" value="30">30 registros</label>
                <label><input type="radio" name="regs" value="40">40 registros</label>
                <label><input type="radio" name="regs" value="50">50 registros</label>
                <label><input type="radio" name="regs" value="60">60 registros</label>
                </form><br>
                <table>
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Cantidad mínima</th>
                            <th>Armario</th>
                            <th>Balda</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
                


                <br>
                <button onclick="window.location.href='{{ Cookie::get('TYPE') === 'admin' ? route('materials.dashboard') : route('welcome_teacher') }}'" class="btn btn-warning">Volver</button>

                <br><br>
                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
        <script src="{{ asset('js/storagesUpdate.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/tables.js') }}" type="text/javascript"></script>

    </body>
</html>
