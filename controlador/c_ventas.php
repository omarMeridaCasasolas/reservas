<?php
    require_once("../modelo/model_venta.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $venta = new Venta();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getlistaVentas':
                $res = $venta->getlistaVentas();
                break;
            case 'obtenerVentasGeneradas':
                $fechaInicio = $_REQUEST['fechaInicio'];
                $fechaFinal = $_REQUEST['fechaFin'];
                $res = $venta->obtenerVentasGeneradas($fechaInicio,$fechaFinal);
                break;
            // case 'getlistaPublicaciones':
            //     $res = $publicacion->getlistaPublicaciones();
            //     break;
            // case 'verPublicaciones':
            //     $res = $publicacion->verPublicaciones();
            //     break; 
            case 'getReporteVentas':
                $fechaInicio = $_REQUEST['fechaInicio']." 00:00:00";
                $fechaFinal = $_REQUEST['fechaFin']." 23:59:59";
                // $res = $fechaInicio ."----".$fechaFinal;
                $res = $venta->getReporteVentas($fechaInicio,$fechaFinal);
                break; 
            default:
                # code...
                break;
        }
        $venta->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }