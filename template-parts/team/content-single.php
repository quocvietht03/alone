<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.2
 */

$fields = get_fields();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-team-wrap'); ?>>
	<?php if ( has_post_thumbnail() ) { ?>

		<div class="entry-image">
			<?php the_post_thumbnail('full'); ?>
		</div>

	<?php } ?>

	<div class="entry-content">

		<div class="entry-header">
			<?php
				the_title( '<h1 class="entry-title">', '</h1>' );

				if( !empty( $fields['team_position'] ) ) {
					echo '<div class="entry-position">' . $fields['team_position'] . '</div>';
				}
			?>
		</div>

		<?php
			$socials = alone_get_social_html( get_the_ID(), 'team_socials' );
			if( !empty( $socials ) ) {
		?>
			<div class="entry-socials">
				<h3 class="title">
					<?php esc_html_e('Follow Me: ', 'alone'); ?>
				</h3>

				<?php echo '<div class="socials">' . $socials . '</div>'; ?>
			</div>
		<?php } ?>

		<?php
			if( !empty( $fields['team_info'] ) ) {
				echo '<div class="entry-info">' . $fields['team_info'] . '</div>';
			}
		?>

		<?php if( !empty( $fields['team_phone'] ) || !empty( $fields['team_email'] ) ) { ?>
			<div class="entry-contact">
				<h3 class="title">
					<?php esc_html_e('Contact Info: ', 'alone'); ?>
				</h3>
				<div class="content">
					<?php
						if( !empty( $fields['team_phone'] ) ) {
							echo '<div class="phone">' . $fields['team_phone'] . '</div>';
						}

						if( !empty( $fields['team_email'] ) ) {
							echo '<div class="email">' . $fields['team_email'] . '</div>';
						}
					?>
				</div>
			</div>
		<?php } ?>

		<?php if( !empty( $fields['team_skills'] ) ) { ?>
			<div class="entry-skills">
				<h3 class="title">
					<?php esc_html_e('skills: ', 'alone'); ?>
				</h3>

				<div class="skills">
					<?php foreach ( $fields['team_skills'] as $skill ) { ?>
						<div class="skill-item">
							<?php
								if( !empty( $skill['percent'] ) ) {
									echo '<div class="progress-bar-container" data-percent="' . esc_attr( $skill['percent'] ) . '"></div>';
								}

								if( !empty( $skill['title'] ) ) {
									echo '<div class="title">' . $skill['title'] . '</div>';
								}
							?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->

<?php if ( !empty( get_the_content() ) ) {  ?>
	<div class="member-about-wrap">
		<div class="title-wrap">
			<h3 class="title">
				<?php esc_html_e('About Me: ', 'alone'); ?>
			</h3>
			<div class="sub-title">
				<?php esc_html_e('Education & Training', 'alone'); ?>
			</div>
			<div class="line"></div>
		</div>

		<div class="desc">
			<?php the_content(); ?>
		</div>
	</div>
<?php } ?>

<?php if( !empty( $fields['team_projects'] ) ) { ?>
	<div class="member-projects-wrap">
		<div class="title-wrap">
			<h3 class="title">
				<?php esc_html_e('Projects: ', 'alone'); ?>
			</h3>
			<div class="sub-title">
				<?php esc_html_e('Which Handeled By Me', 'alone'); ?>
			</div>
			<div class="line"></div>
		</div>

		<div class="projects-list">
			<?php foreach ($fields['team_projects'] as $form_id ) { ?>
				<div class="give-form" >
	        <?php
						// Maybe display the featured image.
						printf(
							'<div class="give-card__media">
								%s
								<div class="give-card__overlay"></div>
							</div>',
							get_the_post_thumbnail( $form_id, 'large-medium' )
						);
	        ?>

					<?php the_terms( $form_id, 'give_forms_category', '<div class="give-card__category">', ',', '</div>' ); ?>

	        <div class="give-card__body">
	          <?php
							// Maybe display the form title.
							printf(
								'<h3 class="give-card__title">
									<a href="%s">%s</a>
								</h3>',
								get_the_permalink($form_id),
								get_the_title($form_id)
							);

							// Maybe display the goal progess bar.
							if ( give_is_setting_enabled( get_post_meta( $form_id, '_give_goal_option', true ) ) ) {
									give_show_goal_progress( $form_id );
							}

	          ?>
	        </div>

				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>
