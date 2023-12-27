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
    include '../conexion/conexion5.php';
    
    

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
                                    <form  id="formulario" method="POST">
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
                                        <input type="hidden" id="pedido_mesero" name="pedido_mesero" value="<?php echo $id; ?>">
                                        <input type="hidden" id="pedido_estado" name="pedido_estado" value="abierta">
                                        <input type="hidden" id="pedido_mesas" name="pedido_mesas" value="<?php echo $idmesas; ?>">
                                         
                                         <button value="<?php echo $idmesas; ?>" id="pedido_mesa" type="submit"  name="pedido_mesa"  href="pedido_mesa.php?pedido_mesa=<?php echo $idmesas; ?>" class="btn btn-outline-dark btn-lg p-2 m-2">
                                            <span class="material-icons">restaurant</span>
                                            &#160;&#160;&nbsp;
                                            Mesa&nbsp;<?php echo $idmesas; ?>
                                             &#160;&#160;&nbsp;                                             
                                            <span class="label <?php echo $label_class; ?>"><?php echo $estado; ?></span>
                                        </button>
                                        <?php } ?>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>            
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        <script src="../js/mensajes.js"></script>
        <script src="../js/app.js"></script>
        <script>
            
        </script>
    </body>
</html>