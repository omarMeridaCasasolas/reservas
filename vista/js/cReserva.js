var tablaReserva;
var diaReserva = new Array();   //Arreglo para obtener un cierto order respecto a los dias [martes, miercoles, ..etc]
var reservasLunes = new Array();
var reservasMartes = new Array();
var reservasMiercoles = new Array();
var reservasJueves = new Array();
var reservasViernes = new Array();
var reservasSabado = new Array();
var reservasDomingo = new Array();
var semanaCompleta = new Array();

var idReserva;
var dataFormularioDeportivo;
var listaIdReserva = new Array();

let listaEventos = new Array();
$(document).ready(function () {
    calendarioReserva($("#fechaReserva").val());
    getListaClientes();
    listadeEventos();

    // PAGOS 
    $(".pagos").change(function (e) { 
        e.preventDefault();
        let pagoDigital = $("#pagoDigital").val();
        let pagoEfectivo = $("#pagoEfectivo").val();
        $("#pagoDepositado").html(parseFloat(pagoDigital)+ parseFloat(pagoEfectivo));
    });

    $(".pagosEdit").change(function (e) { 
        e.preventDefault();
        let pagoDigital = $("#pagoEditDigital").val();
        let pagoEfectivo = $("#pagoEditEfectivo").val();
        $("#pagoEditDepositado").html(parseFloat(pagoDigital)+ parseFloat(pagoEfectivo));
    });

    $("#fechaReserva").change(function (e) { 
        e.preventDefault();
        calendarioReserva($("#fechaReserva").val());
    });

    $("#cajaIntervalo .form-check-input").change(function (e) { 
        e.preventDefault();
        let intervalo = $('input[name="radioIntervalo"]:checked').val();
        if(intervalo == "60"){
            $(".cat1").hide();
        }else{
            $(".cat1").show();
        }
        // console.log(intervalo);
    });

    $("#hrLimiteReserva").change(function (e) { 
        e.preventDefault();
        if($("#tipoReserva").val() == "Juego Deportivo"){
            let idPrecio = $("#hrLimiteReserva").val();
            console.log(idPrecio);
            let datos = idPrecio.split('_');
            let precio = datos[datos.length-1];
            $("#precioCostoReserva").val(precio);
        }
    });

    $("#hrLimiteEditReserva").change(function (e) { 
        e.preventDefault();
        if($("#tipoEditReserva").val() == "Juego Deportivo"){
            let idPrecio = $("#hrLimiteEditReserva").val();
            console.log(idPrecio);
            let datos = idPrecio.split('_');
            let precio = datos[datos.length-1];
            $("#precioCostoEditReserva").val(precio);
        }
    });

    $("#tipoReserva").change(function (e) { 
        e.preventDefault();
        let tipo = $("#tipoReserva").val();
        if(tipo == "Juego Deportivo"){
            $("#cajaListaEvento").addClass('d-none');
        }else{
            $("#cajaListaEvento").removeClass('d-none');
        }
    });

    $("#myTable").on('click','button.btnDisponible',function (e) {
		e.preventDefault();
        let aux = this.id;
        let arreglo = aux.split('_');
        if(arreglo.length >= 2){
            $("#idReservaActual").html(arreglo[1]);
            $.ajax({
                type: "POST",
                url: "../controlador/c_reserva.php",
                data: {metodo:"getReserva", reserva :arreglo[1]},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    $("#idReservaActual").html(response.id_reserva);
                    $("#detalleFecha").html(response.fecha_reserva);
                    $("#detalleDia").html(response.dia_reserva);
                    $("#detalleHora").html(response.hora_reserva);
                    $("#detallePrecio").html(response.precio_hora);
                    rellenarHorario(response.dia_reserva,response.hora_reserva);
                }
            });
        }else{
            console.log("No es numero");
        }
        // let fecha = 
    });

    $("#formReservar").submit(function (e) { 
        e.preventDefault();
        let idCliente = $("#nombreCliente").val();
        let pagoDigital = $("#pagoDigital").val();
        let pagoEfectivo = $("#pagoEfectivo").val();
        let costoReserva = $("#precioCostoReserva").val();

        let reserva = $("#idReservaActual").html();
        // console.log(cliente);
        let tipoReserva = $("#tipoReserva").val();
        if(tipoReserva == "Juego Deportivo"){
            // $(selector).addClass(className);
            realizarReservaJuegoDeportivo(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva);
        }else{
            realizarReservaEvento(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva);
        }
    });

    $("#nombreEventoModelo").change(function (e) { 
        e.preventDefault();
        let id = $("#nombreEventoModelo").val();
        console.log(id);
        let evento = listaEventos.find(e => e.id_modelo_evento == id);
        $("#precioCostoReserva").val(evento.precio_aprox);
        // console.log($("#nombreEventoModelo option:selected" ).text());

    });


    // EDITAR RESEVA 
    $("#myTable").on('click','button.btnReservado',function (e) {
		e.preventDefault();
        let aux = this.id;
        let arreglo = aux.split('_');
        if(arreglo.length >= 2){
            $("#idReservaActual").html(arreglo[1]);
            $.ajax({
                type: "POST",
                url: "../controlador/c_reserva.php",
                data: {metodo:"getReservaEdit", reserva :arreglo[1]},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    $("#idEditReservaActual").html(response[0].id_reserva);
                    $("#detalleEditFecha").html(response[0].fecha_reserva);
                    $("#detalleEditDia").html(response[0].dia_reserva);
                    $("#detalleEditHora").html(response[0].hora_reserva);
                    $("#detalleEditPrecio").html(response[0].precio_hora);
                    $("#nombreEditCliente").val(response[0].id_cliente).trigger('change');
                    $("#precioCostoEditReserva").val(response[0].costo_reserva);
                    $("#pagoEditDigital").val(response[0].pago_digital);
                    $("#pagoEditEfectivo").val(response[0].pago_efectivo);
                    $("#pagoEditDepositado").html(parseFloat(response[0].pago_digital)+ parseFloat(response[0].pago_efectivo));

                    $("#idEditFechaReserva").html(response[0].identificador_reserva);

                    $("#precioCostoEditReserva").attr("placeholder", response[0].costo_reserva);
                    $("#pagoEditDigital").attr("placeholder", response[0].pago_digital);
                    $("#pagoEditEfectivo").attr("placeholder", response[0].pago_efectivo);

                    if(response[0].tipo_preserva == 'Deportivo'){
                        $("#tipoEditReserva").val("Juego Deportivo");
                    }else{
                        if(response[0].tipo_preserva == 'Evento'){
                            $("#tipoEditReserva").val("Evento");
                        }else{

                        }
                    }
                    rellenarHorarioEdit(response[0].dia_reserva,response[0].hora_reserva);
                    total = 0;
                    response.forEach(element => {
                        total += parseInt(element.precio_hora);
                    });
                    console.log("option_"+response[response.length-1].id_reserva+"_"+total);
                    $("#hrLimiteEditReserva").val("option_"+response[response.length-1].id_reserva+"_"+total);
                    
                    // rellenarHorario(response.dia_reserva,response.hora_reserva);
                }
            });
        }else{
            console.log("No es numero");
        }
        // let fecha = 
    });

    $("#btnActulizarReserva").click(function (e) { 
        e.preventDefault();
        
        let reserva = $("#idEditReservaActual").html();
        let fechaAnteriorReserva = $("#idEditFechaReserva").html();
        console.log();
        if($("#btnActulizarReserva").val() == "Actualizar"){
            let idCliente = $("#nombreEditCliente").val();
            let pagoDigital = $("#pagoEditDigital").val();
            let pagoEfectivo = $("#pagoEditEfectivo").val();
            let costoReserva = $("#precioCostoEditReserva").val();
            let tipoReserva = $("#tipoEditReserva").val();
            if(tipoReserva == "Juego Deportivo"){
                // $(selector).addClass(className);
                realizarEditReservaJuegoDeportivo(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva,fechaAnteriorReserva);
            }else{
                realizarReservaEvento(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva);
            }
        }else{
            eliminarReserva(fechaAnteriorReserva);
        }
    });

    // $("#formReservarEdit").submit(function (e) {
    //     e.preventDefault();
        // console.log("click desde submit");
        // let idCliente = $("#nombreEditCliente").val();
        // let pagoDigital = $("#pagoEditDigital").val();
        // let pagoEfectivo = $("#pagoEditEfectivo").val();
        // let costoReserva = $("#precioCostoEditReserva").val();
        // let reserva = $("#idEditReservaActual").html();
        // // console.log(cliente);
        // let tipoReserva = $("#tipoEditReserva").val();
        // if(tipoReserva == "Juego Deportivo"){
        //     // $(selector).addClass(className);
        //     realizarEditReservaJuegoDeportivo(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva);
        // }else{
        //     realizarReservaEvento(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva);
        // }
    // });

    // ACIONES (EDITAR - ELIMINAR)
    $("#switch1").change(function (e) { 
        e.preventDefault();
        if($(this).is(":checked")) {
            $("#headerEditar").removeClass('bg-warning');
            $("#headerEditar").addClass('bg-danger');
            $("#headerEditar > .modal-title").html('Eliminar reserva');
            $("#btnActulizarReserva").val("Eliminar");
            
            $("#msjEliminar").removeClass('d-none');
            
        }else{
            $("#headerEditar").removeClass('bg-danger');
            $("#headerEditar").addClass('bg-warning');
            $("#headerEditar > .modal-title").html('Actualizar reserva');
            $("#btnActulizarReserva").val("Actualizar");

            $("#msjEliminar").addClass('d-none');
        }
    });

    $("#myTable").on('click','button.btnCerrado',function (e) {
		e.preventDefault();
        let aux = this.id;
        console.log(aux);
        let arreglo = aux.split('_');
        if(arreglo.length >= 2){
            $("#idHabilitarReservaActual").html(arreglo[1]);
            $.ajax({
                type: "POST",
                url: "../controlador/c_reserva.php",
                data: {metodo:"getReserva", reserva :arreglo[1]},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    // $("#idHabilitarReservaActual").html(response.id_reserva);
                    $("#detalleHabilitarFecha").html(response.fecha_reserva);
                    $("#detalleHabilitarDia").html(response.dia_reserva);
                    $("#detalleHabilitarHora").html(response.hora_reserva);
                    $("#detalleHabilitarPrecio").html(response.precio_hora);
                }
            });
        }else{
            console.log("No es numero");
        }
    });    

    $("#formReservarHabilitar").submit(function (e) { 
        e.preventDefault();
        // console.log($("#idHabilitarReservaActual").html());
        $.ajax({
            type: "POST",
            url: "../controlador/c_reserva.php",
            data: {metodo:"habilitarReserva",reserva: $("#idHabilitarReservaActual").html()},
            success: function (response) {
                // console.log(response);
                if(response == 'true'){
                    $('#modalNoDisponble').modal('hide');
                    calendarioReserva($("#fechaReserva").val());
                    Swal.fire('Exito!!','Se ha habilitado horario para futuras reservas','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});

function getListaClientes(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_cliente.php",
        data: {metodo:"getListaClientes"},
        dataType: "JSON",
        success: function (response) {
            response.forEach(element => {
                $("#nombreCliente").append(`<option value=${element.id_cliente}>${element.nombre_cliente} `+tieneCarnet(element.ci_cliente)+`</option>`);
                $("#nombreEditCliente").append(`<option value=${element.id_cliente}>${element.nombre_cliente} `+tieneCarnet(element.ci_cliente)+`</option>`);
            });
            $('#nombreCliente').select2();
            $('#nombreEditCliente').select2();
        }
    });
}

function tieneCarnet(carnet){
    if(carnet == null || carnet ==""){
        return "";
    }else{
        return "("+carnet+")";
    }
}

function calendarioReserva(dia){
    // $("#myTable").empty();
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo:"getReservaSemana",dia},
        dataType: "JSON",
        success: function (response) {
            limpiarArreglos();
            console.log(response);
            let aux = '' 
            let ultimo = '';
            response.forEach(element => {   //Correr los dias reserva para categorizar por dia de la semana: lunes, martes, etc
                aux = element.dia_reserva;
                if(ultimo != aux){
                    ultimo = aux;
                    diaReserva.push(aux);
                }
                switch (aux) {
                    case 'lunes':
                        reservasLunes.push(element);
                        break;
                    case 'martes':
                        reservasMartes.push(element);
                        break;
                    case 'miercoles':
                        reservasMiercoles.push(element);
                        break;
                    case 'jueves':
                        reservasJueves.push(element);
                        break;
                    case 'viernes':
                        reservasViernes.push(element);
                        break;
                    case 'sabado':
                        reservasSabado.push(element);
                        break;
                    default:
                        reservasDomingo.push(element);
                        break;
                }
            });
            showCabezera();
            semanaCompleta.push(reservasLunes);
            semanaCompleta.push(reservasMartes);
            semanaCompleta.push(reservasMiercoles);
            semanaCompleta.push(reservasJueves);
            semanaCompleta.push(reservasViernes);
            semanaCompleta.push(reservasSabado);
            semanaCompleta.push(reservasDomingo);
            showBody();
        }
    });
}

function limpiarArreglos(){
    diaReserva = new Array();
    reservasLunes = new Array();
    reservasMartes = new Array();
    reservasMiercoles = new Array();
    reservasJueves = new Array();
    reservasViernes = new Array();
    reservasSabado = new Array();
    reservasDomingo = new Array();
    semanaCompleta = new Array();
}
function showCabezera(){
    $("#myTable thead tr").empty();
    cabezera = "<th>Horario</th>";
    diaReserva.forEach(element => {
        cabezera += "<th>"+element+"</th>";
    });
    $("#myTable thead tr").html(cabezera);
}

function showBody(){
    let fila = "";
    for(let i = 9; i<23; i++){
        let hora = buscarReserva(i);
        fila += `<tr>${hora}</tr>`;

        let media = buscarReservaMedia(i);
        fila += `<tr class="cat1">${media}</tr>`;
    }
    // $("#myTable tbody").empty();
    $("#myTable tbody").html(fila);
    // $(".cat1").hide();
}

function buscarReserva(tmp){
    let res ="";
    let hora = agregarZero(tmp)+":00";
    res += `<td>${hora}</td>`;
    for (let i = 0; i < diaReserva.length; i++) {
        let diaNombre = diaReserva[i];    
        for (let j = 0; j < semanaCompleta.length; j++) {   //semana completa lleva los diferentes array de Lunes, martes, miercoles
            let myArray = semanaCompleta[j];
            if(myArray[0].dia_reserva == diaNombre){
                let aux = myArray.find(e => e.hora_reserva == hora);
                if(aux.estado_reserva == "mantenimiento"){
                    res += `<td ><button type='button' class='btn btn-sm btn-info btnCerrado' data-toggle='modal' data-target='#modalNoDisponble' id='idRsv_${aux.id_reserva}'>Revision</button></td>`;
                }else{
                    if(aux.estado_reserva == "disponible"){
                        res += `<td><button type='button' class='btn btn-sm btn-success btnDisponible' data-toggle='modal' data-target='#modalDisponble' id='idRsv_${aux.id_reserva}'>Disponible</button></td>`;
                    }else{
                        res += `<td><button type='button' class='btn btn-sm btn-warning btnReservado' id='idRsv_${aux.id_reserva}' data-toggle='modal' data-target='#modalReservado'>Reservado</button></td>`;
                    }
                }
            }
            
        }
    }
    return res;
}


function buscarReservaMedia(tmp){
    let res ="";
    let hora = agregarZero(tmp)+":30";
    res += `<td>${hora}</td>`;
    for (let i = 0; i < diaReserva.length; i++) {
        let diaNombre = diaReserva[i];      //lunes
        for (let j = 0; j < semanaCompleta.length; j++) {
            let myArray = semanaCompleta[j];
            if(myArray[0].dia_reserva == diaNombre){
                let aux = myArray.find(e => e.hora_reserva == hora);
                if(aux.estado_reserva == "mantenimiento"){
                    res += `<td><button type='button' class='btn btn-sm btn-info btnCerrado' data-toggle='modal' data-target='#modalNoDisponble' id='idRsv_${aux.id_reserva}'>Revision</button></td>`;
                }else{
                    if(aux.estado_reserva == "disponible"){
                        res += `<td><button type='button' class='btn btn-sm btn-success btnDisponible' data-toggle='modal' data-target='#modalDisponble' id='idRsv_${aux.id_reserva}'>Disponible</button></td>`;
                    }else{
                        res += `<td><button type='button' class='btn btn-sm btn-warning btnReservado' id='idRsv_${aux.id_reserva}' data-toggle='modal' data-target='#modalReservado'>Reservado</button></td>`;
                    }
                }
            }
            
        }
    }
    return res;
}

function crearFormularioJuegoDeportivo(){
    let id = $("#idReservaActual").html();
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo:"getHorarioContinuo",id},
        dataType: "JSON",
        success: function (response) {
            let opciones= '';
            let minimoHora = true;
            let valor = 0;
            for (let i = 0; i < response.length; i++) {
                let element = response[i];
                if(element.estado_reserva == 'disponible'){
                    aux = element.hora_reserva;
                    limiteReserva = aux.split(':');
                    console.log(limiteReserva);
                    if(limiteReserva[1] == '00'){
                        if(minimoHora){
                            valor += Number.parseInt(element.precio_hora);
                            i +=1;
                            opciones += `<option value='${response[i].id_reserva}'>${limiteReserva[0]+":59"}</option>`;
                            minimoHora = false;
                        }else{
                            opciones += `<option value='${response[i].id_reserva}'>${limiteReserva[0]+":29"}</option>`;
                        }
                        valor += Number.parseInt(response[i].precio_hora);
                    }else{
                        if(minimoHora){
                            valor += Number.parseInt(element.precio_hora);
                            i +=1;
                            opciones += `<option value='${response[i].id_reserva}'>${(parseInt(limiteReserva[0])+1)+":29"}</option>`;
                            minimoHora = false;
                        }else{
                            opciones += `<option value='${response[i].id_reserva}'>${limiteReserva[0]+":59"}</option>`;
                        }
                        valor += Number.parseInt(response[i].precio_hora);
                    }
                }else{
                    break;
                }
            }
            $("#hrLimiteReserva").append(opciones);
        }
    });
}


function buscarElemento(arrayActual, horaReserva){
    for (let i = 0; i < arrayActual.length; i++) {
        let element = arrayActual[i];
        if(element.hora_reserva == horaReserva){
            return element;
        }
    }
}

function agregarZero(a){
    if(a<=9){
        return "0"+a;
    }
    return a;
}

function listadeEventos(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_modelo_evento.php",
        data: {metodo:"getListaModeloEventos"},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            listaEventos = response.data;
            listaEventos.forEach(element => {
                $("#nombreEventoModelo").append(`<option value="${element.id_modelo_evento}">${element.nombre_modelo_evento} - ${element.precio_aprox}</option>`);
            });
            $('#nombreEventoModelo').select2();
        }
    });
}

function rellenarHorario(nombreDia, horaDia){
    $("#hrLimiteReserva").empty();
    let bandera = true;
    let addOpciones = '';
    let precioTotal = 0;
    for (let index = 0; index < semanaCompleta.length && bandera; index++) {
        let arraySemana = semanaCompleta[index];
        if(arraySemana[0].dia_reserva == nombreDia){
            for (let i = 0; i < arraySemana.length && bandera; i++) {
                let dia = arraySemana[i];
                // console.log(dia);
                if(dia.hora_reserva == horaDia ){
                    let tiempo = 30;
                    for (let j = i; j < arraySemana.length && bandera; j++) {
                        let element = arraySemana[j];
                        // console.log(element);
                        if(element.estado_reserva == 'disponible'){
                            precioTotal += parseInt(element.precio_hora);
                            if( j != i){
                                addOpciones +=`<option value="option_${element.id_reserva}_${precioTotal}">${element.hora_limite} -Tiempo ${ minutosAHoras(tiempo)}</option>`
                            }
                            tiempo += 30;
                        }else{
                            bandera = false;
                        }
                    }
                }
            }
        }
    }
    $("#hrLimiteReserva").append(addOpciones);
    let cantOpciones  = $('#hrLimiteReserva option').length;
    if(cantOpciones == 0){
        $('#mensajeReserva30min').removeClass('d-none');
        $("#formReservar").addClass('d-none');
    }else{
        $('#mensajeReserva30min').addClass('d-none');
        $('#formReservar').removeClass('d-none');
    }
}


function rellenarHorarioEdit(nombreDia, horaDia){
    // console.log(nombreDia+"<--->"+horaDia);
    $("#hrLimiteEditReserva").empty();
    let bandera = true;
    let addOpciones = '';
    let precioTotal = 0;
    for (let index = 0; index < semanaCompleta.length && bandera; index++) {
        let arraySemana = semanaCompleta[index];
        if(arraySemana[0].dia_reserva == nombreDia){
            for (let i = 0; i < arraySemana.length && bandera; i++) {
                let dia = arraySemana[i];
                // console.log(dia);
                if(dia.hora_reserva == horaDia ){
                    let tiempo = 30;
                    for (let j = i; j < arraySemana.length && bandera; j++) {
                        let element = arraySemana[j];
                        // console.log(element);
                        let aux1 = 'reservado';
                        if(element.estado_reserva == aux1 || element.estado_reserva == 'disponible'){
                            if(element.estado_reserva == 'disponible'){
                                aux1 = 'disponible';
                            }
                            precioTotal += parseInt(element.precio_hora);
                            if( j != i){
                                addOpciones +=`<option value="option_${element.id_reserva}_${precioTotal}">${element.hora_limite} -Tiempo ${ minutosAHoras(tiempo)}</option>`
                            }
                            tiempo += 30;
                        }else{
                            bandera = false;
                        }
                    }
                }
            }
        }
    }
    $("#hrLimiteEditReserva").append(addOpciones);
    let cantOpciones  = $('#hrLimiteEditReserva option').length;
    if(cantOpciones == 0){
        $('#mensajeReserva30min').removeClass('d-none');
        $("#formReservar").addClass('d-none');
    }else{
        $('#mensajeReserva30min').addClass('d-none');
        $('#formReservar').removeClass('d-none');
    }
}

function minutosAHoras(totalMinutes) {
    let minutes = totalMinutes % 60;
    let hours = Math.floor(totalMinutes / 60);
  
    return `${padTo2Digits(hours)}:${padTo2Digits(minutes)}`;
}
  
function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
}


function realizarReservaJuegoDeportivo(idCliente,costoReserva,pagoDigital,pagoEfectivo,reservaInicio){
    let tmp = $("#hrLimiteReserva").val();
    datos = tmp.split('_');
    console.log(datos[1]);
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo: "reservaPorJuegoDeportivo",idCliente,costoReserva,pagoDigital,pagoEfectivo,reservaInicio,reservaFinal: datos[1]},
        // dataType: "JSON",
        success: function (response) {
            // console.log(response);
            if(response == 'true'){
                $('#modalDisponble').modal('hide');
                calendarioReserva($("#fechaReserva").val());
                Swal.fire('Exito!!','Se ha reservado la cancha','success');
            }else{
                Swal.fire('Error!!',response,'error');
            }
        }
    });
}

function realizarReservaEvento(idCliente,costoReserva,pagoDigital,pagoEfectivo,reserva){
    
}

function realizarEditReservaJuegoDeportivo(idCliente,costoReserva,pagoDigital,pagoEfectivo,reservaInicio,fechaAnteriorReserva){
    console.log("hola");
    let tmp = $("#hrLimiteEditReserva").val();
    datos = tmp.split('_');
    console.log(datos[1]);
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo: "reservaPorJuegoDeportivoEdit",idCliente,costoReserva,pagoDigital,pagoEfectivo,reservaInicio,reservaFinal: datos[1],fechaAnteriorReserva},
        // dataType: "JSON",
        success: function (response) {
            console.log(response);
            if(response == 'true'){
                $('#modalReservado').modal('hide');
                calendarioReserva($("#fechaReserva").val());
                Swal.fire('Exito!!','Se ha actualizado la reserva','success');
            }else{
                Swal.fire('Error!!',response,'error');
            }
        }
    });
}

function eliminarReserva(fechaAnteriorReserva){
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo:"eliminarReserva",fechaAnteriorReserva},
        // dataType: "dataType",
        success: function (response) {
            console.log(response);
            if(response == 'true'){
                $('#modalReservado').modal('hide');
                calendarioReserva($("#fechaReserva").val());
                Swal.fire('Exito!!','Se ha eliminado la reserva','success');
            }else{
                Swal.fire('Error!!',response,'error');
            }
        }
    });
}