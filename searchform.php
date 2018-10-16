<form id="search-box" role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label class="sr-only"> Buscar no site </label>
	<div class="input-group add-on">		
		<input type="search" id="search-el" class="search-field form-control" placeholder="O que você procura?" value="<?php echo get_search_query() ?>" required name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    <div class="input-group-btn">
      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
    </div>
	</div>
</form>