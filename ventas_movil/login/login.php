<?php
header("Content-Type: application/json");
$response= array();
include("../control/conex.php");
$link=Conectarse();
$myusername=$_POST['usuario'];
$mypassword=$_POST['password']; /* 
$efectivo_inicial=$_POST['efectivo_inicial']; 
 */
// To protect MySQL injection (more detail about MySQL injection)
/* $myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysqli_real_escape_string($myusername);
$mypassword = mysqli_real_escape_string($mypassword); */
$sql="SELECT * FROM usuarios
	WHERE usuario='$myusername' 
	AND pass='$mypassword'";

	$result=mysqli_query($link, $sql);
	if (!$result){
		 die('Error: ' . mysqli_error());
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
	
	$_SESSION["username"] = $nombre_usuario or die("Error al iniciar username");
	$_SESSION["permisos"] = $row["permisos"] or die("Error al iniciar permisos");
	
	
	
	$response["login"] = "valid";
	/* $q_iniciar_turno = "INSERT INTO turnos SET 
	fecha_turno = CURDATE(),
	hora_inicio= CURTIME(),
	efectivo_inicial= $efectivo_inicial,
	id_usuario= '$id_usuario'";
	
	mysqli_query($q_iniciar_turno) or die("Error al insertar turno: $$q_iniciar_turno ".mysqli_error());
	$_SESSION["turno"] = mysqli_insert_id() or die("Error al iniciar turno");
	 */
	//header("location:../index.php");
}
else{
	$response["login"] = "invalid";
	$response["mensaje"] = "Usuario y/o Contraseña Inválidos";
	$response["query"] = $sql;

}

echo json_encode($response);
?>