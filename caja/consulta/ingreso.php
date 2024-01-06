<?php
include '../../conexion/conexion.php';

            if($_REQUEST['inlineRadioOptions'] == "INGRESO"){

                if(isset($_POST['register'])){

                    if(strlen($_POST['fecha_movimiento']) >= 1 && strlen($_POST['usuario']) && strlen($_POST['movimiento']) && strlen($_POST['desc_movimiento']) && strlen($_POST['valor'])  && strlen($_POST['user_login'])){

                        // $fecha = date("y/m/d/H/i/s");
                        $fecha = trim($_POST['fecha_movimiento']);
                        $usuario = trim($_POST['usuario']);
                        $movimiento = trim($_POST['movimiento']);
                        $desc_movimiento = trim($_POST['desc_movimiento']);
                        $valor_ingreso = trim($_POST['valor']);
                        $valor_egreso =  trim("0");
                        $user_login = trim($_POST['user_login']);
                        $liquidado = trim($_POST['liquidado']);  
                        
                        $consulta = "   INSERT INTO caja(fecha_movimiento, usuario, movimiento, desc_movimiento, valor_ingreso, valor_egreso, user_login, liquidado) 
                                        VALUES ('$fecha','$usuario','$movimiento','$desc_movimiento','$valor_ingreso','$valor_egreso','$user_login','$liquidado')";
                        $resultado = mysqli_query($mysqli,$consulta);
                        
                        if($resultado){
                            header('location:../caja_ingresos.php?mensaje=guardado')
                            ?>
                            <h3 class="ok">Registro guardado </h3>

                            <?php                                
                        } else {header('location:../caja_ingresos.php?mensaje=falta')
                            ?>
                            
                            <h3 class="bad">Registro no guardado</h3>
                            
                            <?php
                        } 
                        } else {header('location:../caja_ingresos.php?mensaje=nada')
                            ?>
                            
                            <h3 class="bad">ingrese los datos</h3>
                            <?php 
                    }
                        
                }

  }else if($_REQUEST['inlineRadioOptions'] == "EGRESO"){

    if(isset($_POST['register'])){

        if(strlen($_POST['fecha_movimiento']) >= 1 && strlen($_POST['usuario']) && strlen($_POST['movimiento']) && strlen($_POST['desc_movimiento']) && strlen($_POST['valor'])  && strlen($_POST['user_login'])){

            // $fecha = date("y/m/d/H/i/s");
            $fecha = trim($_POST['fecha_movimiento']);
            $usuario = trim($_POST['usuario']);
            $movimiento = trim($_POST['movimiento']);
            $desc_movimiento = trim($_POST['desc_movimiento']);
            $valor_ingreso = trim("0");
            $valor_egreso = trim($_POST['valor']);
            $user_login = trim($_POST['user_login']);
            $liquidado = trim($_POST['liquidado']);  
            
            $consulta = "   INSERT INTO caja(fecha_movimiento, usuario, movimiento, desc_movimiento, valor_ingreso, valor_egreso, user_login, liquidado) 
                            VALUES ('$fecha','$usuario','$movimiento','$desc_movimiento','$valor_ingreso','$valor_egreso','$user_login','$liquidado')";
            $resultado = mysqli_query($mysqli,$consulta);
            
            if($resultado){
                header('location:../caja_ingresos.php?mensaje=guardado')
                ?>
                <h3 class="ok">Registro guardado </h3>

                <?php                                
            } else {header('location:../caja_ingresos.php?mensaje=falta')
                ?>
                
                <h3 class="bad">Registro no guardado</h3>
                
                <?php
            } 
            } else {header('location:../caja_ingresos.php?mensaje=nada')
                ?>
                
                <h3 class="bad">ingrese los datos</h3>
                <?php 
        }
            
    }
  }
   