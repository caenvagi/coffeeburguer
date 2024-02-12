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

$mysqli = retornarConexion();

$fpdf = new FPDF('P', 'mm', array(58,200));
$fpdf->AddPage('portrait', array(58,200));
$fpdf->SetMargins(5,5,5,5);

cabecera($fpdf, $mysqli);
// titulosdetalle($fpdf);
// imprimirdetalle($fpdf, $mysqli);
// piedepagina($fpdf, $mysqli);
// piedepagina2($fpdf, $mysqli);



function cabecera($fpdf, $mysqli)
{
    $fpdf->Image('../assets/img/logofact.png', 18, 2, 20);
	$fecha = date_default_timezone_set('America/Bogota');    setlocale(LC_TIME,'spanish');  
    $fecha = strftime('%A, %d de %B de %Y ');

    $fpdf->Ln(11);
    $fpdf->SetFont('Arial','B',9);
    $fpdf->cell(50,5,'Coffee Burguer "Mirador"',0,1,'C');

    $fpdf->SetFont('Arial','',8);
    $fpdf->MultiCell(50,5,'WathApp 311-1234567',0,'C');

   $query = "   SELECT *
                FROM pedidos                
                ORDER by codigo_recibo DESC LIMIT 1 
                        ";
                $pedidos = $mysqli->query($query);
                $row = $pedidos->fetch_assoc();                
                
                $registro_id = $_GET['pedido_mesa'];
                $codigo_recibo = $_GET['codigo_recibo'];

    //$fpdf->Ln(1);
    $fpdf->SetFont('Arial','',8);
    $fpdf->Cell(20, 5 , 'Recibo No: ',0,0,'L');
    $fpdf->Cell(20,5,$codigo_recibo,0,1,'L');
    //$fpdf->Ln(1);
    $fpdf->SetFont('Arial','',8);
    $fpdf->Cell(20, 5 , 'Domicilio No: ',0,0,'L');
    $fpdf->Cell(20,5,$registro_id,0,1,'L');
    //$fpdf->Ln(1);
    $fpdf->SetFont('Arial','',8);
    $fpdf->Cell(15, 5 , 'Cliente: ',0,0,'L');
    $fpdf->Cell(25,5,$row['pedido_cliente'],0,1,'L');
    //$fpdf->Ln(1);
    $fpdf->SetFont('Arial','',8);
    $fpdf->Cell(15, 5 , 'Direccion: ',0,0,'L');
    $fpdf->Cell(25,5,$row['pedido_direccion'],0,1,'L');
    //$fpdf->Ln(1);
    $fpdf->SetFont('Arial','',8);
    $fpdf->Cell(15, 5 , 'Telefono: ',0,0,'L');
    $fpdf->Cell(25,5,$row['pedido_telefono'],0,1,'L');

    $fpdf->Cell(58,1,'______________________________',0,1,'L');
    $fpdf->Ln(3);
    $fpdf->SetFont('Arial','B',8);
    $fpdf->Cell(7,4,'CAN',0,0,'L');
    $fpdf->Cell(15,4,'PROD',0,0,'L');
    $fpdf->Cell(28,4,'VALOR',0,1,'R');
    $fpdf->Cell(58,1,'______________________________',0,1,'L');

    $totalproducto = 0;

    $fpdf->Ln(3);
    $fpdf->SetFont('Arial','',7);

    $registro_id = $_GET['pedido_mesa'];      

    $query1 = "  SELECT     codigo_recibo_detalle,
                            codigo_recibo,
                            producto_id,
                            detalle_producto,
                            producto_nombre,
                            producto_precio,
                            detalle_cantidad,
                            sum(detalle_cantidad) as totalcant,
                            detalle_precio,
                            sum(detalle_cantidad * producto_precio) as totalprecio,
                            pedido_mesa,
                            detalle_estado
                        FROM        pedido_detalle AS PD
                        INNER JOIN  productos AS PR ON PD.detalle_producto=PR.producto_id
                        INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle=PE.codigo_recibo
                        WHERE       pedido_mesa = $registro_id and codigo_recibo_detalle = $codigo_recibo
                        group by    detalle_producto    
                            
                ";
                $pedidos1 = $mysqli->query($query1);            
    
    while($row = $pedidos1->fetch_assoc()){    
        $fpdf->Cell(5,4,$row['totalcant'],0,0,'C');
        $fpdf->Cell(30,4,$row['producto_nombre'],0,0,'L');
        $fpdf->Cell(15,4,number_format($row['totalprecio'], 0, ",", "."),0,1,'R');
    }

    $fpdf->Cell(58,1,'__________________________________',0,1,'L');

    $query2 = "  SELECT         codigo_recibo_detalle as recibo,
                                pedido_tipo,
                                mesas_nombre,
                                COUNT(detalle_cantidad) AS totalcant,
                                sum(detalle_cantidad * detalle_precio) as total
                            FROM        pedido_detalle AS PD
                            INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id
                            INNER JOIN  categorias AS CA ON PR.producto_categoria = CA.categoria_id
                            INNER JOIN  pedidos AS PE ON PD.codigo_recibo_detalle = PE.codigo_recibo
                            INNER JOIN  mesa AS ME ON ME.mesas_id = PD.detalle_mesa
                            WHERE       pedido_mesa = $registro_id and codigo_recibo_detalle = $codigo_recibo       
                ";
                $pedidos2 = $mysqli->query($query2);
                $row2 = $pedidos2->fetch_assoc();

    $fpdf->Ln(3);
    $fpdf->SetFont('Arial','B',8);
    $fpdf->Cell(5,4,'',0,0,'L');
    $fpdf->Cell(15,4,'TOTAL',0,0,'L');
    $fpdf->Cell(30,4,'$'.number_format($row2['total'], 0, ",", "."),0,1,'R');               


    
}

        







$fpdf->Output();








