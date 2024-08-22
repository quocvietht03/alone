<?php
/**
 * Common theme hook functions
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 1.5
 */

/**********************************
* Header
**********************************/

/**
 * Hook: alone_site_header_content
 *
 * @hooked alone_topbar_widgets - 10
 * @hooked alone_site_branding - 30
 */
add_action('alone_site_header_content', 'alone_topbar_widgets', 10);
add_action('alone_site_header_content', 'alone_site_branding', 30);

function alone_topbar_widgets() {
  /**
   * Topbar widgets
   */
  get_template_part( 'template-parts/header/topbar', 'widgets' );
}

function alone_site_branding() {
  /**
   * Site branding
   */
  get_template_part( 'template-parts/header/site', 'branding' );
}

/**
 * Hook: alone_site_logo_image
 *
 * @hooked alone_site_branding_logo_image - 10
 */
add_action('alone_site_logo_image', 'alone_site_branding_logo_image', 10);

function alone_site_branding_logo_image() {
/**
 * Site logo image
 */
 ?>
    <div class="site-logo image-logo"><?php the_custom_logo(); ?></div>
 <?php
}

/**
 * Hook: alone_site_logo_text
 *
 * @hooked alone_site_branding_logo_text - 10
 */
add_action('alone_site_logo_text', 'alone_site_branding_logo_text', 10);

function alone_site_branding_logo_text() {
/**
 * Site logo text
 */
 ?>
   <div class="site-logo text-logo">
     <?php if ( is_front_page() ) : ?>
       <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
     <?php else : ?>
       <h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
     <?php endif; ?>

     <?php
     $description = get_bloginfo( 'description', 'display' );
     if ( $description || is_customize_preview() ) :
       ?>
         <div class="site-description">
           <?php echo $description; ?>
         </div>
     <?php endif; ?>
   </div>
 <?php
}

/**
 * Hook: alone_primary_navigation
 *
 * @hooked alone_site_branding_primary_navigation - 10
 */
add_action('alone_primary_navigation', 'alone_site_branding_primary_navigation', 10);

function alone_site_branding_primary_navigation() {
 /**
  * Primary navigation
  */
  if ( has_nav_menu( 'primary' ) ) :

    if( function_exists( 'ubermenu' ) ) {
      ubermenu( 'main', array( 'theme_location' => 'primary') );
    } else {
      ?>
        <button class="menu-toggle" aria-expanded="false" aria-pressed="false" id="mobile-nav-primary"><?php esc_html_e( 'Menu', 'alone' ); ?></button>

        <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'alone' ); ?>">
          <?php
            wp_nav_menu(
              array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'link_before'		 => '<span>',
                'link_after'		 => '</span>'
              )
            );
          ?>
        </nav><!-- #site-navigation -->
      <?php
    }
  endif;
}

/**
 * Hook: alone_site_branding_extras_navigation
 *
 * @hooked alone_site_branding_extras_navigation_wrapper_start - 10
 * @hooked alone_site_branding_extras_navigation_search - 20
 * @hooked alone_site_branding_extras_navigation_wrapper_end - 60
 */
add_action('alone_site_branding_extras_navigation', 'alone_site_branding_extras_navigation_wrapper_start', 10);
add_action('alone_site_branding_extras_navigation', 'alone_site_branding_extras_navigation_search', 20);
//add_action('alone_site_branding_extras_navigation', 'alone_site_branding_extras_navigation_user', 30);
add_action('alone_site_branding_extras_navigation', 'alone_site_branding_extras_navigation_wrapper_end', 60);

function alone_site_branding_extras_navigation_wrapper_start() {
  /**
   * Extras navigation wrapper start
   */
  ?>
    <div id="site-extras-navigation" class="extras-navigation">
  <?php
}

function alone_site_branding_extras_navigation_search() {
  /**
   * Extras navigation search item
   */
  ?>
    <div class="extra-item toggle-item mini-search">
      <a class="toggle-icon" href="#">
        <?php echo alone_get_icon_svg( 'search', 16 ); ?>
      </a>
      <div class="toggle-content">
        <div class="content-wrap">
          <?php echo get_search_form(false); ?>
        </div>
      </div>
    </div>
  <?php
}

function alone_site_branding_extras_navigation_user() {
  /**
   * Extras navigation user item
   */
  ?>
    <div class="extra-item mini-user">
      <?php
      if( is_user_logged_in() ) {
        echo '<a class="toggle-icon" href="' . get_edit_profile_url() . '" title="' . esc_attr__( 'Edit Profile', 'alone' ) . '">' . alone_get_icon_svg( 'user', 16 ) . '</a>';
      } else {
        echo '<a class="toggle-icon" href="' . wp_login_url() . '" title="' . esc_attr__( 'Login', 'alone' ) . '">' . alone_get_icon_svg( 'user', 16 ) . '</a>';
      }
      ?>
    </div>
  <?php
}

function alone_site_branding_extras_navigation_wrapper_end() {
  /**
   * Extras navigation wrapper end
   */
  ?>
    </div>
  <?php
}

/**********************************
* Page titlebar
**********************************/
/**
 * Hook: alone_page_titlebar_main
 *
 * @hooked alone_page_titlebar_main_template - 10
 */
add_action('alone_page_titlebar_main', 'alone_page_titlebar_main_template', 10);

function alone_page_titlebar_main_template() {
  /**
   * Page titlebar main template
   */
  get_template_part( 'template-parts/page-titlebar/page-titlebar', 'main' );
}

/**
 * Hook: alone_page_titlebar_page
 *
 * @hooked alone_page_titlebar_page_template - 10
 */
add_action('alone_page_titlebar_page', 'alone_page_titlebar_page_template', 10);

function alone_page_titlebar_page_template() {
 /**
  * Page titlebar page template
  */
 get_template_part( 'template-parts/page-titlebar/page-titlebar', 'page' );
}

/**
* Hook: alone_page_titlebar_archive
*
* @hooked alone_page_titlebar_archive_template - 10
*/
add_action('alone_page_titlebar_archive', 'alone_page_titlebar_archive_template', 10);

function alone_page_titlebar_archive_template() {
  /**
   * Page titlebar archive pages
   */
  get_template_part( 'template-parts/page-titlebar/page-titlebar', 'archive' );
}

/**
* Hook: alone_page_titlebar_search
*
* @hooked alone_page_titlebar_search_template - 10
*/
add_action('alone_page_titlebar_search', 'alone_page_titlebar_search_template', 10);

function alone_page_titlebar_search_template() {
  /**
   * Page titlebar search results pages
   */
  get_template_part( 'template-parts/page-titlebar/page-titlebar', 'search' );
}

/**********************************
* Footer
**********************************/
/**
 * Hook: alone_site_footer_content
 *
 * @hooked alone_site_footer_widgets - 10
 * @hooked alone_site_footer_info - 30
 */
add_action('alone_site_footer_content', 'alone_site_footer_widgets', 10);
add_action('alone_site_footer_content', 'alone_site_footer_info', 30);

function alone_site_footer_widgets() {
  /**
   * Footer widgets
   */
  get_template_part( 'template-parts/footer/footer', 'widgets' );
}

function alone_site_footer_info() {
  /**
   * Footer info
   */
  get_template_part( 'template-parts/footer/footer', 'info' );
}

/**
 * Hook: alone_footer_info
 *
 * @hooked alone_footer_info_wrapper_start - 10
 * @hooked alone_footer_info_copyright - 20
 * @hooked alone_footer_info_navigation - 30
 * @hooked alone_footer_info_wrapper_end - 60
 */
add_action('alone_footer_info', 'alone_footer_info_wrapper_start', 10);
add_action('alone_footer_info', 'alone_footer_info_copyright', 20);
add_action('alone_footer_info', 'alone_footer_info_navigation', 30);
add_action('alone_footer_info', 'alone_footer_info_wrapper_end', 60);

function alone_footer_info_wrapper_start() {
  /**
   * Footer info wrapper start
   */
  $classes = 'site-info';

  if( has_nav_menu( 'footer' ) ) {
    $classes .= ' has-navigation';
  }

  ?>
    <div class="<?php echo esc_attr( $classes ); ?>">
      <div class="container responsive">
        <div class="site-info-wrap">
  <?php
}

function alone_footer_info_copyright() {
  /**
   * Site copyright
   */
  ?>
    <div class="copyright">
      <?php if( alone_get_option( 'custom_site_copyright' ) ) { ?>

        <?php echo alone_get_option( 'copyright_text' ) ?>

      <?php } else { ?>

        <?php $blog_info = get_bloginfo( 'name' ); ?>

        <?php if ( ! empty( $blog_info ) ) : ?>
          <a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>,
        <?php endif; ?>

        <a href="<?php echo esc_url( __( 'https://bearsthemes.com/', 'alone' ) ); ?>" class="imprint">
          <?php
          /* translators: %s: Bearsthemes. */
          printf( __( 'Proudly powered by %s.', 'alone' ), 'Bearsthemes' );
          ?>
        </a>

      <?php } ?>

    </div>
  <?php
}

function alone_footer_info_navigation() {
  /**
   * Footer info navigation
   */
  if ( has_nav_menu( 'footer' ) ) :
    ?>
      <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'alone' ); ?>">
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer',
            'menu_class'     => 'footer-menu',
            'depth'          => 1,
          )
        );
        ?>
      </nav><!-- .footer-navigation -->
    <?php
  endif;
}

function alone_footer_info_wrapper_end() {
  /**
   * Footer info wrapper end
   */
  ?>
      </div>
    </div>
  </div><!-- .site-info -->
  <?php
}

/**********************************
* Single Post
**********************************/

/**
 * Hook: alone_entry_share_socials
 *
 * @hooked alone_share_socials_wrapper_start - 10
 * @hooked alone_share_socials_content - 20
 * @hooked alone_share_socials_wrapper_end - 40
 */
add_action( 'alone_entry_share_socials', 'alone_share_socials_wrapper_start', 10 );
add_action( 'alone_entry_share_socials', 'alone_share_socials_content', 20 );
add_action( 'alone_entry_share_socials', 'alone_share_socials_wrapper_end', 40 );

function alone_share_socials_wrapper_start() {
  /**
   * Socials share wrapper start
   */
  ?>
    <div class="entry-social-share">
  <?php
}

function alone_share_socials_content() {
  if( 1 !== absint( alone_get_option( 'show_socials_share' ) ) ) {
    return;
  }

	$output = '<span>' . esc_html__('Share: ', 'alone') . '</span>';

	$socials['facebook'] ='<a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url( get_permalink() ) . '" class="facebook" target="_blank">' . alone_get_social_icon_svg('facebook', 12) . '</a>';

	$socials['twitter'] = '<a href="https://twitter.com/home?status=' . esc_url( get_permalink() ) . '" class="twitter" target="_blank">' . alone_get_social_icon_svg('twitter', 12) . '</a>';

	$socials['pinterest'] = '<a href="https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&amp;media=&amp;description=" class="pinterest" target="_blank">' . alone_get_social_icon_svg('pinterest', 12) . '</a>';

	$socials['linkedin'] = '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_url( get_permalink() ) . '&amp;title=&amp;summary=&amp;source=' . get_the_permalink() . '" class="linkedin" target="_blank">' . alone_get_social_icon_svg('linkedin', 12) . '</a>';

	$socials['google'] = '<a href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" class="google" target="_blank">' . alone_get_social_icon_svg('google', 12) . '</a>';

	$socials['mail'] = '<a href="mailto:info@websiteplanet.com?&amp;subject=' . esc_url( get_permalink() ) . '&amp;body=Hi guys, %0AJust wanted to say you created an amazing theme, i love it. Well done!' . get_the_permalink() . '" class="mail">' . alone_get_social_icon_svg('mail', 12) . '</a>';


	$socials_sort = alone_get_option( 'socials_share_sort' );

  if( ! empty( $socials_sort ) ) {
    foreach ($socials_sort as $key => $value) {
      $output .= $socials[$value];
    }
  }

  echo apply_filters( 'alone_share_socials_content', $output );

}

function alone_share_socials_wrapper_end() {
  /**
   * Socials share wrapper end
   */
  ?>
  </div><!-- .socials-share -->
  <?php
}

/**
 * Load more posts
 */
function alone_posts_load_more_scripts() {

  if( 'pagination' === alone_get_option( 'blog_pagination_type' ) ) {
    return;
  }
 
	global $wp_query; 
 
	wp_register_script( 'posts-loadmore', get_stylesheet_directory_uri() . '/js/posts-loadmore.js', array('jquery') );
 
	wp_localize_script( 'posts-loadmore', 'posts_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		'posts' => json_encode( $wp_query->query_vars ),
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
 	wp_enqueue_script( 'posts-loadmore' );
}
add_action( 'wp_enqueue_scripts', 'alone_posts_load_more_scripts' );

/**
 * Load more posts ajax handler
 */
function alone_posts_loadmore_ajax_handler(){
  if( 'pagination' === alone_get_option( 'blog_pagination_type' ) ) {
    return;
  }
  
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
 
	query_posts( $args );
 
	if( have_posts() ) :
 
		while ( have_posts() ) {
      the_post();

      get_template_part( 'template-parts/content/content' );

    }
 
	endif;
	die;
}

add_action('wp_ajax_posts_loadmore', 'alone_posts_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_posts_loadmore', 'alone_posts_loadmore_ajax_handler');

/**
 * Validation form comment
 */
add_action('wp_footer', 'alone_comment_validation_init');
function alone_comment_validation_init(){
  if(comments_open() ) { ?>
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      jQuery('#commentform').validate({
          rules: {
            author: {
              required: true,
              minlength: 2
            },
            email: {
              required: true,
              email: true
            },
            comment: {
              required: true,
              minlength: 20
            }
          },
          errorElement: "div",
          errorPlacement: function(error, element) {
            element.after(error);
          }
      });
    });
    </script>
    <?php
    }
}
