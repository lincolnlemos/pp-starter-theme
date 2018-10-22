<?php 

function pp_debug($var) {
  echo '<pre>'.print_r($var,1). '</pre>';
  die();
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


// Recebe o 
function set_inline_background($data) {
  
  $tipo = isset($data['tipo_de_background']) && $data['tipo_de_background'] ? $data['tipo_de_background'] : false;
  if (!$tipo) return false;

  $output = '';

  if ($tipo == 'Cor' && $data['cor']) {
    $output = 'background-color: ' . $data['cor'] . ';';
  }
  
  if ($tipo == 'Imagem' && $data['image']) {
    $output = 'background-image: url(' . get_acf_image_url($data['image']) . ');';
  }

  if ($output) {
    return 'style="'.$output.'"'; 
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



// Recebe um array com os backgrounds e imprime as divs
function pp_set_backgrounds($data) {
  
  $desktop = isset($data['background_desktop']) && $data['background_desktop'] ?  $data['background_desktop'] : false;
  $mobile = isset($data['background_mobile']) && $data['background_mobile'] ?  $data['background_mobile'] : false;
  
  if ($desktop) {
    echo '<div class="lazy lazy--background d-none d-md-block" data-bg="url(\''.$desktop['url'].'\')"></div>';
  }
  
  if ($mobile) {
    echo '<div class="lazy lazy--background d-md-none" data-bg="url(\''.$mobile['url'].'\')"></div>';
  }

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

