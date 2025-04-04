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

if( 1 !== absint( alone_get_option( 'give_change_posts_per_page' ) ) ) {
	$posts_per_page = get_option( 'posts_per_page' );
} else {
	$posts_per_page = absint( alone_get_option( 'give_posts_per_page' ) );
}


if( is_front_page() ) {
	$paged = (get_query_var('page')) ? absint( get_query_var('page') ) : 1;
} else {
	$paged = (get_query_var('paged')) ? absint( get_query_var('paged') ) : 1;
}

$args = [
	'post_type' => 'give_posts',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged,
];

$wp_query = new \WP_Query( $args );

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area <?php echo esc_attr($classes); ?>">
		<div class="container responsive">
			<main id="main" class="site-main">

					<?php if ( $wp_query->have_posts() ) { ?>
							
						<section class="give-forms-list <?php echo esc_attr( $pagination_type ); ?>">
							<?php
							// Load posts loop.
							while ( $wp_query->have_posts() ) {
								$wp_query->the_post();
									get_template_part( 'give/content-give-form' );
							}
							?>
						</section> 

						<?php
						if( 'pagination' !== $pagination_type ) { 
							// Load more button
							
							if ( $wp_query->max_num_pages > 1 ) {
								echo '<div class="give-forms-loadmore give-posts-loadmore" data-posts_per_page="' . $posts_per_page . '" data-current_page="' . max( 1, get_query_var('paged')) . '" data-max_page="' . $wp_query->max_num_pages . '">
										<a class="btn-loadmore" href="#">' . esc_html__('More Post', 'alone') . '</a>
									</div>';
								
							}
						} else {
							// Previous/next page navigation.
							if ( $wp_query->found_posts ) {
								?>
								<nav class="navigation pagination" role="navigation">
									<div class="nav-links">
										<?php
											$big = 999999999;

											if( is_front_page() ) {
												$current = max( 1, get_query_var('page') );
											} else {
												$current = max( 1, get_query_var('paged') );
											}

											echo paginate_links( array(
												'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
												'format' => '?paged=%#%',
												'current' => $current,
												'total' => $wp_query->max_num_pages,
												'mid_size'  => 2,
												'prev_text' => '<svg class="svg-icon" width="12" height="12" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 443.52 443.52" style="enable-background:new 0 0 443.52 443.52;" xml:space="preserve"><path d="M143.492,221.863L336.226,29.129c6.663-6.664,6.663-17.468,0-24.132c-6.665-6.662-17.468-6.662-24.132,0l-204.8,204.8    c-6.662,6.664-6.662,17.468,0,24.132l204.8,204.8c6.78,6.548,17.584,6.36,24.132-0.42c6.387-6.614,6.387-17.099,0-23.712    L143.492,221.863z"></path></svg>' . __( 'Prev', 'alone' ),
												'next_text' => __( 'Next', 'alone' ) . '<svg class="svg-icon" width="12" height="12" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 443.52 443.52" style="enable-background:new 0 0 443.52 443.52;" xml:space="preserve"><path d="M336.226,209.591l-204.8-204.8c-6.78-6.548-17.584-6.36-24.132,0.42c-6.388,6.614-6.388,17.099,0,23.712l192.734,192.734    		L107.294,414.391c-6.663,6.664-6.663,17.468,0,24.132c6.665,6.663,17.468,6.663,24.132,0l204.8-204.8    C342.889,227.058,342.889,216.255,336.226,209.591z"></path></svg>',
											) );
										?>
									</div>
								</nav>
								<?php
							}
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
