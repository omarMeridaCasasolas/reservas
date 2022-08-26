var tablaDeProductos, listaPermanenteItem , tablaCompra;
var listaDeProductosPedido = new Array();
$(document).ready(function () {
    getlistaVentas();
    getListaProveedores();
    obtenerTablaProductos();

    $("#tablaDeProductos tbody").on('click','button.addProductoPedido',function () {
        let dataProducto = tablaDeProductos.row( $(this).parents('tr') ).data();
        tablaDeProductos.row( $(this).parents('tr') ).remove().draw();
        $("#contenedorInput").append("<div class='row no-gutters my-1 filaItem p-1' id='fila_"+dataProducto.id_producto+"'>"+
                                        "<span id='preciosProducto"+dataProducto.id_producto+"' class='d-none'>"+JSON.stringify(dataProducto)+"</span>"+
                                        "<div class='col-4'>"+dataProducto.nombre_producto+" "+tieneDescripcion(dataProducto.descripcion_producto)+"</div>"+
                                        "<div class='col-2'><input type='text' value='1' name='IdCant_"+dataProducto.id_producto+"' id='IdCant_"+dataProducto.id_producto+"' class='form-control cantProductoSolicitado p-1' style='width:100%;'></div>"+
                                        "<div class='col-2'><input type='number' value='1.00' min='0.0' step='0.01' name='IdPrecio_"+dataProducto.id_producto+"' id='IdPrecio_"+dataProducto.id_producto+"' class='form-control precioCompraProducto p-1' style='width:100%;'></div>"+
                                        "<div class='col-2 text-center' style='font-size:16px;'><span id='precioUnidad_"+dataProducto.id_producto+"'>1</span><span> Bs</span></div>"+
                                        "<div class='col-2 text-center'><button type='button' class='btnDeletePedido btn btn-sm btn-danger' id='btnID_"+dataProducto.id_producto+"'><i class='far fa-window-close'></i></button></div>"+
                                    "</div>");
        listaDeProductosPedido.push(dataProducto);
        calcularTotalAcumalado();
    });

    $('#contenedorInput').on('keyup','input.precioCompraProducto', function(e) {
        e.preventDefault();
        let precioCompra = parseFloat($(this).val());
        let param = this.id.split('_');
        let idProd = param[1];
        let precioTmp = $("#"+this.id).val();
        if(precioTmp.match(/^[0-9.]+$/)){
            $("#"+this.id).css('color','#000');
            let totalCompraProducto =  precioCompra / parseInt($("#IdCant_"+idProd).val());
            $("#precioUnidad_"+idProd).html(totalCompraProducto.toFixed(2));
            calcularTotalAcumalado();
        }else{
            $("#"+this.id).css('color','#F00');
            $('#subTotalProducto_'+idProd).val("Error");
            $("#IdTotalPedido").val("Error");
        }
    });

    $('#contenedorInput').on('keyup','input.cantProductoSolicitado', function(e) {
        e.preventDefault();
        let cantidad = parseInt($(this).val());
        let param = this.id.split('_');
        let idProd = param[1];
        let precioTmp = $("#"+this.id).val();
        if(precioTmp.match(/^[0-9]+$/)){
            $("#"+this.id).css('color','#000');
            let totalCompraProducto =  parseFloat( $("#IdPrecio_"+idProd).val() ) / cantidad ;
            $("#precioUnidad_"+idProd).html(totalCompraProducto.toFixed(2));
            calcularTotalAcumalado();
        }else{
            $("#"+this.id).css('color','#F00');
            $('#subTotalProducto_'+idProd).val("Error");
            $("#IdTotalPedido").val("Error");
        }
    });

    $('#contenedorInput').on('click','button.btnDeletePedido ', function(e) {
        e.preventDefault();
        console.log(this.id);
        // console.log(listaDeProductosPedido);
        let parm = this.id.split('_');
        buscarProductoAddTabla(parm[1]);
        calcularTotalAcumalado();
    });


    $(document).on('click','button.addProveedorNuevo', function() {
        // e.preventDefault();
        let proveedor = $(".select2-search__field").val();
        console.log(proveedor);
        let arreglo = proveedor.split('-');
        // let numCad = arreglo.length;
        let nombre = arreglo[0];
        if(arreglo.length == 2){
            let numero = arreglo[1];
            agregarRapidoProveedor(nombre,numero);
        }else{
            agregarRapidoProveedorNombre(nombre);
        }
    });


    // EVENTO UNA VES QUE SE ESCONDIO MODAL 
    $('#myModal').on('hidden.bs.modal', function () {
        $("#mensajeProveedor").empty();
        // console.log("Se escondio modal");
    });

    $("#formAddCompra").submit(function (e) { 
        e.preventDefault();
        let formData = new FormData($(this)[0]);
        // for (var pair of formData.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]); 
        // }
        $('#myModal').modal('hide');
        $.ajax({
            url: "../controlador/c_crearCompra.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                // console.log(data);
                if(data == "1"){
                    tablaCompra.ajax.reload();
                    tablaDeProductos.ajax.reload();
					// $('#formAddCurso')[0].reset();
                    Swal.fire('Exito!!','Se ha registrado la compra','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });

    // ELIMINAR COMPRA 
    $("#checkConfirmar").change(function (e) { 
        e.preventDefault();
        if($("#checkConfirmar").is(':checked')){
            $('#btnEliminarCompra').prop("disabled", false)
        }
        else{
            $('#btnEliminarCompra').prop("disabled", true); 
        }
    });

    $("#tablaCompra tbody").on('click','button.eliminarCompra',function (e) {
        e.preventDefault();
        let dataCompra = tablaCompra.row( $(this).parents('tr') ).data();
        $("#idDeletCompra").html(dataCompra.id_compra);
        $("#deletProveedorCompra").html(dataCompra.nombre_proveedor);
        $("#deletFechaCompra").html(dataCompra.fecha_compra);
    });


});

function agregarRapidoProveedor(nombre,numero){
    $.ajax({
        type: "POST",
        url: "../controlador/c_proveedor.php",
        data: {metodo:"agregarRapidoProveedor",nombre,numero},
        dataType: "JSON",
        success: function (response) {
            let num1 = Number.parseInt(response);
            if(Number.isInteger(num1)){
                let data = {id:num1, text: nombre+' - '+numero};
                var newOption = new Option(data.text, data.id, false, false);
                $('#addCompraProveedor').append(newOption).trigger('change');
                $('#addCompraProveedor').val(data.id).trigger('change');
                // $('#addCompraProveedor').select2({ minimumResultsForSearch: -1 });
                $("#mensajeProveedor").append(`<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Exito!</strong> Se agrego a un nuevo proveedor.
                </div>`);
            }else{
                // Swal.fire('Error!!',response,'error');
                $("#mensajeProveedor").append(`<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Problema!</strong> ${response}
                    </div>`);
            }
        }
    });
}

function agregarRapidoProveedorNombre(nombre){
    $.ajax({
        type: "POST",
        url: "../controlador/c_proveedor.php",
        data: {metodo:"agregarRapidoProveedorNombre",nombre},
        dataType: "JSON",
        success: function (response) {
            let num1 = Number.parseInt(response);
            if(Number.isInteger(num1)){
                let data = {id:num1, text: nombre};
                var newOption = new Option(data.text, data.id, false, false);
                $('#addCompraProveedor').append(newOption).trigger('change');
                $('#addCompraProveedor').val(data.id).trigger('change');
                // $('#addCompraProveedor').select2({ minimumResultsForSearch: -1 });
                $("#mensajeProveedor").append(`<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Exito!</strong> Se agrego a un nuevo proveedor.
                </div>`);
            }else{
                // Swal.fire('Error!!',response,'error');
                $("#mensajeProveedor").append(`<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Problema!</strong> ${response}
                    </div>`);
            }
        }
    });
}


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
                console.log(json.data);
                // listaPermanenteItem = {};
                listaPermanenteItem = json.data;
                return json.data;
            }   
        },
        columns:[
            {data: "nombre_producto"},
            {data: "descripcion_producto"},
            {data: "stock_producto"},
            {data: null,
                defaultContent:
                  "<button type='button' class='addProductoPedido btn btn-warning btn-sm'><i class='fas fa-shopping-cart'></i></button>",
            }
        ]
    });
}

function getListaProveedores(){
    $.ajax({
        type: "POST",
        url: "../controlador/c_proveedor.php",
        data: {metodo:'getListaProveedor'},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            let arregloProveedores = response.data;
            // let listaClientes = JSON.parse(response);
            // $("#addCompraProveedor").empty();
            // $("#editPedidoTienda").empty();
            // $("#addCompraProveedor").append("<option value=''>Ninguno</option>");
            // $("#editPedidoTienda").append("<option value=''>Ninguno</option>");
            arregloProveedores.forEach(element => {
                $("#addCompraProveedor").append("<option value='"+element.id_proveedor+"'>"+element.nombre_proveedor+" - "+element.telefono_proveedor+"</option>");
                // $("#editPedidoTienda").append("<option value='"+element.id_cliente+"'>"+element.nombre_cliente+" - "+element.ci_cliente+"</option>");
            });
            $('#addCompraProveedor').select2({
                "language": {
                    "noResults": function(){
                        // return "Provvedor no encontrado <a href='#' class='btn btn-sm btn-primary addProveedorNuevo'>  Agregar proveedor</a>";
                        return "Proveedor no encontrado <button type='button' class='btn btn-sm btn-primary addProveedorNuevo'>  Agregar proveedor</button>";
                    }
                },
                 escapeMarkup: function (markup) {
                     return markup;
                }
            });
            // $('#editPedidoTienda').select2();
        }
    });
}

function calcularTotalAcumalado(){
    let totalFinal = 0;
    $(".precioCompraProducto").each(function() {
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

function calcularPrecioPorUnidad(cantidad,idProducto){
    let tmp = $('#preciosProducto'+idProducto).html();
    let objetoTmp  = JSON.parse(tmp);
    let subtotal = cantidad*objetoTmp.precio_venta;
    $('#subTotalProducto_'+idProducto).val(subtotal.toFixed(2));
}


function getlistaVentas(){
	$('#tablaCompra').dataTable().fnDestroy();
	tablaCompra = $("#tablaCompra").DataTable({
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
			url: "../controlador/c_compra.php",
			data: { metodo: "getlistaCompras"},
		},
		columns: [
            { data: "id_compra", width:"5%" },
			{ data: "fecha_compra", width: "15%" },
            { data: "nombre_proveedor", width: "20%" },
			{ data: "cantidad", width: "15%" },
            { data: "total_compra", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProducto btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='eliminarCompra btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarCurso'><i class='fas fa-trash'></i></button>",
				width: "10%"
			}
		]
	});
}