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

<article id="post-<?php the_ID();  ?>" <?php post_class( 'blog-post-wrap' ); ?> >

  <div class="entry-image">
    <?php the_post_thumbnail('medium'); ?>
  </div>

  <div class="entry-content">

    <?php if(has_category()) { ?>
			<div class="entry-cat-links"><?php the_category( ', ' ); ?></div>
		<?php } ?>

    <?php the_title( '<h3 class="entry-title"><a href="' . get_the_permalink() . '">', '</a></h3>' ); ?>

    <ul class="entry-meta">
      <li><time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time></li>
      <li><?php echo esc_html__('by ', 'alone') . get_the_author(); ?></li>
    </ul>

  </div>
</article>
