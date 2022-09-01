let listaCursoAlumno = new Array(); 
$(document).ready(function () {
    // getListaPagosGrupo($("#selectGrupo").val());
    getlistaCursos();
    // listaAlumnos();
    $("#selectGrupo").change(function (e) { 
        e.preventDefault();
        getlistaCursos(getListaPagosGrupo($("#selectGrupo").val()));
    });

    $("#btnChangeAlumnos").click(function (e) { 
        e.preventDefault();
        listaAlumnos();
    });

    $("#listasAddGrupo").change(function (e) { 
        e.preventDefault();
        listaAlumnos();
    });

    $(".pagoAdd").change(function (e) { 
        e.preventDefault();
        let pagoDigital = $("#pagoAddDigital").val();
        let pagoEfectivo = $("#pagoAddEfectico").val();
        $("#totalPagadoInscripcion").html( parseFloat(pagoDigital)+ parseFloat(pagoEfectivo) );
    });



    $("#formAddAlumnoGrupo").submit(function (e) { 
        e.preventDefault();
        let alumno = $("#listasAddAlumno").val();
        let grupo = $("#listasAddGrupo").val();
        let pagoDigital = $("#pagoAddDigital").val();
        let pagoEfectivo = $("#pagoAddEfectico").val();
        $.ajax({
            type: "POST",
            url: "../controlador/c_pago.php",
            data: {metodo:"agregarAlumnoClase",alumno,grupo,pagoDigital,pagoEfectivo},
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
            }
        });
    });

    $("#myTable tbody").on('click','button.btnCobroAlumno',function (e) {
        e.preventDefault();
        console.log("click");
        let val = this.id;
        let datos = val.split('_');
        console.log(listaCursoAlumno);
        let datosInscripcion = listaCursoAlumno.find(e => e.id_gestion_curso == datos[1]);

        $("#fechaInscripcionGrupo").html(datosInscripcion.fecha_inscripcion);
        $("#detalleNombre").html(datosInscripcion.nombre_alumno); 
        $("#precioCursoMes").html(datosInscripcion.precio_curso);
        $("#detallePagoTotal").html(datosInscripcion.pago_gestion);
        $("#idCursoAlumno").html(datosInscripcion.id_gestion_curso);
        $.ajax({
            type: "POST",
            url: "../controlador/c_pago.php",
            data: {metodo:"listaDePagosAlumno",id:datos[1]},
            dataType: "JSON",
            success: function (response) {
                // cajaRegistroPagos
                console.log(response.data.length);
                $("#tablaPagosAlumno tbody").html('');
                if(response.data.length == 0){
                    $("#tablaPagosAlumno tbody").append("<tr class='text-center'><td colspan='4'>No existe ningun registro de pago</td></tr>");
                }else{
                    let cuerpo = '';
                    response.data.forEach(element => {
                        cuerpo += `<tr><td>${element.fecha_pago}</td><td>${element.pago_digital}</td>
                        <td>${element.pago_efectivo}</td><td>${element.total_pago}</td></tr>`;
                    });
                    $("#tablaPagosAlumno tbody").append(cuerpo);
                }
            }
        });
    });

    $("#formReservarEdit").submit(function (e) { 
        e.preventDefault();
        let pagoDigital = $("#pagoAlumnoDigital").val();
        let pagoEfectivo = $("#pagoAlumnoEfectivo").val();
        // console.log(pagoDigital+' -- '+pagoEfectivo);
        $.ajax({
            type: "POST",
            url: "../controlador/c_pago.php",
            data: {metodo:"registrarPagoCurso",pagoDigital,pagoEfectivo, id:$("#idCursoAlumno").html()},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == '1'){
                    $('#modalPagoEstudiante').modal('hide');
                    getListaPagosGrupo($("#selectGrupo").val());
                    Swal.fire('Exito!!','Se ha regitrado el pago','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    // ELIMINAR DEL GRUPO O CURSO 
    $("#myTable tbody").on('click','button.deletAlumnoGrupo',function (e) {
        e.preventDefault();
        console.log("click");
        let val = this.id;
        let datos = val.split('_');
        let datosInscripcion = listaCursoAlumno.find(e => e.id_gestion_curso == datos[1]);
        $("#delNombreAlumno").html(datosInscripcion.nombre_alumno); 
        $("#delNombreGrupo").html(datosInscripcion.nombre_curso);
        $("#idDeletGestion").html(datosInscripcion.id_gestion_curso);
        // $("#idDeletAlumno").html(datosInscripcion.id_alumno);
    });

    

    $("#formDeleteAlumnoGrupo").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../controlador/c_pago.php",
            data: {metodo:'eliminarAlumnoGrupo', id:$("#idDeletGestion").html()},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == '1'){
                    $('#modalEliminarAlumnoGrupo').modal('hide');
                    getListaPagosGrupo($("#selectGrupo").val());
                    Swal.fire('Exito!!','Se ha eliminado al alumno '+$("#delNombreAlumno").html(),'success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});

function getListaPagosGrupo(id){
    $.ajax({
        type: "POST",
        url: "../controlador/c_pago.php",
        data: {metodo:"getListaPagosGrupo",id},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            if(response.length == 0){
                let cabezera = '<th>Nombres</th><th>1º</th><th>2º</th><th>3º</th>';
                let cuerpo = '<tr><td colspan="4">No existe alumnos</td></tr>';
                $("#myTable  thead  tr").html(cabezera); 
                $("#myTable  tbody").html(cuerpo); 
            }else{
                listaCursoAlumno = response;
                drawCabecera();
                drawbody();
            }
        }
    });
}



function getlistaCursos(){
    // let id = $("#selectGrupo").val();
    $.ajax({
        type: "POST",
        url: "../controlador/c_curso.php",
        data: {metodo:"getListaCursoInscripcion"},
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            // let listaCursos =  response.data;
            // $("#selectGrupo").empty();
            $("#listasAddGrupo").empty();
            response.forEach(element => {
                $("#selectGrupo").append(`<option value='${element.id_curso}'>${element.nombre_curso}</option>`);
                $("#listasAddGrupo").append(`<option value='${element.id_curso}'>${element.nombre_curso}</option>`);
            });
            $('#selectGrupo').select2();
            // $('#listasAddGrupo').select2();
            getListaPagosGrupo($('#selectGrupo').val());
        }
    });
}

function drawCabecera(){
    let cantMeses = (parseInt(listaCursoAlumno[0].totalDias) / 30) + 1;
    // console.log(cantMeses);
    let cabecera = `<th>Nombre</th>`; 
    for (let i = 1; i <= cantMeses; i++) {
        cabecera += `<th>${i}º Mes</th>`;
    }
    cabecera += '<th>Opc.</th>'
    // console.log(cabecera);
    $("#myTable  thead  tr").html(cabecera); 
}

function drawbody(){
    let cantMeses = (parseInt(listaCursoAlumno[0].totalDias) / 30) + 1;
    let cuerpo = '<tr>';
    // let diasTotalClase = listaCursoAlumno[0].totalDias;
    let pagoCursoMes = parseFloat(listaCursoAlumno[0].precio_curso); 
    listaCursoAlumno.forEach(element => {
        let diasTotalAlumno = element.cantidad_dias_alumno;
        let pagoTotalAlumnoCurso  = parseFloat(element.pago_gestion);
        // console.log(pagoTotalAlumnoCurso+' -- '+pagoCursoMes);
        cuerpo += `<tr><td>${element.nombre_alumno}<br>${element.fecha_inscripcion}</td>`;
        let porcentaje = 0.0;
        for (let i = 0; i < cantMeses-1; i++) {
            if(pagoTotalAlumnoCurso > 0){
                let resultPago = pagoTotalAlumnoCurso - pagoCursoMes;
                if(resultPago >= 0){
                    porcentaje = 100;
                    pagoTotalAlumnoCurso = pagoTotalAlumnoCurso - pagoCursoMes;
                }else{
                    porcentaje = ((pagoCursoMes - Math.abs(resultPago)) *100 )/pagoCursoMes;
                    pagoTotalAlumnoCurso = 0;
                }
            }else{
                porcentaje = 0;
            }
            

            if(diasTotalAlumno >= 0){
                if(diasTotalAlumno >= 30){
                    cuerpo += `<td>30/30
                    <div class="progress" style="height:10px">
                        <div class="progress-bar" style="width:${porcentaje}%;height:10px"></div>
                    </div>
                    </td>`;
                }else{
                    cuerpo += `<td>${diasTotalAlumno}/30 
                    <div class="progress" style="height:10px">
                        <div class="progress-bar" style="width:${porcentaje}%;height:10px"></div>
                    </div>
                    </td>`;
                }
                diasTotalAlumno -= 30;
            }else{
                cuerpo += `<td>0/30 
                <div class="progress" style="height:10px">
                    <div class="progress-bar" style="width:${porcentaje}%;height:10px"></div>
                </div>
                </td>`;
            }
        }
        cuerpo += `<td> <button id='btnDelet_${element.id_gestion_curso}' type='button' class='deletAlumnoGrupo btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarAlumnoGrupo'><i class='fas fa-trash'></i></button>
        <button type='button' id='btnCobro_${element.id_gestion_curso}' class='btnCobroAlumno btn btn-info btn-sm' data-toggle='modal' data-target='#modalPagoEstudiante'><i class='fas fa-money-bill-wave-alt'></i></button> </td> </tr>`;
    });
    cuerpo += `</tr>`;
    $("#myTable  tbody").html(cuerpo); 
    // console.log(cuerpo);
} 

function listaAlumnos() {
    $.ajax({
        type: "POST",
        url: "../controlador/c_alumno.php",
        data: {metodo:"getListaAlumnoNoInscritos",clase:$("#selectGrupo").val()},
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            $('#listasAddAlumno').empty();
            response.data.forEach(element => {
                $("#listasAddAlumno").append(`<option value='${element.id_alumno}'>${element.nombre_alumno} - ${element.edad}</option>`);
            });
            $('#listasAddAlumno').select2();
        }
    });
}