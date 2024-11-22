<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @yield('estilos')
    <link rel="stylesheet" href="{{asset ('CSS/plant.css')}}">
    {{-- Estilos de bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    {{-- Link fuente "Poppins sans-serif" --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    {{-- Link iconos de google --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    {{-- Favicon --}}
    <link rel="icon" type="ima/png" href="{{asset('img/logo.png')}}">
</head>
    
<body id="body-pd" style="background-color: rgb(236, 234, 234);">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <p class="text-light bienvenida">Bienvenido Administrador</p>
        <p class="text-light" id="p">Cooperativa Urbanos Pereira</p>
    </header>
    <div class="l-navbar shadow" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="{{ route ('index')}}" class="nav_logo" id="nav-logo"> <img src="{{asset ('img/logo.png')}}" alt="" style="width: 52px; height: 52px;"> </a>
                <div class="nav_list"> 
                    <a href="{{ route ('index')}}" class="nav_link"><i class='bx bx-group nav_icon'></i> <span class="nav_name">Principal</span> </a>
                    <a href="{{ route ('rotaciones')}}" class="nav_link"> <i class='bx bx-refresh nav_icon'></i> <span class="nav_name">Rotaciones</span> </a>
                    <a href="{{ route ('grupos')}}" class="nav_link"> <i class='bx bx-table nav_icon'></i> <span class="nav_name">Grupos</span> </a>
                    <a href="{{ route ('asignaciones')}}" class="nav_link"> <i class='bx bx-news nav_icon'></i> </i> <span class="nav_name">Asignaciones</span> </a>
                </div>
            </div> 
           
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf <!-- Necesario para la protección CSRF -->
                <button type="submit" class="nav_link border-0 bg-white" id="cerrarSe"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar Sesión</span> </button>
            </form>
        
        </nav>
    </div>
    <!--Container Main start-->
    <main class="height-100">
        @yield('content')
    </main>
    <!--Container Main end-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
   document.addEventListener("DOMContentLoaded", function(event) {

const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId),
        pElement = headerpd.querySelector('#p'); // Selecciona el p dentro del header
    const mainContent = document.querySelector('.height-100'); // Selecciona el contenedor principal

    // Validate that all variables exist
    if (toggle && nav && bodypd && headerpd && mainContent && pElement) {
        toggle.addEventListener('click', () => {
            // show navbar
            nav.classList.toggle('show')
            // change icon
            toggle.classList.toggle('bx-x')
            // add padding to body
            bodypd.classList.toggle('body-pd')
            // add padding to header
            headerpd.classList.toggle('body-pd')
            
            // Ocultar o mostrar el p
            if (nav.classList.contains('show')) {
                pElement.style.display = 'none'; // Ocultar p
                mainContent.style.paddingLeft = '0'; // Añadir padding izquierdo al contenido
            } else {
                pElement.style.display = ''; // Mostrar p
                mainContent.style.paddingLeft = ''; // Restablecer padding izquierdo del contenido
            }
        });
    }
}

showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

/*===== LINK ACTIVE =====*/
const linkColor = document.querySelectorAll('.nav_link')

function colorLink() {
    if (linkColor) {
        linkColor.forEach(l => l.classList.remove('active'))
        this.classList.add('active')
    }
}
linkColor.forEach(l => l.addEventListener('click', colorLink))

// Your code to run since DOM is loaded and ready
});

    </script>
    
</html>

