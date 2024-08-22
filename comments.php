<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="comment-wrapper clearfix">

	<?php if ( have_comments() ) : ?>
		<h2 class="heading-comment"><?php comments_number( esc_html__('Comment (0)', 'alone'), esc_html__('Comment (1)', 'alone'), esc_html__('Comments (%)', 'alone') ); ?></h2>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'alone' ); ?></p>
	<?php endif; ?>

	<?php
		$commenter = wp_get_current_commenter();

		$fields =  array(
			'author' => '<div class="comment-form-header">
                    <div class="comment-field comment-form-author">
                      <label>' . esc_html__('Name', 'alone') . '</label>
                      <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="'.__('Your name','alone').'" aria-required="true" />
                    </div>',
			'email' => '<div class="comment-field comment-form-email">
                    <label>' . esc_html__('Email', 'alone') . '</label>
                    <input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" placeholder="'.__('youremail@gmail.com','alone').'" aria-required="true" />
                  </div>',
			'url' => '<div class="comment-field comment-form-url">
                  <label>' . esc_html__('Website', 'alone') . '</label>
                  <input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="'.__('http://yourwebsite.com','alone').'" />
                </div>
              </div>',
		);

		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'submit',
			'name_submit'       => 'submit',
			'title_reply'       => '<span class="label-reply">'.esc_html__( 'Leave A Comment', 'alone' ).'</span>',
			'title_reply_to'    => '<span class="label-reply">'.esc_html__( 'Leave A Reply to %s', 'alone' ).'</span>',
			'cancel_reply_link' => esc_html__( 'Cancel Reply', 'alone' ),
			'label_submit'      => esc_html__( 'Post Comment', 'alone' ),
			'format'            => 'xhtml',

			'comment_field' =>  '<div class="comment-field comment-form-comment">
                            <span class="label">' . esc_html__('Your Comment', 'alone') . '</span>
                            <textarea id="comment" name="comment" cols="60" rows="6" aria-required="true" placeholder="'.esc_attr__('Start typing...','alone').'">' . '</textarea>
                          </div>',

			'must_log_in' => '<div class="must-log-in">'.
                          esc_html__('You must be', 'alone').'
                          <a href="'.wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ).'">'.esc_html__('logged in', 'alone').'</a> '.esc_html__('to post a comment.', 'alone').
                        '</div>',

			'logged_in_as' => '<div class="logged-in-as">'.
                          esc_html__('Logged in as', 'alone').'
                          <a class="name" href="'.admin_url( 'profile.php' ).'">'.$user_identity.'</a>.
                          <a href="'.wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ).'" title="'.esc_attr__('Log out of this account', 'alone').'">'.esc_html__('Log out?', 'alone').'</a>
                        </div>',

			'comment_notes_before' => '',

			'comment_notes_after' => '<span class="comment-note">' . esc_html__('All comments are held for moderation.', 'alone') . '</span>',

			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		  );

		comment_form($args);
	?>

  <?php if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h3 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'alone' ); ?></h3>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'alone' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'alone' ) ); ?></div>
		</nav>
		<?php endif; ?>

		<?php
			wp_list_comments( array(
				'style'      => 'div',
				'short_ping' => true,
				'avatar_size' => 48,
				'callback' => 'alone_custom_comment',
			) );
		?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h3 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'alone' ); ?></h3>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'alone' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'alone' ) ); ?></div>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

</div>
