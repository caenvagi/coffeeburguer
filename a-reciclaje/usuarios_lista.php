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

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";

    
    // Para guardar el usuario nuevo
    include '../conexion/conexion.php';
	
	if(isset($_POST['register'])){
    
        if(strlen($_POST['id']) >= 1 && strlen($_POST['nombre']) && strlen($_POST['cargo']) && strlen($_POST['direccion']) && strlen($_POST['telefono']) && strlen($_POST['email'])>= 1 && strlen($_POST['usuario']) && strlen($_POST['clave']) && strlen($_POST['tipo_usuario']) && strlen($_POST['foto']) && strlen($_POST['fotos'])){

            $id = trim($_POST['id']);
            $nombre = trim($_POST['nombre']);
            $cargo = trim($_POST['cargo']);
            $direccion = trim($_POST['direccion']);
            $telefono = trim($_POST['telefono']);
            $email = trim($_POST['email']);
            $usuario = trim($_POST['usuario']);
            $clave = md5($_POST['clave']);
            $tipo = trim($_POST['tipo_usuario']);
            $foto = trim($_POST['foto1']);
            $fotos = trim($_POST['foto2']);
            
            
            $consulta = "   INSERT INTO usuarios(nombre, cargo, direccion, telefono, email, usuario, clave, tipo_usuario, foto, fotos) 
                            VALUES ('$nombre','$cargo','$direccion','$telefono','$email','$usuario','$clave','$tipo','$foto','$fotos')";
            $resultado = mysqli_query($mysqli,$consulta);
            if($resultado){
                header('location:usuarios_nuevos.php?mensaje=guardado')
                ?>
                <h3 class="ok">Registro guardado </h3>

                <?php                                
            } else {header('location:usuarios_nuevos.php?mensaje=falta')
                ?>
                
                <h3 class="bad">Registro no guardado</h3>
                
                <?php
                } 
            } else {header('location:usuarios_nuevos.php?mensaje=nada')
                ?>
                
                <h3 class="bad">ingrese los datos</h3>
                <?php 
        }
            
    }

    // Para el combox
    $query = "  SELECT id_tipo, nomtipo_usuario 
                FROM tipo_usuarios
                WHERE id_tipo > 2
                ";
    $resultado1 = $mysqli->query($query);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
            <?php require '../logs/head.php';?>
    </head>
    <body>
    <?php require '../logs/nav-bar.php'; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-3">
                <!-- BARRA NAVEGACIÓN -->
                    <?php require 'user_navegacion.php'; ?>
                <!-- FIN BARRA NAVEGACIÓN -->

                <!-- inicio form y tabla hoy -->
                    <div class="container mt-3">
                                <div class="row justify-content-center">

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
                                                <div class="alerta alert alert-success alert-dismissible fade show text-center " role="alert">
                                                    <h5><strong>Ok !</strong> Usuario creado.</h5>
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
                                                    <h5><strong>Error !</strong> @mail o Nombre o Usuario ya existen!</h5>
                                                    Intenta de nuevo
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

                                    <!-- formulario ingresar guias -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    Ingresar Usuario:
                                                </div>
                                                
                                                <form id="usuario" name="usuario" class="row g-0 p-2" action="usuarios_nuevos.php" method="POST">

                                                        <input value="<?php echo $id ?>"  type="hidden" class="form-control" name="id" placeholder="id" aria-label="id" aria-describedby="basic-addon1" required autofocus>

                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-alt"></i>&nbsp;</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" aria-label="nombre" aria-describedby="basic-addon1" required autofocus>
                                                        </div>
                                                    
                                                    
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marker-alt"></i>&nbsp;</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="direccion" placeholder="Direccion" aria-label="direccion" aria-describedby="basic-addon1" required autofocus>
                                                        </div>

                                                    
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i>&nbsp;</span>
                                                            </div>
                                                        <input value="" type="tel" class="form-control" name="telefono" placeholder="Telefono" aria-label="tel" aria-describedby="basic-addon1" minlength="12" maxlength="12" required autofocus>
                                                        </div>

                                                    
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i>&nbsp;</span>
                                                            </div>
                                                        <input  type="text" class="form-control" name="email" placeholder="Email" aria-label="email" aria-describedby="basic-addon1" required autofocus>
                                                        </div>

                                                        
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-circle"></i>&nbsp;</span>
                                                            </div>
                                                        <input  type="text" class="form-control" name="usuario" placeholder="Usuario" aria-label="usuario" aria-describedby="basic-addon1" required autofocus>
                                                        </div>

                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i>&nbsp;</span>
                                                            </div>
                                                        <input  type="text" class="form-control" name="clave" placeholder="Clave" aria-label="clave" aria-describedby="basic-addon1" minlength="5" required autofocus>
                                                        </div>
                                                        
                                                        <div class="mb-1">
                                                            <label class="form-label"> </label>
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-user-tie'></i>&nbsp;</label>
                                                                    </div>
                                                                    <select class="form-select custom-select" id="cargo" name="cargo" required autofocus>
                                                                        <option hidden selected>Cargo</option>
                                                                        <option value="mensajero">Mensajero</option>
                                                                        <option value="Administrador">Administrador</option>
                                                                        <option value="Programador">Programador</option>
                                                                            
                                                                    </select>
                                                                </div>
                                                        </div>

                                                        <input value="assets/img/logoEnvia.png"  type="hidden" class="form-control" name="foto" placeholder="foto" aria-label="foto" aria-describedby="basic-addon1" required autofocus>

                                                        <input value="../assets/img/logoEnvia.png"  type="hidden" class="form-control" name="fotos" placeholder="fotos" aria-label="fotos" aria-describedby="basic-addon1" required autofocus>

                                                        <div class="mb-1">
                                                            <label class="form-label"> </label>
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-chalkboard-teacher'></i>&nbsp;</label>
                                                                    </div>
                                                                    <select class="form-select custom-select" id="tipo_usuario" name="tipo_usuario" required autofocus>
                                                                        <option hidden selected>Rol</option>
                                                                            <?php while ($row = $resultado1->fetch_assoc()) { ?>
                                                                        <option value="<?php echo $row['id_tipo']; ?>"><?php echo $row['nomtipo_usuario']; ?>
                                                                        </option>
                                                                            <?php } ?>
                                                                    </select>
                                                                </div>
                                                        </div>    

                                                    <div class="d-grid gap-2">
                                                        <button type="submit" class="btn btn-secondary btn btn-block" name="register" href="usuarios_nuevos.php"><i class="bi bi-plus-lg text-white">&nbsp;GUARDAR</i></button>
                                                    </div>

                                                    

                                                </form>
                                            </div>
                                        </div>
                                    <!-- fin formulario ingresar guias -->
                            </div>

                            

                        </div>
                    <!-- fin form y tabla hoy -->

            </div>
        </main>
        <!-- footer -->
            <?php require '../nav-footer.php'; ?>
        <!-- fin footer -->
    </div>    





    
    <script src="../js/mensajes.js"></script>
    </body>
</html>