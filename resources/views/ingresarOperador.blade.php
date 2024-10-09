@extends('layouts.plantillaDashboard')

@section('title', 'Ingresar Operador')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingOpe.css')}}">
@endsection

@section('content')
<main>
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
        <h1 class="navbar-brand fs-2 p-2">Ingresar Operador</h1>
    </div>
    <form action="{{route ('ingresoOpe')}}" method="POST" class="form-control mx-auto p-5 mt-5 mb-5">
        @csrf
        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="numero_docu">Código<span class="text-danger">*</span></label> 
            <input style="width:300px;" type="text" id="code" name="code" class="form-control" value="" required>
        </div>

        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="numero_docu">Nombre<span class="text-danger">*</span></label> 
            <input style="width:300px;" type="text" id="name" name="name" class="form-control" value="" required>
        </div>

        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="numero_docu">Código de bus<span class="text-danger">*</span></label> 
            <input style="width:300px;" type="text" id="bus_code" name="bus_code" class="form-control" value="" required>
        </div>

        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="tipo_identificacion">Estado<span class="text-danger">*</span></label> 
            <div>
                <select style="width:300px;" name="status" class="form-control " title="Seleccione el estado" required>
                    @foreach ($status as $state )
                        <option value="{{$state->id_status }}">{{$state->status_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="boton mx-auto text-center">
            <button type="submit" class="btn w-25 mt-2 mb-2">Enviar</button>
        </div>
    </form>
</main>
@endsection