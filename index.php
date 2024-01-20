<?php

require "conexion/conexion.php";

session_start();

if ($_POST) {

	$usuario = $_POST['usuario'];
	$password = $_POST['clave'];

	$sql = "SELECT id, clave, nombre, cargo, email, tipo_usuario, usuario, foto1, foto2 FROM usuarios WHERE usuario='$usuario'";
	//echo $sql;
	$resultado = $mysqli->query($sql);
	$num = $resultado->num_rows;

	if ($num > 0) {
		$row = $resultado->fetch_assoc();
		$password_bd = $row['clave'];

		$pass_c = md5($password);

		if ($password_bd == $pass_c) {

			$_SESSION['id'] = $row['id'];
			$_SESSION['nombre'] = $row['nombre'];
			$_SESSION['cargo'] = $row['cargo'];
			$_SESSION['direccion'] = $row['direccion'];
			$_SESSION['telefono'] = $row['telefono'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['usuario'] = $row['usuario'];			
			$_SESSION['tipo_usuario'] = $row['tipo_usuario'];			
			$_SESSION['foto1'] = $row['foto1'];
			$_SESSION['foto2'] = $row['foto2'];
			$_SESSION['activo'] = $row['activo'];

			header("location: principal/dashboard.php");
?>
		<?php
		} else {
			header('location:index.php?mensaje=password')
		?>
		<?php
		}
		} else {
		header('location:index.php?mensaje=usuario')
		?>
<?php
	}
}

echo "<link rel='stylesheet' type='text/css' href='css/estilos.css'>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Coffee burger</title>	
		
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script type="text/javascript" src="js/mensajes.js"></script>

	<!-- CSS  -->
	<link href="css/estilos.css" type="text/css" rel="stylesheet" media="screen,projection" />
	<link href="css/styles.css" rel="stylesheet" />
</head>

<body >
	<main>
		<div id="layoutAuthentication">
			<div class="row justify-content-center fondo" id="layoutAuthentication_content">
				
						<!-- <div id="fondo" class="row justify-content-center fondo"> -->
							<div class="col-lg-5 col-10">
								<div class="card shadow-lg border-0 rounded-lg mt-5 mb-0" id="card-loguin">
									<div class="card-header">
										<div >
											<img  id="logo-loguin" src="assets/img/logo.png">
										</div>
										<h4 class="text-center font-weight-light my-4">Coffee Burger "Mirador"</h4>
									</div>
									<div class="card-body">
									<!-- Mensajes -->	
										<!-- Mensaje error password -->
										<?php
										if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'password') {
										?>
											<div class="alerta alert alert-danger alert-dismissible fade show" role="alert">
												<strong>Error !</strong> Password Incorrecto
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php
										}
										?>
										<!-- fin Mensaje error password -->
										<!-- Mensaje error usuario -->
										<?php
										if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'usuario') {
										?>
											<div class="alerta alert alert-warning alert-dismissible fade show" role="alert">
												<strong>Error !</strong> Usuario Incorrecto
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php
										}
										?>
										<!-- fin Mensaje error usuario -->
									<!-- Mensajes -->
										<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											<div class="input-group  mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class='fas fa-user-circle'></i>&nbsp;</span>
												</div>
												<input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" aria-label="usuario" aria-describedby="basic-addon1">
											</div>
											<!-- <div class="form-floating mb-3">
												<input class="form-control" id="usuario" name="usuario" type="text" placeholder="usuario" />
												<label for="Usuario">Usuario</label>
											</div> -->
											<div class="input-group  mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class='fas fa-key'></i>&nbsp;</span>
												</div>
												<input type="password" id="clave" class="form-control" name="clave" placeholder="password" aria-label="password" aria-describedby="basic-addon1">
											</div>
											<!-- <div class="form-floating mb-3">
												<input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
												<label for="inputPassword">Password</label>
											</div> -->
											<!-- <div class="form-check mb-3">
												<input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
												<label class="form-check-label" for="inputRememberPassword">Remember Password</label>
											</div> -->
											<div class="d-flex align-items-center justify-content-between mt-4 mb-0">
												<!-- <a class="small" href="password.html">Forgot Password?</a> -->
												<button type="submit" class="btn btn-primary">Iniciar Sesion</button>
											</div>
										</form>
									</div>
									<!-- <div class="card-footer text-center py-3">
										<div class="small"><a href="register.html">Need an account? Sign up!</a></div>
									</div> -->
								</div>
							</div>
						<!-- </div> -->
			</div>
				<?php
				require 'logs/nav-footer.php';
				?>
		</div>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
			<script src="js/scripts.js"></script>
	</main>
</body>
</html>