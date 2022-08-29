$(document).ready(function () {
    // getListaPagosGrupo($("#selectGrupo").val());
    getlistaCursos();
    $("#selectGrupo").change(function (e) { 
        e.preventDefault();
        // getlistaCursos();
    });
});

function getListaPagosGrupo(id){
    $.ajax({
        type: "POST",
        url: "../controlador/c_pago.php",
        data: {metodo:"getListaPagosGrupo",id},
        dataType: "dataType",
        success: function (response) {
            console.log(response);
        }
    });
}

function getlistaCursos(){
    // let id = $("#selectGrupo").val();
    $.ajax({
        type: "POST",
        url: "../controlador/c_curso.php",
        data: {metodo:"getListaCursoInscripcion"},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            // let listaCursos =  response.data;
            response.forEach(element => {
                $("#selectGrupo").append(`<option value='${element.id_curso}'>${element.nombre_curso}</option>`);
            });
            $('#selectGrupo').select2();
            getListaPagosGrupo($('#selectGrupo').val());
        }
    });
}