	<footer id="footer">
		<div class="container">
			<a class="logotipo logotipo-rodape" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<img src="<?php echo get_field('logotipo_rodape', 'options'); ?>" class="img-fluid"/>
			</a>
			<p> © Copyright <?php echo date('Y') ?> - <?php bloginfo('name'); ?> - Todos direitos reservados</p>
		</div>		
	</footer>

<?php wp_footer(); ?>
</body>
</html>
