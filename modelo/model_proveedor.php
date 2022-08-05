<?php 
    require_once("conexion.php");
    ob_clean();
    class Proveedor extends Conexion{
        private $sentenceSQL;
        public function Proveedor(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaproveedor(){
            $sql = "SELECT * from proveedor ORDER BY id_proveedor DESC;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        // public function getListaClientesData(){
        //     $sql = "SELECT * from cliente";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $res = $sentenceSQL->execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }

        public function agregarProveedor($nombre,$telefono,$detalle){
            $sql = "INSERT INTO proveedor(nombre_proveedor, telefono_proveedor, detalle_proveedor) 
            VALUES(:nom,:telef,:detalle);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":telef"=>$telefono,":detalle"=>$detalle));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizarProveedor($id,$nombre,$telefono,$detalle){
            $sql = "UPDATE proveedor SET nombre_proveedor = :nom , detalle_proveedor = :detalle, telefono_proveedor = :telef 
            WHERE id_proveedor = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":detalle"=>$detalle,":telef"=>$telefono,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarProveedor($id){
            $sql = "DELETE FROM proveedor WHERE id_proveedor = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }
    } 

?>