<?php	function Conectarse()	{		$host="localhost";		$set_local = "SET time_zone = '-05:00'";		$set_names = "SET NAMES 'utf8'";		date_default_timezone_set('America/Mexico_City');						if($_SERVER["SERVER_NAME"] == "localhost"){						$db="muebleria";			$usuario="sistemas";			$pass="Glifom3dia";					}		else{						$db="syncsis_muebleria";			$usuario="syncsis_user";			$pass="muebleria@2015";					}				if (!($link=mysql_connect($host,$usuario,$pass)))		{			die( "Error conectando a la base de datos.". mysql_error());		}				if (!mysql_select_db($db,$link))		{			die( "Error seleccionando la base de datos.". mysql_error());		} 				if (!mysql_query($set_local, $link))			{			die( "Error cambiando TimeZone.". mysql_error());		}				mysql_query("SET NAMES 'utf8'") or die("Error Cambiando charset");		setlocale(LC_ALL,"es_ES");		//mysql_query("SET CHARACTER SET utf8") or die("Error en charset UTF8".MYSQL_ERROR());						//ACTIVAR SI LA BASE DE DATOS NO ESTA EN UTF-8		//mysql_query($set_names, $link) or die( "Error cambiando Charset". mysql_error());		// mysql_query ("set character_set_client='utf8'"); 		// mysql_query ("set character_set_results='utf8'"); 		// mysql_query ("set collation_connection='utf8_general_ci'");		// mysql_query("SET NAMES 'utf8'");		/* mysql_query("SET CHARACTER SET utf8") or die(MYSQL_ERROR());			mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");			mysql_set_charset('utf8', $link) or die(MYSQL_ERROR());		*/				return $link;	}?>