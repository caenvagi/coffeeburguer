<?php
    session_start();

    require '../conexion/conexion.php';

    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
    }
    $id = $_SESSION['id'];

    $tipo_usuario = $_SESSION['tipo_usuario'];
    
    if ($tipo_usuario == 1) {
        $where = "";
    } else if ($tipo_usuario == 2) {
        $where = "WHERE id=$id";
    }

    //para buscar guias por usuario
    include '../conexion/conexion.php';

    $sql_usuarios = $mysqli->query("SELECT * FROM usuarios ") or die($mysqli->error);

    if (isset($_GET['id'])) {
    $usuario = $_GET['id'];
    $sql_usuario = $mysqli->query(" SELECT  US.id,
                                            US.nombre,
                                            US.email,
                                            US.usuario,
                                            US.tipo_cargo,
                                            US.tipo_usuario,
                                            Tu.tipo_usuario,
                                            US.direccion,
                                            US.telefono,
                                            US.foto1,
                                            US.foto2,
                                            US.activo,
                                            TC.cargo_nombre
                                    FROM usuarios as US
                                    INNER JOIN  tipo_usuarios as Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                    INNER JOIN  tipo_cargo TC ON US.tipo_cargo = TC.id_cargo
                                    WHERE id=$usuario") or die($mysqli->error);
    } else {
    $sql_usuario = $mysqli->query("   SELECT  US.id,
                                            US.nombre,
                                            US.email,
                                            US.usuario,
                                            US.tipo_cargo,
                                            US.tipo_usuario,
                                            Tu.tipo_usuario,
                                            US.direccion,
                                            US.telefono,
                                            US.foto1,
                                            US.foto2,
                                            US.activo,
                                            TC.cargo_nombre
                                    FROM usuarios as US
                                    INNER JOIN  tipo_usuarios as Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                    INNER JOIN  tipo_cargo TC ON US.tipo_cargo = TC.id_cargo
                                        WHERE id$usuario") or die($mysqli->error);
    }

    date_default_timezone_set('America/Bogota');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
	

    include '../conexion/conexion.php';
    $tipousuario = $mysqli->query("  SELECT         US.nombre,
                                                    US.email,
                                                    US.usuario,
                                                    US.tipo_usuario,
                                                    Tu.tipo_usuario,
                                                    US.direccion,
                                                    US.telefono
                                        FROM        usuarios US
                                        INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        WHERE       id=$id
                                        ") or die($mysqli->error);

    
    $tipousuario2 = $mysqli->query("  SELECT      US.id,
                                                    US.nombre,
                                                    US.email,
                                                    US.usuario,
                                                    US.tipo_usuario,
                                                    Tu.tipo_usuario,
                                                    US.direccion,
                                                    US.telefono,
                                                    US.tipo_cargo,
                                                    TC.cargo_nombre
                                        FROM        usuarios US
                                        INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        INNER JOIN  tipo_cargo TC ON US.tipo_cargo = TC.id_cargo
                                        WHERE       id=$id
                                        ") or die($mysqli->error);

    $tipofoto = $mysqli->query("      SELECT        US.id,
                                                    US.nombre,
                                                    US.email,
                                                    US.usuario,
                                                    US.tipo_usuario,
                                                    Tu.tipo_usuario,
                                                    US.direccion,
                                                    US.telefono,
                                                    US.foto1,
                                                    US.foto2,
                                                    US.activo,
                                                    TC.cargo_nombre
                                        FROM        usuarios US
                                        INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        INNER JOIN  tipo_cargo TC ON US.tipo_cargo = TC.id_cargo
                                        WHERE       id=$id
                                        ") or die($mysqli->error);
                                        
    $tipofoto1 = $mysqli->query("      SELECT        
                                        US.id,
                                        US.nombre,
                                        US.email,
                                        US.usuario,
                                        US.tipo_cargo,
                                        US.tipo_usuario,
                                        Tu.tipo_usuario,
                                        US.direccion,
                                        US.telefono,
                                        US.foto1,
                                        US.foto2,
                                        US.activo,
                                        TC.cargo_nombre
                            FROM        usuarios US
                            INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                            INNER JOIN  tipo_cargo TC ON US.tipo_cargo = TC.id_cargo
                            WHERE       id=$id
                            ") or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <script src="../js/jquery-3.5.1.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
        <?php require '../logs/head.php';?>
        <link rel="stylesheet" href="../css/estilos.css">
    </head>
    <body>
        <?php require '../logs/nav-bar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
            <div class="card-header BG-PRIMARY mt-1 "><b style="color: white;">Usuario</b></div>
                <div class="container-fluid ml-2 ">                  
                            <div class="container col-12 col-sm-12 " id="containerPerfil">
                                <div class="row col-12 col-sm-12 ">
                                    <div class="card border-light col-12 col-sm-5 col-md-4 " id="imagen">
                                        <?php
                                            while ($fila = $sql_usuario->fetch_array()) {
                                                        $foto = $fila['foto1'];
                                                        $fotos = $fila['foto2'];
                                                        $activo = $fila['activo'];
                                                        $nombre = $fila['nombre'];
                                                        $direccion = $fila['direccion'];
                                                        $telefono = $fila['telefono'];
                                                        $email = $fila['email'];
                                                        $usuario = $fila['usuario'];
                                                        $tipo = $fila['tipo_usuario'];
                                                        $cargo = $fila['tipo_cargo'];
                                                        $cargoNombre = $fila['cargo_nombre'];
                                        ?>
                                        <img class="fotoPerfil" src="<?php echo $foto ?>"></img>                                          
                                    </div>

                                    <div class="card border-light col-sm-6 col-md-7" id="datosUser">
                                        <h4 id="datosNombre"><?php echo $nombre ?></h4>
                                        <p id="datosCargo" class="datosCargo m-0"><?php echo $cargoNombre ?></p>
                                        <div class="row">
                                            <div class="card border-light col-4 col-sm-5 col-md-3" id="cardDatos">
                                                <h7 class="labelCards">Direccion</h7>
                                                <h7 class="labelCards">Telefono</h7>
                                                <h7 class="labelCards">Email</h7>
                                            </div>                                            
                                            <div class="card border-light col-7 col-sm-7 col-md-8" id="cardDatos">
                                                <h7 class="datosCards"><?php echo $direccion ?></h7>
                                                <h7 class="datosCards"><?php echo $telefono ?></h7>
                                                <h7 class="datosCards"><?php echo $email ?></h7>
                                            </div>
                                        </div>

                                        <div class="row mt-10">
                                            <div class="card border-light col-4 col-sm-5 col-md-3" id="cardDatos">
                                                <h7 class="labelCards">Usuario</h7>
                                                <h7 class="labelCards">Rol</h7>
                                                <h7 class="labelCards">Cargo</h7>
                                            </div>                                            
                                            <div class="card border-light col-7 col-sm-7 col-md-8" id="cardDatos">
                                                <h7 class="datosCards"><?php echo $usuario ?></h7>
                                                <h7 class="datosCards"><?php echo $tipo ?></h7>
                                                <h7 class="datosCards"><?php echo $cargoNombre ?></h7>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <?php } ?>
                                    <div  id="cajaBotones" class="row justify-content-center"> 
                                        <div class="row" id="">
                                            <div class="d-grid gap-2 col-4 mx-auto" >
                                                <button id="" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">Cambiar Avatar</button>
                                            </div>
                                            <div class="d-grid gap-2 col-4 mx-auto" >
                                                <button id="" type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Cambiar contraseña</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                            </div>
                        <!-- CARD PEFIL NUEVO FIN -->
                        
                        <!-- modal cambiar avatar -->
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <i class='fas fa-images' style='font-size:24px'></i>&nbsp;&nbsp;
                                            <h5 class="modal-title" id="exampleModalLabel">Cambiar Avatar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card border-4 mt-2 mb-2">
                                                <!-- <div class="card-header bg-primary text-center ">
                                                &nbsp; Actualizar avatar: &nbsp;&nbsp; <b style='font-size:24px'></b></div> -->
                                                    <form action="foto.php" method="post" enctype="multipart/form-data">
                                                        <input type="text" name="id" value="<?php echo $id; ?>" style="display: none;">
                                                        <div class="form-group M-2">
                                                            <label class="p-2" for="my-input">Selecione una imagen :</label>
                                                            <input id="my-input" class="form-control " type="file" name="nfoto" id="nfoto">
                                                        </div>
                                                        <!-- <input type="submit" value="guardar" name="guardar" id="guardar">-->
                                                        <div class="d-grid gap-2">
                                                            <button type="submit" class="btn btn-secondary btn btn-block M-2" id="guardar1" name="guardar1" ><i class='fas fa-redo'></i>&nbsp ACTUALIZAR</button>
                                                        </div>                
                                                    </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- modal cambiar avatar -->

                        <!-- modal actualizar contraseña -->
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <i class='fas fa-user-lock' style='font-size:24px'></i>&nbsp;
                                            <h5 class="modal-title" id="exampleModalLabel">Actulizar contraseña</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card border-4 mt-2 ">                                            
                                                <div class="card-body">
                                                    <form action="" method="POST" name="frmChangePass" id="frmChangePass">
                                                        <div class="form-group m-2">
                                                            <div class="input-group mb-3 m-2 mt-3">
                                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-key'></i>&nbsp;</span>                                            
                                                                <input class="form-control" type="password" name="txtPassUser"  id="txtPassUser"   placeholder="Contraseña Actual" required>
                                                                <button class="btn btn-secondary" onclick="mostrarPassword1()" type="button" id="button-addon1"><span class="fa fa-eye-slash icon"></span></button>
                                                            </div>
                                                            <div class="input-group mb-3 m-2 mt-3">
                                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-key'></i>&nbsp;</span>
                                                                <input class="form-control" type="password" name="txtNewPassUser"  id="txtNewPassUser"  placeholder="Nueva Contraseña" required>
                                                                <button class="btn btn-secondary" onclick="mostrarPassword2()" type="button" id="button-addon2"><span class="fa fa-eye-slash icon"></span></button>
                                                            </div>
                                                            <div class="input-group mb-3 m-2 mt-3">
                                                                <span class="input-group-text" id="basic-addon1"><i class='fas fa-key'></i>&nbsp;</span>
                                                                <input class="form-control" type="password" name="txtPassConfirm"  id="txtPassConfirm"  placeholder="Confirmar Contraseña" required>
                                                                <button class="btn btn-secondary" onclick="mostrarPassword3()" type="button" id="button-addon3"><span class="fa fa-eye-slash icon"></span></button>
                                                            </div>
                                                        </div>
                                                            <style>
                                                                .alertChangePass{
                                                                    text-align: center;
                                                                    font-weight: bold ;
                                                                }
                                                            </style>
                                                        <div class="alertChangePass" style="display: none;"></div>
                                                        <div class="d-grid gap-2">
                                                            <button type="submit" class="btn_save btn-secondary btn btn-block m-2" ><i class='fas fa-redo'></i>&nbsp ACTUALIZAR</button>
                                                        </div>
                                                    </form>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- modal actualizar contraseña -->
                </div>
            </main>
            <?php require '../logs/nav-footer.php'; ?> 
        </div> 
        <!-- validar contaseña javascript -->    
            <script> 
                $(document).ready(function(){

                    //cambiar password
                    $('.form-control').keyup(function(){
                        validPass();
                    });

                    //form cambiar contraseña
                    $('#frmChangePass').submit(function(e){
                        e.preventDefault();

                        var passActual = $('#txtPassUser').val();
                        var passNuevo = $('#txtNewPassUser').val();
                        var confirmPassNuevo = $('txtPassConfirm').val();
                        var action = "changePassword";

                        if(passNuevo === confirmPassNuevo){
                            $('.alertChangePass').html('<p style="color:blue;">Las contraseñas no coinciden</p>');
                            $('.alertChangepass').slideDown();
                            return false;
                        }

                        if(passNuevo.length < 5 ){
                            $('.alertChangePass').html('<p style="color:green;">La contraseña nueva debe tener al menos 5 caracteres</p>');
                            $('.alertChangePass').slideDown();
                            return false;
                        }

                        $.ajax({
                            url : 'ajax.php',
                            type : "POST",
                            async : true, 
                            data : {action:action,passActual:passActual,passNuevo:passNuevo},
                            
                            success: function(respuesta)
                            {
                                if(respuesta != 'error')
                                {
                                    var info = JSON.parse(respuesta);
                                    if(info.cod == '00'){
                                        $('.alertChangePass').html('<p style="color:green;">'+info.msg+'</p>');
                                        $('#frmChangePass')[0].reset();
                                    }else{
                                        $('.alertChangePass').html('<p style="color:red;">'+info.msg+'</p>');
                                    }
                                    $('.alertChangePass').slideDown();
                                }
                            },
                            error: function(error){
                            }
                        });
                    });     
                }); // end ready

                function validPass(){
                    var passNuevo = $('#txtNewPassUser').val();
                    var confirmPassNuevo = $('#txtPassConfirm').val();
                    if(passNuevo != confirmPassNuevo){
                            $('.alertChangePass').html('<p style="color:red;">Las contraseñas no coinciden</p>');
                            $('.alertChangepass').slideDown();
                            return false;
                        }

                        if(passNuevo.length < 5 ){
                            $('.alertChangePass').html('<p style="color:blue;">La contraseña nueva debe tener minimo 5 caracteres</p>');
                            $('.alertChangePass').slideDown();
                            return false;
                        }

                        $('.alertChangePass').html('');
                        $('.alertChangePass').slideUp();
                }
            </script>
        <!-- fin validar contaseña javascript -->  
        <!-- mostrar contaseña javascript -->        
            <script type="text/javascript">
                function mostrarPassword1(){
                    var cambio = document.getElementById("txtNewPassUser");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        var cambio = document.getElementById("txtPassConfirm");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        var cambio = document.getElementById("txtPassUser");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                    } 
                    
                    
            </script>

            <script type="text/javascript">
                function mostrarPassword2(){
                        var cambio = document.getElementById("txtNewPassUser");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        var cambio = document.getElementById("txtPassConfirm");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        var cambio = document.getElementById("txtPassUser");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                    } 
                    
                    
            </script>

            <script type="text/javascript">
                function mostrarPassword3(){
                    var cambio = document.getElementById("txtNewPassUser");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        var cambio = document.getElementById("txtPassConfirm");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        var cambio = document.getElementById("txtPassUser");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                    } 
                    
                    
            </script>
        <!-- mostrar contaseña javascript -->
    </body>
</html>

