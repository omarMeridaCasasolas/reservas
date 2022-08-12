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
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre'];
                    $descripcion = $_REQUEST['descripcion'];
                    $precioVenta = $_REQUEST['precioVenta'];
                    $res = $producto->agregarProducto($nombre,$descripcion,$precioVenta);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'actualizarProducto':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre'];
                    $descripcion = $_REQUEST['descripcion'];
                    $precioVenta = $_REQUEST['precioVenta'];
                    $id =  $_REQUEST['id'];
                    $res = $producto->actualizarProducto($nombre,$descripcion,$precioVenta,$id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'listarSnackCliente':
                $res = $producto->listarSnackCliente();
                break; 
            case 'eliminarProducto':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $producto->eliminarProducto($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'obtenerComprasProducto':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $producto->obtenerComprasProducto($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            default:
                # code...
                break;
        }
        $producto->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }