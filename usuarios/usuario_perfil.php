<?php
    session_start();

    require '../conexion/conexion.php';

    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
    }
    $id = $_SESSION['id'];
   
    $tipo_usuario = $_SESSION['tipo_usuario'];
    ;

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
    $sql_usuario = $mysqli->query("   SELECT * FROM usuarios
                                        WHERE id=$usuario") or die($mysqli->error);
    } else {
    $sql_usuario = $mysqli->query("   SELECT * FROM usuarios
                                        WHERE id=$usuario") or die($mysqli->error);
    }

    date_default_timezone_set('America/Bogota');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
	

    include '../conexion/conexion.php';
    $tipousuario = $mysqli->query("  SELECT       US.nombre,
                                                    US.email,
                                                    US.usuario,
                                                    US.tipo_usuario,
                                                    Tu.tipo_usuario,
                                                    US.direccion,
                                                    US.telefono
                                        FROM        usuarios US
                                        INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        WHERE       id=$usuario
                                        ") or die($mysqli->error);

    
    $tipousuario2 = $mysqli->query("  SELECT      US.id,
                                                    US.nombre,
                                                    US.email,
                                                    US.usuario,
                                                    US.tipo_usuario,
                                                    Tu.tipo_usuario,
                                                    US.direccion,
                                                    US.telefono,
                                                    US.cargo
                                        FROM        usuarios US
                                        INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        WHERE       id=$usuario
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
                                                    US.activo
                                        FROM        usuarios US
                                        INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                                        WHERE       id=$usuario
                                        ") or die($mysqli->error);
                                        
    $tipofoto1 = $mysqli->query("      SELECT        US.id,
                                        US.nombre,
                                        US.email,
                                        US.usuario,
                                        US.cargo,
                                        US.tipo_usuario,
                                        Tu.tipo_usuario,
                                        US.direccion,
                                        US.telefono,
                                        US.foto1,
                                        US.foto2,
                                        US.activo
                            FROM        usuarios US
                            INNER JOIN  tipo_usuarios Tu ON US.tipo_usuario = Tu.id_tipo_usuario
                            WHERE       id=$usuario
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
                <div class="container-fluid px-3">
                    <!-- BARRA NAVEGACIÓN -->
                        <div class="card-header BG-PRIMARY mt-1"><b style="color: white;">Perfil Usuario</b></div>
                            <!-- CARD PERFIL NUEVO -->
                                <div class="container col-sm-12" id="containerPerfil">
                                    <div class="row">

                                        <div class="card border-light col-sm-4" id="imagen">
                                            <?php
                                                while ($fila = $tipofoto1->fetch_array()) {
                                                            $foto = $fila['foto1'];
                                                            $fotos = $fila['foto2'];
                                                            $activo = $fila['activo'];
                                                            $nombre = $fila['nombre'];
                                                            $direccion = $fila['direccion'];
                                                            $telefono = $fila['telefono'];
                                                            $email = $fila['email'];
                                                            $usuario = $fila['usuario'];
                                                            $tipo = $fila['tipo_usuario'];
                                                            $cargo = $fila['cargo'];
                                            ?>
                                            <img class="fotoPerfil" src="<?php echo $foto ?>"></img>                                          
                                        </div>

                                        <div class="card border-light col-sm-7" >
                                            <h4 id="datosNombre"><?php echo $nombre ?></h4>
                                            <p id="datosCargo" class="datosCargo m-0"><?php echo $cargo ?></p>
                                            <div class="row">
                                                <div class="card border-light col-sm-3" id="cardDatos">
                                                    <h7 class="labelCards">Direccion</h7>
                                                    <h7 class="labelCards">Telefono</h7>
                                                    <h7 class="labelCards">Email</h7>
                                                </div>                                            
                                                <div class="card border-light col-sm-8" id="cardDatos">
                                                    <h7 class="datosCards"><?php echo $direccion ?></h7>
                                                    <h7 class="datosCards"><?php echo $telefono ?></h7>
                                                    <h7 class="datosCards"><?php echo $email ?></h7>
                                                </div>
                                            </div>

                                            <div class="row mt-10">
                                                <div class="card border-light col-sm-3" id="cardDatos">
                                                    <h7 class="labelCards">Usuario</h7>
                                                    <h7 class="labelCards">Rol</h7>
                                                    <h7 class="labelCards">Cargo</h7>
                                                </div>                                            
                                                <div class="card border-light col-sm-8" id="cardDatos">
                                                    <h7 class="datosCards"><?php echo $usuario ?></h7>
                                                    <h7 class="datosCards"><?php echo $tipo ?></h7>
                                                    <h7 class="datosCards"><?php echo $cargo ?></h7>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php } ?>
                                        <div  id="cajaBotones" class="row justify-content-center"> 
                                            <div class="row" id="">
                                                <div class="d-grid gap-2 col-4 mx-auto" >
                                                    <button id="" type="button" class="btn btn-outline-primary" >Cambiar imagen</button>
                                                </div>
                                                <div class="d-grid gap-2 col-4 mx-auto" >
                                                    <button id="" type="button" class="btn btn-outline-success" >Cambiar contraseña</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                </div>
                            <!-- CARD PEFIL NUEVO FIN -->
                        
                        
                            <!-- imagen usuario -->
                                            <style>
                                                #tercio{
                                                display: inline-block;
                                                }

                                                #avatar4{
                                                display:block;
                                                height: 200px;
                                                width: 200px;
                                                border-radius:100px;
                                                margin-left: auto;
                                                margin-right: auto;
                                                position:relative;
                                                filter: grayscale(0);
                                                z-index:1;
                                                }
                                                #avatar5{
                                                display:block;
                                                height: 200px;
                                                width: 200px;
                                                border-radius:100px;
                                                margin-left: auto;
                                                margin-right: auto;
                                                position:relative;
                                                filter: grayscale(1);
                                                z-index:1;
                                                }
                                                #icon{
                                                position: absolute;
                                                font-size:50px;
                                                top: 20px;
                                                left: 140px; /* Ajuste */
                                                z-index:2;
                                                background:white;
                                                border-radius:25px;
                                                }
                                                .card-header {
                                                    background-color: gray  !important;       
                                                }
                                            </style>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <div id="tercio" class="card p-1 m-1 border-0" >
                                                <?php
                                                    while ($fila = $tipofoto->fetch_array()) {
                                                            $foto = $fila['foto1'];
                                                            $fotos = $fila['foto2'];
                                                            $activo = $fila['activo'];
                                                ?>
                                                <?php
                                                    if ($activo == "SI") 
                                                        {echo "<img id='avatar4' class='avatar4' src='$fotos'>";
                                                        }else 
                                                        {echo "<img id='avatar5' class='avatar5' src='$fotos'>";
                                                        } ?>

                                                        <?php if ($activo == "SI") 
                                                        {echo "<p><i id='icon' style=color:green class='bi bi-person-check-fill'></i></p>";
                                                        }else 
                                                        {echo "<p><i id='icon' style=color:grey class='bi bi-person-x-fill'></i></p>";
                                                        }
                                                ?>                                                 
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <!-- fin imagen usuario -->

                            


                    <!-- TODOS LOS CARDS -->       
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    
                                    <!-- CARDS INFORMACION PERSONAL-->    
                                            <div class="card border-4">
                                                <div class="card-header text-center " >
                                                <i class='fas fa-id-card' style='font-size: 22px'></i>&nbsp; Informacion Personal: &nbsp;&nbsp; <b style='font-size: 22px'></b></div>
                                                        <table class="table table table-borderless mt-3">
                                                            <?php
                                                            while ($fila = $tipousuario->fetch_array()) {
                                                                $nombre = $fila['nombre'];
                                                                $email = $fila['email'];
                                                                $nomtipo_usuario = $fila['tipo_usuario'];
                                                                $direccion = $fila['direccion'];
                                                                $telefono = $fila['telefono'];
                                                            ?>

                                                            <TR>
                                                                <div class="TH col-sm-10 " style="float: right">
                                                                    <TH style='text-align:right ; font-size: 15px'><label class="col-sm-9">NOMBRE:</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD style="color:blue" ><b><?php echo $nombre ?></b></TD>
                                                                </div>
                                                            </TR>

                                                            <TR>
                                                                <div class="TH col-sm-12" style="float: left">
                                                                    <TH style='text-align:right '><label class="col-sm-12">DIRECCION:</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $direccion?></TD>
                                                                </div>
                                                            </TR>

                                                            <TR>
                                                                <div class="TH col-sm-12" style="float: left">
                                                                    <TH style='text-align:right'><label class="col-sm-12">TELEFONO:</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $telefono?></TD>
                                                                </div>
                                                            </TR>
                                                                
                                                            <TR>
                                                                <div class="TH col-sm-12" style="float: left">
                                                                    <TH style='text-align:right'><label class="col-sm-12">EMAIL:</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $email?></TD>
                                                                </div>
                                                            </TR>
                                                            <?php
                                                            }
                                                            ?>
                                                        </table>
                                            </div>
                                    <!-- CARDS INFORMACION PERSONAL-->
                                    
                                    <!-- CARD IMAGEN-->
                                        <div class="card border-4 mt-2 mb-2">
                                            <div class="card-header text-center ">
                                            <i class='fas fa-images' style='font-size:24px'></i>&nbsp; Cambiar Imagen: &nbsp;&nbsp; <b style='font-size:24px'></b></div>
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
                                    
                                        
                                        
                                    <!--CARD IMAGEN -->

                                </div>

                                    <!-- CARD DATOS USUARIO -->                            
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="card border-4">
                                                <div class="card-header text-center ">
                                                <i class='fas fa-id-card-alt' style='font-size:24px'></i>&nbsp; Datos usuario: &nbsp;&nbsp; <b style='font-size:24px'></b></div>
                                                        <table class="table table table-borderless mt-3">
                                                            <?php
                                                            while ($fila = $tipousuario2->fetch_array()) {
                                                                $nombre = $fila['nombre'];
                                                                $nomtipo_usuario = $fila['tipo_usuario'];
                                                                $direccion = $fila['direccion'];
                                                                $telefono = $fila['telefono'];
                                                                $id_usu = $fila['id'];
                                                                $usuario1 = $fila['usuario'];
                                                                $cargo = $fila['cargo'];
                                                                $tipo_usuario = $fila['cargo'];
                                                            ?>

                                                            <TR>
                                                                <div class="TH col-sm-10 " style="float: left">
                                                                    <TH style='text-align:right'><label class="col-sm-10">USUARIO :</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $usuario1?></TD>
                                                                </div>
                                                            </TR>

                                                            <TR>
                                                                <div class="TH col-sm-10" style="float: left">
                                                                    <TH style='text-align:right'><label class="col-sm-10">CARGO :</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $cargo?></TD>
                                                                </div>
                                                            </TR>

                                                            <TR>
                                                                <div class="TH col-sm-10" style="float: left">
                                                                    <TH style='text-align:right'><label class="col-sm-10">TIPO USUARIO :</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $nomtipo_usuario; ?></TD>
                                                                </div>
                                                            </TR>

                                                            <TR>
                                                                <div class="TH col-sm-10" style="float: left">
                                                                    <TH style='text-align:right'><label class="col-sm-10">N° USUARIO :</label></TH>
                                                                </div>
                                                                <div class="TD col-sm-6" style="float: left">
                                                                    <TD><?php echo $id_usu; ?></TD>
                                                                </div>
                                                            </TR>            

                                                            <?php
                                                                }
                                                                ?>
                                                        </table>
                                            </div>
                                    <!-- CARD DATOS USUARIO -->                                    

                                    <!--CARD CAMBIO CONTRASEÑA --> 
                                        <div class="card border-4 mt-2 ">
                                            <div class="card-header text-center ">
                                            <i class='fas fa-user-lock' style='font-size:24px'></i>&nbsp; Cambiar Contraseña: &nbsp;&nbsp; <b style='font-size:24px'></b></div>
                                                
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
                                    <!--CARD CAMBIO CONTRASEÑA -->        
                            </div>
                        </div>
                    <!-- fin TODOS LOS CARDS -->

                    <?php require '../logs/nav-footer.php'; ?>                          
                </div>
            </main>
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

