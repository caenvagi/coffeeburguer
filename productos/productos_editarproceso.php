<?php

//print_r($_POST);
    if(!isset($_POST['editar'])){
        header('location: producto_nuevo.php?mensaje=error');
    }

    include '../conexion/conexion3.php';

    $id = $_POST['producto_id'];
    $producto_nombre = $_POST['producto_nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['producto_categoria'];
    $estacion = $_POST['producto_estacion'];  
    
    $sentencia = $bd->prepare(" UPDATE  productos
                                SET     producto_nombre=?,producto_precio=?,producto_cantidad=?,producto_categoria=?,producto_estacion=?
                                WHERE   producto_id = ?;");
    $resultado = $sentencia->execute([$producto_nombre,$precio,$cantidad,$categoria,$estacion,$id]);

    if($resultado === TRUE){
        header('location: producto_nuevo.php?mensaje=editado');

    }    else {
        header('location: producto_nuevo.php?mensaje=falta');

    }

    
?>