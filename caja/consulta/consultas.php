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

    // Para el combox conceptos
	    $query02 =" SELECT      id_concepto, 
                                nombre_concepto
                    FROM        caja_conceptos
                ";
        $conceptos = $mysqli->query($query02);
// Fin Para el combox conceptos
?>