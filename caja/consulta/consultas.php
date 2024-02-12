<?php
    // Para el combox guias mensajeros activos
        $query01 =" SELECT      id, 
                                nombre
                    FROM        usuarios
                    WHERE       contabilidad = 'SI'
                    ORDER BY    nombre ASC
               ";
        $usuarios = $mysqli->query($query01);
    // Fin Para el combox guias mensajeros activos

    // Para el combox guias mensajeros activos
    $query03 =" SELECT      id, 
                            nombre
                FROM        usuarios
                WHERE       contabilidad = 'SI'
                ORDER BY    nombre ASC
            ";
        $usuarios2 = $mysqli->query($query03);
// Fin Para el combox guias mensajeros activos

    // Para el combox conceptos
	    $query02 =" SELECT      id_concepto, 
                                nombre_concepto
                    FROM        caja_conceptos
                ";
        $conceptos = $mysqli->query($query02);
// Fin Para el combox conceptos

// Para el combox conceptos
        $query04 =" SELECT      id_concepto, 
                                nombre_concepto
                    FROM        caja_conceptos
                ";
        $conceptos2 = $mysqli->query($query04);
// Fin Para el combox conceptos
?>