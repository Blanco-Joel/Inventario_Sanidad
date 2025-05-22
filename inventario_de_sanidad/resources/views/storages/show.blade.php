<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            table, th, td {
                border: 1px solid;
            }
        </style>
    </head>
    <body>
        <h1>Materiales en Armario {{ $cabinet }}, Balda {{ $shelf }}</h1>

  @if($storages->isEmpty())
    <p>No hay materiales registrados en esta ubicación.</p>
  @else
    <table>
      <thead>
        <tr>
          <th>Material ID</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Cantidad mínima</th>
        </tr>
      </thead>
      <tbody>
        @foreach($storages as $st)
          <tr>
            <td>{{ $st->material_id }}</td>
            <td>{{ $st->material->name /* relación */ }}</td>
            <td>{{ $st->units }}</td>
            <td>{{ $st->min_units }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
    </body>
</html>