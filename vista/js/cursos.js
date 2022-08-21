var tablaCurso;
let arregloAlumnos = new Array();
let listaDatosAlumnos = new Array();
let alumnosEliminados = new Array();
let alumnosNuevos = new Array();
let cantAlumnosInscritos = 0;   //Solo se actualiza por cada curso
let cantAlumnosNuevos = 0;
let cantAlumnosEliminados = 0;
$(document).ready(function () {
    getListaCurso();
    getListaAlumno(); 
    calcularFechaReserva();

    $("#addTurnoEntrada").change(function (e) { 
        e.preventDefault();
        let tiempoEntrada = $("#addTurnoEntrada").val();
        let target = new Date("1970-01-01 " + tiempoEntrada);
        target.setMinutes(target.getMinutes() + 30);
        //target = new Date(target); 
        let horaSalida = agregarZero(parseInt(target.getHours()))+":"+agregarZero(parseInt(target.getMinutes()));
        $("#addTurnoSalida").val(horaSalida);
        console.log(horaSalida);
    });

    // EDITAR LISTA DE ALUMNO POR CURSO 
    $("#formEdicionAlumnos").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../controlador/c_curso.php",
            data: {metodo:"actualizarListaAlumnosCurso", idCurso: $("#editAlumnoCurso").html(),listaAlumnosNuevos:JSON.stringify(alumnosNuevos),listaAlumnosEliminados:JSON.stringify(alumnosEliminados)},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
            }
        });
    });


    // CAMBIAR FECHA 
    $("#addFechaEntrada").change(function (e) { 
        e.preventDefault();
        calcularFechaReserva();
    });

    $("#editFechaEntrada").change(function (e) { 
        e.preventDefault();
        calcularFechaReservaEditar();
    });

    $("#formAddCurso").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#addNombreCurso").val();
        let precio = $("#addPrecioCurso").val();
        let nomProfesor = $("#addProfesorCurso").val();
        let grupo = $("#addGrupoCurso").val();
        let entrada = $("#addTurnoEntrada").val();
        let salida = $("#addTurnoSalida").val();
        let fechaEntrada = $("#addFechaEntrada").val();
        let fechaSalida = $("#addFechaSalida").val();
        let fechasJuego = new Array();
        $('#cajaFechasSemana .form-check-input:checked').each(function() {
            fechasJuego.push($(this).val());
        });
        // console.log(fechasJuego);
        // console.log(fechaEntrada);
        // console.log(entrada);
        $('#myModal').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_curso.php",
            data: {metodo:"agregarCurso",nombre, precio, nomProfesor,grupo, entrada,salida,fechaEntrada,fechaSalida ,fechasReserva: JSON.stringify(fechasJuego)},
            // dataType: "JSON",
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

    // EDITAR CURSO 
    $("#tablaCurso tbody").on('click','button.editCurso',function (e) {
		e.preventDefault();
        let datosCurso = tablaCurso.row( $(this).parents('tr') ).data();
        console.log(datosCurso);
        $("#idEditCurso").html(datosCurso.id_curso);
        $("#editNombreCurso").val(datosCurso.nombre_curso);
        $("#editPrecioCurso").val(parseFloat(datosCurso.precio_curso));
        $("#editProfesorCurso").val(datosCurso.nombre_profesor);
        $("#editGrupoCurso").val(datosCurso.grupo_curso);
        $("#editTurnoEntrada").val(datosCurso.horario_entrada);
        $("#editTurnoSalida").val(datosCurso.horario_salida);
        $("#editFechaEntrada").val(datosCurso.fecha_inicio);
        $("#editFechaSalida").val(datosCurso.fecha_final);
        calcularFechaReservaEditar();
        $.ajax({
            type: "POST",
            url: "../controlador/c_reserva.php",
            data: {metodo:"listaReservaSemanaEdit", fechaInicio:datosCurso.fecha_inicio, idCurso: datosCurso.id_curso },
            dataType: "JSON",
            success: function (response) {
                response.forEach(element => {
                    $( "#cajaEditFechasSemana input[value="+element.fecha_reserva+"]").prop( "checked", true );
                });
            }
        });
    });

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

    $("#tablaCurso tbody").on('click','button.editAlumnos',function () {
		let datosCurso = tablaCurso.row( $(this).parents('tr') ).data();
        $("#editAlumnoCurso").html(datosCurso.id_curso);
        // $("#nomEditProveedor").val(datosProveedor.nombre_proveedor);
        $("#cajaAlumnosNuevos").empty();
        $("#cajaAlumnosEliminados").empty();
        $.ajax({
            type: "POST",
            url: "../controlador/c_curso.php",
            data: {metodo: "listaAlumnosCursoGrupo", idCurso:datosCurso.id_curso},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                arregloAlumnos = new Array();
                // $("#cajaAlumnosNuevos").append("<ul>");
                response.forEach(element => {
                    $("#cajaAlumnosNuevos").append(`<li>${element.nombre_alumno} - ${element.edad}</li>`);
                    // $("#listaAlumnosInscritos").select2().val(element.id_alumno).trigger("change");
                    // $("#listaAlumnosInscritos").val(element.id_alumno);
                    arregloAlumnos.push(element.id_alumno);
                });
                // $("#cajaAlumnosNuevos").append("</ul>");
                $("#listaAlumnosInscritos").val(arregloAlumnos);
                cantAlumnosInscritos = arregloAlumnos.length;
                // $("#listaAlumnosInscritos").select2();
                $('#listaAlumnosInscritos').select2().trigger('change');
                cantAlumnosNuevos = 0;
                cantAlumnosEliminados = 0;
            }
        });
    });

    $("#listaAlumnosInscritos").change(function (e) { 
        e.preventDefault();
        // var selectVal = $("#listaAlumnosInscritos option:selected").val();
        let listaAlumnosActual = $('#listaAlumnosInscritos').val(); 
        // console.log("Alumnos inscritos inicio "+arregloAlumnos);
        // console.log("Alumnos inscritos nuevos"+listaAlumnosActual);
        alumnosNuevos = listaAlumnosActual.filter(item => !arregloAlumnos.includes(item));
        console.log(arregloAlumnos);
        if(cantAlumnosNuevos != alumnosNuevos.length){
            // let element = alumnosNuevos[alumnosNuevos.length-1];
            //     let alumno = listaDatosAlumnos.find(x => x.id_alumno == element );
            //     console.log(alumno);
            //     $("#cajaAlumnosNuevos").append(`<li>${alumno.nombre_alumno} - ${alumno.edad}</li>`);
            $("#cajaAlumnosNuevos").empty();
            listaAlumnosActual.forEach(element => {
                console.log(element);
                let alumno = listaDatosAlumnos.find(x => x.id_alumno == element );
                console.log(alumno);
                $("#cajaAlumnosNuevos").append(`<li>${alumno.nombre_alumno} - ${alumno.edad}</li>`);
            });
            cantAlumnosNuevos = listaAlumnosActual.length;
        }
        alumnosEliminados = arregloAlumnos.filter(item => !listaAlumnosActual.includes(item));
        console.log("Alumnos eliminados "+alumnosEliminados);
        if(cantAlumnosEliminados != alumnosEliminados.length){
            $("#cajaAlumnosEliminados").empty();
            alumnosEliminados.forEach(element => {
                let alumno = listaDatosAlumnos.find(x => x.id_alumno == element );
                console.log(alumno);
                $("#cajaAlumnosEliminados").append(`<li>${alumno.nombre_alumno} - ${alumno.edad}</li>`);
            });
            cantAlumnosEliminados = alumnosEliminados.length;
        }
    });

    $("#tablaCurso tbody").on('click','button.deletCurso',function () {
		let datosCurso = tablaCurso.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletCurso").html(datosCurso.id_curso);
		$("#nomDeletCurso").html(datosCurso.nombre_curso);
    });

    $("#formDeletCurso").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletCurso").html();
        $('#modalEliminarCurso').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_curso.php",
            data: {metodo:"eliminarCurso", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaCurso.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado al curso '+$("#nomDeletCurso").html(),'success');
					$('#formDeletCurso')[0].reset();
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
            listaDatosAlumnos = response.data;
            // let listaClientes = JSON.parse(response);
            // $("#addPedidoTienda").empty();
            // $("#editPedidoTienda").empty();
            // $("#addPedidoTienda").append("<option value=''>Ninguno</option>");
            // $("#editPedidoTienda").append("<option value=''>Ninguno</option>");
            listaDatosAlumnos.forEach(element => {
                $("#listaAlumnosInscritos").append("<option value='"+element.id_alumno+"'>"+element.nombre_alumno+" - "+element.edad+"</option>");
                // $("#editPedidoTienda").append("<option value='"+element.id_cliente+"'>"+element.nombre_cliente+" - "+element.ci_cliente+"</option>");
            });
            // $('#listaAlumnosInscritos').select2();
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
            { data: "horario_entrada", width: "10%" },
            { data: "cantidad_alumnos", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editCurso btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarCurso'><i class='fas fa-edit'></i></button> "+
                "<button type='button' class='deletCurso btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarCurso'><i class='fas fa-trash'></i></button> "+
                "<button type='button' class='editAlumnos btn btn-info btn-sm' data-toggle='modal' data-target='#modalAlumnos'><i class='fa fa-users'></i></button> ",
				width: "10%"
			}
		]
	});
}


function agregarZero(val){
    if(val<10){
        return "0"+val;
    }else{
        return val;
    }
}

function calcularFechaReserva(){
    let weekday = ["domingo","lunes","martes","miercoles","jueves","viernes","sabado"];
        let fecha = new Date($("#addFechaEntrada").val());
        fecha.setDate(fecha.getDate() + 1);
        let fechaInicio = parseInt(fecha.getDay());
        let cadena = '<p>Fechas de practica</p>';
        for (let i = 0; i < weekday.length; i++) {
            let dia = weekday[fechaInicio];
            // console.log(dia);
            cadena += `<div class="form-check">
                <label class="form-check-label" for="check_${i}">
                    <input type="checkbox" class="form-check-input" id="check_${i}" value="${fecha.getFullYear() + "-" + agregarZero(fecha.getMonth() + 1) + "-"+ agregarZero(fecha.getDate())}" 
                    name="option1">${dia+" "+ agregarZero(fecha.getDate()) + "/" + agregarZero(fecha.getMonth() + 1) + "/"+fecha.getFullYear()}
                </label>
            </div>`;
            fechaInicio = (fechaInicio + 1) % 7;
            // fecha = addDays(fecha.getFullYear() + "-" + (fecha.getMonth() + 1) + "-" + fecha.getDate());
            // fecha.setDate(setDate(fecha.getDate() + days));
            fecha.setDate(fecha.getDate() + 1);
        }
        $("#cajaFechasSemana").html(cadena);
}


function calcularFechaReservaEditar(){
    let weekday = ["domingo","lunes","martes","miercoles","jueves","viernes","sabado"];
        let fecha = new Date($("#editFechaEntrada").val());
        fecha.setDate(fecha.getDate() + 1);
        let fechaInicio = parseInt(fecha.getDay());
        let cadena = '<p>Fechas de practica</p>';
        for (let i = 0; i < weekday.length; i++) {
            let dia = weekday[fechaInicio];
            // console.log(dia);
            cadena += `<div class="form-check">
                <label class="form-check-label" for="checkEdit_${i}">
                    <input type="checkbox" class="form-check-input" id="checkEdit_${i}" value="${fecha.getFullYear() + "-" + agregarZero(fecha.getMonth() + 1) + "-"+ agregarZero(fecha.getDate())}" 
                    name="option2">${dia+" "+ agregarZero(fecha.getDate()) + "/" + agregarZero(fecha.getMonth() + 1) + "/"+fecha.getFullYear()}
                </label>
            </div>`;
            fechaInicio = (fechaInicio + 1) % 7;
            // fecha = addDays(fecha.getFullYear() + "-" + (fecha.getMonth() + 1) + "-" + fecha.getDate());
            // fecha.setDate(setDate(fecha.getDate() + days));
            fecha.setDate(fecha.getDate() + 1);
        }
        $("#cajaEditFechasSemana").html(cadena);
}