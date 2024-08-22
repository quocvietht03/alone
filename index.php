<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

get_header();

/**
 * Hook: alone_page_titlebar_main
 *
 * @hooked alone_page_titlebar_main_template - 10
 */
do_action( 'alone_page_titlebar_main' );

$classes = 'main-template';

if( 'full-content' !== alone_get_option( 'blog_pages_layout' ) ) {
	$classes .= ( is_active_sidebar( 'blog-sidebar' ) ) ? ' has-sidebar' : '';
	$classes .= ( 'content-sidebar' === alone_get_option( 'blog_pages_layout' ) ) ? ' right-sidebar' : ' left-sidebar';
}

$pagination_type = alone_get_option( 'blog_pagination_type' );

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area <?php echo esc_attr($classes); ?>">
		<div class="container responsive">
			<main id="main" class="site-main">

					<?php
					if ( have_posts() ) {
						?>

						<section class="posts-list blog-posts-list <?php echo esc_attr( $pagination_type ); ?>">
							<?php
								// Load posts loop.
								while ( have_posts() ) {
									the_post();
									get_template_part( 'template-parts/content/content' );
								}
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

					} else {

						// If no content, include the "No posts found" template.
						get_template_part( 'template-parts/content/content', 'none' );

					}
					?>


			</main><!-- .site-main -->

			<?php get_sidebar(); ?>

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
