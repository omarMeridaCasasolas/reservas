<?php 
    require_once("conexion.php");
    ob_clean();
    class Alumno extends Conexion{
        private $sentenceSQL;
        public function Alumno(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaAlumno(){
            $sql = "SELECT id_alumno, nombre_alumno, carnet_alumno, fecha_nacimiento nombre_tutor, celular_contacto, 
            DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),fecha_nacimiento)), '%Y')+0 AS edad from alumno ORDER BY id_alumno DESC;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function agregarAlumnoCurso($idCurso,$idAlumno,$fechaInscripcion){
            $sql = "INSERT INTO gestion_curso(id_curso, id_alumno, fecha_inscripcion) VALUES(:curso,:alumno,:fecha);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":curso"=>$idCurso,":alumno"=>$idAlumno,":fecha"=>$fechaInscripcion));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function agregarAlumno($nombre,$carnet,$nombreTutor,$contacto,$fecha){
            $sql = "INSERT INTO alumno(nombre_alumno, carnet_alumno, nombre_tutor, celular_contacto, fecha_nacimiento) 
            VALUES(:nom,:carnet,:tutor,:contacto,:fecha);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":carnet"=>$carnet,":tutor"=>$nombreTutor,":contacto"=>$contacto,":fecha"=>$fecha));
            if($res == 1 ){
                $res = $this->connexion_bd->lastInsertId();
                $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
                $sentenceSQL->closeCursor();
                return $string;
            }else{
                $sentenceSQL->closeCursor();
                return $res;
            }
        }

        public function actualizarAlumno($id,$nombre,$carnet,$fecha,$tutor,$contacto){
            $sql = "UPDATE alumno SET nombre_alumno = :nom , carnet_alumno = :carnet, nombre_tutor = :tutor,  celular_contacto = :telefono, 
            fecha_nacimiento = :fecha WHERE id_alumno = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":carnet"=>$carnet,":tutor"=>$tutor,":telefono"=>$contacto,":fecha"=>$fecha,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarAlumno($id){
            $sql = "DELETE FROM alumno WHERE id_alumno = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function agregarRapidoalumnoNombre($nombre){
            $sql = "INSERT INTO alumno(nombre_alumno) VALUES(:nom);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre));
            if($res == 1 || $res == true){
                $res = $this->connexion_bd->lastInsertId();
                $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
                $sentenceSQL->closeCursor();
                return $string;
            }else{
                $sentenceSQL->closeCursor();
                return $res;
            }
        }

        public function agregarRapidoalumno($nombre,$numero){
            $sql = "INSERT INTO alumno(nombre_alumno,telefono_alumno) VALUES(:nom,:telef);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":telef"=>$numero));
            if($res == 1 || $res == true){
                $res = $this->connexion_bd->lastInsertId();
                $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
                $sentenceSQL->closeCursor();
                return $string;
            }else{
                $sentenceSQL->closeCursor();
                return $res;
            }
        }

        public function getListaAlumnoNoInscritos($id){
            $sql = "SELECT id_alumno, nombre_alumno, carnet_alumno, fecha_nacimiento nombre_tutor, celular_contacto, 
            DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),fecha_nacimiento)), '%Y')+0 AS edad FROM alumno 
            WHERE id_alumno NOT IN (SELECT id_alumno FROM gestion_curso WHERE id_curso = :id);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
    } 

?>