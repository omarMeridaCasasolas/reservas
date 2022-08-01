var ctx;
$(document).ready(function () {
    ctx = document.getElementById('myChart').getContext('2d');
    construirGrafica();
    $("#btnSolicitarReporte").click(function (e) { 
        e.preventDefault();
        console.log("Se esta haciendo click");
        let porReserva = $('#checkReserva').is(':checked');
        let porVenta =  $('#checkVenta').is(':checked');
        console.log(porReserva);
        console.log(porVenta);
        let fechaInicio = $("#fechaInicioReporte").val();
        let fechaFin = $("#fechaFinalReporte").val();
        if(porReserva){
            $("#cajaReserva").removeClass('d-none');
            obtenerReporteReserva(fechaInicio,fechaFin);
        }else{
            $("#cajaReserva").addClass('d-none');
        }
        if(porVenta){
            $("#cajaVenta").removeClass('d-none');
            obtenerReporteVenta(fechaInicio,fechaFin);
        }else{
            $("#cajaVenta").addClass('d-none');
        }
    });
});

function obtenerReporteReserva(fechaInicio,fechaFin){
    $("#tablaReserva tbody").empty();
    $.ajax({
        type: "POST",
        url: "../controlador/c_reserva.php",
        data: {metodo:"obtenerReservasGeneradas", fechaFin, fechaInicio},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            // $(selector).append(content);
            let res = "";
            let totalReserva = 0;
            for (let i = 0; i < response.length; i++) {
                let element = response[i];
                res += `<tr><td>${element.nombre_cliente}</td><td>${element.total_hora}</td><td>${element.total}</td></tr>`;
                totalReserva += Number.parseFloat(element.total);
            }
            $("#tablaReserva tbody").append(res);
            $("#totalReserva").html(totalReserva+" Bs");
        }
    });
}

function obtenerReporteVenta(fechaInicio,fechaFin){
    $("#tablaVentas tbody").empty();
    $.ajax({
        type: "POST",
        url: "../controlador/c_ventas.php",
        data: {metodo:"obtenerVentasGeneradas", fechaFin, fechaInicio},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            let res = "";
            let totalReserva = 0;
            for (let i = 0; i < response.length; i++) {
                let element = response[i];
                res += `<tr><td>${element.nombre_producto}</td><td>${element.cant_vendida}</td><td>${element.total}</td></tr>`;
                totalReserva += Number.parseFloat(element.total);
            }
            $("#tablaVentas tbody").append(res);
            $("#totalVentas").html(totalReserva+" Bs");
        }
    });
}


function construirGrafica(){
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}