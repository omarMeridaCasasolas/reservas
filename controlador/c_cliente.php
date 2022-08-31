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
            case 'actualizarCliente':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id =  trim($_REQUEST['id']);
                    $nombre =  trim($_REQUEST['nombreCliente']); 
                    $ci =  trim($_REQUEST['ciCliente']);
                    $numero =  trim($_REQUEST['celCliente']);
                    $res = $cliente->actualizarCliente($nombre,$ci,$numero,$id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;   
            case 'eliminarCliente':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id =  trim($_REQUEST['id']);
                    $res = $cliente->eliminarCliente($id);
                }else{
                    $res = "Error de autentificacion";
                }
            default:
                # code...
                break;
        }
        $cliente->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }