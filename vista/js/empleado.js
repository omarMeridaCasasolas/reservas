var tablaEmpleado;
$(document).ready(function () {
    getListaEmpleado(); 

    $("#formAddEmpleado").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#nomAddEmpleado").val();
        let usuario = $("#userAddEmpleado").val();
        let pass = $("#passAddEmpleado").val();
        let tipo = $("#tipoAddEmpleado").val();
        let telef = $("#telAddEmpleado").val();
        $('#modalAgregarEmpleado').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_empleado.php",
            data: {metodo:"agregarEmpleado",nombre,usuario, pass, tipo , telef},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaEmpleado.ajax.reload();
					$('#formAddEmpleado')[0].reset();
                    Swal.fire('Exito!!','Se ha agregado aun nuevo empleado','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    // EDITAR EMPLEADO
    // $("#tablaEmpleado tbody").on('click','button.editEmpleado',function (e) {
	// 	e.preventDefault();
    //     console.log("Se ha hecho click en cerrado");
    // });

    $("#formEditEmpleado").submit(function (e) { 
        e.preventDefault();
        $('#modalEditarEmpleados').modal('hide');
        let id = $("#idEditEmpleado").html();
        let nombre = $("#nomEditEmpleado").val();
		let user = $("#userEditEmpleado").val();
        let estado = $("#estadoEditEmpleado").val();
		let tipo = $("#tipoEditEmpleado").val();
        let telef = $("#telEditEmpleado").val();
        $.ajax({
            type: "POST",
            url: "../controlador/c_empleado.php",
            data: {metodo:"actualizarEmpleado",nombre,user,estado,tipo,telef,id},
            success: function (response) {  
                console.log(response);
                if(response == "1"){
                    tablaEmpleado.ajax.reload();
					$('#formAddEmpleado')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del empleado','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    $("#tablaEmpleado tbody").on('click','button.editEmpleado',function () {
		let datosEmpleado = tablaEmpleado.row( $(this).parents('tr') ).data();
        console.log(datosEmpleado);
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#nomEditEmpleado").val(datosEmpleado.nombre_empleado);
		$("#userEditEmpleado").val(datosEmpleado.usuario_empleado);
        $("#estadoEditEmpleado").val(datosEmpleado.estado_empleado);
		$("#tipoEditEmpleado").val(datosEmpleado.tipo_empleado);
        $("#telEditEmpleado").val(datosEmpleado.telefono_empleado);
		$("#idEditEmpleado").html(datosEmpleado.id_empleado);
    });

    $("#tablaEmpleado tbody").on('click','button.deletEmpleado',function () {
		let datosProveedor = tablaEmpleado.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletEmpleado").html(datosProveedor.id_empleado);
		$("#nomDeletEmpleado").html(datosProveedor.nombre_empleado); 
    });

    $("#formDeletEmpleado").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletEmpleado").html();
        $('#modalEliminarEmpleado').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_empleado.php",
            data: {metodo:"eliminarEmpleado", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaEmpleado.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al empleado '+$("#nomDeletEmpleado").html(),'success');
					$('#formDeletEmpleado')[0].reset();
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});

function getListaEmpleado(){
    $('#tablaEmpleado').dataTable().fnDestroy();
	tablaEmpleado = $("#tablaEmpleado").DataTable({
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
			url: "../controlador/c_empleado.php",
			data: { metodo: "getListaEmpleado"},
		},
		columns: [
			{ data: "nombre_empleado", width: "23%" },
			{ data: "usuario_empleado", width: "23%" },
            { data: "telefono_empleado", width: "10%" },
			{ data: "tipo_empleado", width: "15%" },
            { data: "estado_empleado", // can be null or undefined
				// "defaultContent": "Sin Asignacion", "width": "15%"},
				render: function (data) {
				  if (data == '1') {
					return '<h5><span class="badge badge-success">Activo</span></h5>';
					} else {
						return '<h5><span class="badge badge-danger">Baja</span></h5>';
					}
				},width: "14%",
			},
			{ data: null,
				defaultContent:
				"<button type='button' class='editEmpleado btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarEmpleados'><i class='fas fa-edit'></i></button> "+
                "<button type='button' class='deletEmpleado btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarEmpleado'><i class='fas fa-trash'></i></button> ",
				width: "10%"
			}
		]
	});
}