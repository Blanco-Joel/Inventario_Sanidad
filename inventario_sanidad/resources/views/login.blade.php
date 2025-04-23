<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Portal de sanidad</title>
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Portal de sanidad</h2>
        
        <!-- Muestra errores de validación -->
        @if ($errors->has('login'))
            <div class="alert-error-login">{{ $errors->first('login') }}</div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf <!-- Token de seguridad para formularios en Laravel -->
            
            <div class="input-group">
                <label for="user">Número de usuario</label>
                <input type="text" name="user" id="user" placeholder="Número">
                @error('user')
                    <div class="alert-error-uspas">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Contraseña">
                @error('password')
                    <div class="alert-error-uspas">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-button">Login</button>

        </form>
    </div>
</body>
</html>