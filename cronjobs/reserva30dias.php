<?php
    require_once('../modelo/model_reserva.php');
    reserva(92);
    function reserva($dias){
        $reserva = new Reserva();
        $idCancha = 1;
        $hora = 9;
        $precio = 85;
        $today = getdate();
        var_dump($today);
        for($i=0;$i<$dias;$i++){
            $intDia = $today['wday'];
            // var_dump($intDia);
            $fecha = date($today['year']."-".$today['mon']."-".$today['mday']);
            if($intDia == 0){
                // echo "Es domingo\n";
                for($j = 9; $j< 23 ;$j++){
                    if($j<14){
                        $hora = $j.":00";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":29");
                        // agregar media hora
                        $hora = $j.":30";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":59");
                    }
                    else{
                        $hora = $j.":00";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'mantenimiento',$j.":29");
                        // agregar media hora
                        $hora = $j.":30";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'mantenimiento',$j.":59");
                    }

                }
            }else{
                if($intDia <= 5){
                    // echo "Es un dia laboral entre lun-viernes\n";
                    for($j = 9; $j< 23 ;$j++){
                        $hora = $j.":00";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":29");
                        $hora = $j.":30";
                        $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":59");
                    }
                }else{
                    // for($j = 9; $j< 20 ;$j++){
                    //     $hora = $j.":00";
                    //     $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":29");

                    //     $hora = $j.":30";
                    //     $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":59");
                    // }
                    // echo "Es sabado\n";
                    for($j = 9; $j< 23 ;$j++){
                        if($j<20){
                            $hora = $j.":00";
                            $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":29");
                            // agregar media hora
                            $hora = $j.":30";
                            $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'disponible',$j.":59");
                        }
                        else{
                            $hora = $j.":00";
                            $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'mantenimiento',$j.":29");
                            // agregar media hora
                            $hora = $j.":30";
                            $reserva->insertarReserva($idCancha,$fecha,convDiasSemana($today['weekday']),$precio,$hora,'mantenimiento',$j.":59");
                        }
                    }
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