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

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
    
    include '../conexion/conexion.php';
    
    // consulta ingreso de datos a base datos    
        if(isset($_POST['register'])){        
            if(strlen($_POST['mesas_nombre']) >= 1 && strlen($_POST['mesas_estado']) >= 1){
                $mesa = trim($_POST['mesas_nombre']);
                $estados = trim($_POST['mesas_estado']);

                $consulta = "   INSERT INTO mesa(mesas_nombre,mesas_estado) 
                                VALUES ('$mesa','$estados')";
                
                $resultado = mysqli_query($mysqli,$consulta);
                
                if($resultado){
                    header('location:mesas.php?mensaje=guardado')
                    ?>
                    <h3 class="ok">Registro guardado </h3>
                    <?php                                
                } else {header('location:mesas.php?mensaje=falta')
                    ?>                    
                    <h3 class="bad">Registro no guardado</h3>                    
                    <?php
                    } 
                } else {header('location:mesas.php?mensaje=nada')
                    ?>                    
                    <h3 class="bad">ingrese los datos</h3>
                    <?php 
            }                
        }
    //
    // lista de mesas  
        $query_mesa =   "   SELECT  *  
                            FROM mesa
                        ";
        $mesas = $mysqli->query($query_mesa);
    //    
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
                    <div class="card-header BG-WARNING mt-1"><font color="white">PEDIDOS</font></div>
                    <div class="container mt-1">
                        <div class="row justify-content-center">
                            <!-- inicio formulario -->
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ingresar Mesa nueva:
                                        </div> 
                                        <form id="mesas" name="mesas" class="sm p-4" action="mesas.php" method="POST">
                                                <input type="hidden" class="form-control" name="mesas_id" id="mesas_id" placeholder="mesas_id" aria-label="id" aria-describedby="basic-addon1" readonly></input>
                                                <input type="hidden" class="form-control" name="mesas_estado" id="mesas_estado"  value="cerrada" placeholder="mesas_estado" aria-label="mesas_estado" aria-describedby="basic-addon1"></input>  
                                                <input type="hidden" class="form-control" name="mesas_nombre" id="mesas_nombre"  value="mesa" placeholder="mesas_nombre" aria-label="mesas_nombre" aria-describedby="basic-addon1"></input>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-warning btn btn-block" name="register" href="mesas.php"><i class="bi bi-plus-lg text-white">&nbsp;Crear Mesa</i></button>
                                            </div>     
                                        </form>        
                                    </div> 
                                </div>
                            <!-- fin formulario -->
                            <!-- inicio tabla -->    
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            Listado de mesas:
                                        </div>
                                        <div class="p-2">
                                            <table class="table table-sm table-bordered text-center table-hover" style="font-size: 14px">
                                                <thead>                                                    
                                                    <tr class="table-active">                                                        
                                                        <th align="center">MESA</th>
                                                        <th align="center">ESTADO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($fila = $mesas->fetch_array()) {
                                                        $id = $fila['mesas_id'];
                                                        $nombre = $fila['mesas_nombre'];
                                                        $estado = $fila['mesas_estado'];
                                                        if ($estado == 'cerrada') {
                                                            $label_class = 'badge bg-danger';
                                                        } elseif ($estado == 'abierta') {
                                                            $label_class = "badge bg-success" ;
                                                        } elseif ($estado == 'por entregar') {
                                                            $label_class = 'badge bg-primary badge';
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td align="center"><?php echo $id; ?></td>
                                                        <td align="center" class="label <?php echo $label_class; ?>"><?php echo $estado; ?></td>
                                                        
                                                    </tr>
                                                        <?php } ?>
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
                                                        <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> &nbsp;Mesa Ingresada...
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
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!-- fin tabla -->
                        </div>    
                    </div>
                </div>
            </main>
            <?php require '../logs/nav-footer.php'; ?>
        </div>
        <script src="../js/mensajes.js"></script>
    </body>
</html>