var tablaCliente;
$(document).ready(function () {
    getListaClientes(); 

	$("#checkConfirmacion").change(function (e) { 
		e.preventDefault();
		let res = $('#checkConfirmacion').is(':checked');
		if(res){
			$('#btnEliminarCliente').prop("disabled", false);
		}else{
			$('#btnEliminarCliente').prop("disabled", true);
		}
	});

    $("#formAddCliente").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#nomCliente").val();
        let ci = $("#ciCliente").val();
        let numero = $("#numCliente").val();
        $('#modalAgregarCliente').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_cliente.php",
            data: {metodo:"agregarCliente",nombre,ci,numero},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaCliente.ajax.reload();
					$('#formAddCliente')[0].reset();
                    Swal.fire('Exito!!','Se ha creado el cliente','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

	// EDITAR CLIENTE 
	$("#tablaCliente tbody").on('click','button.editCliente',function () {
		let datosCliente = tablaCliente.row( $(this).parents('tr') ).data();
        $("#idEditCliente").html(datosCliente.id_cliente);
        $("#nomEditCliente").val(datosCliente.nombre_cliente);
		$("#numEditCliente").val(datosCliente.celular_cliente);
        $("#ciEditCliente").val(datosCliente.ci_cliente);
    });

	$("#formEditCliente").submit(function (e) { 
		e.preventDefault();
		let id = $("#idEditCliente").html();
		let nombreCliente = $("#nomEditCliente").val();
		let celCliente = $("#numEditCliente").val();
		let ciCliente = $("#ciEditCliente").val(); 
		$('#modalEditarCliente').modal('hide');
		$.ajax({
			type: "POST",
			url: "../controlador/c_cliente.php",
			data: {metodo:'actualizarCliente',nombreCliente,celCliente,ciCliente,id},
			dataType: "JSON",
			success: function (response) {
				if(response == "1"){
                    tablaCliente.ajax.reload();
					$('#formEditCliente')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del cliente','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
			}
		});
	});

	// ELIMINAR CLIENTE 
	$("#tablaCliente tbody").on('click','button.eliminarCliente',function () {
		let datosCliente = tablaCliente.row( $(this).parents('tr') ).data();
        $("#idEliminarCliente").html(datosCliente.id_cliente);
        $("#nomEliminarCliente").html(datosCliente.nombre_cliente);
    });

	$("#formEliminarCliente").submit(function (e) { 
		e.preventDefault();
		$('#modalEliminarCliente').modal('hide');
		$.ajax({
			type: "POST",
			url: "../controlador/c_cliente.php",
			data: {metodo:"eliminarCliente",id:$("#idEliminarCliente").html()},
			dataType: "JSON",
			success: function (response) {
				// console.log(response);
				if(response == "1"){
					$('#checkConfirmacion').prop('checked', false);
					$('#btnEliminarCliente').prop("disabled", true);
                    tablaCliente.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al cliente '+$("#nomEliminarCliente").html(),'success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
			}
		});
	});
});

function getListaClientes(){
    $('#tablaCliente').dataTable().fnDestroy();
	tablaCliente = $("#tablaCliente").DataTable({
		"pageLength": 50,
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
			url: "../controlador/c_cliente.php",
			data: { metodo: "getListaClientesData"},
		},
		columns: [
			{ data: "id_cliente", width: "5%" },
			{ data: "nombre_cliente", width: "25%" },
            { data: "celular_cliente", width: "15%" },
			{ data: "ci_cliente", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editCliente btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarCliente'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='eliminarCliente btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarCliente'><i class='fas fa-trash'></i></button>",
				width: "10%"
			}
		],
		dom: 'Blfrtip',
        buttons: [
			{ 	extend: 'copy',
				className: 'btn btn-info  mb-3', 
				text:      '<i class="fa fa-copy"></i> Copiar',
                titleAttr: 'Copy',
				exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
			},
			{ 	extend: 'csv', 
				className: 'btn btn-warning  mb-3',
				text:      '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'csv',
				exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                } 
			},
			{ 	extend: 'excel', 
				className: 'btn btn-success mb-3',
				text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                } 
			},
			{ 	extend: 'pdf', 
				className: 'btn btn-danger  mb-3',
				text:      '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
				alignment: 'center',
				exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                },
				customize: function (doc) {
					// doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
    				doc.defaultStyle.alignment = 'center';
				} 
			}
        ]
	});
}