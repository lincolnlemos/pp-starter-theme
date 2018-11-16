<?php

// ADMIN MENU
// YOAST
// DASHBOARD
// WP-LOGIN
// TINYMCE
  // Custom elements
  // Custom Colors


/* ADMIN MENU */
/* ----------------------------------------- */
  // Change menu with fontawesome icons  
  // add_action('admin_head', 'fontawesome_icon_dashboard');

  function fontawesome_icon_dashboard() {
     echo "<style type='text/css' media='screen'>
        #adminmenu #menu-posts-produto div.wp-menu-image:before { font-family:'FontAwesome' !important; content:'\\f0a4'; }  
     </style>";
  }
/* ----------------------------------------- ADMIN MENU */    


/* YOAST */
/* ----------------------------------------- */
  // Filter Yoast Meta Priority
  add_filter( 'wpseo_metabox_prio', function() { return 'low';});
/* ----------------------------------------- YOAST */    


/* DASHBOARD */
/* ----------------------------------------- */
  // Remove default dashboard widgets
  add_action('admin_menu', 'disable_default_dashboard_widgets');


  function disable_default_dashboard_widgets() {
    remove_meta_box('dashboard_browser_nag', 'dashboard', 'core');
    remove_meta_box('dashboard_right_now', 'dashboard', 'core');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
    remove_meta_box('dashboard_primary', 'dashboard', 'core');
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
  }


  // Remove metabox from taxonomies
  add_action('admin_menu', 'disable_metabox_from_taxonomies');
  function disable_metabox_from_taxonomies() {
      global $pagenow;
      if (in_array($pagenow, ['post.php', 'post-new.php'])) {
                  
          $post_type = $pagenow == 'post-new.php' ? (isset($_GET['post_type']) ? $_GET['post_type'] : 'post') : get_post_type($_GET['post']);
          
          $taxonomies = get_object_taxonomies($post_type);

          if ($taxonomies) {
              foreach ($taxonomies as $tax ) {
                  remove_meta_box('tagsdiv-'. $tax, $post_type , 'side');
              }
          }
      }    
  }

/* ----------------------------------------- DASHBOARD */    
  

/* WP-LOGIN */
/* ----------------------------------------- */
  // Call wp-login Styles
  add_action( 'login_head', 'wpmidia_custom_login' );
  
  // Change URL logotype
  add_filter('login_headerurl', 'wpmidia_custom_wp_login_url');

  // Change title logotype
  add_filter('login_headertitle', 'wpmidia_custom_wp_login_title');

  function wpmidia_custom_login() {
      echo '<link media="all" type="text/css" href="'.get_template_directory_uri().'/assets/css/login-style.css" rel="stylesheet">';
      
      $logotipoID = get_field( 'logotipo', 'options', false );
      $img = wp_get_attachment_metadata($logotipoID);
      
      if ($logotipoID) {
      ?>
        <style type="text/css" media="screen">
          body.login h1 a {
            background-image: url(<?php echo wp_get_attachment_url($logotipoID); ?>);
            background-size: contain;
            background-position: center center;
            width: <?php echo $img['width']; ?>px;
            height: <?php echo $img['height']; ?>px;
          }
        </style>   
      <?php      
      }    
  }

  function wpmidia_custom_wp_login_url() {
    return home_url();
  }

  function wpmidia_custom_wp_login_title() {
    return get_option('blogname');
  }
/* ----------------------------------------- WP-LOGIN */    



/* Adiciona o ID do usuário no body-class */
/* ----------------------------------------- */
function id_usuario_body_class( $classes ) {
  global $current_user;
    $classes .= ' user-' . $current_user->ID;
  return trim( $classes );
}
add_filter( 'admin_body_class', 'id_usuario_body_class' );






/* TINYMCE */
/* ----------------------------------------- */
  add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' ); 

  function tiny_mce_remove_unused_formats($init) {
    // Add block format elements you want to show in dropdown
    // $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    return $init;
  }
  
  function my_mce4_options($init) {
    $default_colours = '"000000", "Black",
                        "993300", "Burnt orange",
                        "333300", "Dark olive",
                        "003300", "Dark green",
                        "003366", "Dark azure",
                        "000080", "Navy Blue",
                        "333399", "Indigo",
                        "333333", "Very dark gray",
                        "800000", "Maroon",
                        "FF6600", "Orange",
                        "808000", "Olive",
                        "008000", "Green",
                        "008080", "Teal",
                        "0000FF", "Blue",
                        "666699", "Grayish blue",
                        "808080", "Gray",
                        "FF0000", "Red",
                        "FF9900", "Amber",
                        "99CC00", "Yellow green",
                        "339966", "Sea green",
                        "33CCCC", "Turquoise",
                        "3366FF", "Royal blue",
                        "800080", "Purple",
                        "999999", "Medium gray",
                        "FF00FF", "Magenta",
                        "FFCC00", "Gold",
                        "FFFF00", "Yellow",
                        "00FF00", "Lime",
                        "00FFFF", "Aqua",
                        "00CCFF", "Sky blue",
                        "993366", "Red violet",
                        "FFFFFF", "White",
                        "FF99CC", "Pink",
                        "FFCC99", "Peach",
                        "FFFF99", "Light yellow",
                        "CCFFCC", "Pale green",
                        "CCFFFF", "Pale cyan",
                        "99CCFF", "Light sky blue",
                        "CC99FF", "Plum"';

    $custom_colours =  '"E14D43", "Color 1 Name",
                        "D83131", "Color 2 Name",
                        "ED1C24", "Color 3 Name",
                        "F99B1C", "Color 4 Name",
                        "50B848", "Color 5 Name",
                        "00A859", "Color 6 Name",
                        "00AAE7", "Color 7 Name",
                        "282828", "Color 8 Name"';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';

    // enable 6th row for custom colours in grid
    $init['textcolor_rows'] = 6;

    return $init;
  }
  add_filter('tiny_mce_before_init', 'my_mce4_options');

/* ----------------------------------------- TINYMCE */    


/* Allow upload extra filetypes */
/* ----------------------------------------- */
  function my_extra_upload_files($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter('upload_mimes', 'my_extra_upload_files');
/* ----------------------------------------- Allow upload extra filetypes */    


/* Add Custom Pages to Custom Post Types */
/* ----------------------------------------- */
  function get_my_custom_post_types() {
    // Get all new CPTS
    $post_types = get_post_types(['public' => true ]);
    
    // Remove default CPTS
    unset($post_types['post']);
    unset($post_types['page']);
    unset($post_types['attachment']);

    return $post_types;
  }  

  add_action('init', 'add_custom_pages_to_cpts', 99);
  
  function add_custom_pages_to_cpts() {
    
    $post_types = get_my_custom_post_types();

    // If we still have CPTS
    if ($post_types) {

        foreach ($post_types as $post_type ) {
          
          $parent_slug = 'edit.php';
          if ($post_type != 'post') {
            $parent_slug .= '?post_type=' . $post_type;
          }
          acf_add_options_page([
            'page_title' 	=> __('Configurações', 'pp') . ' ' . ucfirst($post_type),
            'menu_title' 	=> __('Configurações', 'pp') . ' ' . ucfirst($post_type),            
            'menu_slug' 	=> 'acf-'. $post_type,
            'capability' 	=> 'edit_posts', 
            'parent_slug'	=> $parent_slug,
            'position'	=> false,
            'redirect'	=> false,
          ]);
          
        } // foreach
    } // if

  }  


  add_action('admin_bar_menu', 'add_toolbar_items', 100);
  function add_toolbar_items($admin_bar){
    
    // Get my registered CPT's
    $post_types = get_my_custom_post_types();    
    
    
    // Add Edit link to archive pages
    if (is_post_type_archive()) {
      
      // Get the current CPT
      $post_type = get_query_var('post_type');

      // IF the current CPT is on our registered CPTs
      if (in_array($post_type, $post_types)) {
        
        // Add menu to edit page
        $admin_bar->add_menu( array(
          'id'    => 'edit-acf-'. $post_type,
          'title' => 'Editar',
          'href'  => get_admin_url(). 'edit.php?post_type='.$post_type.'&page=acf-'.$post_type,
          'meta'  => array(
            'title' => __('Editar', 'pp'),
          ),
        ));
        
      }
    
    // Add view page to ACF Edit Pages
    } elseif (is_admin() && isset($_GET['page']) && isset($_GET['post_type']) ) {
      
      // Get the current CPT
      $post_type = $_GET['post_type'];

      // IF the current CPT is on our registered CPTs
      if (in_array($post_type, $post_types)) {
        
        // Add menu to edit page
        $admin_bar->add_menu( array(
          'id'    => 'view-acf-'. $post_type,
          'title' => 'Ver ' . ucfirst($post_type),
          'href'  => get_post_type_archive_link($post_type),
          'meta'  => array(
            'title' => __('Ver ', 'pp') . ucfirst($post_type),
          ),
        ));
        
      }

    }
  }

/* ----------------------------------------- Add Custom Pages to Custom Post Types */


