$( document ).ready(function() {
	
	$("#txt_descuento").on("keyup", sumChecked);
	$("#txt_anticipo").on("keyup", sumChecked);
	
	$(".estudio_completo").click(function(){
		/* Rx. Panorámica    ( impresa)
		Rx. Lateral de Cráneo   ( impresa)
		Fotografias ( 9 ) Impresas
		2 Trazos computarizados
		Modelos Estudio */

		sumChecked(); 
	});
	$(".Radiografias").click(function(){
		sumChecked();
	});
	$(".trazos").click(function(){
		sumChecked();
	});
	$(".modelos").click(function(){
		sumChecked();
	});
	$(".periapical").click(function(){
		sumChecked();
	});
	
	$("#input1").click(function(){
		/* $(':checkbox[readonly=readonly]').click(function(){
			return false;        
	}); */
		$("#input4").click();
		$("#input4").attr("readonly", "readonly");
		$("#input9").click();
		$("#input4").attr("readonly", "readonly");
		$("#input37").click();
		sumChecked();
	});
	
	$("#input2").click(function(){
		$("#input4").click();
		$("#input9").click();
		//$("#input36").click();
		sumChecked();
	});
	$("#input3").click(function(){
		$("#input4").click();
		$("#input9").click();
		$("#input36").click();
		//$("#input37").click();
		sumChecked();
	});
});