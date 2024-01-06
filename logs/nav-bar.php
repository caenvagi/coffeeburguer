<?php
   //session_start();

    require '../conexion/conexion.php';

    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
    }
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $usuario = $_SESSION['usuario'];
	$foto = $_SESSION['foto1'];
    $fotos = $_SESSION['foto2'];
    
    if ($tipo_usuario == 1) {
        $where = "";
    } else if ($tipo_usuario == 2) {
        $where = "WHERE id=$id";
    }

    include '../conexion/conexion.php';
    $fotouser = $mysqli->query("  SELECT        US.nombre,
                                                US.email,
                                                US.usuario,
                                                US.tipo_usuario,
                                                Tu.tipo_usuario,
                                                US.direccion,
                                                US.telefono,
                                                US.foto1,
                                                Us.foto2                                       
                                        FROM usuarios US
                                        INNER JOIN tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        WHERE id=$id
                                        ") or die($mysqli->error);
    
    
        
?>

<!DOCTYPE html>
<html lang="es">

    <head>
    
    </head>

    <body class="BG sb-nav-fixed">
        
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

<!-- Navbar Brand -->
    <a class="logo2" href="../index/dashboard.php"><img class="logo2" src="../assets/img/logo.png"></a><a class="navbar-brand ps-3" href="../index/dashboard.php">Coffee Burguer</a>
<!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        
    <b style="font-size:16px" class="text-white" class="text-left" class="ng-binding"></b>
<!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group"></div>
    </form>
<!-- Navbar -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4" id="navbar-nav">
        <li class="nav-item dropdown">
        <?php
            while ($fila = $fotouser->fetch_array()) {
            $foto1 = $fila['foto1'];
        ?>
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombre ?>&nbsp;&nbsp;&nbsp;<img class="avatar2" src="<?php echo $foto1 ?>" /><!-- &nbsp;&nbsp;<i class="fas fa-user fa-fw"></i>--></a>
        <?php } ?>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="../usuarios/usuarios.php"><i class="fa fa-user-circle"></i>&nbspPerfil</a></li>
                <!--<li><a class="dropdown-item" href="#!">Otros</a></li>-->
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="../logout.php"><i class='fas fa-power-off'></i>&nbspCerrar Sesion</a></li>
            </ul>
        </li>
    </ul>
</nav>
			
        <!-- BARRA SUPERIOR FIN-->
        <!-- INICIO MENU PRINCIPAL -->
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                        <div class="sb-sidenav-menu">
                            <div class="nav">
                                <!-- titulo del menu <div class="sb-sidenav-menu-heading">Menu</div> -->
                                <a class="nav-link" href="#">
                                    <img class="avatar" src="<?php echo $foto ?>"/> &nbsp;<?php echo $nombre ?>
                                    </br>
                                    &nbsp;<?php echo $usuario ?>
                                    <div class="sb-nav-link-icon"><!--<i class="fas fa-tachometer-alt"></i>--></div>
                                    </a>

                                <div class="sb-sidenav-menu-heading">Menu</div>

                                <!-- MENU ENVIA INICIO -->
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div><span class="material-icons">lunch_dining</span></div>
                                        &nbsp;&nbsp;&nbsp;Pedidos:
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    
                                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="../pedidos/pedido_nuevo.php">
                                                <div><span class="material-icons">restaurant</span></div>
                                                &nbsp;&nbsp;&nbsp;Pedidos
                                            </a>

                                                                                       

                                            <a class="nav-link" href="../pedidos/pedido_domicilio.php">
                                                <div><span class="material-icons">two_wheeler</span></div>
                                                &nbsp;&nbsp;&nbsp;Domicilios
                                            </a>

                                            <a class="nav-link" href="../pedidos/pedido_abierto.php">
                                                <div><span class="material-symbols-outlined">table_restaurant</span></div>
                                                &nbsp;&nbsp;&nbsp;Pedido Abierto
                                            </a> 


                                            <a class="nav-link" href="../pedidos/pedido_lista.php">
                                                <div><i class="fas fa-chart-line" ></i></div>
                                                &nbsp;&nbsp;&nbsp;Lista pedidos
                                            </a>
                                            
                                            

                                            <!--<a class="nav-link" href="../env_guias/envia_devoluciones.php">
                                                <div><i class="fas fa-sign-in-alt"></i></div>
                                                &nbsp;&nbsp;&nbsp;Categorias
                                            </a>-->
                                        </nav>

                                    </div>
                                <!-- MENU ENVIA FIN-->

                                <!-- MENU INVENTARIO INICIO-->
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse-apostilla" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div><span class="material-icons">kitchen</span></div>
                                        &nbsp;&nbsp;&nbsp;Inventario
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapse-apostilla" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="../productos/producto_nuevo.php">
                                                <div><span class="material-icons">fastfood</span></div>
                                                &nbsp;&nbsp;&nbsp;Productos
                                            </a>
                                            <a class="nav-link" href="../productos/producto_categoria.php">
                                                <div><span class="material-icons">category</span></div>
                                                &nbsp;&nbsp;&nbsp;Categorias
                                            </a>
                                            <a class="nav-link" href="../mesas/mesas.php">
                                                <div><span class="material-symbols-outlined">food_bank</span></div>
                                                &nbsp;&nbsp;&nbsp;Mesas
                                            </a>
                                            <!-- <a class="nav-link" href="../mesas/domicilios.php">
                                                <div><span class="material-icons">two_wheeler</span></div>
                                                &nbsp;&nbsp;&nbsp;Domicilios
                                            </a> -->
                                            
                                            <!-- <a class="nav-link" href="../apostillas/apost_tablas.php">
                                            <div><i class='bi bi-clipboard-check-fill'></i></div>
                                            &nbsp;&nbsp;&nbsp;General
                                            </a>-->
                                            
                                            <!-- <a class="nav-link" href="layout-sidenav-light.html">-----</a> -->
                                        </nav>
                                    </div>
                                <!-- MENU APOSTILLAS FIN-->

                                <!-- MENU CAJA Caja-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse-caja" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div><i style="font-size:24px" class="fas fa-cash-register"></i></div>
                                        &nbsp;&nbsp;&nbsp;Caja
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapse-caja" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="../caja/caja_ingresos.php">
                                                <div><i class="fas fa-keyboard" ></i></div>
                                                &nbsp;&nbsp;&nbsp;Ingresar
                                            </a>
                                            <a class="nav-link" href="../caja/caja_lista.php">
                                                <div><i class='fas fa-file-alt'></i></div>
                                                &nbsp;&nbsp;&nbsp;Listado
                                            </a>
                                            <a class="nav-link" href="../caja/caja_saldos.php">
                                                <div><i class='fas fa-donate'></i></div>
                                                &nbsp;&nbsp;&nbsp;Saldos
                                            </a>
                                            
                                            
                                        </nav>
                                    </div>
                                <!-- MENU CONFIGURACION Caja-->

                                <!-- MENU CONFIGURACION INICIO-->
                                <?php if($tipo_usuario == 1){?>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse-ENVIA" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div><i style="font-size:24px" class="fa">&#xf013;</i></div>
                                        &nbsp;&nbsp;&nbsp;Configuracion
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapse-ENVIA" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="../usuarios/usuarios_nuevos.php">
                                                <div><i class="fa fa-user-circle" style='font-size:24px'></i></div>
                                                &nbsp;&nbsp;&nbsp;Empleados
                                            </a>
                                        </nav>
                                    </div>
                                <?php  } ?>    
                                <!-- MENU CONFIGURACION FIN-->

                                <!-- OTRO MENU INICIO-->
                                    <!--<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                        Pages
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                                Authentication
                                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                            </a>
                                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                                <nav class="sb-sidenav-menu-nested nav">
                                                    <a class="nav-link" href="login.html">Login</a>
                                                    <a class="nav-link" href="register.html">Register</a>
                                                    <a class="nav-link" href="password.html">Forgot Password</a>
                                                </nav>
                                            </div>
                                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                                Error
                                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                            </a>
                                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                                <nav class="sb-sidenav-menu-nested nav">
                                                    <a class="nav-link" href="401.html">401 Page</a>
                                                    <a class="nav-link" href="404.html">404 Page</a>
                                                    <a class="nav-link" href="500.html">500 Page</a>
                                                </nav>
                                            </div>
                                        </nav>
                                    </div>
                                    
                                    <div class="sb-sidenav-menu-heading">Addons</div>
                                    <a class="nav-link" href="charts.html">
                                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                        Charts
                                    </a>
                                    <a class="nav-link" href="tables.html">
                                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                        Tables
                                    </a>-->
                                    <!-- titulo del menu <div class="sb-sidenav-menu-heading">Menu</div> -->
                                <!-- OTRO MENU FIN  -->
                            </div>
                        </div>
                        <div class="sb-sidenav-footer">
                            <div class="small">Logged in as:</div>
                            <?php echo $usuario ?>
                        </div>
                    </nav>
            </div>   
        <!-- FIN MENU PRINCIPAL -->

    </body>
</html>