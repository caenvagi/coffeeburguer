<?php

    include '../conexion/conexion.php';
    include '../conexion/config.php';
    include '../conexion/conexionPDO.php';

    // inicio de sesion
        session_start();
        
        $mesas = $_GET['pedido_mesa'];
        $_SESSION['ides'] = $mesas;
        
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
    
    $sentencia = $pdo->prepare("SELECT      *
                                FROM        productos as pro
                                INNER JOIN  categorias as cat on pro.producto_categoria = cat.categoria_id
                                ORDER BY    categoria_id");     
    $sentencia ->execute();
    $listaproductos = $sentencia -> fetchAll(PDO::FETCH_ASSOC);
    //print_r($listaproductos);

    $sentencia1 = $pdo->prepare("SELECT * FROM `pedido_detalle`");
    $sentencia1 ->execute();
    $listapedidos = $sentencia1 -> fetchAll(PDO::FETCH_ASSOC);
    //print_r($listapedidos);

    // consulta ingreso de datos a base datos   
        error_reporting(0);
        $host='localhost'; #tu servidor o localhost
        $usuario='root'; #usuario de la base de datos
        $password=''; #contraseña de la base de datos
        $bd='burguermirador'; #base de datos

    #Petición de conexión
        $conexion = new mysqli($host,$usuario,$password,$bd) or die('could not connect to database');

    #variable con el registro que se va a insertar
        $registro_id = $_GET['pedido_mesa']; 
        $fecha = date("y/m/d/H/i/s");
        $mesero = trim($_POST['pedido_mesero']);
        $mesero1 = trim($_POST['pedido_mesero_nombre']);
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
            $queryOrder = "INSERT INTO `pedidos`(`pedido_fecha`, `pedido_mesero`, `pedido_mesero_nombre`, `pedido_mesa`, `pedido_estado`)
                            VALUES ('$fecha','$mesero','$mesero1','$mesa','$estado')";                            

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
        
    // Para mesa abierta
        $queryUlt = "   SELECT  codigo_recibo
                        FROM    pedidos 
                        WHERE   pedido_mesa = $registro_id and pedido_estado='abierta'
        ";
        $ultimo = $mysqli->query($queryUlt);

    // Para mesa abierta
        $queryUlt1 = "  SELECT  codigo_recibo
                        FROM    pedidos 
                        WHERE   pedido_mesa = $registro_id and pedido_estado='abierta'
        ";
        $ultimo1 = $mysqli->query($queryUlt1);

    // Para mesa abierta
        $query_productos1 = "   SELECT      codigo_recibo_detalle as recibo,
                                            COUNT(detalle_cantidad) AS totalcant,
                                            sum(detalle_cantidad * detalle_precio) as total
                                FROM        pedido_detalle AS PD
                                INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                                INNER JOIN  categorias AS CA ON PR.producto_categoria=CA.categoria_id
                                INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                                WHERE       pedido_mesa = $registro_id and detalle_estado = 'abierta'
                            ";
        $productos1 = $mysqli->query($query_productos1);

    // Para categorias
        $categorias = $mysqli-> query(" SELECT  * 
                                        FROM    categorias
                                    ") or die($conexion->error);
                                    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require '../logs/head.php'; ?>
        <?php require 'task-add.php'; ?>
        <script src="../js/funcion.js"></script>
    </head>
    <body>
        <?php require '../logs/nav-bar.php'; ?>
        <div id="layoutSidenav_content" class="layoutSidenav" >
            <main>
            <div class="card-header BG-WARNING mt-1"><font color="white">PEDIDOS</font></div>
                <div class="container-fluid"> 
                    <div class="container mt-3">
                        <div class="row justify-content-center">
                            <!-- card principal productos -->
                                <div class="col col-md-6 col-lg-6 m-2 p-0">
                                    <div class="card">
                                        <div class="card-header">
                                        PRODUCTOS                                        
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
                                                <div class="rows">
                                                    <?php foreach ($listaproductos as $producto) { ?>
                                                        <form   method="POST" action="task-add.php?pedido_mesa=<?php echo $mesas ?>"  id="task-form1">
                                                            <button class="product_item btn btn-outline-dark mt-2 mb-0 mx-1" id="product_item" type="submit" value="product_item" category="<?php echo $producto['categoria_nombre']; ?>">
                                                                <?php foreach ($ultimo as $recibo) { ?>
                                                                <input type="hidden" value="<?php echo $recibo['codigo_recibo']; ?>" id="codigo_recibo_detalle" class="codigo_recibo_detalle" name="codigo_recibo_detalle"  readonly></input>
                                                                <?php } ?>
                                                                <input type="hidden" value="<?php echo $mesas ?>" id="detalle_mesa" class="detalle_mesa" name="detalle_mesa" readonly></input>
                                                                <input type="hidden" value="<?php echo $producto['producto_id']; ?>" id="detalle_producto" class="detalle_producto" name="detalle_producto" readonly></input>
                                                                <input type="hidden" value="1" id="detalle_cantidad" class="detalle_cantidad" name="detalle_cantidad" readonly></input>
                                                                <input type="hidden" value="<?php echo $producto['producto_precio']; ?>" id="detalle_precio" class="detalle_precio" name="detalle_precio" readonly></input>
                                                                <input type="hidden" value="abierta"id="detalle_estado" class="detalle_estado" name="detalle_estado" readonly></input>
                                                                <div class="img1">
                                                                    <span><img class="avatar3" src="<?php echo $producto['producto_img']; ?>" style="font-size:30px"></img></span>
                                                                </div>
                                                                <p style="font-size: 12px ; align-items: stretch; text-align: center">
                                                                    <?php echo $producto['producto_nombre']; ?>
                                                                    <br>$&nbsp;<?php echo $producto['producto_precio']; ?></p>
                                                            </button>
                                                        </form>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <!-- fin listado productos -->
                                    </div>
                                </div>
                            <!-- fin card principal productos -->
                            <!-- inicio listado pedido -->
                                <div class="col col-md-5 col-lg-5 m-2 p-0">
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
                                                    <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> &nbsp;Producto guardado...
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
                                            PEDIDO PARA LA MESA <?php echo $mesas ?>
                                        </div> 
                                        <table class="table table-bordered table-sm text-center">
                                            <thead>
                                                <td><b>PRODUCTO</b></td>
                                                <td><b>CANT</b></td>
                                                <td><b>PRECIO</b></td>
                                                <td><b>BORRAR</b></td>
                                                
                                            </thead>
                                            <tbody id="tasks" class="text-center">
                                            </tbody>
                                        </table>
                                        <div class="total1" id="total1">
                                            <div style="width: calc(100% - 24px)">
                                                    <?php foreach ($ultimo1 as $rec) { ?>
                                                <form method="POST" action="task-update.php?pedido_mesa=<?php echo $registro_id?>&codigo_recibo=<?php echo $rec['codigo_recibo']; ?>">
                                                    <?php } ?>
                                                    <?php foreach ($productos1 as $prod) { ?> 
                                                    <button class="total-boton">
                                                        <div class="total2">
                                                            <div class="total3">
                                                                <p class="total4"><?php echo $prod['totalcant']; ?></p>
                                                            </div>
                                                                <p class="total5">&nbsp;&nbsp;&nbsp;&nbsp;Confirmar pedido:</p>
                                                        </div>
                                                        <div class="total6">
                                                            <p class="total7">$&nbsp;<?php echo number_format($prod['total'], 0, ",", "."); ?></p>
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"><path d="M9.993 18c.263.002.516-.099.705-.281l5.009-5.01a1.002 1.002 0 0 0 0-1.418l-5.01-5.01a1.001 1.001 0 0 0-1.416 1.417l4.3 4.302-1 1.002-3.3 3.3A1.002 1.002 0 0 0 9.993 18Z"></path>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    <?php } ?>
                                                    <label type="text" id="nombre"></label><br>
                                                </form>
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
       <script>
        
       </script>
                                            
    </body>
</html>                                    