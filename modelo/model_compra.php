<?php 
    require_once("conexion.php");
    ob_clean();
    class Compra extends Conexion{
        private $sentenceSQL;
        public function Compra(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getlistacompras(){
            $sql = "SELECT compra.id_compra, fecha_compra, total_compra, nombre_proveedor, count(detalle_compra.id_compra) as cantidad FROM compra INNER JOIN 
            detalle_compra ON detalle_compra.id_compra = compra.id_compra  INNER JOIN proveedor ON 
            compra.id_proveedor = proveedor.id_proveedor group by(detalle_compra.id_compra); ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function agregarCompra($fechaCompra,$totalCompra,$idProveedor){
            $sql = "INSERT INTO compra (fecha_compra, total_compra, id_proveedor) VALUES(:fecha,:total,:proveedor);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":fecha"=>$fechaCompra,":total"=>$totalCompra,":proveedor"=>$idProveedor));
            if($res == 1 || $res == true){
                $res = $this->connexion_bd->lastInsertId();
                $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
                $sentenceSQL->closeCursor();
                return $string;
            }else{
                $sentenceSQL->closeCursor();
                return $res;
            }
        }
        
        public function agregarDetalleCompra($idCompra,$idProducto,$cantidadProducto,$precioCompra){
            // $sql = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad_producto, precio_producto) VALUES(:compra,:product,:cant,:precio);";
            $sql = "CALL agregarProductoStock(:compra, :product, :cant, :precio)";
                    // CALL agregarProductoStock(5, 10, 6, 51.12
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":compra"=>$idCompra,":product"=>$idProducto,":cant"=>intval($cantidadProducto),":precio"=>$precioCompra));
            return $res;
        }

        public function getReporteCompras($fechaInicio,$fechaFinal){
            $sql = "SELECT fecha_compra, nombre_proveedor, format(total_compra,2) as total_compra FROM compra INNER JOIN 
            proveedor ON compra.id_proveedor = proveedor.id_proveedor  WHERE fecha_compra between :inicio AND :fin;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":inicio"=>$fechaInicio,":fin"=>$fechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        
    } 

?>