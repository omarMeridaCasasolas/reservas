var tablaReserva;
var diaReserva = new Array();
var reservasLunes = new Array();
var reservasMartes = new Array();
var reservasMiercoles = new Array();
var reservasJueves = new Array();
var reservasViernes = new Array();
var reservasSabado = new Array();
var reservasDomingo = new Array();
var semanaCompleta = new Array();

var idReserva;
$(document).ready(function () {
    calendarioReserva($("#fechaReserva").val());
    getListaClientes();

    $("#fechaReserva").change(function (e) { 
        e.preventDefault();
        console.log("Se esta cambiando el dia");
        calendarioReserva($("#fechaReserva").val());
    });
    
    $("#myTable").on('click','button.btnCerrado',function (e) {
		e.preventDefault();
        console.log("Se ha hecho click en cerrado");
    });

    $("#myTable").on('click','button.btnDisponible',function (e) {
		e.preventDefault();
        console.log(this.id);
        let aux = this.id;
        let arreglo = aux.split('_');
        if(arreglo.length >= 2){
            $.ajax({
                type: "POST",
                url: "../controlador/c_reserva.php",
                data: {metodo:"getReserva", reserva :arreglo[1]},
                dataType: "JSON",
                success: function (response) {
                    // console.log(typeof(response));
                    $("#idReservaActual").html(response.id_reserva);
                    $("#detalleFecha").html(response.fecha_reserva);
                    $("#detalleDia").html(response.dia_reserva);
                    $("#detalleHora").html(response.hora_reserva);
                    $("#detallePrecio").html(response.precio_hora);
                }
            });
        }else{
            console.log("No es numero");
        }
    });

    $("#formReservar").submit(function (e) { 
        e.preventDefault();
        let cliente = $("#nombreCliente").val();
        let reserva = $("#idReservaActual").html();
        // console.log(cliente);
        $.ajax({
            type: "POST",
            url: "../controlador/c_reserva.php",
            data: {metodo:"agregarReserva",cliente,reserva},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    $("#idRsv_"+reserva).removeClass("btn-success");
                    $("#idRsv_"+reserva).removeClass("btnDisponible");
                    $("#idRsv_"+reserva).addClass("btn-warning");
                    $("#idRsv_"+reserva).addClass("btnReservado");
                    $("#idRsv_"+reserva).html("Reservado");
                }
                $('#modalDisponble').modal('hide');
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
            console.log(response);
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
            let aux, ultimo;
            response.forEach(element => {
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
        let res = buscarReserva(i);
        fila += `<tr>${res}</tr>`;
    }
    $("#myTable tbody").empty();
    $("#myTable tbody").html(fila);
}

function buscarReserva(tmp){
    let res ="";
    let hora = tmp+":00";
    res += `<td>${hora}</td>`;
    for (let i = 0; i < diaReserva.length; i++) {
        let diaNombre = diaReserva[i];      //lunes
        for (let j = 0; j < semanaCompleta.length; j++) {
            let myArray = semanaCompleta[j];
            if(myArray[0].dia_reserva == diaNombre){
                let aux = myArray.find(e => e.hora_reserva == hora);
                if(aux == undefined){
                    res += `<td><button type='button' class='btn btn-sm btn-info btnCerrado' data-toggle='modal' data-target='#modalNoDisponble'>En revision</button></td>`;
                }else{
                    if(aux.id_cliente == null){
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

