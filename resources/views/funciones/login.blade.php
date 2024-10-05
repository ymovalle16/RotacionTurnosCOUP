<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Estilos manuales --}}
    <link rel="stylesheet" href="{{ asset('CSS/app.css') }}">
    {{-- Estilos de bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    {{-- Link fuente "Poppins sans-serif" --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    {{-- Link iconos de google --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Iniciar sesión</title>
    {{-- Favicon --}}
    <link rel="icon" type="ima/png" href="{{asset('img/logo.png')}}">
</head>
<body background="{{ asset('img/fondo_login.jpg') }}">
    <div class="contenedor">
        <!-- Mostrar errores si existen -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('validacion') }}" method="POST">
            @csrf <!-- Asegúrate de incluir esto -->
            <div class="mb-3">
                <div class="logo"><img src="{{asset('img/logo.png')}}" alt="Logo Cooperativa Urbanos Pereira"></div>
                <div class="icono">
                    <input type="text" name="identification" class="form-control" placeholder="Usuario" value="{{ old('identification') }}" required>
                    <img src="{{asset('img/user.png')}}" alt="">
                </div>
            </div>
            <div class="mb-3">
                <div class="icono">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <img src="{{asset('img/password.png')}}" alt="">
                </div>
            </div>
            <div class="boton mx-auto text-center m-4">
                <button type="submit" class="btn">Iniciar sesión</button>
            </div>
        </form>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>