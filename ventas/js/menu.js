$( document ).ready(function() {
	
	$('body').on('click', '.disabled', function(e) {
		e.preventDefault();
		return false;
	});
});

function ajaxCall(url, data, loader){		
	var request = 	$.ajax({
			"url": url,
			"type":'POST',
			"data":	data,
			"dataType": 'json'
		});
	
	return request;
}
function ajaxError(xhr, textStatus, error){
	alertify.error("<i class='fa fa-warning'></i> Error: " + error);
	console.error(xhr);
	console.error(textStatus);
	console.error(error);
} 
function llenarSelect(id_select, options){
	$("#"+id_select).append(options);
} 