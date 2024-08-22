<?php
/**
 * The template for displaying all single give forms
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

get_header();

if( '' !== get_post_meta( get_the_ID(), 'give_style_display_field', true ) ) {
	$give_form_style = get_post_meta( get_the_ID(), 'give_style_display_field', true );
} else {
	$give_form_style = alone_get_option( 'give_form_style' );
}

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area single-give-forms-template <?php echo '' === $give_form_style ? 'default' : 'style-' . $give_form_style;  ?>">
		<main id="main" class="site-main">

			<?php if ( '' === $give_form_style ) { ?>

				<div class="container responsive">
					<?php

					// Start the Loop.
					while ( have_posts() ) :
						the_post();

						give_get_template_part( 'single-give-form/content', 'single-give-form' );

						// Previous/next post navigation.
						the_post_navigation(
							array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'alone' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'alone' ) . '</span> <br/>' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'alone' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'alone' ) . '</span> <br/>' .
									'<span class="post-title">%title</span>',
							)
						);

					endwhile; // End the loop.
					?>

				</main><!-- #main -->

			</div>

			<?php
				} else {
					while ( have_posts() ) : the_post();
						give_get_template_part( 'single-give-form/content', 'style-' . $give_form_style );
						?>
						<div class="container responsive">
							<?php
							// Previous/next post navigation.
							the_post_navigation(
								array(
									'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'alone' ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Next post:', 'alone' ) . '</span> <br/>' .
										'<span class="post-title">%title</span>',
									'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'alone' ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Previous post:', 'alone' ) . '</span> <br/>' .
										'<span class="post-title">%title</span>',
								)
							);
							?>
						</div>
						<?php
					endwhile;
				}
			?>

	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
