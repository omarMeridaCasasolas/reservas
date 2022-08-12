var tablaCurso;
$(document).ready(function () {
    getListaCurso();
    getListaAlumno(); 

    $("#formAddCurso").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#addNombreCurso").val();
        let fecha = $("#addFechaCurso").val();
        let nomProfesor = $("#addProfesorCurso").val();
        let grupo = $("#addGrupoCurso").val();
        $('#modalAgregarProveedor').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_curso.php",
            data: {metodo:"agregarProveedor",nombre, telefono, detalle},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaCurso.ajax.reload();
					$('#formAddCurso')[0].reset();
                    Swal.fire('Exito!!','Se ha agregado un nuevo curso','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    // EDITAR EMPLEADO
    // $("#tablaCurso tbody").on('click','button.editProveedor',function (e) {
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
            url: "../controlador/c_curso.php",
            data: {metodo:"actualizarProveedor",nombre,detalle,telefono,id},
            success: function (response) {  
                console.log(response);
                if(response == "1"){
                    tablaCurso.ajax.reload();
					$('#formEditProveedor')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del proveedor','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    $("#tablaCurso tbody").on('click','button.editProveedor',function () {
		let datosProveedor = tablaCurso.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#nomEditProveedor").val(datosProveedor.nombre_proveedor);
		$("#telEditProveedor").val(datosProveedor.telefono_proveedor);
        $("#detalleEditProveedor").val(datosProveedor.detalle_provvedor);
        $("#idEditProveedor").html(datosProveedor.id_proveedor);
    });

    $("#tablaCurso tbody").on('click','button.deletProveedor',function () {
		let datosProveedor = tablaCurso.row( $(this).parents('tr') ).data();
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
            url: "../controlador/c_curso.php",
            data: {metodo:"eliminarProveedor", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaCurso.ajax.reload();
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
    $.ajax({
        type: "POST",
        url: "../controlador/c_alumno.php",
        data: {metodo:'getListaAlumno'},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            let arregloAlumnos = response.data;
            // let listaClientes = JSON.parse(response);
            // $("#addPedidoTienda").empty();
            // $("#editPedidoTienda").empty();
            // $("#addPedidoTienda").append("<option value=''>Ninguno</option>");
            // $("#editPedidoTienda").append("<option value=''>Ninguno</option>");
            arregloAlumnos.forEach(element => {
                $("#addAlumnosCurso").append("<option value='"+element.id_alumno+"'>"+element.nombre_alumno+" - "+element.carnet_alumno+"</option>");
                // $("#editPedidoTienda").append("<option value='"+element.id_cliente+"'>"+element.nombre_cliente+" - "+element.ci_cliente+"</option>");
            });
            $('#addAlumnosCurso').select2();
            // $('#editPedidoTienda').select2();
        }
    });
}

function getListaCurso(){
    $('#tablaCurso').dataTable().fnDestroy();
	tablaCurso = $("#tablaCurso").DataTable({
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
			url: "../controlador/c_curso.php",
			data: { metodo: "getListaCurso"},
		},
		columns: [
			{ data: "nombre_curso", width: "25%" },
			{ data: "nombre_profesor", width: "20%" },
            { data: "fecha_inicio", width: "10%" },
            { data: "horario_curso", width: "10%" },
            { data: "cantidad_alumnos", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProveedor btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fas fa-edit'></i></button> "+
                "<button type='button' class='deletProveedor btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarProveedor'><i class='fas fa-trash'></i></button> ",
				width: "10%"
			}
		]
	});
}