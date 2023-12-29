
<?php
include('database.php');

//print_r($_POST);

if(!empty($_POST)){
    if($_POST['mesa']){
        $mesa = $_POST['mesa'];

        $query = "SELECT    codigo_recibo_detalle,
                    detalle_producto,
                    producto_nombre,
                    producto_precio,
                    detalle_cantidad,
                    sum(detalle_cantidad) as totalcant,
                    detalle_precio,
                    sum(detalle_cantidad * producto_precio) as totalprecio,
                    pedido_mesa,
                    detalle_estado
                FROM        pedido_detalle AS PD
                INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                WHERE       detalle_mesa = $mesa and detalle_estado = 'abierta'
                group by    detalle_producto    
        ";
        $result = mysqli_query($connection,$query);

        if(!$result){
            die('consulta fallo'.mysqli_error($connection));
            }
            $json = array();
            while($row = mysqli_fetch_array($result)){ 
                $json[] = array( 
                    'codigo_recibo_detalle' => $row['codigo_recibo_detalle'],
                    'detalle_producto' => $row['detalle_producto'],
                    'producto_nombre' => $row['producto_nombre'],
                    'producto_precio' => $row['producto_precio'],
                    'totalprecio' =>  number_format($row['totalprecio'], 0, ",", "."),
                    'detalle_cantidad' => $row['detalle_cantidad'],
                    'totalcant' => $row['totalcant'],
                    'pedido_mesa' => $row['pedido_mesa'],
                    'detalle_precio' => $row['detalle_precio'],
                    'detalle_estado' => $row['detalle_estado']
                );
            } 
            $jsonstring = json_encode($json);
            echo $jsonstring;      
    }
    exit;
}
exit;

// $query = "SELECT    codigo_recibo_detalle,
//                     detalle_producto,
//                     producto_nombre,
//                     producto_precio,
//                     detalle_cantidad,
//                     sum(detalle_cantidad) as totalcant,
//                     detalle_precio,
//                     sum(detalle_cantidad * producto_precio) as totalprecio,
//                     pedido_mesa,
//                     detalle_estado
//         FROM        pedido_detalle AS PD
//         INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
//         INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
//         WHERE       detalle_mesa = 1 and codigo_recibo_detalle = 12 and detalle_estado = 'abierta'
//         group by    detalle_producto
// ";
// $result = mysqli_query($connection,$query);

// if(!$result){
//     die('consulta fallo'.mysqli_error($connection));
//     }
//     $json = array();
//     while($row = mysqli_fetch_array($result)){ 
//         $json[] = array( 
//             'codigo_recibo_detalle' => $row['codigo_recibo_detalle'],
//             'detalle_producto' => $row['detalle_producto'],
//             'producto_nombre' => $row['producto_nombre'],
//             'producto_precio' => $row['producto_precio'],
//             'totalprecio' => $row['totalprecio'],
//             'detalle_cantidad' => $row['detalle_cantidad'],
//             'totalcant' => $row['totalcant'],
//             'pedido_mesa' => $row['pedido_mesa'],
//             'detalle_precio' => $row['detalle_precio'],
//             'detalle_estado' => $row['detalle_estado']
//         );
//     }
//     $jsonstring = json_encode($json);
//     echo $jsonstring;
    
    
    ?>