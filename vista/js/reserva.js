// var tablaReserva;
// var diaReserva = new Array();
// var reservasLunes = new Array();
// var reservasMartes = new Array();
// var reservasMiercoles = new Array();
// var reservasJueves = new Array();
// var reservasViernes = new Array();
// var reservasSabado = new Array();
// var reservasDomingo = new Array();
// var semanaCompleta = new Array();

// $(document).ready(function () {
//     calendarioReserva($("#fechaReserva").val());

//     $("#fechaReserva").change(function (e) { 
//         e.preventDefault();
//         console.log("Se esta cambiando el dia");
//         calendarioReserva($("#fechaReserva").val());
//     });

//     $("#myTable").on('click','button.btnCerrado',function (e) {
// 		e.preventDefault();
//         console.log("Se ha hecho click en cerrado");
//     });
// });

// function calendarioReserva(dia){
//     // $("#myTable").empty();
//     $.ajax({
//         type: "POST",
//         url: "../controlador/c_reserva.php",
//         data: {metodo:"getReservaSemana",dia},
//         dataType: "JSON",
//         success: function (response) {
//             limpiarArreglos();
//             console.log(response);
//             let aux, ultimo;
//             response.forEach(element => {
//                 aux = element.dia_reserva;
//                 if(ultimo != aux){
//                     ultimo = aux;
//                     diaReserva.push(aux);
//                 }
//                 switch (aux) {
//                     case 'lunes':
//                         reservasLunes.push(element);
//                         break;
//                     case 'martes':
//                         reservasMartes.push(element);
//                         break;
//                     case 'miercoles':
//                         reservasMiercoles.push(element);
//                         break;
//                     case 'jueves':
//                         reservasJueves.push(element);
//                         break;
//                     case 'viernes':
//                         reservasViernes.push(element);
//                         break;
//                     case 'sabado':
//                         reservasSabado.push(element);
//                         break;
//                     default:
//                         reservasDomingo.push(element);
//                         break;
//                 }
//             });
//             showCabezera();
//             semanaCompleta.push(reservasLunes);
//             semanaCompleta.push(reservasMartes);
//             semanaCompleta.push(reservasMiercoles);
//             semanaCompleta.push(reservasJueves);
//             semanaCompleta.push(reservasViernes);
//             semanaCompleta.push(reservasSabado);
//             semanaCompleta.push(reservasDomingo);
//             showBody();
//         }
//     });
// }

// function limpiarArreglos(){
//     diaReserva = new Array();
//     reservasLunes = new Array();
//     reservasMartes = new Array();
//     reservasMiercoles = new Array();
//     reservasJueves = new Array();
//     reservasViernes = new Array();
//     reservasSabado = new Array();
//     reservasDomingo = new Array();
//     semanaCompleta = new Array();
// }
// function showCabezera(){
//     $("#myTable thead tr").empty();
//     cabezera = "<th>Horario</th>";
//     diaReserva.forEach(element => {
//         cabezera += "<th>"+element+"</th>";
//     });
//     $("#myTable thead tr").html(cabezera);
// }

// function showBody(){
//     let fila = "";
//     for(let i = 9; i<23; i++){
//         let res = buscarReserva(i);
//         fila += `<tr>${res}</tr>`;
//     }
//     $("#myTable tbody").empty();
//     $("#myTable tbody").html(fila);
// }

// function buscarReserva(tmp){
//     let res ="";
//     let hora = tmp+":00";
//     res += `<td>${hora}</td>`;
//     for (let i = 0; i < diaReserva.length; i++) {
//         let diaNombre = diaReserva[i];      //lunes
//         for (let j = 0; j < semanaCompleta.length; j++) {
//             let myArray = semanaCompleta[j];
//             if(myArray[0].dia_reserva == diaNombre){
//                 let aux = myArray.find(e => e.hora_reserva == hora);
//                 if(aux == undefined){
//                     res += `<td><button type='button' class='btn btn-sm btn-danger btnCerrado' data-toggle='modal' data-target='#modalNoDisponble'>Cerrado</button></td>`;
//                 }else{
//                     if(aux.id_cliente == null){
//                         res += `<td><button type='button' class='btn btn-sm btn-success btnDisponible' data-toggle='modal' data-target='#modalDisponble' id='idRsv_${aux.id_reserva}'>Disponible</button></td>`;
//                     }else{
//                         res += `<td><button type='button' class='btn btn-sm btn-warning btnReservado' id='idRsv_${aux.id_reserva}'>Reservado</button></td>`;
//                     }
//                 }
//             }
            
//         }
//     }
//     return res;
// }
$(document).ready(function () {
    calendarioReserva($("#fechaReserva").val());

    $("#fechaReserva").change(function (e) { 
        e.preventDefault();
        calendarioReserva($("#fechaReserva").val());
    });
});

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

function minutosAHoras(totalMinutes) {
    let minutes = totalMinutes % 60;
    let hours = Math.floor(totalMinutes / 60);
  
    return `${padTo2Digits(hours)}:${padTo2Digits(minutes)}`;
}
  
function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
}


function agregarZero(a){
    if(a<=9){
        return "0"+a;
    }
    return a;
}