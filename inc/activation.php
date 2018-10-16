<?php 

/* Clear Theme */
/* ----------------------------------------- */
	
	// Remove default Emojis for Wordpress
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	
	// Remove recent comments style
	function twentyten_remove_recent_comments_style() {  
        global $wp_widget_factory;  
        remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );  
    }  
	add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );



	// Remove inline styles printed when the gallery shortcode is used. 
	function twentyten_remove_gallery_css( $css ) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

/* ----------------------------------------- Clear Theme */		



/* Cria páginas ao instalar o tema */
/* ----------------------------------------- */
// programmatically create some basic pages, and then set Home and Blog
// setup a function to check if these pages exist
function the_slug_exists($post_name) {
	global $wpdb;
	if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
		return true;
	} else {
		return false;
	}
}

$paginas = [
	// [Title, Content, 'Slug']
	['Home', '', 'home'],
	['Blog', '', 'blog'],
	['Institucional', '', 'institucional'],
	['Fale Conosco', '', 'fale-conosco'],
];

// Cria as páginas
if (isset($_GET['activated']) && is_admin()){
	foreach ($paginas as $pagina) {
		$page_check = get_page_by_title($pagina[0]);
		if(!isset($page_check->ID) && !the_slug_exists($pagina[2])){
		    $newPageId = wp_insert_post(array(
		    	'post_type' => 'page',
		    	'post_title' => $pagina[0],
		    	'post_content' => $pagina[1],
		    	'post_status' => 'publish',
		    	'post_author' => 1,
		    	'post_slug' => $pagina[2]
		    ));
		    if ($pagina[0] == 'Home') { update_option( 'page_on_front', $newPageId ); update_option( 'show_on_front', 'page' ); }
		    if ($pagina[0] == 'Blog') { update_option( 'page_for_posts', $newPageId ); }
		}	
	}
}

/* ----------------------------------------- Cria páginas ao instalar o tema */	