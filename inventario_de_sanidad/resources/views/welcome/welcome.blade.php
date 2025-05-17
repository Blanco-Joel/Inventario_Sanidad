@extends('layout.app')

@section('content')
    <!-- Dialog para cambiar contraseña -->
    <dialog id="firstLogDialog" >
        <div  class="text-center" >
            <h3>Cambiar Contraseña</h3>
            <p>En el primer ingreso a la página se ha<br> de cambiar la contraseña.</p>
            <form id="FirstLogForm"  action="{{ route('changePasswordFirstLog') }}" method="POST">
                @csrf

                <label for="newPassword">Nueva Contraseña</label><br>
                <input type="password" id="newPassword" name="newPassword" ><br><br>
            
                <label for="confirmPassword">Confirmar Nueva Contraseña</label><br>
                <input type="password" id="confirmPassword" name="confirmPassword" ><br><br>
                
                <p id="error"></p>
                <button type="submit">Cambiar Contraseña</button>
            </form>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </dialog>

    @if (session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif

    <h1>Bienvenido</h1>
    <p>Has iniciado sesión correctamente.</p>

    <!-- Notificaciones de alerta -->
    @if(!empty($data))
        <h4>WARNING</h4>
        @foreach ($data as $warning)
            <p>{{$warning->name}} tiene solo {{$warning->units}} unidad/es en {{$warning->storage_type ==  "use" ? "uso" : "reserva";}}.</p>
        @endforeach
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/firstWelcome.js') }}"></script>
@endpush
