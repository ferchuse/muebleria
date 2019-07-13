$(document).ready(function(){
	
		$("#btn_agregar").click(function(){
			$("#modal_nuevo_usuario").modal("show");
		});
		
		$("#form_nuevo_usuario").submit(function(event){
			event.preventDefault();
			spinner = $(this).find(".fa-spin");
			
			if(validar("#form_nuevo_usuario")){
				spinner.toggleClass("hide");
				$.post("control/rows_name_insert.php", 
				{
					"table" : "usuarios",
					"fields_value" : $("#form_nuevo_usuario").serializeArray()
				}   
				, 
				function(response, status){
					if(response.estatus == "success"){
						
						alertify.success(response.mensaje);
						$("#modal_nuevo_usuario").modal("hide");
						
						window.location.reload();
					}
					else{
						
						alertify.error(response.mensaje);
					}
					
					console.log(response);		
					spinner.toggleClass("hide");
						
				});
				
			}
			
		});
		
		
		
		
		$("#btn_actualizar").click(function(){
			$.post("guardar_usuarios.php",  $("#form_usuarios" ).serialize() + "&action=update" ,  function(data_return, status){
				alertify.success(data_return);
				//window.location.reload(true);
			});
		});
		
		$( ".btn_update").click(function(event) {
			boton = $(this);
			id_value= boton.data("id_value");		
			fields_value = boton.closest("tr").find(":input").serializeArray();
			$.post('control/rows_name_update.php', 
				{
					"table": "usuarios",
					"id_field": "id_usuario",
					"id_value": id_value,
					"fields_value": fields_value
				}, 
				function(response,status){
					//boton.closest("tr").fadeOut();
					if(response.estatus == "success"){
						
						alertify.success(response.mensaje);
					}
					else{
						
						alertify.error(response.mensaje);
					}
					
			});
				
		 });
		$( ".btn_delete").click(function(event) {
			boton = $(this);
			id_value= boton.data("id_value");
			alertify.confirm().setting(
				{
					"title":"Confirma",
					"message": "¿Estás seguro que deseas eliminar?",
					"onok" : 
						function(){
							$.get('row_delete.php', 
								{
									"table": "coordinadores",
									"id_field": "id_chef",
									"id_value": id_value
								}, 
								function(response,status){
									boton.closest("tr").fadeOut();
									if(response.estatus == "success"){
										
										alertify.success(response.mensaje);
									}
									else{
										
										alertify.error(response.mensaje);
									}
									
							});
						}
				}).show();
		 });
		 
		function ok_delete(boton){
			
			$.get('borrar.php', {"id": boton.attr("id")}, function(data_return, status){
				boton.closest("tr").fadeOut();
			});
		}
		
		$('input:password').hover(function () {
			$(this).attr('type', 'text');
		}, function () {
			$(this).attr('type', 'password');
		});
		
		function oncancel(){
			return ;
		}
	});