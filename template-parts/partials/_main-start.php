<?php global $post; ?>
<main id="main-content" class="main">	
	<?php if (!is_front_page() && !is_home()) : ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php // _partial('_header') ?>
			<section id="content" class="">
	<?php endif; ?>