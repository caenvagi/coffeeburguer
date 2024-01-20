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
    
        if(strlen($_POST['id']) >= 1 && strlen($_POST['nombre']) && strlen($_POST['cargo']) && strlen($_POST['direccion']) && strlen($_POST['telefono']) && strlen($_POST['email'])>= 1 && strlen($_POST['usuario']) && strlen($_POST['clave']) && strlen($_POST['tipo_usuario']) && strlen($_POST['foto1']) && strlen($_POST['foto2']) && strlen($_POST['activo'])){

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
            $activo = trim($_POST['activo']);
            
            $consulta = "   INSERT INTO usuarios(id, nombre, cargo, direccion, telefono, email, usuario, clave, tipo_usuario, foto1, foto2, activo) 
                            VALUES ('$id','$nombre','$cargo','$direccion','$telefono','$email','$usuario','$clave','$tipo','$foto','$fotos','$activo')";
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
    $query = "  SELECT id_tipo_usuario, tipo_usuario 
                FROM tipo_usuarios
                WHERE id_tipo_usuario > 2
                ";
    $resultado1 = $mysqli->query($query);

    // Para lista de usuarios
    $query = "  SELECT * 
                FROM usuarios
                ";
    $resultado2 = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="es">
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
                        <div class="card-header BG-primary mt-1"><b style="color: white;">Empleados</b></div>
                    <!-- FIN BARRA NAVEGACIÓN -->
                        <div class="container mt-1 p-4 rounded-3" style="background-color: ;">
                            <div class="row justify-content">
                                
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
                                            <h5><i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> Usuario creado.</h5>
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
                                
                                <!-- modasl ingreso empleados -->
                                    <!--  Modal trigger button  -->
                                    <div class="col col-sm-3 col-md-4">
                                        <button type="button" class="btn btn-outline-primary btn-md mb-2" data-bs-toggle="modal" data-bs-target="#modalId">
                                            <strong>+ Empleado</strong>
                                        </button>
                                    </div>
                                    <!-- Modal Body-->
                                    <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId"><i class="fa fa-user-circle" style='font-size:24px'></i>&nbsp;&nbsp;Ingresar empleado</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <!-- formulario ingresar USUARIO -->
                                                            <div class="col-md-12">
                                                                <div class="card border-4 rounded-3" style="background-color: ;">
                                                                    <form id="usuario" name="usuario" class="row g-0 p-2" action="usuarios_nuevos.php" method="POST">
                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-alt"></i>&nbsp;</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" id="id" name="id" placeholder="cedula" aria-label="cedula" aria-describedby="basic-addon1" required autofocus>
                                                                        </div>
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
                                                                            <label class="form-label"></label>
                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-user-tie'></i>&nbsp;</label>
                                                                                </div>
                                                                                    <select class="form-select custom-select" id="cargo" name="cargo" required autofocus>
                                                                                        <option hidden selected>Cargo</option>
                                                                                        <option value="mensajero">Mesero</option>
                                                                                        <option value="Administrador">Administrador</option>
                                                                                        <option value="Programador">Tecnologia</option>
                                                                                    </select>
                                                                            </div>
                                                                        </div>
                                                                        <input value="../assets/img/logo.png"  type="hidden" class="form-control" id="foto1" name="foto1" placeholder="foto" aria-label="foto" aria-describedby="basic-addon1" required autofocus>

                                                                        <input value="../assets/img/logo.png"  type="hidden" class="form-control" id="foto2" name="foto2" placeholder="fotos" aria-label="fotos" aria-describedby="basic-addon1" required autofocus>

                                                                        <input value="SI"  type="hidden" class="form-control" id="activo" name="activo" placeholder="activo" aria-label="activo" aria-describedby="basic-addon1" required autofocus>
                                                                        
                                                                        <div class="mb-1">
                                                                            <label class="form-label"></label>
                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-chalkboard-teacher'></i>&nbsp;</label>
                                                                                </div>
                                                                                <select class="form-select custom-select" id="tipo_usuario" name="tipo_usuario" required autofocus>
                                                                                    <option hidden selected>Rol</option>
                                                                                            <?php while ($row = $resultado1->fetch_assoc()) { ?>
                                                                                    <option value="<?php echo $row['id_tipo_usuario']; ?>"><?php echo $row['tipo_usuario']; ?>
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
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Body-->
                                <!-- modasl ingreso empleados -->
                                
                                <!-- tabla empleados -->
                                    <div class="col col-12 col-sm-12 col-md-12">
                                        <div>
                                            Empleados registrados:
                                        </div>
                                        <table id="tablita" class="table table table-borderless table-hover mt-3 table text-center table align-middle" style="font-size: 12px">
                                            <thead>
                                                <tr>
                                                    <th align="center">NOMBRE</th>
                                                    <th align="center">AVATAR</th>
                                                    <th align="center">CARGO</th>
                                                    <th align="center">USER</th>
                                                    <th align="center" colspan="2">ACTIVO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    while ($fila = $resultado2->fetch_array()) {
                                                        $id = $fila['id'];
                                                        $nombre = $fila['nombre'];
                                                        $cargo = $fila['cargo'];
                                                        $direccion = $fila['direccion'];
                                                        $telefono = $fila['telefono'];
                                                        $foto = $fila['foto1'];
                                                        $fotos = $fila['foto2'];
                                                        $user = $fila['usuario'];
                                                        $activo = $fila['activo'];
                                                        $activo2 = $fila['activo'];
                                                ?>
                                                        <style>
                                                            .avatar4 {
                                                                width: 3em;
                                                                border-radius:20px;
                                                                filter: grayscale(0);
                                                                }
                                                            .avatar5 {
                                                                width: 3em;
                                                                border-radius:20px;
                                                                filter: grayscale(1);
                                                                }
                                                        </style>
                                                    <tr>
                                                        <td align="center"><a href="usuario_perfil.php?id=<?php echo $id; ?>"><?php echo $nombre; ?></a></td>
                                                        <td><?php if ($activo == "SI") 
                                                                {echo "<img class='avatar4' src='$foto'";
                                                                }else 
                                                                {echo 
                                                                    "<img class='avatar5' src='$foto'";
                                                                }
                                                                ?></td>
                                                        <td align="center"><?php echo $cargo; ?></td>
                                                        <td align="center"><?php echo $user; ?></td>                                                                
                                                        <td align="center"><?php echo $activo2; ?></td>
                                                        <td>
                                                            <?php if ($activo == "SI") 
                                                                {echo "<h3 style=color:green><i class='bi bi-person-check-fill'></i></h3>";
                                                                }else 
                                                                {echo "<h3 style=color:grey><i class='bi bi-person-x-fill'></i></h3>";}
                                                                ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                            </tbody>
                                            <tfoot>                                                
                                            </tfoot>
                                        </table>
                                    </div>
                                <!-- fin tabla empleados -->    
                            </div>
                        </div>
                </div>
            </main>
            <!-- footer -->
                <?php require '../logs/nav-footer.php'; ?>
            <!-- fin footer -->
        </div> 
        <script src="../js/mensajes.js"></script>
        <script>
            var table = document.getElementById("tablita");
            var rows = table.getElementsByTagName("tr");
                for (var z = 1; z < rows.length; z++) {
            if(rows[z].cells[4].innerHTML == 'SI'){
                rows[z].style.backgroundColor = "";
            }else{
            rows[z].style.backgroundColor = "lightgray";
            }
        }
        </script>
    </body>
</html>
                                
                                        
                                            
                                        