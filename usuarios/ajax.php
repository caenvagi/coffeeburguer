<?php

    require '../conexion/conexion5.php';

    session_start();

    $id     = $_SESSION['id'];
    
// cambiarcontraseña
    if($_POST['action'] == 'changePassword'){
        if(!empty($_POST['passActual']) && !empty($_POST['passNuevo']))
        {
            $password   = md5($_POST['passActual']);
            $newPass    = md5($_POST['passNuevo']);
            $id = $_SESSION['id'];           

            $code       =   '';
            $msg        =   '';
            $arrData    =   array();

            $query_user = mysqli_query($conexion," SELECT * 
                                                    FROM usuarios
                                                    WHERE clave = '$password' and id = $id");
            
            $result = mysqli_num_rows($query_user);
            if($result > 0)
            {
                $query_update = mysqli_query($conexion,"UPDATE usuarios SET clave = '$newPass' WHERE id = '$id'");
                mysqli_close($conexion);

                if($query_update){
                    $code = '00';
                    $msg = "Su contraseña se ha actualizado con exito.";
                }else{
                    $code = '2';
                    $msg = "No es posible cambiar la contraseña.";
                }
            }else{
                $code = '1';
                $msg = "La contraseña actual es incorrecta.";
            }
            $arrData = array('cod' => $code, 'msg' => $msg);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);

        }else{
            echo "error";
        }
        exit;
    }
?>

