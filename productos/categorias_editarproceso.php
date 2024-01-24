<?php

print_r($_POST);
    if(!isset($_POST['editar'])){
        header('location: producto_categoria.php?mensaje=error');
    }

    include '../conexion/conexion3.php';

    $id = $_POST['categoria_id'];
    $nombre = $_POST['categoria_nombre'];
    $descripcion = $_POST['categoria_descripcion'];
    
    $sentencia = $bd->prepare(" UPDATE  categorias
                                SET     categoria_nombre=?,categoria_descripcion=?
                                WHERE   categoria_id = ?;");
    $resultado = $sentencia->execute([$nombre,$descripcion,$id]);

    if($resultado === TRUE){
        header('location: producto_categoria.php?mensaje=editado');

    }    else {
        header('location: producto_categoria.php?mensaje=falta');

    }
?>