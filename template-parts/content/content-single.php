<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-wrap'); ?>>
	<?php if ( has_post_thumbnail() ) { ?>

		<div class="entry-image">
			<?php the_post_thumbnail('full'); ?>
		</div>

	<?php } ?>

	<div class="entry-content">
		<?php if(has_category()) { ?>
			<div class="entry-cat-links"><?php the_category( ', ' ); ?></div>
		<?php } ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<ul class="entry-meta">
			<li>
				<?php if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) { ?>
					<time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>"><?php echo esc_html__('Updated on ', 'alone') . esc_html( get_the_modified_date() ); ?></time>
				<?php } else { ?>
					<time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html__('Posted on ', 'alone') . esc_html( get_the_date() ); ?></time>
				<?php } ?>
			</li>
			<li>
				<?php echo '<span>' . esc_html__('by ', 'alone') . '</span><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar( get_the_author_meta( 'ID' ), 22 ) . ' ' . get_the_author() . '</a>'; ?>
			</li>
			<?php
	      if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
					echo '<li>';
					comments_popup_link();
					echo '</li>';
	      }
	     ?>
		</ul>

		<div class="entry-content-inner">
			<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'alone' ),
						'after'  => '</div>',
					)
				);
			?>

		</div>

		<?php if( has_tag() || 1 === absint( alone_get_option( 'show_socials_share' ) ) ) : ?>
			<div class="entry-footer">
				<?php the_tags( '<div class="entry-tag-links"><span>'. esc_html__('Tags: ', 'alone') .'</span>', '', '</div>' ); ?>

				<?php
					/**
					 * Hook: alone_entry_share_socials
					 *
					 * @hooked alone_share_socials_wrapper_start - 10
					 * @hooked alone_share_socials_content - 20
					 * @hooked alone_share_socials_wrapper_end - 40
					 */
					do_action( 'alone_entry_share_socials' );
				?>
			</div>
		<?php endif; ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
