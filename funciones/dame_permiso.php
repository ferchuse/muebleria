<?php
	
	
	function dame_permiso($url_paginas,$link){
		
		// return false;
		$consulta = "SELECT * FROM permisos LEFT JOIN paginas USING(id_paginas) 
		WHERE url_paginas = '$url_paginas' 
		AND id_usuarios = {$_SESSION["id_usuarios"]}";
		
		
		$result = mysqli_query($link, $consulta) or die("Error dame_permiso($consulta) ". mysqli_error($link));
		
		if(mysqli_num_rows($result) > 0){
			while($fila = mysqli_fetch_assoc($result)){
				
				$respuesta= $fila["permiso"];
			}
			
			if($respuesta == "Sin Acceso"){
				return "hidden"; 
			}
			else{
				return $respuesta;
			}
			
			
		}
		else{
			
			return false;//"Pagina no existe, $url_paginas,{$_SESSION["id_usuarios"]}, $consulta";
		}
		
	}
	
?>