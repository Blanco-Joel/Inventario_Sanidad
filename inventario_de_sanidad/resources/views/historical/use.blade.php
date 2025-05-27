@extends('layout.app')

@section('title', 'Materiales en uso')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/historical.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    
@endpush

@section('content')

<div id="loader-overlay">
    <div class="spinner"></div>
</div> 
<div class="historical-container">
    <h1 class="historical-title">Materiales en uso</h1>
    <form class="search-form">
        <!-- Buscador -->
        <div class="search-container">
            <input type="text" id="buscarId" placeholder="Buscar..." autocomplete="off">
            <div class="dropdown-container">
                <button type="button" id="filterToggle"><i class="fa-solid fa-filter"></i></button>
                <div id="filterOptions" class="filter-options">
                    <label><input type="radio" name="filtro" value="1" checked>Nombre</label>
                    <label><input type="radio" name="filtro" value="2">Descripción</label>
                    <label><input type="radio" name="filtro" value="3">Armario</label>
                    <label><input type="radio" name="filtro" value="4">Balda</label>
                    <label><input type="radio" name="filtro" value="5">Unidades</label>
                    <label><input type="radio" name="filtro" value="6">Mínimo</label>
                    <label><input type="radio" name="filtro" value="7">Fecha de modificación</label>
                </div>
            </div>
        </div>
    </form>

            <div class="view-toggle">
                <button id="cardViewBtn" class="btn btn-outline btn-notifications active"><i class="fa-solid fa-list-ul"></i> </button>
                <button id="tableViewBtn" class="btn btn-outline btn-notifications"><i class="fa-solid fa-table"></i> </button>
            </div>
        </div>

        <div id="cardView" class="card-grid">
            <?php
            // @foreach($materials as $material)
            //     <div class="material-card">
            //         <img src="{{ asset($material->image_path ?? 'storage/no_image.jpg') }}" alt="{{ $material->name }}">
            //         <div class="material-card-body">
            //             <h5>{{ $material->name }}</h5>
            //             <p>{{ $material->description }}</p>
            //             <ul>
            //                 <li><strong>Armario:</strong> {{ $material->cabinet }}</li>
            //                 <li><strong>Balda:</strong> {{ $material->shelf }}</li>
            //                 <li><strong>Unidades:</strong> {{ $material->units }}</li>
            //                 <li><strong>Mínimo:</strong> {{ $material->min_units }}</li>
            //             </ul>
            //         </div>
            //     </div>
            // @endforeach
            ?>
        </div>

        <div id="tableView" class="table-wrapper" style="display: none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Armario</th>
                        <th>Balda</th>
                        <th>Unidades</th>
                        <th>Mínimo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // @foreach($materials as $material)
                    //     <tr>
                    //         <td><img src="{{ asset($material->image_path ?? 'storage/no_image.jpg') }}" alt="{{ $material->name }}" class="cell-img"></td>
                    //         <td>{{ $material->name }}</td>
                    //         <td class="cell-description">{{ $material->description }}</td>
                    //         <td>{{ $material->cabinet }}</td>
                    //         <td>{{ $material->shelf }}</td>
                    //         <td>{{ $material->units }}</td>
                    //         <td>{{ $material->min_units }}</td>
                    //     </tr>
                    // @endforeach
                    ?>
                </tbody>
            </table>
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
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('filterToggle');
            const optionsBox = document.getElementById('filterOptions');
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                optionsBox.style.display = optionsBox.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.dropdown-container')) {
                    optionsBox.style.display = 'none';
                }
            });
        });
    </script>
<script>
    
document.addEventListener('DOMContentLoaded', () => {
    const cardViewBtn = document.getElementById('cardViewBtn');
    const tableViewBtn = document.getElementById('tableViewBtn');
    const cardView = document.getElementById('cardView');
    const tableView = document.getElementById('tableView');
    const searchInput = document.querySelector('.search-input');

    function activateCardView() {
        cardView.style.display = 'grid';
        tableView.style.display = 'none';
        cardViewBtn.classList.add('active');
        tableViewBtn.classList.remove('active');
    }

    function activateTableView() {
        cardView.style.display = 'none';
        tableView.style.display = 'block';
        tableViewBtn.classList.add('active');
        cardViewBtn.classList.remove('active');
    }

    cardViewBtn.addEventListener('click', (e) => {
        e.preventDefault();
        activateCardView();
    });

    tableViewBtn.addEventListener('click', (e) => {
        e.preventDefault();
        activateTableView();
    });

    // Filtro en tiempo real
    searchInput.addEventListener('input', () => {
        const filter = searchInput.value.toLowerCase();

        // Filtrar tarjetas
        const cards = cardView.querySelectorAll('.material-card');
        cards.forEach(card => {
            const name = card.querySelector('h5').textContent.toLowerCase();
            card.style.display = name.includes(filter) ? '' : 'none';
        });

        // Filtrar filas tabla
        const rows = tableView.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    });

    activateCardView();

});
</script>
    <script src="{{ asset('js/historicalFunctions.js') }}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
    <script src="{{ asset('js/tableReserveUse.js') }}"></script>
@endpush
