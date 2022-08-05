
<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_proveedor.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $proveedor = new Proveedor();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaProveedor':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $proveedor->getListaProveedor();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarProveedor':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $telefono = $_REQUEST['telefono'];
                    $detalle = $_REQUEST['detalle'];
                    $res = $proveedor->agregarProveedor($nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarProveedor':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $nombre = $_REQUEST['nombre']; 
                    $telefono = $_REQUEST['telefono'];
                    $detalle = $_REQUEST['detalle'];
                    $res = $proveedor->actualizarProveedor($id,$nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminarProveedor':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $proveedor->eliminarProveedor($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            default:
                # code...
                break;
        }
        $proveedor->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }