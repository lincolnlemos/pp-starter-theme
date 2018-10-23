<aside id="sidebar" class="sidebar col-md-4">
    <?php 
    	if ( is_active_sidebar( 'sidebar-principal' ) ) :
    	   dynamic_sidebar( 'sidebar-principal' );
    	endif;
    ?>
</aside>