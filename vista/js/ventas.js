var tablaDeProductos, listaPermanenteItem , tablaVenta;
var listaDeProductosPedido = new Array();
$(document).ready(function () {
    getlistaVentas();
    getlistaTiendasPedido();
    obtenerTablaProductos();

    $("#tablaDeProductos tbody").on('click','button.addProductoPedido',function () {
        let dataProducto = tablaDeProductos.row( $(this).parents('tr') ).data();
        tablaDeProductos.row( $(this).parents('tr') ).remove().draw();
        $("#contenedorInput").append("<div class='row my-1 no-gutters filaItem' id='fila_"+dataProducto.id_producto+"'>"+
                                        "<span id='preciosProducto"+dataProducto.id_producto+"' class='d-none'>"+JSON.stringify(dataProducto)+"</span>"+
                                        "<div class='col-4'>"+dataProducto.nombre_producto+" "+tieneDescripcion(dataProducto.descripcion_producto)+"</div>"+
                                        "<div class='col-2'><input type='number' value='1'  required step='1' max='"+dataProducto.stock_producto+"' name='IdCant_"+dataProducto.id_producto+"' id='IdCant_"+dataProducto.id_producto+"' class='form-control cantProductoSolicitado p-1' style='width:100%;'></div>"+
                                        "<div class='col-2 text-center' style='font-size:16px;'><span id='precioUnidad_"+dataProducto.id_producto+"'>"+dataProducto.precio_venta+"</span><span> Bs</span></div>"+
                                        "<div class='col-2'><input type='text' required value='"+dataProducto.precio_venta+"' name='subTotalProducto_"+dataProducto.id_producto+"' id='subTotalProducto_"+dataProducto.id_producto+"' class='form-control actualSubtotal p-1 text-center' disabled style='width:100%;'></div>"+
                                        "<div class='col-2 text-center'><button type='button' class='btnDeletePedido btn btn-sm btn-danger' id='btnID_"+dataProducto.id_producto+"'><i class='far fa-window-close'></i></button></div>"+
                                    "</div>");
        listaDeProductosPedido.push(dataProducto);
        calcularTotalAcumalado();
    });

    $('#contenedorInput').on('click','button.btnDeletePedido ', function(e) {
        e.preventDefault();
        console.log(this.id);
        // console.log(listaDeProductosPedido);
        let parm = this.id.split('_');
        buscarProductoAddTabla(parm[1]);
        calcularTotalAcumalado();
    });

    $('#contenedorInput').on('change','input.cantProductoSolicitado', function(e) {
        let param = this.id.split('_');
        let idProd = param[1];
        let precioTmp = $("#"+this.id).val();
        if(precioTmp.match(/^[0-9]+$/)){
            console.log('es un numero');
            $("#"+this.id).css('color','#000');
            calcularPrecioProducto(precioTmp,idProd);
            calcularTotalAcumalado();
        }else{
            $("#"+this.id).css('color','#F00');
            $('#subTotalProducto_'+idProd).val("Error");
            $("#IdTotalPedido").val("Error");
        }
    });

});

function obtenerTablaProductos(){
    $('#tablaDeProductos').dataTable().fnDestroy();
    tablaDeProductos = $("#tablaDeProductos").DataTable({
        responsive: true,
        ajax:{
            method: "POST",
			url: "../controlador/c_producto.php",
			data: { metodo: "getlistaProductos"},
            dataSrc: function ( json ) {
                //Make your callback here.
                // alert("Done!");
                // console.log(json.data);
                // listaPermanenteItem = {};
                listaPermanenteItem = json.data;
                return json.data;
            }   
        },
        columns:[
            {data: "nombre_producto", width: "35%" },
            {data: "descripcion_producto", width: "30%" },
            {data: "precio_venta", width: "10%" },
            {data: "stock_producto", width: "15%" },
            {data: null,
                defaultContent:
                  "<button type='button' class='addProductoPedido btn btn-warning btn-sm'><i class='fas fa-shopping-cart'></i></button>",
                width: "10%" 
            }
        ]
    });

    // REALIZAR UNA VENTA 
    $("#formAddVenta").submit(function (e) { 
        e.preventDefault();
        // $(".actualSubtotal").removeAttr("");
        $('.actualSubtotal').prop("disabled", false);
        $('#IdTotalPedido').prop("disabled", false);
        let formData = new FormData($(this)[0]);
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
        $('.actualSubtotal').prop("disabled", true);
        $('#IdTotalPedido').prop("disabled", true);
        $.ajax({
            url: "../controlador/c_crearVenta.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                // console.log(data);
                if(data == "1"){
                    tablaVenta.ajax.reload();
                    tablaDeProductos.ajax.reload();
					// $('#formAddCurso')[0].reset();
                    Swal.fire('Exito!!','Se ha registrado la venta','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
}

function getlistaTiendasPedido(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_cliente.php",
        data: {metodo:'getListaClientes'},
        dataType: "JSON",
        success: function (response) {
            // let listaClientes = JSON.parse(response);
            // $("#addClientaVenta").empty();
            // $("#editPedidoTienda").empty();
            // $("#addClientaVenta").append("<option value=''>Ninguno</option>");
            // $("#editPedidoTienda").append("<option value=''>Ninguno</option>");
            response.forEach(element => {
                $("#addClientaVenta").append("<option value='"+element.id_cliente+"'>"+element.nombre_cliente+" - "+element.ci_cliente+"</option>");
                // $("#editPedidoTienda").append("<option value='"+element.id_cliente+"'>"+element.nombre_cliente+" - "+element.ci_cliente+"</option>");
            });
            $('#addClientaVenta').select2();
            // $('#editPedidoTienda').select2();
        }
    });
}

function calcularTotalAcumalado(){
    let totalFinal = 0;
    $(".actualSubtotal").each(function() {
        totalFinal +=  parseFloat($(this).val());
    });
    $("#IdTotalPedido").val(totalFinal.toFixed(2));
}

function tieneDescripcion(cadena){
    if(cadena === null || cadena == ""){
        return "";
    }else{
        return `(${cadena})`;
    }
}

function buscarProductoAddTabla(id){
    let i = 0;
    while (i<listaDeProductosPedido.length) {
        if(listaDeProductosPedido[i].id_producto == id){
            tablaDeProductos.row.add(listaDeProductosPedido[i]).draw();
            listaDeProductosPedido.splice(i,1);
            $("#fila_"+id).remove();
            break;
        }
        i++;
    }
}

function calcularPrecioProducto(cantidad,idProducto){
    let tmp = $('#preciosProducto'+idProducto).html();
    let objetoTmp  = JSON.parse(tmp);
    let subtotal = cantidad*objetoTmp.precio_venta;
    $('#subTotalProducto_'+idProducto).val(subtotal.toFixed(2));
}


function getlistaVentas(){
	$('#tablaVenta').dataTable().fnDestroy();
	tablaVenta = $("#tablaVenta").DataTable({
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
			url: "../controlador/c_ventas.php",
			data: { metodo: "getlistaVentas"},
		},
		columns: [
			{ data: "id_ventas", width: "5%" },
			{ data: "fecha_venta", width: "15%" },
            { data: "nombre_cliente", width: "20%" },
			{ data: "nombre_empleado", width: "20%" },
            { data: "total_venta", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProducto btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='estadoEmpleado btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
				width: "10%"
			}
		]
	});
}