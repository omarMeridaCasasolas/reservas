var tablaAlumno;
$(document).ready(function () {
    getListaAlumno(); 
    getlistaGrupos();

    $("#addFechaNacAlumno").change(function (e) { 
        e.preventDefault();
        // console.log(getAge($("#addFechaNacAlumno").val()));
        $("#addEdadAlumno").val(getAge($("#addFechaNacAlumno").val()));
        // let fecha = $("#addFechaNacAlumno").val();
    });

    $("#editFechaNacAlumno").change(function (e) { 
        e.preventDefault();
        // console.log(getAge($("#addFechaNacAlumno").val()));
        $("#editEdadAlumno").val(getAge($("#editFechaNacAlumno").val()));
        // let fecha = $("#addFechaNacAlumno").val();
    });

    $("#formAddAlumno").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#addNomAlumno").val();
        let carnet = $("#addCIAlumno").val();
        let nombreTutor = $("#addNomTutorAlumno").val();
        let contacto = $("#addContactoAlumn").val();
        let fecha = $("#addFechaNacAlumno").val();
        let curso = $("#selGrupos").val();
        $('#modalAgregarAlumno').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_alumno.php",
            data: {metodo:"agregarAlumno",nombre, carnet, nombreTutor, contacto, fecha, curso},
            // dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaAlumno.ajax.reload();
					$('#formAddAlumno')[0].reset();
                    Swal.fire('Exito!!','Se ha agregado a un nuevo alumno '+$("#addNomAlumno").val(),'success');
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

    // EDITAR ALUMNO
    $("#formEditAlumno").submit(function (e) { 
        e.preventDefault();
        $('#modalEditarAlumno').modal('hide');
        let id = $("#idEditAlumno").html();
        let nombre = $("#editNomAlumno").val();
		let carnet = $("#editCIAlumno").val();
        let fecha = $("#editFechaNacAlumno").val();
        let tutor = $("#editNomTutorAlumno").val();
		let contacto = $("#editContactoAlumn").val();
        // let detalle = $("#editEdadAlumno").val();
        $.ajax({
            type: "POST",
            url: "../controlador/c_alumno.php",
            data: {metodo:"actualizarAlumno",nombre,carnet,fecha,tutor,contacto,id},
            success: function (response) {  
                console.log(response);
                if(response == "1"){
                    tablaAlumno.ajax.reload();
					$('#formEditAlumno')[0].reset();
                    Swal.fire('Exito!!','Se ha actualizado los datos del alumno '+nombre,'success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    $("#tablaAlumno tbody").on('click','button.editAlumno',function () {
		let datosAlumno = tablaAlumno.row( $(this).parents('tr') ).data();
        $("#idEditAlumno").html(datosAlumno.id_alumno);
        $("#editNomAlumno").val(datosAlumno.nombre_alumno);
		$("#editCIAlumno").val(datosAlumno.carnet_alumno);
        $("#editFechaNacAlumno").val(datosAlumno.fecha_nacimiento);
        $("#editNomTutorAlumno").val(datosAlumno.nombre_tutor);
        $("#editContactoAlumn").val(datosAlumno.celular_contacto);
        $("#editEdadAlumno").val(getAge(datosAlumno.fecha_nacimiento));
        $("#selEditGrupos").val(datosAlumno.id_curso);
    });

    // ELIMINAR ALUMNO 
    $("#tablaAlumno tbody").on('click','button.deletAlumno',function () {
		let dalosAlumno = tablaAlumno.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletAlumno").html(dalosAlumno.id_alumno);
		$("#nomDeletAlumno").html(dalosAlumno.nombre_alumno);
    });

    $("#formDeletAlumno").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletAlumno").html();
        $('#modalEliminarAlumno').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_alumno.php",
            data: {metodo:"eliminarAlumno", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaAlumno.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al alumno '+$("#nomDeletAlumno").html(),'success');
					$('#formDeletAlumno')[0].reset();
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
			url: "../controlador/c_alumno.php",
			data: { metodo: "getListaAlumno"},
		},
		columns: [
            { data: "id_alumno", width: "5%" },
			{ data: "nombre_alumno", width: "25%" },
			{ data: "carnet_alumno", width: "15%" },
            { data: "nombre_tutor", width: "25%" },
            { data: "celular_contacto", width: "15%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editAlumno btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarAlumno'><i class='fas fa-edit'></i></button> "+
                "<button type='button' class='deletAlumno btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarAlumno'><i class='fas fa-trash'></i></button> ",
				width: "15%"
			}
		]
	});
}

// selGrupos

function getlistaGrupos(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_curso.php",
        data: {metodo:"getListaCursoInscripcion"},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            response.forEach(element => {
                $("#selGrupos").append(`<option value='${element.id_curso}'>${element.nombre_curso}</option>`);
                // $("#selEditGrupos").append(`<option value='${element.id_curso}'>${element.nombre_curso}</option>`);
            });
        }
    });
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}