<?php		include ("conex.php");	$link = Conectarse();		if($_POST["guardar"]){				$codigos = $_POST["codigos"];		$productos = $_POST["productos"];		$cantidades = $_POST["cantidades"];							$insert_entrada="INSERT INTO entradas_almacen			SET id_almacen = '1', 			fecha = CURDATE(), 			hora = CURTIME() , 			entrega = 'Proveedor' , 			recibe = 'Almacenista' , 			tipo_entrada = 'Entrada Cedis Toluca'";			mysql_query($insert_entrada) or die('Error insertando $insert_entrada: '.mysql_error());						$id_entrada = mysql_insert_id();						foreach($cantidades as $key => $value){				if($value){										$insert_detalle ="INSERT INTO detalle_entrada_almacen					SET id_entrada = '$id_entrada', codigo_barras = '$codigos[$key]', piezas = '$value'";										mysql_query($insert_detalle) or die("Error insertando detalle: $insert_detalle ".mysql_error());										$update_existencias ="UPDATE existencias_almacen 					SET existencia_en_piezas = '$value' + (SELECT  existencia_en_piezas FROM(														SELECT * FROM existencias_almacen) AS existencia_actual														WHERE codigo_barras = '$codigos[$key]')											WHERE codigo_barras = '$codigos[$key]'";					mysql_query($update_existencias) or die("Error actualizando existencia: $update_existencias ".mysql_error());				}			}						$insert_historial ="INSERT INTO detalle_entrada_almacen								SELECT * FROM ";								//mysql_query($insert_historial) or die("Error insertando historial: $insert_historial ".mysql_error());											//echo "<div class='mensaje'>Guardado Correctamente</div>";						/* update apples					   set price = (						  select price from (							 select * from apples						  ) as x						  where variety = 'gala')					   where variety = 'fuji';"; */			}?>