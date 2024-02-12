<?php 
    session_start();

    $id = $_POST['id'];
    require '../conexion/conexion.php';
    $foto = $_FILES['nfoto'];
    echo $foto['tmp_name'];
    $directorio_destino = "images";
    $directorio_destino2 = "../usuarios/";
    $directorio_destino3 = "../usuarios/";

    $tmp_name = $foto['tmp_name']; 
        $img_file = $foto['name'];
        $img_type = $foto['type'];
        echo 1;
        // Si se trata de una imagen   
        if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
        strpos($img_type, "jpg")) || strpos($img_type, "png")))
        {
            //¿Tenemos permisos para subir la imágen?
            echo 2;
            $destino3 = $directorio_destino3 . 'images/' .  $img_file;
            mysqli_query($mysqli, "UPDATE usuarios SET foto1 = '$destino3' WHERE id = '$id';");
            $destino = $directorio_destino2 . 'images/' .  $img_file;
            mysqli_query($mysqli, "UPDATE usuarios SET foto2 = '$destino' WHERE id = '$id';");
            $destino = $directorio_destino . '/' .  $img_file;
            (move_uploaded_file($tmp_name, $destino))
?>
<script type="text/javascript">
    window.location = "usuarios_nuevos.php";
</script>
<?php  
}
?>