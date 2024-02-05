<?php
	session_start();

        require '../conexion/conexion.php';

        if (!isset($_SESSION['id'])) {
            header("Location: ../../index.php");
        }
        $id = $_SESSION['id'];
        $nombre = $_SESSION['nombre'];
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $usuario = $_SESSION['usuario'];
        $foto = $_SESSION['foto1'];
        $fotos = $_SESSION['foto1'];

        if ($tipo_usuario == 1) {
            $where = "";
        } else if ($tipo_usuario == 2) {
            $where = "WHERE id=$id";
        }
    
    date_default_timezone_set('America/Bogota');

    header('Content-Type: text/html; charset=ISO-8859-1');

    echo "<link rel='stylesheet' type='text/css' href='../css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='../css/estilos.css'>";
    
    // consultas ventas por categoria mes actual
        include '../conexion/conexion.php'; 
        // comidas rapidas
        $query_totalCat = " SELECT  pedido_fecha,
                                    producto_categoria,
                                    COALESCE(sum(detalle_cantidad * detalle_precio)) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                        INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id
                        INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id 
                        WHERE       producto_categoria = 1   AND MONTH(pedido_fecha)=MONTH(CURDATE())                 
                        group by    producto_categoria
                                                ";
        $totalComRap = $mysqli->query($query_totalCat);
         // cafe
        $query_totalCat1 = " SELECT pedido_fecha,
                                    producto_categoria,
                                    sum(detalle_cantidad * detalle_precio) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                        INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id
                        INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id 
                        WHERE       producto_categoria = 2   AND MONTH(pedido_fecha)=MONTH(CURDATE())               
                        group by    producto_categoria
                                                ";
        $totalcafe = $mysqli->query($query_totalCat1);
        // malteadas
        $query_totalCat2 = " SELECT pedido_fecha,
                                    producto_categoria,
                                    sum(detalle_cantidad * detalle_precio) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                        INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id
                        INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id 
                        WHERE       producto_categoria = 5   AND MONTH(pedido_fecha)=MONTH(CURDATE())                  
                        group by    producto_categoria
                                                ";
        $totalBebidas = $mysqli->query($query_totalCat2);
        // cervezas y gaseosas
        $query_totalCat3 = " SELECT pedido_fecha,
                                    producto_categoria,
                                    sum(detalle_cantidad * detalle_precio) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                        INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id
                        INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id 
                        WHERE       producto_categoria = 6 and 7 AND MONTH(pedido_fecha)=MONTH(CURDATE())                 
                        group by    producto_categoria
                                                ";
        $totalNevera = $mysqli->query($query_totalCat3);
        // Heladeria
        $query_totalCat4 = " SELECT pedido_fecha,
                                    producto_categoria,
                                    sum(detalle_cantidad * detalle_precio) as total
                        FROM        pedidos AS PE 
                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                        INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id
                        INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id
                        INNER JOIN  categorias AS CT ON PR.producto_categoria = CT.categoria_id 
                        WHERE       producto_categoria = 8  AND MONTH(pedido_fecha)=MONTH(CURDATE())                  
                        group by    producto_categoria
                                                ";
        $totalHeladeria = $mysqli->query($query_totalCat4);

        // Heladeria
        $query_catTotal = "     SELECT 								
                                        producto_categoria,
                                        categoria_nombre,
                                        categoria_img,
                                        sum(detalle_cantidad * detalle_precio) as total
                                FROM        pedidos AS PE 
                                INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                                INNER JOIN  mesa AS ME ON PE.pedido_mesa = ME.mesas_id
                                INNER JOIN  productos AS PR ON PD.detalle_producto = PR.producto_id
                                INNER JOIN  categorias AS CT ON PR.producto_categoria = CT.categoria_id 
                                WHERE      	MONTH(pedido_fecha)=MONTH(CURDATE())                  
                                group by    producto_categoria
                                                ";
                                $totalCat = $mysqli->query( $query_catTotal);
        
    // fin consultas       

    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require '../logs/head.php';?>        
    </head>
    <body>
        <?php require '../logs/nav-bar.php';?>
        <!-- inicio pagina -->
            <div id="layoutSidenav_content" class="bg-light">
                <main >
                    
                        <!-- FECHA Y HORA-->
                            <div class="container-fluid px-4">
                                <h5 class="mt-4 text-center" style="color:grey">
                                <?php  setlocale(LC_TIME,"spanish"); echo strftime("%A, %d de %B de %Y");?> 
                                </h5>
                            </div> 
                        <!--FIN  FECHA Y HORA-->
                        
                        <!-- grafico ventas $-->
                                <div class="card m-3 border border-1 rounded-3">
                                    <div class="container-fluid px-4">
                                        <h4 class="mt-2 text-center text-grey">
                                            <i class='far fa-chart-bar' style='font-size:18x'></i>&nbsp;&nbsp;Grafico de ventas mes de <?php  setlocale(LC_TIME,"spanish"); echo strftime("%B");?>
                                        </h4>
                                        <div class="row">
                                            <div class="container-fluid px-3">
                                                <div class="row">
                                                    
                                                    <div class="col-xl-6 col-md-6 mt-2" >
                                                        <div class="cardes text-black m-1 border border-dark border border-1 rounded-3" style="background-color: #faf7f8"0 >
                                                            <div class="">&nbsp &nbsp Grafico ventas por mes </div>
                                                            
                                                                <div class="card-body m-1 p-2">
                                                                    <canvas id="grafica2"></canvas>                                                            
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-6 col-md-6 mt-2" >
                                                        <div class="cardes text-black m-1 border border-dark border border-1 rounded-3" style="background-color: #faf7f8"0 >
                                                            <div class="">&nbsp &nbsp Grafico unidades por mes </div>
                                                            
                                                                <div class="card-body m-1 p-2">
                                                                    <canvas id="grafica3"></canvas>                                                            
                                                                </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>    
                        <!-- grafico ventas $-->
                        
                        

                    <!-- card ventas por categoria  2-->
                        <div class="card">
                                <div class="card-header text-center">
                                <span class="material-icons">category</span>&nbsp;&nbsp;
                                Ventas por categoria mes de <?php  setlocale(LC_TIME,"spanish"); echo strftime("%B");?>
                                </div>
                                <ul class="ventasCat">
                                <?php foreach ($totalCat as $total) { ?>
                                    <li>
                                        
                                        <img src="<?php echo $total['categoria_img']?>" alt="" class="logoCat">
                                        <span class="info"> <h7>$&nbsp;<?php echo number_format($total['total'], 0, ",", "."); ?></h7>
                                        <p><?php echo $total['categoria_nombre']?></p></span>                                                                                           
                                    </li>
                                    <?php } ?>                                   
                                </ul>
                            </div>    
                    <!-- card ventas por categoria -->

                        

                </main>
                <?php require '../logs/nav-footer.php'; ?>
            </div>         
        <!-- FIN pagina -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
        <script>
            // Obtener una referencia al elemento canvas del DOM
            const $grafica2 = document.querySelector("#grafica2");
                // Las etiquetas son las que van en el eje X. 
                const etiquetas1 =['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC']
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const datosVentas1 = {
                    label: "<?php setlocale(LC_TIME,"spanish"); echo strftime("%Y", strtotime("- 1 YEAR")); ?>",
                    data: [<?php $sql = "	SELECT  MONTHNAME(pedido_fecha) as fecha,
                                                    sum(detalle_cantidad * detalle_precio) as cantidad
                                            FROM    pedidos PE
                                            INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle           	
                                            WHERE   YEAR(pedido_fecha)=YEAR(DATE_SUB(NOW(),INTERVAL 1 YEAR))
                                            GROUP BY EXTRACT(MONTH FROM pedido_fecha)
                                    ";
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($registros = mysqli_fetch_array($result)) {
                                    ?> '<?php echo $registros["cantidad"] ?>',
                                    <?php
                                    }
                                    ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    backgroundColor: 'rgba(54, 10, 250, 0.2)', // Color de fondo
                    borderColor: 'rgba(54, 45, 250, 1)', // Color del borde
                    borderWidth: 1, // Ancho del borde
                };
                const datosVentas2 = {
                        label: "<?php setlocale(LC_TIME,"spanish"); echo strftime("%Y"); ?>",
                        data: [<?php $sql = "   SELECT   MONTHNAME(pedido_fecha) as fecha,
                                                        sum(detalle_cantidad * detalle_precio) as cantidad
                                                FROM    pedidos PE
                                                INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle 
                                                WHERE 		YEAR(pedido_fecha)=YEAR(NOW())
                                                GROUP BY 	EXTRACT(MONTH FROM pedido_fecha)
                                    ";
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($registros = mysqli_fetch_array($result)) {
                                    ?> '<?php echo $registros["cantidad"] ?>',
                                    <?php
                                    }
                                    ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                        backgroundColor: 'rgba(245, 115, 158, 0.5)', // Color de fondo
                        borderColor: 'rgba(245, 115, 158, 1)', // Color del borde
                        borderWidth: 1, // Ancho del borde
                    };
                    new Chart($grafica2, {
                        type: 'line', // Tipo de gráfica
                        data: {
                            labels: etiquetas1,
                            datasets: [
                                datosVentas1,
                                datosVentas2,               
                                // Aquí más datos...
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                            },
                        }
                    });
        </script>
        <script>
                    
                            // Obtener una referencia al elemento canvas del DOM
                            const $grafica3 = document.querySelector("#grafica3");
                            // Las etiquetas son las que van en el eje X. 
                            const etiquetas3 = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC']
                            // Podemos tener varios conjuntos de datos. Comencemos con uno
                            const datosVentas3 = {
                                label:'<?php setlocale(LC_TIME,"spanish"); echo strftime("%Y", strtotime("- 1 YEAR")); ?>',
                                data: [<?php $sql = "	SELECT  MONTHNAME(pedido_fecha)  as fecha,
                                                                SUM(detalle_cantidad)  as cantidad
                                                        FROM    pedidos as PE 
                                                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle
                                                        WHERE 	YEAR(pedido_fecha)=YEAR(DATE_SUB(NOW(),INTERVAL 1 YEAR))
                                                        GROUP BY EXTRACT(MONTH FROM pedido_fecha)
                                    ";
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($registros = mysqli_fetch_array($result)) {
                                    ?> '<?php echo $registros["cantidad"] ?>',
                                    <?php
                                    }
                                    ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                                backgroundColor: 'rgba(199, 248, 201, 0.8)', // Color de fondo
                                borderColor: 'rgba(17, 248, 27, 0.8)', // Color del borde
                                borderWidth: 1, // Ancho del borde
                            };
                            const datosVentas4 = {
                                label: '<?php setlocale(LC_TIME,"spanish"); echo strftime("%Y"); ?>',
                                data: [<?php $sql = "	SELECT  MONTHNAME(pedido_fecha)  as fecha,
                                                                SUM(detalle_cantidad)  as cantidad
                                                        FROM    pedidos as PE 
                                                        INNER JOIN  pedido_detalle as PD ON PE.codigo_recibo = PD.codigo_recibo_detalle
                                                        WHERE 	YEAR(pedido_fecha)=YEAR(NOW())
                                                        GROUP BY EXTRACT(MONTH FROM pedido_fecha)
                                    ";
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($registros = mysqli_fetch_array($result)) {
                                    ?> '<?php echo $registros["cantidad"] ?>',
                                    <?php
                                    }
                                    ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                                backgroundColor: 'rgba(246, 133, 131,1)', // Color de fondo
                                borderColor: 'rgba(251, 11, 6, 0.8)', // Color del borde
                                borderWidth: 1, // Ancho del borde
                            };
                            new Chart($grafica3, {
                                type: 'bar', // Tipo de gráfica
                                data: {
                                    labels: etiquetas3,
                                    datasets: [
                                        datosVentas3,
                                        datosVentas4,
                                        // Aquí más datos...
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }],
                                    },
                                }
                            });
        </script>
    </body>
</html>
                                                                            
                                                                            

                                                                            

                                                    
                                                
                                                
                                                
                                                
                                                
                                                




                        
                        

                       
						
                        
                        
                       
