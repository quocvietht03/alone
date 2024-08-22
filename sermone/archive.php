<?php
/**
 * Sermone archive
 *
 * @since 1.0.0
 * @version 1.0.0
 */

get_header();
// echo '<pre>'; print_r( sermone_get_field( 'sermone_user_favorite', 'user_1' ) ); echo '<pre>';
// sermone_update_field( 'sermone_user_favorite', [
//   [
//     'items' => [
//       [
//         'value' => 'post:sermone:191',
//         'type' => 'post',
//         'subtype' => 'sermone',
//         'id' => 191
//       ]
//     ]
//   ]
// ], 'user_1' );
// print_r( sermone_get_favorite_by_user( 1 ) );

/**
* Hook: alone_sermone_page_titlebar_archive
*
* @hooked alone_sermone_page_titlebar_archive_template - 10
*/
do_action( 'alone_sermone_page_titlebar_archive' );

$classes = 'archive-sermone-template';
if( is_singular( 'sermone' ) ) {
	$classes = 'single-sermone-template';
}

?>
<div id="content" class="site-content">
	<div id="primary" class="content-area <?php echo esc_attr($classes); ?>">
    <div class="container responsive">
      <?php
      $query = sermone_get_posts_archive();

      /**
       * sermone_archive_top hook.
       *
       * @see sermone_archive_heading - 16
       * @see sermone_filter_bar - 20
       */
      //do_action( 'sermone_archive_top', $query );

      if ( $query->have_posts() ) :

        do_action( 'sermone_archive_post_list_before', $query );

        $sermone_posts_classes = sermone_archive_posts_classes();
        echo '<div id="sermone-archive-post-list" class="'. $sermone_posts_classes .'">';
        while ( $query->have_posts() ) : $query->the_post();
          /**
           * sermone_archive_post_item_loop hook.
           *
           * @see sermone_archive_post_item_loop - 20
           */
          do_action( 'sermone_archive_post_item_loop', get_the_ID() );
        endwhile;
        echo '</div>';

        /**
         * sermone_archive_post_list_after hook.
         *
         * @see sermone_archive_pagination - 20
         */
        do_action( 'sermone_archive_post_list_after', $query );

      else :

      endif;
      ?>
    </div>
  </div>
</div>
<?php
get_footer();
