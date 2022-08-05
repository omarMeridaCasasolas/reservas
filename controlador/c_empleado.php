<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_empleado.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $empleado = new Empleado();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaEmpleado':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $empleado->getListaEmpleado();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarEmpleado':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $usuario = $_REQUEST['usuario'];
                    $pass = $_REQUEST['pass'];
                    $tipo = $_REQUEST['tipo'];
                    $telef = $_REQUEST['telef'];
                    $res = $empleado->agregarEmpleado($nombre,$usuario,$pass,$tipo,$telef);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarEmpleado':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $nombre = $_REQUEST['nombre']; 
                    $usuario = $_REQUEST['user'];
                    $estado = $_REQUEST['estado'];
                    $tipo = $_REQUEST['tipo'];
                    $telef = $_REQUEST['telef'];
                    $res = $empleado->actualizarEmpleado($id,$nombre,$usuario,$estado,$tipo,$telef);
                }else{
                    $res = "Error de autentificacion";
                }
            case 'eliminarEmpleado':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $empleado->eliminarEmpleado($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            default:
                # code...
                break;
        }
        $empleado->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }