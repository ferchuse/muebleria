<?php 
	
	$codigos = explode(",", $_GET["codigos"] );
	// print_r($economicos);
	
	include("../conexi.php");
	$link = Conectarse();
	
	
	
?> 

<!DOCTYPE html>
<html lang="es_mx">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Imprimir Producto</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

		<style>
			img
			{
			background-image:url('default.jpg');
			}
		</style>
		
	</head>
	<body >
		
		
		<div >		
			<div class="container text-center mt-5">		
				<div class="row">		
					
					
					<?php foreach($codigos as $id_producto){ 
						
						$consulta = "SELECT * FROM productos WHERE id_articulo = '{$id_producto}' ";
						
						$result = mysqli_query($link, $consulta )
						or die("Error al ejecutar $consulta: $consulta".mysqli_error($link));
						
						// print_r($consulta);
						
						while($fila = mysqli_fetch_assoc($result)) {
							$precios = [];
							$producto =$fila;
							
							$consulta_precios ="SELECT * FROM productos_precios LEFT JOIN tipo_precio USING(id_tipo_precio) WHERE id_articulo = '{$id_producto}' AND activo = 1";
							
							$result_precios = mysqli_query($link, $consulta_precios )
							or die("Error al ejecutar $consulta: $consulta".mysqli_error($link));
							
							
							// print_r($consulta_precios);
							// print_r($precios);
							while($fila_precio = mysqli_fetch_assoc($result_precios)) {
								
								$precios[] =$fila_precio;
								
								
							}
						}
						
					?>
					<div class="col-sm-4 mb-2 border">
					
						<img class="img-fluid" src="<?= $producto["url_foto"] == "" ? "default.jpg" : $producto["url_foto"]?>">
						Clave: <?= $producto["id_articulo"]?> <br>
						<b><?= $producto["descripcion"]?></b> <br> 
						<?php
							
							foreach($precios as $precio){ ?>
							
							<?= $precio["nombre_precio"]?> :
							$<?= number_format($precio["precio"])?> <br>
							<?php	
							}
						?>
					</div>
					<?php	
					}
					?>
					
				</div> 
			</div> 
		</div> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</body>
</html>	


