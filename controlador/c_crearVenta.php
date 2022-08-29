<?php
    // print_r($_POST);
    session_start();
    date_default_timezone_set('America/La_Paz');
    ob_clean();
    if(isset($_SESSION['usuario'])){
        $arrayRespuesta = $_POST;
        // print_r($arrayRespuesta);
        // $arrayRespuesta = array('addClientaVenta' => 2,
        //      'IdTotalPedido' => 1.00,
        //      'IdCant_7' => 2,
        //      'subTotalProducto_7' => 11.00,
        //      'IdCant_10' => 1,
        //      'subTotalProducto_10' => 11.50,
        //      'tablaDeProductos_length' => 10
        //  );
        // print_r($arrayRespuesta);
        class VentaDTO{
            public $id = 0;
            public $idCliente = 0;
            public $idEmpleado = 0;
            public $totalVenta = 0.0;
        }

        class DetalleVenta{
            public $idVenta = 0;
            public $idProducto = 0;
            public $cantidadVenta = 0;
            public $precioVenta = 0.0;
        }

        function ventaProducto($idProducto, $cantidad, &$listaObjetos){
            $objeto = buscarObjeto($idProducto,$listaObjetos);
            $objeto->cantidadVenta = $cantidad;
        }

        function precioProducto($idProducto, $precio, &$listaObjetos){
            $objeto = buscarObjeto($idProducto,$listaObjetos);
            $objeto->precioVenta = $precio;
        }

        function &buscarObjeto($id,&$listaObjetos){
            for ($i=0; $i < count($listaObjetos) ; $i++) { 
                $objeto = $listaObjetos[$i];
                if($objeto->idProducto == $id){
                    return $objeto;
                }
            }
            $detalleVenta = new DetalleVenta();
            $detalleVenta->idProducto = $id;
            array_push($listaObjetos,$detalleVenta);
            return $detalleVenta;
        } 
        $hoy = date('Y-m-d h:i:s');
        $listaObjetos = array();
        // // $res = 0;
        $ventaDTO = new VentaDTO();
        foreach($arrayRespuesta as $key => $elemento){
            // echo $key."-->".$elemento."<><>";
            switch ($key) {
                case 'tablaDeProductos_length':
                    break;
                case 'addClientaVenta':
                    $ventaDTO->idCliente = $elemento;
                    break;
                case 'IdTotalPedido':
                    $ventaDTO->total= $elemento;
                    break;
                case (preg_match("/^IdCant_/",$key)? true : false):
                    $tmp = explode("_",$key);
                    ventaProducto($tmp[1],$elemento,$listaObjetos);
                    break;
                case (preg_match("/^subTotalProducto_/",$key)? true : false):
                    $tmp = explode("_",$key);
                    precioProducto($tmp[1],$elemento,$listaObjetos);
                    break;
                default:
                    # code...
                    break;
            }
        }
        // print_r($listaObjetos);
        require_once('../modelo/model_venta.php');
        $venta = new Venta();
        $idVenta = $venta->agregarVenta($hoy, $ventaDTO->total, $ventaDTO->idCliente,$_SESSION['id_empleado']);
        // echo $idVenta;
        // $ventaDTO->id = $idVenta;
        // print_r($listaObjetos);
        // $res = count($listaObjetos);
        // echo $res."\n";
        // var_dump($listaObjetos);
        // $res = count($listaObjetos);

        $res = "";
        for ($i=0; $i < count($listaObjetos) ; $i++) { 
            $detalleVenta = $listaObjetos[$i];
            // print_r($idVenta."--".$detalleVenta->idProducto."--".$detalleVenta->cantidadVenta."--".$detalleVenta->precioVenta);
            $res = $venta->agregarDetalleVenta($idVenta,$detalleVenta->idProducto,$detalleVenta->cantidadVenta,$detalleVenta->precioVenta);
            if($res){
                continue;
            }else{
                break;
            }
        }
        $venta->cerrarConexion();
        echo $res;

    }
    

    

?>