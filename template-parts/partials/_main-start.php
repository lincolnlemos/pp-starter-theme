<?php global $post; ?>
<main id="main-content" class="main">	
	
	<?php if (!is_front_page() && !is_home() && !is_archive()) : ?>
		<article <?php post_class(); ?>>
			<?php // _partial('_header') ?>
			<section id="content" class="">
	<?php endif; ?>