<div id="404-wrapper" class="row justify-content-md-center pt-5">
	<div class="col-md-8 col-lg-6">
		<h1 class="page-title">
			<?php _e( 'Página não encontrada :(', 'pp' ); ?>
		</h1>
		<p>
				<?php _e( 'Acho que você se perdeu, digite abaixo o que procura ou volte para a página inicial.', 'pp' ); ?>
		</p>
		<?php get_search_form(); ?>
	</div>
</div>

<script type="text/javascript">
	// focus on search field after it has loaded
	document.getElementById('s') && document.getElementById('s').focus();
</script>