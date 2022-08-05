<?php 
    require_once("conexion.php");
    ob_clean();
    class Usuario extends Conexion{
        private $sentenceSQL;
        public function Usuario(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getUsuario($usuario,$pass){
            $sql = "SELECT * from empleado WHERE UPPER(usuario_empleado) = UPPER(:usuario) AND pass_empleado = :pass AND estado_empleado = 1;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":usuario"=>$usuario,":pass"=>$pass));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
            // return json_encode($respuesta, JSON_PRETTY_PRINT);
        }
    } 

?>