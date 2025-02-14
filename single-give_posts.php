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
	<div id="primary" class="content-area single-give_posts--template">
		<main id="main" class="site-main">
			<div class="container responsive">
				<?php
				// Start the Loop.
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/give_posts/content', 'single' );

				endwhile; // End the loop.
				?>

			</main><!-- #main -->

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
