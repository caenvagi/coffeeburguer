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

        // consulta estado de la mesa
            $queryEstados = "   SELECT pedido_estado , pedido_mesa
                                    FROM pedidos ";
            $estadosBtn = $mysqli->query($queryEstados);

        // consulta listado de mesas
            $query_mesa = " SELECT  *
                            FROM mesa AS ME
                            WHERE mesas_tipo_pedido = 'LOCAL' "; 
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
                <div class="card-header BG-WARNING mt-1"><b style="color: white;">PEDIDOS POR MESA</b></div>
                <div class="container">
                    <div class="rows">
                        <?php
                            while ($fila = $mesas->fetch_array()) {                                                        
                                    $idmesas = $fila['mesas_id'];
                                    $nombremesa = $fila['mesas_nombre'];                                               
                                    $estado = $fila['mesas_estado'];
                                    $tipo = $fila['mesas_tipo_pedido'];

                                    if ($estado == 'cerrada') {
                                        $label_class = 'badge bg-danger';
                                    } elseif ($estado == 'abierta') {
                                        $label_class = "badge bg-success" ;
                                    } elseif ($estado == 'por entregar') {
                                        $label_class = 'badge bg-primary badge';
                                    }
                                    ?>
                        <form method="POST" action="pedido_mesa.php?pedido_mesa=<?php echo $idmesas;?>" class="m-0">
                            <input type="hidden" id="pedido_mesero" name="pedido_mesero" value="<?php echo $id; ?>">
                            <input type="hidden" id="pedido_mesero_nombre" name="pedido_mesero_nombre" value="<?php echo $nombre; ?>">
                            <input type="hidden" id="pedido_mesa" name="pedido_mesa" value="<?php echo $idmesas; ?>">
                            <input type="hidden" id="pedido_estado" name="pedido_estado" value="abierta">
                            <input type="hidden" id="pedido_cliente" name="pedido_cliente" value="LOCAL">
                            <input type="hidden" id="pedido_direccion" name="pedido_direccion" value="LOCAL">
                            <input type="hidden" id="pedido_telefono" name="pedido_telefono" value="LOCAL">
                            <input type="hidden" id="pedido_tipo" name="pedido_tipo" value="<?php echo $tipo; ?>">

                            <button value="agregar" id="btn_mesa" name="btn_mesa" type="submit" class="btn btn-outline-dark btn-lg p-2 m-2">
                                <span class="material-icons" id="tenedor">restaurant</span>
                                <br>
                                <p>&nbsp;<?php echo $nombremesa;?></p>
                                <span class="label <?php echo $label_class; ?>"><?php echo $estado; ?></span>
                            </button>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </main>            
            <?php require '../logs/nav-footer.php'; ?>
        </div>
    </body>
</html>