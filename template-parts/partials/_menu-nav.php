<?php   
  $logotipoMobile = get_field('mobile_logotipo', 'options');
  $logotipo = get_field('logotipo', 'options');
?>
  <div class="row">

    <nav class="navbar">

      <a class="navbar--logo d-inline-block d-expand-none" href="<?php echo get_home_url(); ?>"> 
        
        <?php         
          // Se existir um $logotipoMobile cadastrado, altera as classes
          $logotipoCssClass = $logotipoMobile ? 'd-none d-lg-inline-block' : 'd-inline-block';
          // Se estiver cadastrado o logotipo, exibe o mesmo. 
          // Caso contrário exibe o nome do site          
          $headerName = $logotipo ? 
            '<img src="'. $logotipo .'" class="'.$logotipoCssClass.' img-fluid" alt="Logotipo '.get_bloginfo().'"/>' :
            get_bloginfo( 'name' );
          echo $headerName;

          // Se existir logo para mobile, exibe-o
          echo ($logotipoMobile ? '<img src="'. $logotipoMobile .'" height="30" class="d-inline-block d-lg-none img-fluid align-top" alt="Logotipo '.get_bloginfo().'">' : '');

        ?>
        
      </a>
            
      <span class="navbar--toggler js-toggle-menu d-inline-block d-lg-none icon-toggle" data-bodyclass="mobilemenu--open"></span>
      <span class="navbar--searchicon d-inline-block icon-search d-lg-none"></span>
      
      <div class="navbar--container">

        <div class="navbar--navigation d-md-none">
          <div class="navbar--navigation--back"><span></span></div>
          <div class="navbar--navigation--current"></div>
          <div class="navbar--navigation--close js-toggle-menu" data-bodyclass="mobilemenu--open"><span></span></div>
        </div>

        <?php wp_nav_menu(['theme_location' => 'primary','container' => false, 'menu_class' => 'navbar--menu']); ?> 

      </div>         

    </nav><!-- /.navbar-collapse -->    
  </div>