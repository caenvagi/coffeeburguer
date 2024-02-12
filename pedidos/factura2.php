<?php
    // inicio de sesion
        session_start();

        require '../conexion/conexion.php';

        if (!isset($_SESSION['id'])) {
            header("Location: ../index.php");
        }
        $id = $_SESSION['id'];
        $nombre = $_SESSION['nombre'];
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $usuario = $_SESSION['usuario'];

        if ($tipo_usuario == 1) {
            $where = "";
        } else if ($tipo_usuario == 2) {
            $where = "WHERE id=$id";
        }
    //    
    date_default_timezone_set('America/Bogota');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
    
    include '../conexion/conexion.php';

    $registro_id = $_GET['pedido_mesa'];
    $codigo_recibo = $_GET['codigo_recibo'];
    
    // consulta estado de la mesa

    $pedidos1 = $mysqli-> query(" SELECT    codigo_recibo_detalle,
                                            codigo_recibo,
                                            pedido_mesa,
                                            pedido_cliente,
                                            pedido_direccion,
                                            pedido_telefono,
                                            mesas_nombre,
                                            detalle_estado
                                        FROM        pedido_detalle AS PD
                                        
                                        INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                                        INNER JOIN  mesa AS ME ON ME.mesas_id = PD.detalle_mesa
                                        WHERE       pedido_mesa = $registro_id and codigo_recibo_detalle = $codigo_recibo
                                        group by    codigo_recibo
            
                            ") or die($mysqli->error);

    $pedidos2 = $mysqli-> query(" SELECT codigo_recibo_detalle,
                                        codigo_recibo,
                                        producto_id,
                                        detalle_producto,
                                        producto_nombre,
                                        producto_precio,
                                        detalle_cantidad,
                                        sum(detalle_cantidad) as totalcant,
                                        detalle_precio,
                                        sum(detalle_cantidad * producto_precio) as totalprecio,                                       
                                        pedido_mesa,
                                        pedido_cliente,
                                        pedido_direccion,
                                        pedido_telefono,
                                        mesas_nombre,
                                        detalle_estado
                                        FROM        pedido_detalle AS PD
                                        INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                                        INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                                        INNER JOIN  mesa AS ME ON ME.mesas_id = PD.detalle_mesa
                                        WHERE       pedido_mesa = $registro_id and codigo_recibo_detalle = $codigo_recibo
                                        group by    detalle_producto

    ") or die($mysqli->error);

    $pedidos3 = $mysqli-> query(" SELECT 
                                        detalle_cantidad,
                                        sum(detalle_cantidad) as totalcant,
                                        detalle_precio,
                                        sum(detalle_cantidad * producto_precio) as totalprecio                                      
                                       
                                        FROM        pedido_detalle AS PD
                                        INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                                        INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                                        INNER JOIN  mesa AS ME ON ME.mesas_id = PD.detalle_mesa
                                        WHERE       pedido_mesa = $registro_id and codigo_recibo_detalle = $codigo_recibo
                                        

    ") or die($mysqli->error);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../logs/head.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>    
</head>
<body onload="imprimir() ; cerrar()">
    <style>
        table {
            border: #b2b2b2 1px solid;
            
        }
        td, th {
            border: lightgrey 1px solid;
            font-size:10px !important;
        }
        .cabecera{
            font-size:11px !important;
        }
    </style>
    <?php
    
    ?>
 <div class="cabecera">
   
   
        
    <b>Coffee Burguer "Mirador"</b>    
    <br>
    <b>Pedido</b> 
    <br>
    <?php
        while ($fila = $pedidos1->fetch_array()) {

            $mesa = $fila['mesas_nombre'];
            
            $cliente = $fila['pedido_cliente'];
            $direccion = $fila['pedido_direccion'];
            $telefono = $fila['pedido_telefono'];

    ?>
    <H7>Pedido No:</H7>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $codigo_recibo ?>
    <br>
    <H7>Tipo:</H7>&nbsp;&nbsp; <?php echo $mesa ?>
    <br>
    <H7>Cliente:</H7>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente ?>
    <br>
    <H7>Direccion:</H7>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $direccion ?>
    <br>
    <H7>Telefono:</H7>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $telefono ?>
    <br>
    
    <?php } ?>
    </div>
   
    <table >
        <thead>
            <th>Can</th>
            <th style="text-align:center">Prod</th>
            
        </thead>
        <tbody>
        <?php
        while ($fila = $pedidos2->fetch_array()) {            

            $cantidad = $fila['totalcant'];
            $producto = $fila['producto_nombre'];
            $total = $fila['totalprecio'];
            
    ?>
            <tr>
         
                <td style="text-align:center"><?php echo $cantidad ?></td>
                <td><?php echo $producto ?></td>
                
                
            </tr>    
            <?php } ?>
        </tbody>
        <tfoot>
            
            <td><b>Total</b></td>
            <?php
        while ($fila = $pedidos3->fetch_array()) {            

            
            $totalfactura = $fila['totalprecio'];
            
    ?>
            <td><?php echo number_format($totalfactura) ?></td>
            
            <?php } ?>
        </tfoot>
        </tr>
    </table>
    <script>
        function imprimir(){
            if(window.print) window.print()
            else alert ("puede utilizar ctrl p");
            }
         function cerrar(){
            window.onafterprint = function () {
                window.close();
            }
         }   
    </script>
</body>
</html>