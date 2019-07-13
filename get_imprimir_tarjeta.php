<?php
header("access-control-allow-origin: *");
include ("conex.php");
include ("is_selected.php");
$link = Conectarse();
$dt_fecha_actual = new DateTime();
$tarjeta = $_GET["tarjeta"];
$tabla_detalle = array();
?>

<?php 
$q_nota = "SELECT * FROM ventas 
	WHERE tarjeta = '$tarjeta'";
	
$result_nota = mysql_query($q_nota,$link) or die("Error en: $q_nota  ".mysql_error());

while($row = mysql_fetch_assoc($result_nota)){
	$tabla_nota[] = $row;
}
$bold = '! U1 SETBOLD 1 ';
$unbold = '! U1 SETBOLD 0 ';
$font1 = ' ! U1 SETLP 1 0 20';
$font2 = ' ! U1 SETLP 2 0 40'; 
$font3 = ' ! U1 SETLP 3 0 40'; 
$font4 = ' ! U1 SETLP 4 0 20'; 
$font5 = ' ! U1 SETLP 5 0 20'; 
$font6 = ' ! U1 SETLP 6 0 20'; 
$font7 = ' ! U1 SETLP 7 0 20'; 
$br = ' ! U1 RY 40 ! U1 X 0'; 
$tab = ' ! U1 X 20'; 
$tab4 = '! U1 X 200';
$tab5 = '! U1 X 300';

$saldo_abonado = $tabla_nota[0]["importe"] - $tabla_nota[0]["enganche"] -  $tabla_nota[0]["saldo_actual"];
$fecha_ultimo_abono = date("d/m/Y", strtotime($tabla_nota[0]["fecha_ultimo_abono"]));

$dt_fecha_hoy = new DateTime();
$dt_fecha_u_abono = new DateTime($tabla_nota[0]["fecha_ultimo_abono"]);
$interval = date_diff($dt_fecha_hoy,$dt_fecha_u_abono);
$dias_atraso = $interval->days;
$num_atrasos = floor($dias_atraso / 7);
//echo "Fecha Ultimo abono:" . $dt_fecha_u_abono->format("d/m/Y") . "<br>";
//echo "Dias Atraso:" . $dias_atraso . "<br>";
//echo "Atrasos:" . $num_atrasos . "<br>";

$encabezado = " ! U1 BEGIN-PAGE ! U1 LMARGIN 1 ! U1 SETLP 4 0 50 ! U1 X 80 MUEBLERIA ! U1 RY 40 ! U1 X 20 CASA ROBERTO ";
$datos_cliente = "";
$datos_nota = " ! U1 SETLP 3 0 20 ";
$datos_nota .= "$br $bold Fecha : $unbold ". date("d/m/Y");
$datos_nota .= "$br $bold Hora : $unbold ". date("h:i A");
$datos_nota .= "$br $bold Tarjeta #: $unbold ". $tabla_nota[0]["tarjeta"];
$datos_nota .= "$br $bold Cliente: $unbold". $tabla_nota[0]["nombre_cliente"];
$datos_nota .= "$br $bold Direccion: $unbold". $tabla_nota[0]["direccion"];
$datos_nota .= "$br $bold Telefono: $unbold". $tabla_nota[0]["tel_cliente"];
$datos_nota .= "$br $bold Dia de Cobro: $unbold $tab4". $tabla_nota[0]["dia_cobranza"];
$datos_nota .= "$br $bold Cobrador: $unbold $tab4". $tabla_nota[0]["cobrador"];
$datos_nota .= "$br $bold Vendedor: $unbold $tab2 ". $tabla_nota[0]["clave_vendedor"];
$datos_nota .= "$br $bold Articulo: $unbold ". $tabla_nota[0]["articulo"];
$datos_nota .= "$br $bold Abono: $unbold            $ ". $tabla_nota[0]["cantidad_abono"];
$datos_nota .= "$br $bold Importe: $unbold          $ ". $tabla_nota[0]["importe"];
$datos_nota .= "$br $bold Enganche: $unbold         $ ". $tabla_nota[0]["enganche"];
$datos_nota .= "$br $bold Saldo Actual: $unbold     $ ". $tabla_nota[0]["saldo_actual"];
$datos_nota .= "$br $bold Cantidad Abonada: $unbold $ ". $saldo_abonado; 
$datos_nota .= "$br $bold Fecha Ult Abono: $unbold". $fecha_ultimo_abono ;
$datos_nota .= "$br $bold Dias de Atraso: $unbold". $dias_atraso;
$datos_nota .= "$br $bold Pagos Atrasados: $unbold". $num_atrasos;
$datos_nota .= "$br $bold Abonos Atrasados: $unbold". number_format(($num_atrasos * $tabla_nota[0]["cantidad_abono"]),2) ;
$datos_nota .= "$br $br      Firma de Confirmidad: " ;
//$datos_nota .= " $font2 FONT 2";
//$datos_nota .= "$font2 FONT 2";
//$datos_nota .= "$font5 FONT 5";
$detalle_nota = "";
$footer = "$br $br _______________________________ $br ! U1 END-PAGE ";
 
$texto_ticket = $encabezado.  $datos_nota . $datos_cliente . $detalle_nota . $footer;
//$texto_ticket = "LOGO ! U1 PCX 10 10 !<RDCLOGO.PCX" ;

echo $texto_ticket;
//echo "<pre>". var_dump($tabla_nota);
//echo json_encode($tabla_nota) ; 
?> 

