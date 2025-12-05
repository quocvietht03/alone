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
					<?php 
					    if (function_exists('icl_object_id')) {
							$current_language = apply_filters('wpml_current_language', null);

							if ($current_language === 'ar') {
								?>
								<h1 class="page-title">الأحداث</h1>
								<div id="breadcrumbs" class="breadcrumbs"><span><span>بيت</span> » <span class="breadcrumb_last" aria-current="page">الأحداث</span></span></div>
								<?php
							} else {
								the_archive_title( '<h1 class="page-title">', '</h1>' );
								if ( function_exists('yoast_breadcrumb') ) {
									yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
								}
							}
						} else {
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							if ( function_exists('yoast_breadcrumb') ) {
								yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
							}
						}
					?>
				</div>
			</div>
	</div>
<?php } ?>
