<?php
include('database.php');

$mesas = $_GET['pedido_mesa'];
$recibo = $_GET['codigo_recibo'];

echo $mesas;
echo $recibo;

if(isset($_GET['pedido_mesa'])){
$query = "UPDATE mesa SET mesas_estado = 'cerrada' where mesas_id = $mesas";
$result = mysqli_query($connection,$query);

$query1 = "UPDATE pedidos SET pedido_estado = 'cerrada' where codigo_recibo = $recibo";
$result1 = mysqli_query($connection,$query1);

$query2 = "UPDATE pedido_detalle SET detalle_estado = 'cerrada' where codigo_recibo_detalle = $recibo";
$result2 = mysqli_query($connection,$query2);


    if(!$result1){
        die(' la consulta a fallado');
    } 

    header("location:pedido_nuevo.php?pedido_mesa=$mesas");
}
?>