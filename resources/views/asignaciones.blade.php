@extends('layouts.plantillaDashboard')
@section('title', 'Asignaciones')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/asig.css')}}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="encabezado">
    <h1 class="navbar-brand fs-2 p-2">Asignaciones</h1>
</div>

<!-- Filtro de búsqueda -->
<div class="d-flex justify-content-end mb-3 w-75 mx-auto">
    <input type="text" id="groupSearch" class="form-control" placeholder="Buscar por cuenca o código de operador">
</div>

<div class="table-responsive bg-light shadow p-2 mx-auto mb-5 w-75">
    <table id="rotacion-table" class="table table-bordered bg-light mx-auto">
        <thead>
            <tr>
                <th colspan="4" class="text-center p-0">Asignaciones</th>
            </tr>
            <tr class="text-center">
                <th colspan="2" class="samaria p-0 w-50">Tabla</th>
                <th colspan="2" class="tokio p-0 w-50">Código de operador</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($groups as $group) --}}
                <tr data-group-id="">
                    <td colspan="2">hola</td> <!-- Nombre de la cuenca -->
                    <td colspan="2"></td>
                </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
    <!-- Paginación -->
    <nav class="pagination justify-content-center">
        <a class="page-link prev text-dark" href="#" aria-label="Previous">
            <span aria-hidden="true"><</span>
        </a>
        <span class="current-page"></span>
        <a class="page-link next text-dark" href="#" aria-label="Next">
            <span aria-hidden="true">></span>
        </a>
    </nav>
</div>

@endsection