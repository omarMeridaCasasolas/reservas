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
            case 'getListaClientesData':
                if(isset($_SESSION['usuario'])){
                    $res = $cliente->getListaClientesData();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarCliente':
                if(isset($_SESSION['usuario']) && isset($_REQUEST['nombre']) && isset($_REQUEST['ci']) && isset($_REQUEST['numero'])){
                    $nombre = $_REQUEST['nombre']; 
                    $ci = $_REQUEST['ci'];
                    $numero = $_REQUEST['numero'];
                    $res = $cliente->agregarCliente($nombre,$ci,$numero);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
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