$( document ).ready(function() {
	
	$('body').on('click', '.disabled', function(e) {
		e.preventDefault();
		return false;
	}); 
		$(".botonExcel").click(function(){
			
			$('#tabla_reporte').tableExport(
			{
				type:'excel',
				tableName:'Incidencias',
				escape:'false'
			});
		});
		
		$(".btn_exportar").click(function(){
			
			$('#tabla_reporte').tableExport(
			{
				type:'excel',
				tableName:'Registros',
				escape:'false'
			});
		});
		
		$( ".fecha" ).datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: 0
			//yearRange: '1920:2000'
		});
		 
	});