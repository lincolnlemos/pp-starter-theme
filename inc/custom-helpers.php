<?php 

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
      
        $output .= open_tag($tag, $args['attr']) . $content . close_tag($tag);

      $output .= $args['after'];
	
      if (isset($args['echo']) && $args['echo'] === false) 
        return $output;
      
      echo $output;
  
    }

}