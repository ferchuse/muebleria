<?php

require_once("excel.php");
require_once("excel-ext.php");
$assoc = array(
 array("Nombre"=>"Mattias", "Edad"=>40),
 array("Nombre"=>"Tony", "Edad"=>15),
 array("Nombre"=>"Peter", "Edad"=>30),
 array("Nombre"=>"Edvard", "Edad"=>20)
 );
createExcel("excel-array.xls", $assoc);
exit;


    require_once("excel.php");
    require_once("excel-ext.php");
    // Consultamos los datos desde MySQL
    $conEmp = mysql_connect("localhost", "userDB", "passDB");
    mysql_select_db("sampleDB", $conEmp);
    $queEmp = "SELECT nombre, direccion, telefono FROM empresa";
    $resEmp = mysql_query($queEmp, $conEmp) or die(mysql_error());
    $totEmp = mysql_num_rows($resEmp);
    // Creamos el array con los datos
    while($datatmp = mysql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    // Generamos el Excel  
    createExcel("excel-mysql.xls", $data);
    exit;
?>

