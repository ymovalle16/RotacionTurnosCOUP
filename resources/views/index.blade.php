@extends('layouts.plantillaDashboard')

@section('title', 'Dashboard')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/dash.css')}}">
@endsection



<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

<script>
function sortRowsByCode(tableSelector) {
    const table = document.querySelector(tableSelector);
    const rows = Array.from(table.querySelectorAll('tbody tr'));

    // Ordenar las filas por el primer valor (Código)
    const sortedRows = _.sortBy(rows, row => {
        return row.cells[0].textContent.trim();
    });

    // Reinsertar las filas ordenadas en la tabla
    const tbody = table.querySelector('tbody');
    sortedRows.forEach(row => tbody.appendChild(row));
}

// Ordenar las tablas al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    sortRowsByCode('.table.operators'); // Ordenar por código de operador
    sortRowsByCode('.table.buses'); // Ordenar por código de bus
});

</script>

@section('content')
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
    @if(session('success'))
    <div class="alert alert-success" style="width: 100%; margin: 0 auto; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
    @endif
    <div class="encabezado">
        <h1 class="navbar-brand fs-2 p-2">Operadores</h1>
        <a href="{{route ('ingresarOperador')}}" class="btn">Crear</a>
    </div>
    
    <div class="table-responsive m-3 bg-light shadow p-2">
        <div class="search-container d-right d-flex justify-content-end">
            <input type="text" id="searchInput" placeholder="Busca por Código, Nombre, Código de bus o estado" class="form-control rounded-0 w-75"/>
        </div>
        <table class="table operators" id="tablaOperadores">
            <thead>
                <tr>
                    <th scope="col" >Código</th>
                    <th scope="col" >Nombre</th>
                    <th scope="col" >Bus asignado</th>
                    <th scope="col" >Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider operators">
                @foreach ($operators as $operator)
                    <tr>
                        <td>{{ $operator->code }}</td>
                        <td>{{ $operator->name }}</td>
                        @if($operator->bus_code)
                            <td>{{ $operator->bus_code }}</td>
                        @else
                            <td>Sin bus Asignado</td>
                        @endif
                        <td>{{ $operator->status->status_name }}</td>
                        <td>
                            {{-- href="{{route ('editarOpe', $operator->id)}}"  PONERLO DESPUÉS DE TENER LA OPCIÓN DE CREAR BUSES--}}
                            {{-- <a class="btn btn-sm btn-success"><img src="{{asset ('img/edit.png')}}" alt="" class="w-25"></a> --}}
                            <!-- Button trigger modal -->
                        <a href="{{route ('editarOpe', $operator->id)}}" class="btn btn-sm btn-success">
                            <img src="{{asset ('img/edit.png')}}" alt="" class="w-25">
                        </a>
                        
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

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="encabezado2">
                <h1 class="navbar-brand fs-2 p-2">Buses </h1>
                <a href="{{route ('ingresarBus')}}" class="btn btn-sm">Crear</a>
            </div>
            <div class="table-responsive m-3 bg-light shadow p-2">
                <div class="search-container  d-right d-flex justify-content-end">
                    <input type="text" id="searchInput2" placeholder="Busca por Código o Estado" class="form-control rounded-0 w-75"/>
                </div>
                <table class="table buses">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider buses">
                        @foreach ($buses as $bus)
                            <tr>
                                <td>{{ $bus->code }}</td>
                                <td>{{ $bus->statusBus->status_name }}</td>
                                <td>
                                    <a href="{{route ('editarBus', $bus->id)}}" class="btn btn-sm btn-success"><img src="{{asset ('img/edit.png')}}" alt="" class="w-25"></a>
                                </td>
                            </tr>
                        @endforeach
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
        <div class="col-md-6">
            <div class="encabezado2">
                <h1 class="navbar-brand fs-2 p-2">Descansos</h1>
            </div>
            <div class="table-responsive m-4 bg-light shadow p-2">
                <table class="table descansos">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider buses">
                        @foreach ($operatorss as $operato)
                            <tr>
                                <td>{{ $operato->code }}</td>
                                <td>{{ $operato->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>

<script>
function handlePaginationAndFilter(tableSelector, paginationSelector, searchInputSelector) {
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

    function filterTable() {
        const searchInput = document.querySelector(searchInputSelector).value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.cells;
            let match = false;

            for (let i = 0; i < cells.length; i++) {
                if (cells[i].textContent.toLowerCase().includes(searchInput)) {
                    match = true;
                    break;
                }
            }

            row.style.display = match ? '' : 'none'; // Mostrar u ocultar la fila
        });

        if (searchInput === "") {
            resetPagination(); // Reestablecer la paginación si el input está vacío
        }
    }

    function resetPagination() {
        currentPage = 1;
        showPage(currentPage);
    }

    document.querySelector(searchInputSelector).addEventListener('input', filterTable);
}

// Llama a la función para ambas tablas
document.addEventListener('DOMContentLoaded', () => {
    handlePaginationAndFilter('.table.operators', '.pagination.operators', '#searchInput');
    handlePaginationAndFilter('.table.buses', '.pagination.buses', '#searchInput2');
});

</script> 

@endsection

