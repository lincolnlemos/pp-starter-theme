<?php if( have_rows('sociais_info','options') ): ?>
	<ul class="redes-sociais">
		<?php  while ( have_rows('sociais_info','options') ) : the_row(); ?>
			<li>
				<a href="<?php the_sub_field('url_info'); ?>" target="_blank">
					<?php the_sub_field('icone_info'); ?>
				</a>
			</li>
		<?php endwhile; ?>
	</ul>
<?php endif; ?>