<?php
session_start();

    require '../conexion/conexion.php';

    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
    }
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $usuario = $_SESSION['usuario'];
    $usuarios = $_SESSION['usuario'];

    if ($tipo_usuario == 1) {
        $where = "";
    } else if ($tipo_usuario == 2) {
        $where = "WHERE id=$id";
    }


require('../fpdf/fpdf.php');
require("../conexion/conexion4.php");
$conexion = retornarConexion();

$fpdf = new FPDF('L', 'mm', 'A4', true);
$fpdf->AddPage('portrait', 'A4');
$fpdf->SetMargins(15,15, 15, 15);
cabecera($fpdf, $conexion);
titulosdetalle($fpdf);
imprimirdetalle($fpdf, $conexion);
piedepagina($fpdf, $conexion);
piedepagina2($fpdf, $conexion);



function cabecera($fpdf, $conexion)
{
	$fecha = date_default_timezone_set('America/Bogota');    setlocale(LC_TIME,'spanish');  
    $fecha = strftime('%A, %d de %B de %Y ');
    
    $fecha1 = date_default_timezone_set('America/Bogota');    setlocale(LC_TIME,'spanish');  
    $fecha1 = strftime('%d%m%y-%H%M');
    
    //para buscar guias por nombre
include '../conexion/conexion2.php';

$sql_usuarios = $conexion->query("SELECT * FROM usuarios") or die($conexion->error);

if (isset($_GET['id'])) {
    $usuario = $_GET['id'];
    $resGuias5 = $conexion->query("      SELECT guia AS guia,
                                                SUM(cantidad) AS cantidad,
                                                SUM(cantidad * valor) AS total,
                                                SUM(valor) AS valor, 
                                                SUM(contraentrega) as contraentrega,
                                                Us.nombre
                                                
                                            FROM guias_mensajeros Gm 
                                            INNER JOIN usuarios Us ON Gm.usuario = Us.id 
                                            WHERE id=$usuario and cancelado = 'No'
                                            LIMIT 1
                                            ") or die($conexion->error);
} else {
    $resGuias5 = $conexion->query(" SELECT      guia AS guia,
                                                SUM(cantidad) AS cantidad,
                                                SUM(cantidad * valor) AS total,
                                                SUM(valor) AS valor, 
                                                SUM(contraentrega) as contraentrega,
                                                Us.nombre
                                                    
                                    FROM guias_mensajeros Gm 
                                    INNER JOIN usuarios Us ON Gm.usuario = Us.id 
                                    WHERE cancelado = 'No'  LIMIT 1
                                ") or die($conexion->error);
}

 $resultado5 = mysqli_fetch_array($resGuias5);

    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->Rect(0, 0, 220, 50, 'F');
    $fpdf->SetFont('Arial', 'B', 15);
    $fpdf->SetTextColor(0, 0, 0);
    
    $pago=0;
    
    $fpdf->SetFont('Arial', '', 16);
    $fpdf->sety(10);
    $fpdf->setx(0);
    $fpdf->Cell(0,0,'Servicorreo Express',0,1,'C');
    
    $fpdf->SetFont('Arial', '', 16);
    $fpdf->sety(16);
    $fpdf->setx(0);
    $fpdf->Cell(0,0,'Cra 6 # 18-37',0,1,'C');
    
    $fpdf->SetFont('Arial', '', 16);
    $fpdf->sety(22);
    $fpdf->setx(0);
    $fpdf->Cell(0,0,'Montenegro',0,1,'C');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(32);
    $fpdf->setx(15);
    $fpdf->Cell(0,0,'FECHA:',0,1,'L');
  
    $fpdf->SetFont('Arial','',12);
    $fpdf->sety(32);
    $fpdf->setx(60);
    $fpdf->Cell(0,0,"".$fecha,0,1,'L');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(38);
    $fpdf->setx(15);
    $fpdf->Cell(0,0,'INFORME DIARIO:',0,1,'L');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(38);
    $fpdf->setx(60);
    $fpdf->Cell(0,0,"".$fecha1,0,1,'L');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(38);
    $fpdf->setx(100);
    $fpdf->Cell(0,0,'GENERADO POR:',0,1,'L');
    
    $fpdf->SetFont('Arial','',12);
    $fpdf->sety(38);
    $fpdf->setx(140);
    $fpdf->Cell(0,0,"".$_SESSION['usuario'],0,1,'L');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(44);
    $fpdf->setx(15);
    $fpdf->Cell(0,0,'MENSAJERO:',0,1,'L');
    
    $fpdf->SetFont('Arial','',12);
    $fpdf->sety(44);
    $fpdf->setx(60);
    $fpdf->Cell(0,0,"".$resultado5['nombre'],0,1,'L');
    
    
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(50);
    $fpdf->setx(15);
    $fpdf->Cell(0,0,'TOTAL GUIAS:',0,1,'L');
    
    $fpdf->SetFont('Arial','',14);
    $fpdf->sety(50);
    $fpdf->setx(50);
    $fpdf->Cell(0,0,"".$resultado5['cantidad'],0,1,'L');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(50);
    $fpdf->setx(70);
    $fpdf->Cell(0,0,'VALOR C.E:',0,1,'L');
    
    $fpdf->SetFont('Arial','',14);
    $fpdf->sety(50);
    $fpdf->setx(100);
    $fpdf->Cell(0,0,'$'.number_format($resultado5['contraentrega'],0,',','.'),0,1,'L');
    
    $fpdf->SetFont('Arial','B',12);
    $fpdf->sety(50);
    $fpdf->setx(130);
    $fpdf->Cell(0,0,'VALOR A PAGAR:',0,1,'L');
    
    $fpdf->SetFont('Arial','',14);
    $fpdf->sety(50);
    $fpdf->setx(170);
    $fpdf->Cell(0,0,'$'.number_format($resultado5['total'],0,',','.'),0,1,'L');

}

function titulosdetalle($fpdf)
{
    $fpdf->SetY(55);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->SetLineWidth(0.2);
    
    $fpdf->Cell(30, 10, 'MENSAJERO', 1, 0, 'C', 1);
    $fpdf->Cell(40, 10, 'FECHA/HORA', 1, 0, 'C', 1);
    $fpdf->Cell(40, 10, 'GUIA', 1, 0, 'C', 1);
    $fpdf->Cell(10, 10, 'UND', 1, 0, 'C', 1);
    $fpdf->Cell(30, 10, '$/UN', 1, 0, 'C', 1);
    $fpdf->Cell(30, 10, 'F.CE', 1, 0, 'C', 1);
    
}

function imprimirdetalle($fpdf, $conexion)
{
   //para buscar guias por nombre
include '../conexion/conexion2.php';

$sql_usuarios = $conexion->query("SELECT * FROM usuarios") or die($conexion->error);

if (isset($_GET['id'])) {
    $usuario = $_GET['id'];
    $resGuias2 = $conexion->query("      SELECT fecha, guia, SUM(cantidad) AS cantidad, SUM(cantidad * valor) AS total, id , valor, Us.nombre, cancelado, contraentrega, date_format(fecha,'%d/%m/%Y - %h:%i %p')   as fecha1,cantidad AS cantidad1
                                                FROM guias_mensajeros Gm 
                                                INNER JOIN usuarios Us ON Gm.usuario = Us.id 
                                                WHERE id=$usuario and cancelado = 'No'
                                                GROUP BY guia ORDER BY fecha ASC 
                                                ") or die($conexion->error);
} else {
    $resGuias2 = $conexion->query(" SELECT Us.nombre AS nombre, fecha, Us.id as id, guia, cantidad, valor,  cantidad * valor AS total, cancelado , usuario , contraentrega, date_format(fecha,'%d/%m/%Y - %h:%i %p')   as fecha1, cantidad AS cantidad1
                                                    FROM guias_mensajeros Gm 
                                                    INNER JOIN usuarios Us ON Gm.usuario = Us.id 
                                                    WHERE cancelado = 'No' ORDER BY fecha ASC 
                                                    ") or die($conexion->error);
}
    
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->SetFont('times', '', 10);
    $fpdf->SetY(65);
    $fpdf->SetLineWidth(0.2);
    $pago=0;
    $item=0;
    
    foreach ($resGuias2 as $fila) {
        $fpdf->Cell(30, 6, $fila['nombre'], 1, 0, 'C', 1);
        $fpdf->Cell(40, 6, $fila['fecha1'], 1, 0, 'C', 1);
        $fpdf->Cell(40, 6, $fila['guia'], 1, 0, 'C', 1);
        $fpdf->Cell(10, 6, $fila['cantidad1'], 1, 0, 'C', 1);
        $fpdf->Cell(30, 6, '$'.number_format($fila['total'],0,',','.'), 1, 0, 'R', 1);
        $fpdf->Cell(30, 6, '$'.number_format($fila['contraentrega'],0,',','.'), 1, 0, 'R', 1);
        $fpdf->Ln();
        
        
        
    }
    
}

function piedepagina($fpdf , $conexion)
{
   //para buscar guias por nombre
include '../conexion/conexion2.php';

$sql_usuarios = $conexion->query("SELECT * FROM usuarios") or die($conexion->error);

if (isset($_GET['id'])) {
    $usuario = $_GET['id'];
    $resGuias4 = $conexion->query("      SELECT guia AS guia,
                                                SUM(cantidad) AS cantidad,
                                                SUM(cantidad * valor) AS total,
                                                SUM(valor) AS valor, 
                                                SUM(contraentrega) as contraentrega
    
                                                FROM guias_mensajeros Gm 
                                                INNER JOIN usuarios Us ON Gm.usuario = Us.id 
                                                WHERE id=$usuario and cancelado = 'No'
                                                 
                                                ") or die($conexion->error);
} else {
    $resGuias4 = $conexion->query(" SELECT      guia AS guia,
                                                SUM(cantidad) AS cantidad,
                                                SUM(cantidad * valor) AS total,
                                                SUM(valor) AS valor, 
                                                SUM(contraentrega) as contraentrega
    
                                                FROM guias_mensajeros Gm 
                                                INNER JOIN usuarios Us ON Gm.usuario = Us.id 
                                                WHERE cancelado = 'No'  
                                                ") or die($conexion->error);
}
  
   $resultado1 = mysqli_fetch_array($resGuias4);
    
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->SetFont('times', 'B', 14);
    
    $fpdf->Cell(30, 10, '', 1, 0, 'C', 1);
    $fpdf->Cell(40, 10, '', 1, 0, 'C', 1);
    $fpdf->Cell(40, 10, 'TOTAL DIA', 1, 0, 'C', 1);
    $fpdf->Cell(10, 10, "".$resultado1['cantidad'], 1, 0, 'C', 1);
    $fpdf->Cell(30, 10, '$'.number_format($resultado1['total'],0,',','.'), 1, 0, 'R', 1);
    $fpdf->Cell(30, 10, '$'.number_format($resultado1['contraentrega'],0,',','.'), 1, 0, 'R', 1); 

	
                                 
}

function piedepagina2($fpdf , $conexion)
{
	$fpdf->SetFont('Arial','',12);
	$fpdf->setx(15);
    $fpdf->Cell(0,40,'RECIBIDO POR:_______________________',0,1,'L');
	
	$fpdf->SetFont('Arial','',12);
	$fpdf->setx(110);
    $fpdf->Cell(0,-40,'MENSAJERO:________________________',0,1,'L');
	
	
	
}


$fecha1 = date_default_timezone_set('America/Bogota');    setlocale(LC_TIME,'spanish');  
$fecha1 = strftime('%y%m%d-%H%M');

$fpdf->OutPut('I' ,"$fecha1.pdf");

$fpdf->OutPut('F', "archivos/$fecha1.pdf");






