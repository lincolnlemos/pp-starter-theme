<?php

/* Valida CNPJ no WPCF7 */
/* ----------------------------------------- */
  
  // Aqui estão os filtros "wpcf7_validate_text"
  add_filter('wpcf7_validate_text','valida_cnpj_filter', 20, 2); // Campo do CNPJ
  add_filter('wpcf7_validate_text*', 'valida_cnpj_filter', 20, 2); // Campo do CNPJ Obrigatório

  function valida_cnpj_filter( $result, $tag ) {
    $tag = new WPCF7_Shortcode( $tag );
   
    // Aqui vamos testar se é o campo certo...
    if ( 'cnpj' == $tag->name ) {

      // Criamos uma váriavel "$name" para vincular o campo
      $name = $tag->name;

      // Criamos a variável "$the_value" para receber a informação no envio do formulário 
      $the_value = $_POST[$name]; 
   
      // Verificamos se o campo é inválido usando nossa função para validar CNPJ
      if (!valida_cnpj($the_value)) {
        $result->invalidate( $tag, "CNPJ Inválido!" );
      }
   
    }

    return $result;
  }

/* ----------------------------------------- Valida CNPJ no WPCF7 */    
