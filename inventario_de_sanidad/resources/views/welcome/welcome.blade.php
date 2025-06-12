@extends('layout.app')

@section('title', 'Bienvenido')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome/welcome.css') }}">
@endpush

@section('content')
    <!-- Dialog para cambiar contraseña -->
    <dialog id="firstLogDialog" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Cambiar Contraseña</h2>
            <p>En el primer ingreso a la página se ha de cambiar la contraseña.</p>
            <form id="FirstLogForm" action="{{ route('changePasswordFirstLog') }}" method="POST">
                @csrf
                <input type="password" id="newPassword" name="newPassword" placeholder="Nueva contraseña">
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirma la nueva contraseña">

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="alert-error-uspas">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button class="btn btn-primary" type="submit">Cambiar Contraseña</button>
            </form>
        </div>
    </dialog>

    @if (session('mensaje'))
        <div class="con">
            <h1>Bienvenido <span>{{ Cookie::get('NAME') }}</span></h1>
            <p>Has iniciado sesión correctamente.</p>
        </div>

        <div id="successToast" class="toast-success hidden">
            <p>{{ session('mensaje') }}</p>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/firstWelcome.js') }}"></script>
@endpush
