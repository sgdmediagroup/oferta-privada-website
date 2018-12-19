jQuery(document).ready(function() {
	 var t = jQuery('.datatable').DataTable( {
		 dom: 'Bfrtip',
		language: {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ participantes",
			"sZeroRecords":    "No se encontraron participantes",
			"sEmptyTable":     "No existen participantes",
			"sInfo":           "Mostrando participantes del _START_ al _END_ de un total de _TOTAL_ participantes",
			"sInfoEmpty":      "Mostrando participantes del 0 al 0 de un total de 0 participantes",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ participantes)",
			"sInfoPostFix":    "",
			"sSearch":         "<i class='fa fa-search'></i>",
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
		},
		pageLength: 50,
		width: '100%',
		columnDefs: [{
			targets: [0,-1,-2],visible: false
		}],
		order:[10,'desc',12,'asc'],
		scrollX: true,
		buttons: [
            'copy', 'csv', 'excel','colvis'
        ]
	} );
	t.on( 'order.dt search.dt', function () {
        t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
	
	
	 jQuery('.datatable-actividades').DataTable( {
		 dom: 'Bfrtip',
		language: {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ participantes",
			"sZeroRecords":    "No se encontraron participantes",
			"sEmptyTable":     "No existen participantes",
			"sInfo":           "Mostrando participantes del _START_ al _END_ de un total de _TOTAL_ participantes",
			"sInfoEmpty":      "Mostrando participantes del 0 al 0 de un total de 0 participantes",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ participantes)",
			"sInfoPostFix":    "",
			"sSearch":         "<i class='fa fa-search'></i>",
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
		},
		pageLength: 50,
		width: '100%',
		columnDefs: [{
			targets: [0],visible: false
		}],
		order:[1,'desc'],
		scrollX: true,
		buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
							
		
	} );
} );

jQuery(".navbar-brand").click(function() {
    jQuery('.sidebar').toggleClass('active')
});

jQuery(document).ready(function(){
    jQuery('[data-toggle="tooltip"]').tooltip();   
});
	