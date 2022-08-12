var tablaProducto;
$(document).ready(function () {
    getlistaProductos();

	$("#formAddProducto").submit(function (e) { 
		e.preventDefault();
		let nombre = $("#addNomProducto").val();
		let descripcion = $("#addDescProducto").val();
		let precioVenta = $("#addVentaProducto").val();
		$('#modalAgregarProducto').modal('hide');
		$.ajax({
			type: "POST",
			url: "../controlador/c_producto.php",
			data: {metodo:"agregarProducto",nombre,descripcion,precioVenta},
			// dataType: "dataType",
			success: function (response) {
				console.log(response);
				if(response == "1"){
					tablaProducto.ajax.reload();
					$('#formAddProducto')[0].reset();
					// $("#modalAgregarProducto").trigger("reset");
					Swal.fire('Exito!!','Se ha agregado un modelo de producto','success');
				}else{
					Swal.fire('Error!!',response,'error');
				}
			}
		});
	});

	//DETALLE PRODUCTO 
	$("#tablaProducto tbody").on('click','button.infoProducto',function () {
		let datosProducto = tablaProducto.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#nombDetalleProducto").html(datosProducto.nombre_producto);
		$("#descDetalleProducto").html(datosProducto.descripcion_producto);
		$("#ventDetalleProducto").html(datosProducto.precio_venta);
		$("#stockDetalleProducto").html(datosProducto.stock_producto);
		$("#contInfo").empty();
		$.ajax({
			type: "POST",
			url: "../controlador/c_producto.php",
			data: {metodo:"obtenerComprasProducto",id: datosProducto.id_producto},
			dataType: "JSON",
			success: function (response) {
				let aux = response.data;
				console.log(aux);
				if(aux.length == 0){
					$("#contInfo").html(`<h5 class='text-center'>No se tiene registro de compra</h5>`);
				}else{
					let cuerpo = '';
					let cabezera = `<table class='table table-striped table-sm'><thead><tr><th>Fecha </th><th>Cantidad</th> <th>Precio</th><th>
					Proveedor</th></tr></thead><tbody>`;
					let footer = `</tbody></table>`;
					aux.forEach(element => {
						cuerpo += `<tr><td>${element.fecha_compra}</td><td>${element.cantidad_producto}</td>
						<td>${element.precio_productos}</td><td>${element.nombre_proveedor}</td></tr>`;
					});
					$("#contInfo").html(cabezera+cuerpo+footer);
				}
				
			}
		});
    });

	// EDITAR PRODUCTO 
	$("#tablaProducto tbody").on('click','button.editProducto',function () {
		let datosProducto = tablaProducto.row( $(this).parents('tr') ).data();
        $("#editIDProducto").val(datosProducto.id_producto);
        $("#editNomProducto").val(datosProducto.nombre_producto);
		$("#editDescProducto").val(datosProducto.descripcion_producto);
		$("#editVentaProducto").val(datosProducto.precio_venta);
    });

	$("#formEditProducto").submit(function (e) { 
        e.preventDefault();
        let id = $("#editIDProducto").val();
        let nombre = $("#editNomProducto").val();
		let descripcion = $("#editDescProducto").val();
		let precioVenta = $("#editVentaProducto").val();
		$('#modalEditarProducto').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_producto.php",
            data: {metodo:"actualizarProducto", id,nombre, descripcion, precioVenta},
            success: function (response) {
                // console.log(response);
                if(response == "1"){
                    tablaProducto.ajax.reload();
                    Swal.fire('Exito!!','Se ha actualizado el producto: '+$("#editNomProducto").val(),'success');
					$('#formEditProducto')[0].reset();
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });


	// ELIMINAR PRODUCTO 
	$("#tablaProducto tbody").on('click','button.deletProducto',function () {
		let datosProducto = tablaProducto.row( $(this).parents('tr') ).data();
        // $("#delIdPublicacion").html(datosPublicacion.id_publicacion);
        $("#idDeletProducto").html(datosProducto.id_producto);
		$("#nomDeletProducto").html(datosProducto.nombre_producto);
    });

	$("#formDeletProducto").submit(function (e) { 
        e.preventDefault();
        let id = $("#idDeletProducto").html();
        $('#modalEliminarProducto').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_producto.php",
            data: {metodo:"eliminarProducto", id},
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaProducto.ajax.reload();
                    Swal.fire('Exito!!','Se ha eliminado el producto'+$("#nomDeletProducto").html(),'success');
					$('#formDeletProducto')[0].reset();
                }else{
                    Swal.fire('Error!!',"No se puede eliminar por que se tiene registros de compras o ventas",'error');
                }
            }
        });
    });
});

function getlistaProductos(){
	$('#tablaProducto').dataTable().fnDestroy();
	tablaProducto = $("#tablaProducto").DataTable({
		"pageLength": 50,
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
			url: "../controlador/c_producto.php",
			data: { metodo: "getlistaProductos"},
		},
		columns: [
			{ data: "id_producto", width: "5%" },
			{ data: "nombre_producto", width: "25%" },
            { data: "descripcion_producto", width: "20%" },
			{ data: "precio_venta", width: "10%" },
            { data: "stock_producto", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='infoProducto btn btn-info btn-sm' data-toggle='modal' data-target='#modalInfoProducto'><i class='fas fa-info-circle'></i></button> "+
				"<button type='button' class='editProducto btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarProducto'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='deletProducto btn btn-danger btn-sm' data-toggle='modal' data-target='#modalEliminarProducto'><i class='fas fa-trash'></i></button>",
				width: "10%"
			}
		]
	});
}