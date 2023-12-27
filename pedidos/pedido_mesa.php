<?php

    include '../conexion/conexion.php';
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

    //consultas   
        // consulta ingreso de datos a base datos   
            error_reporting(0);
            $host='localhost'; #tu servidor o localhost
            $usuario='root'; #usuario de la base de datos
            $password=''; #contraseña de la base de datos
            $bd='burguermirador'; #base de datos

            #Petición de conexión
            $conexion = new mysqli($host,$usuario,$password,$bd) or die('could not connect to database');

            #variable con el registro que se va a insertar
            $registro_id = $_POST['pedido_mesa']; 
            $fecha = date("y/m/d/H/i/s");
            $mesero = trim($_POST['pedido_mesero']);
            $mesa = trim($_POST['pedido_mesa']);
            $estado = trim($_POST['pedido_estado']);

            #Se hace una consulta a la tabla registros de base de datos, se usa COUNT para saber cuántos registros tiene.
            $queryRegistro = $conexion->query(" SELECT COUNT(codigo_recibo) AS cantidad 
                                                FROM pedidos 
                                                WHERE pedido_mesa = $registro_id and pedido_estado='abierta'");
            $row = $queryRegistro->fetch_assoc();

            
            #Si la cantidad es mayor a 0 significa que ya hay un registro, por lo contrario, se inserta a la base de datos.
            if($row['cantidad'] > 0) {
                    $query = "  SELECT *
                                FROM pedidos
                                where  pedido_mesa = $registro_id and pedido_estado='abierta' 
                            ";
                    $pedidos = $mysqli->query($query);
            }else{
                $queryOrder = "INSERT INTO `pedidos`(`pedido_fecha`, `pedido_mesero`, `pedido_mesa`, `pedido_estado`)
                                VALUES ('$fecha','$mesero','$mesa','$estado')";                            

                if (mysqli_query($conexion, $queryOrder)) {

                    $queryAct = "UPDATE mesa SET mesas_estado = 'abierta' where mesas_id = $registro_id";
                    $pedidos2 = $mysqli->query($queryAct);

                    $query3 = " SELECT *
                                FROM pedidos
                                where  pedido_mesa = $registro_id and pedido_estado='abierta' 
                            ";
                    $pedidos = $mysqli->query($query3);
                // echo $nombre. ', registro creado con éxito';
                } else {
                    echo 'Error inesperado.';
                }
            }
        
        // para input hidden numero de mesa
        $query = "  SELECT *
                    FROM pedidos
                    where  pedido_mesa = $registro_id and pedido_estado='abierta' 
                ";
        $pedidos3 = $mysqli->query($query4);

        // Para categorias
            $categorias = $mysqli-> query(" SELECT * 
                                            FROM categorias
                                            ") or die($conexion->error);

         // Para categorias
            $productos = $mysqli-> query("  SELECT * 
                                            FROM productos as pro
                                            INNER JOIN categorias as cat on pro.producto_categoria = cat.categoria_id
                                            ORDER BY producto_categoria
                                            ") or die($conexion->error);    
        
        // Para mesa abierta
            $queryUlt = "   SELECT  codigo_recibo,
                                    pedido_mesa
                            FROM    pedidos 
                            WHERE   pedido_mesa = $registro_id and pedido_estado='abierta'
                    ";
            $ultimo = $mysqli->query($queryUlt);        
        
        // Para mesa abierta
            $query_productos1 = "   SELECT  
                                                codigo_recibo_detalle as cod,
                                                detalle_producto as prod,
                                                producto_nombre as nombre,
                                                sum(detalle_cantidad) as cant,
                                                detalle_precio as precio,
                                                sum(detalle_cantidad * detalle_precio) as total,
                                                categoria_id as categoria,
                                                pedido_mesa
                                    FROM        pedido_detalle AS PD
                                    INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                                    INNER JOIN  categorias AS CA ON PR.producto_categoria=CA.categoria_id
                                    INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                                    WHERE       pedido_mesa = $registro_id and detalle_estado = 'abierta'
                                    group by    detalle_producto
                                    order by    categoria, producto_nombre
            ";
            $productos1 = $mysqli->query($query_productos1);

        // Para mesa abierta
            $query1 = " SELECT codigo_recibo 
                        FROM pedidos 
                        WHERE codigo_recibo = (SELECT MAX(codigo_recibo) 
                        from pedidos)";
            $ultimo1 = $mysqli->query($query1);


            
    // consultas 
?>
<!DOCTYPE html>
<html lang="Es">
    <head>
        <?php require '../logs/head.php'; ?>
        <script src="../js/funcion.js"></script>
    </head>
    <body>
        <?php require '../logs/nav-bar.php'; ?>
        <div id="layoutSidenav_content" class="layoutSidenav" >
            <main>
                <div class="container-fluid"> 
                    <div class="container mt-3">
                        <div class="row justify-content-center">
                            <!-- card principal productos -->
                                <div class="col col-md-6 col-lg-6 m-0 p-0">
                                    <div class="card">
                                        <div class="card-header">
                                            PRODUCTOS
                                                <?php
                                                    while ($fila = $pedidos->fetch_array()) {
                                                        $idcod = $fila['codigo_recibo'];
                                                        $fecha = $fila['pedido_fecha'];
                                                        $mesero = $fila['pedido_mesero'];
                                                        $mesa = $fila['pedido_mesa'];
                                                        $estado = $fila['pedido_estado'];
                                                ?> 
                                                PEDIDO:&nbsp;<b><?php echo $idcod; ?></b><br>
                                                FECHA:&nbsp;<b><?php echo $fecha; ?></b></br>
                                                MESERO:&nbsp;<b><?php echo $mesero; ?></b></br>
                                                MESA:&nbsp;<b><?php echo $mesa; ?></b></br>
                                                ESTADO:&nbsp;<b><?php echo $estado; ?></b></br>
                                                
                                                <form action="pedido_nuevo.php" method="POST">
                                                    <input type="hidden" value="<?php echo $mesa; ?>" name="mesa" id="actEstado"></input>
                                                    <input type="hidden" value="<?php echo $idcod; ?>" name="codRecibo" id="actEstados"></input>
                                                    <button type="submit" value="<?php echo $mesa; ?>" id="BtnEst" name="BtnEst" class="btn btn-outline-dark btn-lg p-2 m-2">
                                                        actualizar estado
                                                    </button> 
                                                </form> 
                                                <?php } ?>
                                        </div>
                                        <!-- inicio listado categorias -->
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="wrap mt-2 mb-2">
                                                        <div class="store-wrapper">
                                                            <div class="category_list">
                                                                <ul class="ul">
                                                                    <a class="category_item" id="all" href="#"  category="all">Todos</a>
                                                                    <?php
                                                                    while ($fila = $categorias->fetch_array()) {
                                                                        $id_cat = $fila['categoria_id'];
                                                                        $cat_nombre = $fila['categoria_nombre'];
                                                                        $cat_img = $fila['categoria_img'];
                                                                        ?>
                                                                    <a class="category_item"  id="<?php echo $cat_nombre?>" href="#" category="<?php echo $cat_nombre?>" ><?php echo $cat_nombre?></a></a>
                                                                    <?php } ?>
                                                                <ul>     
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- fin listado categorias -->
                                        <!-- inicio listado productos -->
                                            <div class="container-fluid p-0 m-0">
                                                <div class="row">
                                                    <form id="task-form">
                                                        <?php while ($fila = $productos->fetch_array()) {
                                                            $id_pro = $fila['producto_id'];
                                                            $nom_pro = $fila['producto_nombre'];
                                                            $pre_pro = $fila['producto_precio'];
                                                            $cat_pro = $fila['producto_categoria'];
                                                            $cat_nom = $fila['categoria_nombre'];
                                                            $img_pro = $fila['producto_img'];
                                                            ?>
                                                            <div id="padre">
                                                                <button class="product_item btn btn-outline-dark mt-2 mb-0 mx-1"
                                                                    id="product_item"                                                                
                                                                    type="submit">                                                                
                                                            
                                                                    <input type="hidden" id="codigo_recibo_detalle" class="codigo_recibo_detalle" value="4" readonly></input>
                                                                    <input type="hidden" id="detalle_mesa" class="detalle_mesa" value="1" readonly></input>
                                                                    <input type="text" id="detalle_producto" class="detalle_producto" value="<?php echo $id_pro?>" readonly></input>
                                                                    <input type="hidden" id="detalle_cantidad" class="detalle_cantidad" value="1" readonly></input>
                                                                    <input type="hidden" id="detalle_precio" class="detalle_precio" value="<?php echo number_format($pre_pro, 0, ",", "."); ?>" readonly></input> 
                                                                    <input type="hidden" id="detalle_estado" class="detalle_estado" value="abierta" readonly></input> 
                                                                
                                                                    <div class="img1" >
                                                                        <span><img class="avatar3" src="<?php echo $img_pro?>" style=" font-size:30px"></img></span>
                                                                    </div>
                                                                    <p style="font-size: 12px ; align-items: stretch; text-align: center">
                                                                    <?php echo $nom_pro?>
                                                                    <br>
                                                                    $&nbsp;<?php echo number_format($pre_pro, 0, ",", "."); ?></p>
                                                            </button>
                                                        </div>
                                                        <?php } ?>
                                                    </form>                                                                                                            
                                                </div>
                                            </div>
                                        <!-- fin listado productos -->
                                    </div>
                                </div>
                            <!-- fin card principal productos -->
                            <!-- inicio listado pedido -->
                                <div class="col col-md-6 col-lg-6 m-0 p-0">
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
                                                if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'falta1') {
                                                ?>
                                                    <div class="alerta alert alert-warning alert-dismissible fade show" role="alert">
                                                        <strong>Error !</strong> mesa no abierta !
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
                                        <table class="table table-bordered table-sm text-center">
                                            <thead>
                                                <td>REC</td>
                                                <td>pro</td>
                                                <td>cant</td>
                                                <td>prec</td>
                                                <td>mesa</td>
                                                
                                            </thead>
                                            <tbody id="tasks" class="text-center">
                                                

                                            </tbody>

                                        </table>
                                        <!-- <?php
                                                while ($fila = $productos1->fetch_array()) {
                                                            $id_pedido = $fila['cod'];
                                                            $id = $fila['prod'];
                                                            $cant = $fila['cant'];
                                                            $nombre = $fila['nombre'];
                                                            $precio = $fila['total'];
                                                            
                                                        ?>                                           
                                        <div class="proditem" id="proditem">
                                            <div class="prod-item1">
                                                <div class="prod-item2">
                                                    <div class="delete-item">
                                                    <span class="material-symbols-outlined" style="font-size:30px">DELETE</span>
                                                    </div>
                                                    <div>
                                                        <p class="prod-nom1" id="prod-nom1" style="font-size:16px"><?php echo $nombre; ?></p>
                                                        <p class="prod-nom2" ID="prod-nom2" style="font-size:18px">$<?php echo number_format($precio, 0, ",", "."); ?></p>
                                                        <a href="" style="font-size:12px">Agregar comentario</a>
                                                    </div>
                                                    <div class="cant">
                                                        <div class="cant1">
                                                            <span class="menos" >
                                                                <span class="material-symbols-outlined" style="font-size:18px">do_not_disturb_on</span>
                                                            </span>
                                                            <input class="cant2" type="text" value="<?php echo $cant; ?>" >
                                                            <span class="mas">
                                                                <span class="material-symbols-outlined" style="font-size:18px">add_circle</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>         
                                        </div>
                                        <?php } ?>                                         -->

                                        <div class="total1" id="total1">
                                            <div style="width: calc(100% - 24px)">
                                                <button class="total-boton">
                                                    <div class="total2">
                                                        <div class="total3">
                                                            <p class="total4"></p>
                                                        </div>
                                                            <p class="total5">Agregar</p>
                                                    </div>
                                                    <div class="total6">
                                                        <p class="total7">$&nbsp;</p>
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"><path d="M9.993 18c.263.002.516-.099.705-.281l5.009-5.01a1.002 1.002 0 0 0 0-1.418l-5.01-5.01a1.001 1.001 0 0 0-1.416 1.417l4.3 4.302-1 1.002-3.3 3.3A1.002 1.002 0 0 0 9.993 18Z"></path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>                                       
                                    </div>
                                </div>
                            <!-- fin listado pedido -->                                   
                        </div>
                    </div>
                </div>
                <div id="div_rojo"></div>
            </main>
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        <script src="../js/mensajes.js"></script>
        
                                            
    </body>
</html>                                    