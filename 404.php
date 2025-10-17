<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

get_header();
?>
<div id="content" class="site-content">
	<div id="primary" class="content-area error-page-template">
		<div class="container responsive">
			<main id="main" class="site-main">

				<div class="error-404 not-found">
					<div class="error-icon">
						<img src="<?php echo get_template_directory_uri(); ?>/images/404.svg" alt="404 Error">
					</div>

					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'alone' ); ?></h1>

					<div class="page-desc"><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'alone' ); ?></div>

					<?php get_search_form(); ?>

					<div class="page-divider">
						<?php _e( 'OR', 'alone' ); ?>
					</div>

					<a href="https://utenzo.beplusthemes.com" class="back-home-btn">
						<?php _e( 'Back to Home', 'alone' ); ?>
					</a>

				</div><!-- .error-404 -->

			</main><!-- #main -->
		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
