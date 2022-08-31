<?php 
    require_once("conexion.php");
    ob_clean();
    class Pago extends Conexion{
        private $sentenceSQL;
        public function Pago(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }

        public function getListaproveedor(){
            $sql = "SELECT * from proveedor ORDER BY id_proveedor DESC;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function getListaPagosGrupo($id,$hoy){
            $sql = "SELECT alumno.id_alumno, id_gestion_curso, nombre_alumno, pago_gestion, gestion_curso.fecha_inscripcion, precio_curso, horario_entrada, horario_salida, nombre_curso, 
            timestampdiff(Day,gestion_curso.fecha_inscripcion,:hoy) as cantidad_dias_alumno, timestampdiff(Day,fecha_inicio, fecha_final) as totalDias
            FROM gestion_curso  INNER JOIN alumno ON alumno.id_alumno = gestion_curso.id_alumno INNER JOIN curso ON gestion_curso.id_curso = curso.id_curso 
            WHERE gestion_curso.id_curso = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":hoy"=>$hoy,":id"=>$id));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }
        
        public function agregarAlumnoClase($idAlumno,$idGrupo,$fecha,$total){
            $sql = "INSERT INTO gestion_curso (id_alumno, id_curso, fecha_inscripcion, pago_gestion) VALUES(:alum,:curso,:fecha,:total);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":alum"=>$idAlumno,":curso"=>$idGrupo,":fecha"=>$fecha,":total"=>$total));
            if($res == 1 ){
                $res = $this->connexion_bd->lastInsertId();
            }
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function registrarPago($id,$pagoDigital,$pagoEfectivo,$fecha,$total){
            $sql = "INSERT INTO pago (id_gestion_curso, pago_digital, pago_efectivo, fecha_pago, total_pago) 
            VALUES(:id,:digital,:efectivo,:fecha,:pago);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id,":digital"=>$pagoDigital,":efectivo"=>$pagoEfectivo,":fecha"=>$fecha,":pago"=>$total));
            $sentenceSQL->closeCursor();
            return $res;
        } 

        public function agregarAlumnoClaseSinPago($idAlumno,$idGrupo,$fecha){
            $sql = "INSERT INTO gestion_curso(id_alumno, id_curso, fecha_inscripcion) VALUES(:alum,:curso,:fecha);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":alum"=>$idAlumno,":curso"=>$idGrupo,":fecha"=>$fecha));
            $sentenceSQL->closeCursor();
            return $res;
        } 

        public function listaDePagosAlumno($id){
            $sql = "SELECT * FROM pago WHERE id_gestion_curso = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function registrarPagoCurso($pagoDigital,$pagoEfectivo,$total,$id,$fecha){
            $sql = "CALL registrarPagoCurso(:efectivo, :digital, :total, :id, :fecha);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":efectivo"=>$pagoEfectivo,":digital"=>$pagoDigital,":id"=>$id,":total"=>$total,":fecha"=>$fecha));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarAlumnoGrupo($id){
            $sql = "CALL eliminarAlumnoGrupo(:id);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }
    }

?>
