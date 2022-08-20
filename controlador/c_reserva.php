<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_reserva.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $reserva = new Reserva();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getReservaSemana':
                $fechaInicio = $_REQUEST['dia'];
                $fechaFinal = date("Y-m-d", strtotime($fechaInicio.' + 6 days'));
                $res = $reserva->getReservaSemana($fechaInicio,$fechaFinal);
                break;
            case 'obtenerReservasGeneradas':
                $fechaInicio = $_REQUEST['fechaInicio'];
                $fechaFinal = $_REQUEST['fechaFin'];
                $res = $reserva->obtenerReservasGeneradas($fechaInicio,$fechaFinal);
                break;
            case 'agregarReserva':
                if(isset($_REQUEST['reserva']) && isset($_REQUEST['cliente']) && isset($_SESSION['usuario'])){
                    $idReserva = $_REQUEST['reserva'];
                    $idCliente = $_REQUEST['cliente'];
                    if($idReserva == $_SESSION['alistarReserva']){
                        $res = $reserva->agregarReserva($idReserva,$idCliente);
                    }else{
                        $res = "Error al prepara la reserva";
                    }
                }else{
                    $res = "Error de credenciales";
                }
                break;
            case 'getReserva':
                if(isset($_REQUEST['reserva']) && isset($_SESSION['usuario'])){
                    $idReserva = $_REQUEST['reserva'];
                    $res = $reserva->getReserva($idReserva);
                    if(is_array($res)){
                        $_SESSION['alistarReserva'] = $res['id_reserva'];
                        $res = json_encode($res, JSON_PRETTY_PRINT);
                    }
                }else{
                    $res = "Error de credenciales";
                }
                break;
            case 'getHorarioContinuo':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id'];
                    $res = $reserva->getHorarioContinuo($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
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
        $reserva->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }