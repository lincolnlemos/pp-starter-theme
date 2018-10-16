<?php while (have_posts()) : the_post(); ?>
	
	<header> <h1 class="page-title"> <?php the_title(); ?> </h1> </header>
	
	<div class="conteudo">
		<?php
			// Se não exister conteúdo, exibe as páginas filhas
			if (!$post->post_content) { echo do_shortcode('[paginas-filhas]'); }				
			the_content(); 
		?>
	</div>
	
	<footer>
		<?php _partial('_comments-disqus'); ?>
	</footer>

<?php endwhile; ?>