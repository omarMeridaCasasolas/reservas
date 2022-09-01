
<?php
    class Conexion{
        protected $connexion_bd;
        public function Conexion(){
            try {
                // $usuario = "root";
                // $contrasenia = "kirium";
                // $this->connexion_bd = new PDO('mysql:host=localhost;dbname=reserva;port=3307',$usuario,$contrasenia);

                // $usuario = "uasrxz4qrh1xinnr";
                // $contrasenia = "WSM9ks7dz2mQJcZ9DUCy";
                // $this->connexion_bd = new PDO('mysql:host=bxqsxwdoasmaf0zorzvi;dbname=reserva;port=3306',$usuario,$contrasenia);

                $usuario = "uasrxz4qrh1xinnr";
                $contrasenia = "WSM9ks7dz2mQJcZ9DUCy";
                $this->connexion_bd = new PDO('mysql:host=bxqsxwdoasmaf0zorzvi-mysql.services.clever-cloud.com;dbname=bxqsxwdoasmaf0zorzvi;port=3306',$usuario,$contrasenia);

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
    