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

        date_default_timezone_set('America/Bogota');

        echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
        echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>"; 

       // error_reporting(0);

    // consultas
        include '../conexion/conexion.php'; 
        
        $query_mesa = " SELECT  	codigo_recibo,
                                    detalle_mesa,                             
                                    detalle_estado,
                                    pedido_mesero,
                                    pedido_mesero_nombre,
                                    COUNT(PD.detalle_cantidad) AS totalcant,
                                    sum(detalle_cantidad * detalle_precio) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle
                        WHERE       detalle_estado = 'abierta'
                        group by    codigo_recibo_detalle
                        order by    detalle_mesa;
                                                ";
        $mesas = $mysqli->query($query_mesa);
        // fin consultas       
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require '../logs/head.php'; ?>
        <script src="../js/mensajes.js"></script>
    </head>
    <body>
        <?php require '../logs/nav-bar.php'; ?>
        <div id="layoutSidenav_content" class="layoutSidenav" >
                <main>
                    <div class="card-header BG-WARNING mt-1"><font color="white">PEDIDOS</font></div>
                        <div class="rows" >
                            <?php while ($fila = $mesas->fetch_array()) {
                                            $codRec = $fila['codigo_recibo'];
                                            $totalcant = $fila['totalcant'];
                                            $total = $fila['total'];
                                            $mesero = $fila['pedido_mesero'];
                                            $mesero1 = $fila['pedido_mesero_nombre'];
                                            $idmesas = $fila['detalle_mesa'];
                                                                                          
                                            $estado = $fila['detalle_estado'];
                                            if ($estado == 'cerrada') {
                                            $label_class = 'badge bg-danger';
                                            } elseif ($estado == 'abierta') {
                                            $label_class = "badge bg-success" ;
                                            } elseif ($estado == 'por entregar') {
                                            $label_class = 'badge bg-primary badge';
                                            }
                            ?>
                            <div class="card-body border m-2 p-0 justify-content-center align-items-center" style="text-align: center">
                                <br>
                                <span class="material-icons" id="tenedor">restaurant</span>
                                <br>
                                <p style="font-size:24px">Mesa:&nbsp;<?php echo $idmesas;?></p>
                                <span class="label <?php echo $label_class; ?>" style="font-size:18px"><?php echo $estado; ?></span>
                                <p>productos servidos:&nbsp;&nbsp;<?php echo $totalcant;?></p>
                                <h4>$&nbsp;<?php echo  number_format($total, 0, ",", ".");?></h4>
                                <p>Atendido por:&nbsp;&nbsp;<?php echo $mesero1;?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </main>            
            <?php require '../logs/nav-footer.php'; ?>
        </div>
    </body>
    <script>
    </script>
</html>