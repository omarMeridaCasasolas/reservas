
<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_tarea.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $tarea = new Tarea();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaTareas':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $tarea->getListaTareas();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarTarea':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $precio = $_REQUEST['precio'];
                    $res = $tarea->agregarTarea($nombre,$precio);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarTarea':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $nombre = $_REQUEST['nombre']; 
                    $precio = $_REQUEST['precio'];
                    $res = $tarea->actualizarTarea($id,$nombre,$precio);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminarTarea':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $tarea->eliminarTarea($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
                
            // case 'agregarRapidotareaNombre':
            //     if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
            //         $nombre = $_REQUEST['nombre']; 
            //         $res = $tarea->agregarRapidotareaNombre($nombre);
            //     }else{
            //         $res = "Error de autentificacion";
            //     }
            //     break;
            // case 'agregarRapidotarea':
            //     if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
            //         $nombre = $_REQUEST['nombre'];
            //         $numero = $_REQUEST['numero'];
            //         $res = $tarea->agregarRapidotarea($nombre,$numero);
            //     }else{
            //         $res = "Error de autentificacion";
            //     }
            //     break;
            default:
                # code...
                break;
        }
        $tarea->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }