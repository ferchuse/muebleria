<?php		include ("conex.php");	$link = Conectarse();		if($_POST["guardar"]){				$orden_producto = $_POST["orden_producto"];		$codigo_barras = $_POST["codigo_barras"];		//$codigo_barras = $_POST["codigo_barras"];		$precio_compra = $_POST["precio_compra"];		$precio_venta = $_POST["precio_venta"];		$piezas_por_caja = $_POST["piezas_por_caja"];								foreach($codigo_barras as $key => $value){				if($value){										$update_productos ="UPDATE  productos					SET 					orden_producto = '$orden_producto[$key]',					codigo_barras = '$codigo_barras[$key]', 					precio_compra = '$precio_compra[$key]', 					precio_venta = '$precio_venta[$key]', 					piezas_por_caja = '$piezas_por_caja[$key]'					WHERE codigo_barras = '$key'";										mysql_query($update_productos) or die("Error al guardar productos: $update_productos ".mysql_error());															}			}						$insert_historial ="INSERT INTO detalle_entrada_almacen								SELECT * FROM ";								//mysql_query($insert_historial) or die("Error insertando historial: $insert_historial ".mysql_error());											echo "<div class='mensaje'>Guardado Correctamente</div>";						/* update apples					   set price = (						  select price from (							 select * from apples						  ) as x						  where variety = 'gala')					   where variety = 'fuji';"; */			}?>