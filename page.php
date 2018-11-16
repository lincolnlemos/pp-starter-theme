<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$page_template = get_page_template_slug();
$templates = array( 'page-' . $post->post_name . '.twig', 'page.twig' );
if ($page_template) {
	$page_template_slug = str_replace('template-parts/', '', $page_template);
	$page_template_slug = str_replace('.php', '', $page_template_slug);
	array_unshift( $templates, 'pages/'. $page_template_slug .'.twig' );	
}
if ( is_front_page() ) {
	array_unshift( $templates, 'front-page.twig' );		
}
Timber::render( $templates, $context );
