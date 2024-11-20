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

    #addRuta9{
    background-color: #f15353 !important;
    color: white
    }

    #addRuta34{
      background-color: #f6f85d !important;
    }

    #BotonT {
        border: none;
        outline: none
    }

    #BotonT:focus {
        box-shadow: none;
    }

    #BotonT:hover{
        background-color: #198754 !important;
    }

    select{
        border: none;
        outline: none;
    }

    select:hover{
        box-shadow: none;
    }

    option{
        background-color: #f0f0f0;
        color: black;
    }

</style>

<div class="d-flex justify-content-between mb-3 w-75 mx-auto">
    <button id="addSamaria" class="btn " onclick="setBasinId(1)">Agregar a Samaria</button>
    <button  id="addRuta9" class="btn " onclick="setBasinId(3)">Agregar a Ruta 9</button>
    <button  id="addRuta34" class="btn " onclick="setBasinId(4)">Agregar a Ruta 34</button>
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
                    <td colspan="2">{{ $group->basin->basin_name }}</td> <!-- Nombre de la cuenca -->
                    <td colspan="2">
                        <div class="d-flex justify-content-between p-0">
                            {{ $group->operator->code }} <!-- Código de operador -->
                            <button id="BotonT" type="button" class="btn btn-sm btn-success transfer-btn">
                                <i class='bx bx-transfer'></i>
                                <select class="bg-success text-light border-0" onchange="transferOperator(this)">
                                    <option value="">Transferir o Soltar</option>
                                    @foreach($basins as $basin)
                                        <option value="{{ $basin->id }}">{{ $basin->basin_name }}</option>
                                    @endforeach
                                    <option value="soltar">Soltar</option>
                                </select>
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
   
       window.transferOperator = function(selectElement) {
            var basinId = selectElement.value;
            var groupId = $(selectElement).closest('tr').data('group-id');
            
            // Manejar específicamente la opción "soltar"
            if (basinId === "soltar") {
                basinId = null;
            }

            $.ajax({
                url: "{{ route('groups.transfer') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    basin_id: basinId,
                    group_id: groupId
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Recargar la página
                    } else {
                        alert(response.message || 'Error en la transferencia');
                    }
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON 
                        ? (xhr.responseJSON.message || 'Error desconocido')
                        : 'Error en la solicitud';
                    
                    alert(errorMessage);
                }
            });
        }
   
        $(document).ready(function() {
            // Filtrar grupos en la tabla en tiempo real
            $('#groupSearch').on('input', function() {
                var searchValue = $(this).val().toLowerCase(); // Obtener el valor de búsqueda y convertirlo a minúsculas
                
                // Recorremos cada fila de la tabla
                $('#rotacion-table tbody tr').each(function() {
                    // Accedemos a la celda que contiene el nombre de la cuenca (columna 1)
                    var basinText = $(this).find('td').eq(0).text().toLowerCase().trim(); // Nombre de la cuenca
                    
                    // Accedemos al div que contiene el código del operador (dentro de la segunda celda)
                    var operatorText = $(this).find('td').eq(1).find('div').contents().filter(function() {
                        return this.nodeType === Node.TEXT_NODE;
                    }).text().toLowerCase().trim(); // Código del operador

                    // Verifica si el texto de búsqueda está en el nombre de la cuenca o en el código del operador
                    var matchBasin = basinText.includes(searchValue); // Coincide con el nombre de la cuenca
                    var matchOperator = operatorText.includes(searchValue); // Coincide con el código del operador

                    // Mostrar fila si coincide con el nombre de la cuenca o el código del operador
                    $(this).toggle(matchBasin || matchOperator);
                });
            });
        });
    });
</script>
    
@endsection

{{-- <i class='bx bxs-hand-up'></i> --}}