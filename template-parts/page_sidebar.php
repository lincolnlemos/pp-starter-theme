<?php 
/**
 * Template Name: Página c/ Sidebar
*/
	get_header();

		_partial('_main-start');
			_loop('index');
		_partial('_main-end');
		
	get_footer();
?>