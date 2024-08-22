<?php
/**
 * Template part for displaying blog posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

?>

<article id="post-<?php the_ID();  ?>" <?php post_class( 'post-wrap' ); ?> >

  <div class="entry-image">
    <?php the_post_thumbnail('medium'); ?>

    <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
      <a class="entry-comment-count" href="<?php comments_link(); ?>">
        <?php
          echo alone_get_icon_svg('comment', 24);
          comments_number( '0', '1', '%' );
        ?>
      </a>
    <?php } ?>
  </div>

  <div class="entry-content">

    <?php if(has_category()) { ?>
			<div class="entry-cat-links"><?php the_category( ', ' ); ?></div>
		<?php } ?>

    <?php the_title( '<h3 class="entry-title"><a href="' . get_the_permalink() . '">', '</a></h3>' ); ?>

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
