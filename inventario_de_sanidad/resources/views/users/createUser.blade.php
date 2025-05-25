@extends('layout.app')

@section('title', 'Alta de usuarios')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/userManagement.css') }}">
@endpush

@section('content')

<div class="alta-usuarios-container">
    <form action="{{ route('altaUsers.process') }}" method="POST">
        @csrf

        @if (session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif

        <h1>Alta de usuarios</h1>
        <h4>Introduce los datos de los usuarios que deseas registrar.</h4>

        <input type="text" id="nombre" name="nombre" placeholder="Nombre">
        @error('nombre') <div class="alert-error-uspas">{{ $message }}</div> @enderror

        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos">
        @error('apellidos') <div class="alert-error-uspas">{{ $message }}</div> @enderror

        <input type="text" id="email" name="email" placeholder="Email">
        @error('email') <div class="alert-error-uspas">{{ $message }}</div> @enderror

        <select id="user_type" name="user_type">
            <option value="teacher">Docente</option>
            <option value="student">Alumno</option>
            <option value="admin">Administrador</option>
        </select>

        <input class="btn btn-primary" type="submit" value="Registrar">
    </form>
</div>
@endsection

@push('scripts')

@endpush
