<?php 
    require_once("conexion.php");
    ob_clean();
    class Empleado extends Conexion{
        private $sentenceSQL;
        public function Empleado(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaEmpleado(){
            // $sql = "SELECT * from empleado WHERE tipo_empleado <> 'Tecnico' ORDER BY id_empleado DESC;";
            $sql = "SELECT * from empleado  ORDER BY id_empleado DESC;";
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

        public function agregarEmpleado($nombre,$usuario,$pass,$tipo,$telef){
            $sql = "INSERT INTO empleado(nombre_empleado, usuario_empleado, pass_empleado, tipo_empleado, telefono_empleado,estado_empleado) 
            VALUES(:nom,:user,:pass,:tipo,:telef,1);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":user"=>$usuario,":pass"=>$pass,":tipo"=>$tipo,":telef"=>$telef));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizarEmpleado($id,$nombre,$usuario,$estado,$tipo,$telef){
            $sql = "UPDATE empleado SET nombre_empleado = :nom , usuario_empleado = :user, estado_empleado = :estado, tipo_empleado = :tipo, 
            telefono_empleado = :telef WHERE id_empleado = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":user"=>$usuario,":estado"=>$estado,":tipo"=>$tipo,":telef"=>$telef,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarEmpleado($id){
            $sql = "DELETE FROM empleado WHERE id_empleado = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }
    } 

?>