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

    // convertirHoraToNumber();

    $("#fechaReserva").change(function (e) { 
        e.preventDefault();
        console.log("Se esta cambiando el dia");
        calendarioReserva($("#fechaReserva").val());
    });
    
    $("#myTable").on('click','button.btnCerrado',function (e) {
		e.preventDefault();
        console.log("Se ha hecho click en cerrado");
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
        let idPrecio = $("#hrLimiteReserva").val();
        console.log(idPrecio);
        let datos = idPrecio.split('_');
        let precio = datos[datos.length-1];
        $("#precioCostoReserva").val(precio);
    });

    $("#tipoReserva").change(function (e) { 
        e.preventDefault();
        let tipo = $("#tipoReserva").val();
        console.log(tipo);
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
        // $.ajax({
        //     type: "POST",
        //     url: "../controlador/c_reserva.php",
        //     data: {metodo:"agregarReserva",cliente,reserva},
        //     dataType: "JSON",
        //     success: function (response) {
        //         console.log(response);
        //         if(response == "1"){
        //             $("#idRsv_"+reserva).removeClass("btn-success");
        //             $("#idRsv_"+reserva).removeClass("btnDisponible");
        //             $("#idRsv_"+reserva).addClass("btn-warning");
        //             $("#idRsv_"+reserva).addClass("btnReservado");
        //             $("#idRsv_"+reserva).html("Reservado");
        //         }
        //         $('#modalDisponble').modal('hide');
        //     }
        // });
    });
});

function getListaClientes(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_cliente.php",
        data: {metodo:"getListaClientes"},
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            response.forEach(element => {
                $("#nombreCliente").append(`<option value=${element.id_cliente}>${element.nombre_cliente} `+tieneCarnet(element.ci_cliente)+`</option>`);
            });
            $('#nombreCliente').select2();
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
    $("#myTable tbody").empty();
    $("#myTable tbody").html(fila);
    $(".cat1").hide();
}

function buscarReserva(tmp){
    let res ="";
    let hora = agregarZero(tmp)+":00";
    res += `<td>${hora}</td>`;
    for (let i = 0; i < diaReserva.length; i++) {
        let diaNombre = diaReserva[i];    
        for (let j = 0; j < semanaCompleta.length; j++) {   //semana completa lleva los diferentes array de Lunes, martes, miercoles
            let myArray = semanaCompleta[j];
            // console.log(myArray);
            if(myArray[0].dia_reserva == diaNombre){
                // console.log()
                let aux = myArray.find(e => e.hora_reserva == hora);
                if(aux.estado_reserva == "mantenimiento"){
                    res += `<td><button type='button' class='btn btn-sm btn-info btnCerrado' data-toggle='modal' data-target='#modalNoDisponble'>Revision</button></td>`;
                }else{
                    if(aux.estado_reserva == "disponible"){
                        res += `<td><button type='button' class='btn btn-sm btn-success btnDisponible' data-toggle='modal' data-target='#modalDisponble' id='idRsv_${aux.id_reserva}'>Disponible</button></td>`;
                    }else{
                        res += `<td><button type='button' class='btn btn-sm btn-warning btnReservado' id='idRsv_${aux.id_reserva}'>Reservado</button></td>`;
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
                    res += `<td><button type='button' class='btn btn-sm btn-info btnCerrado' data-toggle='modal' data-target='#modalNoDisponble'>Revision</button></td>`;
                }else{
                    if(aux.estado_reserva == "disponible"){
                        res += `<td><button type='button' class='btn btn-sm btn-success btnDisponible' data-toggle='modal' data-target='#modalDisponble' id='idRsv_${aux.id_reserva}'>Disponible</button></td>`;
                    }else{
                        res += `<td><button type='button' class='btn btn-sm btn-warning btnReservado' id='idRsv_${aux.id_reserva}'>Reservado</button></td>`;
                    }
                }
            }
            
        }
    }
    return res;
}

function crearFormularioJuegoDeportivo(){
    console.log(dataFormularioDeportivo);
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
        // console.log(element.hora_reserva+"<---->"+horaReserva);
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
            let listaEventos = response.data;
            listaEventos.forEach(element => {
                $("#nombreEventoModelo").append(`<option value="${element.id_modelo_evento}">${element.nombre_modelo_evento} - ${element.precio_aprox}</option>`);
            });
            $('#nombreEventoModelo').select2();
        }
    });
}

function rellenarHorario(nombreDia, horaDia){
    // console.log(nombreDia+"<--->"+horaDia);
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
                        }
                    }
                }
            }
        }
    }
    // console.log(addOpciones);
    $("#hrLimiteReserva").append(addOpciones);
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
            console.log(response);
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