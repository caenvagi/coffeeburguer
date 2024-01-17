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

    header('Content-Type: text/html; charset=ISO-8859-1');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
    
    
    include_once "consulta/consultas.php";
    
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <?php require '../logs/head.php';?>
        
    </head>

    <body>
        <?php require '../logs/nav-bar.php';?>
        <!-- inicio pagina -->
            <div id="layoutSidenav_content" class=bg-light>
                <main>
                    <!-- TITULO ANTES DEL FORM Y LA TABLA -->
                    <div class="container-fluid px-2">
                        <?php require 'caja_navegacion.php'; ?>
                        <div class="container mt-3">
                            <!-- inicio de alertas -->
                                <!-- inicio de falta -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'nada') {
                                            ?>
                                                <div class="alerta alert alert-danger alert-dismissible fade show text-center" role="alert">
                                                <i class="far fa-thumbs-down" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Error !</strong> Ingresa todos los datos
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Mensaje guardado -->
                                            <?php
                                            if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'guardado') {
                                            ?>
                                                <div class="alerta alert alert-success alert-dismissible fade show text-center" role="alert">
                                                <i class="far fa-thumbs-up" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Ok !</strong> Movimiento registrado
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
                                                <i class="far fa-thumbs-down" style="font-size:24px"></i>&nbsp;&nbsp;<strong>Error !</strong> Movimiento ya existe !
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
                            <div class="row justify-content-center">
                                <!-- formulario ingresar movimientos -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                Ingresar Movimiento:
                                            </div>

                                            <style>
                                                .span3{
                                                    padding: 0px;
                                                    margin: 2px;
                                                    border-radius:5px;
                                                    outline-style: solid;
                                                    outline-width: 1px;
                                                    background: lightgreen;
                                                }
                                            </style>
                                            
                                            <form id="movimientos" name="movimientos" class="row g-0 p-2" action="consulta/ingreso.php" method="POST">
                                            
                                            <!-- <input name="id_movimiento" value="<?php echo $id_movimiento ?>"  type="hidden" class="form-control"  placeholder="id_movimiento" aria-label="id_movimiento" aria-describedby="basic-addon1" required autofocus> -->
                                            
                                            <div class="text-center">

                                            <h5 id="span1" class="span3 mt-0" align="center"><span class="span" id="span"></span></h5>

                                                <div class="form-check form-check-inline me-2">
                                                    <i class='fas fa-plus-circle'></i>
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="ingreso" required></input>
                                                    <label class="form-check-label" for="inlineRadio1">ingreso</label>
                                                </div>
                                                <div class="form-check form-check-inline m-2">
                                                    <i class='fas fa-minus-circle'></i>
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="gasto" required></input>
                                                    <label class="form-check-label" for="inlineRadio2">gasto</label>
                                                </div>

                                                <div class="form-floating m-2">
                                                    <input type="Date" name="fecha_movimiento" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                                    <label for="floatingInput">Fecha:</label>
                                                </div>

                                                <select name="usuario" id="usuario" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option value="">Selecione Usuario</option>
                                                    <?php while ($row =  $usuarios->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                    <?php } ?>
                                                </select>

                                                <select name="movimiento" id="movimiento" class="form-select mb-3 mt-1" aria-label="Default select example" required>
                                                    <option selected>Selecione Movimiento</option>
                                                    <?php while ($row =  $conceptos->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['id_concepto']; ?>"><?php echo $row['nombre_concepto']; ?></option>
                                                    <?php } ?>
                                                    <!-- <option value="" id="span1"></option>
                                                    <option id="span2"></option> -->
                                                </select>

                                                <script>
                                                    $("input[name=inlineRadioOptions]").click(function(){
                                                        var valor = this.value;
                                                        console.log(valor);
                                                        $('#span1').text('Va a registrar un'+' '+ valor);
                                                    });
                                                </script> 

                                                <div class="form-floating m-2">
                                                    <input type="text" name="desc_movimiento" class="form-control" id="floatingInput" placeholder="Input" required>
                                                    <label for="floatingInput">Descripcion</label>
                                                </div>
                                                
                                                <div class="form-floating m-2">
                                                    <input type="text" name="valor" class="form-control" id="floatingPassword" placeholder="Password" required>
                                                    <label for="floatingPassword">Valor</label>
                                                </div>

                                                <input value="<?php echo $id ?>"  type="hidden" class="form-control" name="user_login" placeholder="usuario" aria-label="user_login" aria-describedby="basic-addon1" required autofocus>
                                                
                                                <input class="form-check-input" type="hidden" name="liquidado" value="NO">

                                                <input class="form-check-input" type="hidden" name="caja_tipo" value="gasto">

                                                <div class="d-grid gap-2 m-2">
                                                    <button type="submit"  name="register" href="consulta/ingreso.php" class="btn btn-secondary btn btn-block"  ><i class="bi bi-plus-lg text-white">&nbsp;GUARDAR</i></button>
                                                </div>

                                                

                                                

                                                    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <!-- formulario ingresar movimientos -->
                                
                            </div>
                        </div>       
                </main>
                <!-- pie de pagina --> <?php require '../logs/nav-footer.php'; ?>
            </div>         
        <!-- FIN pagina -->
        <script type="text/javascript" src="../js/mensajes.js"></script>
                                                
     </body>

     
</html>
