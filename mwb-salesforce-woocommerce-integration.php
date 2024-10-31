<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com
 * @since             1.0.0
 * @package           Mwb_Salesforce_Woocommerce_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       MWB Salesforce WooCommerce Integration
 * Plugin URI:        https://makewebbetter.com/mwb-salesforce-woocommerce-integration
 * Description:       A very powerful plugin to integrate your WooCommerce store with Salesforce seamlessly.
 * Version:           1.0.0
 * Requires at least: 		4.4
 * Tested up to: 			4.9.8
 * WC requires at least: 	3.0.0
 * WC tested up to: 		3.5.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       saleswoo-org
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$saleswoo_org_activated = true;
$saleswoo_org_flag = 1 ;

/**
 * Checking if WooCommerce is active
 **/
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	$saleswoo_org_activated = false;
	$saleswoo_org_flag = 0;
}
elseif( in_array('salesforce-woocommerce-integration-pro/salesforce-woocommerce-integration-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){

	$saleswoo_org_activated = false;
	$saleswoo_org_flag = -1;
}
elseif(!class_exists( 'SoapClient' )){
	$saleswoo_org_activated = false;
	$saleswoo_org_flag = 2;
}

if( $saleswoo_org_activated && $saleswoo_org_flag){

	/**
	 * The code that runs during plugin activation.
	 */
	if(!function_exists('activate_mwb_salesforce_woocommerce_integration')){

		function activate_mwb_salesforce_woocommerce_integration() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-salesforce-woocommerce-integration-activator.php';
			Mwb_Salesforce_Woocommerce_Integration_Activator::activate();
		}
	}

	/**
	 * The code that runs during plugin deactivation.
	 */
	if(!function_exists('deactivate_mwb_salesforce_woocommerce_integration')){

		function deactivate_mwb_salesforce_woocommerce_integration() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-salesforce-woocommerce-integration-deactivator.php';
			Mwb_Salesforce_Woocommerce_Integration_Deactivator::deactivate();
		}
	}
	

	register_activation_hook( __FILE__, 'activate_mwb_salesforce_woocommerce_integration' );
	register_deactivation_hook( __FILE__, 'deactivate_mwb_salesforce_woocommerce_integration' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-salesforce-woocommerce-integration.php';

	/**
	 * define Saleswoo constants.
	 *
	 * @since 1.0.0
	 */
	function saleswoo_org_deine_constants(){

		saleswoo_org_define( 'SALESWOO_ORG_VERSION', '1.0.0' );
		saleswoo_org_define( 'SALESWOO_ABSPATH',dirname( __FILE__ )."/" );
		saleswoo_org_define( 'SALESWOO_PHP_TOOLKIT',dirname( __FILE__ )."/soap_toolkit"  );
		saleswoo_org_define( 'SALESWOO_URL', plugin_dir_url( __FILE__ ) . '/' );
		saleswoo_org_define( 'SOAP_CLIENT', SALESWOO_PHP_TOOLKIT.'/soapclient');
		saleswoo_org_define( "SF_PARTNER_WSDL", SOAP_CLIENT.'/partner.wsdl.xml');
		saleswoo_org_define( "SF_METADATA_WSDL", SOAP_CLIENT.'/metadata.wsdl.xml');
		saleswoo_org_define( "SF_ENTERPRISE_WSDL", SOAP_CLIENT.'/enterprise.wsdl.xml');
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @param  string|bool $value
	 * @since 1.0.0
	*/
	function saleswoo_org_define($name,$value){

		if(!defined($name)){

			define($name,$value);
		}
	}

	/**
	 * Setting Page Link
	 * @since    1.0.0
	 * @author  MakeWebBetter
	 * @link  http://makewebbetter.com/
	 */
	function saleswoo_org_admin_settings( $actions, $plugin_file ) {

		static $plugin;

		if ( !isset( $plugin ) ) {

			$plugin = plugin_basename ( __FILE__ );
		}

		if ( $plugin == $plugin_file ) {

			$settings = array (
				'settings' => '<a href="' . admin_url ( 'admin.php?page=saleswoo_org' ) . '">' . __ ( 'Settings', 'saleswoo-org' ) . '</a>',
			);

			$actions = array_merge ( $settings, $actions );
		}

		return $actions;
	}

	//add link for settings
	add_filter ( 'plugin_action_links','saleswoo_org_admin_settings', 10, 5 );

	/**
	* Add plugin row meta
	* @since 1.0.0
	*/
	function saleswoo_org_plugin_row_meta( $links, $file ) {
		
		if ( strpos( $file, 'mwb-salesforce-woocommerce-integration.php' ) !== false ) {

			$row_meta = array(
				'docs'    => '<a style="color:#FFF;background-color:#5ad75a;padding:5px;border-radius:6px;" href="https://docs.makewebbetter.com/mwb-salesforce-woocommerce-integration/" target="_blank">'.esc_html__("Documentation","saleswoo-org").'</a>',
				'goPro' => '<a style="color:#FFF;background-color:#FF7A59;padding:5px;border-radius:6px;" href="https://makewebbetter.com/product/salesforce-woocommerce-integration-pro" target="_blank"><strong>'.esc_html__("Go Premium","saleswoo-org").'</strong></a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	add_filter( 'plugin_row_meta', 'saleswoo_org_plugin_row_meta', 10, 2 );

	/**
	 * Auto Redirection to settings page after plugin activation
	 * @since    1.0.0
	 * @author  MakeWebBetter
	 * @link  https://makewebbetter.com/
	 */
	function saleswoo_org_activation_redirect( $plugin ) {

	    if( $plugin == plugin_basename( __FILE__ ) ) {

	        exit( wp_redirect( admin_url( 'admin.php?page=saleswoo_org' ) ) );
	    }
	}
	//redirect to settings page as soon as plugin is activated
	add_action( 'activated_plugin', 'saleswoo_org_activation_redirect' );

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_mwb_salesforce_woocommerce_integration() {

		saleswoo_org_deine_constants();

		$saleswoo_org = new Mwb_Salesforce_Woocommerce_Integration();
		$saleswoo_org->run();

		$GLOBALS['saleswoo_org'] = $saleswoo_org;

	}
	run_mwb_salesforce_woocommerce_integration();
}
elseif( !$saleswoo_org_activated && $saleswoo_org_flag === 0){

	add_action( 'admin_init', 'saleswoo_org_plugin_deactivate' );  
 
 	/**
 	 * Call Admin notices
 	 * 
 	 * @name saleswoo_org_plugin_deactivate()
 	 * @author MakeWebBetter<webmaster@makewebbetter.com>
 	 * @link https://www.makewebbetter.com/
 	 */ 	
  	function saleswoo_org_plugin_deactivate() {

	   deactivate_plugins( plugin_basename( __FILE__ ) );
	   add_action( 'admin_notices', 'saleswoo_org_plugin_error_notice' );
	}

	/**
	 * Show warning message if woocommerce is not install
	 * @since 1.0.0
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */

	function saleswoo_org_plugin_error_notice() {

 		?>
 		 <div class="error notice is-dismissible">
 			<p><?php _e( 'WooCommerce is not activated, Please activate WooCommerce first to install MWB Salesforce WooCommerce Integration .', 'saleswoo-org' ); ?></p>
   		</div>
   		<style>
   		#message{display:none;}
   		</style>
   		<?php 
 	}
}
elseif( !$saleswoo_org_activated && $saleswoo_org_flag === -1){

	/**
	 * Show warning message if Salesforce WooCommerce Integration PRO version is activated
	 * @since 1.0.0
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */

	function saleswoo_org_plugin_basic_error_notice() {

		?>
		 <div class="error notice is-dismissible">
			<p><?php _e("Oops! You tried activating the MWB Salesforce WooCommerce Integration without deactivating the another version of the integration. Kindly deactivate the other version of Salesforce WooCommerce Integration Pro and then try again.", 'saleswoo-org' ); ?></p>
		  </div>
		  <style>
		  #message{display:none;}
		  </style>
		  <?php 
	}

	add_action( 'admin_init', 'saleswoo_org_plugin_deactivate_dueto_basicversion' );  

	
	/**
	 * Call Admin notices
	 * 
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */ 	
	 function saleswoo_org_plugin_deactivate_dueto_basicversion() {

	  deactivate_plugins( plugin_basename( __FILE__ ) );
	  add_action( 'admin_notices', 'saleswoo_org_plugin_basic_error_notice' );
   }
}
elseif( !$saleswoo_org_activated && $saleswoo_org_flag === 2){

	/**
	 * Show warning message if Salesforce WooCommerce Integration PRO version is activated
	 * @since 1.0.0
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */

	function saleswoo_org_plugin_basic_error_notice() {

		?>
		 <div class="error notice is-dismissible">
			<p><?php _e("Soap Client Not Found.", 'saleswoo-org' ); ?></p>
			<p><?php _e("The MWB Salesforce WooCommerce Integration plugin requires Soap Client class enabled. Please contact your Web Server Administrator.", 'saleswoo-org' ); ?></p>
		  </div>
		  <style>
		  #message{display:none;}
		  </style>
		  <?php 
	}

	add_action( 'admin_init', 'saleswoo_org_plugin_deactivate_dueto_basicversion' );  

	
	/**
	 * Call Admin notices
	 * 
	 * @author MakeWebBetter<webmaster@makewebbetter.com>
	 * @link https://www.makewebbetter.com/
	 */ 	
	 function saleswoo_org_plugin_deactivate_dueto_basicversion() {

	  deactivate_plugins( plugin_basename( __FILE__ ) );
	  add_action( 'admin_notices', 'saleswoo_org_plugin_basic_error_notice' );
   }
}
