<?php
include('database.php');

$mesas = $_GET['pedido_mesa'];
$recibo = $_GET['codigo_recibo'];

$fecha = $_POST['caja_fecha'];
$mesero = $_POST['caja_usuario'];
$movimiento = $_POST['caja_movimiento'];
$desc_movimiento = $_POST['caja_desc_movimiento'];
$ingreso = $_POST['caja_ingresos'];
$egresos = $_POST['caja_egresos'];
$user_login = $_POST['user_login'];
$liquidado = $_POST['liquidado'];
$tipo = $_POST['caja_tipo'];


// echo $mesas;
// echo $recibo;

if(isset($_GET['pedido_mesa'])){
$query = "UPDATE mesa SET mesas_estado = 'cerrada' where mesas_id = $mesas";
$result = mysqli_query($connection,$query);

$query1 = "UPDATE pedidos SET pedido_estado = 'cerrada' where codigo_recibo = $recibo";
$result1 = mysqli_query($connection,$query1);

$query2 = "UPDATE pedido_detalle SET detalle_estado = 'cerrada' where codigo_recibo_detalle = $recibo";
$result2 = mysqli_query($connection,$query2);

$query3 = "  INSERT INTO caja    (fecha_movimiento , usuario , movimiento , desc_movimiento , valor_ingreso , valor_egreso , user_login , liquidado , caja_tipo)
                VALUES          ('$fecha','$mesero','$movimiento','$desc_movimiento','$ingreso','$egresos','$user_login','$liquidado','$tipo')";
$result3 = mysqli_query($connection,$query3);



    if(!$result1){
        die(' la consulta a fallado');
    } 

    header("location:pedido_abierto.php");
}
?>