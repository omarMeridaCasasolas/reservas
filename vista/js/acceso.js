$(document).ready(function () {
    $("#signForm").submit(function (e) { 
        e.preventDefault();
        let usuario = $("#validationUsuario").val();
        let pass = $("#validarPass").val();
        $.ajax({
            type: "POST",
            url: "../controlador/c_validar.php",
            data: {usuario,pass},
            dataType: "JSON",
            success: function (response) {
                if(response.respuesta === true){
                    Swal.fire('Exito!!','Se ha verificado los datos','success');
                    setTimeout(() => {
                        window.location.href = "cReserva.php";
                    }, 1200);
                }else{
                    Swal.fire('Error!!','Compruebe su usuario o contraseña','error');
                }
            }
        });
    });
});