<?php
include('database.php');

$mesas = $_GET['pedido_mesa'];
$producto_id = $_GET['producto_id'];
$codigo_recibo_detalle = $_GET['codigo_recibo_detalle'];

if(isset($_GET['producto_id'])){

$query = "  DELETE FROM pedido_detalle
            WHERE codigo_recibo_detalle = $codigo_recibo_detalle and detalle_producto = $producto_id";

$result = mysqli_query($connection,$query);

    if(!$result){
        die(' la consulta a fallado');
    } 
    header("location:pedido_mesa.php?pedido_mesa=$mesas");
}
?>