<?php 

function pp_debug($var, $die = true) {
  echo '<pre>'.print_r($var,1). '</pre>';
  if ($die) {
    die();
  }
}

function images_url($file) {
  echo get_images_url($file);
}

function get_images_url($file) {
  return get_stylesheet_directory_uri() . '/assets/images/'. $file;
}

/*
* Helper to create html tags with PHP
*/
function _p($tag = 'p', $content, $args = []) {
    
    // If you pass a string as $arg argument, this will be setup as class.
    if ($args && is_string($args)) {
      $args = ['class' => $args];
    }

    $defaults = array (      
      'class' => '',      
      'before' => '',
      'attr' => [],
      'after' => '',
      'echo' => true
   );

    // Parse incoming $args into an array and merge it with $defaults
    $args = wp_parse_args( $args, $defaults );
    if ($args['class']) { $args['attr']['class'] = $args['class']; }    
    
    
      // Add special filters  
      $check = explode(':', $tag);
      if (count($check) > 1 ) {
        $tag = $check[0];
        $special_tag = $check[1];

        // Update the url to href atrribute
        if ($special_tag == 'acf-link') {

          $args['attr']['href'] = $args['attr']['url'];
          unset($args['attr']['url']);
        
        // Check if the IMAGE has Link and add 
        } elseif ($special_tag == 'acf-image') {

          $image_ID = isset($content['ID']) ? $content['ID'] : false;
          $image_acf_link = $image_ID && get_field('link', $image_ID) ? get_field('link', $image_ID) : false;          
          
          // Setup the url for the image
          $args['attr']['src'] = $content['url'];
          // Clear content
          $content = ' ';
          
          if ($image_acf_link) {
            $title = $image_acf_link['title'] ? $image_acf_link['title'] : '';
            $target = $image_acf_link['target'] ? $image_acf_link['target'] : '_self';
            $args['before'] = '<a title="'.$title.'" href="'.$image_acf_link['url'].'" target="'. $target .'">' . $args['before'];
            $args['after'] = $args['after'] . '</a>';          
          } // if ($image_acf_link) 

        } // elseif ($special_tag == 'acf-image')         

      } //if (count($check) > 1 ) {

    // Check if has content
    if ($content) {
      $output  = $args['before'];

        // Change the structure if is one line tag
        if (in_array($tag, ['img', 'br'])) {          
          $output .= open_tag($tag, $args['attr'], true);
        } else {          
          $output .= open_tag($tag, $args['attr']) . $content . close_tag($tag);
        }

      $output .= $args['after'];
	
      if (isset($args['echo']) && $args['echo'] === false) 
        return $output;
      
      echo $output;
  
    }

}


/* Set Backgrounds */
/* ----------------------------------------- */
  
  function pp_set_bg_color($data) {        
    
    $hex = isset($data['bg_color']) && $data['bg_color'] ? $data['bg_color'] : false;

    $output = '';

    // If we have color set
    if ($hex) {
      $output = 'background-color: ' . $hex . ';';
    }      

    if ($output) {
      return 'style="'.$output.'"' . set_data_color($hex); 
    }
    
  }
  
  
  function pp_set_bg_image($data) {
    
    $desktop = isset($data['bg_desktop']) && $data['bg_desktop'] ?  $data['bg_desktop'] : false;
    $mobile = isset($data['bg_mobile']) && $data['bg_mobile'] ?  $data['bg_mobile'] : false;
    
    $desktop = $desktop && !is_array($desktop) ? wp_get_attachment($desktop) : $desktop;
    $mobile = $mobile && !is_array($mobile) ? wp_get_attachment($mobile) : $mobile;
    

    if ($mobile) {
      echo '<div class="lazy lazy--background pp-bg-mobile d-expand-none" data-bg="url(\''.$mobile['url'].'\')"></div>';
    }

    if ($desktop) {
      echo '<div class="lazy lazy--background pp-bg-desktop" data-bg="url(\''.$desktop['url'].'\')"></div>';
    }

    if (isset($data['mask']) && $data['mask'] ) {
      echo pp_set_mask();
    }
  }

  function pp_set_mask() {
    return apply_filters('pp_set_mask', '<div class="pp-bg-mask"></div>');
  }
/* ----------------------------------------- Set Backgrounds */

function wp_get_attachment( $attachment_id, $size = 'full' ) {

  $attachment = get_post( $attachment_id );
  $href = wp_get_attachment_image_src($attachment_id, $size, 0);

  $return = [
    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'src' => $href[0],
		'url' => $attachment->guid,
		'title' => $attachment->post_title
  ];
  
  $credits = get_field('credits', $attachment_id);
  if ($credits) {
    $return['credits'] = $credits;
  }

	return $return;
}


function set_image($post_id, $size = 'thumbnail', $attrs=[]) {

  $output = '';

  if ($post_id) {

    $data = wp_get_attachment($post_id, 'thumbnail');
    
    $output .= '<figure class="figure--'.$size.'">';
      $output .= '<img class="lazy" data-src="'.$data['src'].'" title="'.$data['title'].'" alt="'.$data['alt'].'" />';
    $output .= '</figure>'; 
    
    return $output;
  }

}

// Try find the URL form image from ACF image returns
function get_acf_image_url($data) {
  if (!$data) return;
  
  if (is_array($data) && isset($data['url']) && $data['url']) {
    return $data['url'];
  }

}


function generate_attr_string($attr) {
  // echo '<pre>'.print_r($attr). '</pre>';
  // die();
  $attr_string = null;
  if (!empty($attr)) {
    foreach ($attr as $key => $value) {
      // If we have attributes, loop through the key/value pairs passed in
      //and return result HTML as a string

      // Don't put a space after the last value
      if ($value == end($attr)) {
        $attr_string .= $key . "=" . '"' . $value . '"';
      } else {
        $attr_string .= $key . "=" . '"' . $value . '" ';
      }
    }
  }       
return $attr_string;      
}

function open_tag($tag, $attr, $close = false) {
  $attr_string = generate_attr_string($attr);
  $final = $close ? " />" : " >";
  return "<" . $tag . " " . $attr_string . $final; 
}

function close_tag($tag) {
  return "</" . $tag . ">";
}

function format_acf_link($acf_data, $args = '') {

// If you pass the full link or just the url, will works
$data = isset($data['link']) && $data['link'] ? $data['link'] : $data;    


// Set defaults
$defaults = [
  'class' => '',
  'content' => $data['title'],
  'target' => $data['target'] ? $data['target'] : '_self',
  'background' => ''
];

$args = wp_parse_args($args, $defaults);

// Configure the background
$content = $args['background'] ? get_lazyload_background($args['background']) . $args['content'] : $args['content'];

// 
return '<a href="'.$data['url'].'" '. $css_inline .' title="'.$data['title'].'" target="'.$args['target'].'" class="'.$args['class'].'">'.$content.'</a>';
}






add_filter('acf/format_value/type=wysiwyg', 'format_value_wysiwyg', 5, 3);
function format_value_wysiwyg( $value, $post_id, $field ) {
  $value = showBeforeMore($value);  
	return $value;
}



function showBeforeMore($fullText){
  
  if(@strpos($fullText, '<!--more-->')){
    $fullText = str_replace('<!--more-->','<span class="d-inline shownext"> (...)</span><p class="hidenext"></p>',$fullText);
  }
  return $fullText;
}

function set_data_color($hex) {
  
  $colorBright = colorBright($hex);
  if ($colorBright) {
    return ' data-color="'.$colorBright. '" data-hex="'.$hex. '" ';
  } else {
    return false;
  }
}


function colorBright($hex) {
  // Check the length
  $length = strlen($hex);
  
  if ($length == 7 | $length == 6) {

    $hex = $length == 7 ? ltrim($hex, '#') : $hex;

    //break up the color in its RGB components
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    //do simple weighted avarage
    //
    //(This might be overly simplistic as different colors are perceived
    // differently. That is a green of 128 might be brighter than a red of 128.
    // But as long as it's just about picking a white or black text color...)
    if($r + $g + $b > 382){
        return 'light';
    }else{
        return 'dark';
    }
    

  } else {
    return false;
  }

  
}