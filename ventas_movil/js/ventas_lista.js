$(document).ready(function(){
	
 		localforage.getItem('ventas').then(function (ventas) {
			if(ventas){
					
					console.log("Ya hay "+ ventas.length+ " Ventas");
					console.log(ventas);
					tabla_ventas = "";
					nueva_fila = {};
					$.each(ventas, function(index, fila){
						tabla_ventas = tabla_ventas;
						$.each(fila, function(index, campo){
							nueva_fila[campo.name] = campo.value;
					
						});
						
						console.log("------------NUEVA FILA");
						console.log(nueva_fila);
						tabla_ventas = tabla_ventas  + "<tr>" + "<td>" + nueva_fila.tarjeta +"</td>"+ "<td>" + nueva_fila.nombre_cliente +"</td>"  + "<td>" + nueva_fila.articulo +"</td>"+ "<td>" + nueva_fila.importe_total +"</td>"+ "<td>" + nueva_fila.enganche +"</td>" 
						+
						
						+
						+ "</tr>";
					});
					$("#tabla_reporte").find("tbody").html(tabla_ventas);
					
	
				}else{
					alertify.error("No hay Ventas");
					$("#tabla_reporte").find("tbody").html("<tr><td colspan='5'>No hay Ventas</td></td>");
	
				}
			
			}).catch(function (err) {
				alertify.error("Error");
				alertify.error(err);
			});
	

	
});