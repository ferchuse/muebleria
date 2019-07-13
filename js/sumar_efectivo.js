
	function sumar_efectivo(){ 

		var monedas1 = $("#txt_1").val();
		var subtotal_1 = Number(monedas1) *1;
		$("#subtotal_1").html(subtotal_1) ;
		
		var monedas2 = $("#txt_2").val();
		var subtotal_2 = Number(monedas2) *2;
		$("#subtotal_2").html(subtotal_2) ;
		
		var monedas5 = $("#txt_5").val();
		var subtotal_5 = Number(monedas5) *5;
		$("#subtotal_5").html(subtotal_5) ;
		
		var monedas10 = $("#txt_10").val();
		var subtotal_10 = Number(monedas10) *10;
		$("#subtotal_10").html(subtotal_10) ;
		
		var monedas20 = $("#txt_20").val();
		var subtotal_20 = Number(monedas20) *20;
		$("#subtotal_20").html(subtotal_20) ;
		
		var monedas50 = $("#txt_50").val();
		var subtotal_50 = Number(monedas50) * 50;
		$("#subtotal_50").html(subtotal_50) ;
		
		var monedas100 = $("#txt_100").val();
		var subtotal_100 = Number(monedas100) * 100;
		$("#subtotal_100").html(subtotal_100) ;
		
		var monedas200 = $("#txt_200").val();
		var subtotal_200 = Number(monedas200) *200;
		$("#subtotal_200").html(subtotal_200) ;
		
		var monedas500 = $("#txt_500").val();
		var subtotal_500 = Number(monedas500) *500;
		$("#subtotal_500").html(subtotal_500) ;
		
		var vales = $("#txt_vales").val();
		$("#subtotal_vales").html(vales) ;
		
		var tarjeta = $("#txt_tarjeta").val();
		$("#tarjeta").html(tarjeta) ;
		
		var efectivo_inicial = $("#efectivo_inicial").html();
		
		
		var total_efectivo = subtotal_1 + subtotal_2 + subtotal_5 + subtotal_10 + subtotal_20 + subtotal_50+ 
		subtotal_100 + subtotal_200 + subtotal_500;
		//alert(total_efectivo);
				
		$("#total_efectivo").html(Number(total_efectivo) );		
		$("#total_dia").html(Number(total_efectivo) + Number(tarjeta));
		$("#efectivo_final").html(Number(total_efectivo) -Number(vales));
	}
	