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
    
    <div class="table-responsive m-4 bg-light shadow">
        <table class="table">
            <thead>
                <tr>
                  <th scope="col">Código</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Bus asignado</th>
                  <th scope="col">Estado</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                @foreach ($operators as $operator)
                    <tr>
                    <td>{{ $operator->code }}</td>
                    <td>{{ $operator->name }}</td>
                    <td>{{ $operator->bus_code }}</td>
                    <td>{{ $operator->status->status_name }}<td>
                    </tr>
                @endforeach 
              </tbody>
        </table>
        <hr class="linea">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link prev text-dark" href="#" aria-label="Previous">
                        <span aria-hidden="true"><</span>
                    </a>
                </li>
                <span class="current-page"></span>
                <li class="page-item">
                    <a class="page-link next text-dark" href="#" aria-label="Next">
                        <span aria-hidden="true">></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</main>

<script>
// get the table and pagination container
const table = document.querySelector('.table');
const paginationContainer = document.querySelector('.pagination');
const prevLink = paginationContainer.querySelector('.prev');
const nextLink = paginationContainer.querySelector('.next');
const currentPageSpan = paginationContainer.querySelector('.current-page');

// set the number of records per page
const recordsPerPage = 10;

// get the total number of records
const totalRecords = table.rows.length - 1; // subtract 1 for the header row

// calculate the number of pages
const totalPages = Math.ceil(totalRecords / recordsPerPage);

// show the first page by default
let currentPage = 1;
showPage(currentPage);

// add event listeners to navigation arrows
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

// function to show a specific page
function showPage(pageNumber) {
    const startIndex = (pageNumber - 1) * recordsPerPage;
    const endIndex = startIndex + recordsPerPage;

    // hide all rows
    Array.from(table.rows).forEach((row, index) => {
        if (index === 0) return; // skip header row
        row.style.display = (index - 1 >= startIndex && index - 1 < endIndex) ? '' : 'none';
    });

    // update the current page number
    currentPageSpan.textContent = `Página ${pageNumber} de ${totalPages}`;
}


</script>


@endsection