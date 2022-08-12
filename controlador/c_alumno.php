
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
            case 'agregaralumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = trim($_REQUEST['nombre']); 
                    $telefono = trim($_REQUEST['telefono']);
                    $detalle = trim($_REQUEST['detalle']);
                    $res = $alumno->agregaralumno($nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizaralumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = trim($_REQUEST['id']); 
                    $nombre = trim($_REQUEST['nombre']); 
                    $telefono = trim($_REQUEST['telefono']);
                    $detalle = trim($_REQUEST['detalle']);
                    $res = $alumno->actualizaralumno($id,$nombre,$telefono,$detalle);
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminaralumno':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = trim($_REQUEST['id']); 
                    $res = $alumno->eliminaralumno($id);
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