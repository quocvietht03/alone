<?php
/**
 * Template part for displaying search posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

?>

<article id="post-<?php the_ID();  ?>" <?php post_class( 'post-wrap' ); ?> >

  <?php if ( has_post_thumbnail() ) : ?>
    <div class="entry-image">
      <?php the_post_thumbnail('medium_large'); ?>
    </div>
  <?php endif; ?>

  <div class="entry-content">

    <?php if(has_category()) { ?>
			<div class="entry-cat-links"><?php the_category( ', ' ); ?></div>
		<?php } ?>

    <?php the_title( '<h3 class="entry-title"><a href="' . get_the_permalink() . '">', '</a></h3>' ); ?>

    <div class="entry-summary">
  		<?php the_excerpt(); ?>
  	</div>

    <ul class="entry-meta">
      <li>
        <time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo esc_html( get_the_date() ); ?></a></time>
      </li>
      <li>
				<?php echo '<span>' . esc_html__('by ', 'alone') . '</span><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>'; ?>
      </li>
    </ul>

  </div>
</article>
