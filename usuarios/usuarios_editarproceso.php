<?php

print_r($_POST);
    if(!isset($_POST['editar'])){
        header('location: usuarios_nuevos.php?mensaje=error');
    }

    include '../conexion/conexion3.php';

    $id = $_POST['id'];
    $cargo = $_POST['cargo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $activo = $_POST['activo'];    
    
    $sentencia = $bd->prepare(" UPDATE  usuarios 
                                SET     tipo_cargo=?,direccion=?,telefono=?,email=?,activo=?
                                WHERE   id = ?;");
    $resultado = $sentencia->execute([$cargo,$direccion,$telefono,$email,$activo,$id]);

    if($resultado === TRUE){
        header('location: usuarios_nuevos.php?mensaje=editado');

    }    else {
        header('location: usuarios_nuevos.php?mensaje=falta');

    }
?>