@extends('layouts.plantillaDashboard')
@section('title', 'Grupos')

@section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingEdi.css')}}">
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .table-bordered th, .table-bordered td {
        border: 1px solid #909090 !important;
    }
    .table-bordered {
        border-collapse: collapse;
    }
    .table {
        width: 85%
    }

    .d-flex input {
        border: none;
        outline: none
    }

    .d-flex input:focus {
        box-shadow: none
    }

    .btn {
        border: none;
        outline: none
    }

    .btn button:focus {
        box-shadow: none
    }

    #addSamaria{
    background-color: #98fb98 !important;
    }

    #addTokio{
      background-color: #add8e6 !important;
    }

</style>

<div class="d-flex justify-content-between mb-3 w-75 mx-auto">
    <button id="addSamaria" class="btn " onclick="setBasinId(1)">Agregar a Samaria</button>
    <button  class="btn btn-danger" >Agregar a Ruta 9</button>
    <button  class="btn btn-warning" >Agregar a Ruta 34</button>
    <button id="addTokio" class="btn " onclick="setBasinId(2)">Agregar a Tokio</button>
</div> 

<!-- Filtro de búsqueda -->
<div class="d-flex justify-content-end mb-3 w-75 mx-auto">
    <input type="text" id="groupSearch" class="form-control" placeholder="Buscar por cuenca o código de operador">
</div>

<div class="table-responsive">
    <table id="rotacion-table" class="table table-bordered bg-light mx-auto">
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
                <tr data-group-id="{{ $group->id }}">
                    <td colspan="2">{{ $group->basin->basin_name }}</td>
                    <td colspan="2">
                        <div class="d-flex justify-content-between p-0">
                            {{ $group->operator->code }}
                            <button type="button" class="btn btn-sm btn-success transfer-btn">
                                <i class='bx bx-transfer'></i>
                            </button>
                        </div>
                    </td>
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
                  <button type="submit" class="btn btn-warning">Agregar</button>
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

    // Filtrar grupos en la tabla en tiempo real
    $('#groupSearch').on('input', function() {
        var searchValue = $(this).val().toLowerCase();
        $('#rotacion-table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
        });
    });

    // Transferir cuenca del operador
    $('.transfer-btn').on('click', function() {
        var row = $(this).closest('tr');
        var groupId = row.data('group-id');

        $.ajax({
            url: '{{ route("groups.transfer") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                group_id: groupId
            },
            success: function(response) {
                if (response.success) {
                    row.find('td').first().text(response.new_basin);
                } else {
                    alert('Error al transferir el operador.');
                }
            }
        });
    });
});
</script>
@endsection
