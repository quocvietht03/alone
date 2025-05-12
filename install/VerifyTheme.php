<?php
/**
 * Base class for talking to API:s
 *
 * Other API classes may extend this class to take use of the
 * POST and GET request functions.
 */
define("ITEM_ID","15019939");
if (!class_exists('BearsthemesCommunicator')):
  class BearsthemesCommunicator{
    var $baseUrl;
    var $message;
    function __construct($baseUrl='https://apialonev2.kinsta.cloud') {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Regsiter a purchaseCode to a domain.
     *
     * @param String $purchaseCode
     * @param String $domain
     *
     * @return Integer - ID of the inserted connection
     */
    function registerDomain($purchaseCode, $domain) {
        $response = wp_remote_post( $this->baseUrl.'/api/v2/register-domain-by-purchase-code', array(
        	'method' => 'POST',
          'timeout' => 50,
        	'body' => array( 'purchase_code' => $purchaseCode, 'domain' => $domain )
        ));

        if ( is_wp_error( $response ) ) {
           $error_message = $response->get_error_message();
           $this->message = __("Something went wrong on unregister your domain: ", "alone").$error_message;
           return null;
        } else {
           return true;
        }
    }

    /**
     * Unregister / delete domain connaction from purchaseCode.
     *
     * @param String $purchaseCode
     *
     * @return Boolean
     */
    function unRegisterDomains($purchaseCode) {
      $response = wp_remote_post( $this->baseUrl.'/api/v2/unregister-domain-by-purchase-code', array(
        'method' => 'POST',
        'timeout' => 50,
        'body' => array( 'purchase_code' => $purchaseCode )
      ));

      if ( is_wp_error( $response ) ) {
         $error_message = $response->get_error_message();
         $this->message = __("Something went wrong on unregister your domain: ", "alone").$error_message;
         return null;
      } else {
         return true;
      }
    }

    /**
     * Get domains where this theme is used with same
     * purchase_code.
     *
     * @param String $purchaseCode
     *
     * @return Array<String> || null
     */
    function getConnectedDomains($purchaseCode) {
      $response = wp_remote_get( $this->baseUrl.'/api/v2/registered-by-purchase-code/'.$purchaseCode, array( 'timeout' => 50 ) );
      if ( is_wp_error( $response ) ) {
         $error_message = $response->get_error_message();
         $this->message = __("Something went wrong on get connected domain with your purchase code: ", "alone").$error_message;
         return null;
      } else {
         $result = json_decode($response['body']);
         $result = isset($result->result[0]->server_name) ? $result->result[0]->server_name : null;
         return $result;
      }
    }
    /**
     * Get download for certain item using purchase_code.
     *
     * @param String $item_id
     * @param String $purchase_code
     */
    function getPurchaseInformation($purchaseCode) {
      $response = wp_remote_get( $this->baseUrl.'/api/v2/verify-purchase-code/'.$purchaseCode, array( 'timeout' => 50 ) );
      if ( is_wp_error( $response ) ) {
         $error_message = $response->get_error_message();
         $this->message = __("Something went wrong on get purchase information: ", "alone").$error_message;
         return null;
      } else {
         $result = json_decode($response['body']);
         return $result;
      }
    }

    /**
     * Check if purchase_code is valid.
     *
     * @param String $purchaseCode
     *
     * @return Boolean
     */
    function isPurchaseCodeLegit($purchaseCode) {
        $get_info = $this->getPurchaseInformation($purchaseCode);
        $item_id = isset($get_info->data->item->id) ? $get_info->data->item->id : (isset($get_info->item->id) ? $get_info->item->id : 0);
        if($item_id != ITEM_ID) return false;
        return !empty($get_info);
    }
  }
endif;
// End BearsthemesCommunicator Class

// Helper
function isLocalhost($server_name){
  if (
      substr_count($server_name, 'localhost') > 0 ||
      substr_count($server_name, '.dev') > 0 ||
      substr_count($server_name, '.local') > 0
  ) { return true; }
  return false;
}

function isInstallationLegit( $data = false ) {
  $communicator = new BearsthemesCommunicator();
  $data = !$data ? get_option('_verifytheme_settings') : $data;
  if(!$data) return false;
  $__verify = get_option('__verify');
  if( $__verify && $__verify == ITEM_ID ) return true;

  $home_url = home_url();
  $parse_url = parse_url($home_url);
  $server_name =  $parse_url['host'];

  if ( isLocalhost($server_name) ) { return true; }

  if (!empty($data['purchase_code'])) {
      $connected_domain = $communicator->getConnectedDomains(
          $data['purchase_code']
      );

      // Return early if the connected domain is a subdomain of the current
      // domain we are trying to register (or viceversa)
      $real_con_domain = verifythemeGetDomain( $connected_domain );
      $real_current_domain = verifythemeGetDomain( $server_name );

      if ( $real_con_domain === $real_current_domain ) {
      	return true;
      }
      if (
          $connected_domain != $server_name &&
          !empty($connected_domain) && !isLocalhost($server_name)
      ) {
          return false;
      }
  }else{
    return false;
  }
  return true;
}

/**
 * Extract domain from hostname
 */
function verifythemeGetDomain( $url ) {
	$pieces = parse_url( $url );
	$domain = isset( $pieces[ 'path' ] ) ? $pieces[ 'path' ] : '';

	if ( preg_match( '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs ) ) {
		return $regs[ 'domain' ];
	}

	return false;
}
/**
 * Check if our purchase code is connected to any domain.
 * If there's not a domain attached to the purchase code,
 * empty the license data on this installation.
 */
function licenseNeedsDeactivation( $toolkitData ) {
	if ( $toolkitData && isset( $toolkitData[ 'purchase_code' ] ) ) {
		$communicator = new BearsthemesCommunicator();
		$connected_domain = $communicator->getConnectedDomains( $toolkitData[ 'purchase_code' ] );

		if ( ! $connected_domain ) {
			delete_option( '_verifytheme_settings' );
			return true;
		} else {
			return false;
		}
	}

	return false;
}

// End Helper

class VerifyTheme {
    public $isInstallationLegit;
    function __construct() {
      // create custom plugin settings menu
      add_action('admin_menu', array( $this, 'verifytheme_menu' ));
      add_action('admin_init', array( $this, 'verifytheme_page_init' ));
      add_action( 'admin_enqueue_scripts', array( $this, 'verifytheme_admin_script' ), 5);
      $this->isInstallationLegit();
  		if ( !$this->isInstallationLegit ){
  			add_action( 'admin_notices', array( $this, 'verifytheme_admin_notice__warning' ));
  		}
    }
    // check theme activate
    function isInstallationLegit(){
      $toolkitData = get_option('_verifytheme_settings');;
      $installationLegit = isInstallationLegit();
      if ( $toolkitData && $installationLegit ) $this->isInstallationLegit = true;
      return $this->isInstallationLegit;
    }
  	// function notice if theme not active
  	function verifytheme_admin_notice__warning() {
  		$class = 'notice notice-error is-dismissible';
  		$setting_page = admin_url('options-general.php?page=verifytheme_settings');
      $message = sprintf( __( '<b>Important notice:</b> In order to receive all benefits of our theme, you need to activate your copy of the theme. <br />By activating the theme license you will unlock premium options - import demo data, install & update plugins and official support. Please visit  %1$s page to activate your copy of the theme', 'alone' ), '<a href="'.$setting_page.'">' . __('Envato Settings', 'alone') . '</a>' );
  		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses( $message, array('b' => array(), 'br' => array(), 'a' => array('href' => array())) ) );
  	}

    // add style admin
  	function verifytheme_admin_script() {
      wp_register_style( 'verifytheme', get_template_directory_uri() . '/install/verifytheme.css', false );
      wp_enqueue_style( 'verifytheme' );
	  if(!$this->isInstallationLegit){
        $setting_page = admin_url('options-general.php?page=verifytheme_settings');
        $message = esc_html__( "Important notice: In order to receive all benefits of our theme, you need to activate your copy of the theme. \nBy activating the theme license you will unlock premium options - import demo data, install, update plugins and official support. Please visit Envato Settings page to activate your copy of the theme", 'alone' );
        wp_register_script( 'verifytheme', get_template_directory_uri() . '/install/verifytheme.js', false );
        wp_localize_script(
  				'verifytheme',
  				'verifytheme',
  				array(
  					'admin_url'    => admin_url(),
  					'setting_page' => $setting_page,
  					'message'     => $message
  				)
  			);
        wp_enqueue_script( 'verifytheme' );
      }
  	}
    /**
     * Menu admin
     *
     */

    function verifytheme_menu() {
      add_options_page(
          'Envato Settings',
          'Envato Settings',
          'manage_options',
          'verifytheme_settings',
          array( $this, 'verifytheme_settings_page' )
      );
    }
    /**
     * Options page callback
     */
    public function verifytheme_settings_page(){
        $communicator = new BearsthemesCommunicator();
        $toolkitData = get_option('_verifytheme_settings');
        if ( isset( $_POST[ 'change_license' ] ) && class_exists( 'BearsthemesCommunicator' ) ) {
          $is_deregistering_license = true;
					$communicator->unRegisterDomains( $toolkitData[ 'purchase_code' ] );
					delete_option( '_verifytheme_settings' );
          delete_option( '__verify', ITEM_ID);
				}
        $license_already_in_use = false;
  			// This flag checks if we are deregistering a purchase code - We need
  			// it becasuse the $communicator->unRegisterDomains()
  			// runs after the form submission
				$is_deregistering_license = false;

				$installationLegit = isInstallationLegit();

				if ( ! $installationLegit ) {
					$license_already_in_use = true;
				}
        $other_attributes = '';
        $register_button_text = __( 'Register your theme', 'alone' );
        if ( $toolkitData && $installationLegit ){
          $other_attributes = 'disabled';
          $register_button_text = __( 'Activated on this domain', 'alone' );
          $this->isInstallationLegit = true;
        }
        $type = 'primary';
        $name = 'submit';
        $wrap = true;
        $verify_options = get_option( '_verifytheme_settings' );
        ?>
        <div class="wrap verifytheme_wrap">
            <form class="verifytheme_settings_form" method="post" action="options.php">
              <?php
                  // This prints out all hidden setting fields
                  settings_fields( '_verifytheme_settings' );
                  do_settings_sections( '_verifytheme_settings' );
                  submit_button($register_button_text, $type, $name, $wrap, $other_attributes);
              ?>
              <?php if ( $toolkitData && ! $is_deregistering_license && ! $license_already_in_use ) : ?>
                <p class="change_license_wrap">
                  <input name="change_license_tmp" onclick="document.getElementById('change_license_btn').click();" id="change_license_tmp" class="button" value="<?php esc_attr_e('Deregister your product','alone'); ?>" type="button">
                </p>

                <p class="import_demo_wrap">
                  <a href="<?php echo esc_url('themes.php?page=import-demo-page'); ?>"><?php echo esc_html__('Back Import Demo','alone'); ?></a>
                </p>
              <?php endif; ?>
            </form>
            <form style="display: none" id="change_license_form" method="POST">
              <button id="change_license_btn" type="submit" class="button button-primary" name="change_license"><?php echo esc_html__( 'Deregister your product', 'alone' ); ?></button>
            </form>
        </div>
        <?php
    }
    /**
     * Register and add settings
     */
    public function verifytheme_page_init()
    {
        register_setting(
            '_verifytheme_settings', // Option group
            '_verifytheme_settings', // Option name
            array( $this, 'verifytheme_sanitize' ) // Sanitize
        );

        add_settings_section(
            'verifytheme_general_section', // ID
            'Envato Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            '_verifytheme_settings' // Page
        );

        add_settings_field(
            'purchase_code',
            'Purchase code',
            array( $this, 'verifytheme_purchase_code_callback' ),
            '_verifytheme_settings',
            'verifytheme_general_section'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function verifytheme_sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['purchase_code'] ) ) $new_input['purchase_code'] = sanitize_text_field( $input['purchase_code'] );
        $register_error = get_settings_errors('_verifytheme_settings');
        $message = '';
        $type = 'error';
        $data = array();
        $communicator = new BearsthemesCommunicator();
        $ok_purchase_code = $communicator->isPurchaseCodeLegit($new_input['purchase_code']);
        if ($ok_purchase_code) {
            $data = array(
                'purchase_code' => $new_input['purchase_code'],
            );
        } else {
          if($communicator->message){
            $message .= $communicator->message;
          }else{
            $message .= __("Invalid purchase code<br />","alone");
          }
        }
        $connected_domain = $communicator->getConnectedDomains( $new_input['purchase_code'] );
        $already_in_use = ! isInstallationLegit( $data );
        if(!empty($message)):
          if(!$register_error):
            add_settings_error(
                '_verifytheme_settings',
                esc_attr( 'settings_updated' ),
                $message,
                $type
            );
            return array();
          endif;
        else:
          if ( ! $already_in_use ):
            $home_url = home_url();
            $parse_url = parse_url($home_url);
            $server_name =  $parse_url['host'];
            // Deregister any connected domain first
            if( !isLocalhost($server_name) ):
              $communicator->unRegisterDomains( $new_input[ 'purchase_code' ] );
              $communicator->registerDomain($new_input['purchase_code'], $server_name);
              update_option( '__verify', ITEM_ID);
            endif;
          else:
            $message .= sprintf(wp_kses( __( 'This product is in use on another domain: <span>%s</span><br />', 'alone' ), array( 'span' => array(), 'br' => array() ) ), $connected_domain );
            $message .= sprintf(esc_html__('Are you using this theme for a new site? Please purchase a %s ', 'alone' ), '<a tabindex="-1" href="' . esc_url( 'http://themeforest.net/cart/add_items?ref=bearsthemes&item_ids=' ) .ITEM_ID.'" target="_blank">'.esc_html__('new license','alone').'</a>');
            if(!$register_error):
              add_settings_error(
                  '_verifytheme_settings',
                  esc_attr( 'settings_updated' ),
                  $message,
                  $type
              );
              return array();
            endif;
          endif;
        endif;
        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        printf(
            '%s<br />%s<a target="_blank" href="%s">%s</a>.</small>',
            esc_html__('Themeforest provides purchase code for each theme you buy, and you’ll need it to verify and register your product (and to receive theme support).','alone'),esc_html__('To download your purchase code, simply follow these steps at ','alone'), esc_url('https://docs.beplusthemes.com/Alone7/#product-registration'), esc_html__('here','alone')
        );
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function verifytheme_purchase_code_callback()
    {
        printf(
            '<input type="text" id="purchase_code" required name="_verifytheme_settings[purchase_code]" value="%s" /><br /><small>%s<a target="_blank" href="%s">%s</a>.</small>',
            isset( $verify_options['purchase_code'] ) ? esc_attr( $verify_options['purchase_code']) : '', esc_html__('Please insert your Envato purchase code. ','alone'), esc_url('https://docs.beplusthemes.com/Alone7/#product-registration'), esc_html__('More info','alone')
        );
    }
}
