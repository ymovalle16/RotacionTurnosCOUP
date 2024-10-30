@extends('layouts.plantillaDashboard')
@section('title', 'Rotaciones')
{{-- @section('estilos')
<link rel="stylesheet" href="{{asset('CSS/ingEdi.css')}}">
@endsection --}}
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
  /* Estilo para bordes de la tabla */
  .table-bordered th, .table-bordered td {
    border: 1px solid #909090 !important;
  }
  .table-bordered {
    border-collapse: collapse;
  }

  .table{
    width: 85%
  }
    /* Estilo para la fila de fechas */
    #rotacion-fechas {
    background-color: #f0f0f0; /* Gris claro */
  }

  /* Estilo para las columnas de Samaria y Tokio */
  .samaria {
    background-color: #98fb98 !important; /* Verde */
  }
  .tokio {
    background-color: #add8e6 !important; /* Azul */
  }

  /* Estilo para los encabezados de Código de Bus y Nombre */
  .cod-nombre {
    background-color: #f0f0f0 !important; /* Gris claro */
  }

  /* Estilo para las celdas restantes */
  .resto {
    background-color: #ffffff !important; /* Blanco */
  }
</style>
<div class="table-responsive">
  <div style="display: flex; justify-content: flex-end; width: 92%;">
    <button id="download-pdf" class="btn btn-warning  mb-3">Descargar</button>
</div>
  <table id="rotacion-table"class="table table-bordered bg-light mx-auto">
    <thead>
      <tr>
        <th colspan="4" class="text-center p-0"><div id="rotacion-fechas"></div></th>
      </tr>
      <tr class="text-center">
        <th colspan="2" class="samaria p-0">Samaria</th>
        <th colspan="2" class="tokio p-0">Tokio</th>
      </tr>
      <tr class="text-center">
        <th class="cod-nombre p-0">Codido de Bus</th>
        <th class="cod-nombre p-0">Nombre</th>
        <th class="cod-nombre p-0">Codido de Bus</th>
        <th class="cod-nombre p-0">Nombre</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="resto">Bus 1</td>
        <td class="resto">Nombre 1</td>
        <td class="resto">Bus 2</td>
        <td class="resto">Nombre 2</td>
      </tr>
      <tr>
        <td class="resto">Bus 3</td>
        <td class="resto">Nombre 3</td>
        <td class="resto">Bus 4</td>
        <td class="resto">Nombre 4</td>
      </tr>
    </tbody>
  </table>
</div>



<script>
  function getMonday(d) {
    d = new Date(d);
    var day = d.getDay(),
        diff = d.getDate() - day + (day === 0 ? -6 : 1); // adjust when day is sunday
    return new Date(d.setDate(diff));
  }

  function formatDate(date) {
    var options = { day: 'numeric', month: 'long' };
    return date.toLocaleDateString('es-ES', options); // Use Spanish locale for month in letters
  }

  function setWeekRange() {
    var today = new Date();
    var monday = getMonday(today);
    var sunday = new Date(monday);
    sunday.setDate(monday.getDate() + 6);

    var formattedMonday = formatDate(monday);
    var formattedSunday = formatDate(sunday);

    document.getElementById('rotacion-fechas').innerText = `Rotación del ${formattedMonday} al ${formattedSunday}`;
  }

  document.addEventListener('DOMContentLoaded', (event) => {
    setWeekRange();
  });

  document.getElementById('download-pdf').addEventListener('click', () => {
  const element = document.getElementById('rotacion-table');
  html2pdf()
    .from(element)
    .set({
      margin: 0.5,   
      filename: 'rotacion.pdf',
      html2canvas: { scale: 3 }, // Aumentar la escala para mejor calidad
      jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    })
    .save();
});

</script>

@endsection
