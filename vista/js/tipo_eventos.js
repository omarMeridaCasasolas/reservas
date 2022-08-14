var tablaTareas,tablaTipoEventos, listaTareas;
var editIDTareas = new Array();
$(document).ready(function () {
    getListaTareas();
    getListaModeloEventos();

	// PARA CREAR TAREA 
	$("#formAddTarea").submit(function (e) { 
		e.preventDefault();
		let nombre  = $("#addNomTarea").val();
        let precio = $("#addPrecioTarea").val();
        $('#modalAgregarTarea').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_tarea.php",
            data: {metodo:"agregarTarea",nombre, precio},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
				if(response == "1"){
					tablaTareas.ajax.reload();
                    Swal.fire('Exito!!','Se ha agregado un nuevo tipo de evento','success');
					$('#formAddTarea')[0].reset();
				}else{
					Swal.fire('Problema!!',response,'error');
				}
            }
        });
	});

	// ELIMINAR TIPO DE RESERVA 
	$("#tablaTareas tbody").on('click','button.deletTarea',function () {
		let datosTarea = tablaTareas.row( $(this).parents('tr') ).data();
		console.log(datosTarea);
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletTarea").html(datosTarea.id_tarea);
		$("#nomDeletTarea").html(datosTarea.nombre_tarea);
    });

	$("#formDeletTarea").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletTarea").html();
        $('#modalEliminarTarea').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_tarea.php",
            data: {metodo:"eliminarTarea", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaTareas.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado la tarea '+$("#nomDeletTarea").html(),'success');
					$('#formDeletTarea')[0].reset();
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

	// EDITAR TIPO TAREAS

	$("#tablaTareas tbody").on('click','button.editTarea',function () {
		let datosTarea = tablaTareas.row( $(this).parents('tr') ).data();
		$("#editNomTarea").val(datosTarea.nombre_tarea);
        $("#editPrecioTarea").val(datosTarea.precio_tarea);
        $("#idEditTarea").html(datosTarea.id_tarea);
    });

	$("#formEditTarea").submit(function (e) { 
		e.preventDefault();
		let nombre  = $("#editNomTarea").val();
        let precio = $("#editPrecioTarea").val();
		let id = $("#idEditTarea").html();
        $('#modalEditTarea').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_tarea.php",
            data: {metodo:"actualizarTarea",nombre, precio, id},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
				if(response == "1"){
					tablaTareas.ajax.reload();
                    Swal.fire('Exito!!','Se ha actualizado tarea','success');
					$('#formEditTarea')[0].reset();
				}else{
					Swal.fire('Problema!!',response,'error');
				}
            }
        });
	});



    $("#formAddTipoEvento").submit(function (e) { 
        e.preventDefault();
        let nombre  = $("#addNomTipoEvento").val();
        let precio = $("#addPrecioTipoEvento").val();
        let tiempo = $("#addTiempoTipoEvento").val();
        let keyTareas = new Array();
        $("input:checkbox[name=tareasName]:checked").each(function(){
            keyTareas.push($(this).val());
        });
        $('#myModal').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_modelo_evento.php",
            data: {metodo:"agregarTipoEvento",nombre, precio, tiempo, idTareas: JSON.stringify(keyTareas)},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
				if(response == "1"){
					tablaTipoEventos.ajax.reload();
                    Swal.fire('Exito!!','Se ha agregado un nuevo tipo de evento','success');
					$('#formAddTipoEvento')[0].reset();
				}else{
					Swal.fire('Problema!!',response,'error');
				}
            }
        });
    });

	// ELIMINAR TIPO DE RESERVA 
	$("#tablaTipoEventos tbody").on('click','button.deletTipoEvento',function () {
		let datosTipoEvento = tablaTipoEventos.row( $(this).parents('tr') ).data();
		console.log(datosTipoEvento);
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletTipoEvento").html(datosTipoEvento.id_modelo_evento);
		$("#nomDeletTipoEvento").html(datosTipoEvento.nombre_modelo_evento);
    });

	$("#formDeletTipoEvento").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletTipoEvento").html();
        $('#modalEliminarTipoEvento').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_modelo_evento.php",
            data: {metodo:"eliminarModeloEvento", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaTipoEventos.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al proveedor '+$("#nomDeletTipoEvento").html(),'success');
					$('#formDeletTipoEvento')[0].reset();
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

	// EDITAR TIPO EVENTO 
	$("#tablaTipoEventos tbody").on('click','button.editTipoEvento',function () {
		let datosTipoEvento = tablaTipoEventos.row( $(this).parents('tr') ).data();
		$(".tareasEditCheck").prop('checked', false);
        $("#editNomTipoEvento").val(datosTipoEvento.nombre_modelo_evento);
		$("#editPrecioTipoEvento").val(datosTipoEvento.precio_aprox);
        $("#editTiempoTipoEvento").val(datosTipoEvento.hora_modelo_evento);
        $("#idEditTipoEvento").html(datosTipoEvento.id_modelo_evento);
		$.ajax({
            type: "POST",
            url: "../controlador/c_modelo_evento.php",
            data: {metodo:"getTareasTipoEvento", idTipoEvento: datosTipoEvento.id_modelo_evento},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
				// editIDTareas = response;
				response.forEach(element => {
					$("#idTareaEdit_"+element.id_tarea).prop('checked', true);
					// $("#idTareaEdit_"+element.id_tarea).prop('checked');
				});
            }
        });
    });


	$("#formEditTipoEvento").submit(function (e) { 
        e.preventDefault();
        $('#modalEditarTipoEvento').modal('hide');
        let id = $("#idEditTipoEvento").html();
        let nombre = $("#editNomTipoEvento").val();
		let precio = $("#editPrecioTipoEvento").val();
        let tiempo = $("#editTiempoTipoEvento").val();
		let keyTareas = new Array();
        $("input:checkbox[name=tareasEditName]:checked").each(function(){
            keyTareas.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "../controlador/c_modelo_evento.php",
            data: {metodo:"actualizarModeloEventoTareas",nombre,precio,tiempo,idTareas: JSON.stringify(keyTareas),id},
            success: function (response) {  
                console.log(response);
                if(response == "1"){
                    tablaTipoEventos.ajax.reload();
					$('#formEditTipoEvento')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del evento','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});


function getListaTareas(){
	$('#tablaTareas').dataTable().fnDestroy();
	tablaTareas = $("#tablaTareas").DataTable({
		"pageLength": 25,
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
			url: "../controlador/c_tarea.php",
			data: { metodo: "getListaTareas"},
		},
		columns: [
			{ data: "id_tarea", width: "5%" },
			{ data: "nombre_tarea", width: "25%" },
            { data: "precio_tarea", width: "25%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editTarea btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditTarea'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='deletTarea btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarTarea'><i class='fas fa-trash'></i></button>",
				width: "10%"
			}
		],
        "initComplete": function(settings, json) {
            listaTareas = json.data;
            // console.log(listaTareas);
            dibujarTareasTipoEvento();
        }
	});
}

function getListaModeloEventos(){
	$('#tablaTipoEventos').dataTable().fnDestroy();
	tablaTipoEventos = $("#tablaTipoEventos").DataTable({
		"pageLength": 25,
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
			url: "../controlador/c_modelo_evento.php",
			data: { metodo: "getListaModeloEventos"},
		},
		columns: [
			{ data: "id_modelo_evento", width: "5%" },
			{ data: "nombre_modelo_evento", width: "25%" },
            { data: "hora_modelo_evento", width: "15%" },
            { data: "precio_aprox", width: "25%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editTipoEvento btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarTipoEvento'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='deletTipoEvento btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarTipoEvento'><i class='fas fa-trash'></i></button>",
				width: "10%"
			}
		]
	});
}

function dibujarTareasTipoEvento(){
    $("#conTareas").empty();
	$("#conEditTareas").empty();
    let cadena='';
	let cadenaEdit = '';
    // console.log(listaTareas)
    listaTareas.forEach(element => {
        cadena+=`<div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" name="tareasName" class="form-check-input tareasCheck" value="${element.id_tarea}" id="idTarea_${element.id_tarea}">${element.nombre_tarea}
        </label>
      </div>`;
	  cadenaEdit+=`<div class="form-check">
	  <label class="form-check-label">
		<input type="checkbox" name="tareasEditName" class="form-check-input tareasEditCheck" value="${element.id_tarea}" id="idTareaEdit_${element.id_tarea}">${element.nombre_tarea}
	  </label>
	</div>`;
    });
	$("#conTareas").html(cadena);
    $("#conEditTareas").html(cadenaEdit);
}