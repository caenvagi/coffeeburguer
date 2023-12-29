<?php
include('database.php');

$mesas = $_GET['pedido_mesa'];

if(isset($_POST['codigo_recibo_detalle'])){
    $detRec = $_POST['codigo_recibo_detalle'];
    $detMes = $_POST['detalle_mesa'];
    $detPro = $_POST['detalle_producto'];            
    $detCan = $_POST['detalle_cantidad'];            
    $detPre = $_POST['detalle_precio'];
    $detEst = $_POST['detalle_estado']; 
    
    $query = "  INSERT INTO pedido_detalle(codigo_recibo_detalle,detalle_mesa,detalle_producto,detalle_cantidad,detalle_precio,detalle_estado)
                VALUES                    ('$detRec','$detMes','$detPro','$detCan','$detPre','$detEst')";

    $result = mysqli_query($connection,$query);

    if(!$result){
        die(' la consulta a fallado');
    } 
    header("location:pedido_mesa.php?pedido_mesa=$mesas");           
};

?>