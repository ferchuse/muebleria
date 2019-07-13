<?php
	
	header("Content-Type: application/json");
	
	$response= array();
	include("../conexi.php");
	$link=Conectarse();
	$myusername=$_POST['usuario'];
	$mypassword=$_POST['password']; 
	
	// To protect mysqli injection (more detail about mysqli injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysqli_real_escape_string($link, $myusername);
	$mypassword = mysqli_real_escape_string($link, $mypassword);
	$sql="SELECT * FROM usuarios
	WHERE usuario='$myusername' 
	AND pass='$mypassword'";
	$result=mysqli_query($link, $sql);
	if (!$result){
		die('Error: ' . mysqli_error($link));
	}
	$count=mysqli_num_rows($result);
	// Si la consulta devuelve 1 fila inicia la sesion
	if($count==1){
		
		session_start();
		session_regenerate_id(true);
		$id_sesion = session_id();
		$row = mysqli_fetch_assoc($result);
		$id_usuario = $row["id_usuario"];
		$nombre_usuario= $row["usuario"];
		$_SESSION["id_usuario"] = $id_usuario or die("Error al asignar id usuario");
		$_SESSION["usuario"] = $myusername or die("Error al iniciar variables de sesión");
		
		$_SESSION["inicial"] = $row["inicial"];
		$_SESSION["username"] = $nombre_usuario or die("Error al iniciar username");
		$_SESSION["nombre_usuario"] = $row["nombre_usuario"] or die("Error al iniciar nombre_usuario");
		// $_SESSION["permisos"] = $row["permisos"] or die("Error al iniciar permisos");
		
		setcookie("sesion", "si", 0, "/");
		setcookie("id_usuario", $id_usuario,  0, "/");
		setcookie("usuario", $myusername,  0, "/");
		
		$response["login"] = "valid";
		
		
	}
	else{
		$response["login"] = "invalid";
		$response["mensaje"] = "Usuario y/o Contraseña Inválidos";
		
	}
	
	echo json_encode($response);
?>