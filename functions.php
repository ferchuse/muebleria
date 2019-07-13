<?php 
	
	function console_log( $data, $tag ){
		echo '<script>';
		echo 'console.log('. json_encode( $data ) .', "'.$tag.'")';
		echo '</script>';
}
	
	?>