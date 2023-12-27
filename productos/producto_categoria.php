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
        $query_categorias = "SELECT  *  
                            FROM categorias
                            
                            ";
        $categorias = $mysqli->query($query_categorias);
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
                <div class="container-fluid px-3"> 
                <div class="card-header BG-DANGER mt-1"><font color="white">PRODUCTOS</font></div>
                    <div class="container mt-1">
                        <div class="row justify-content-center">
                            <!-- inicio formulario -->
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ingresar categoria nueva:
                                        </div> 
                                        <form id="ventas" name="ventas" class="sm p-4" action="producto_categoria.php" method="POST">
                                                
                                                <input type="hidden" class="form-control" name="id" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" readonly></input>
                                                   
                                                <label class="form-label">Nombre Categoria: </label>
                                                    <div class="input-group mb-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i     class="bi bi-newspaper"></i>&nbsp;</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="categoria_nombre" placeholder="Nombre" aria-label="producto" aria-describedby="basic-addon1" required autofocus></input>
                                                    </div>
                                                    
                                                <label class="form-label">Descripcion: </label>
                                                    <div class="input-group mb-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i     class="bi bi-cash"></i>&nbsp;</span>
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
                            <!-- fin formulario -->
                            <!-- inicio tabla -->    
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            Listado Categorias:
                                        </div>

                                        <div class="p-2">
                                            <table class="table table-sm table-bordered text-center table-hover" style="font-size: 14px">
                                                <thead>                                                    
                                                    <tr class="table-active">
                                                    <th align="center">IMAGEN</th>                                                       
                                                        <th align="center">PRODUCTO</th>
                                                        <th align="center">DESCRIPCION</th>
                                                        
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
                                                        
                                                        
                                                        
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                
                                                <tfoot>
                                                    
                                                </tfoot>
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
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!-- fin tabla guias hoy -->
                        </div>    
                    </div>
                </div>
            </main>
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        <script src="../js/mensajes.js"></script>
    </body>
</html>