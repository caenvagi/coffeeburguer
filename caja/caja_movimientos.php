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
                                                        Us.usuario,
                                                        caja_tipo
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       liquidado = 'NO'
                                            ORDER BY    fecha_movimiento DESC
                                        ") or die($mysqli->error);

    $total_mov_ingreso = $mysqli->query   ("SELECT      SUM(valor_ingreso) as total_ingresos
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       caja_tipo = 'ingreso' 
                                            ORDER BY    fecha_movimiento DESC
    ") or die($conexion->error); 
    
    $total_mov_egreso = $mysqli->query   (" SELECT     SUM(valor_ingreso) as total_egresos
                                            FROM        caja Ca
                                            INNER JOIN  caja_conceptos Cc   ON Ca.movimiento = Cc.id_concepto
                                            INNER JOIN  usuarios Us         ON Ca.usuario    = Us.id   
                                            WHERE       caja_tipo = 'gasto'
                                            ORDER BY    fecha_movimiento DESC
                                        ") or die($conexion->error);

    $total_mov = $mysqli->query   ("    SELECT

                                        (SELECT
                                                SUM(valor_ingreso) as total_ingresos
                                                    
                                        FROM 	caja                                             
                                        WHERE 	caja_tipo = 'ingreso')
                                        -
                                        (SELECT
                                                SUM(valor_ingreso) as total_egreso
                                                    
                                        FROM 	caja                                             
                                        WHERE 	caja_tipo = 'gasto')
                                        
                                        as diferencia
                                            ") or die($conexion->error);                                    
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require '../logs/head.php';?> 
    </head>
    <body>
        <?php require '../logs/nav-bar.php';?>
            <div id="layoutSidenav_content" class="bg-light">
                <main>
                    <div class="card-header BG-secondary mt-1"><i style="font-size:24px;color: white;" class="fas fa-cash-register"></i>&nbsp;&nbsp;<b style="color: white;">CAJA</b></div>
                        <div class="container-fluid px-2">
                            <div class="container mt-3 rounded-3">
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
                                <div class="row justify-content">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header" id="card-headerMov">                                                
                                                <div class="row" id="cardMovimientos">                                                
                                                    Movimientos:
                                                    <div id="botonCajadiv1" class="col-lg-5 col-md-5 col-sm-3 col-12">
                                                        <!-- <button  id="botonCaja" type="button" class="btn btn-outline-dark">Abrir caja</button> -->
                                                    </div>
                                                    <div id="botonCajadiv2" class="col-lg-5 col-md-3 col-sm-7 col-6">
                                                
                                                <!-- Modal  INGRESO-->       
                                                    <button id="botonCaja" type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal1">nueva venta</button>
                                                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <div class="row cardBalanceIconGreen m-2">    
                                                                        <span><i class='fas fa-hand-holding-usd' style='font-size:30px;color:green'></i></span>
                                                                    </div>
                                                                        <h5 class="modal-title" id="exampleModalLabel">Ingresar entradas:</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <style>
                                                                        .span3{
                                                                            padding: 0px !important;
                                                                            margin: 2px !important;
                                                                            border-radius:5px !important;
                                                                            outline-style: solid !important;
                                                                            outline-width: 1px !important;
                                                                            background: #ccdbfd !important;                                                                    
                                                                        }                                                                
                                                                        </style>
                                                                            <form id="movimientos" name="movimientos" class="row g-0 p-2" action="consulta/ingreso.php" method="POST">
                                                                                <!-- <input name="id_movimiento" value="<?php echo $id_movimiento ?>"  type="hidden" class="form-control"  placeholder="id_movimiento" aria-label="id_movimiento" aria-describedby="basic-addon1" required autofocus> -->
                                                                                    <div class="text-center">
                                                                                        
                                                                                        <input type="hidden" name="inlineRadioOptions" value="ingreso"></input>
                                        
                                                                                        <div class="form-floating m-2">
                                                                                            <input type="Date" name="fecha_movimiento" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                                                                            <label for="floatingInput">Fecha:</label>
                                                                                        </div>
                                        
                                                                                        <select name="usuario" id="usuario" class="form-select mb-3" aria-label="Default select example" required>
                                                                                            <option value="">Selecione Usuario</option>
                                                                                            <?php while ($row =  $usuarios->fetch_assoc()) { ?>
                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                        
                                                                                        <select name="movimiento" id="movimiento" class="form-select mb-3 mt-1" aria-label="Default select example" required>
                                                                                            <option selected>Selecione Movimiento</option>
                                                                                            <?php while ($row =  $conceptos->fetch_assoc()) { ?>
                                                                                            <option value="<?php echo $row['id_concepto']; ?>"><?php echo $row['nombre_concepto']; ?></option>
                                                                                            <?php } ?>
                                                                                            <!-- <option value="" id="span1"></option>
                                                                                            <option id="span2"></option> -->
                                                                                        </select>

                                                                                        <div class="form-floating m-2">
                                                                                            <input type="text" name="desc_movimiento" class="form-control" id="floatingInput" placeholder="Input" required>
                                                                                            <label for="floatingInput">Descripcion</label>
                                                                                        </div>
                                                                                        
                                                                                        <div class="form-floating m-2">
                                                                                            <input type="text" name="valor" class="form-control" id="floatingPassword" placeholder="Password" required>
                                                                                            <label for="floatingPassword">Valor</label>
                                                                                        </div>
                                        
                                                                                        <input value="<?php echo $id ?>"  type="hidden" class="form-control" name="user_login" placeholder="usuario" aria-label="user_login" aria-describedby="basic-addon1" required autofocus>
                                                                                        
                                                                                        <input class="form-check-input" type="hidden" name="liquidado" value="NO">
                                        
                                                                                        <input class="form-check-input" type="hidden" name="caja_tipo" value="gasto">
                                        
                                                                                        <div class="d-grid gap-2 m-2">
                                                                                            <button type="submit"  name="register" href="consulta/ingreso.php" class="btn btn-success btn btn-block"  ><i class="bi bi-plus-lg text-white">&nbsp;GUARDAR</i></button>
                                                                                        </div>
                                                                                    </div>
                                                                            </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <!-- MODAL INGRESO   -->
                                                    
                                                <!-- Modal -->   
                                                    <button id="botonCaja" type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">nuevo gasto</button>
                                                    </div>
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <div class="row cardBalanceIconRed m-2">    
                                                                        <span><i class='fas fa-coins' style='font-size:30px;color:red'></i></span>
                                                                    </div>
                                                                    <h5 class="modal-title" id="exampleModalLabel">Ingresar Gasto:</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <style>
                                                                    .span3{
                                                                        padding: px !important;
                                                                        margin: 2px !important;
                                                                        border-radius:5px !important;
                                                                        outline-style: solid !important;
                                                                        outline-width: 1px !important;
                                                                        background: #ccdbfd !important;                                                                    
                                                                    }                                                                
                                                                    </style>
                                                                        <form id="movimientos" name="movimientos" class="row g-0 p-2" action="consulta/ingreso.php" method="POST">
                                                                            <!-- <input name="id_movimiento" value="<?php echo $id_movimiento ?>"  type="hidden" class="form-control"  placeholder="id_movimiento" aria-label="id_movimiento" aria-describedby="basic-addon1" required autofocus> -->
                                                                                <div class="text-center">
                                                                                    
                                                                                    <input type="hidden" name="inlineRadioOptions" value="gasto"></input>
                                    
                                                                                    <div class="form-floating m-2">
                                                                                        <input type="Date" name="fecha_movimiento" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                                                                        <label for="floatingInput">Fecha:</label>
                                                                                    </div>
                                    
                                                                                    <select name="usuario" id="usuario" class="form-select mb-3" aria-label="Default select example" required>
                                                                                        <option value="">Selecione Usuario</option>
                                                                                        <?php while ($row =  $usuarios->fetch_assoc()) { ?>
                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                    
                                                                                    <select name="movimiento" id="movimiento" class="form-select mb-3 mt-1" aria-label="Default select example" required>
                                                                                        <option selected>Selecione Movimiento</option>
                                                                                        <?php while ($row =  $conceptos->fetch_assoc()) { ?>
                                                                                        <option value="<?php echo $row['id_concepto']; ?>"><?php echo $row['nombre_concepto']; ?></option>
                                                                                        <?php } ?>
                                                                                        <!-- <option value="" id="span1"></option>
                                                                                        <option id="span2"></option> -->
                                                                                    </select>

                                                                                    <div class="form-floating m-2">
                                                                                        <input type="text" name="desc_movimiento" class="form-control" id="floatingInput" placeholder="Input" required>
                                                                                        <label for="floatingInput">Descripcion</label>
                                                                                    </div>
                                                                                    
                                                                                    <div class="form-floating m-2">
                                                                                        <input type="text" name="valor" class="form-control" id="floatingPassword" placeholder="Password" required>
                                                                                        <label for="floatingPassword">Valor</label>
                                                                                    </div>
                                    
                                                                                    <input value="<?php echo $id ?>"  type="hidden" class="form-control" name="user_login" placeholder="usuario" aria-label="user_login" aria-describedby="basic-addon1" required autofocus>
                                                                                    
                                                                                    <input class="form-check-input" type="hidden" name="liquidado" value="NO">
                                    
                                                                                    <input class="form-check-input" type="hidden" name="caja_tipo" value="gasto">
                                    
                                                                                    <div class="d-grid gap-2 m-2">
                                                                                        <button type="submit"  name="register" href="consulta/ingreso.php" class="btn btn-danger btn btn-block"  ><i class="bi bi-plus-lg text-white">&nbsp;GUARDAR</i></button>
                                                                                    </div>
                                                                                </div>
                                                                        </form>
                                                                </div>
                                                                <!-- <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                                </div> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                <!-- MODAL     -->
                                                </div>
                                            </div>
                                            <div class="cardbody m-3">
                                                <div class="row transacciones">
                                                    <div class="d-grid gap-2 col-12 mx-auto">
                                                        <button type="button" class="btn btn-outline-dark">transacciones</button>
                                                    </div>
                                                    <!-- <div class="d-grid gap-2 col-6 mx-auto">
                                                        <button type="button" class="btn btn-outline-secondary">Cierres de Caja</button>
                                                    </div> -->
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
                                                            <?php
                                                                        while ($fila = $total_mov->fetch_array()) {
                                                                                $saldo_mes = $fila['diferencia'];
                                                                                if($saldo_mes < 0){
                                                                                    $textColor = 'red';
                                                                                }
                                                                    ?>
                                                            <span style="color: <?php echo $textColor ; ?>"class="value value-bottom"> $&nbsp;<?php echo number_format($saldo_mes, 0, ",", "."); ?></span>
                                                            <?php } ?>  
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
                                                                <?php
                                                                    while ($fila = $total_mov_ingreso->fetch_array()) {
                                                                    $ingresos = $fila['total_ingresos'];
                                                                    ?>
                                                            <span class="value value-bottom"> $&nbsp;<?php echo number_format($ingresos, 0, ",", "."); ?></span>
                                                                    <?php } ?>
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
                                                                <?php
                                                                    while ($fila = $total_mov_egreso->fetch_array()) {
                                                                    $egresos = $fila['total_egresos'];
                                                                    ?>
                                                            <span class="value value-bottom"> $&nbsp;<?php echo number_format($egresos, 0, ",", "."); ?></span>
                                                            <?php } ?>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div  class="row informes justify-content-between m-0"> 
                                                <div class="row butom_list" id="butom_list">
                                                    <div class="d-grid gap-2 col-4 mx-auto" >
                                                        <button id="botonTabla" type="button" class="botonTabla btn btn-outline-primary" category="todos">Todos</button>
                                                    </div>
                                                    <div class="d-grid gap-2 col-4 mx-auto" >
                                                        <button id="botonTabla" type="button" class="botonTabla btn btn-outline-success" category="ingreso">Ingresos</button>
                                                    </div>
                                                    <div class="d-grid gap-2 col-4 mx-auto">
                                                        <button id="botonTabla" type="button" class="botonTabla btn btn-outline-danger" category="gasto">Gastos</button>
                                                    </div> 
                                                    <!-- <div class="d-grid gap-2 col-2 mx-auto">
                                                        <button id="botonTabla" type="button" class="botonTabla btn btn-outline-primary" category="cobrar">Por cobrar</button>
                                                    </div>
                                                    <div class="d-grid gap-2 col-2 mx-auto">
                                                        <button id="botonTabla" type="button" class="botonTabla btn btn-outline-dark" category="pagar">Por pagar</button>
                                                    </div> -->
                                                </div>
                                                    <table id="tablita" class="table table-borderless table-hover mt-3" >
                                                        <thead id="tableHeadMovimientos">                                                        
                                                            <th>logo</th>
                                                            <th>tipo</th>
                                                            <th>Concepto</th>
                                                            <th>Valor</th>
                                                            <th>Fecha y hora</th>                                                        
                                                        </thead>
                                                        <tbody id="tableBodyMovimientos">
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
                                                                    
                                                                    $caja_tipo = $fila['caja_tipo'];

                                                                    if($caja_tipo === 'ingreso'){
                                                                        $label_class1 = 'fas fa-hand-holding-usd';
                                                                    }elseif($caja_tipo === 'gasto'){
                                                                        $label_class1 = 'fas fa-coins';
                                                                    }
                                                                    
                                                                    if($caja_tipo === 'ingreso'){
                                                                        $label_class2 = 'tableIconGreen';
                                                                    }elseif($caja_tipo === 'gasto'){
                                                                        $label_class2 = 'tableIconRed';
                                                                    }

                                                                    if($caja_tipo === 'ingreso'){
                                                                        $label_class3 = 'green';
                                                                    }elseif($caja_tipo === 'gasto'){
                                                                        $label_class3 = 'red';
                                                                    }

                                                                    if($caja_tipo === 'ingreso' ){
                                                                        $valor = 'color:green';
                                                                    }elseif ($caja_tipo === 'gasto' ){
                                                                        $valor = 'color:red';
                                                                    }                                                              
                                                                ?>
                                                            <tr>                                                            
                                                                <td class="product_item1" category="<?php echo $caja_tipo; ?>" id="<?php echo $label_class2; ?>"><span  class="label <?php echo $label_class1; ?>" style="font-size:14px ; color:<?php echo $label_class3; ?>"></td>
                                                                <td class="product_item1" category="<?php echo $caja_tipo; ?>"><?php echo $caja_tipo; ?></td>
                                                                <td class="product_item1" category="<?php echo $caja_tipo; ?>"><?php echo $desc_movimiento; ?></td>
                                                                <td style="<?php echo $valor; ?>" class="product_item1" category="<?php echo $caja_tipo; ?>">$<?php echo number_format($valor_ingreso, 0, ",", "."); ?></td>
                                                                <td class="product_item1" category="<?php echo $caja_tipo; ?>"><?php echo $fecha; ?></td>
                                                            </tr>   
                                                            <?php } ?>
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
        <script>
                $(document).ready(function () {
            // agregando el active a los botones//
                $('.butom_list .botonTabla[category="todos"]').addClass("ct_item_active");
                            
                    $(".botonTabla").click(function () {
                        var catBoton = $(this).attr("category");
                        console.log(catBoton);
            
                    $(".botonTabla").removeClass("ct_item_active");
                    $(this).addClass("ct_item_active");
                    $(".product_item1").hide();
            
                    $('.product_item1[category="' + catBoton + '"]').show();
                    $('.botonTabla[category="todos"]').click(function () {
                    $(".product_item1").show();
                    });
            });
        });
    </script>                                                       
    </body>
</html>
