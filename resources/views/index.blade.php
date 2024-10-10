@extends('layouts.plantillaDashboard')

@section('title', 'Dashboard')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/dash.css')}}">
@endsection

@section('content')
<main class="">
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
    <div class="encabezado">
        <h1 class="navbar-brand fs-2 p-2">Operadores</h1>
        <a href="{{route ('ingresarOperador')}}" class="btn">Ingresar</a>
    </div>
    
    <div class="table-responsive m-4 bg-light shadow p-2">
        <table class="table operators">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Bus asignado</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider operators">
                @foreach ($operators as $operator)
                    <tr>
                        <td>{{ $operator->code }}</td>
                        <td>{{ $operator->name }}</td>
                        <td>{{ $operator->bus_code }}</td>
                        <td>{{ $operator->status->status_name }}</td>
                        <td>
                            {{-- href="{{route ('editarOpe', $operator->id)}}"  PONERLO DESPUÉS DE TENER LA OPCIÓN DE CREAR BUSES--}}
                            <a class="btn btn-sm btn-success"><img src="{{asset ('img/edit.png')}}" alt="" class="w-25"></a>
                            <a class="btn btn-sm btn-danger"><img src="{{asset ('img/delete.png')}}" alt="" class="w-25"></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr class="linea">
        <nav class="pagination operators justify-content-center">
            <a class="page-link prev text-dark" href="#" aria-label="Previous">
                <span aria-hidden="true"><</span>
            </a>
            <span class="current-page"></span>
            <a class="page-link next text-dark" href="#" aria-label="Next">
                <span aria-hidden="true">></span>
            </a>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h1 class="navbar-brand fs-2 p-2">Buses disponibles</h1>
            <div class="table-responsive m-4 bg-light shadow p-2">
                <table class="table buses">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider buses">
                        <tr>
                            <td>111</td>
                            <td>Varada</td>
                            <td>
                                <a class="btn btn-sm btn-success"><img src="{{asset ('img/edit.png')}}" alt="" class="w-25"></a>
                                <a class="btn btn-sm btn-danger"><img src="{{asset ('img/delete.png')}}" alt="" class="w-25"></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr class="linea">
                <nav class="pagination buses justify-content-center">
                    <a class="page-link prev text-dark" href="#" aria-label="Previous">
                        <span aria-hidden="true"><</span>
                    </a>
                    <span class="current-page"></span>
                    <a class="page-link next text-dark" href="#" aria-label="Next">
                        <span aria-hidden="true">></span>
                    </a>
                </nav>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>

</main>

<script>
   function handlePagination(tableSelector, paginationSelector) {
    const table = document.querySelector(tableSelector);
    const paginationContainer = document.querySelector(paginationSelector);
    const prevLink = paginationContainer.querySelector('.prev');
    const nextLink = paginationContainer.querySelector('.next');
    const currentPageSpan = paginationContainer.querySelector('.current-page');

    const recordsPerPage = 10;
    const totalRecords = table.querySelectorAll('tbody tr').length;
    const totalPages = Math.ceil(totalRecords / recordsPerPage);

    let currentPage = 1;
    showPage(currentPage);

    prevLink.addEventListener('click', (event) => {
        event.preventDefault();
        if (currentPage > 1) {
            showPage(--currentPage);
        }
    });

    nextLink.addEventListener('click', (event) => {
        event.preventDefault();
        if (currentPage < totalPages) {
            showPage(++currentPage);
        }
    });

    function showPage(pageNumber) {
        const startIndex = (pageNumber - 1) * recordsPerPage;
        const endIndex = startIndex + recordsPerPage;

        table.querySelectorAll('tbody tr').forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });

        currentPageSpan.textContent = `Página ${pageNumber} de ${totalPages}`;
    }
}

// Llama a la función para ambas tablas
document.addEventListener('DOMContentLoaded', () => {
    handlePagination('.table.operators', '.pagination.operators');
    handlePagination('.table.buses', '.pagination.buses');
});



</script>

@endsection