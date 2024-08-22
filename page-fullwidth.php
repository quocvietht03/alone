<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.1
 */

get_header();

/**
 * Hook: alone_page_titlebar_page
 *
 * @hooked alone_page_titlebar_page_template - 10
 */
do_action( 'alone_page_titlebar_page' );

?>
<main id="main" class="site-main">
	<?php

	// Start the Loop.
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content/content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

	endwhile; // End the loop.
	?>
</main><!-- #main -->

<?php
get_footer();
