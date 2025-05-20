<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Login </title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
</head>
<body>
    <div class="bg-login">
        <div class="login-wrapper">
            <div class="login-box">
                <h3>Portal de sanidad</h3>
                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <input type="text" name="user" placeholder="Número de usuario">
                        @error('user')
                            <div class="error-messages">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Contraseña">
                        @error('password')
                            <div class="error-messages">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('login')
                        <div class="error-messages">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
<footer></footer>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path
        fill="#fff"
        fill-opacity="1"
        d="M0,0L40,42.7C80,85,160,171,240,197.3C320,224,400,192,480,154.7C560,117,640,75,720,74.7C800,75,880,117,960,154.7C1040,192,1120,224,1200,213.3C1280,203,1360,149,1400,122.7L1440,96L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"
    ></path>
</svg>

</html>