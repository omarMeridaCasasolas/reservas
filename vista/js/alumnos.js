var tablaAlumno;
$(document).ready(function () {
    getListaAlumno(); 

    $("#formAddProveedor").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#nomAddProveedor").val();
        let telefono = $("#telAddProveedor").val();
        let detalle = $("#detalleAddProveedor").val();
        $('#modalAgregarProveedor').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_alumno.php",
            data: {metodo:"agregarProveedor",nombre, telefono, detalle},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaAlumno.ajax.reload();
					$('#formAddProveedor')[0].reset();
                    Swal.fire('Exito!!','Se ha agregado a un nuevo proveedor','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    // EDITAR EMPLEADO
    // $("#tablaAlumno tbody").on('click','button.editProveedor',function (e) {
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
            url: "../controlador/c_alumno.php",
            data: {metodo:"actualizarProveedor",nombre,detalle,telefono,id},
            success: function (response) {  
                console.log(response);
                if(response == "1"){
                    tablaAlumno.ajax.reload();
					$('#formEditProveedor')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del proveedor','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    $("#tablaAlumno tbody").on('click','button.editProveedor',function () {
		let dalosAlumno = tablaAlumno.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#nomEditProveedor").val(dalosAlumno.nombre_proveedor);
		$("#telEditProveedor").val(dalosAlumno.telefono_proveedor);
        $("#detalleEditProveedor").val(dalosAlumno.detalle_provvedor);
        $("#idEditProveedor").html(dalosAlumno.id_proveedor);
    });

    $("#tablaAlumno tbody").on('click','button.deletAlumno',function () {
		let dalosAlumno = tablaAlumno.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletAlumno").html(dalosAlumno.id_alumno);
		$("#nomDeletAlumno").html(dalosAlumno.nombre_alumno);
    });

    $("#formDeletProveedor").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletProveedor").html();
        $('#modalEliminarProveedor').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_alumno.php",
            data: {metodo:"eliminarProveedor", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaAlumno.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al proveedor '+$("#nomDeletProveedor").html(),'success');
					$('#formDeletProveedor')[0].reset();
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});

function getListaAlumno(){
    $('#tablaAlumno').dataTable().fnDestroy();
	tablaAlumno = $("#tablaAlumno").DataTable({
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
			url: "../controlador/c_alumno.php",
			data: { metodo: "getListaAlumno"},
		},
		columns: [
			{ data: "nombre_alumno", width: "25%" },
			{ data: "carnet_alumno", width: "15%" },
            { data: "nombre_tutor", width: "25%" },
            { data: "celular_contacto", width: "15%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProveedor btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fas fa-edit'></i></button> "+
                "<button type='button' class='deletAlumno btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarProveedor'><i class='fas fa-trash'></i></button> ",
				width: "15%"
			}
		]
	});
}