<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materiales en Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/style_welcome.css') }}">

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Historial de modificaciones</h1>

            <div class="row">
            <table id="tabla-modificaciones" border="1">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Nombre</th>
                        <th onclick="sortTable(1)">Apellidos</th>
                        <th onclick="sortTable(2)">Email</th>
                        <th onclick="sortTable(3)">Tipo de usuario</th>
                        <th onclick="sortTable(4)">Última modificación</th>
                        <th onclick="sortTable(5)">Fecha de alta</th>
                        <th onclick="sortTable(6)">Material</th>
                        <th onclick="sortTable(7)">Unidades modificadas</th>
                        <th onclick="sortTable(8)">Fecha de acción</th>
                        <th onclick="sortTable(9)">Tipo de almacenamiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modifications as $modification)
                        <tr>
                            <td>{{ $modification->first_name }}</td>
                            <td>{{ $modification->last_name }}</td>
                            <td>{{ $modification->email }}</td>
                            <td>{{ $modification->user_type }}</td>
                            <td>{{ $modification->action_datetime }}</td>
                            <td>{{ $modification->created_at }}</td>
                            <td>{{ $modification->material_name }}</td>
                            <td>{{ $modification->units }}</td>
                            <td>{{ $modification->action_datetime }}</td>
                            <td>{{ $modification->storage_type == "reserve"? "reserva" : "uso" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        <a href="{{ route('materiales.submenuHistorial') }}" class="btn ">Volver</a>

    </div>
</body>
</html>
