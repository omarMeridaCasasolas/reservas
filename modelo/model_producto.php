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

        public function agregarProducto($nombre,$descripcion,$precioVenta,$precioCompraUnidad,$unidadesCompradas){
            $sql = "INSERT INTO producto(nombre_producto,id_categoria , descripcion_producto, precio_venta, precio_compra, stock_producto) 
            VALUES(:nombre,1, :descripcion, :venta, :compra, :unidades);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":descripcion"=>$descripcion,":venta"=>$precioVenta,
            ":compra"=>$precioCompraUnidad,":unidades"=>$unidadesCompradas));
            $sentenceSQL->closeCursor();
            return $res;
        }
    } 

?>