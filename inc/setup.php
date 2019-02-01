<?php


/* Load Default Javascripts and Styles */
/* ----------------------------------------- */

function pp_load_scripts(){
 	
 	$path_js = get_template_directory_uri() . '/assets/js/';
 	$path_child_js = get_stylesheet_directory_uri() . '/assets/js/';
	 
	$path_css = get_template_directory_uri() . '/assets/css/';
	$path_child_css = get_stylesheet_directory_uri() . '/assets/css/';
	 
	 $framework = get_template_directory_uri() . '/assets/framework/';
	 
	wp_deregister_script('jquery');	

	wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', [], false, false);
	wp_enqueue_script('pp-main', $path_child_js . 'main.js', ['jquery'], false, true);


	// Only for Framework Test Purposes
	if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'framework.pp') {		
		
		/* Prism JS */
		/* ----------------------------------------- */
			// https://prismjs.com/download.html#themes=prism-okaidia&languages=markup+css+clike+javascript+css-extras+markup-templating+php+scss+twig
			wp_enqueue_script('prism-js', $framework . 'prism.js', ['jquery'], false, true);
			wp_enqueue_style( 'prism-css', $framework. 'prism.css');
			/* ----------------------------------------- Prism JS */
			
			wp_enqueue_style( 'framework-css', $path_css. 'framework.css');
	}

	
}
add_action( 'wp_enqueue_scripts', 'pp_load_scripts' );


function pp_load_admin_scripts() {

	$path_js = get_stylesheet_directory_uri() . '/assets/js/admin/';
	$path_css = get_stylesheet_directory_uri() . '/assets/css/admin/';
	 
	wp_enqueue_style( 'custom-admin-style', $path_css. 'admin-style.css');	
}
add_action('admin_enqueue_scripts', 'pp_load_admin_scripts');



// Runs a function after_setup_theme
add_action( 'after_setup_theme', 'pp_setup' );

if ( ! function_exists( 'pp_setup' ) ):

	// Configura os padrões do tema e suporte a algumas funções do wp.
	function pp_setup() {

		// Add callback for custom TinyMCE editor stylesheets.
		add_editor_style('assets/css/editor-style.css');

		// Registers theme menu's 
		register_nav_menus( array(
			'primary' => __( 'Navegação Global', 'pp' ),
			'secondary' => __( 'Navegação Blog', 'pp' ),
		) );

}
endif;


/* Excerpt */
/* ----------------------------------------- */
	
	function twentyten_excerpt_length( $length ) { return 40; }
	add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

	function twentyten_continue_reading_link() {
		return ' <a href="'. get_permalink() . '" title="Veja mais sobre '. get_the_title() .'">' . __( 'Saiba mais', 'pp' ) . '</a>';
	}

	function twentyten_auto_excerpt_more( $more ) {
		return ' &hellip;' . twentyten_continue_reading_link();
	}
	add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );


	function twentyten_custom_excerpt_more( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= twentyten_continue_reading_link();
		}
		return $output;
	}
	add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );
/* ----------------------------------------- Excerpt */		



/**
 * Register widgetized areas 
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar', 'pp' ),
		'id' => 'sidebar-principal',
		'description' => __( 'Arraste os itens desejados até aqui. ', 'pp' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 style="display:none;">',
		'after_title' => '</h2>',
	) );

}

/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );


	

/* 
	Filtro para criar container responsivo nos embeds do the_content
	Style no @pp-default-styles.less
/* ----------------------------------------- */
	add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);
	function wrap_embed_with_div($html, $url, $attr) {
	        return "<div class=\"responsive-container\">".$html."</div>";
	}
/* ----------------------------------------- Filtro para criar container responsivo nos embeds do the_content */		



/* Adiciona classes ao body caso seja mobile */
/* ----------------------------------------- */
	function device_body_class ( $classes )  {
			
		if ( wp_is_mobile() ) {
			$classes[] = 'mobile';		
		} else {
			$classes[] = 'desktop';
		}
		return $classes;
	}
	add_filter( 'body_class', 'device_body_class' );

/* ----------------------------------------- Adiciona classes ao body caso seja mobile */




