<?php
/**
 * The template for displaying archive give pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

get_header();

/**
* Hook: alone_page_titlebar_archive
*
* @hooked alone_page_titlebar_archive_template - 10
*/
do_action( 'alone_page_titlebar_archive' );

$classes = 'archive-donation-page-template';

if( 'full-content' !== alone_get_option( 'give_pages_layout' ) ) {
	$classes .= ( is_active_sidebar( 'blog-sidebar' ) ) ? ' has-sidebar' : '';
	$classes .= ( 'content-sidebar' === alone_get_option( 'give_pages_layout' ) ) ? ' right-sidebar' : ' left-sidebar';
}

$pagination_type = alone_get_option( 'give_pagination_type' );

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area <?php echo esc_attr($classes); ?>">
		<div class="container responsive">
			<main id="main" class="site-main">

					<?php if ( have_posts() ) { ?>

						<section class="give-forms-list <?php echo esc_attr( $pagination_type ); ?>">
							<?php
							// Load posts loop.
							while ( have_posts() ) {
								the_post();
									get_template_part( 'give/content-give-form' );
							}
							?>
						</section> 

						<?php
						if( 'pagination' !== $pagination_type ) {
							// Load more button
							global $wp_query;
							if (  $wp_query->max_num_pages > 1 ) {
								echo '<div class="give-forms-loadmore">
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

			<?php get_sidebar( 'give' ); ?>

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
