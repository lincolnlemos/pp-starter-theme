<?php 
	echo _partial('_header-search');
	echo _partial('_header-archive');

	if (have_posts()): 

		while (have_posts()) : the_post();
		_loop('loop-content-post');

		endwhile; 
		if (function_exists('wp_pagenavi')) { wp_pagenavi(); };
	endif; 
	wp_reset_query(); 
?>