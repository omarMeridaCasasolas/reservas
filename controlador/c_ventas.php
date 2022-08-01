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
        $venta->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }