<?php 

	if (is_page_template('templates/page-sidebar.php')) {		
		_loop('sidebar');		

	} elseif (is_404()) {
		_loop('404');

	} elseif (is_archive()) {
		_loop('archive');

	} elseif (is_single()) {
		_loop('single');

	} elseif (is_page()) {
		_loop('page');

	} else {
		_loop('blog'); 
	}				
?>