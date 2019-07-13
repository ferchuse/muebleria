function calcular(){
	var importe_total = 0;
	arr_unitario = $(".txt_unitario"); 
	arr_cantidad = $(".txt_cantidad");
	
	$('.txt_importe').each(function(index) {
		this.value=calc_importe(arr_cantidad.get(index).value, arr_unitario.get(index).value);
		importe_total += Number($(this).val());
	});
	
	document.getElementById("txt_total").value = importe_total.toFixed(2);
}
	
function calc_importe(cantidad, unitario){
	if (cantidad== ''){
		return "";
	}
	else{
		return (cantidad * unitario).toFixed(2);
	}
}

function sumChecked() {
		var subtotal = 0;
		var sub_estudios = 0;
		var sub_radiografias = 0;
		var sub_trazos = 0;
		var sub_modelos = 0;
		var sub_periapical = 0;
		var porc_descuento =  $("#txt_descuento").val();
		var anticipo =   Number($("#txt_anticipo").val());
		var n = $(":checked.estudios").length;
		//alert("tamaño de array"+n);
		
		/* var estudio_completo = [];
		var estudios_gratis=new Array("input4","input9")	;
		 */
		if($(":checked.estudio_completo").length >= 1){
			$(":checked.estudio_completo").each(function(){
				sub_estudios += Number($(this).val());
			});
			
			var radiografias_gratis = Number($("#input4").val()) + Number($("#input9").val());
			
			$(":checked.Radiografias").each(function(){
				sub_radiografias += Number($(this).val());
			});
			
			sub_radiografias = sub_radiografias - radiografias_gratis;
			
			if($(":checked.trazos").length == 0 
			|| $(":checked.trazos").length == 1
			|| $(":checked.trazos").length == 2){
				sub_trazos = 0;
			}
			else{
				trazos_gratis = 100;
				$(":checked.trazos").each(function(){
					
					sub_trazos += Number($(this).val()) ;
				});
				sub_trazos = sub_trazos - trazos_gratis;
				
			}
			if($(":checked.modelos").length <= 1){
				sub_modelos = 0;
				
			}
			else{
				modelos_gratis = 230;
				$(":checked.modelos").each(function(){
					
					sub_modelos += Number($(this).val()) ;
				});
				sub_modelos = sub_modelos- modelos_gratis;
			
			}
		}
		else{
			$(":checked.Radiografias").each(function(){
				sub_radiografias += Number($(this).val());
			});
			$(":checked.trazos").each(function(){
				sub_trazos += Number($(this).val());
			});
			$(":checked.modelos").each(function(){	
				sub_modelos += Number($(this).val()) ;
			});
			$(":checked.periapical").each(function(){
				sub_periapical += Number($(this).val());
			});
		}
		
		subtotal = sub_estudios + sub_radiografias + sub_trazos + sub_modelos + sub_periapical;
		
		var descuento = subtotal * porc_descuento/100;
		var importe_total = subtotal - descuento;
		var restante = importe_total - anticipo;
		
		$("#span_subtotal").html(subtotal);
		$("#span_descuento").html(descuento);
		$("#span_importe_total").html(importe_total);
		$("#span_restante").html(restante);
		
		$("#val_subtotal").val(subtotal);
		$("#val_descuento").val(descuento);
		$("#val_importe_total").val(importe_total);
		$("#val_restante").val(restante);
		
		
		//alert(importe_total);
	}