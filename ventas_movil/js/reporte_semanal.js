$(document).ready(function(){
	function cargarReporte(){ 
		fecha_inicial =  $("#fecha_inicial").val();
		fecha_final =  $("#fecha_final").val();
		icono_carga = $("#load_reporte");
		icono_carga.toggleClass("hide");
		
		 $.ajax({ 
			url: "control/get_reporte_semanal.php", 
			dataType: "html", 
			method: "GET",
			"data": {
						"fecha_inicial": fecha_inicial,
						"fecha_final": fecha_final
						
					},
					success: function( respuesta ) {
						$("#div_tabla_reporte").html(respuesta);
					
					icono_carga.toggleClass("hide");
			},
			error: function( data, status , errno) { // Si el servidor nos manda un error por respuesta, por ej,ERROR 404, 500 , TIMEOUT ,etc. 
				alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " + errno );
				console.log(errno);
				console.log(data);
				console.log(status);
			}
		}); 
		
	}
	
	
	cargarReporte();
	
	
	$("#btn_reporte").click(function(event){
		
	
		cargarReporte();	
		
	});
	$(".fecha").datepicker({
		
		
	});
	
	
});