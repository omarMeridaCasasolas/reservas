<?php
    session_start();
    ob_clean();
    $salida = array('respuesta' => false );
    if(isset($_POST['usuario']) && isset($_POST['pass'])){
        $user = $_POST['usuario'];
        $pass = $_POST['pass'];
        if(strlen($user) <=8 &&  strlen($pass) <=5){
            $salida = '{"respuesta":false}';
        }else{
            require_once('../modelo/model_usuario.php');
            $usuario = new Usuario();
            $res = $usuario->getUsuario($user,$pass);
            // $res = json_decode($aux);
            if(count($res) == 1){
                $_SESSION['usuario'] = $res[0]['usuario_empleado'];
                $_SESSION['pass'] = $res[0]['pass_empleado'];
                $_SESSION['nombre'] = $res[0]['nombre_empleado'];
                $_SESSION['tipo_empleado'] = $res[0]['tipo_empleado'];
                $salida = array('respuesta' => true );
            }else{
                $salida  = array('respuesta' => false );
            }
        }
    }else{
        $salida = array('respuesta' => false );
    }
    header("Content-Type: application/json");
    echo json_encode($salida);