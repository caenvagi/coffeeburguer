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
    
    // consulta estado de la mesa 1
        
        $query1 = " SELECT pedido_estado
                    FROM pedidos
                    WHERE pedido_mesa=1 and codigo_recibo = (SELECT MAX(codigo_recibo) from pedidos)
        ";
        $estado1 = $mysqli->query($query1);

    // consulta estado de la mesa 2    

        $query2 = "  SELECT pedido_estado 
                    FROM pedidos 
                    WHERE pedido_mesa=2 and codigo_recibo = (SELECT MAX(codigo_recibo) 
                    from pedidos)
                    ";
        $estado2 = $mysqli->query($query2);

        // consulta estado de la mesa 2    

        $query3 = "  SELECT pedido_estado 
                    FROM pedidos 
                    WHERE pedido_mesa=3 and codigo_recibo = (SELECT MAX(codigo_recibo) 
                    from pedidos)
                    ";
        $estado3 = $mysqli->query($query3);

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

                                <form  method="POST" action="pedido_mesa1.php">

                                <input type="hidden" name="pedido_mesero" value="<?php echo $id; ?>">
                                <input type="hidden" name="pedido_estado" value="atendida">
                                <input type="hidden" name="pedido_mesas" value="1">

                                <button value="1" id="pedido_mesa" type="submit"  name="pedido_mesa"  href="pedido_mesa1.php?pedido_mesa=1" class="btn btn-outline-dark btn-lg">
                                        <span class="material-icons">restaurant</span>
                                        &#160;&#160;&nbsp;
                                        Mesa 1
                                        &#160;&#160;&nbsp;
                                        <?php
                                        while ($fila = $estado1->fetch_array()) {
                                            $estadonuevo1 = $fila['pedido_estado'];
                                            $estado = $fila['pedido_estado'];
                                            if ($estado == 'atendida') {
                                                $label_class = 'badge bg-danger';
                                            } elseif ($estado == 'pendiente') {
                                                $label_class = "badge bg-success" ;
                                            } elseif ($estado == 3) {
                                                $label_class = 'badge-porentregar badge';
                                            }  ?>
                                        <span class="label <?php echo $label_class; ?>"><?php echo $estadonuevo1; ?></span>
                                        <?php } ?>
                                </button>
                                
                                <br>

                                    
                                    <button value="2" id="pedido_mesa" type="submit" name="pedido_mesa" href="pedido_mesa1.php?pedido_mesa=2" class="btn btn-outline-dark btn-lg" >
                                        <span class="material-icons">restaurant</span>
                                        &#160;&#160;&nbsp;
                                        Mesa 2
                                        &#160;&#160;&nbsp;
                                        <?php
                                        while ($fila = $estado2->fetch_array()) {
                                            $estadonuevo2 = $fila['pedido_estado'];
                                            $estado22 = $fila['pedido_estado'];
                                            if ($estado22== 'atendida') {
                                                $label_class = 'badge bg-danger';
                                            } elseif ($estado22 == 'pendiente') {
                                                $label_class = "badge bg-success" ;
                                            } elseif ($estado22 == 3) {
                                                $label_class = 'badge-porentregar badge';
                                            }  ?>
                                        <span class="label <?php echo $label_class; ?>"><?php echo $estadonuevo2; ?></span>
                                        <?php } ?>                                       
                                    </button>
                                    <br>

                                    <button value="3" id="pedido_mesa" type="submit" name="pedido_mesa" href="pedido_mesa1.php?pedido_mesa=3" class="btn btn-outline-dark btn-lg" >
                                        <span class="material-icons">restaurant</span>
                                        &#160;&#160;&nbsp;
                                        Mesa 3
                                        &#160;&#160;&nbsp;
                                        <?php
                                        while ($fila = $estado3->fetch_array()) {
                                            $estadonuevo3 = $fila['pedido_estado'];
                                            $estado33 = $fila['pedido_estado'];
                                            if ($estado33== 'atendida') {
                                                $label_class = 'badge bg-danger';
                                            } elseif ($estado33 == 'pendiente') {
                                                $label_class = "badge bg-success" ;
                                            } elseif ($estado33 == 3) {
                                                $label_class = 'badge-porentregar badge';
                                            }  ?>
                                        <span class="label <?php echo $label_class; ?>"><?php echo $estadonuevo3; ?></span>
                                        <?php } ?>                                       
                                    </button>
                                    
                                </form>   
                            </div>
                            </div>

                            <!-- <form action="pedido_mesa1.php" method="POST">
                                <input type="text" name="pedido_mesero" value="<?php echo $id;?>">
                                <input type="text" name="pedido_estado" value="atendida">
                                <input type="text" name="pedido_mesas" value="1">

                                <button type="submit" name="pedido_mesa" value="1"> mesa 1</button>

                            </form> -->

                                    
                            
                            

                                        </div>
                                    </div>
                                </div>
                            <!-- fin tabla guias hoy -->
                        </div>    
                    </div>
                </div>
            </main>
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        <script src="../js/mensajes.js"></script>
    </body>
</html>