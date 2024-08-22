<?php
/**
 * The template for displaying all single posts
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
	<div id="primary" class="content-area single-posts-template">
		<main id="main" class="site-main">
			<div class="container responsive">
				<?php

				// Start the Loop.
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content/content', 'single' );

					if ( is_singular( 'attachment' ) ) {
						// Parent post navigation.
						the_post_navigation(
							array(
								/* translators: %s: Parent post link. */
								'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'alone' ), '%title' ),
							)
						);
					} elseif ( is_singular( 'post' ) ) {
						// Author info
						get_template_part( 'template-parts/post/author', 'bio' );

						// Previous/next post navigation.
						alone_the_post_navigation();

					}

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

					// Related posts
					get_template_part( 'template-parts/post/related', 'posts' );

				endwhile; // End the loop.
				?>

			</main><!-- #main -->

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
