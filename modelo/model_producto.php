<?php 
    require_once("conexion.php");
    ob_clean();
    class Producto extends Conexion{
        private $sentenceSQL;
        public function Producto(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }
        public function getlistaProductos(){
            $sql = "SELECT * from producto;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            // $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function agregarProducto($nombre,$descripcion,$precioVenta){
            $sql = "INSERT INTO producto(nombre_producto,id_categoria , descripcion_producto, precio_venta , stock_producto) VALUES(:nombre,1, :descripcion, :venta, 0);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":descripcion"=>$descripcion,":venta"=>$precioVenta));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function listarSnackCliente(){
            $sql = "SELECT * from producto WHERE stock_producto > 1;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }

        public function eliminarProducto($id){
            $sql = "DELETE FROM producto WHERE id_producto = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function obtenerComprasProducto($id){
            $sql = "SELECT cantidad_producto, precio_productos, fecha_compra, nombre_proveedor FROM detalle_compra INNER JOIN compra ON compra.id_compra = detalle_compra.id_compra 
            INNER JOIN proveedor ON proveedor.id_proveedor = compra.id_proveedor WHERE id_producto = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            // $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function actualizarProducto($nombre,$descripcion,$precioVenta,$id){
            $sql = "UPDATE producto SET nombre_producto = :nombre , descripcion_producto = :descripcion, precio_venta = :venta WHERE id_producto = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":descripcion"=>$descripcion,":venta"=>$precioVenta,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }
    } 
