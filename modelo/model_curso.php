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
            $sql = "SELECT curso.id_curso, nombre_profesor,nombre_curso, fecha_inicio, fecha_final, horario_entrada, horario_salida, precio_curso, grupo_curso,
            count(gestion_curso.id_curso) as cantidad_alumnos FROM curso LEFT JOIN gestion_curso ON curso.id_curso = gestion_curso.id_curso group by (curso.id_curso);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function getListaCursoInscripcion(){
            $sql = "SELECT id_curso, nombre_curso FROM curso;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }

        public function agregarCurso($nombre,$precio,$nomProfesor,$grupo,$entrada,$salida,$fechaEntrada,$fechaSalida){
            $sql = "INSERT INTO curso(nombre_curso, precio_curso, nombre_profesor, grupo_curso, horario_entrada, horario_salida, fecha_inicio, fecha_final) 
            VALUES(:nom,:precio,:profesor,:grupo,:horaEntrada,:horaSalida,:fechaInicio,:fechaFinal);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nom"=>$nombre,":precio"=>$precio,":profesor"=>$nomProfesor,":grupo"=>$grupo,":horaEntrada"=>$entrada,
            ":horaSalida"=>$salida,":fechaInicio"=>$fechaEntrada,":fechaFinal"=>$fechaSalida));
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

        public function agregarNuevosAlumnos($listaAlumnosNuevos,$idCurso,$fecha){
            $sql = "INSERT INTO gestion_curso(id_alumno, id_curso, fecha_inscripcion) VALUES(:idAlumno,:idCurso,:fecha);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            foreach ($listaAlumnosNuevos as $idAlumno) {
                $res = $sentenceSQL->execute(array(":idAlumno"=>$idAlumno,":idCurso"=>$idCurso,":fecha"=>$fecha));
                echo $res."\n";
            }
            $sentenceSQL->closeCursor();
            return $res;
        }


        public function eliminarAlumnosCurso($listaAlumnosNuevos,$idCurso){
            $sql = "DELETE FROM gestion_curso WHERE id_alumno = :idAlumno AND id_curso = :idCurso;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            foreach ($listaAlumnosNuevos as $idAlumno) {
                $res = $sentenceSQL->execute(array(":idAlumno"=>$idAlumno,":idCurso"=>$idCurso));
                var_dump($res);
            }
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarCurso($id){
            $sql = "DELETE FROM curso WHERE id_curso = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function listaAlumnosCursoGrupo($idCurso){
            $sql = "SELECT alumno.id_alumno, nombre_alumno, carnet_alumno, DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),fecha_nacimiento)), '%Y')+0 AS edad, 
            fecha_nacimiento FROM alumno INNER JOIN gestion_curso ON alumno.id_alumno = gestion_curso.id_alumno WHERE id_curso = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$idCurso));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
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