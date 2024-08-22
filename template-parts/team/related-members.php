<?php
/**
 * The template for displaying Related Members
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.2
 */

if( 1 !== absint( alone_get_option( 'show_related_members' ) ) ) {
  return;
}

global $post;

// Related category
$cats_array = array( 0 );
$cats = wp_get_post_terms( $post->ID, 'team_category' );
foreach ( $cats as $cat ) {
  $cats_array[] = $cat->term_id;
}
$cats_array = array_map( 'absint', $cats_array );

// Related tag
$tags_array = array( 0 );
$tags = wp_get_post_terms( $post->ID, 'team_category' );
foreach ( $tags as $tag ) {
  $tags_array[] = $tag->term_id;
}
$tags_array = array_map( 'absint', $tags_array );

$numbers = absint( alone_get_option( 'related_members_number' ) );

$related = new WP_Query(
 array(
   'post_type'           => 'team',
   'posts_per_page'      => $numbers,
   'ignore_sticky_posts' => 1,
   'no_found_rows'       => 1,
   'order'               => 'rand',
   'post__not_in'        => array( $post->ID ),
   'tax_query'           => array(
     'relation' => 'OR',
     array(
       'taxonomy' => 'team_category',
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
<div class="related-members-wrap">

  <div class="title-wrap">
    <h3 class="title">
      <?php esc_html_e('Members: ', 'alone'); ?>
    </h3>
    <div class="sub-title">
      <?php esc_html_e('Team With Me', 'alone'); ?>
    </div>
    <div class="line"></div>
  </div>

  <div class="members-list">
    <?php
    while ( $related->have_posts() ) : $related->the_post();
      ?>
        <div class="member-wrap" >

          <div class="entry-image">
            <div class="entry-overlay"></div>

            <?php
              the_post_thumbnail('medium');

              $socials = alone_get_social_html( get_the_ID(), 'team_socials' );
        			if( !empty( $socials ) ) {
        				echo '<div class="entry-socials">' . $socials . '</div>';
        			}
            ?>
          </div>

          <div class="entry-content">

            <?php
              the_title( '<h3 class="entry-title"><a href="' . get_the_permalink() . '">', '</a></h3>' );

              $postion = get_field( 'team_position' );
              if( !empty( $postion ) ) {
        				echo '<div class="entry-postion">' . $postion . '</div>';
        			}
            ?>

          </div>
        </div>
      <?php
    endwhile;
    wp_reset_postdata();

    ?>
  </div>

</div>
