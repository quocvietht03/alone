<?php
/**
 * Alone: Customizer
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

 class Alone_Customize {
 	/**
 	 * Customize settings
 	 *
 	 * @var array
 	 */
 	protected $config = array();

 	/**
 	 * The class constructor
 	 *
 	 * @param array $config
 	 */
 	public function __construct( $config ) {
 		$this->config = $config;

 		if ( ! class_exists( 'Kirki' ) ) {
 			return;
 		}

 		$this->register();
 	}

 	/**
 	 * Register settings
 	 */
 	public function register() {

 		/**
 		 * Add the theme configuration
 		 */
 		if ( ! empty( $this->config['theme'] ) ) {
 			Kirki::add_config(
 				$this->config['theme'], array(
 					'capability'  => 'edit_theme_options',
 					'option_type' => 'theme_mod',
 				)
 			);
 		}

 		/**
 		 * Add panels
 		 */
 		if ( ! empty( $this->config['panels'] ) ) {
 			foreach ( $this->config['panels'] as $panel => $settings ) {
 				Kirki::add_panel( $panel, $settings );
 			}
 		}

 		/**
 		 * Add sections
 		 */
 		if ( ! empty( $this->config['sections'] ) ) {
 			foreach ( $this->config['sections'] as $section => $settings ) {
 				Kirki::add_section( $section, $settings );
 			}
 		}

 		/**
 		 * Add fields
 		 */
 		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
 			foreach ( $this->config['fields'] as $name => $settings ) {
 				if ( ! isset( $settings['settings'] ) ) {
 					$settings['settings'] = $name;
 				}

 				Kirki::add_field( $this->config['theme'], $settings );
 			}
 		}
 	}

 	/**
 	 * Get config ID
 	 *
 	 * @return string
 	 */
 	public function get_theme() {
 		return $this->config['theme'];
 	}

 	/**
 	 * Get customize setting value
 	 *
 	 * @param string $name
 	 *
 	 * @return bool|string
 	 */
 	public function get_option( $name ) {

 		$default = $this->get_option_default( $name );

 		return get_theme_mod( $name, $default );
 	}

 	/**
 	 * Get default option values
 	 *
 	 * @param $name
 	 *
 	 * @return mixed
 	 */
 	public function get_option_default( $name ) {
 		if ( ! isset( $this->config['fields'][ $name ] ) ) {
 			return false;
 		}

 		return isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;
 	}
 }

 /**
  * This is a short hand function for getting setting value from customizer
  *
  * @param string $name
  *
  * @return bool|string
  */
 function alone_get_option( $name ) {
 	global $alone_customize;

 	$value = false;

 	if ( class_exists( 'Kirki' ) ) {
 		$value = Kirki::get_option( 'alone', $name );
 	} elseif ( ! empty( $alone_customize ) ) {
 		$value = $alone_customize->get_option( $name );
 	}

 	return apply_filters( 'alone_get_option', $value, $name );
 }

 /**
  * Get page
  *
  * @return array
  */
 function alone_customizer_get_pages( $default = false ) {
  	if ( ! is_admin() ) {
  		return;
  	}

  	$output = array();

  	if ( $default ) {
  		$output[0] = esc_html__( 'Select Page', 'alone' );
  	}

  	$pages = get_pages();

  	if ( is_array( $pages ) && ! empty( $pages ) ) {
  		foreach ( $pages as $page ) {
  			$output[ $page->ID ] = $page->post_title;
  		}
  	}


  	return $output;
 }

 /**
  * Get post
  *
  * @return array
  */
 function alone_customizer_get_posts( $post_type, $default = false ) {
  	if ( ! is_admin() ) {
  		return;
  	}

  	$output = array();

  	if ( $default ) {
  		$output[0] = esc_html__( 'Select Post', 'alone' );
  	}

  	$posts = get_posts(array(
      'post_type' => $post_type
    ));

  	if ( is_array( $posts ) && ! empty( $posts ) ) {
  		foreach ( $posts as $post ) {
  			$output[ $post->ID ] = $post->post_title;
  		}
  	}


  	return $output;
 }

 /**
  * Get category
  *
  * @return array
  */
 function alone_customizer_get_categories( $taxonomies, $default = false ) {
 	if ( ! taxonomy_exists( $taxonomies ) ) {
 		return;
 	}

 	if ( ! is_admin() ) {
 		return;
 	}

 	$output = array();

 	if ( $default ) {
 		$output[0] = esc_html__( 'Select Category', 'alone' );
 	}

 	global $wpdb;
 	$post_meta_infos = $wpdb->get_results(
 		$wpdb->prepare(
 			"SELECT a.term_id AS id, b.name as name, b.slug AS slug
 						FROM {$wpdb->term_taxonomy} AS a
 						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
 						WHERE a.taxonomy = '%s'", $taxonomies
 		), ARRAY_A
 	);

 	if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
 		foreach ( $post_meta_infos as $value ) {
 			$output[ $value['slug'] ] = $value['name'];
 		}
 	}


 	return $output;
 }

 /**
  * Move some default sections to `general` panel that registered by theme
  *
  * @param object $wp_customize
  */
 function alone_customize_modify( $wp_customize ) {
 	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
 	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
 }

 add_action( 'customize_register', 'alone_customize_modify' );


 /**
  * Enqueue script for custom customize control.
  */
 function alone_customize_controls_enqueue_scripts( $wp_customize ) {
   wp_enqueue_style( 'alone-customize', get_template_directory_uri() . '/css/customize.css', array(), wp_get_theme()->get( 'Version' ) );

 }
 add_action('customize_controls_enqueue_scripts', 'alone_customize_controls_enqueue_scripts');


 /**
  * Get customize settings
  *
  * @return array
  */
 function alone_customize_settings() {
 	/**
 	 * Customizer configuration
 	 */

 	$settings = array(
 		'theme' => 'alone',
 	);

 	$panels = array(
 		'general'      => array(
 			'priority' => 10,
 			'title'    => esc_html__( 'General', 'alone' ),
 		),

 		'styling'      => array(
 			'title'    => esc_html__( 'Styling', 'alone' ),
 			'priority' => 20,
 		),

    'posts'      => array(
 			'title'    => esc_html__( 'Posts', 'alone' ),
 			'priority' => 160,
 		),

 	);

 	$sections = array(
		'site_titlebar'                => array(
			'title'       => esc_html__( 'Site Titlebar', 'alone' ),
			'description' => '',
			'priority'    => 20,
			'capability'  => 'edit_theme_options',
			'panel'       => 'general',
		),

    	'copyright'                => array(
 			'title'       => esc_html__( 'Site Copyright', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
 			'panel'       => 'general',
 		),

    	'socials_share'                => array(
 			'title'       => esc_html__( 'Socials Share', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
 			'panel'       => 'general',
 		),

    	'colors'                => array(
 			'title'       => esc_html__( 'Colors', 'alone' ),
 			'description' => '',
 			'priority'    => 10,
 			'capability'  => 'edit_theme_options',
 			'panel'       => 'styling',
 		),

		'typography'          => array(
 			'title'       => esc_html__( 'Typography', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
			'panel'       => 'styling',
 		),

    	'page_titlebar'          => array(
 			'title'       => esc_html__( 'Page Titlebar', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
			'panel'       => 'styling',
 		),

    	'blog_pages'          => array(
 			'title'       => esc_html__( 'Blog Pages', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
			'panel'       => 'posts',
 		),

    	'single_post'          => array(
 			'title'       => esc_html__( 'Single Post', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
			'panel'       => 'posts',
 		),

    	'single_team'          => array(
 			'title'       => esc_html__( 'Single Team', 'alone' ),
 			'description' => '',
 			'priority'    => 20,
 			'capability'  => 'edit_theme_options',
			'panel'       => 'posts',
 		),

 	);

 	$fields = array(

    // Site logo
    'logo_width' => array(
      'type'        => 'slider',
    	'label'       => esc_html__( 'Logo Width', 'alone' ),
    	'section'     => 'title_tagline',
      'priority'    => 10,
    	'default'     => 165,
    	'choices'     => array(
    		'min'  => 50,
    		'max'  => 300,
    		'step' => 1,
    	),
      'active_callback' => array(
 				array(
 					'setting'  => 'custom_logo',
 					'operator' => '!=',
 					'value'    => '',
 				),
 			),
    ),

	// Site Titlebar
	'site_titlebar' => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Site TitleBar', 'alone' ),
		'section'     => 'site_titlebar',
		'default'     => 1,
		'priority'    => 20,
		'description' => esc_html__( 'Check this to enable titlebar in the site.', 'alone' ),
	),

    // Copyright
    'custom_site_copyright' => array(
      'type'        => 'toggle',
      'label'       => esc_html__( 'Custom site copyright', 'alone' ),
      'section'     => 'copyright',
      'default'     => 0,
      'priority'    => 20,
      'description' => esc_html__( 'Check this to custom copyright in the site footer.', 'alone' ),
    ),
    'copyright_text' => array(
      'type'            => 'textarea',
      'label'           => esc_html__( 'Copyright text', 'alone' ),
      'section'         => 'copyright',
      'default'         => esc_html__( 'Proudly powered by Bearsthemes', 'alone' ),
      'priority'        => 20,
      'active_callback' => array(
        array(
          'setting'  => 'custom_site_copyright',
          'operator' => '==',
          'value'    => 1,
        ),
      ),
    ),

    // Socials share
    'show_socials_share' => array(
      'type'        => 'toggle',
      'label'       => esc_html__( 'Show socials', 'alone' ),
      'section'     => 'socials_share',
      'default'     => 1,
      'priority'    => 20,
      'description' => esc_html__( 'Check this to show socials share in the site.', 'alone' ),
    ),
    'socials_share_sort' => array(
      'type'            => 'sortable',
      'label'           => esc_html__( 'Socials Sort', 'alone' ),
      'section'         => 'socials_share',
      'default'     => array(
    		'facebook',
    		'twitter',
    		'pinterest',
        'mail',
    	),
    	'choices'     => array(
    		'facebook'  => esc_html__( 'Facebook', 'alone' ),
    		'twitter'   => esc_html__( 'Twitter', 'alone' ),
    		'pinterest' => esc_html__( 'Pinterest', 'alone' ),
    		'linkedin'  => esc_html__( 'Linkedin', 'alone' ),
    		'google'    => esc_html__( 'Google', 'alone' ),
    		'mail'      => esc_html__( 'Mail', 'alone' ),
    	),
      'priority'        => 20,
      'active_callback' => array(
        array(
          'setting'  => 'show_socials_share',
          'operator' => '==',
          'value'    => 1,
        ),
      ),
    ),

	// Colors
	'custom_colors' => array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Custom Colors', 'alone' ),
		'default'     => 'default',
		'section'     => 'colors',
		'priority'    => 10,
		'choices'     => array(
			'default' => esc_html__( 'Default', 'alone' ),
			'custom'  => esc_html__( 'Custom', 'alone' ),
		),
	),
	'main_color' => array(
		'type'            => 'color',
		'description' 		=> __( 'Apply a custom color for buttons, links, etc.', 'alone' ),
		'default'         => 199,
		'mode'        		=> 'hue',
		'section'         => 'colors',
		'priority'        => 10,
		'active_callback' => array(
			array(
				'setting'  => 'custom_colors',
				'operator' => '==',
				'value'    => 'default',
			),
		),
	),
	'custom_color' => array(
		'type'            => 'color',
		'description' 		=> __( 'Apply a custom color for buttons, links, featured images, etc.', 'alone' ),
		'default'         => '#0073a8',
		'section'         => 'colors',
		'priority'        => 10,
		'choices'     => [
			'alpha' => true,
		],
		'active_callback' => array(
			array(
				'setting'  => 'custom_colors',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	),

	// Typography
	'custom_typos' => array(
		'type'     => 'toggle',
		'label'    => esc_html__( 'Custom Typography', 'alone' ),
		'default'  => 0,
		'section'  => 'typography',
		'priority' => 10,
	),

	'body_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Body', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'regular',
			'font-size'      => '16px',
			'line-height'    => '1.75',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#333',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'pre_heading_typo' => array(
		'type'        => 'custom',
		'section'     => 'typography',
		'default'         => '<hr style="margin:15px 0;"></hr>',
		'priority'    => 10,
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'heading1_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Heading 1', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'bold',
			'font-size'      => '42px',
			'line-height'    => '1.25',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'heading2_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Heading 2', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'bold',
			'font-size'      => '32px',
			'line-height'    => '1.25',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'heading3_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Heading 3', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'bold',
			'font-size'      => '24px',
			'line-height'    => '1.25',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'heading4_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Heading 4', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'bold',
			'font-size'      => '18px',
			'line-height'    => '1.25',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'heading5_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Heading 5', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'bld',
			'font-size'      => '14px',
			'line-height'    => '1.25',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'heading6_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Heading 6', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'bold',
			'font-size'      => '12px',
			'line-height'    => '1.25',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'pre_menu_typo'  => array(
		'type'        => 'custom',
		'section'     => 'typography',
		'default'         => '<hr style="margin:15px 0;"></hr>',
		'priority'    => 10,
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'menu_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Menu', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '15px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

	'sub_menu_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Sub Menu', 'alone' ),
		'section'  => 'typography',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'regular',
			'font-size'      => '15px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#111',
			'text-transform' => 'none',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_typos',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

    // Page Titlebar
	'custom_page_titlebar' => array(
		'type'     => 'toggle',
		'label'    => esc_html__( 'Custom Style', 'alone' ),
		'default'  => 0,
		'section'  => 'page_titlebar',
		'priority' => 10,
	),

    'page_title_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Page Title', 'alone' ),
		'section'  => 'page_titlebar',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '700',
			'font-size'      => '30px',
			'line-height'    => '1.25',
        	'letter-spacing' => '0',
 				'subsets'        => array( 'latin-ext' ),
 				'color'          => '#002866',
 				'text-transform' => 'uppercase',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_page_titlebar',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

    'page_breadcrumb_typo' => array(
		'type'     => 'typography',
		'label'    => esc_html__( 'Breadcrumb', 'alone' ),
		'section'  => 'page_titlebar',
		'priority' => 10,
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '14px',
			'line-height'    => '1.5',
        	'letter-spacing' => '0',
 				'subsets'        => array( 'latin-ext' ),
 				'color'          => '#002866',
 				'text-transform' => 'uppercase',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_page_titlebar',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

    'page_breadcrumb_bg_color' => array(
 			'type'     => 'color',
 			'label'    => esc_html__( 'Breadcrumb BG Color', 'alone' ),
 			'section'  => 'page_titlebar',
 			'priority' => 10,
 			'default'  => '#FFEE00',
			'active_callback' => array(
 				array(
 					'setting'  => 'custom_page_titlebar',
 					'operator' => '==',
 					'value'    => 1,
 				),
 			),
 		),

    'page_titlebar_bg_color' => array(
 			'type'     => 'color',
 			'label'    => esc_html__( 'Titlebar BG Color', 'alone' ),
 			'section'  => 'page_titlebar',
 			'priority' => 10,
 			'default'  => '#f0f0f1',
			'active_callback' => array(
 				array(
 					'setting'  => 'custom_page_titlebar',
 					'operator' => '==',
 					'value'    => 1,
 				),
 			),
 		),

    'page_titlebar_bg_image' => array(
 			'type'     => 'image',
 			'label'    => esc_html__( 'Titlebar BG Image', 'alone' ),
 			'section'  => 'page_titlebar',
 			'priority' => 10,
 			'default'  => '',
			'active_callback' => array(
 				array(
 					'setting'  => 'custom_page_titlebar',
 					'operator' => '==',
 					'value'    => 1,
 				),
 			),
 		),

    'page_titlebar_spacing' => array(
		'type'     => 'dimensions',
		'label'    => esc_html__( 'Titlebar Spacing', 'alone' ),
		'section'  => 'page_titlebar',
		'priority' => 10,
		'default'  => array(
			'top'  => '75px',
			'bottom' => '75px',
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_page_titlebar',
				'operator' => '==',
				'value'    => 1,
			),
		),
	),

    // Blog pages
    'blog_pages_layout' => array(
		'type'        => 'radio',
		'label'       => esc_html__( 'Layout', 'alone' ),
		'section'     => 'blog_pages',
		'default'     => 'content-sidebar',
		'priority'    => 20,
		'choices'     => array(
			'full-content'    => esc_html__( 'Full Content', 'alone' ),
			'content-sidebar' => esc_html__( 'Content - Sidebar', 'alone' ),
			'sidebar-content' => esc_html__( 'Sidebar - Content', 'alone' ),
		),
    ),

	'blog_pagination_type' => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Pagination Type', 'alone' ),
		'section'     => 'blog_pages',
		'default'     => 'pagination',
		'priority'    => 20,
		'choices'     => array(
			'pagination'    => esc_html__( 'Pagination', 'alone' ),
			'loadmore-button' 		=> esc_html__( 'Load More Button', 'alone' ),
			'loadmore-scroll' 		=> esc_html__( 'Load More Scroll', 'alone' ),
		),
	),

    // Single post
    'show_author_bio' => array(
      'type'        => 'toggle',
      'label'       => esc_html__( 'Show Author Bio', 'alone' ),
      'section'     => 'single_post',
      'default'     => 1,
      'priority'    => 20,
      'description' => esc_html__( 'Check this to show author bio in single post.', 'alone' ),
    ),

    'pre_related_posts'  => array(
		'type'        => 'custom',
		'section'     => 'single_post',
	    'default'     => '<hr style="margin:15px 0;"></hr>',
		'priority'    => 20,
	),

    'show_related_posts' => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show related posts', 'alone' ),
		'section'     => 'single_post',
		'default'     => 1,
		'priority'    => 20,
		'description' => esc_html__( 'Check this to show related post in single post.', 'alone' ),
    ),

    'related_posts_heading' => array(
		'type'        => 'text',
		'label'       => esc_html__( 'Related posts heading', 'alone' ),
		'section'     => 'single_post',
		'default'     => esc_html__( 'Related Posts', 'alone' ),
		'priority'    => 20,
		'active_callback' => array(
			array(
				'setting'  => 'show_related_posts',
				'operator' => '==',
				'value'    => 1,
			),
		),
    ),

    'related_posts_number' => array(
      'type'        => 'text',
      'label'       => esc_html__( 'Related posts number', 'alone' ),
      'section'     => 'single_post',
      'default'     => 3,
      'priority'    => 20,
      'active_callback' => array(
        array(
          'setting'  => 'show_related_posts',
          'operator' => '==',
          'value'    => 1,
        ),
      ),
    ),

    // Single team
    'show_related_members' => array(
      'type'        => 'toggle',
      'label'       => esc_html__( 'Show related members', 'alone' ),
      'section'     => 'single_team',
      'default'     => 1,
      'priority'    => 20,
      'description' => esc_html__( 'Check this to show related members in single team.', 'alone' ),
    ),

    'related_members_number' => array(
      'type'        => 'text',
      'label'       => esc_html__( 'Related members number', 'alone' ),
      'section'     => 'single_team',
      'default'     => 4,
      'priority'    => 20,
      'active_callback' => array(
        array(
          'setting'  => 'show_related_members',
          'operator' => '==',
          'value'    => 1,
        ),
      ),
    ),

 	);

  // WooCommerce
  $sections = array_merge( $sections,
    array(
      'shop_badge' => array(
   			'title'       => esc_html__( 'Shop Badge', 'alone' ),
   			'description' => '',
   			'priority'    => 20,
   			'capability'  => 'edit_theme_options',
  			'panel'       => 'woocommerce',
   		),

      'shop_mini_cart' => array(
   			'title'       => esc_html__( 'Shop Mini Cart', 'alone' ),
   			'description' => '',
   			'priority'    => 20,
   			'capability'  => 'edit_theme_options',
  			'panel'       => 'woocommerce',
   		),

    )
  );

  $fields = array_merge( $fields,
    array(
      // Product catalog
      'product_catalog_layout' => array(
        'type'        => 'radio',
        'label'       => esc_html__( 'Shop layout', 'alone' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 'content-sidebar',
        'priority'    => 5,
        'description' => esc_html__( 'Choose layout to display on the main shop page.', 'alone' ),
        'choices'     => array(
          'full-content'    => esc_html__( 'Full Content', 'alone' ),
      		'content-sidebar' => esc_html__( 'Content - Sidebar', 'alone' ),
      		'sidebar-content' => esc_html__( 'Sidebar - Content', 'alone' ),
        ),
      ),

      'product_catalog_toolbar' => array(
        'type'        => 'toggle',
        'label'       => esc_html__( 'Shop Toolbar', 'alone' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 1,
        'priority'    => 5,
        'description' => esc_html__( 'Check this to show toolbar in the catalog page.', 'alone' ),
      ),

      // Badge
      'show_badges' => array(
        'type'        => 'toggle',
        'label'       => esc_html__( 'Shop Badges', 'alone' ),
        'section'     => 'shop_badge',
        'default'     => 1,
        'priority'    => 20,
        'description' => esc_html__( 'Check this to show badges in the catalog page.', 'alone' ),
      ),

      'badges' => array(
        'type'        => 'multicheck',
        'label'       => esc_html__( 'Badges', 'alone' ),
        'section'     => 'shop_badge',
        'default'     => array( 'hot', 'new', 'sale', 'outofstock' ),
        'priority'    => 20,
        'choices'     => array(
          'hot'        => esc_html__( 'Hot', 'alone' ),
          'new'        => esc_html__( 'New', 'alone' ),
          'sale'       => esc_html__( 'Sale', 'alone' ),
          'outofstock' => esc_html__( 'Out Of Stock', 'alone' ),
        ),
        'description' => esc_html__( 'Select which badges you want to show', 'alone' ),
      ),

      'hot_text' => array(
        'type'            => 'text',
        'label'           => esc_html__( 'Custom Hot Text', 'alone' ),
        'section'         => 'shop_badge',
        'default'         => 'Hot',
        'priority'        => 20,
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'hot',
          ),
        ),
      ),

      'hot_color' => array(
        'type'            => 'color',
        'label'           => esc_html__( 'Custom Hot Color', 'alone' ),
        'default'         => '',
        'section'         => 'shop_badge',
        'priority'        => 20,
        'choices'         => array(
          'alpha' => true,
        ),
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'hot',
          ),
        ),
      ),

      'hot_color_custom' => array(
        'type'     => 'custom',
        'section'  => 'shop_badge',
        'default'  => '<hr>',
        'priority' => 20,
      ),

      'outofstock_text' => array(
        'type'            => 'text',
        'label'           => esc_html__( 'Custom Out Of Stock Text', 'alone' ),
        'section'         => 'shop_badge',
        'default'         => 'Out Of Stock',
        'priority'        => 20,
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'outofstock',
          ),
        ),
      ),

      'outofstock_color' => array(
        'type'            => 'color',
        'label'           => esc_html__( 'Custom Out Of Stock Color', 'alone' ),
        'default'         => '',
        'section'         => 'shop_badge',
        'priority'        => 20,
        'choices'         => array(
          'alpha' => true,
        ),
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'outofstock',
          ),
        ),
      ),

      'outofstock_color_custom' => array(
        'type'     => 'custom',
        'section'  => 'shop_badge',
        'default'  => '<hr>',
        'priority' => 20,
      ),

      'new_text' => array(
        'type'            => 'text',
        'label'           => esc_html__( 'Custom New Text', 'alone' ),
        'section'         => 'shop_badge',
        'default'         => 'New',
        'priority'        => 20,
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'new',
          ),
        ),
      ),

      'new_color' => array(
        'type'            => 'color',
        'label'           => esc_html__( 'Custom New Color', 'alone' ),
        'default'         => '',
        'section'         => 'shop_badge',
        'priority'        => 20,
        'choices'         => array(
          'alpha' => true,
        ),
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'new',
          ),
        ),
      ),

      'new_color_custom' => array(
        'type'     => 'custom',
        'section'  => 'shop_badge',
        'default'  => '<hr>',
        'priority' => 20,
      ),

      'sale_type' => array(
        'type'            => 'select',
        'label'           => esc_html__( 'Sale Type', 'alone' ),
        'default'         => '1',
        'section'         => 'shop_badge',
        'priority'        => 20,
        'choices'         => array(
          '1' => esc_html__( 'Percent', 'alone' ),
          '2' => esc_html__( 'Save', 'alone' ),
        ),
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'sale',
          ),
        ),
      ),

      'sale_color' => array(
        'type'            => 'color',
        'label'           => esc_html__( 'Custom Sale Color', 'alone' ),
        'default'         => '',
        'section'         => 'shop_badge',
        'priority'        => 20,
        'choices'         => array(
          'alpha' => true,
        ),
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'sale',
          ),
        ),
      ),

      'sale_save_text' => array(
        'type'            => 'text',
        'label'           => esc_html__( 'Custom Save Text', 'alone' ),
        'section'         => 'shop_badge',
        'default'         => esc_html__( 'Save', 'alone' ),
        'priority'        => 20,
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'new',
          ),
          array(
            'setting'  => 'sale_type',
            'operator' => '==',
            'value'    => '2',
          ),
        ),
      ),

      'sale_color_custom' => array(
        'type'     => 'custom',
        'section'  => 'shop_badge',
        'default'  => '<hr>',
        'priority' => 20,
      ),

      'product_newness' => array(
        'type'            => 'number',
        'label'           => esc_html__( 'Product Newness', 'alone' ),
        'section'         => 'shop_badge',
        'default'         => 3,
        'priority'        => 20,
        'description'     => esc_html__( 'Display the "New" badge for how many days?', 'alone' ),
        'active_callback' => array(
          array(
            'setting'  => 'badges',
            'operator' => 'contains',
            'value'    => 'new',
          ),
        ),
      ),

      // Mini Cart
      'show_mini_cart' => array(
        'type'        => 'toggle',
        'label'       => esc_html__( 'Shop Mini Cart', 'alone' ),
        'section'     => 'shop_mini_cart',
        'default'     => 1,
        'priority'    => 20,
        'description' => esc_html__( 'Check this to show mini cart in the site header.', 'alone' ),
      ),

    )
  );

  // GiveWP
  $panels = array_merge( $panels,
    array(
   		'give_donation' => array(
   			'priority' => 160,
   			'title'    => esc_html__( 'Give Donation', 'alone' ),
   		),

   	)
  );

  $sections = array_merge( $sections,
    array(
      'give_mini_donation' => array(
   			'title'       => esc_html__( 'Mini Donation', 'alone' ),
   			'description' => '',
   			'priority'    => 20,
   			'capability'  => 'edit_theme_options',
  			'panel'       => 'give_donation',
   		),

      'give_goal_progress' => array(
   			'title'       => esc_html__( 'Goal Progress', 'alone' ),
   			'description' => '',
   			'priority'    => 20,
   			'capability'  => 'edit_theme_options',
  			'panel'       => 'give_donation',
   		),

      'give_archive_pages' => array(
   			'title'       => esc_html__( 'Archive Pages', 'alone' ),
   			'description' => '',
   			'priority'    => 20,
   			'capability'  => 'edit_theme_options',
  			'panel'       => 'give_donation',
   		),

      'give_single_post' => array(
   			'title'       => esc_html__( 'Single Post', 'alone' ),
   			'description' => '',
   			'priority'    => 20,
   			'capability'  => 'edit_theme_options',
  			'panel'       => 'give_donation',
   		),
    )
  );

  $fields = array_merge( $fields,
    array(
      // Mini donation
      'show_mini_donation' => array(
        'type'        => 'toggle',
        'label'       => esc_html__( 'Show Mini Donation', 'alone' ),
        'section'     => 'give_mini_donation',
        'default'     => 1,
        'priority'    => 20,
        'description' => esc_html__( 'Check this to show mini donation in the site header.', 'alone' ),
      ),

      'give_form_id' => array(
        'type'            => 'select',
        'label'           => esc_html__( 'Give Form', 'alone' ),
        'section'         => 'give_mini_donation',
        'default'         => 0,
        'priority'        => 20,
        'choices'         => alone_customizer_get_posts( 'give_forms', true ),
        'active_callback' => array(
          array(
   					'setting'  => 'show_mini_donation',
   					'operator' => '==',
   					'value'    => 1,
   				),
        ),
      ),

      'custom_goal_progress' => array(
        'type'        => 'toggle',
        'label'       => esc_html__( 'Custom Goal Progress', 'alone' ),
        'section'     => 'give_goal_progress',
        'default'     => 1,
        'priority'    => 20,
        'description' => esc_html__( 'Check this to custom goal progress in give forms.', 'alone' ),
      ),

      'goal_progress_easing' => array(
        'type'        => 'select',
        'label'       => esc_html__( 'Easing', 'alone' ),
        'section'     => 'give_goal_progress',
        'default'     => 'linear',
        'choices'     => array(
          'linear' => esc_html__( 'Linear', 'alone' ),
          'easeOut' => esc_html__( 'EaseOut', 'alone' ),
          'bounce' => esc_html__( 'Bounce', 'alone' ),
        ),
        'priority'    => 20,
        'active_callback' => array(
          array(
   					'setting'  => 'custom_goal_progress',
   					'operator' => '==',
   					'value'    => 1,
   				),
        ),
      ),

      'goal_progress_duration' => array(
        'type'        => 'slider',
        'label'       => esc_html__( 'Duration', 'alone' ),
        'section'     => 'give_goal_progress',
        'default'     => 800,
        'choices'     => array(
          'min'  => 0,
      		'max'  => 2000,
      		'step' => 10,
        ),
        'priority'    => 20,
        'active_callback' => array(
          array(
   					'setting'  => 'custom_goal_progress',
   					'operator' => '==',
   					'value'    => 1,
   				),
        ),
      ),

      'goal_progress_color' => array(
        'type'        => 'multicolor',
        'label'       => esc_html__( 'Duration', 'alone' ),
        'section'     => 'give_goal_progress',
        'default'     => array(
          'from'    => '#FFEA82',
          'to'   => '#ED6A5A',
        ),
        'choices'     => array(
          'from'    => esc_html__( 'from Color', 'alone' ),
          'to'   => esc_html__( 'to Color', 'alone' ),
        ),
        'priority'    => 20,
        'active_callback' => array(
          array(
   					'setting'  => 'custom_goal_progress',
   					'operator' => '==',
   					'value'    => 1,
   				),
        ),
      ),

      'goal_progress_trailcolor' => array(
        'type'        => 'color',
        'label'       => esc_html__( 'Trail Color', 'alone' ),
        'section'     => 'give_goal_progress',
        'default'     => '#EEEEEE',
        'priority'    => 20,
        'active_callback' => array(
          array(
   					'setting'  => 'custom_goal_progress',
   					'operator' => '==',
   					'value'    => 1,
   				),
        ),
      ),

      // Archive
      'give_pages_layout' => array(
        'type'        => 'radio',
        'label'       => esc_html__( 'Layout', 'alone' ),
        'section'     => 'give_archive_pages',
        'default'     => 'content-sidebar',
        'priority'    => 20,
        'choices'     => array(
          'full-content'    => esc_html__( 'Full Content', 'alone' ),
      		'content-sidebar' => esc_html__( 'Content - Sidebar', 'alone' ),
      		'sidebar-content' => esc_html__( 'Sidebar - Content', 'alone' ),
        ),
      ),

	  'give_pagination_type' => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Pagination Type', 'alone' ),
		'section'     => 'give_archive_pages',
		'default'     => 'pagination',
		'priority'    => 20,
		'choices'     => array(
		  	'pagination'    => esc_html__( 'Pagination', 'alone' ),
			'loadmore-button' 		=> esc_html__( 'Load More Button', 'alone' ),
			'loadmore-scroll' 		=> esc_html__( 'Load More Scroll', 'alone' ),
		),
	  ),

      'give_change_posts_per_page' => array(
        'type'        => 'toggle',
        'label'       => esc_html__( 'Change posts per page', 'alone' ),
        'section'     => 'give_archive_pages',
        'default'     => 0,
        'priority'    => 20,
        'description' => esc_html__( 'Check this to change posts per page in archive pages.', 'alone' ),
      ),

      'give_posts_per_page' => array(
        'type'        => 'text',
        'label'       => esc_html__( 'Posts per page', 'alone' ),
        'section'     => 'give_archive_pages',
        'default'     => 10,
        'priority'    => 20,
        'active_callback' => array(
          array(
   					'setting'  => 'give_change_posts_per_page',
   					'operator' => '==',
   					'value'    => 1,
   				),
        ),
      ),

      // Single
      'give_form_style' => array(
        'type'        => 'select',
        'label'       => esc_html__( 'Style', 'alone' ),
        'section'     => 'give_single_post',
        'default'     => '',
        'priority'    => 20,
        'choices'     => array(
          '' => esc_html__( 'Default', 'alone' ),
          '1' => esc_html__( 'Custom style 1', 'alone' ),
          '2' => esc_html__( 'Custom style 2', 'alone' ),
          '3' => esc_html__( 'Custom style 3', 'alone' ),
          '4' => esc_html__( 'Custom style 4', 'alone' ),
          '5' => esc_html__( 'Custom style 5', 'alone' ),
        ),
      ),


    )
  );

 	$settings['panels']   = apply_filters( 'alone_customize_panels', $panels );
 	$settings['sections'] = apply_filters( 'alone_customize_sections', $sections );
 	$settings['fields']   = apply_filters( 'alone_customize_fields', $fields );

 	return $settings;
 }

 $alone_customize = new Alone_Customize( alone_customize_settings() );
