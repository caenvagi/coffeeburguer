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

    include '../conexion/conexion.php';
    
    // consulta ingreso de datos a base datos    
        if(isset($_POST['register'])){
        
            if(strlen($_POST['producto_nombre']) >= 1 && strlen($_POST['producto_precio']) >= 1 && strlen($_POST['producto_cantidad']) >= 1 && strlen($_POST['producto_categoria']) >= 1 && strlen($_POST['producto_img']) >= 1){

                
                $producto = trim($_POST['producto_nombre']);
                $valor = trim($_POST['producto_precio']);
                $cantidad = trim($_POST['producto_cantidad']);
                $categoria = trim($_POST['producto_categoria']);
                $estacion = trim($_POST['producto_estacion']);
                $img = trim($_POST['producto_img']);
                
                $consulta = "   INSERT INTO productos(producto_nombre, producto_precio, producto_cantidad, producto_categoria, producto_img, producto_estacion) 
                                VALUES ('$producto','$valor','$cantidad','$categoria','$img','$estacion')";
                
                $resultado = mysqli_query($mysqli,$consulta);
                
                if($resultado){
                    header('location:producto_nuevo.php?mensaje=guardado')
                    ?>
                    <h3 class="ok">Registro guardado </h3>

                    <?php                                
                } else {header('location:producto_nuevo.php?mensaje=falta')
                    ?>
                    
                    <h3 class="bad">Registro no guardado</h3>
                    
                    <?php
                    } 
                } else {header('location:producto_nuevo.php?mensaje=nada')
                    ?>
                    
                    <h3 class="bad">ingrese los datos</h3>
                    <?php 
            }
                
        }
    //

    // Para el combox
    $query1 = "  SELECT * 
                FROM categorias 
                ";
    $categorias = $mysqli->query($query1);

   

    // Para el combox
    $query3 = "  SELECT * 
                FROM producto_estacion 
                ";
    $estacion = $mysqli->query($query3);

    
        
    // lista de porductos  
        $query_productos = "SELECT  *  
                            FROM productos AS PR
                            INNER JOIN categorias AS CT ON CT.categoria_id = PR.producto_categoria
                            INNER JOIN producto_estacion as PE ON PE.estacion_id = PR.producto_estacion
                            ORDER BY categoria_id
                            ";
        $productos = $mysqli->query($query_productos);

        // lista de porductos  
        $query_productos1 = "SELECT  *  
                            FROM productos AS PR
                            INNER JOIN categorias AS CT ON CT.categoria_id = PR.producto_categoria
                            INNER JOIN producto_estacion as PE ON PE.estacion_id = PR.producto_estacion
                            ORDER BY categoria_id
                            ";
        $productosEditar = $mysqli->query($query_productos1);
    //    

    date_default_timezone_set('America/Bogota');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
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
            <div class="card-header BG-DANGER mt-1"><b style="color: white;"><span class="material-icons">fastfood</span>&nbsp;&nbsp;INGRESAR PRODUCTOS</b></div>
                <div class="container-fluid px-3"> 
                
                    <div class="container mt-1 p-2 rounded-3">
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
                                    <!-- Mensaje guardado -->
                                    <?php
                                    if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'guardado') {
                                    ?>
                                        <div class="alerta alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> &nbsp;Producto Guardado...
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
                                    <?php } ?>
                            <!-- fin alertas -->
                        <div class="row justify-content">

                                <!--  Modal trigger button  -->
                                    <div class="col col-sm-3 col-md-4">
                                        <button type="button" class="btn btn-outline-danger btn-md mb-2" data-bs-toggle="modal" data-bs-target="#modalId">
                                            <strong>+ Producto</strong>
                                        </button>
                                    </div>
                                <!--  Modal trigger button  -->    

                                <!-- modal ingreso PRODUCTOS -->
                                    <!-- Modal Body-->
                                    <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId"><span class="material-icons">fastfood</span>&nbsp;&nbsp;Ingresar producto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                    <!-- formulario ingresar PRODUCTO -->
                                                        <div class="col-md-12">
                                                            <div class="card border-4 rounded-3" style="background-color: ;">
                                                                <form id="ventas" name="ventas" class="sm p-4" action="producto_nuevo.php" method="POST">
                                                                    <input type="hidden" class="form-control" name="id" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" readonly></input>
                                                                        
                                                                        <label class="form-label">Nombre producto: </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons">fastfood</span></i>&nbsp;</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="producto_nombre" placeholder="Nombre" aria-label="producto" aria-describedby="basic-addon1" required autofocus></input>
                                                                        </div>
                                                                        <label class="form-label">Precio: </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-cash"></i>&nbsp;</span>
                                                                            </div>
                                                                            <input type="number" class="form-control" name="producto_precio" placeholder="$" aria-label="valor" aria-describedby="basic-addon1" required autofocus></input>
                                                                        </div>
                                                                        <label class="form-label">Cantidad: </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-clipboard-list'></i>&nbsp;</span>
                                                                            </div>
                                                                            <input type="number" class="form-control" name="producto_cantidad" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon1" required autofocus></input>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label class="form-label">Categoria </label>
                                                                                <div class="input-group mb-1">
                                                                                    <div class="input-group-prepend">
                                                                                        <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-chalkboard-teacher'></i>&nbsp;</label>
                                                                                    </div>
                                                                                    <select class="form-select custom-select" id="categoria" name="producto_categoria" required autofocus>
                                                                                        <option hidden selected>Categoria</option>
                                                                                            <?php while ($row = $categorias->fetch_assoc()) { ?>
                                                                                        <option value="<?php echo $row['categoria_id']; ?>"><?php echo $row['categoria_id']; ?>-<?php echo $row['categoria_nombre']; ?></option>
                                                                                        
                                                                                            <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                        </div>

                                                                        <div class="mb-1">
                                                                            <label class="form-label">Estacion de trabajo </label>
                                                                                <div class="input-group mb-1">
                                                                                    <div class="input-group-prepend">
                                                                                        <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-coffee'></i>&nbsp;</label>
                                                                                    </div>
                                                                                    <select class="form-select custom-select" id="estacion" name="producto_estacion" required autofocus>
                                                                                        <option hidden selected>Estacion</option>
                                                                                            <?php while ($row = $estacion->fetch_assoc()) { ?>
                                                                                        <option value="<?php echo $row['estacion_id']; ?>"><?php echo $row['estacion_id']; ?>-<?php echo $row['estacion_nombre']; ?></option>
                                                                                        
                                                                                            <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                        </div>

                                                                        <input value="../assets/img/logo.png"  type="hidden" class="form-control" id="img" name="producto_img" placeholder="img" aria-label="img" aria-describedby="basic-addon1" required autofocus>
                                                                        <br>
                                                                        <div class="d-grid gap-2">
                                                                            <button type="submit" class="btn btn-danger btn btn-block" name="register" href="producto_nuevo.php"><i class="bi bi-plus-lg text-white">&nbsp;GUARDAR</i></button>
                                                                        </div>
                                                                </form>
                                                            </div>
                                                        </div>                                                       
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Body-->
                                <!-- modal ingreso PRODUCTOS -->    

                                <!-- inicio tabla -->    
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                Listado de productos:
                                            </div>
    
                                            <div class="p-0">
                                                <table id="tabla-productos" class="table table-sm table-borderless table-hover mt-0 table text-center table align-middle" style="font-size: 12px">
                                                    <thead>                                                    
                                                        <tr class="table-active">                                                        
                                                            <th COLSPAN=2 align="center">PRODUCTO</th>
                                                            <th align="center">PRECIO</th>
                                                            <th colspan=2 align="center">CATEGORIA</th>
                                                            <th>ESTACION</th>                                               
                                                            <th>EDITAR</th>
                                                        </tr>
                                                    </thead>
    
                                                    <tbody>
                                                        <?php
                                                        while ($fila = $productos->fetch_array()) {
                                                            $id = $fila['producto_id'];
                                                            $img = $fila['producto_img'];
                                                            $nombre = $fila['producto_nombre'];
                                                            $precio = $fila['producto_precio'];
                                                            $categoria = $fila['categoria_nombre'];
                                                            $catimg = $fila['categoria_img'];
                                                            $estacion = $fila['estacion_nombre'];
                                                            
                                                        ?>
                                                        <tr>
                                                            <td class="avatar4" align="center"><img class="avatar3" src="<?php echo $img ?>" ></img></td>
                                                            <td align="center"><?php echo $nombre; ?></td>
                                                            <td align="right">$<?php echo number_format($precio, 0, ",", "."); ?></td>
                                                            <td align="center"><?php echo $categoria; ?></td>
                                                            <td align="center"><img class="avatar3" src="<?php echo $catimg ?>" ></img></td>
                                                            <td align="center"><?php echo $estacion; ?></td>
                                                            <td align="center"><a data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $id ?>"
                                                                                    title="Editar" class="btn btn-outline-success btn-xs">
                                                                                    <i class="bi bi-pencil-square"></i></a></td>
                                                            
                                                        </tr>
                                                        <?php  }  ?>
                                                    </tbody>
                                                    
                                                    <tfoot>                                                    
                                                    </tfoot>
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <!-- fin tabla guias hoy -->

                                <!-- modal editar producto -->
                                    <!-- Modal -->
                                    <?php
                                                        while ($fila = $productosEditar->fetch_array()) {
                                                            $id = $fila['producto_id'];
                                                            $img = $fila['producto_img'];
                                                            $nombre = $fila['producto_nombre'];
                                                            $precio = $fila['producto_precio'];
                                                            $categoria = $fila['categoria_id'];            
                                                            $categoriaNombre = $fila['categoria_nombre'];
                                                            $catimg = $fila['categoria_img'];
                                                            $estacion = $fila['estacion_id'];
                                                            $estacionNombre = $fila['estacion_nombre'];
                                                            $cantidades = $fila['producto_cantidad'];
                                                            
                                                        ?>
                                    <form id="productos" name="productos" class="row g-0 p-2" action="productos_editarproceso.php" method="POST">
                                        <div class="modal fade" id="exampleModal<?php echo $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><span class="material-icons">fastfood</span>&nbsp;Modificar Producto <br></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>    
                                                    <div class="modal-body">

                                                    <input type="hidden" class="form-control" name="producto_id" id="producto_id" value="<?php echo $id; ?>" placeholder="producto_id" aria-label="producto_id" aria-describedby="basic-addon1" readonly required autofocus>
                                                        
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons">fastfood</span>&nbsp;</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="producto_nombre" id="producto_nombre" value="<?php echo $nombre; ?>" placeholder="producto_nombre" aria-label="producto_nombre" aria-describedby="basic-addon1" required autofocus>
                                                        </div>

                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-cash"></i>&nbsp;</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="precio" id="precio" placeholder="Precio" value="<?php echo $precio; ?>" aria-label="precio" aria-describedby="basic-addon1" required autofocus>
                                                        </div>

                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-clipboard-list'></i>&nbsp;</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="cantidad" value="<?php echo $cantidades; ?>" aria-label="cantidad" aria-describedby="basic-addon1"  required autofocus>
                                                        </div>

                                                        <div class="mb-1">
                                                            <label class="form-label">Categoria </label>
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-chalkboard-teacher'></i>&nbsp;</label>
                                                                    </div>
                                                                    <select class="form-select custom-select" id="producto_categoria" name="producto_categoria" autofocus>
                                                                        <option value="<?php echo $categoria; ?>"selected><?php echo $categoriaNombre; ?></option>
                                                                            <?php
                                                                             //Para el combox
                                                                            $query2 = "  SELECT * 
                                                                            FROM categorias 
                                                                            ";
                                                                        $categoriasEditar = $mysqli->query($query2);
                                                                        ?>
                                                                        <?php while ($row = $categoriasEditar->fetch_assoc()) { ?>
                                                                        <option value="<?php echo $row['categoria_id']; ?>"><?php echo $row['categoria_id']; ?>-<?php echo $row['categoria_nombre']; ?></option>
                                                                            <?php } ?>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="mb-1">
                                                            <label class="form-label">Estacion de trabajo </label>
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-coffee'></i>&nbsp;</label>
                                                                    </div>
                                                                    <select class="form-select custom-select" id="producto_estacion" name="producto_estacion" autofocus>
                                                                        <option value="<?php echo $estacion; ?>" selected><?php echo $estacionNombre; ?></option>
                                                                        <?php 
                                                                        // Para el combox
                                                                            $query4 = "  SELECT * 
                                                                                        FROM producto_estacion 
                                                                                        ";
                                                                            $estacionEditar = $mysqli->query($query4);
                                                                            ?>    
                                                                        <?php while ($row = $estacionEditar->fetch_assoc()) { ?>
                                                                        <option value="<?php echo $row['estacion_id']; ?>"><?php echo $row['estacion_id']; ?>-<?php echo $row['estacion_nombre']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" value="editar" class="btn btn-danger btn btn-block">Guardar cambios</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>    
                                    <?php } ;  ?> 
                                <!-- modal editar producto -->  
                            </div>    
                        </div>
                    </div>
                </main>
                <?php require '../logs/nav-footer.php'; ?>
            </div>
            <script src="../js/mensajes.js"></script>
    </body>
</html>
