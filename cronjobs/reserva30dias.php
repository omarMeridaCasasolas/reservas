<?php
    require_once('../modelo/model_reserva.php');
    reserva(30);
    function reserva($dias){
        $reserva = new Reserva();
        $idCancha = 1;
        $hora = 9;
        $precio = 90;
        $today = getdate();
        var_dump($today);
        for($i=0;$i<$dias;$i++){
            $intDia = $today['wday'];
            // var_dump($intDia);
            $fecha = date($today['year']."-".$today['mon']."-".$today['mday']);
            if($intDia == 0){
                // echo "Es domingo\n";
                for($j = 9; $j< 14 ;$j++){
                    $hora = $j.":00";
                    $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible');
                }
            }else{
                if($intDia <= 5){
                    // echo "Es un dia laboral entre lun-viernes\n";
                    for($j = 9; $j< 23 ;$j++){
                        $hora = $j.":00";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible');
                    }
                }else{
                    for($j = 9; $j< 20 ;$j++){
                        $hora = $j.":00";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible');
                    }
                    // echo "Es sabado\n";
                }
            }
            //var_dump($fecha);
            $aux = date("Y-m-d", strtotime($fecha.' + 1 days'));
            var_dump($aux);
            $res = strtotime($aux); 
            $today = getdate($res);
            //$today = strtotime("+1 day", strtotime(getdate()));
            // var_dump($today);
        }

    }

    function convDiasSemana($variable){
        $res ="";
        switch ($variable) {
            case 'Monday':
                $res = "lunes";
                break;
            case 'Tuesday':
                $res = "martes";
                break;
            case 'Wednesday':
                $res = "miercoles";
                break;
            case 'Thursday':
                $res = "jueves";
                break;
            case 'Friday':
                $res = "viernes";
                break;
            case 'Saturday':
                $res = "sabado";
                break;    
            default:
                $res = "domingo";
                break;
        }
        return $res;
    }