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
        
            if(strlen($_POST['categoria_nombre']) >= 1 && strlen($_POST['categoria_descripcion']) >= 1 && strlen($_POST['categoria_img']) >= 1){

                
                $nombre = trim($_POST['categoria_nombre']);
                $descripcion = trim($_POST['categoria_descripcion']);
                $catimg = trim($_POST['categoria_img']);
                
                
                $consulta = "   INSERT INTO categorias(categoria_nombre, categoria_descripcion, categoria_img) 
                                VALUES ('$nombre','$descripcion','$catimg')";
                
                $resultado = mysqli_query($mysqli,$consulta);
                
                if($resultado){
                    header('location:producto_categoria.php?mensaje=guardado')
                    ?>
                    <h3 class="ok">Registro guardado </h3>

                    <?php                                
                } else {header('location:producto_categoria.php?mensaje=falta')
                    ?>
                    
                    <h3 class="bad">Registro no guardado</h3>
                    
                    <?php
                    } 
                } else {header('location:producto_categoria.php?mensaje=nada')
                    ?>
                    
                    <h3 class="bad">ingrese los datos</h3>
                    <?php 
            }
                
        }
           
    // lista de porductos  
        $query_categorias = "   SELECT  *  
                                FROM categorias  ";
        $categorias = $mysqli->query($query_categorias);

         // lista de porductos  
         $query_categorias1 = "     SELECT  *  
                                    FROM categorias  ";
        $categoriasEditar = $mysqli->query($query_categorias1);
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
            <div class="card-header BG-DANGER mt-1"><b style="color: white;"><span class="material-icons">category</span>&nbsp;&nbsp;INGRESAR CATEGORIAS</b></div>
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
                                    <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> &nbsp;Categoria Guardada...
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
                                        <strong>Error !</strong> Categoria ya existe !
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

                        <div class="row justify-content">

                            
                            
                            <!--  Modal trigger button  -->
                                <div class="col col-sm-3 col-md-4">
                                    <button type="button" class="btn btn-outline-danger btn-md mb-2" data-bs-toggle="modal" data-bs-target="#modalId">
                                        <strong>+ Categoria</strong>
                                    </button>
                                </div>
                            <!--  Modal trigger button  -->
                            
                            <!-- tabla -->    
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            Listado Categorias:
                                        </div>
                                        <div class="p-0">
                                            <table class="table table table-borderless table-hover mt-0 table text-center table align-middle" style="font-size: 12px"">
                                                <thead>                                                    
                                                    <tr class="table-active">
                                                    <th align="center">IMAGEN</th>                                                       
                                                        <th align="center">PRODUCTO</th>
                                                        <th align="center">DESCRIPCION</th>
                                                        <th align="center">EDITAR</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($fila = $categorias->fetch_array()) {
                                                        $id = $fila['categoria_id'];
                                                        $nombre = $fila['categoria_nombre'];
                                                        $descripcion = $fila['categoria_descripcion'];
                                                        $catimg = $fila['categoria_img'];                                                        
                                                    ?>
                                                    <tr>
                                                        <td align="center"><img class="avatar3" src="<?php echo $catimg ?>" ></img></td>
                                                        <td align="center"><?php echo $nombre; ?></td>
                                                        <td align="center"><?php echo $descripcion; ?></td>
                                                        <td align="center"><a data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $id ?>"
                                                                                    title="Editar" class="btn btn-outline-success btn-xs">
                                                                                    <i class="bi bi-pencil-square"></i></a></td>                                           
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>                                                
                                                <tfoot>                                                    
                                                </tfoot>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!-- tabla -->
                            
                            <!-- modal ingreso CATEGORIA -->
                                    <!-- Modal Body-->
                                    <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId"><span class="material-icons">category</span>&nbsp;&nbsp;Ingresar Categoria</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <!-- formulario ingresar PRODUCTO -->
                                                        <div class="col-md-12">
                                                            <div class="card border-4 rounded-3" style="background-color: ;">
                                                            <form id="ventas" name="ventas" class="sm p-4" action="producto_categoria.php" method="POST">
                                                
                                                                    <input type="hidden" class="form-control" name="id" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" readonly></input>
                                                                    
                                                                    <label class="form-label">Nombre Categoria: </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons">category</span>&nbsp;</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="categoria_nombre" placeholder="Nombre" aria-label="producto" aria-describedby="basic-addon1" required autofocus></input>
                                                                        </div>
                                                                        
                                                                    <label class="form-label">Descripcion: </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon1"><i class='far fa-file-alt'></i></i>&nbsp;</span>
                                                                            </div>
                                                                            <textarea rows="6" cols="50" type="textarea" class="form-control" name="categoria_descripcion" placeholder="Descripcion" aria-label="valor" aria-describedby="basic-addon1" required autofocus></textarea>
                                                                        </div>
                                                                        
                                                                        <input value="../assets/img/logo.png"  type="hidden" class="form-control" id="img" name="categoria_img" placeholder="img" aria-label="img" aria-describedby="basic-addon1" required autofocus>

                                                                        <br>

                                                                    <div class="d-grid gap-2">
                                                                        <button type="submit" class="btn btn-danger btn btn-block" name="register" href="producto_categoria.php"><i class="bi bi-plus-lg text-white">&nbsp;GUARDAR</i></button>
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
                            <!-- modal ingreso CATEGORIA-->

                            <!-- modal editar categoria -->
                                    <!-- Modal -->
                                <div class="card p-2 m-2">
                                    <?php
                                        while ($fila = $categoriasEditar->fetch_array()) {
                                                $id = $fila['categoria_id'];
                                                $nombre = $fila['categoria_nombre'];
                                                $descripcion = $fila['categoria_descripcion'];
                                                $catimg = $fila['categoria_img'];
                                    ?>
                                    <form id="categorias" name="categorias" class="row g-0 p-2" action="categorias_editarproceso.php" method="POST">
                                        <div class="modal fade" id="exampleModal<?php echo $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><span class="material-icons">category</span>&nbsp;Modificar Categoria <br></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>    
                                                    <div class="modal-body">

                                                        <input type="text" class="form-control" name="categoria_id" id="categoria_id" value="<?php echo $id; ?>" placeholder="categoria_id" aria-label="categoria_id" aria-describedby="basic-addon1" readonly required autofocus>
                                                        
                                                        <label class="form-label">Nombre Categoria: </label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons">category</span>&nbsp;</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="categoria_nombre" id="categoria_nombre" value="<?php echo $nombre; ?>" placeholder="categoria_nombre" aria-label="categoria_nombre" aria-describedby="basic-addon1" required autofocus>
                                                        </div>
                                                        <label class="form-label">Descripcion: </label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class='far fa-file-alt'></i>&nbsp;</span>
                                                            </div>
                                                            <textarea rows="6" cols="50" type="textarea" class="form-control" name="categoria_descripcion" placeholder="Descripcion" aria-label="categoria_descripcion" aria-describedby="basic-addon1" required autofocus><?php echo $descripcion; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger btn btn-block" name="register" href="producto_categoria.php"><i class="bi bi-plus-lg text-white">&nbsp; Actualizar</i></button>
                                                    </div>
                                                    <div class="d-grid gap-2">
                                                        
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>    
                                    </form>    
                                    <?php } ;  ?>
                                </div>         
                            <!-- modal editar categoria -->                         

                        </div>    
                    </div>
                </div>
            </main>
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        <script src="../js/mensajes.js"></script>
    </body>
</html>


