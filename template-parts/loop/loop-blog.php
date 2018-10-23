<?php 
	echo '<h1>TEsete</h1>';
	echo _partial('_header-search');
	echo _partial('_header-archive');

	$post_type = $wp_query->query['post_type'];
	echo '<pre>'.print_r($post_type,1). '</pre>';
	die();
	if (have_posts()): 
		
		echo '<div class="section section--'.$post_type.'">';

			while (have_posts()) : the_post();

				_loop('loop-content-post');

			endwhile; 
			if (function_exists('wp_pagenavi')) { wp_pagenavi(); };
			
		echo '</div>';
	endif; 
	wp_reset_query(); 
?>