<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">		
		<?php wp_head(); ?>

		<script> 
			// Browser update
			var $buoop = {notify:{e:-2,f:-3,o:-3,s:-2,c:-4},insecure:true,unsupported:true,api:5}; 
			function $buo_f(){ 
			 var e = document.createElement("script"); 
			 e.src = "//browser-update.org/update.min.js"; 
			 document.body.appendChild(e);
			};
			try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
			catch(e){window.attachEvent("onload", $buo_f)}
		</script>
		
	</head>

	<body <?php body_class(); ?>>

		<?php do_action('pp_header', 1); ?>



