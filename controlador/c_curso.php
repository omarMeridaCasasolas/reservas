
<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_curso.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $curso = new Curso();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $curso->getListaCurso();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $telefono = $_REQUEST['telefono'];
                    $detalle = $_REQUEST['detalle'];
                    $res = $curso->agregarcurso($nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $nombre = $_REQUEST['nombre']; 
                    $telefono = $_REQUEST['telefono'];
                    $detalle = $_REQUEST['detalle'];
                    $res = $curso->actualizarcurso($id,$nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminarCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $curso->eliminarcurso($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
                
            case 'agregarRapidoCursoNombre':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $res = $curso->agregarRapidocursoNombre($nombre);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarRapidoCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre'];
                    $numero = $_REQUEST['numero'];
                    $res = $curso->agregarRapidocurso($nombre,$numero);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            default:
                # code...
                break;
        }
        $curso->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }