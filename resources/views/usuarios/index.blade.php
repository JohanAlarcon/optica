@extends('layouts.app')
<div id="app">
@section('content')

<div class="container">
    <h2>Lista de usuarios registrados <a href="usuarios/create"><button type="button"
                class="btn btn-success float-right">Agregar usuario</button></a></h2>


    <table class="table table-border data-table display responsive nowrap" style="width:100%">
        <thead>
            <tr>
              
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Imagen</th>
                <th scope="col" width="100px">Opciones</th>
            </tr>
        </thead>
        <tbody>
          
          
          

        </tbody>
    </table>


</div>

  @push('scripts')

    <script>
    
      $(function(){
        
        var table = $('.data-table').DataTable({
          
          responsive: true,
          processing: true,
          serverSide: true,
          fixedHeader: true,
          footer: true,
          //dom: "lBrtip",
          dom: "Bfrtip",
          lengthMenu: [ [50, 200, 500, 1000, 2000, -1 ], [ '50 Filas', '200 Filas', '500 Filas','1000 Filas','2000 Filas', 'Mostrar todo' ] ],
          buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
         ],
          ajax: "{{ route('usuarios.index')}}",
          columns: [
            
          
            { data: 'name',   name: 'name'},
            { data: 'email',  name: 'email'},
            { data: 'rol',    name: 'rol'},
            { data: 'imagen', name: 'imagen', searchable: false},
            { data: 'action', name: 'action', orderable:false, searchable:false},
            
          ],
          "language": {

            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
            },
            "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

          }
          
        });
        
         
        
      })

    </script>
      
  @endpush


@endsection

</div>