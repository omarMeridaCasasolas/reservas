
<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_alumno.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $alumno = new Alumno();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaAlumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $alumno->getListaAlumno();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarAlumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = trim($_REQUEST['nombre']); 
                    $carnet = trim($_REQUEST['carnet']);
                    $nombreTutor = trim($_REQUEST['nombreTutor']);
                    $contacto = trim($_REQUEST['contacto']);
                    $fecha = trim($_REQUEST['fecha']);
                    $curso = trim($_REQUEST['curso']);
                    $aux = $alumno->agregarAlumno($nombre,$carnet,$nombreTutor,$contacto,$fecha);
                    if(is_integer(intval($aux))){
                        if($curso != 'Ninguno'){
                            date_default_timezone_set('America/La_Paz');
                            $fechaInscripcion = date('Y-m-d');
                            $res = $alumno->agregarAlumnoCurso($curso,$aux,$fechaInscripcion);
                        }else{
                            $res = 1;
                        }
                    }else{
                        $res = $aux;
                    }

                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarAlumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = trim($_REQUEST['id']); 
                    $nombre = trim($_REQUEST['nombre']); 
                    $carnet = trim($_REQUEST['carnet']);
                    $fecha = trim($_REQUEST['fecha']);
                    $tutor = trim($_REQUEST['tutor']); 
                    $contacto = trim($_REQUEST['contacto']);
                    $res = $alumno->actualizarAlumno($id,$nombre,$carnet,$fecha,$tutor,$contacto);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminarAlumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = trim($_REQUEST['id']); 
                    $res = $alumno->eliminarAlumno($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
                
            case 'agregarRapidoalumnoNombre':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = trim($_REQUEST['nombre']); 
                    $res = $alumno->agregarRapidoalumnoNombre($nombre);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarRapidoalumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = trim($_REQUEST['nombre']);
                    $numero = trim($_REQUEST['numero']);
                    $res = $alumno->agregarRapidoalumno($nombre,$numero);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            default:
                # code...
                break;
        }
        $alumno->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }