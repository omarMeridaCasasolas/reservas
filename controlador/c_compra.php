<?php
    require_once("../modelo/model_compra.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $compra = new Compra();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getlistaCompras':
                $res = $compra->getlistaCompras();
                break;
            case 'obtenercomprasGeneradas':
                $fechaInicio = $_REQUEST['fechaInicio'];
                $fechaFinal = $_REQUEST['fechaFin'];
                $res = $compra->obtenercomprasGeneradas($fechaInicio,$fechaFinal);
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
        $compra->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }