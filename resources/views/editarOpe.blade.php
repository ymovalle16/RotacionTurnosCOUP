@extends('layouts.plantillaDashboard')

@section('title', 'Editar información de operador')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingEdi.css')}}">
@endsection

@section('content')

<main>

    <div class="encabezado">
        <h1 class="navbar-brand fs-2 p-2">Editar información de operador</h1>
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
    <form action="{{route ('actualizarOperador', $operator->id)}}" method="POST" class="form-control mx-auto p-5 mt-5 mb-5 shadow">
        @csrf
        @method('PUT')
        <div class="form-group justify-content-between d-flex mx-auto" style="width: 85%">
            <label class="fs-5" for="name">Nombre</label>
            <input style="width:300px;" type="text" id="name" name="name" class="form-control" value="{{ $operator->name }}" >
        </div>
        
        @if($operator->bus_code)
        <!-- Operador tiene bus asignado -->
        <div class="form-group justify-content-between d-flex mx-auto" style="width: 85%">
            <label class="fs-5" for="change_bus">¿Desea cambiar el bus?</label>
            <select style="width:300px;" id="change_bus" name="change_bus" class="form-control">
                <option value="no">No</option>
                <option value="yes">Sí</option>
            </select>
        </div>
    
        <div id="current_bus_status" class="form-group justify-content-between mx-auto" style="display: none; width: 85%">
            <label class="fs-5" for="current_bus_status_id">Estado del bus actual</label>
            <select style="width:300px;" id="current_bus_status_id" name="current_bus_status_id" class="form-control">
                @foreach ($statusBus as $statu)
                    <option value="{{ $statu->id }}">{{ $statu->status_name }}</option>
                @endforeach
            </select>
        </div>
    
        <div id="new_bus_code" class="form-group justify-content-between mx-auto" style="display: none; width: 85%">
            <label class="fs-5" for="new_bus_code">Nuevo bus</label>
            <select style="width:300px;" id="new_bus_code" name="new_bus_code" class="form-control">
                <option value="">Sin bus asignado</option>
                @foreach ($availableBuses as $bus)
                    <option value="{{ $bus->code }}">{{ $bus->code }}</option>
                @endforeach
            </select>
        </div>
        @else
        <!-- Operador no tiene bus asignado -->
        <div class="form-group justify-content-between mx-auto d-flex" style="width: 85%">
            <label class="fs-5" for="new_bus_code">Asignar un bus</label>
            <select style="width:300px;" id="new_bus_code" name="new_bus_code" class="form-control">
                <option value="">Sin bus</option>
                @foreach ($availableBuses as $bus)
                    <option value="{{ $bus->code }}">{{ $bus->code }}</option>
                @endforeach
            </select>
        </div>
        @endif
    
        <div class="form-group justify-content-between d-flex mx-auto" style="width: 85%">
            <label class="fs-5" for="id_status">Estado</label>
            <select style="width:300px;" name="id_status" class="form-control" >
                @foreach ($status as $state)
                    <option value="{{ $state->id }}">{{ $state->status_name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="boton mx-auto text-center d-flex mt-5 mb-3">
            <button type="submit" class="btn w-25 mx-auto">Enviar</button>
            <a href="{{route('index')}}" class="bot w-25 mx-auto">Volver</a>
        </div>
    </form>
    
    
</main>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const changeBusSelect = document.getElementById('change_bus');
    const currentBusStatusDiv = document.getElementById('current_bus_status');
    const newBusCodeDiv = document.getElementById('new_bus_code');

    if (changeBusSelect) {
        changeBusSelect.addEventListener('change', function () {
            if (this.value === 'yes') {
                currentBusStatusDiv.style.display = 'flex';
                newBusCodeDiv.style.display = 'flex';
            } else {
                currentBusStatusDiv.style.display = 'none';
                newBusCodeDiv.style.display = 'none';
            }
        });
    }
});

</script>

@endsection
