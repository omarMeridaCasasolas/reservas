var tablaProveedor;
$(document).ready(function () {
    getListaProveedor(); 

    $("#formAddProveedor").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#nomAddProveedor").val();
        let telefono = $("#telAddProveedor").val();
        let detalle = $("#detalleAddProveedor").val();
        $('#modalAgregarProveedor').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_proveedor.php",
            data: {metodo:"agregarProveedor",nombre, telefono, detalle},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaProveedor.ajax.reload();
					$('#formAddProveedor')[0].reset();
                    Swal.fire('Exito!!','Se ha agregado a un nuevo proveedor','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    // EDITAR EMPLEADO
    // $("#tablaProveedor tbody").on('click','button.editProveedor',function (e) {
	// 	e.preventDefault();
    //     console.log("Se ha hecho click en cerrado");
    // });

    $("#formEditProveedor").submit(function (e) { 
        e.preventDefault();
        $('#modalEditarProveedor').modal('hide');
        let id = $("#idEditProveedor").html();
        let nombre = $("#nomEditProveedor").val();
		let telefono = $("#telEditProveedor").val();
        let detalle = $("#detalleEditProveedor").val();
        $.ajax({
            type: "POST",
            url: "../controlador/c_proveedor.php",
            data: {metodo:"actualizarProveedor",nombre,detalle,telefono,id},
            success: function (response) {  
                console.log(response);
                if(response == "1"){
                    tablaProveedor.ajax.reload();
					$('#formEditProveedor')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del proveedor','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    $("#tablaProveedor tbody").on('click','button.editProveedor',function () {
		let datosProveedor = tablaProveedor.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#nomEditProveedor").val(datosProveedor.nombre_proveedor);
		$("#telEditProveedor").val(datosProveedor.telefono_proveedor);
        $("#detalleEditProveedor").val(datosProveedor.detalle_provvedor);
        $("#idEditProveedor").html(datosProveedor.id_proveedor);
    });

    $("#tablaProveedor tbody").on('click','button.deletProveedor',function () {
		let datosProveedor = tablaProveedor.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletProveedor").html(datosProveedor.id_proveedor);
		$("#nomDeletProveedor").html(datosProveedor.nombre_proveedor);
    });

    $("#formDeletProveedor").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletProveedor").html();
        $('#modalEliminarProveedor').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_proveedor.php",
            data: {metodo:"eliminarProveedor", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaProveedor.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al proveedor '+$("#nomDeletProveedor").html(),'success');
					$('#formDeletProveedor')[0].reset();
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});

function getListaProveedor(){
    $('#tablaProveedor').dataTable().fnDestroy();
	tablaProveedor = $("#tablaProveedor").DataTable({
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
			url: "../controlador/c_proveedor.php",
			data: { metodo: "getListaProveedor"},
		},
		columns: [
			{ data: "nombre_proveedor", width: "25%" },
			{ data: "telefono_proveedor", width: "15%" },
            { data: "detalle_proveedor", width: "30%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProveedor btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fas fa-edit'></i></button> "+
                "<button type='button' class='deletProveedor btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarProveedor'><i class='fas fa-trash'></i></button> ",
				width: "13%"
			}
		]
	});
}