<?php

require '../conexion/conexion.php';
    // Para saldo avances
        $query01 ="   SELECT 
                                Ca.usuario,
                                Us.nombre,
                                SUM(valor_ingreso - valor_egreso) AS saldo
                    FROM 		caja Ca
                    INNER JOIN	usuarios Us ON Ca.usuario = Us.id
                    WHERE       movimiento = '1' 
                    GROUP BY 	usuario 
                        ";
        $saldo_avance = $mysqli->query($query01);
    // Para saldo avances

    // Para saldo compras
        $query02 ="     SELECT 
                                    Ca.usuario,
                                    Us.nombre,
                                    SUM(valor_ingreso - valor_egreso) AS saldo
                        FROM 		caja Ca
                        INNER JOIN	usuarios Us ON Ca.usuario = Us.id
                        WHERE       movimiento = '2' 
                        GROUP BY 	usuario 
                ";
        $saldo_compras = $mysqli->query($query02);
    // Para saldo compras

    // Para saldo gasolina
        $query03 =  "   SELECT 
                                    Ca.usuario,
                                    Us.nombre,
                                    SUM(valor_ingreso - valor_egreso) AS saldo
                        FROM 		caja Ca
                        INNER JOIN	usuarios Us ON Ca.usuario = Us.id
                        WHERE       movimiento = '4' 
                        GROUP BY 	usuario 
                    ";
    $saldo_gasolina = $mysqli->query($query03);
    // Para saldo gasolina
	
	// Para saldo SALARIOS
        $query04 =  "   SELECT 
                                    Ca.usuario,
                                    Us.nombre,
                                    SUM(valor_ingreso - valor_egreso) AS saldo
                        FROM 		caja Ca
                        INNER JOIN	usuarios Us ON Ca.usuario = Us.id
                        WHERE       movimiento = '5' 
                        GROUP BY 	usuario 
                    ";
    $saldo_salarios = $mysqli->query($query04);
    // Para saldo SALARIOS
	
	// Para saldo prestamos
        $query05 =  "   SELECT 
                                    Ca.usuario,
                                    Us.nombre,
                                    SUM(valor_ingreso - valor_egreso) AS saldo
                        FROM 		caja Ca
                        INNER JOIN	usuarios Us ON Ca.usuario = Us.id
                        WHERE       movimiento = '7' 
                        GROUP BY 	usuario 
                    ";
    $saldo_prestamos = $mysqli->query($query05);
    // Para saldo prestamos

    
    

?>
