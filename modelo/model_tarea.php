<?php 
    require_once("conexion.php");
    ob_clean();
    class Tarea extends Conexion{
        private $sentenceSQL;
        public function Tarea(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaTareas(){
            $sql = "SELECT * from tarea ORDER BY id_tarea DESC;";
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

        public function agregarTarea($nombre,$precio){
            $sql = "INSERT INTO tarea(nombre_tarea, precio_tarea)VALUES(:nom,:precio);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":precio"=>$precio));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizarTarea($id,$nombre,$precio){
            $sql = "UPDATE tarea SET nombre_tarea = :nom , precio_tarea = :precio WHERE id_tarea = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":precio"=>$precio,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarTarea($id){
            $sql = "DELETE FROM tarea WHERE id_tarea = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        // public function agregarRapidoProveedorNombre($nombre){
        //     $sql = "INSERT INTO proveedor(nombre_proveedor) VALUES(:nom);";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $res = $sentenceSQL->execute(array(":nom"=>$nombre));
        //     if($res == 1 || $res == true){
        //         $res = $this->connexion_bd->lastInsertId();
        //         $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
        //         $sentenceSQL->closeCursor();
        //         return $string;
        //     }else{
        //         $sentenceSQL->closeCursor();
        //         return $res;
        //     }
        // }

        // public function agregarRapidoProveedor($nombre,$numero){
        //     $sql = "INSERT INTO proveedor(nombre_proveedor,telefono_proveedor) VALUES(:nom,:telef);";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $res = $sentenceSQL->execute(array(":nom"=>$nombre,":telef"=>$numero));
        //     if($res == 1 || $res == true){
        //         $res = $this->connexion_bd->lastInsertId();
        //         $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
        //         $sentenceSQL->closeCursor();
        //         return $string;
        //     }else{
        //         $sentenceSQL->closeCursor();
        //         return $res;
        //     }
        // }
    } 

?>