<?php
    session_start();
    require_once("../modelo/model_producto.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $producto = new Producto();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getlistaProductos':
                // $res = $producto->getlistaProductos();
                if(isset($_SESSION['usuario'])){
                    $res = $producto->getlistaProductos();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarProducto':
                if(isset($_SESSION['usuario'])){
                    $nombre = $_REQUEST['nombre'];
                    $descripcion = $_REQUEST['descripcion'];
                    $precioVenta = $_REQUEST['precioVenta'];
                    $precioCompraUnidad = $_REQUEST['precioCompraUnidad'];
                    $unidadesCompradas = $_REQUEST['unidadesCompradas'];
                    $res = $producto->agregarProducto($nombre,$descripcion,$precioVenta,$precioCompraUnidad,$unidadesCompradas);
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
        $producto->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }