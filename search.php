<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

get_header();

/**
* Hook: alone_page_titlebar_search
*
* @hooked alone_page_titlebar_search_template - 10
*/
do_action( 'alone_page_titlebar_search' );

$pagination_type = alone_get_option( 'blog_pagination_type' );

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area search-page-template">
		<div class="container responsive">
			<main id="main" class="site-main">

			<?php if ( have_posts() ) : ?>
				<section class="posts-list search-posts-list <?php echo esc_attr( $pagination_type ); ?>">
					<?php
					// Start the Loop.
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that
						 * will be used instead.
						 */
						get_template_part( 'template-parts/content/content', 'search' );

						// End the loop.
					endwhile;
					?>
				</section>

				<?php
				if( 'pagination' !== $pagination_type ) {
					// Load more button
					global $wp_query;
					if (  $wp_query->max_num_pages > 1 ) {
						echo '<div class="posts-loadmore">
								<a class="btn-loadmore" href="#">' . esc_html__('More Post', 'alone') . '</a>
							</div>';
					}
				} else {
					// Previous/next page navigation.
					alone_the_posts_navigation();
				}

				// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content/content', 'none' );

			endif;
			?>
			</main><!-- #main -->

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
