var tablaCliente;
$(document).ready(function () {
    getListaClientes(); 
    $("#formAddCliente").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#nomCliente").val();
        let ci = $("#ciCliente").val();
        let numero = $("#numCliente").val();
        $('#modalAgregarCliente').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/c_cliente.php",
            data: {metodo:"agregarCliente",nombre,ci,numero},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response == "1"){
                    tablaCliente.ajax.reload();
					$('#formAddCliente')[0].reset();
                    Swal.fire('Exito!!','Se ha creado el cliente','success');
                }else{
                    Swal.fire('Error!!',response,'error');
                }
            }
        });
    });
});

function getListaClientes(){
    $('#tablaCliente').dataTable().fnDestroy();
	tablaCliente = $("#tablaCliente").DataTable({
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
			url: "../controlador/c_cliente.php",
			data: { metodo: "getListaClientesData"},
		},
		columns: [
			{ data: "id_cliente", width: "5%" },
			{ data: "nombre_cliente", width: "25%" },
            { data: "celular_cliente", width: "15%" },
			{ data: "ci_cliente", width: "10%" },
			{ data: null,
				defaultContent:
				"<button type='button' class='editProducto btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal'><i class='fas fa-edit'></i></button> "+
				"<button type='button' class='estadoEmpleado btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
				width: "10%"
			}
		]
	});
}