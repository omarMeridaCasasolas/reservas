<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_cliente.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $cliente = new Cliente();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaClientes':
                if(isset($_SESSION['usuario'])){
                    $res = $cliente->getListaClientes();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            // case 'getlistaPublicaciones':
            //     $res = $publicacion->getlistaPublicaciones();
            //     break;
            // case 'verPublicaciones':
            //     $res = $publicacion->verPublicaciones();
            //     break; 
            // case 'eliminarPublicacion':
            //     $idPublicacion = $_REQUEST['idPublicacion'];
            //     $res = $publicacion->eliminarPublicacion($idPublicacion);
            //     break; 
            default:
                # code...
                break;
        }
        $cliente->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }