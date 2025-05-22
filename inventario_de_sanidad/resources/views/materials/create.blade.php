@extends('layout.app')

@section('title', 'Alta de materiales')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style_createMaterial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
<div class="material-form-wrapper">
    <h1 class="form-title">Alta de Materiales</h1>

    <div class="basket-toggle">
        <button id="toggleBasketBtn" class="btn btn-outline btn-notifications" type="button">
            <i class="fa-solid fa-cart-shopping"></i>
        </button>
    </div>

    {{-- Formulario para agregar a la cesta --}}
    <form action="{{ route('materials.basket.create') }}" method="POST" enctype="multipart/form-data" class="material-form">
        @csrf

        <div class="form-group">
            <input type="text" name="name" placeholder="Nombre del material" value="{{ old('name') }}">
            @error('name')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <textarea name="description" rows="3" placeholder="Descripción del material">{{ old('description') }}</textarea>
            @error('description')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="storage">Localización</label>
            <select name="storage" id="storage">
                <option value="">-- Seleccionar --</option>
                <option value="CAE" {{ old('storage')=='CAE'?'selected':'' }}>CAE</option>
                <option value="odontologia" {{ old('storage')=='odontologia'?'selected':'' }}>Odontología</option>
            </select>
            @error('storage')
                <div class="alert-error-uspas">{{ $message }}</div>
            @enderror
        </div>

        <fieldset class="fieldset">
            <legend>Uso</legend>
            <div class="form-grid-5">
                <input type="number" name="units_use" placeholder="Cantidad" min="1" value="{{ old('units_use') }}">
                <input type="number" name="min_units_use" placeholder="Cantidad mínima" min="1" value="{{ old('min_units_use') }}">
                <input type="number" name="cabinet_use" placeholder="Armario" value="{{ old('cabinet_use') }}">
                <input type="number" name="shelf_use" placeholder="Balda" min="1" value="{{ old('shelf_use') }}">
                <input type="number" name="drawer" placeholder="Cajón" value="{{ old('drawer') }}">
            </div>
            @foreach (['units_use', 'min_units_use', 'cabinet_use', 'shelf_use', 'drawer'] as $field)
                @error($field)
                    <div class="alert-error-uspas">{{ $message }}</div>
                @enderror
            @endforeach
        </fieldset>

        <fieldset class="fieldset">
            <legend>Reserva</legend>
            <div class="form-grid-4">
                <input type="number" name="units_reserve" placeholder="Cantidad" min="1" value="{{ old('units_reserve') }}">
                <input type="number" name="min_units_reserve" placeholder="Cantidad mínima" min="1" value="{{ old('min_units_reserve') }}">
                <input type="text" name="cabinet_reserve" placeholder="Armario" value="{{ old('cabinet_reserve') }}">
                <input type="number" name="shelf_reserve" placeholder="Balda" value="{{ old('shelf_reserve') }}">
            </div>
            @foreach (['units_reserve', 'min_units_reserve', 'cabinet_reserve', 'shelf_reserve'] as $field)
                @error($field)
                    <div class="alert-error-uspas">{{ $message }}</div>
                @enderror
            @endforeach
        </fieldset>

        <div class="form-group file-upload">
            <label for="image" class="btn btn-primary">Subir Imagen</label>
            <input type="file" name="image" id="image" class="btn btn-primary file-upload-input" onchange="previewImage(event, '#imgPreview')">
            
            <img id="imgPreview" src="" alt="">
            <span id="file-name" class="file-name-display">Ningún archivo seleccionado</span>
            
        </div>

        <div class="form-actions">
            <input type="submit" value="Añadir" class="btn btn-primary">
        </div>
    </form>

    {{-- Confirmar alta --}}
    <form action="{{ route('materials.store') }}" method="POST" class="material-form">
        @csrf
        <input type="submit" value="Alta" class="btn btn-success">
    </form>

    {{-- Flash messages --}}
    {{-- @if (session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif --}}
    @if (session('error'))
        <p class="alert-error-uspas">{{ session('error') }}</p>
    @endif

    {{-- Cesta --}}
    @php
        $basket = json_decode(Cookie::get('materialsAddBasket','[]'), true);
    @endphp

    @if ($basket)
        <div class="basket-section hidden">
            <h4 class="basket-title">Cesta de Materiales</h4>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th rowspan="2">Nombre</th>
                            <th class="wide" rowspan="2">Descripción</th>
                            <th colspan="5">Uso</th>
                            <th colspan="5">Reserva</th>
                        </tr>
                        <tr>
                            <th>Cant.</th><th>Mín</th><th>Armario</th><th>Balda</th><th>Cajón</th>
                            <th>Cant.</th><th>Mín</th><th>Armario</th><th>Balda</th><th>Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($basket as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td class="cell-description custom-scroll">{{ $item['description'] }}</td>
                                <td>{{ $item['use']['units'] }}</td>
                                <td>{{ $item['use']['min_units'] }}</td>
                                <td>{{ $item['use']['cabinet'] }}</td>
                                <td>{{ $item['use']['shelf'] }}</td>
                                <td>{{ $item['use']['drawer'] }}</td>
                                <td>{{ $item['reserve']['units'] }}</td>
                                <td>{{ $item['reserve']['min_units'] }}</td>
                                <td>{{ $item['reserve']['cabinet'] }}</td>
                                <td>{{ $item['reserve']['shelf'] }}</td>
                                <td><img class="cell-img" src="{{ asset('storage/' . ($item['image_temp'] ?? 'no_image.jpg')) }}" class="basket-img" alt=""></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection


@push('scripts')
    <script>
        document.getElementById("image").addEventListener("change", function () {
            const fileName = this.files[0]?.name || "Ningún archivo seleccionado";
            document.getElementById("file-name").textContent = fileName;
        });
    </script>

    <script src="{{ asset('js/previewImage.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("toggleBasketBtn");
            const formSections = document.querySelectorAll(".material-form, .form-title, .form-group, fieldset, .form-actions");
            const basketSection = document.querySelector(".basket-section");
            let showingBasketOnly = false;

            toggleBtn.addEventListener("click", function () {
                showingBasketOnly = !showingBasketOnly;

                formSections.forEach(el => el.classList.toggle("hidden", showingBasketOnly));

                if (basketSection) {
                    basketSection.classList.toggle("hidden", !showingBasketOnly);
                }

                toggleBtn.classList.remove(showingBasketOnly ? "btn-outline" : "btn-primary");
                toggleBtn.classList.add(showingBasketOnly ? "btn-primary" : "btn-outline");
            });
        });
    </script>
@endpush