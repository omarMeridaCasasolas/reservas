
<?php
    //obtencion del archivo
    session_start();
    require_once("../modelo/model_modeloEvento.php");
    ob_clean();
    if(isset($_POST['metodo'])){
        $metodo = $_POST['metodo'];
        $modeloEvento = new ModeloEvento();
        $res = "No hay metodo"; 
        switch ($metodo) {
            case 'getListaModeloEventos':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $res = $modeloEvento->getListaModeloEventos();
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'getTareasTipoEvento':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $idTipoEvento = $_REQUEST['idTipoEvento'];
                    $res = $modeloEvento->getTareasTipoEvento($idTipoEvento);
                }else{
                    $res = "Error de autentificacion";
                }
                break;
            case 'agregarTipoEvento':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $nombre = $_REQUEST['nombre']; 
                    $precio = $_REQUEST['precio'];
                    $tiempo = $_REQUEST['tiempo'];
                    $idTipoEvento = $modeloEvento->agregarTipoEvento($nombre,$precio,$tiempo);
                    $listaIDTareas = json_decode($_REQUEST['idTareas']);
                    foreach ($listaIDTareas as $value) {
                        $aux = $modeloEvento->asignarTareaTipoEvento($value,$idTipoEvento);
                        if($aux == "1"){
                            $res = 1;
                        }else{
                            $res = $aux;
                            break;
                        }
                    }
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'actualizarModeloEventoTareas':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $nombre = $_REQUEST['nombre']; 
                    $precio = $_REQUEST['precio'];
                    $tiempo = $_REQUEST['tiempo'];
                    $listaIDTareas = json_decode($_REQUEST['idTareas']);
                    $aux = $modeloEvento->actualizarModeloEventoTareas($id,$nombre,$precio,$tiempo);
                    if($aux == "1"){
                        $aux = $modeloEvento->eliminarModeloTarea($id);
                        if($aux == "1"){
                            foreach ($listaIDTareas as $value) {
                                $aux = $modeloEvento->asignarTareaTipoEvento($value,$id);
                                if($aux == "1"){
                                    $res = 1;
                                }else{
                                    $res = $aux;
                                    break;
                                }
                            }
                        }else{
                            $res = $aux;
                        }
                    }else{
                        $res = $aux;
                    }
                }else{
                    $res = "Error de autentificacion";
                }
                break; 
            case 'eliminarModeloEvento':
                if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
                    $id = $_REQUEST['id']; 
                    $aux = $modeloEvento->eliminarModeloTarea($id);
                    if($aux == "1"){
                        $res = $modeloEvento->eliminarModeloEvento($id);
                    }else{
                        $res = $aux;
                    }
                    
                }else{
                    $res = "Error de autentificacion";
                }
                break;
                
            // case 'agregarRapidomodeloEventoNombre':
            //     if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
            //         $nombre = $_REQUEST['nombre']; 
            //         $res = $modeloEvento->agregarRapidomodeloEventoNombre($nombre);
            //     }else{
            //         $res = "Error de autentificacion";
            //     }
            //     break;
            // case 'agregarRapidomodeloEvento':
            //     if(isset($_SESSION['usuario']) && ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico')){
            //         $nombre = $_REQUEST['nombre'];
            //         $numero = $_REQUEST['numero'];
            //         $res = $modeloEvento->agregarRapidomodeloEvento($nombre,$numero);
            //     }else{
            //         $res = "Error de autentificacion";
            //     }
            //     break;
            default:
                # code...
                break;
        }
        $modeloEvento->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener variables";
    }