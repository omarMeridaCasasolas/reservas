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

        // public function obtenercomprasGeneradas($fechaInicio,$fechaFinal){
        //     $sql = "SELECT nombre_producto, sum(total_producto) AS total, count(detalle_compra.id_producto) * cant_compra AS cant_vendida FROM detalle_compra 
        //     INNER JOIN producto ON producto.id_producto = detalle_compra.id_producto INNER JOIN compra ON compra.id_compras = detalle_compra.id_compras 
        //     WHERE fecha_compra between :inicio AND :final group by(detalle_compra.id_producto)  order by total desc";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $res = $sentenceSQL->execute(array(":inicio"=>$fechaInicio,":final"=>$fechaFinal));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return json_encode($respuesta, JSON_PRETTY_PRINT);
        // }
    } 

?>