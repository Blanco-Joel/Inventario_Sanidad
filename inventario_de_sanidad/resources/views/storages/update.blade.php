@extends('layout.app')

@section('title', 'Actualizacion de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/storages/update.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
@endpush

@section('content')
<div id="loader-overlay">
    <div class="spinner"></div>
</div>
<div class="">
    <div class="content-wrapper">
        <h1>Gestionar Almacenamiento</h1>
        
        <!-- Buscador -->
        <form class="search-form">
            <div class="search-container">
                <input type="text" id="buscarId" placeholder="Buscar..." autocomplete="off">
                <div class="dropdown-container">
                    <button type="button" id="filterToggle"><i class="fa-solid fa-filter"></i></button>
                    <div id="filterOptions" class="filter-options">
                        <label><input type="radio" name="filtro" value="2" checked>Nombre</label>
                        <label><input type="radio" name="filtro" value="3">Localización</label>
                        <label><input type="radio" name="filtro" value="4">Tipo</label>
                    </div>
                </div>
            </div>
        </form>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Localización</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Cantidad mínima</th>
                    <th>Armario</th>
                    <th>Balda</th>
                    <th>Cajón</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
        <!-- Paginación -->
        <div id="paginacion" class="pagination-controls">
            <div class="pagination-select">
                <label for="regsPorPagina"></label>
                <select id="regsPorPagina">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="pagination-buttons">
                <!-- Botones de paginación se insertarán aquí -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/storagesUpdate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
    <script src="{{ asset('js/tableFunctions.js') }}"></script>
    <script src="{{ asset('js/tableStorage.js') }}" type="text/javascript"></script>
    <?php //<script src="{{ asset('js/filterToggle.js') }}"></script> ?>
    <script>
document.addEventListener("DOMContentLoaded", () => {
  const inputBuscar = document.getElementById("buscarId");
  const filtroRadios = document.querySelectorAll("input[name='filtro']");
  const toggleBtn = document.getElementById("filterToggle");
  const filterOptions = document.getElementById("filterOptions");

  let criterio = "2"; // Por defecto: Nombre

  function normalizar(txt) {
    return txt.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  }

  const tbody = document.querySelector(".table tbody");
  const filas = Array.from(tbody.rows);

  toggleBtn.addEventListener("click", () => {
    filterOptions.style.display = filterOptions.style.display === "none" ? "block" : "none";
  });

  filtroRadios.forEach(radio => {
    radio.addEventListener("change", (e) => {
      criterio = e.target.value;
      filtrarTabla();
    });
  });

  inputBuscar.addEventListener("input", filtrarTabla);

  function filtrarTabla() {
    const valor = normalizar(inputBuscar.value.trim());
    let nombreActual = "";
    let mostrarNombre = true;

    for (let i = 0; i < filas.length; i++) {
      const fila = filas[i];

      // Si es fila de título (material-title)
      if (fila.cells.length === 1 && fila.cells[0].classList.contains("material-title")) {
        nombreActual = normalizar(fila.textContent.trim());
        // Ver si este nombre coincide con el filtro
        mostrarNombre = criterio === "2" && (!valor || nombreActual.includes(valor));
        fila.style.display = mostrarNombre ? "" : "none";
        continue;
      }

      // Fila de datos (uso o reserva)
      const celdas = fila.cells;

      // Localización = 0, Tipo = 1 (a pesar de rowspan), cuidado con columnas variables
      const localizacion = normalizar(celdas[0]?.textContent || "");
      const tipo = normalizar(celdas[1]?.textContent || "");

      let coincide = false;

      if (!valor) {
        coincide = true;
      } else {
        switch (criterio) {
          case "2": // Nombre
            coincide = nombreActual.includes(valor);
            break;
          case "3": // Localización
            coincide = localizacion.includes(valor);
            break;
          case "4": // Tipo
            coincide = tipo.includes(valor);
            break;
        }
      }

      fila.style.display = coincide ? "" : "none";

      // Mostrar también el nombre si alguna fila hija coincide
      if (criterio !== "2" && coincide && filas[i - 1]?.classList.contains("material-title")) {
        filas[i - 1].style.display = "";
      }
    }
  }
});

</script>
@endpush

