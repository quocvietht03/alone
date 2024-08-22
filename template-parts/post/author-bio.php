<?php
/**
 * The template for displaying Author info
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if ( 1 !== absint( alone_get_option( 'show_author_bio' ) ) ) {
	return;
}

if ( (bool) get_the_author_meta( 'description' ) ) : ?>

<div class="author-bio">
	<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>

	<h3 class="author-title"><?php echo esc_html__('By ', 'fuel-com') . get_the_author(); ?></h3>

	<div class="author-desc"><?php echo get_the_author_meta('description') ?></div>

	<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
		<?php esc_html_e( 'View more posts', 'alone' ); ?>
	</a>
</div><!-- .author-bio -->
<?php endif; ?>
