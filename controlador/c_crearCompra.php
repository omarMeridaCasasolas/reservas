<?php
    // print_r($_POST);
    session_start();
    date_default_timezone_set('America/La_Paz');
    ob_clean();
    if(isset($_SESSION['usuario'])){
        $arrayRespuesta = $_POST;
        // print_r($arrayRespuesta);
        // $arrayRespuesta = array('addCompraProveedor' => 10,
        //     'IdTotalPedido' => 1.00,
        //     'IdCant_6' => 2,
        //     'IdPrecio_6' => 1.00,
        //     'IdCant_7' => 9,
        //     'IdPrecio_7' => 1.50,
        //     'IdCant_9' => 4,
        //     'IdPrecio_9' => 3.50,
        //     'tablaDeProductos_length' => 10
        // );
        // print_r($arrayRespuesta);
        class CompraDTO{
            public $id=0;
            public $total=0;
            public $idProveedor =0;
        }

        class DetalleCompra{
            public $idProducto = 0;
            public $cantidadCompra = 0;
            public $precioCompra = 0.0;
            public $idCompra = 0;
        }

        function compraProducto($idProducto, $cantidad, &$listaObjetos){
            $objeto = buscarObjeto($idProducto,$listaObjetos);
            $objeto->cantidadCompra = $cantidad;
        }

        function precioProducto($idProducto, $precio, &$listaObjetos){
            $objeto = buscarObjeto($idProducto,$listaObjetos);
            $objeto->precioCompra = $precio;
        }

        function &buscarObjeto($id,&$listaObjetos){
            for ($i=0; $i < count($listaObjetos) ; $i++) { 
                $objeto = $listaObjetos[$i];
                if($objeto->idProducto == $id){
                    return $objeto;
                }
            }
            $detalleCompra = new DetalleCompra();
            $detalleCompra->idProducto = $id;
            array_push($listaObjetos,$detalleCompra);
            return $detalleCompra;
        } 
        // // session_start();
        // // ob_clean();
        // // $arrayRespuesta = $_POST;
        // // var_dump($_POST);
        $hoy = date('Y-m-d h:i:s');
        $listaObjetos = array();
        // // $res = 0;
        $compraDTO = new CompraDTO();
        foreach($arrayRespuesta as $key => $elemento){
            // echo $key."-->".$elemento."<><>";
            switch ($key) {
                case 'tablaDeProductos_length':
                    break;
                case 'addCompraProveedor':
                    $compraDTO->idProveedor = $elemento;
                    break;
                case 'IdTotalPedido':
                    $compraDTO->total= $elemento;
                    break;
                case (preg_match("/^IdCant_/",$key)? true : false):
                    $tmp = explode("_",$key);
                    // echo $tmp[1];
                    compraProducto($tmp[1],$elemento,$listaObjetos);
                    // precioProducto($tmp[1],$elemento,$listaObjetos);
                    break;
                case (preg_match("/^IdPrecio_/",$key)? true : false):
                    $tmp = explode("_",$key);
                    // echo $tmp[1];
                    // $res ++;
                    // $res = $elemento;
                    precioProducto($tmp[1],$elemento,$listaObjetos);
                    // compraProducto($tmp[1],$elemento,$listaObjetos);
                    break;
                default:
                    # code...
                    break;
            }
        }
        // print_r($listaObjetos);
        require_once('../modelo/model_compra.php');
        $compra = new Compra();
        $idCompra = $compra->agregarCompra($hoy, $compraDTO->total, $compraDTO->idProveedor);
        // $compraDTO->id = $idCompra;
        // print_r($listaObjetos);
        // $res = count($listaObjetos);
        // echo $res."\n";
        // var_dump($listaObjetos);
        // $res = count($listaObjetos);
        $res = "";
        for ($i=0; $i < count($listaObjetos) ; $i++) { 
            $detalleCompra = $listaObjetos[$i];
            // print_r($idCompra."--".$detalleCompra->idProducto."--".$detalleCompra->cantidadCompra."--".$detalleCompra->precioCompra);
            $res = $compra->agregarDetalleCompra($idCompra,$detalleCompra->idProducto,$detalleCompra->cantidadCompra,$detalleCompra->precioCompra);
            if($res){
                continue;
            }else{
                break;
            }
        }
        $compra->cerrarConexion();
        echo $res;

    }
    

    

?>