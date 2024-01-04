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
        
        $query_mesa = " SELECT  	pedido_fecha,
                                    codigo_recibo,
                                    detalle_mesa,                             
                                    detalle_estado,
                                    pedido_mesero,
                                    pedido_mesero_nombre,
                                    mesas_tipo_pedido,
                                    COUNT(PD.detalle_cantidad) AS totalcant,
                                    sum(detalle_cantidad * detalle_precio) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                        INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id                       
                        group by    codigo_recibo_detalle
                        order by    codigo_recibo  DESC
                                                ";
        $mesas = $mysqli->query($query_mesa);
        // fin consultas       
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require '../logs/head.php'; ?>
        <script src="../js/mensajes.js"></script>
       <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    </head>
    <body>
        <?php require '../logs/nav-bar.php'; ?>
        <div id="layoutSidenav_content" class="layoutSidenav" >
                <main>
                    <div class="card-header bg-secondary mt-1"><font color="white">CAJA</font></div>
                        <div class="table-responsive m-2" >
                            <table id="example" class="table display table-sm table-striped table-hover table-bordered" style="width:100% ; text-align: center;">
                                <thead class="table-success">
                                    <tr>
                                        <th>FECHA Y HORA</th>
                                        <th>FACTURA</th>
                                        <th>ATENDIDO</th>
                                        <th>MESA</th>
                                        <th>CANT</th>
                                        <th>TOTAL</th>
                                        <th>ESTADO</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody style="width:100% ; text-align: center;">
                                <?php while ($fila = $mesas->fetch_array()) {
                                                $fecha = $fila['pedido_fecha'];
                                                $codRec = $fila['codigo_recibo'];
                                                $mesero = $fila['pedido_mesero'];
                                                $mesero1 = $fila['pedido_mesero_nombre'];

                                                $tipo_pedido = $fila['mesas_tipo_pedido'];
                                                    if ($tipo_pedido == 'LOCAL') {
                                                    $label_class1 = 'fas fa-utensils';
                                                    } elseif ($tipo_pedido == 'DOMICILIO') {
                                                    $label_class1 = "fas fa-motorcycle" ;
                                                    } elseif ($tipo_pedido == 'por entregar') {
                                                    $label_class1 = 'badge bg-primary badge';
                                                    }
                                                    
                                                $idmesas = $fila['detalle_mesa'];
                                                $totalcant = $fila['totalcant'];
                                                $total = $fila['total']; 
                                                    
                                                $estado = $fila['detalle_estado'];
                                                if ($estado == 'cerrada') {
                                                $label_class = 'badge bg-danger';
                                                } elseif ($estado == 'abierta') {
                                                $label_class = "badge bg-success" ;
                                                } elseif ($estado == 'por entregar') {
                                                $label_class = 'badge bg-primary badge';
                                                }
                                ?>
                                    <tr>
                                        <td><?php echo $fecha; ?></td>
                                        <td><?php echo $codRec; ?></td>
                                        <td><?php echo $mesero1; ?></td>
                                        <td><?php echo $idmesas; ?></td>
                                        <td><?php echo $totalcant; ?></td>
                                        <td>$&nbsp;<?php echo number_format($total, 0, ",", "."); ?></td>
                                        <td><span class="label <?php echo $label_class; ?>" style="font-size:18px"><?php echo $estado; ?></span></td>
                                        <td><span class="label <?php echo $label_class1; ?>" style="font-size:20px"></span>&nbsp;&nbsp;<?php echo $tipo_pedido; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="table-success">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                </tfoot>                               
                            </table> 
                        </div>
                    </main>            
            <?php require '../logs/nav-footer.php'; ?>
        </div>
    </body>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#example');
        }) ;       
    </script>
</html>