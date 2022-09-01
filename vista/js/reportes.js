var ctx;
let tablaVentas;
let tablaCompras;
let tablaPagosGrupo;
let tablaPagosReserva;
$(document).ready(function () {
    // ctx = document.getElementById('myChart').getContext('2d');
    construirGrafica();
    $("#btnSolicitarReporte").click(function (e) { 
        e.preventDefault();
        let fechaInicio = $("#fechaInicioReporte").val();
        let fechaFin = $("#fechaFinalReporte").val();
        obtenerReporteVenta(fechaInicio,fechaFin);
        obtenerReporteCompras(fechaInicio,fechaFin);
        obtenerPagosCurso(fechaInicio,fechaFin);
		obtenerPagosReserva(fechaInicio,fechaFin);
        // console.log("Se esta haciendo click");
        // let porReserva = $('#checkReserva').is(':checked');
        // let porVenta =  $('#checkVenta').is(':checked');
        
        // if(porReserva){
        //     $("#cajaReserva").removeClass('d-none');
        //     obtenerReporteReserva(fechaInicio,fechaFin);
        // }else{
        //     $("#cajaReserva").addClass('d-none');
        // }
        // if(porVenta){
        //     $("#cajaVenta").removeClass('d-none');
        //     obtenerReporteVenta(fechaInicio,fechaFin);
        // }else{
        //     $("#cajaVenta").addClass('d-none');
        // }
    });
});

function obtenerReporteReserva(fechaInicio,fechaFin){
    $("#tablaReserva tbody").empty();
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo:"obtenerReservasGeneradas", fechaFin, fechaInicio},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            // $(selector).append(content);
            let res = "";
            let totalReserva = 0;
            for (let i = 0; i < response.length; i++) {
                let element = response[i];
                res += `<tr><td>${element.nombre_cliente}</td><td>${element.total_hora}</td><td>${element.total}</td></tr>`;
                totalReserva += Number.parseFloat(element.total);
            }
            $("#tablaReserva tbody").append(res);
            $("#totalReserva").html(totalReserva+" Bs");
        }
    });
}

function obtenerReporteVenta(fechaInicio,fechaFin){
    // $("#tablaVentas tbody").empty();
    // $.ajax({
    //     type: "POST",
    //     url: "../controlador/c_ventas.php",
    //     data: {metodo:"obtenerVentasGeneradas", fechaFin, fechaInicio},
    //     dataType: "JSON",
    //     success: function (response) {
    //         console.log(response);
    //         let res = "";
    //         let totalReserva = 0;
    //         for (let i = 0; i < response.length; i++) {
    //             let element = response[i];
    //             res += `<tr><td>${element.nombre_producto}</td><td>${element.cant_vendida}</td><td>${element.total}</td></tr>`;
    //             totalReserva += Number.parseFloat(element.total);
    //         }
    //         $("#tablaVentas tbody").append(res);
    //         $("#totalVentas").html(totalReserva+" Bs");
    //     }
    // });
    $('#tablaVentas').dataTable().fnDestroy();
	tablaVentas = $("#tablaVentas").DataTable({
        // dom: 'Bfti',
        dom: 'Blfrti',
		responsive: true,
		"order": [[ 0, "desc" ]],
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ninguno dato disponible en esta tabla",
			sInfo:
				"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
			sInfoPostFix: "",
			sSearch: "Buscar:",
			sUrl: "",
			sInfoThousands: ",",
			sLoadingRecords: "Cargando...",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Ultimo",
				sNext: "Siguiente",
				sPrevious: "Anterior",
			},
			oAria: {
				sSortAscending:
					": Activar para ordenar la columna de manera ascendente",
				sSortDescending:
					": Activar para ordenar la columna de manera descendente",
			},
			buttons: {
				copy: "Copiar",
				colvis: "Visibilidad",
			},
		},
		ajax: {
			method: "POST",
			url: "../controlador/c_ventas.php",
			data: { metodo: "getReporteVentas", fechaInicio, fechaFin},
		},
		columns: [
			{ data: "nombre_cliente"},
			{ data: "fecha_venta"},
            { data: "total_venta"},
		],
        buttons: [
			{ 	extend: 'copy',
				className: 'btn btn-info  mb-3', 
				text:      '<i class="fa fa-copy"></i> Copiar',
                titleAttr: 'Copy',
			},
			{ 	extend: 'csv', 
				className: 'btn btn-warning  mb-3',
				text:      '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'csv',
			},
			{ 	extend: 'excel', 
				className: 'btn btn-success mb-3',
				text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
			},
			{ 	extend: 'pdf', 
				className: 'btn btn-danger  mb-3',
				text:      '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				alignment: 'center',

				customize: function (doc) {
					// doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
    				doc.defaultStyle.alignment = 'center';
				} 
			}
        ],
        initComplete: function(settings, json) {
            // console.log(json);
            let total = 0.0;
            json.data.forEach(element => {
                total += parseFloat(element.total_venta);
            });
            $("#totalVentas").html(total);
        }
	});
}

function obtenerReporteCompras(fechaInicio,fechaFin){
    $('#tablaCompras').dataTable().fnDestroy();
	tablaCompras = $("#tablaCompras").DataTable({
        // dom: 'Bfti' p,
        dom: 'Bfrti',
		responsive: true,
		"order": [[ 0, "desc" ]],
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ninguno dato disponible en esta tabla",
			sInfo:
				"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
			sInfoPostFix: "",
			sSearch: "Buscar:",
			sUrl: "",
			sInfoThousands: ",",
			sLoadingRecords: "Cargando...",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Ultimo",
				sNext: "Siguiente",
				sPrevious: "Anterior",
			},
			oAria: {
				sSortAscending:
					": Activar para ordenar la columna de manera ascendente",
				sSortDescending:
					": Activar para ordenar la columna de manera descendente",
			},
			buttons: {
				copy: "Copiar",
				colvis: "Visibilidad",
			},
		},
		ajax: {
			method: "POST",
			url: "../controlador/c_compra.php",
			data: { metodo: "getReporteCompras", fechaInicio, fechaFin},
		},
		columns: [
			{ data: "nombre_proveedor"},
			{ data: "fecha_compra"},
            { data: "total_compra"},
		],
        buttons: [
			{ 	extend: 'copy',
				className: 'btn btn-info  mb-3', 
				text:      '<i class="fa fa-copy"></i> Copiar',
                titleAttr: 'Copy',
			},
			{ 	extend: 'csv', 
				className: 'btn btn-warning  mb-3',
				text:      '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'csv',
			},
			{ 	extend: 'excel', 
				className: 'btn btn-success mb-3',
				text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
			},
			{ 	extend: 'pdf', 
				className: 'btn btn-danger  mb-3',
				text:      '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				alignment: 'center',

				customize: function (doc) {
					// doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
    				doc.defaultStyle.alignment = 'center';
				} 
			}
        ],
        initComplete: function(settings, json) {
            // console.log(json);
            let total = 0.0;
            json.data.forEach(element => {
                total += parseFloat(element.total_compra);
            });
            $("#totalCompras").html(total);
        }
	});
}

function obtenerPagosCurso(fechaInicio,fechaFin){
    $('#tablaPagosGrupo').dataTable().fnDestroy();
	tablaPagosGrupo = $("#tablaPagosGrupo").DataTable({
        // dom: 'Bfti' p,
        dom: 'Bfrti',
		responsive: true,
		"order": [[ 0, "desc" ]],
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ninguno dato disponible en esta tabla",
			sInfo:
				"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
			sInfoPostFix: "",
			sSearch: "Buscar:",
			sUrl: "",
			sInfoThousands: ",",
			sLoadingRecords: "Cargando...",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Ultimo",
				sNext: "Siguiente",
				sPrevious: "Anterior",
			},
			oAria: {
				sSortAscending:
					": Activar para ordenar la columna de manera ascendente",
				sSortDescending:
					": Activar para ordenar la columna de manera descendente",
			},
			buttons: {
				copy: "Copiar",
				colvis: "Visibilidad",
			},
		},
		ajax: {
			method: "POST",
			url: "../controlador/c_pago.php",
			data: { metodo: "obtenerPagosCurso", fechaInicio, fechaFin},
		},
		columns: [
			{ data: "nombre_curso"},
			{ data: "fecha_pago"},
            { data: "pago_efectivo"},
			{ data: "pago_digital"},
            { data: "total_pago"},
		],
        buttons: [
			{ 	extend: 'copy',
				className: 'btn btn-info  mb-3', 
				text:      '<i class="fa fa-copy"></i> Copiar',
                titleAttr: 'Copy',
			},
			{ 	extend: 'csv', 
				className: 'btn btn-warning  mb-3',
				text:      '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'csv',
			},
			{ 	extend: 'excel', 
				className: 'btn btn-success mb-3',
				text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
			},
			{ 	extend: 'pdf', 
				className: 'btn btn-danger  mb-3',
				text:      '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				alignment: 'center',

				customize: function (doc) {
					// doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
    				doc.defaultStyle.alignment = 'center';
				} 
			}
        ],
        initComplete: function(settings, json) {
            // console.log(json);
            let total = 0.0;
            json.data.forEach(element => {
                total += parseFloat(element.total_pago);
            });
            $("#totalPagosGrupo").html(total);
        }
	});
}


function obtenerPagosReserva(fechaInicio,fechaFin){
	$('#tablaPagosReserva').dataTable().fnDestroy();
	tablaPagosReserva = $("#tablaPagosReserva").DataTable({
        // dom: 'Bfti' p,
        dom: 'Bfrti',
		responsive: true,
		"order": [[ 0, "desc" ]],
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ninguno dato disponible en esta tabla",
			sInfo:
				"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
			sInfoPostFix: "",
			sSearch: "Buscar:",
			sUrl: "",
			sInfoThousands: ",",
			sLoadingRecords: "Cargando...",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Ultimo",
				sNext: "Siguiente",
				sPrevious: "Anterior",
			},
			oAria: {
				sSortAscending:
					": Activar para ordenar la columna de manera ascendente",
				sSortDescending:
					": Activar para ordenar la columna de manera descendente",
			},
			buttons: {
				copy: "Copiar",
				colvis: "Visibilidad",
			},
		},
		ajax: {
			method: "POST",
			url: "../controlador/c_reserva.php",
			data: { metodo: "obtenerPagosReserva", fechaInicio, fechaFin},
		},
		columns: [
			{ data: "nombre_cliente"},
			{ data: "identificador_reserva"},
            { data: "hora_reserva"},
			{ data: "hora_limite"},
            { data: "duracion_reserva"},
			{ data: "pago_efectivo"},
			{ data: "pago_digital"},
            { data: "costo_reserva"},
		],
        buttons: [
			{ 	extend: 'copy',
				className: 'btn btn-info  mb-3', 
				text:      '<i class="fa fa-copy"></i> Copiar',
                titleAttr: 'Copy',
			},
			{ 	extend: 'csv', 
				className: 'btn btn-warning  mb-3',
				text:      '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'csv',
			},
			{ 	extend: 'excel', 
				className: 'btn btn-success mb-3',
				text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
			},
			{ 	extend: 'pdf', 
				className: 'btn btn-danger  mb-3',
				text:      '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				alignment: 'center',

				customize: function (doc) {
					// doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
    				doc.defaultStyle.alignment = 'center';
				} 
			}
        ],
        initComplete: function(settings, json) {
            // console.log(json);
            let total = 0.0;
            json.data.forEach(element => {
                total += parseFloat(element.total_pago);
            });
            $("#totalPagoReserva").html(total);
        }
	});
}

function construirGrafica(){
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}