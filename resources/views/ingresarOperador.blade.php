@extends('layouts.plantillaDashboard')

@section('title', 'Ingresar Operador')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingEdi.css')}}">
@endsection

@section('content')
<main>

    <div class="encabezado">
        <h1 class="navbar-brand fs-2 p-2">Ingresar Operador</h1>
    </div>
    @if(session('success'))
            <div class="alert alert-success mt-3" style="width: 90%; margin: 0 auto">
                {{ session('success') }}
            </div>
    @endif
    <!-- Mostrar errores si existen -->
    @if ($errors->any())
    <div class="alert alert-danger  mt-3" style="width: 90%; margin: 0 auto">
        <ul>
            @foreach ($errors->all() as $error)
            <li style="list-style: none;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{route ('ingresoOpe')}}" method="POST" class="form-control mx-auto p-5 mt-5 mb-5 shadow">
        @csrf
        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="numero_docu">Código<span class="text-danger">*</span></label> 
            <input style="width:300px;" type="number" id="code" name="code" class="form-control" value="" required>
        </div>

        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="numero_docu">Nombre<span class="text-danger">*</span></label> 
            <input style="width:300px;" type="text" id="name" name="name" class="form-control" value="" required>
        </div>

        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="tipo_identificacion">Código de bus<span class="text-danger">*</span></label> 
            <div>
                <select style="width:300px;" name="bus_code" class="form-control " title="Seleccione el código de bus" required>
                    <option value="Sin código">Sin bus asignado</option>
                    @foreach ($availableBuses as $bus)
                        <option value="{{ $bus->code }}">{{ $bus->code }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group justify-content-between d-flex w-75 mx-auto">
            <label class="fs-5" for="tipo_identificacion">Estado<span class="text-danger">*</span></label> 
            <div>
                <select style="width:300px;" name="id_status" class="form-control " title="Seleccione el estado" required>
                    @foreach ($status as $state )
                        <option value="{{$state->id }}">{{$state->status_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="boton mx-auto text-center d-flex mt-5 mb-3 ">
            <button type="submit" class="btn w-25 mx-auto">Enviar</button>
            <a href="{{route ('index')}}" class="bot w-25 mx-auto">Volver</a>
        </div>
    </form>
</main>
@endsection