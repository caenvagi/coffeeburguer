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

    // consultas
    include '../conexion/conexion.php';   
    
    $mesa = trim($_POST['mesa']);
    $codRec = trim($_POST['codRecibo']);
    $estado = trim($_POST['BtnEst']);
    
    $queryAct = "UPDATE mesa 
                SET mesas_estado = 'cerrada' 
                where mesas_id = $mesa";
    $pedidos = $mysqli->query($queryAct);

    $queryAct1 = "UPDATE pedidos 
                SET pedido_estado = 'cerrada' 
                where codigo_recibo = $codRec";
    $pedidos1 = $mysqli->query($queryAct1);

    $queryAct2 = "UPDATE pedido_detalle
        SET detalle_estado = 'cerrada' 
        where codigo_recibo_detalle = $codRec";
    $pedidos2 = $mysqli->query($queryAct2);

        // consulta estadoS de la mesa
            $queryEstados = "   SELECT pedido_estado
                                FROM pedidos
                    
            ";
            $estadosBtn = $mysqli->query($queryEstados);        

        // consulta listado de mesas
            $query_mesa = " SELECT *
                            FROM mesa                                                    
                        ";
            $mesas = $mysqli->query($query_mesa);
    // fin consultas
        
?>

<!DOCTYPE html>
<html lang="Es">
    <head>
        <?php require '../logs/head.php'; ?>
        <script src="../js/mensajes.js"></script>
    </head>
    <body>
        <?php require '../logs/nav-bar.php'; ?>
        <div id="layoutSidenav_content" class="layoutSidenav" >
            <main>
                <div class="container-fluid px-3"> 
                    <div class="card-header BG-WARNING mt-1"><font color="white">PEDIDOS</font></div>
                    <div class="container mt-1">
                        <div class="row justify-content-center">
                            <div class="container-fluid">
                                <div class="row">
                                <?php
                                                while ($fila = $mesas->fetch_array()) {
                                                        $idmesas = $fila['mesas_id'];
                                                        $nombre = $fila['mesas_nombre'];                                               
                                                        $estado = $fila['mesas_estado'];
                                                        if ($estado == 'cerrada') {
                                                            $label_class = 'badge bg-danger';
                                                        } elseif ($estado == 'abierta') {
                                                            $label_class = "badge bg-success" ;
                                                        } elseif ($estado == 'por entregar') {
                                                            $label_class = 'badge bg-primary badge';
                                                        } 
                                            ?> 
                                    <form method="POST" action="pedido_mesa.php">

                                        <input type="hidden" id="pedido_mesero" name="pedido_mesero" value="<?php echo $id; ?>">
                                        <input type="hidden" id="pedido_mesa" name="pedido_mesa" value="<?php echo $idmesas; ?>">
                                        <input type="hidden" id="pedido_estado" name="pedido_estado" value="abierta">

                                        <button value="<?php echo $idmesas; ?>" id="btn_mesa" name="btn_mesa" type="submit"     class="btn btn-outline-dark btn-lg p-2 m-2">
                                            <span class="material-icons">restaurant</span>
                                            &#160;&#160;&nbsp;
                                            Mesa&nbsp;<?php echo $idmesas; ?>
                                            &#160;&#160;&nbsp;                                             
                                            <span class="label <?php echo $label_class; ?>"><?php echo $estado; ?></span>
                                        </button>
                                    </form>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>            
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        
       
    </body>
</html>