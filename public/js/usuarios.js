$(function(){
         
    $('.data-table thead tr').clone(true).appendTo( '.data-table thead' );
    $('.data-table thead tr:eq(1) th').each( function (i) {
        
        var title = $(this).text();
      
         if(title == 'Fecha creacion'){
          
          $(this).html( '<div class="row"><input type="date" class="form-control" id="min-date" /><input type="date" class="form-control" id="max-date" /></div>');
        
        }else  if(title!= 'Imagen' && title!= 'Opciones'){
          
          $(this).html( '<div class="row"><input type="text" class="form-control" placeholder="Buscar '+title+'" /></div>' );
  
          $( 'input', this ).on( 'keyup change', function () {
            
              if ( table.column(i).search() !== this.value ) {
                  
                  table.column(i).search( this.value ).draw();
                  
              }
          } );
        
      }else{
        
        $(this).html( '<input type="hidden" style="display:none" />' );
        
      }
        
    } );
    
    
    var table = $('.data-table').DataTable({
      
      orderCellsTop: true,
      responsive: true,
      processing: true,
      //Esta linea se comenta para que funcione el filtro de fechas en el dataTable
      //serverSide: true, 
      fixedHeader: true,
      footer: true,
      dom: "lBrtip",
      lengthMenu: [ [50, 200, 500, 1000, 2000, -1 ], [ '50 Filas', '200 Filas', '500 Filas','1000 Filas','2000 Filas', 'Mostrar todo' ] ],
      buttons: {
        
        dom: {
          button: {
            tag: 'button',
            className: ''
          }
        },
        buttons:  [{
          extend: 'excel',
          text: '<i class="far fa-file-excel"></i> Excel',
          titleAttr: 'Exportar a Excel',
          className: 'btn btn-sm btn-success',
          exportOptions: {
            columns: [ 0, 1, 2 ],
          }
        },
        {
          extend: 'csvHtml5',
          text: '<i class="fas fa-file-csv"></i> CSV',
          titleAttr: 'CSV',
          className: 'btn btn-sm btn-success',
          exportOptions: {
            columns: [ 0, 1, 2 ],
          }
        },
        {
          extend: 'copy',
          text: '<i class="far fa-copy"></i> Copiar',
          titleAttr: 'copiar',
          className: 'btn btn-sm btn-secondary',
          exportOptions: {
            columns: [ 0, 1, 2 ],
          }
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> PDF',
          titleAttr: 'PDF',
          className: 'btn btn-sm btn-danger',
          exportOptions: {
            columns: [ 0, 1, 2 ],
          }
        },
        {
          extend: 'print',
          text: '<i class="fas fa-print"></i> Imprimir',
          className: 'btn btn-sm btn-warning',
          titleAttr: 'Imprimir',
          exportOptions: {
            columns: [ 0, 1, 2 ],
          }
        }]
      }, 
     /*  ajax: "{{ route('usuarios.index')}}", */
       ajax: "../../../../../../optica/public/index.php/usuarios",
      columns: [
        
      
        { data: 'name',          name: 'name'},
        { data: 'email',         name: 'email'},
        { data: 'created_at',    name: 'created_at', type:"date"},
        { data: 'rol',           name: 'rol'}, 
        { data: 'imagen',        name: 'imagen', orderable:false, searchable: false},
        { data: 'action',        name: 'action', orderable:false, searchable:false},
        
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
    
    $.fn.dataTable.ext.search.push(
      
        function(settings, data, dataIndex) {
          
          var min = $('#min-date').val();
          var max = $('#max-date').val();
          
          var createdAt = data[2] || 0; 
          
          if (min == '' && max == '')                return true; 
          if (min == '' && createdAt <= max)         return true; 
          if (max == '' && createdAt >= min)         return true; 
          if (createdAt <= max && createdAt >= min)  return true; 
            
            return false;

        });
    

      $('#min-date,#max-date').change( function() {
       
        table.draw();
          
      });
      
      $('.reset').click( function() {
       
        if($("#guardar").attr('disabled')){
           
          window.location.href =  $("#usuarios").attr("href");
        
        }else{
          
          this.form.reset();
          
        }
       
          
      });  
    
  });
 