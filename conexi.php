<?php	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	header("Cache-Control: post-check=0, pre-check=0", false);	header("Pragma: no-cache");	function Conectarse()	{		$host="localhost";		$set_local = "SET time_zone = '-05:00'";		$set_names = "SET NAMES 'utf8'";		date_default_timezone_set('America/Mexico_City');						if($_SERVER["SERVER_NAME"] == "localhost"){						$db="muebleria";			$usuario="sistemas";			$pass="Glifom3dia";					}		else{						$db="syncsis_muebleria";			$usuario="syncsis_user";			$pass="muebleria@2015";					}								if (!($link=mysqli_connect($host,$usuario,$pass)))		{			die( "Error conectando a la base de datos.". mysqli_error());		}				if (!mysqli_select_db($link,$db))		{			die( "Error seleccionando la base de datos.". mysqli_error());		} 				if (!mysqli_query($link, $set_local ))			{			die( "Error cambiando TimeZone.". mysqli_error());		}				if($_SERVER["SERVER_NAME"] != "localhost"){			mysqli_query($link, "SET NAMES 'utf8'") or die("Error Cambiando charset");		}		setlocale(LC_ALL,"es_ES");		//mysqli_query("SET CHARACTER SET utf8") or die("Error en charset UTF8".mysqli_ERROR());				if($_SERVER["SERVER_NAME"] == "localhost") {			mysqli_query($link, "SET NAMES 'utf8'") or die("Error Cambiando charset").mysqli_error($link);		}		//ACTIVAR SI LA BASE DE DATOS NO ESTA EN UTF-8		//mysqli_query($set_names, $link) or die( "Error cambiando Charset". mysqli_error());		// mysqli_query ("set character_set_client='utf8'"); 		// mysqli_query ("set character_set_results='utf8'"); 		// mysqli_query ("set collation_connection='utf8_general_ci'");		// mysqli_query("SET NAMES 'utf8'");		/* mysqli_query("SET CHARACTER SET utf8") or die(mysqli_ERROR());			mysqli_query("SET SESSION collation_connection = 'utf8_unicode_ci'");			mysqli_set_charset('utf8', $link) or die(mysqli_ERROR());		*/				return $link;	}?>	