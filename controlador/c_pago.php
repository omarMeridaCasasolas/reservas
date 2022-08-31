
<?php
    //obtencion del archivo
    session_start();
    date_default_timezone_set('America/La_Paz');
    require_once("../modelo/model_pago.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $pago = new Pago();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaPagosGrupo':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id'];
                    $fecha = date('Y-m-d');
                    $res = $pago->getListaPagosGrupo($id,$fecha);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'listaDePagosAlumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id'];
                    $res = $pago->listaDePagosAlumno($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'registrarPagoCurso':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = trim($_REQUEST['id']);
                    $pagoDigital = $_REQUEST['pagoDigital'];
                    $pagoEfectivo = $_REQUEST['pagoEfectivo'];
                    $total = floatval($pagoDigital) + floatval($pagoEfectivo);
                    $fecha = date('Y-m-d');
                    $res = $pago->registrarPagoCurso($pagoDigital,$pagoEfectivo,$total,$id,$fecha);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'eliminarAlumnoGrupo':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = trim($_REQUEST['id']);
                    $res = $pago->eliminarAlumnoGrupo($id);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarAlumnoClase':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idAlumno = trim($_REQUEST['alumno']);
                    $idGrupo = trim($_REQUEST['grupo']);
                    $pagoDigital = trim($_REQUEST['pagoDigital']);
                    $pagoEfectivo = trim($_REQUEST['pagoEfectivo']);
                    $fecha = date('Y-m-d');
                    $total = floatval($pagoDigital) + floatval($pagoEfectivo);
                    if($total > 0){
                        $res = $pago->agregarAlumnoClase($idAlumno,$idGrupo,$fecha,$total);
                        // var_dump($res);
                        if(is_numeric($res)){
                            $res = $pago->registrarPago($res,$pagoDigital,$pagoEfectivo,$fecha,$total);
                        }
                    }else{
                        $res = $pago->agregarAlumnoClaseSinPago($idAlumno,$idGrupo,$fecha);
                    }
                    
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            default:
                # code...
                break;
        }
        $pago->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }