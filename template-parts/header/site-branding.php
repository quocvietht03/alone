<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */
?>
<div class="site-branding">
	<div class="container">
		<div class="branding-wrap">
			<?php
				if ( has_custom_logo() ) :
					/**
					 * Hook: alone_site_logo_image
					 *
					 * @hooked alone_site_branding_logo_image - 10
					 */
					do_action( 'alone_site_logo_image' );

				else :
					/**
					 * Hook: alone_site_logo_text
					 *
					 * @hooked alone_site_branding_logo_text - 10
					 */
					do_action( 'alone_site_logo_text' );

				endif;
			?>

			<div class="site-menu-wrap">
				<?php
				/**
				 * Hook: alone_primary_navigation.
				 *
				 * @hooked alone_site_branding_primary_navigation - 10
				 */
				do_action( 'alone_primary_navigation' );

				/**
				 * Hook: alone_site_branding_extras_navigation.
				 *
				 * @hooked alone_site_branding_extras_navigation_wrapper_start - 10
				 * @hooked alone_site_branding_extras_navigation_search - 20
				 * @hooked alone_site_branding_extras_navigation_wrapper_end - 60
				 */
				do_action( 'alone_site_branding_extras_navigation' );
				?>

			</div>
		</div>
	</div>
</div><!-- .site-branding -->
