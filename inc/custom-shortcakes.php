<?php

// Botão usando as classes do boostrap
add_shortcode( 'button', 'button_shortcode' );

// Lista de páginas filhas
add_shortcode( 'paginas-filhas', 'child_pages_shorcode' );


/* Botão usando as classes do boostrap */
/* ----------------------------------------- */
  function button_shortcode( $atts ) {
     extract( shortcode_atts(
       array(
         'titulo' => '',
         'url' => '',
         'target' => '',
         'css_class' => ''
       ),
       $atts
     ));
     return '<a class="btn '.$css_class.'" target="'.$target.'" title="' . $titulo . '" href="' . $url . '">' . $titulo . '</a>';
  }

  if (function_exists('shortcode_ui_register_for_shortcode')) {
    shortcode_ui_register_for_shortcode(
        'button', 
            array(
            'label' => 'Botão',
            'listItemImage' => 'dashicons-video-alt3', /* Optional. src or dashicons-$icon.  */
            'attrs'          => array(  
                array(       
                  'label'        => 'Título',         
                  'attr'         => 'titulo',         
                  'type'         => 'text',         
                  'description'  => 'Please enter the button text',
                ),
                array(
                  'label'        => 'Qual url do botão?',
                  'attr'         => 'url',
                  'type'         => 'url',
                  'class'        => 'regular-text'
                ),
                array(
                  'label'        => 'Abrir em  uma nova janela?',
                  'attr'         => 'target',
                  'type'         => 'radio',
                  'value'      => '_self',
                  'options'      => array('_self' => 'Não', '_blank' => 'Sim')
                ),
                array(
                  'label'        => 'Cor do botão',
                  'attr'         => 'css_class',
                  'type'         => 'radio',
                  'value'      => 'btn-primary',
                  'options'      => [
                      'btn-primary' => 'Primária',
                      'btn-secondary' => 'Secundária'
                  ]
                ),
            ),        
        )
    );
  }
/* ----------------------------------------- Botão usando as classes do boostrap */    



/* Lista de páginas filhas */
/* ----------------------------------------- */    
     
    function child_pages_shorcode( $atts ) {
       extract( shortcode_atts(
         array('tipo' => 'simples'),
         $atts
       ));

       ob_start();
        
        global $post;
        // Defaults 
        $args = [  'child_of' => $post->ID, 'title_li' => '' ];         
        $ulClass = 'list-unstyled';

        if ($tipo == 'veja-tambem') {
          $ulClass .= ' veja-tambem';
          echo '<p class="veja-tambem-title text-primary"><strong>Veja também:</strong></p>';
        }


        echo '<ul class="'.$ulClass.'">';
          wp_list_pages($args);
        echo '</ul>';
        
       return ob_get_clean();

    }

    if (function_exists('shortcode_ui_register_for_shortcode')) {
      shortcode_ui_register_for_shortcode(
          'paginas-filhas', 
          array(
              // 'post_type'     => array( 'page' ),
              'label' => 'Lista de páginas filhas',
              'listItemImage' => 'dashicons-list-view', /* Optional. src or dashicons-$icon.  */
              /** Shortcode Attributes */
              'attrs'          => array(  
                  array(
                    'label'        => 'Selecione o layout de exibição',
                    'attr'         => 'tipo',
                    'type'         => 'radio',
                    'value'        => 'simples',
                    'options'      => array(
                        'simples' => 'Lista simples', 
                        'veja-tambem' => 'Veja também'
                      )
                  ),
              ),  // attrs       
          )
      ); 
    }    
/* ----------------------------------------- Lista de páginas filhas */        
