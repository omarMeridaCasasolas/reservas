$(document).ready(function () {
    listarProductos();

    $("#buscadorSnack").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#cajaSnack div").filter(function() {
            console.log(this);
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function listarProductos(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_producto.php",
        data: {metodo:"listarSnackCliente"},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            // <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
            response.forEach(element => {
                $("#cajaSnack").append(`<div class="col-lg-4 col-md-6 mb-3 justify-content-center">
                <div class="card" style="width: 100%;">
                    <div class="card-body p-4">
                        <h6 class="my-1"><strong>Nombre:</strong> ${element.nombre_producto}</h6>
                        <h6 class="my-1"><strong>Descripcion: </strong> ${existeDescripcion(element.descripcion_producto)}</h6>
                        <h6 class="my-1"><strong>Precio:</strong> ${element.precio_venta}</h6>
                        <h6 class="my-1"><strong>Cantidad:</strong> ${element.stock_producto}</h6>
                    </div>
                </div>
            </div>`);
            });
        }
    });
}

function existeDescripcion(res){
    if(res =="" || res == null){
        return "-.-";
    }else{
        return res;
    }
}