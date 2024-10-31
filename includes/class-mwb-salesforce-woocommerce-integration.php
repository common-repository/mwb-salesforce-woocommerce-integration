<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Salesforce_Woocommerce_Integration {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mwb_Salesforce_Woocommerce_Integration_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SALESWOO_ORG_VERSION' ) ) {
			$this->version = SALESWOO_ORG_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mwb-salesforce-woocommerce-integration';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mwb_Salesforce_Woocommerce_Integration_Loader. Orchestrates the hooks of the plugin.
	 * - Mwb_Salesforce_Woocommerce_Integration_i18n. Defines internationalization functionality.
	 * - Mwb_Salesforce_Woocommerce_Integration_Admin. Defines all hooks for the admin area.
	 * - Mwb_Salesforce_Woocommerce_Integration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-salesforce-woocommerce-integration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-salesforce-woocommerce-integration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwb-salesforce-woocommerce-integration-admin.php';

		$this->loader = new Mwb_Salesforce_Woocommerce_Integration_Loader();

		// Class required for SOAP connection with Salesforce
		require_once ( SOAP_CLIENT.'/SforcePartnerClient.php');
		require_once ( SOAP_CLIENT.'/SforceMetadataClient.php');
		require_once ( SOAP_CLIENT.'/SforceEnterpriseClient.php');
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mwb_Salesforce_Woocommerce_Integration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mwb_Salesforce_Woocommerce_Integration_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mwb_Salesforce_Woocommerce_Integration_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $this->loader->add_action( 'wp_ajax_saleswoo_org_verify_account', $plugin_admin, 'saleswoo_org_verify_account'  );
        
        $this->loader->add_action( 'wp_ajax_saleswoo_org_get_started_call', $plugin_admin, 'saleswoo_org_get_started_call'  );

        $this->loader->add_action( 'wp_ajax_saleswoo_org_get_products_count', $plugin_admin, 'saleswoo_org_get_products_count'  );

        $this->loader->add_action( 'wp_ajax_saleswoo_org_create_product', $plugin_admin, 'saleswoo_org_create_product'  );

        $this->loader->add_action( 'wp_ajax_saleswoo_org_products_uploaded', $plugin_admin, 'saleswoo_org_products_uploaded'  );

        $this->loader->add_action( 'wp_ajax_saleswoo_org_delete_single_product', $plugin_admin, 'saleswoo_org_delete_single_product'  );
        
        $this->loader->add_action( 'wp_ajax_saleswoo_org_upload_single_product', $plugin_admin, 'saleswoo_org_upload_single_product'  );

	}	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mwb_Salesforce_Woocommerce_Integration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
 
	/**
	 * predefined default saleswoo tabs.
	 * @since     1.0.0
	 */
	public function saleswoo_org_default_tabs() { 

		$default_tabs = array();

		$default_tabs['saleswoo_org_overview'] 	= array( "name" => __( 'Overview', 'saleswoo-org' ), "dependency" => "" );

		$default_tabs['saleswoo_org_connect'] 	= array( "name" => __( 'Connect', 'saleswoo-org' ), "dependency" => array("saleswoo_org_get_started" ));

		$default_tabs['saleswoo_org_products'] 	= array( "name" => __( 'Upload Products', 'saleswoo-org' ), "dependency" => array('saleswoo_org_account_verified') );

		$common_dependencies = array("is_org_products_uploaded") ;

		$default_tabs['saleswoo_org_account'] 	= array( "name" => __( 'Account', 'saleswoo-org' ), "dependency" => array("is_org_products_uploaded"));

		$default_tabs['saleswoo_org_contact'] 	= array( "name" => __( 'Contact', 'saleswoo-org' ), "dependency" =>  array("is_org_products_uploaded") );

		$default_tabs['saleswoo_org_contract'] 	= array( "name" => __( 'Contract', 'saleswoo-org' ), "dependency" => array("is_org_products_uploaded") );

		$default_tabs['saleswoo_org_lead'] 		= array( "name" => __( 'Lead', 'saleswoo-org' ), "dependency" => array("is_org_products_uploaded") );

		$default_tabs['saleswoo_org_opportunity'] = array( "name" => __( 'Opportunity', 'saleswoo-org' ), "dependency" => array("is_org_products_uploaded") );

		$default_tabs['saleswoo_org_order'] = array( "name" => __( 'Order', 'saleswoo-org' ), "dependency" => array("is_org_products_uploaded") );

		return $default_tabs;
	}

	/**
	 * checking dependencies for tabs
	 * @since     1.0.0
	 */
	public function check_dependencies( $dependency = array() ) {

		$flag = true;

		global $saleswoo_org;

		if( count( $dependency ) ) {

			foreach( $dependency as $single_dependency ) {

				$flag &= $saleswoo_org->$single_dependency();
			}
		}

		return $flag;
	}

	/**
	 * Locate and load appropriate template.
	 *
	 * @since 	1.0.0
	 */
	public function load_template_view( $path, $params=array() ) {

		$file_path = SALESWOO_ABSPATH.$path;

		if( file_exists( $file_path ) ) {

			include $file_path;
		}
		else {

			$notice = sprintf( __( 'Unable to locate file path at location "%s" some features may not work properly in MWB Salesforce WooCommerce Integration, please contact us!', 'saleswoo-org' ) , $file_path );

			$this->saleswoo_org_notice( $notice, 'error' );
		}
	}

	/**
	 * show admin notices.
	 * @param  string 	$message 	Message to display.
	 * @param  string 	$type    	notice type, accepted values - error/update/update-nag
	 * @since  1.0.0
	 */
	public static function saleswoo_org_notice( $message, $type='error' ) {

		$classes = "notice ";

		switch( $type ) {

			case 'update':
				$classes .= "updated";
				break;

			case 'update-nag':
				$classes .= "update-nag";
				break;

			case 'success':
				$classes .= "notice-success is-dismissible";
				break;

			default:
				$classes .= "error";
		} 

		$notice = '<div style="margin:15px" class="'. $classes .'">';
		$notice .= '<p>'. $message .'</p>';
		$notice .= '</div>';

		echo $notice;	
	}

	/**
	* Checking if Get Started button is clicked
	* @since 1.0.0
	*/
	public static function saleswoo_org_get_started(){

		return get_option('saleswoo_org_get_started',false);
	}

	/**
	* Check if Salesforce Account is Verified or Not
	* @since 1.0.0
	*/
	public static function saleswoo_org_account_verified(){

		return get_option ('saleswoo_org_account_verified',false);
	}

	/**
	* Check if integration is Enabled
	* @since 1.0.0
	*/
	public static function is_org_integration_enabled(){

		if(get_option('saleswoo_org_enable_integration','no') == 'yes'){

			return true;
		}

		return false;
	}

	/**
	* Check if Products are uploaded
	* @since 1.0.0
	*/
	public static function is_org_products_uploaded(){

		return get_option('saleswoo_org_products_uploaded',false);
	}

	/**
     * create log of requests.
     * @since 1.0.0
     */
	public static function saleswoo_org_create_log( $message, $response) {

        $log_enable = get_option( 'saleswoo_org_log_enable', 'no' );

        if( $log_enable == "yes" ) {

            $log_dir = WC_LOG_DIR.'saleswoo-org-logs.log';

            if (!is_dir($log_dir)) {

                @fopen( WC_LOG_DIR.'saleswoo-org-logs.log', 'a' );
            }

            $log  = "Website: ".$_SERVER['REMOTE_ADDR'].PHP_EOL.
                    'Time: '.current_time("F j, Y  g:i a").PHP_EOL.
                    "Process: ".$message.PHP_EOL.
                    "Response: ".json_encode($response).PHP_EOL.
                    "-----------------------------------".PHP_EOL;

            file_put_contents($log_dir, $log, FILE_APPEND);
        }
    }
}
