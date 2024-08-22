<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

?>

	<footer id="colophon" class="site-footer">

		<?php
			/**
			 * Hook: alone_site_footer_content
			 *
			 * @hooked alone_site_footer_widgets - 10
			 * @hooked alone_site_footer_info - 30
			 */
			do_action( 'alone_site_footer_content' );
		?>

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
