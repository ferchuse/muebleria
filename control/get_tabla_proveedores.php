<?php
include("conexi.php");
$link=Conectarse();

$tabla = $_POST["tabla"];
$id_field = $_POST["id_field"];
$nombres_campos=array(
	"Proveedor",
	"razon_social_prov",
	"Rfc",
	"Tipo",
	"Estado",
	"Telefono",
	"email"
	
	);
$query = "SELECT *  FROM $tabla  ";

if(isset($_POST["campo_filtro"])){
	
	$campo_filtro = $_POST["campo_filtro"];
	$valor_filtro = $_POST["valor_filtro"];
	$query.= " WHERE $campo_filtro LIKE '%$valor_filtro%' ";
}
if(isset($_POST["order"])){
	$order = $_POST["order"];
}else{
	$order = "Especialidad";
	}
$query.= " ORDER BY  $order ";

$query.= " LIMIT 50";

$result_med = mysqli_query( $link , $query)
or die("Error al ejecutar $query: $query".mysqli_error($link ));

$numero_filas = mysqli_num_rows($result_med);

if($numero_filas == 0){ ?>
	<tr >
		<td class="" colspan="5">
			<div class="alert alert-warning">
				No hay resultados
			</div>
		</td>
	</tr>	
	
	
<?php	
}		
while($fila = mysqli_fetch_assoc($result_med)) { //iteramos por cada fila del resultado de la consulta
	
	
?>
	<tr >
		<?php foreach($nombres_campos as $nombre_campo){?>
			<td ><?php echo $fila["$nombre_campo"]?></td>
			<?php
		}
		?>
		
		<td>
			
			<button  type="button" title="Editar" class="btn btn-warning btn-sm editar_fila " data-id_value="<?php echo $fila["$id_field"];?>" >
				<i class="fa fa-pencil"></i> 
			</button>
			<button  type="button" title="Eliminar"   class="btn btn-danger btn-sm borrar_fila "  data-id_value="<?php echo $fila["$id_field"];?>" >
				<i class="fa fa-trash"></i>  
			</button>
		</td>
	</tr>	
<?php
}
