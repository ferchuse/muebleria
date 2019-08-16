<?php
	header("Content-Type: application/json");
	include("../conexi.php");
	$link  = Conectarse();
	$respuesta   = array();
	//Busca el ultimo turno
	$q_turnos = "SELECT * FROM  turnos ORDER BY id_turnos DESC LIMIT 1";
	
	$respuesta["q_turnos"] = "$q_turnos";
	$result = mysqli_query($link, $q_turnos);
	
	if(!$result){
		$respuesta["buscar_turno"] = "Error al Buscar Turno: $q_turnos". mysqli_error($link);
		}
	else{
		$num_rows = mysqli_num_rows($result) ;
		$respuesta["num_rows"] = "$num_rows";
		//No hay turno, iniciar 1
		if($num_rows == 0){
			$respuesta["ultimo_turno"] = 1;
			$respuesta["pedir_efectivo"] = 1;
			$respuesta["accion"] = "No hay turnos";
			
			$insertar_turno = "INSERT turnos SET 
			fecha_inicio_turnos = CURDATE(),
			hora_inicios = CURTIME()
			";
			if(mysqli_query($link,$insertar_turno)){
				$respuesta['estatus'] = 'success';
				}else{
				$respuesta['estatus'] = 'error';
				$respuesta['mensaje'] = 'Error en Insertar Turno';
			}
		}
		#Ya hay un turno, verificar si esta abierto o cerrado
		else{
			$consulta = "SELECT * FROM turnos WHERE cerrado = 0 ";
			$resultado = mysqli_query($link,$consulta);
			$numero_turno_abiertos = mysqli_num_rows($resultado);
			if($numero_turno_abiertos == 0){
				$insertar_nuevo_t = "INSERT INTO turnos SET 
				fecha_inicio_turnos = CURDATE(),
				hora_inicios = CURTIME(), cerrado = 0";
				
				if(mysqli_query($link,$insertar_nuevo_t)){
					$respuesta['estatus'] = "success";
					$respuesta["pedir_efectivo"] = 1;
				}
				else{
					$respuesta['estatus'] = 'error';
					$respuesta['mensaje'] = 'Error en Insertar';
					
				}
				
			}
			else{
				while($fila = mysqli_fetch_assoc($result)){
					$respuesta["ultimo_turno"] = $fila["id_turnos"];
					$respuesta["cerrado"] = $fila["cerrado"];
					$respuesta["efectivo_inicial"] = $fila["efectivo_inicial"]; 
				}
				
			}
			
			
		}
	}
	echo json_encode($respuesta);
	
?>