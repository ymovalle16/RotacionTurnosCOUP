<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @yield('estilos')
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
<body>
    <header class="navbar fixed-top p-0 ">
        <a href="{{route ('index')}}" class="navbar-brand  m-0 text-light col-lg-2">Cooperativa Urbanos Pereira</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed border-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <p class="navbar-brand flex-fill p-2 m-0 text-light ps-3">Bienvenido Administrador</p>
        {{-- <a href="" class="navbar-brand ps-2 pe-2 m-0 text-light">Cerrar sesión</a> --}}
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf <!-- Necesario para la protección CSRF -->
            <button type="submit" class="btn ps-2 pe-2 m-0 text-light">Cerrar sesión</button>
        </form>
    </header>
    <div class="container-fluid">
        <div class="row flex">
            <nav id="sidebarMenu"class="col-md-6 col-lg-2 pt-5">
                <div class="position-sticky">
                    <div class="logo"><img src="{{asset('img/logo.png')}}" alt=""></div>
                    <div class="menu text-center w-100 mt-5">
                        <ul class="list-unstyled">
                            <li class="mb-3"><a class="navbar-brand" href="{{route ('index')}}">Principal</a></li>
                            <li class="mb-3"><a class="navbar-brand" href="{{route ('rotaciones')}}">Rotaciones</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
{{-- Scripts de bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

