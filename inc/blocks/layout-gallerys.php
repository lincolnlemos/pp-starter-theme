<?php

// Show 
function pp_print_image($wp_data_image) {

}

function pp_gallery_w_filter($data) {
  // Return if no data
  if (count($data) < 1) return;

  echo '<div class="pp pp-gallery-with-filter">';
    // Show filters only if has more then one category
    if (count($data) > 1):
      echo '<ul class="filters">';
        foreach ($data as $gallery) { 
          $slug = sanitize_title($gallery['category']);
          echo '<li data-filter=".'.$slug.'">'.$gallery['category'].'</li>';
        }
      echo '</ul>';
    endif;
    echo '<div class="medias">';
      foreach ($data as $gallery) {
        
      }
    echo '</div>'; // medias
  echo '</div>';

} // pp_gallery_w_filter