
<?php
    class Conexion{
        protected $connexion_bd;
        public function Conexion(){
            try {
                $usuario = "root";
                $contrasenia = "kirium";
                $this->connexion_bd = new PDO('mysql:host=localhost;dbname=reserva;port=3307',$usuario,$contrasenia);
                $this->connexion_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connexion_bd;
            }catch (PDOException $e) {
                echo "Errod aqui";
                print "¡Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

?>
    