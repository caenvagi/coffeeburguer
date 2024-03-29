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
                $tipo_pedido = trim($_POST['mesas_tipo_pedido']);
                $consmesas = trim($_POST['mesas_cons_mesas']);
                $consdomi = trim($_POST['mesas_cons_domicilios']);

                $consulta = "   INSERT INTO mesa(mesas_nombre,mesas_estado,mesas_tipo_pedido,mesas_cons_mesas,mesas_cons_domicilios) 
                                VALUES ('$mesa','$estados','$tipo_pedido','$consmesas','$consdomi')";
                
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
                            ORDER BY mesas_nombre
                        ";
        $mesas = $mysqli->query($query_mesa);
    //  
    // lista de mesas  
        $query_mesa1 =   "      SELECT * 
                                FROM mesa                  
                                ORDER BY mesas_id 
                                DESC LIMIT 1
                        ";
        $mesas1 = $mysqli->query($query_mesa1);        
    // 
    //lista poe nombre de mesa
        $query_mesa2 = "    SELECT  *
                            FROM    mesa
                            ORDER BY mesas_id DESC LIMIT 1 ";
        $mesas2 = $mysqli->query($query_mesa2); 
        
    error_reporting(1);
    error_reporting(E_ALL ^ E_NOTICE);
    // consultas
        include '../conexion/conexion.php'; 
        
        $query_mesa9 = "    SELECT  	mesas_id                                
                            FROM        mesa 
                            where       mesas_tipo_pedido = 'MESA'
                            ";

        $query_mesa11 = "       SELECT  	mesas_id                                
                                FROM        mesa 
                                where       mesas_tipo_pedido = 'DOMICILIO'
        ";
        // fin consultas
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
            <div class="card-header BG-DANGER mt-1"><span style="color: white;" class="material-symbols-outlined">food_bank</span>&nbsp;&nbsp;<b style="color: white;">INGRESAR MESAS</b></div>
                <div class="container-fluid px-2"> 
                    <div class="container mt-3 rounded-3">
                        
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
                                            <strong>Error !</strong> Mesa y/o domicilio ya existe !
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

                                <!-- botones iniciales -->
                                    <?php 
                                    if($mesas11 = mysqli_query($mysqli, $query_mesa11)){
                                        if(mysqli_num_rows($mesas11) > 0) {
                                            while ($fila = $mesas11->fetch_array()) {
                                                $idmesa11 = $fila['mesas_id'];                       
                                            }echo'
                                                                    
                                            ';
                                                mysqli_free_result($mesas11);
                                            } else{                        
                                            echo'<!--  button domicilio inicial  -->
                                            <div  id="botonDomicilio" class="d-grid gap-2 col-4" >
                                                        <form id="mesas" name="mesas" class="sm p-4" action="mesas.php" method="POST">        
                                                            
                                                                <input value="DOMICILIO-1" type="hidden"name="mesas_nombre" ></input>
                                                                <input value="cerrada" type="hidden"name="mesas_estado" ></input>
                                                                <input value="DOMICILIO" type="hidden"name="mesas_tipo_pedido" ></input>
                                                                <input value="0" type="hidden"name="mesas_cons_mesas" ></input>
                                                                <input value="1" type="hidden"name="mesas_cons_domicilios" ></input>

                                                            
                                                                <button id="boton-mesas" type="submit" name="register" class="btn btn-outline-primary btn-sm">
                                                                    <strong>+ Domicilio inicial</strong>
                                                                </button>
                                                            
                                                        </form> 
                                                    </div>      
                                                <!--  button domicilio inicial  -->
                                            ';  
                                            } 
                                    ?> <?php } ?>         
                                    
                                    <?php 
                                        if($mesas8 = mysqli_query($mysqli, $query_mesa9)){
                                            if(mysqli_num_rows($mesas8) > 0) {
                                                while ($fila = $mesas8->fetch_array()) {
                                                    $idmesa7 = $fila['mesas_id'];                       
                                                }echo'
                                                <!--  Modal trigger button  -->
                                                            <div id="botonMesa2" class="d-grid gap-2 col-4 mt-4 ">
                                                                <button id="boton-mesas" type="button" class="btn btn-outline-danger btn-md mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                    <strong>+ Mesa</strong>
                                                                </button>
                                                            </div>
                                                        <!--  Modal trigger button  -->                     
                                            ';
                                                mysqli_free_result($mesas8);
                                            } else{                        
                                            echo'<!--  button mesa inicial  -->
                                                            <div id="botonMesa1" class="d-grid gap-2 col-4" >
                                                                <form id="mesas" name="mesas" class="sm p-4" action="mesas.php" method="POST">        
                                                                    <input value="MESA-1" type="hidden"name="mesas_nombre" ></input>
                                                                    <input value="cerrada" type="hidden"name="mesas_estado" ></input>
                                                                    <input value="MESA" type="hidden"name="mesas_tipo_pedido" ></input>
                                                                    <input value="1" type="hidden"name="mesas_cons_mesas" ></input>
                                                                    <input value="0" type="hidden"name="mesas_cons_domicilios" ></input>

                                                                    
                                                                        <button id="boton-mesas" type="submit" name="register" class="btn btn-outline-success btn-sm">
                                                                            <strong>+ Mesa inicial</strong>
                                                                        </button>
                                                                    
                                                                </form> 
                                                            </div>       
                                                        <!--  button mesa inicial  -->
                                            ';  
                                            } 
                                        
                                        
                                    ?> <?php } ?>
                                <!-- botones iniciales -->

                                <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">+ Adicionar Mesas</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        while ($fila = $mesas1->fetch_array()) {
                                                            $id_mesa = $fila['mesas_id'];    
                                                            $nombre_mesa = $fila['mesas_nombre'];
                                                            $tipo_pedido = $fila['mesas_tipo_pedido'];
                                                            $consMesas = $fila['mesas_cons_mesas'];
                                                            $consDomicilio = $fila['mesas_cons_domicilios'];
                                                        ?>
                                                        <form id="mesas" name="mesas" class="sm p-4" action="mesas.php" method="POST">
                                                                
                                                                <div class="mb-1">
                                                                    <label class="form-label">Forma de pedido </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-chalkboard-teacher'></i>&nbsp;</label>
                                                                            </div>
                                                                            <select name="mesas_tipo_pedido" id="mesas_tipo_pedido" required autofocus>
                                                                                <option hidden>Seleccione forma de pedido</option>
                                                                                <option value="MESA">MESA</option>
                                                                                <option value="DOMICILIO">DOMICILIO</option>                                                    
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                                
                                                                <div class="mb-1">
                                                                    <label class="form-label">mesas_nombre </label>
                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-chalkboard-teacher'></i>&nbsp;</label>
                                                                            </div>
                                                                            <select name="mesas_nombre" id="mesas_nombre" required autofocus>
                                                                                <option hidden selected>Seleccione tipo de pedido</option>
                                                                                <?php
                                                                                //lista de mesas  
                                                                                $query_mesa5 =   "      SELECT * 
                                                                                                        FROM mesa
                                                                                                        WHERE mesas_tipo_pedido = 'MESA'                  
                                                                                                        ORDER BY mesas_id 
                                                                                                        DESC LIMIT 1                                                                           ";
                                                                                $mesas5 = $mysqli->query($query_mesa5);
                                                                                
                                                                                while ($fila = $mesas5->fetch_array()) {
                                                                                    $id_mesa = $fila['mesas_id'];    
                                                                                    $nombre_mesa = $fila['mesas_nombre'];
                                                                                    $tipo_pedido = $fila['mesas_tipo_pedido'];
                                                                                    $consecutivo = $fila['mesas_cons_mesas'];
                                                                                ?>
                                                                                <option name="nombremesa2" value="MESA-<?php echo $consecutivo +1 ?>">MESA-<?php echo $consecutivo +1 ?></option>
                                                                                <?php } ?>
                                                                                
                                                                                <?php
                                                                            // lista de mesas  
                                                                                $query_mesa6 =   "      SELECT * 
                                                                                                        FROM mesa
                                                                                                        WHERE mesas_tipo_pedido = 'DOMICILIO'                  
                                                                                                        ORDER BY mesas_id 
                                                                                                        DESC LIMIT 1                                                                           ";
                                                                                $mesas6 = $mysqli->query($query_mesa6);
                                                                                
                                                                                while ($fila = $mesas6->fetch_array()) {
                                                                                    $id_mesa = $fila['mesas_id'];    
                                                                                    $nombre_mesa = $fila['mesas_nombre'];
                                                                                    $tipo_pedido = $fila['mesas_tipo_pedido'];
                                                                                    $consecutivo = $fila['mesas_cons_domicilios'];
                                                                                ?>
                                                                                <option value="DOMICILIO-<?php echo $consecutivo +1 ?>">DOMICILIO-<?php echo $consecutivo +1 ?></option>                                                    
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                                
                                                                <input type="hidden" class="form-control" name="mesas_estado" id="mesas_estado"  value="cerrada" placeholder="mesas_estado" aria-label="mesas_estado" aria-describedby="basic-addon1"></input>
                                                                
                                                                <input type="text" class="form-control" id="mesas_cons_mesas" name="mesas_cons_mesas" placeholder="mesas_cons_mesas" required autofocus>
                                                                
                                                                <input type="text" class="form-control" id="mesas_cons_domicilios" name="mesas_cons_domicilios" placeholder="mesas_cons_domicilios" required autofocus>
                                                                
                                                                <?php } ?>

                                                                <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="submit" name="register" class="btn btn-danger">Agregar Mesa</button>
                                                            </div>                                                
                                                        </form>                                                    
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>
                                <!-- Modal -->
                                
                                <!-- inicio tabla -->    
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                Listado de mesas:
                                            </div>
                                            <div class="p-2">
                                                <table class="table table table-borderless table-hover mt-3 table text-center table align-middle" style="font-size: 12px">
                                                    <thead>                                                    
                                                        <tr class="table-active">                                                        
                                                            <!-- <th align="center">mesas_id</th> -->
                                                            <th align="center">Nombre pedido</th>
                                                            <th align="center">Estado</th>
                                                            <th align="center">Tipo pedido</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        while ($fila = $mesas->fetch_array()) {
                                                            $id = $fila['mesas_id'];
                                                            $nombre = $fila['mesas_nombre'];
                                                            $estado_pedido = $fila['mesas_tipo_pedido'];
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
                                                            <!-- <td align="center"><?php echo $id; ?></td> -->
                                                            <td align="center"><?php echo $nombre; ?></td>
                                                            <td align="center" class="label <?php echo $label_class; ?>"><?php echo $estado; ?></td>
                                                            <td align="center"><?php echo $estado_pedido; ?></td>
                                                        </tr>
                                                            <?php } ?>
                                                    </tbody>
                                                    <tfoot>                                                    
                                                    </tfoot>
                                                
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
        <script>
            $("select[name=mesas_tipo_pedido]").click(function(){
                $("select[name=mesas_tipo_pedido]").each(function(){
                    var valor5 = this.value;
                        // $('#span2').text('Va a registrar un'+' '+ valor);
                        if (valor5 == "MESA") {
                            document.getElementById("mesas_cons_mesas").value = <?php
                                            //lista de mesas  
                                            $query_mesa5 =   "      SELECT * 
                                                                    FROM mesa
                                                                    WHERE mesas_tipo_pedido = 'MESA'                  
                                                                    ORDER BY mesas_id 
                                                                    DESC LIMIT 1 ";
                                            $mesas5 = $mysqli->query($query_mesa5);
                                            
                                            while ($fila = $mesas5->fetch_array()) {                                                
                                                $consMesas1 = $fila['mesas_cons_mesas'];
                                            ?>
                                            <?php echo $consMesas1 +1 ?>
                                            <?php } ?>;
                            document.getElementById("mesas_cons_domicilios").value = 0;
    
                        }else if (valor5 == "DOMICILIO") {
                            document.getElementById("mesas_cons_mesas").value = 0;
                            document.getElementById("mesas_cons_domicilios").value =  <?php
                                            //lista de mesas  
                                            $query_mesa5 =   "      SELECT * 
                                                                    FROM mesa
                                                                    WHERE mesas_tipo_pedido = 'DOMICILIO'                  
                                                                    ORDER BY mesas_id 
                                                                    DESC LIMIT 1                                                                           ";
                                            $mesas5 = $mysqli->query($query_mesa5);
                                            
                                            while ($fila = $mesas5->fetch_array()) {
                                                $consDomicilio1 = $fila['mesas_cons_domicilios'];
                                            ?>
                                            <?php echo $consDomicilio1 +1 ?>
                                            <?php } ?>;
                        }
                        console.log(valor5)
                    });
                });
        </script>
        <script>
            $("select[name=mesas_nombre]").click(function(){
                $("select[name=mesas_tipo_pedido]").each(function(){
                    var valor6 = this.value;
                        // $('#span2').text('Va a registrar un'+' '+ valor);
                        if (valor6 == "MESA") {
                            document.getElementById("mesas_cons_mesas").value = <?php
                                            //lista de mesas  
                                            $query_mesa6 =   "      SELECT * 
                                                                    FROM mesa
                                                                    WHERE mesas_tipo_pedido = 'MESA'                  
                                                                    ORDER BY mesas_id 
                                                                    DESC LIMIT 1 ";
                                            $mesas6 = $mysqli->query($query_mesa6);
                                            
                                            while ($fila = $mesas6->fetch_array()) {                                                
                                                $consMesas3 = $fila['mesas_cons_mesas'];
                                            ?>
                                            <?php echo $consMesas3 +1 ?>
                                            <?php } ?>;
                            document.getElementById("mesas_cons_domicilios").value = 0;
    
                        }else if (valor6 == "DOMICILIO") {
                            document.getElementById("mesas_cons_mesas").value = 0;
                            document.getElementById("mesas_cons_domicilios").value =  <?php
                                            //lista de mesas  
                                            $query_mesa7 =   "      SELECT * 
                                                                    FROM mesa
                                                                    WHERE mesas_tipo_pedido = 'DOMICILIO'                  
                                                                    ORDER BY mesas_id 
                                                                    DESC LIMIT 1                                                                           ";
                                            $mesas7 = $mysqli->query($query_mesa7);
                                            
                                            while ($fila = $mesas7->fetch_array()) {
                                                $consDomicilio2 = $fila['mesas_cons_domicilios'];
                                            ?>
                                            <?php echo $consDomicilio2 +1 ?>
                                            <?php } ?>;
                        }
                        console.log(valor6)
                    });
                });
        </script>
        <script>
            
        </script> 
    </body>
</html>