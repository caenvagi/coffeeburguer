<?php
	session_start();

        require '../conexion/conexion.php';

        if (!isset($_SESSION['id'])) {
            header("Location: index.php");
        }
        $id = $_SESSION['id'];
        $nombre = $_SESSION['nombre'];
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $usuario = $_SESSION['usuario'];
        $foto = $_SESSION['foto1'];

        if ($tipo_usuario == 1) {
            $where = "";
        } else if ($tipo_usuario == 2) {
            $where = "WHERE id=$id";
        }
    
    date_default_timezone_set('America/Bogota');

    header('Content-Type: text/html; charset=ISO-8859-1');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
    
    include_once "consulta/saldo.php"; 
    
     
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <?php require '../logs/head.php';?>
    </head>

    <body>
        <?php require '../logs/nav-bar.php';?>
        <!-- inicio pagina -->
            <div id="layoutSidenav_content" class=bg-light>
                <main>
                    <!-- TITULO ANTES DEL FORM Y LA TABLA -->
                    <div class="container-fluid px-2">
                        <?php require 'caja_navegacion.php'; ?>
                        <div class="container mt-3">
                            <div class="col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        TOTAL INGRESOS POR SERVICIOS EXTRA
                                    </div>                        
                                        <table id="avances" class="display table table-sm table-bordered table-striped table-hover text text-center" style="font-size: 12px" class="table table-bordered text-center" >
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>NOMBRE</th>
                                                        <th>SALDO</th>
                                                    </tr> 
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        while ($fila = $saldo_avance->fetch_array()) {
                                                                    $usuario = $fila['usuario'];
                                                                    $nombre = $fila['nombre'];
                                                                    $saldo = $fila['saldo'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $usuario; ?></td>
                                                        <td><?php echo $nombre; ?></td>
                                                        <td align="right"><?php  if ($saldo < "0"){echo "<font color='red'>".number_format($saldo, 0, ",",".")."</font>";
                                                                                        }else{echo number_format($saldo, 0, ",", ".");
                                                                                        }
                                                            ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                        </table>
                                </div>
                            </div>
                             <br>                                   
                            
                                   
                            
                        </div>       
                </main>
                <!-- pie de pagina --> <?php require '../logs/nav-footer.php'; ?>
            </div>         
        <!-- FIN pagina -->
        <script type="text/javascript" src="../js/mensajes.js"></script>
                                                
     </body>

     
</html>