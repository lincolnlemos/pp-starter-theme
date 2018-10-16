<?php while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<figure>
				<?php the_post_thumbnail( 'post-thumb', array( 'class' => 'img-fluid' ) ); ?>
			</figure>
		</a>
		<a href="<?php the_permalink(); ?>" title="Saiba mais sobre: <?php the_title(); ?>"><h2><?php the_title(); ?></h2></a>

		<span class="date"><?php the_date(); ?></span>
		<span class="author"><?php _e( 'Publicado por', 'angolanos' ); ?> <?php the_author_posts_link(); ?></span>
		<span class="comments"><?php comments_number( '0 comentário', '1 comentário', '% comentários' ); ?></span>

		<?php the_content(); ?>

		<?php the_tags( __( 'Tags: ', 'angolanos' ), ', ', '<br>'); ?>
		<p><?php the_category(', '); ?></p>
		<p><?php the_author(); ?></p>
		<?php comments_template(); ?>
	</article>

<?php endwhile; ?>