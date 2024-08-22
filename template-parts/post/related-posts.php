<?php
/**
 * The template for displaying Related Posts
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if( 1 !== absint( alone_get_option( 'show_related_posts' ) ) ) {
  return;
}

global $post;

// Related category
$cats_array = array( 0 );
$cats = wp_get_post_terms( $post->ID, 'category' );
foreach ( $cats as $cat ) {
  $cats_array[] = $cat->term_id;
}
$cats_array = array_map( 'absint', $cats_array );

// Related tag
$tags_array = array( 0 );
$tags = wp_get_post_terms( $post->ID, 'category' );
foreach ( $tags as $tag ) {
  $tags_array[] = $tag->term_id;
}
$tags_array = array_map( 'absint', $tags_array );

$numbers = absint( alone_get_option( 'related_posts_number' ) );

$related = new WP_Query(
 array(
   'post_type'           => 'post',
   'posts_per_page'      => $numbers,
   'ignore_sticky_posts' => 1,
   'no_found_rows'       => 1,
   'order'               => 'rand',
   'post__not_in'        => array( $post->ID ),
   'tax_query'           => array(
     'relation' => 'OR',
     array(
       'taxonomy' => 'category',
       'field'    => 'term_id',
       'terms'    => $cats_array,
       'operator' => 'IN',
     ),
     array(
       'taxonomy' => 'post_tag',
       'field'    => 'term_id',
       'terms'    => $tags_array,
       'operator' => 'IN',
     ),
   ),
 )
);

if ( $related->post_count == 0 ) {
 return;
}

?>
<div class="related-posts-wrap">

  <?php if( alone_get_option( 'related_posts_heading' ) ) { ?>
    <h2 class="related-title"><?php echo alone_get_option( 'related_posts_heading' ); ?></h2>
  <?php } ?>

  <div class="related-posts-list">
    <?php
    while ( $related->have_posts() ) : $related->the_post();

      get_template_part( 'template-parts/content/content' );

    endwhile;
    wp_reset_postdata();

    ?>
  </div>

</div>
