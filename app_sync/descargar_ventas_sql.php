<?php 
	// header("Content-Type: application/json");
	include('../conexi.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = "
	DROP TABLE IF EXISTS ventas;
	DROP TABLE IF EXISTS abonos;
	DROP TABLE IF EXISTS incidencias; 
	 	CREATE TABLE `ventas` (   `No.` varchar(255) DEFAULT NULL,   `fecha_venta` date DEFAULT NULL,   `tarjeta` varchar(11) NOT NULL,   `nv` varchar(255) DEFAULT NULL,   `nombre_cliente` varchar(255) DEFAULT NULL,   `celular` varchar(255) DEFAULT NULL,   `telefono` varchar(20) DEFAULT NULL,   `entre_calles` varchar(255) DEFAULT NULL,   `referencias` text,   `direccion` varchar(255) DEFAULT NULL,   `sector` varchar(255) DEFAULT NULL,   `clave_producto` varchar(255) DEFAULT NULL,   `articulo` varchar(255) DEFAULT NULL,   `clave_vendedor` varchar(255) DEFAULT NULL,   `clave_cobrador` varchar(255) DEFAULT NULL,   `fecha_vencimiento` date DEFAULT NULL,   `mes` varchar(255) DEFAULT NULL,   `importe` varchar(200) DEFAULT NULL,   `enganche` varchar(255) DEFAULT '0',   `saldo_inicial` varchar(200) DEFAULT NULL,   `saldo_actual` decimal(10,0) DEFAULT NULL,   `cobrador` varchar(255) DEFAULT NULL,   `dia_cobranza` varchar(255) DEFAULT NULL,   `fecha_hora_mod` varchar(255) DEFAULT NULL,   `usuario_mod` varchar(255) DEFAULT NULL,   `observaciones` varchar(255) DEFAULT NULL,   `cantidad_abono` decimal(10,2) DEFAULT NULL,   `fecha_ultimo_abono` date DEFAULT NULL,   `coordenadas` varchar(50) DEFAULT '',   `id_estatus` int(11) DEFAULT NULL,   `tipo_articulo` varchar(255) DEFAULT NULL,   `tipo_venta` varchar(255) DEFAULT 'Crédito',   PRIMARY KEY (`tarjeta`) );
	
	CREATE TABLE `abonos` (   `zona` varchar(255) DEFAULT NULL,   `id_abonos` int(10) NOT NULL,   `id_ventas` int(10) NOT NULL,   `fecha_abonos` datetime DEFAULT NULL,   `monto_abonos` decimal(10,0) DEFAULT NULL,   `id_usuarios` int(10) NOT NULL,   `estatus_abonos` varchar(255) DEFAULT 'Activo',   PRIMARY KEY (`id_abonos`,`id_ventas`) );
	
	CREATE TABLE `incidencias` (   `zona` varchar(255) DEFAULT NULL,   `id_ventas` int(10) NOT NULL ,   `tipo_incidencia` varchar(255) DEFAULT NULL,   `comentario` varchar(255) DEFAULT NULL,   `programado` varchar(255) DEFAULT NULL,   PRIMARY KEY (`id_ventas`,`zona`) );
	";
	
	
	$consulta = "SELECT 	* FROM ventas 	WHERE ventas.cobrador = '{$_GET["cobrador"]}' 	AND id_estatus <> '9' 
				AND id_estatus <> '10'  ORDER BY tarjeta 
	";
	$result = mysqli_query($link,$consulta);
	if($result){
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
		}
		while($fila = mysqli_fetch_assoc($result)){
			$insert="INSERT INTO ventas VALUES ";	
			// foreach($fila as $campo => $valor){
			// $insert.= $campo .",";
			// }
			// $insert  = trim($insert, ",");
			// $insert .= ") VALUES ";
			// $insert  = trim($insert, ",");
			
			
			$insert .= "(";
			foreach($fila as $campo => $valor){
				$insert.= "'".$valor ."',";
			}
			$insert  = trim($insert, ",");
			$insert .= ")";
			
			$respuesta.= $insert.";\n";
		}
	}	
	else{
		$respuesta.= mysqli_error($link);
	}
	echo $respuesta;
?> 		