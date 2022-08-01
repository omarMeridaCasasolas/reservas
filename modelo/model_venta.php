<?php 
    require_once("conexion.php");
    ob_clean();
    class Venta extends Conexion{
        private $sentenceSQL;
        public function Venta(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getlistaVentas(){
            $sql = "SELECT id_ventas, nombre_cliente, nombre_empleado , fecha_venta, total_venta from venta LEFT JOIN cliente ON cliente.id_cliente = venta.id_cliente 
            INNER JOIN empleado ON empleado.id_empleado = venta.id_empleado;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function obtenerVentasGeneradas($fechaInicio,$fechaFinal){
            $sql = "SELECT nombre_producto, sum(total_producto) AS total, count(detalle_venta.id_producto) * cant_venta AS cant_vendida FROM detalle_venta 
            INNER JOIN producto ON producto.id_producto = detalle_venta.id_producto INNER JOIN venta ON venta.id_ventas = detalle_venta.id_ventas 
            WHERE fecha_venta between :inicio AND :final group by(detalle_venta.id_producto)  order by total desc";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":inicio"=>$fechaInicio,":final"=>$fechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }
    } 

?>