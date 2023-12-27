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
    //    
    date_default_timezone_set('America/Bogota');

    include '../conexion/conexion.php';
    
    // consulta ingreso de datos a base datos    
        if(isset($_POST['register'])){
        
            if(strlen($_POST['pedido_mesero']) >= 1 && strlen($_POST['pedido_mesa']) >= 1){

                $fecha = date("y/m/d/H/i/s");
                $mesero = trim($_POST['pedido_mesero']);
                $mesa = trim($_POST['pedido_mesa']);
                
                
                $consulta = "   INSERT INTO pedidos(pedido_fecha, pedido_mesero, pedido_mesa) 
                                VALUES ('$fecha','$mesero','$mesa')";
                
                $resultado = mysqli_query($mysqli,$consulta);
                
                if($resultado){
                    header('location:pedido_mesa1.php?mensaje=guardado')
                    ?>
                    <h3 class="ok">Registro guardado </h3>

                    <?php                                
                } else {header('location:pedido_mesa1.php?mensaje=falta')
                    ?>
                    
                    <h3 class="bad">Registro no guardado</h3>
                    
                    <?php
                    } 
                } else {header('location:pedido_mesa1.php?mensaje=nada')
                    ?>
                    
                    <h3 class="bad">ingrese los datos</h3>
                    <?php 
            }
                
        }

        // consulta ingreso de datos a base datos    
        if(isset($_POST['codigo_recibo_detalle'])){
        
            if(strlen($_POST['codigo_recibo_detalle']) >= 1 && strlen($_POST['detalle_producto']) >= 1 && strlen($_POST['detalle_cantidad']) >= 1 && strlen($_POST['detalle_precio']) >= 1){

                $recibo = trim($_POST['codigo_recibo_detalle']);
                $producto = trim($_POST['detalle_producto']);
                $cantidad = trim($_POST['detalle_cantidad']);
                $precio = trim($_POST['detalle_precio']);
                
                
                $consulta = "   INSERT INTO pedido_detalle(codigo_recibo_detalle, detalle_producto, detalle_cantidad, detalle_precio) 
                                VALUES ('$recibo','$producto','$cantidad','$precio')";
                
                $resultado = mysqli_query($mysqli,$consulta);
                
                if($resultado){
                    header('location:pedido_mesa1.php?mensaje=guardado1')
                    ?>
                    <h3 class="ok">Registro guardado </h3>

                    <?php                                
                } else {header('location:pedido_mesa1.php?mensaje=falta1')
                    ?>
                    
                    <h3 class="bad">Registro no guardado</h3>
                    
                    <?php
                    } 
                } else {header('location:pedido_mesa1.php?mensaje=nada1')
                    ?>
                    
                    <h3 class="bad">ingrese los datos</h3>
                    <?php 
            }
                
        }
//consultas

    // Para el combox
        $query = "  SELECT * 
                    FROM usuarios 
                    ";
        $empleados = $mysqli->query($query);

    // Para categorias
        $query = "  SELECT * 
                    FROM categorias 
                    ";
        $categorias = $mysqli->query($query);

    // Para el combox ultimo valor
        $query = "  SELECT  codigo_recibo 
                    FROM    pedidos
                    ORDER BY codigo_recibo  DESC
                    LIMIT 1";
        $ultimo = $mysqli->query($query);   

     //para filtro por categorias
        if(isset($_GET["categoria_id"])){
            $id_categoria = $_GET["categoria_id"];
            $filtro_cat = $mysqli->query( " SELECT * 
                                            FROM productos
                                            WHERE producto_categoria = $id_categoria")
            or die  ($mysqli->error);   
        }else{
            $filtro_cat = $mysqli->query( " SELECT * 
                                            FROM productos
                                            order by producto_categoria
            ")
            or die  ($mysqli->error);   
        }
        
    // lista de productos  
        $query_productos = "SELECT  *  
                            FROM productos AS PR
                            INNER JOIN categorias AS CT ON CT.categoria_id=PR.producto_categoria
                            ORDER BY categoria_id asc
                            ";
        $productos = $mysqli->query($query_productos);

    // lista de productos
        // $query3 = " SELECT codigo_recibo FROM pedidos WHERE codigo_recibo = (SELECT MAX(codigo_recibo) 
        //             from pedidos)";
        // $ultimo3 = $mysqli->query($query3);

     // ultimo codigo de recibo
        $query_productos1 = "   SELECT  
                                            codigo_recibo_detalle as cod,
                                            detalle_producto as prod,
                                            producto_nombre as nombre,
                                            sum(detalle_cantidad) as cant,
                                            detalle_precio as precio,
                                            sum(detalle_cantidad * detalle_precio) as total,
                                            categoria_id as categoria
                                FROM        pedido_detalle AS PD
                                INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                                INNER JOIN  categorias AS CA ON PR.producto_categoria=CA.categoria_id
                                WHERE       codigo_recibo_detalle = (SELECT MAX(codigo_recibo) from pedidos)
                                group by    detalle_producto
                                order by    categoria, producto_nombre
        ";
        $productos1 = $mysqli->query($query_productos1); 
        
        $query1 = " SELECT codigo_recibo FROM pedidos WHERE codigo_recibo = (SELECT MAX(codigo_recibo) 
                    from pedidos)";
                $ultimo1 = $mysqli->query($query1);

        $query2 = " SELECT codigo_recibo FROM pedidos WHERE codigo_recibo = (SELECT MAX(codigo_recibo) 
                    from pedidos)";
        $ultimo2 = $mysqli->query($query2);
        
    // ultimo codigo de recibo
        $query_cant_prod = "    SELECT COUNT(detalle_producto) as total_cantidad,
                                       SUM(detalle_cantidad * detalle_precio) as total_precio 
                                FROM pedido_detalle
                                WHERE codigo_recibo_detalle = (SELECT MAX(codigo_recibo) from pedidos)";
        $cant_prod = $mysqli->query($query_cant_prod);
// consultas 

    

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
    
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
                <div class="container-fluid"> 
                    <div class="container mt-3">
                        <div class="row justify-content-center">
                            <div class="col col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        Ingresar pedido para la: <b>mesa 1</b><br>
                                        Empleado encargado:&nbsp;<b><?php echo $nombre ?></b>
                                            <?php while ($row = $ultimo2->fetch_assoc()) { ?>
                                        pedido:<b><?php echo $row['codigo_recibo']; ?></b>
                                            <?php } ?>
                                    </div>
                                    <!-- inicio listado categorias -->
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="wrap mt-2 mb-2">
                                                    <div class="store-wrapper">
                                                        <div class="category_list">
                                                            <ul class="ul">
                                                                <a class="boton" href="pedido_mesa1.php"  category="all">Todos</a>
                                                                <?php
                                                                while ($fila = $categorias->fetch_array()) {
                                                                    $id_cat = $fila['categoria_id'];
                                                                    $cat_nombre = $fila['categoria_nombre'];
                                                                    $cat_img = $fila['categoria_img'];
                                                                    ?>
                                                                <a class="boton" href="pedido_mesa1.php?categoria_id=<?php echo $id_cat?>" ><?php echo $cat_nombre?></a></a>
                                                                <?php } ?>
                                                            <ul>     
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    <!-- fin listado categorias -->                                    
                                    <!-- inicio listado productos -->
                                        <div class="container-fluid">
                                            <div class="row">
                                                <?php
                                                    while ($fila = $filtro_cat->fetch_array()) {
                                                            $id = $fila['producto_id'];
                                                            $img = $fila['producto_img'];
                                                            $nombre = $fila['producto_nombre'];
                                                            $precio = $fila['producto_precio'];
                                                            $categoria = $fila['producto_categoria'];                       
                                                           ?>
                                                <div class="col col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4" >
                                                    <form method="POST" action="pedido_mesa1.php" class="m-0">
                                                    
                                                        <?php while ($row = $ultimo1->fetch_assoc()) { ?>
                                                        <input type="hidden" name="codigo_recibo_detalle" value="<?php echo $row['codigo_recibo']; ?>"  readonly>
                                                        <?php } ?></input>
    
                                                        
                                                        <!-- <input type="submit" name="detalle_producto" value="<?php echo $id; ?>" href="pedido_mesa1.php"><div class="img1" >
                                                            <span><img class="avatar3" src="<?php echo $img ?>" style=" font-size:30px"></img></span>
                                                                </div>
                                                                <p style="font-size: 12px ; align-items: stretch; text-align: center"><?php echo $nombre; ?>
                                                                <br>
                                                                $<?php echo number_format($precio, 0, ",", "."); ?></p></input> -->

                                                        <input type="hidden" name="detalle_cantidad" value="1"></input>
                                                        <input type="hidden" name="detalle_precio" value="8000"></input>                                                        
    
                                                        

                                                        
                                                        
                                                        
                                                        <button type="submit" value="<?php echo $id ?>" name="detalle_producto" href="pedido_mesa1.php" class="btn btn-outline-dark mt-2 mb-0" id="btn-prod">
                                                                
                                                        <div class="img1" >
                                                            <span><img class="avatar3" src="<?php echo $img ?>" style=" font-size:30px"></img></span>
                                                                </div>
                                                                <p style="font-size: 12px ; align-items: stretch; text-align: center"><?php echo $nombre; ?>
                                                                <br>
                                                                $<?php echo number_format($precio, 0, ",", "."); ?></p>
                                                        </button> 
                                                    <form>                                                        
                                                </div>
                                                <?php } ?>    
                                            </div>
                                        </div>
                                    <!-- fin listado productos -->
                                </div>    
                            </div>
                            <!-- inicio listado pedido -->
                                <div class="col col-md-6 col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <!-- inicio de alertas -->

                                                <!-- inicio de falta -->
                                                <?php
                                                if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'nada') {
                                                ?>
                                                    <div class="alerta alert alert-danger alert-dismissible fade show" role="alert">
                                                        <strong>Error !</strong> Ingresa todos los datos
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <!-- inicio de falta -->
                                                <?php
                                                if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'nada1') {
                                                ?>
                                                    <div class="alerta alert alert-danger alert-dismissible fade show" role="alert">
                                                        <strong>Error !</strong> Ingresa todos los datos
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <!-- Mensaje guardado -->
                                                <?php
                                                if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'guardado') {
                                                ?>
                                                    <div class="alerta alert alert-success alert-dismissible fade show" role="alert">
                                                    <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> &nbsp;Mesa abierta...
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <!-- Mensaje guardado 1-->
                                                <?php
                                                if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'guardado1') {
                                                ?>
                                                    <div class="alerta alert alert-success alert-dismissible fade show" role="alert">
                                                    <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> &nbsp;Producto agregado...
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <!-- Mensaje falta -->
                                                <?php
                                                if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'falta') {
                                                ?>
                                                    <div class="alerta alert alert-warning alert-dismissible fade show" role="alert">
                                                        <strong>Error !</strong> Producto ya existe !
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
                                            <!-- fin alertas -->
                                            PEDIDO
                                        </div>
                                            <?php
                                                while ($fila = $productos1->fetch_array()) {
                                                            $id_pedido = $fila['cod'];
                                                            $id = $fila['prod'];
                                                            $cant = $fila['cant'];
                                                            $nombre = $fila['nombre'];
                                                            $precio = $fila['total'];
                                                            
                                                        ?>
                                        <div class="prod-item">
                                            <div class="prod-item1">
                                                <div class="prod-item2">
                                                    <div class="delete-item">
                                                    <span class="material-symbols-outlined">delete</span>
                                                    </div>
                                                    
                                                    <div>
                                                        <p class="prod-nom1"><?php echo $nombre; ?></p>
                                                        <p class="prod-nom2">$<?php echo number_format($precio, 0, ",", "."); ?></p>
                                                        <a href="">agregar comentario</a>
                                                    </div>
                                                    
                                                    <div class="cant">
                                                        <div class="cant1">
                                                            <span class="menos">
                                                                <span class="material-symbols-outlined">do_not_disturb_on</span>
                                                            </span>
                                                            <input class="cant2" type="text" value="<?php echo $cant; ?></p>">
                                                            <span class="mas">
                                                                <span class="material-symbols-outlined">add_circle</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>        
                                        </div>
                                        <?php } ?>
                                        <?php
                                            while ($fila =  $cant_prod->fetch_array()) {
                                                            $total_cantidad = $fila['total_cantidad'];
                                                            $total_precio = $fila['total_precio'];
                                                            
                                                                                  
                                        ?>

                                        <div class="total1">
                                            <div style="width: calc(100% - 24px)">
                                                <button class="total-boton">
                                                    <div class="total2">
                                                        <div class="total3">
                                                            <p class="total4"><?php echo $total_cantidad; ?></p>
                                                        </div>
                                                            <p class="total5">Agregar</p>
                                                    </div>
                                                    <div class="total6">
                                                        <p class="total7">$&nbsp;<?php echo number_format($total_precio, 0, ",", "."); ?></p>
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"><path d="M9.993 18c.263.002.516-.099.705-.281l5.009-5.01a1.002 1.002 0 0 0 0-1.418l-5.01-5.01a1.001 1.001 0 0 0-1.416 1.417l4.3 4.302-1 1.002-3.3 3.3A1.002 1.002 0 0 0 9.993 18Z"></path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <?php } ?>



                                    </div>
                                </div>
                                <!-- fin listado pedido -->                            
                            </div>
                        </div>
                    </div>   
                </main>
                <?php require '../logs/nav-footer.php'; ?>
            </div>
            <script src="../js/mensajes.js"></script>
        </body>
    </html>                           