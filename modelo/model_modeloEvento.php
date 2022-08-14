<?php 
    require_once("conexion.php");
    ob_clean();
    class ModeloEvento extends Conexion{
        private $sentenceSQL;
        public function ModeloEvento(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaModeloEventos(){
            $sql = "SELECT * from modelo_evento ORDER BY id_modelo_evento DESC;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function agregarTipoEvento($nombre,$precio,$tiempo){
            $sql = "INSERT INTO modelo_evento(nombre_modelo_evento, precio_aprox, hora_modelo_evento) VALUES(:nom,:precio,:tiempo);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":precio"=>$precio,":tiempo"=>$tiempo));
            if($res == 1 ){
                $res = $this->connexion_bd->lastInsertId();
            }
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function asignarTareaTipoEvento($idTarea,$idTipoEvento){
            $sql = "INSERT INTO modelo_tarea(id_modelo_evento, id_tarea) VALUES(:idTipo,:idTarea);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":idTipo"=>$idTipoEvento,":idTarea"=>$idTarea));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizarModeloEventoTareas($id,$nombre,$precio,$tiempo){
            $sql = "UPDATE modelo_evento SET nombre_modelo_evento = :nom , hora_modelo_evento = :hora, precio_aprox = :precio 
            WHERE id_modelo_evento = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":hora"=>$tiempo,":precio"=>$precio,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarModeloTarea($id){
            $sql = "DELETE FROM modelo_tarea WHERE id_modelo_evento = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarModeloEvento($id){
            $sql = "DELETE FROM modelo_evento WHERE id_modelo_evento = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function getTareasTipoEvento($id){
            $sql = "SELECT tarea.id_tarea, nombre_tarea, precio_tarea from tarea INNER JOIN modelo_tarea ON tarea.id_tarea = modelo_tarea.id_tarea 
            WHERE id_modelo_evento = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
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