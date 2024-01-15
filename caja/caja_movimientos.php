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
    
    
    include_once "consulta/consultas.php";
    
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
                <div class="card-header BG-secondary mt-1"><b style="color: white;">CAJA</b></div>
                    <!-- TITULO ANTES DEL FORM Y LA TABLA -->
                    <div class="container-fluid px-2">
                        <div class="container mt-3">
                            <!-- inicio de alertas -->
                                <!-- inicio de falta -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'nada') {
                                            ?>
                                                <div class="alerta alert alert-danger alert-dismissible fade show text-center" role="alert">
                                                <i class="far fa-thumbs-down" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Error !</strong> Ingresa todos los datos
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Mensaje guardado -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'guardado') {
                                            ?>
                                                <div class="alerta alert alert-success alert-dismissible fade show text-center" role="alert">
                                                <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> Movimiento registrado
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Mensaje falta -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'falta') {
                                            ?>
                                                <div class="alerta alert alert-warning alert-dismissible fade show text-center" role="alert">
                                                <i class="far fa-thumbs-down" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Error !</strong> Movimiento ya existe !
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Mensaje error -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'error') {
                                            ?>
                                                <div class="alerta alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Error !</strong> Vuelve a intentar!
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Mensaje actualizar -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'editado') {
                                            ?>
                                                <div class="alerta alert alert-primary alert alert-dismissible fade show" role="alert">
                                                    <strong>Actualizacion :</strong> Todos los datos fueron actualizados.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Mensaje eliminar -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'eliminado') {
                                            ?>
                                                <div class="alerta alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Eliminar :</strong> El registro fue eliminado.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
											<!-- Mensaje informe diario -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'informe') {
                                            ?>
                                                <div class="alerta alert alert-success alert alert-dismissible fade show" role="alert">
                                                    <strong><h2 class="text-center">INFORME DIARIO C.E Y RECAUDO</h2></strong> <h3 class="text-center">Ha sido generado</h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                            <!-- fin alertas -->        
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header" id="card-headerMov">                                                
                                            <div class="row" id="cardMovimientos">                                                
                                                Movimientos:
                                                <div id="botonCajadiv1" class="col-lg-5 col-md-5 col-sm-3 col-12">
                                                    <button  id="botonCaja" type="button" class="btn btn-outline-dark">Abrir caja</button>
                                                </div>
                                                <div id="botonCajadiv2" class="col-lg-5 col-md-3 col-sm-7 col-6">
                                                    <button id="botonCaja" type="button" class="btn btn-outline-success">Nueva venta</button>
                                                    <button id="botonCaja" type="button" class="btn btn-outline-danger">nuevo gasto</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cardbody m-3">
                                            <div class="row transacciones">
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <button type="button" class="btn btn-outline-dark">transacciones</button>
                                                </div>
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <button type="button" class="btn btn-outline-secondary">Cierres de Caja</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row informes justify-content-between m-3">
                                            <div class="card shadow col-md-4" id="cardBalance">
                                                <div class="cardBalance">
                                                    <div class="row cardBalanceIconGreen m-2">    
                                                        <span><i class='far fa-chart-bar' style='font-size:30px;color:green'></i></span>
                                                    </div>
                                                    <div class="cardBalanceText">
                                                        <span class="label-bottom">Balance</span>
                                                        <span class="value value-bottom"> $&nbsp;20.500</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card shadow col-md-4" id="cardBalance">
                                                <div class="cardBalance">
                                                    <div class="row cardBalanceIconGreen m-2">    
                                                        <span><i class='fas fa-hand-holding-usd' style='font-size:30px;color:green'></i></span>
                                                    </div>
                                                    <div class="cardBalanceText">
                                                        <span class="label-bottom">Ventas totales</span>
                                                        <span class="value value-bottom"> $&nbsp;20.500</span>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="card shadow col-md-4" id="cardBalance">
                                                <div class="cardBalance">
                                                    <div class="row cardBalanceIconRed m-2">    
                                                        <span><i class='fas fa-coins' style='font-size:30px;color:red'></i></span>
                                                    </div>
                                                    <div class="cardBalanceText">
                                                        <span class="label-bottom">Gastos totales</span>
                                                        <span class="value value-bottom"> $&nbsp;20.500</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div  class="row informes justify-content-between m-0">
                                            <div class="d-grid gap-2 col-3 mx-auto">
                                                <button id="botonTabla" type="button" class="btn btn-outline-success">Ingresos</button>
                                            </div>
                                            <div class="d-grid gap-2 col-3 mx-auto">
                                                <button id="botonTabla" type="button" class="btn btn-outline-danger">Gastos</button>
                                            </div> 
                                            <div class="d-grid gap-2 col-3 mx-auto">
                                                <button id="botonTabla" type="button" class="btn btn-outline-primary">Por cobrar</button>
                                            </div>
                                            <div class="d-grid gap-2 col-3 mx-auto">
                                                <button id="botonTabla" type="button" class="btn btn-outline-dark">Por pagar</button>
                                            </div>
                                            
                                                <table class="mt-3" >
                                                    <thead id="tableHeadMovimientos">
                                                        <th></th>
                                                        <th>Concepto</th>
                                                        <th>Valor</th>
                                                        <th>Medio de pago</th>
                                                        <th>Fecha y hora</th>
                                                        <th>Estado</th>
                                                    </thead>
                                                    <tbody id="tableBodyMovimientos">
                                                        <td id="tableIconGreen"><i class='fas fa-hand-holding-usd' style='font-size:14px;color:green'></i></td>
                                                        <td>Venta en el punto</td>
                                                        <td>$35.000</td>
                                                        <td>Efectivo</td>
                                                        <td>14/01/2023 11:20 pm</td>
                                                        <td style="font-size:14px"><span class="badge bg-success">Pagada</span></td>
                                                    </tbody>
                                                    <tbody id="tableBodyMovimientos">
                                                        <td id="tableIconGreen"><i class='fas fa-hand-holding-usd' style='font-size:14px;color:green'></i></td>
                                                        <td>Venta en el punto</td>
                                                        <td>$35.000</td>
                                                        <td>Efectivo</td>
                                                        <td>14/01/2023 11:20 pm</td>
                                                        <td style="font-size:14px"><span class="badge bg-success">Pagada</span></td>
                                                    </tbody>
                                                </table>
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>       
                </main>
                <!-- pie de pagina --> <?php require '../logs/nav-footer.php'; ?>
            </div>         
        <!-- FIN pagina -->
        <script type="text/javascript" src="../js/mensajes.js"></script>
    </body>
</html>
