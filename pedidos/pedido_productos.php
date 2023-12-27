<?php

include '../conexion/conexion.php';
// consulta ingreso pedido detalles a base datos    
if(isset($_POST['codigo_recibo_detalle'])){
            
    if(strlen($_POST['codigo_recibo_detalle']) >= 1 && strlen($_POST['detalle_producto']) >= 1 && strlen($_POST['detalle_cantidad']) >= 1 && strlen($_POST['detalle_precio']) >= 1){

        $recibo = trim($_POST['codigo_recibo_detalle']);
        $producto = trim($_POST['detalle_producto']);
        $cantidad = trim($_POST['detalle_cantidad']);
        $precio = trim($_POST['detalle_precio']);
        $estado = trim($_POST['detalle_estado']);
        
        
        $consulta = "   INSERT INTO pedido_detalle(codigo_recibo_detalle, detalle_producto, detalle_cantidad, detalle_precio, detalle_estado) 
                        VALUES ('$recibo','$producto','$cantidad','$precio','$estado')";
        
        $resultado = mysqli_query($mysqli,$consulta);
        
        if($resultado){
            
            header('location:pedido_mesa.php?mensaje=guardado1')
            ?>
            <h3 class="ok">Registro guardado </h3>

            <?php                                
        } else {header('location:pedido_mesa.php?mensaje=falta1')
            ?>
            
            <h3 class="bad">Registro no guardado</h3>
            
            <?php
            } 
        } else {header('location:pedido_mesa.php?mensaje=nada1')
            ?>
            
            <h3 class="bad">ingrese los datos</h3>
            <?php 
    }
        
}


?>