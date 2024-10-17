@extends('layouts.plantillaDashboard')

@section('title', 'Editar información de bus')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingEdi.css')}}">
@endsection

@section('content')
<main>
    <div class="encabezado">
        <h1 class="navbar-brand fs-2 p-2">Editar información de bus</h1>
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
    <form action="{{route('actualizarBus', $bus->id)}}" method="POST" class="form-control mx-auto p-5 mt-5 mb-5 shadow">
        @csrf
        @method('PUT')
        <div class="form-group justify-content-between mx-auto d-flex" style=" width: 85%">
            <label class="fs-5" for="status_id">Estado<span class="text-danger">*</span></label>
            <div>
                <select style="width:300px;" name="status_id" class="form-control " title="Seleccione el estado" required>
                    @foreach ($statusBus as $statu)
                        <option value="{{$statu->id}}" {{ $bus->status_id == $statu->id ? 'selected' : '' }}>{{$statu->status_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="boton mx-auto text-center d-flex mt-5 mb-3">
            <button type="submit" class="btn w-25 mx-auto">Enviar</button>
            <a href="{{route('index')}}" class="bot w-25 mx-auto">Volver</a>
        </div>
    </form>
</main>
@endsection

