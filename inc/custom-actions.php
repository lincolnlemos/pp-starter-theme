<?php
// Default actions for PP Framework

# 01 - Popups on footer
add_action( 'wp_footer', 'pp_popups');



// You can add popups in front page
function pp_popups() {
  global $post, $popupContent, $cssAdicional;
  
  // Prevent erros in page without $post (Ex: 404 error)
  if (!$post) return;
  
  // Get popups
  $popups = get_field( 'pp-popups', 'options' );
    
  if ($popups) {     
    foreach ($popups as $popup) {
      // If popup are active and is to current page 
      if ($popup['ativo'] && in_array($post->ID, $popup['localizacao'])) {
        $popupContent = $popup['conteudo'][0]; $cssAdicional = $popup['css_adicional'];
        // Chama o arquivo baseado no layout
        include(PP_BLOCK_PATH . '_popups-'. $popupContent['acf_fc_layout']. '.php');
      }
    }
  }
}
