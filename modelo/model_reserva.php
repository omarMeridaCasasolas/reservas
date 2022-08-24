<?php 
    require_once("conexion.php");
    ob_clean();
    class Reserva extends Conexion{
        private $sentenceSQL;
        public function Reserva(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL = null;
            $this->connexion_bd = null;
        }
        public function insertarReserva($idCancha,$fechaReserva,$diaReserva,$precioReserva,$hora,$estadoReserva,$limite){
            $sql = "INSERT INTO reserva(id_cancha, fecha_reserva, dia_reserva, precio_hora, hora_reserva, estado_reserva, hora_limite) 
            VALUES (:id, :fecha, :dia, :precio, :hora , :estado, :limite);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$idCancha,":fecha"=>$fechaReserva,":dia"=>$diaReserva,":precio"=>$precioReserva,
            ":hora"=>$hora ,":estado"=>$estadoReserva,":limite"=>$limite));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function getReservaSemana($fechaInicio,$fechaFinal){
            $sql = "SELECT id_reserva, dia_reserva, id_cancha, id_empleado, id_cliente, fecha_reserva, precio_hora, TIME_FORMAT(hora_reserva, '%H:%i') as hora_reserva, 
            estado_reserva, id_curso, id_evento, tipo_reserva, TIME_FORMAT(hora_limite, '%H:%i') as hora_limite FROM reserva WHERE fecha_reserva between :inicio AND :fin order by fecha_reserva;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":inicio"=>$fechaInicio,":fin"=>$fechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }

        public function obtenerReservasGeneradas($fechaInicio,$fechaFinal){
            $sql = "SELECT nombre_cliente, sum(precio_hora) AS total, count(reserva.id_cliente) AS total_hora FROM reserva  
            INNER JOIN cliente ON cliente.id_cliente = reserva.id_cliente WHERE fecha_reserva between :inicio AND :final 
            AND reserva.id_cliente IS NOT NULL group by(reserva.id_cliente) ORDER BY total DESC;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":inicio"=>$fechaInicio,":final"=>$fechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }

        public function getReserva($idReserva){
            $sql = "SELECT id_reserva, dia_reserva, id_cancha, id_empleado, id_cliente, fecha_reserva, precio_hora, TIME_FORMAT(hora_reserva, '%H:%i') as hora_reserva, 
            estado_reserva, id_curso, id_evento, tipo_reserva from reserva WHERE id_reserva = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$idReserva));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            if(count($respuesta) >= 1){
                return $respuesta[0];
            }else{
                return "Error de obtenr reserva";
            }
            // return json_encode($respuesta[0], JSON_PRETTY_PRINT);
        }

        public function agregarReserva($idReserva,$idCliente){
            $sql = "UPDATE reserva SET id_cliente = :cliente, estado_reserva = 'reservado' WHERE id_reserva = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":cliente"=>$idCliente,":id"=>$idReserva));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function getHorarioContinuo($id){
            $sql = "SELECT id_reserva, TIME_FORMAT(hora_reserva, '%H:%i') as hora_reserva, estado_reserva, precio_hora FROM reserva WHERE id_reserva >= :id AND estado_reserva = 
            'disponible' AND fecha_reserva = (SELECT fecha_reserva FROM reserva WHERE id_reserva = :id);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$id));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }

        public function reservaCancha30min($value,$fechaSalida,$timeReserva,$idCurso){
            $sql = "SELECT reservaFechas(:fechaEntrada,:fechaSalida,:horaReserva,:idCurso);";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":fechaEntrada"=>$value,":fechaSalida"=>$fechaSalida,":horaReserva"=>$timeReserva,":idCurso"=>$idCurso));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function listaReservaSemanaEdit($fechaInicio,$fechaFinal,$idCurso){
            $sql = "SELECT DISTINCT(fecha_reserva) FROM reserva WHERE fecha_reserva BETWEEN :fechaInicio AND :fechaFinal AND id_curso = :id;";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":fechaInicio"=>$fechaInicio,":fechaFinal"=>$fechaFinal,":id"=>$idCurso));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta, JSON_PRETTY_PRINT);
        }

        public function reservaPorJuegoDeportivo($idCliente,$costoReserva,$pagoDigital,$pagoEfectivo,$reservaInicio,$reservaFinal,$ident){
            $sql = "CALL reservaPorJuegoDeportivo(:idCliente,:costoReserva,:pagoDigital,:pagoEfectivo,:reservaInicio,:reservaFinal,:ident)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":idCliente"=>$idCliente,":costoReserva"=>$costoReserva,":pagoDigital"=>$pagoDigital,
            ":pagoEfectivo"=>$pagoEfectivo,":reservaInicio"=>$reservaInicio,":reservaFinal"=>$reservaFinal,":ident"=>$ident));
            $sentenceSQL->closeCursor();
            return json_encode($res, JSON_PRETTY_PRINT);
        }

    } 

?>