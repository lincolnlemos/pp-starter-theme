<?php 


if (!function_exists('pp_setup_header')) {
    
    function pp_setup_header($args) {
        
        $headerTpl = apply_filters('pp_set_header', 'header_default');        
        $path = 'template-parts/header/' . $headerTpl;
        echo get_template_part($path);
 
    }
}

add_action('pp_header', 'pp_setup_header', 10, 1);
