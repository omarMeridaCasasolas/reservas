<?php 
    require_once("conexion.php");
    ob_clean();
    class Cliente extends Conexion{
        private $sentenceSQL;
        public function Cliente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaClientes(){
            $sql = "SELECT * from cliente";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            // return $respuesta;
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }
    } 

?>