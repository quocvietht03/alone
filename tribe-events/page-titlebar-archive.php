<?php
/**
 * Displays page titlebar in events default template
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if( ! alone_get_option( 'site_titlebar' ) ) {
	return;
}

?>

<?php if( is_post_type_archive( 'tribe_events' ) ) { ?>
	<div class="page-titlebar">
			<div class="container responsive">
				<div class="page-titlebar-content">
					<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
					<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
						}
					?>
				</div>
			</div>
	</div>
<?php } ?>
