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
    @if ($errors->any())
        <div class="alert alert-danger mt-3" style="width: 90%; margin: 0 auto">
            <ul>
                @foreach ($errors->all() as $error)
                <li style="list-style: none;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('actualizarBus', $bus->id)}}" method="POST" class="form-control mx-auto mt-5 mb-5 shadow" id="formulario">
        @csrf
        @method('PUT')
        <div class="form-group row justify-content-between w-75 mx-auto">
            <label class="col-form-label col-sm-4 col-md-4 col-lg-3" for="status_id">Estado<span class="text-danger">*</span></label>
            <div class="col-sm-8 col-md-8 col-lg-9">
                <select name="status_id" class="form-control" required>
                    @foreach ($statusBus as $statu)
                        <option value="{{$statu->id}}" {{ $bus->status_id == $statu->id ? 'selected' : '' }}>{{$statu->status_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="boton text-center d-flex mt-5 mb-3 flex-sm-row gap-4">
            <button type="submit" class="btn mb-2 mb-sm-0">Enviar</button>
            <a href="{{route('index')}}" class="bot">Volver</a>
        </div>
    </form>
</main>
@endsection

