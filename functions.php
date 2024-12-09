<?php
/**
 * Alone functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

/**
 * Alone only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'alone_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function alone_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Alone, use a find and replace
		 * to change 'alone' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'alone', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'alone' ),
				'footer' => __( 'Footer Menu', 'alone' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 74,
				'width'       => 165,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
	  add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'alone' ),
					'shortName' => __( 'S', 'alone' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'alone' ),
					'shortName' => __( 'M', 'alone' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'alone' ),
					'shortName' => __( 'L', 'alone' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'alone' ),
					'shortName' => __( 'XL', 'alone' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => 'default' === alone_get_option('custom_colors') ? __( 'Blue', 'alone' ) : null,
					'slug'  => 'primary',
					'color' => alone_get_main_color(),
				),
				array(
					'name'  => __( 'Dark Gray', 'alone' ),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __( 'Light Gray', 'alone' ),
					'slug'  => 'light-gray',
					'color' => '#333',
				),
				array(
					'name'  => __( 'White', 'alone' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'alone_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alone_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Blog', 'alone' ),
			'id'            => 'blog-sidebar',
			'description'   => __( 'Add widgets here to appear in your blog.', 'alone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Topbar', 'alone' ),
			'id'            => 'topbar-sidebar',
			'description'   => __( 'Add widgets here to appear in your header.', 'alone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'alone' ),
			'id'            => 'footer-sidebar',
			'description'   => __( 'Add widgets here to appear in your footer.', 'alone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'alone_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function alone_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'alone_content_width', 1170 );
}
add_action( 'after_setup_theme', 'alone_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function alone_scripts() {

	wp_enqueue_style( 'alone-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	wp_add_inline_style( 'alone-style', alone_theme_custom_style() );

	wp_style_add_data( 'alone-style', 'rtl', 'replace' );

	wp_enqueue_style( 'alone-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_script( 'alone-priority-menu', get_theme_file_uri( '/js/priority-menu.js' ), array(), wp_get_theme()->get( 'Version' ), true );
	}

	wp_enqueue_script( 'alone-main', get_theme_file_uri( '/js/main.js' ), array('jquery'), wp_get_theme()->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'alone_scripts' );

/**
 * Display custom style in customizer and on frontend.
 */
function alone_theme_custom_style() {
	// Not include custom style in admin.
	if ( is_admin() ) {
		return;
	}

	$theme_styles = '';

	if ( !empty( alone_get_option('custom_logo') ) && 165 !== absint( alone_get_option('logo_width') ) ) {
		// Logo
		$theme_styles .= '.site-logo.image-logo .custom-logo { width: ' . alone_get_option('logo_width') . 'px; }';
	}


	if ( 199 !== absint( alone_get_option('main_color') ) ) {
		// Colors
		require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
		$theme_styles .= alone_custom_colors_css();

	}

	if ( 0 !== absint( alone_get_option('custom_typos') ) ) {
		// Typography
		require_once get_parent_theme_file_path( '/inc/typography.php' );
		$theme_styles .= alone_custom_typos_css();

	}

	// Styling
	require_once get_parent_theme_file_path( '/inc/styling.php' );

	/**
	 * Filters Alone custom theme styles.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_styles
	 */
	return apply_filters( 'alone_custom_theme_styles_css', $theme_styles );
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function alone_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'alone_skip_link_focus_fix' );

/**
 * Enqueue supplemental block editor styles.
 */
function alone_editor_customizer_styles() {

	wp_enqueue_style( 'alone-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '1.1', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'alone_editor_customizer_styles' );

/**
 * Support upload mimes
 */
function alone_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';

  return $mimes;
}
add_filter('upload_mimes', 'alone_mime_types');

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-alone-svg-icons.php';

/**
 * Verify purchase code
 */
require get_template_directory() . '/install/VerifyTheme.php';

if(class_exists('VerifyTheme')){
	function verifytheme_init(){
		$VerifyTheme = new VerifyTheme();
	}
	add_action( 'after_setup_theme', 'verifytheme_init' );
}

/**
 * Theme install
 */
require get_template_directory() . '/install/plugin-required.php';
require  get_template_directory() . '/install/import-pack/import-functions.php';

/**
 * Common theme helper functions.
 */
require get_template_directory() . '/inc/helper-functions.php';

/**
 * Common theme hook functions.
 */
require get_template_directory() . '/inc/hook-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

if ( class_exists( 'WooCommerce' ) ) {
	/**
	 * Woocommerce.
	 */
	require get_template_directory() . '/woocommerce/helper-functions.php';
}

if ( class_exists( 'Give' ) ) {
	/**
	 * Give.
	 */
	require get_template_directory() . '/give/helper-functions.php';
}

if ( class_exists( 'Tribe__Events__Main' ) ) {
	/**
	 * Tribe Events.
	 */
	require get_template_directory() . '/tribe-events/helper-functions.php';
}

if ( defined('SERMONE_VER') ) {
	/**
	 * Sermone.
	 */
	require get_template_directory() . '/sermone/helper-functions.php';
}

/**
 * Affiliate
 */
require get_template_directory() . '/affiliate/affiliate.php';

/**
 * Cron job
 */
require get_template_directory() . '/cron/cron-helper.php';


function alone_load_textdomain() {
	if ( function_exists( 'icl_object_id' ) ) {
		if (ICL_LANGUAGE_CODE == "ar") {
			load_textdomain('give', get_stylesheet_directory() . '/languages/give-ar.mo');
			load_textdomain('alone', get_stylesheet_directory() . '/languages/alone-ar.mo');
		}
	}
	
}
add_action('init', 'alone_load_textdomain');

function alone_fix_for_yoast_breadcrumb_translation( $links ) {
	global $post;

	if ( !$post ) {
		return $links;
	}

	if ( function_exists( 'icl_object_id' ) ) {

		if ( 'en' == ICL_LANGUAGE_CODE ) {
				$breadcrumbhome[] = array(
					'url' => esc_url( get_permalink(3437) ),
					'text' => 'Home',
					'allow_html' => true,
				);
		} elseif( 'ar' == ICL_LANGUAGE_CODE ) {
				$breadcrumbhome[] = array(
					'url' => esc_url( get_permalink(25) ),
					'text' => 'بيت',
					'allow_html' => true,
				);
		}
		array_splice( $links, 0, 1, $breadcrumbhome );
	}
	return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'alone_fix_for_yoast_breadcrumb_translation' );