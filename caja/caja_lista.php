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
    
    include '../conexion/conexion.php';
    $movimientos = $mysqli->query   ("  SELECT          id_movimiento,
                                                        fecha_movimiento,
                                                        Ca.usuario,
                                                        Ca.movimiento,
                                                        desc_movimiento,
                                                        valor_ingreso,
                                                        valor_egreso,
                                                        Ca.user_login,
                                                        Cc.nombre_concepto,
                                                        Us.nombre,
                                                        Us.usuario
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       liquidado = 'NO'
                                            ORDER BY    fecha_movimiento DESC
                                         ") or die($conexion->error);

    $total_mov_ingreso = $mysqli->query   ("  SELECT      SUM(valor_ingreso) as total_ingresos
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       liquidado = 'NO'
                                            ORDER BY    fecha_movimiento DESC
                                        ") or die($conexion->error);

    $total_mov_egreso = $mysqli->query   (" SELECT     SUM(valor_egreso) as total_egresos
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       liquidado = 'NO'
                                            ORDER BY    fecha_movimiento DESC
                                        ") or die($conexion->error);                                   

    $total_mov = $mysqli->query   ("      SELECT      SUM(valor_ingreso) - SUM(valor_egreso) as saldo_mes
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       liquidado = 'NO'
                                            ORDER BY    fecha_movimiento DESC
                                    ") or die($conexion->error);
   
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <?php require '../logs/head.php';?>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        
    </head>

    <body>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
        <?php require '../logs/nav-bar.php';?>
        <!-- inicio pagina -->
            <div id="layoutSidenav_content" class=bg-light>
                <main>
                    <!-- TITULO ANTES DEL FORM Y LA TABLA -->
                    <div class="container-fluid px-4">
                        <?php require 'caja_navegacion.php'; ?>
                        <!-- tabla movimientos -->
                        <div class="col-md-12 col-xl-12">
                                <div class="card m-3 p-1">
                                    <div class="card-header">
                                        Movimientos de caja Mensual:
                                    </div>
                            
                                                <style>
                                                    #contenedorPadre {
                                                    }
                                                    #contenedorHijo {
                                                        position: absolute;
                                                        top: 50%;
                                                        left: 50%;
                                                        transform: translate(-50%, -50%);
                                                    }
                                                    
                                                    .card2{
                                                        margin:     -1px -13px 0 -13px;
                                                    }
                                                </style>

                                        <div class="container"> 
                                            <div class="row">

                                                <div id="contenedorPadre" class="col-lg-4 col-sm-12" >
                                                    <div  class="row p-2">
                                                        <div class="card col-3 bg-success text-white">
                                                            <div id="contenedorHijo" ><i class='fas fa-cash-register' style='font-size:30px'></i>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card col-9">
                                                            <div class="card-header text-center">
                                                                SALDO           
                                                            </div>
                                                            <div class="text-center">
                                                                <?php
                                                                    while ($fila = $total_mov->fetch_array()) {
                                                                            $saldo_mes = $fila['saldo_mes'];
                                                                            if($saldo_mes < 0){
                                                                            $label_class = 'badge bg-danger';
                                                                            }else if ($saldo_mes > 0) {
                                                                                $label_class = 'badge bg-success';
                                                                            }
                                                                ?>
                                                            </div>
                                                            <div  style="font-size:18px;" class="card2 label <?php echo $label_class; ?>">$ <?php echo number_format($saldo_mes, 0, ",", "."); ?>
                                                                    <?php } ?>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                <div id="contenedorPadre" class="col-lg-4 col-sm-12" >
                                                    <div  class="row p-2">
                                                        <div class="card col-3 bg-primary text-white">
                                                            <div id="contenedorHijo" ><i class='fas fa-arrow-alt-circle-right' style='font-size:36px'></i>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card col-9">
                                                            <div class="card-header text-center">
                                                                Ingresos
                                                            </div>
                                                            <div class="text-center">
                                                                <?php
                                                                    while ($fila = $total_mov_ingreso->fetch_array()) {
                                                                    $ingresos = $fila['total_ingresos'];
                                                                    ?>
                                                            </div>
                                                            <div class="card2 bg-primary text-white" style="font-size:19px  ; text-align:center" >$ <?php echo number_format($ingresos, 0, ",", "."); ?>
                                                            </div>
                                                                
                                                                <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="contenedorPadre" class="col-lg-4 col-sm-12" >
                                                    <div  class="row p-2">
                                                        <div class="card col-3 bg-danger text-white">
                                                            <div id="contenedorHijo" ><i class='fas fa-arrow-alt-circle-left' style='font-size:36px'></i>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card col-9">
                                                            <div class="card-header text-center">
                                                                Gastos
                                                            </div>
                                                            <div class="text-center">
                                                                <?php
                                                                while ($fila = $total_mov_egreso->fetch_array()) {
                                                                $egresos = $fila['total_egresos'];
                                                                ?>
                                                                </div>
                                                                <div class="card2 bg-danger text-white" style="font-size:19px  ; text-align:center" >$ <?php echo number_format($egresos, 0, ",", "."); ?>
                                                                </div>
                                                            
                                                            <?php } ?>     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                               

                                        <div class="card m-3">
                                            <div class="card-header">
                                                Movimientos de caja Mensual:
                                            </div>
                                            <div class="table-responsive m-2">
                                                <table id="example" class="display table table-sm table-bordered table-striped table-hover text text-center" style="font-size: 12px" class="table table-bordered text-center" >
                                                    <caption>Movimientos de caja Mensual</caption>
                                                    
                                                
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th align="center">Cod</i></th>
                                                            <th align="center">Fecha</th>
                                                            <th align="center">Usuario</th>
                                                            <th align="center">Movimiento</th>
                                                            <th align="center">Detalle</th>
                                                            <th align="center">Ingreso</th>
                                                            <th align="center">Gasto</th>
                                                            <!-- <th align="center">Creado por</th> -->
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            while ($fila = $movimientos->fetch_array()) {
                                                                $id = $fila['id_movimiento'];
                                                                $fecha = $fila['fecha_movimiento'];
                                                                $usuario = $fila['nombre'];
                                                                $movimiento = $fila['nombre_concepto'];
                                                                $desc_movimiento = $fila['desc_movimiento'];
                                                                $valor_ingreso = $fila['valor_ingreso'];
                                                                $valor_egreso = $fila['valor_egreso'];
                                                                $user = $fila['usuario'];
                                                        ?>
                                                        <tr>
                                                            <td align="center"><?php echo $id; ?></td>
                                                            <td align="center"><?php echo $fecha; ?></td>
                                                            <td align="center"><?php echo $usuario; ?></td>
                                                            <td align="center"><?php echo $movimiento; ?></td>
                                                            <td align="center"><?php echo $desc_movimiento; ?></td>
                                                            <td align="right" style="color: blue">$<?php echo number_format($valor_ingreso, 0, ",", "."); ?></td>
                                                            <td align="right" style="color: red">$<?php echo number_format($valor_egreso, 0, ",", "."); ?></td>
                                                            <!-- <td align="right"><?php echo $user; ?></td> -->
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    
                                                    <tfoot>
                                                        
                                                    </tfoot>
                                                   
                                                </table>
                                            </div>
                                        </div>
                        </div>
                        <!-- tabla movimientos -->
                    </div>
                </div>     
            </main>
                <!-- pie de pagina --> <?php require '../logs/nav-footer.php'; ?>
            
        </div>          
        <!-- FIN pagina -->
        
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    "order": [[ 0, "desc" ]],
                    'pageLength': 25,
                    "language": {
                         "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                        }
                           
                    });
                    
                    });
        </script> 
        <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>                                                           
     </body>
     <script type="text/javascript" src="../js/mensajes.js"></script>
    
    
     
</html>
