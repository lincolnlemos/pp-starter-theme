<?php


/* Load Javascripts */
/* ----------------------------------------- */

function pp_load_scripts(){
 	
 	$path_js = get_template_directory_uri() . '/assets/js/';
 	$path_css = get_template_directory_uri() . '/assets/css/';
            		
	wp_deregister_script('jquery');	
	wp_deregister_script( 'wp-embed' );

	wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', [], false, true);		
	wp_enqueue_script('gsap', '//cdnjs.cloudflare.com/ajax/libs/gsap/2.0.2/TweenMax.min.js', ['jquery'], false, true);		
	// wp_enqueue_script('gsap-css-plugin', '//cdnjs.cloudflare.com/ajax/libs/gsap/2.0.2/plugins/CSSPlugin.min.js', [], false, true);				
	wp_enqueue_script('gsap-css-rule-plugin', '//cdnjs.cloudflare.com/ajax/libs/gsap/2.0.2/plugins/CSSRulePlugin.min.js', [], false, true);				
	wp_enqueue_script('scrollmagic', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', [], false, true);				
	wp_enqueue_script('scrollmagic--gsap', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.min.js', [], false, true);
	wp_enqueue_script('scrollmagic--debug', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', ['scrollmagic'], false, true);				
	wp_enqueue_script('flickty', '//unpkg.com/flickity@2/dist/flickity.pkgd.min.js', [], false, true);				
	wp_enqueue_script('lazyload', '//cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/8.15.2/lazyload.min.js', [], false, true);				
	wp_enqueue_script('pp-main', $path_js . 'main.js', ['gsap', 'scrollmagic', 'flickty', 'lazyload'], false, true);
	// wp_enqueue_script('pp-libs', $path_js . 'libs.js', [], false, true);
	
				
	// wp_localize_script( 'jquery', 'siteVars', [] );
  	
  	// wp_enqueue_style( 'bootstrap', $path_css . 'bootstrap.css');
  	// wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=');
	// wp_enqueue_style( 'main', $path_css . 'main.css');
  	// wp_enqueue_style( 'libs', $path_css . 'libs.css');

}
add_action( 'wp_enqueue_scripts', 'pp_load_scripts' );


function pp_load_admin_scripts() {

	$path_js = get_template_directory_uri() . '/assets/js/';
	$path_css = get_template_directory_uri() . '/assets/css/';
	 
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
			'secondary' => __( 'Navegação Local', 'pp' ),
		) );

}
endif;


// Adiciona tamanho de thumbs customizáveis
add_action('init', 'add_custom_image_sizes');

function add_custom_image_sizes() {
	add_image_size('post-gallery', 750, 440, true); 
	// add_image_size('slider-destaque', 1170, 350, true);
	// add_image_size('imagem-thumb', 800, 600, true);
}


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
