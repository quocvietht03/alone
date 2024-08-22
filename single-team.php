<?php
/**
 * The template for displaying all single team
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

get_header();

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area single-team-template">
		<main id="main" class="site-main">
			<div class="container responsive">
				<?php

				// Start the Loop.
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/team/content', 'single' );

					// Related posts
					get_template_part( 'template-parts/team/related', 'members' );

				endwhile; // End the loop.
				?>

			</main><!-- #main -->

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
