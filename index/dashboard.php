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
    

    include '../conexion/conexion.php';

    
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
                <main >
                    

                        <!-- FECHA Y HORA-->
                            <div class="container-fluid px-4">
                                <h5 class="mt-4 text-center" style="color:grey">
                                <?php  setlocale(LC_TIME,"spanish"); echo strftime("%A, %d de %B de %Y");?> 
                                </h5>
                            </div> 
                        <!--FIN  FECHA Y HORA-->
                        <!-- grafico ventas $-->
                            <div class="card m-3 bg- border border-1 rounded-3">
                                <div class="container-fluid px-4">
                                    <h4 class="mt-2 text-center text-grey">
                                        <i class='bi bi-newspaper' style='font-size:24px'></i>&nbsp &nbsp VENTAS
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
						
                        <!-- INFORME ENVIA VENTAS-->     
                            <div class="card m-3  border border-1" >       
                                <div class="container-fluid px-2">
                                    <h4 class="mt-2 text-center" >
                                        <i class='bi bi-newspaper' style='font-size:24px'></i>&nbsp &nbsp INFORME VENTAS
                                    </h4>
                                    <div class="row">
                                        <div class="container-fluid px-2">
                                            <div class="row">

                                                    <div class="col-sm-6">
                                                        <div class="cardes card text-grey m-1 border border-1 rounded-3" style="background-color: #ffffff;">
                                                            
                                                            
                                                            <div class="card-header">
                                                            
                                                                    <h7 ><?php setlocale(LC_TIME,"spanish"); echo ucfirst(strftime("%B")); ?> 
                                                                    del <?php setlocale(LC_TIME,"spanish"); echo strftime("%Y", strtotime("- 1 YEAR")); ?></h7> 
                                                                    
                                                                </div>

                                                            <div class="row text-center ">                
                                                                <div class="col-sm-6 text-center">
                                                                    <div class="text-center" style="font-size: 11px; color:grey">
                                                                        Presupuesto 
                                                                    </div>
                                                                        <h6 style="color:grey">$ 4.000.000</h6>
                                                                    
                                                                        
                                                                    <div class="" style="font-size: 12px; color:black">
                                                                        Venta
                                                                    </div>
                                                                        <h5> $ 3.500.000</h5>
                                                                        

                                                                    <div class="single-chart col-auto" class="col-auto" style="width:6em">
                                                                            	
                                                                        <svg viewBox="0 0 36 36" class="circular-chart orange">
                                                                            <path class="circle-bg"
                                                                                d="M18 2.0845
                                                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                                />
                                                                            <path class="circle"
                                                                                stroke-dasharray="50,100"
                                                                                    
                                                                                d="M18 2.0845
                                                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                                />
                                                                            <text x="18" y="20.35" class="percentage">50 % </text>
                                                                        </svg>
                                                                            
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6"> 
                                                                    <div class="" style="font-size: 12px; color:grey">
                                                                        Unidades
                                                                    </div>
                                                                   
                                                                        

                                                                        <div class="contenedor justify-content-center" >
                                                                            <div class="card-header bg-light" >
                                                                                <h3>30</h3>
                                                                                
                                                                            </div>    
                                                                            <p style='font-size: 10px;color:grey'></p>
                                                                        </div>

                                                                        <div class="card-body  m-0 p-1">
                                                                           
                                                                            <div class="contenedor justify-content-center">
                                                                                <div class="card-header bg-white" >
                                                                                    <h6><span>-50</span></h6>
                                                                                </div>
                                                                                <p style='font-size: 10px;color:grey'>&nbsp;Unidades vs.<br><h7><?php setlocale(LC_TIME,"spanish"); echo strftime("%Y", strtotime("- 2 YEAR")); ?></h7> </p>
                                                                            </div>
                                                                            <h2 style='color:red'><i class='bi bi-caret-down-fill'></i></h2><h7 style='font-size: 10px;color:red'>Menos unidades vendidas</h7>
                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                        <div class="cardes text-gray m-1 border border-1 rounded-3" style="background-color: #ffffff;">
                                                            
                                                            <div class="card-header">
                                                            <h7><?php setlocale(LC_TIME,'spanish'); echo ucfirst(strftime("%B de %Y")); ?></h7>
                                                            </div>

                                                            <div class="row text-center">                
                                                                <div class="col-sm-6">    
                                                                    <div class="" style="font-size: 11px; color:grey">   
                                                                        Presupuesto
                                                                    </div>
                                                                        <h6 style="color:grey">$ 5.000.000</h6>
                                                                        
                                                                       
                                                                    <div class="" style="font-size: 12px; color:black">
                                                                        Venta 
                                                                    </div>
                                                                        <h5>$ 4.900.000</h5>
                                                                        

                                                                    <div class="single-chart col-auto" class="col-auto" style="width:6em">
                                                                        	
                                                                        <svg viewBox="0 0 36 36" class="circular-chart blue">
                                                                        <path class="circle-bg"
                                                                            d="M18 2.0845
                                                                            a 15.9155 15.9155 0 0 1 0 31.831
                                                                            a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <path class="circle"
                                                                            stroke-dasharray="80,100"
                                                                            
                                                                            d="M18 2.0845
                                                                            a 15.9155 15.9155 0 0 1 0 31.831
                                                                            a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <text x="18" y="20.35" class="percentage"> 80 %</text>
                                                                        
                                                                        </svg>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6"> 
                                                                    <div class="" style="font-size: 12px; color:grey">
                                                                        Unidades
                                                                    </div>
                                                                    

                                                                        <div class="contenedor justify-content-center" >
                                                                            <div class="card-header bg-light" >
                                                                                <h3>50</h3>
                                                                                
                                                                            </div>    
                                                                            <p style='font-size: 10px;color:grey'></p>
                                                                        </div>

                                                                        <div class="card-body  m-0 p-1">
                                                                            
                                                                            
                                                                            <div class="contenedor justify-content-center">
                                                                                <div class="card-header bg-white" >
                                                                                    <h6><span>20</span></h6>
                                                                                </div>
                                                                                <p style='font-size: 10px;color:grey'>&nbsp;Unidades vs.<br><h7><?php setlocale(LC_TIME,"spanish"); echo strftime("%Y", strtotime("- 1 YEAR")); ?></h7></p>
                                                                            </div>
                                                                            <h2 style='color:green'><i class='bi bi-caret-up-fill'></i></h2><h7 style='font-size: 10px;color:green'>Mas unidades vendidas

                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        <!-- FIN INFORME ENVIA VENTAS-->
                        
                        <!-- INFORME ENVIA GUIAS-->  
                            <div class="card m-3 bg- border border-1" >       
                                <div class="container-fluid px-4">
                                    <h4 class="mt-2 text-center text-grey">
                                    <i class='bi bi-newspaper' style='font-size:24px'></i>&nbsp &nbsp VENTAS POR CATEGORIA
                                    </h4>
                                <div class="container">
                                    <div class="container-fluid px-3">
                                        <div class="row">

                                                <div class="col-xl-3 col-md-3 m-0 p-0" >
                                                    <div class="card cardes text text-grey text-center m-1 border border-1 rounded-3" style="background-color:#eae8d9">
                                                        <div class="card-header" style="color:grey ; font-size:12px">
                                                            COMIDAS RAPIDAS
                                                        </div>
                                                            <div class="row" >
                                                                <div class="card-body" style="color:grey ; font-size:16px">
                                                                    $1.000.000                                                                    
                                                                </div>       
                                                            </div>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-3 m-0 p-0" >
                                                    <div class="card cardes text text-grey text-center m-1 border border-1 rounded-3" style="background-color:#eae8d9">
                                                        <div class="card-header" style="color:grey ; font-size:12px">
                                                            CAFE
                                                        </div>
                                                            <div class="row" >
                                                                <div class="card-body" style="color:grey ; font-size:16px">
                                                                    $500.000                                                                    
                                                                </div>       
                                                            </div>
                                                            
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-3 m-0 p-0" >
                                                    <div class="card cardes text text-grey text-center m-1 border border-1 rounded-3" style="background-color:#eae8d9">
                                                        <div class="card-header" style="color:grey ; font-size:12px">
                                                            BEBIDAS
                                                        </div>
                                                            <div class="row" >
                                                                <div class="card-body" style="color:grey ; font-size:16px">
                                                                    $600.000                                                                    
                                                                </div>       
                                                            </div>
                                                            
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-3 m-0 p-0" >
                                                    <div class="card cardes text text-grey text-center m-1 border border-1 rounded-3" style="background-color:#eae8d9">
                                                        <div class="card-header" style="color:grey ; font-size:12px">
                                                            NEVERA
                                                        </div>
                                                            <div class="row" >
                                                                <div class="card-body" style="color:grey ; font-size:16px">
                                                                    $300.000                                                                    
                                                                </div>       
                                                            </div>
                                                            
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                                
                                                




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <!-- FIN INFORME ENVIA GUIAS-->
                        
                        

                       
						
                        
                        
                       
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
                const etiquetas1 =['ENE','FEB','MAR','ABR','MAY']
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const datosVentas1 = {
                    label: '2023',
                    data: ['10','2','6','4','8',], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    backgroundColor: 'rgba(54, 10, 250, 0.2)', // Color de fondo
                    borderColor: 'rgba(54, 45, 250, 1)', // Color del borde
                    borderWidth: 1, // Ancho del borde
                };
                
                new Chart($grafica2, {
                        type: 'line', // Tipo de gráfica
                        data: {
                            labels: etiquetas1,
                            datasets: [
                                datosVentas1,
                            
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
                const etiquetas3 = [ 'ENE','FEB','MAR','ABR','MAY' ]
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const datosVentas3 = {
                    label:'2023',
                    data: ['10','2','6','4','8', ], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    backgroundColor: 'rgba(199, 248, 201, 0.8)', // Color de fondo
                    borderColor: 'rgba(17, 248, 27, 0.8)', // Color del borde
                    borderWidth: 1, // Ancho del borde
                };
                const datosVentas4 = {
                    label: '2022',
                    data: [ '12','4','8','6','10',], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
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
