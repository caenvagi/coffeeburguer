<?php
	require ('../../conexion/conexion.php');
	
	$id_concepto = $_POST['id_concepto'];
	
	$queryM = "SELECT id, nombre FROM usuarios WHERE id_concepto = '$id_concepto' ORDER BY usuario";
	$resultadoM = $mysqli->query($queryM);
	
	$html= "<option value='0'>Seleccionar Usuario</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['id']."'>".$rowM['nombre']."</option>";
	}
	
	echo $html;
?>