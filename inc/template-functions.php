<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function alone_body_classes( $classes ) {

	if ( is_singular() ) {
		$classes[] = 'singular';
	} else {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'alone_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 */
function alone_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'alone_post_classes', 10, 3 );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function alone_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'alone_pingback_header' );

/**
 * Changes comment form default fields.
 */
function alone_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'alone_comment_form_defaults' );

/**
 * Custom comment list
 */
function alone_custom_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo esc_html( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? 'comment-item-wrap clearfix' : 'comment-item-wrap parent clearfix' ) ?> id="comment-<?php comment_ID() ?>">
	<div class="comment-item clearfix">
    <div class="comment-head">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
      <div class="comment-info">
        <h3 class="name"><?php echo get_comment_author( get_comment_ID() ); ?></h3>
  			<div class="date"><?php echo get_comment_date(); ?></div>
      </div>
    </div>
		<div class="comment-content">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'alone' ); ?></em>
			<?php endif; ?>
			<?php comment_text(); ?>
			<?php
				comment_reply_link( array_merge( $args,
					array(
						'reply_text' => __('Reply ', 'alone') . alone_get_icon_svg( 'reply', 12 ),
						'add_below' => $add_below,
						'depth' => $depth,
						'max_depth' => $args['max_depth']
					)
				) );
			?>
		</div>
	</div>
<?php
}

/**
 * Filters the default archive titles.
 */
function alone_get_the_archive_title() {

	if ( is_category() ) {
		$title =  single_term_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author_meta( 'display_name' );
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'alone' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'alone' ) );
	} elseif ( is_day() ) {
		$title = get_the_date();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name. */
		$title = $tax->labels->singular_name;
	} else {
		$title = __( 'Archives', 'alone' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'alone_get_the_archive_title' );

/**
 * Add custom sizes attribute to responsive image functionality for post thumbnails.
 *
 * @origin Alone 7.0
 *
 * @param array $attr  Attributes for the image markup.
 * @return string Value for use in post thumbnail 'sizes' attribute.
 */
function alone_post_thumbnail_sizes_attr( $attr ) {

	if ( is_admin() ) {
		return $attr;
	}

	if ( ! is_singular() ) {
		$attr['sizes'] = '(max-width: 34.9rem) calc(100vw - 2rem), (max-width: 53rem) calc(8 * (100vw / 12)), (min-width: 53rem) calc(6 * (100vw / 12)), 100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'alone_post_thumbnail_sizes_attr', 10, 1 );

/**
 * Get socials html
 *
 * @origin Alone 7.0
 */
function alone_get_social_html( $post_id, $field_key ) {

	$socials = get_field( $field_key, $post_id );

	if( empty( $socials ) ) {
		return;
	}

	$output = '';

	foreach ( $socials as $social ) {
		if( !empty( $social['name'] ) ) {
			$output .= '<a class="' . esc_attr( $social['name'] ) . '" href="' . esc_url( $social['url'] ) . '" title="' . esc_attr( $social['name'] ) . '">' . alone_get_social_icon_svg( $social['name'], 16 ) . '</a>';
		}
	}

	return $output;
}
