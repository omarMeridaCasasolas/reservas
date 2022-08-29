<?php
    //obtencion del archivo
    session_start();
    date_default_timezone_set('America/La_Paz');
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
            case 'listaReservaSemanaEdit':
                $fechaInicio = $_REQUEST['fechaInicio'];
                $fechaFinal = date("Y-m-d", strtotime($fechaInicio.' + 6 days'));
                $idCurso = $_REQUEST['idCurso'];
                $res = $reserva->listaReservaSemanaEdit($fechaInicio,$fechaFinal,$idCurso);
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
                // reservaPorJuegoDeportivo",idCliente,costoReserva,pagoDigital,pagoEfectivo,reservaInicio,reservaFinal
            case 'reservaPorJuegoDeportivo':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idCliente = intval($_REQUEST['idCliente']);
                    $costoReserva = floatval($_REQUEST['costoReserva']);
                    $pagoDigital = floatval($_REQUEST['pagoDigital']);
                    $pagoEfectivo = floatval($_REQUEST['pagoEfectivo']);
                    $reservaInicio = intval($_REQUEST['reservaInicio']);
                    $reservaFinal = intval($_REQUEST['reservaFinal']);
                    $ident = date("Y-m-d H:i:s");
                    $res = $reserva->reservaPorJuegoDeportivo($idCliente,$costoReserva,$pagoDigital,$pagoEfectivo,$reservaInicio,$reservaFinal,$ident);
                }else{
                    $res = "Error de autentificacion";
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
            case 'getReservaEdit':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idReserva = $_REQUEST['reserva'];
                    $res = $reserva->getReservaEdit($idReserva);
                    if(is_array($res)){
                        // $_SESSION['alistarReserva'] = $res['id_reserva'];
                        $res = json_encode($res, JSON_PRETTY_PRINT);
                    }
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'reservaPorJuegoDeportivoEdit':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idCliente = intval($_REQUEST['idCliente']);
                    $costoReserva = floatval($_REQUEST['costoReserva']);
                    $pagoDigital = floatval($_REQUEST['pagoDigital']);
                    $pagoEfectivo = floatval($_REQUEST['pagoEfectivo']);
                    $reservaInicio = intval($_REQUEST['reservaInicio']);
                    $reservaFinal = intval($_REQUEST['reservaFinal']);
                    $fechaAnteriorReserva = $_REQUEST['fechaAnteriorReserva'];
                    $ident = date("Y-m-d H:i:s");
                    $res = $reserva->reservaPorJuegoDeportivoEdit($idCliente,$costoReserva,$pagoDigital,$pagoEfectivo,$reservaInicio,$reservaFinal,$ident,$fechaAnteriorReserva);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'eliminarReserva':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $fechaAnteriorReserva = $_REQUEST['fechaAnteriorReserva'];
                    $res = $reserva->eliminarReserva($fechaAnteriorReserva);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'habilitarReserva':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['reserva'];
                    // $res =$reserva;
                    $res = $reserva->habilitarReserva($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            // case 'obtnerReservaHabilitacion':
            //     if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
            //         $reserva = $_REQUEST['reserva'];
            //         $res = $reserva->obtnerReservaHabilitacion($reserva);
            //     }else{
            //         $res = "Error de autentificacion";
            //     }
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