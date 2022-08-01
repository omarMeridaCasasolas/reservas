var tablaProducto;
$(document).ready(function () {
    getlistaProductos();
	$("input[type=radio][name=optradio]").change(function (e) { 
		e.preventDefault();
		let res = $('input[name=optradio]:checked', '#formAddProducto').val();
		if(res == "compraPorUnidad"){
			$("#compraPaquete").addClass("d-none");
			$("#compraUnidad").removeClass("d-none");
		}else{
			$("#compraUnidad").addClass("d-none");
			$("#compraPaquete").removeClass("d-none");
		}
	});

	$("#formAddProducto").submit(function (e) { 
		e.preventDefault();
		let nombre = $("#addNomProducto").val();
		let descripcion = $("#addDescProducto").val();
		let precioVenta = $("#addVentaProducto").val();
		let precioCompraUnidad = $("#addPrecioCompraUnit").val();
		let unidadesCompradas = $("#addUnidadesCompra").val();
		$('#modalAgregarProducto').modal('hide');
		$.ajax({
			type: "POST",
			url: "../controlador/c_producto.php",
			data: {metodo:"agregarProducto",nombre,descripcion,precioVenta,precioCompraUnidad,unidadesCompradas},
			// dataType: "dataType",
			success: function (response) {
				console.log(response);
				if(response == "1"){
					tablaProducto.ajax.reload();
					$('#formAddProducto')[0].reset();
					// $("#modalAgregarProducto").trigger("reset");
				}else{
					Swal.fire('Error!!',response,'error');
				}
			}
		});
	});
});

function getlistaProductos(){
	$('#tablaProducto').dataTable().fnDestroy();
	tablaProducto = $("#tablaProducto").DataTable({
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
            { data: "descripcion_producto", width: "15%" },
			{ data: "precio_venta", width: "10%" },
            { data: "stock_producto", width: "15%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProducto btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='estadoEmpleado btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
				width: "10%"
			}
		]
	});
}