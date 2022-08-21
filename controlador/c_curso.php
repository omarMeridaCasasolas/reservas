
<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_curso.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $curso = new Curso();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $curso->getListaCurso();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $precio = $_REQUEST['precio'];
                    $nomProfesor = $_REQUEST['nomProfesor'];
                    $grupo = $_REQUEST['grupo']; 
                    $entrada = $_REQUEST['entrada'];
                    $salida = $_REQUEST['salida'];
                    $fechaEntrada = $_REQUEST['fechaEntrada'];
                    $fechaSalida = $_REQUEST['fechaSalida'];
                    $idCurso = $curso->agregarCurso($nombre,$precio,$nomProfesor,$grupo,$entrada,$salida,$fechaEntrada,$fechaSalida);
                    // if(!is_integer($idCurso)){
                    //     $res = "no es entero";
                    //     break;
                    // }
                    $fechasReserva = json_decode($_REQUEST['fechasReserva']);
                    // $horaInicio = strtotime($entrada.":00");
                    $horaFinal = strtotime($salida.":00");
                    require_once("../modelo/model_reserva.php");
                    $reserva = new Reserva();
                    // var_dump($fechasReserva);
                    foreach ($fechasReserva as $value) {
                        $horaInicio = strtotime($entrada.":00");
                        while($horaInicio < $horaFinal-1){
                            // $res = $res. $horaFinal."\t";
                            $timeReserva = date('h:i:s',$horaInicio);
                            $aux = $reserva->reservaCancha30min($value,$fechaSalida,$timeReserva,$idCurso);
                            // var_dump($aux);
                            if($aux == "1"){
                                $res = 1;
                            }else{
                                $res = $aux;
                                break;
                            }
                            // var_dump(date('h:i:s',$horaInicio));
                            $horaInicio = strtotime("+30 minutes",$horaInicio);
                        }
                        // $aux = $modeloEvento->reservaCancha30min($value,$idCurso,$fechaEntrada,$fechaSalida,$entrada);
                        // if($aux == "1"){
                        //     $res = 1;
                        // }else{
                        //     $res = $aux;
                        //     break;
                        // }
                    }
                    // while($horaInicio < $horaFinal-1){
                    //     // $res = $res. $horaFinal."\t";
                    //     $aux = $curso->reservaCancha30min($value,$idCurso,$fechaEntrada,$fechaSalida,$entrada);
                    //     if($aux == "1"){
                    //         $res = 1;
                    //     }else{
                    //         $res = $aux;
                    //         break;
                    //     }
                    //     var_dump(date('h:i:s',$horaInicio));
                    //     $horaInicio = strtotime("+30 minutes",$horaInicio);
                    //     // var_dump($horaInicio);
                    //     // echo $time = date("m/d/Y h:i:s A T",$unixtime);
                        
                    // }
                    // foreach ($fechasReserva as $value) {
                    //     $aux = $modeloEvento->reservaCancha30min($value,$idCurso,$fechaEntrada,$fechaSalida,$entrada);
                    //     if($aux == "1"){
                    //         $res = 1;
                    //     }else{
                    //         $res = $aux;
                    //         break;
                    //     }
                    // }
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $nombre = $_REQUEST['nombre']; 
                    $telefono = $_REQUEST['telefono'];
                    $detalle = $_REQUEST['detalle'];
                    $res = $curso->actualizarcurso($id,$nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminarCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $res = $curso->eliminarCurso($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
                
            case 'listaAlumnosCursoGrupo':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idCurso = $_REQUEST['idCurso']; 
                    $res = $curso->listaAlumnosCursoGrupo($idCurso);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'actualizarListaAlumnosCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idCurso = $_REQUEST['idCurso'];
                    $listaAlumnosNuevos = json_decode($_REQUEST['listaAlumnosNuevos']);
                    $listaAlumnosEliminados = json_decode($_REQUEST['listaAlumnosEliminados']);
                    $res = 1 ;
                    if(is_array($listaAlumnosNuevos) && count($listaAlumnosNuevos) >= 1){
                        $res = $curso->agregarNuevosAlumnos($listaAlumnosNuevos,$idCurso,date('Y-m-d'));
                    }
                    if(is_array($listaAlumnosEliminados) && count($listaAlumnosEliminados) >= 1){
                        $res = $curso->eliminarAlumnosCurso($listaAlumnosEliminados,$idCurso);
                    }
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'getListaCursoInscripcion':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $curso->getListaCursoInscripcion();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            default:
                # code...
                break;
        }
        $curso->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }