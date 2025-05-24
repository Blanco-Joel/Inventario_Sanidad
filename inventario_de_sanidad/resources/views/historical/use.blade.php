@extends('layout.app')

@section('title', 'Materiales en uso')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/historical.css') }}">
@endpush

@section('content')
<div class="historical-container">
    <h1 class="historical-title">Materiales en uso</h1>

    @if($materials->isEmpty())
        <div class="historical-alert">No hay materiales en uso actualmente.</div>
    @else
        <div class="search-form">
            <div class="search-container">
                <input 
                    type="text" 
                    name="busqueda" 
                    placeholder="Buscar por nombre..." 
                    class="search-input"
                >
                
            </div>

            <div class="view-toggle">
                <button id="cardViewBtn" class="btn btn-outline btn-notifications active"><i class="fa-solid fa-list-ul"></i> </button>
                <button id="tableViewBtn" class="btn btn-outline btn-notifications"><i class="fa-solid fa-table"></i> </button>
            </div>
        </div>

        <div id="cardView" class="card-grid">
            @foreach($materials as $material)
                <div class="material-card">
                    <img src="{{ asset($material->image_path ?? 'storage/no_image.jpg') }}" alt="{{ $material->name }}">
                    <div class="material-card-body">
                        <h5>{{ $material->name }}</h5>
                        <p>{{ $material->description }}</p>
                        <ul>
                            <li><strong>Armario:</strong> {{ $material->cabinet }}</li>
                            <li><strong>Balda:</strong> {{ $material->shelf }}</li>
                            <li><strong>Unidades:</strong> {{ $material->units }}</li>
                            <li><strong>Mínimo:</strong> {{ $material->min_units }}</li>
                        </ul>
                    </div>
                </div>
            @endforeach
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
                    @foreach($materials as $material)
                        <tr>
                            <td><img src="{{ asset($material->image_path ?? 'storage/no_image.jpg') }}" alt="{{ $material->name }}" class="cell-img"></td>
                            <td>{{ $material->name }}</td>
                            <td class="cell-description">{{ $material->description }}</td>
                            <td>{{ $material->cabinet }}</td>
                            <td>{{ $material->shelf }}</td>
                            <td>{{ $material->units }}</td>
                            <td>{{ $material->min_units }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
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
@endpush
