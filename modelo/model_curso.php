<?php 
    require_once("conexion.php");
    ob_clean();
    class Curso extends Conexion{
        private $sentenceSQL;
        public function Curso(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaCurso(){
            $sql = "SELECT curso.id_curso, nombre_profesor,nombre_curso, fecha_inicio, horario_curso, count(gestion_curso.id_curso) as cantidad_alumnos
            from curso LEFT JOIN gestion_curso ON curso.id_curso = gestion_curso.id_curso group by (curso.id_curso);";
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

        public function agregaralumno($nombre,$telefono,$detalle){
            $sql = "INSERT INTO alumno(nombre_alumno, telefono_alumno, detalle_alumno) 
            VALUES(:nom,:telef,:detalle);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":telef"=>$telefono,":detalle"=>$detalle));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizaralumno($id,$nombre,$telefono,$detalle){
            $sql = "UPDATE alumno SET nombre_alumno = :nom , detalle_alumno = :detalle, telefono_alumno = :telef 
            WHERE id_alumno = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":detalle"=>$detalle,":telef"=>$telefono,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminaralumno($id){
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
    } 

?>