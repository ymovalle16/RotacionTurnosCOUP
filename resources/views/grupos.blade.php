@extends('layouts.plantillaDashboard')
@section('title', 'Grupos')
{{-- @section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingEdi.css')}}">
@endsection --}}
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .table-bordered th, .table-bordered td {
    border: 1px solid #909090 !important;
  }
  .table-bordered {
    border-collapse: collapse;
  }

  .table{
    width: 85%
  }
</style>

  <div class="d-flex justify-content-between mb-3 w-75 mx-auto">
    <button id="addSamaria" class="btn btn-primary" onclick="setBasinId(1)">Agregar a Samaria</button>
    <button id="addTokio" class="btn btn-primary" onclick="setBasinId(2)">Agregar a Tokio</button>
  </div> 
  
  <div class="table-responsive">
      <table id="rotacion-table"class="table table-bordered bg-light mx-auto">
        <thead>
          <tr>
            <th colspan="4" class="text-center p-0">Grupos</th>
          </tr>
          <tr class="text-center">
            <th colspan="2" class="samaria p-0 w-50">Cuenca</th>
            <th colspan="2" class="tokio p-0 w-50">Código de operador</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($groups as $group)
            <tr>
              <td colspan="2">{{ $group->basin->basin_name }}</td>
              <td colspan="2">{{ $group->operator->code }}</td>
            </tr>
          @endforeach     
        </tbody>
      </table>
  </div>

<!-- Modal -->
<div class="modal fade" id="operatorModal" tabindex="-1" aria-labelledby="operatorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="operatorModalLabel">Seleccionar Operador</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('groups.store') }}" method="POST">
              @csrf
              <input type="hidden" name="basin_id" id="basin_id">
                <div class="modal-body">
                  <select name="operator_id" class="form-select" required>
                    @foreach ($operators as $operator)
                        @if (!in_array($operator->id, $existingOperatorIds))
                            <option value="{{ $operator->code }}">{{ $operator->code }}</option>
                        @endif
                    @endforeach
                </select>
                
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Agregar</button>
              </div>
          </form>
      </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    window.setBasinId = function(basinId) {
        document.getElementById('basin_id').value = basinId;
        $('#operatorModal').modal('show');
    }
});
</script>

@endsection