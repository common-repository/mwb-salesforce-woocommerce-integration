<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/admin
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Salesforce_Woocommerce_Integration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->admin_actions();
	}

	/**
	 * all admin actions.
	 * 
	 * @since 1.0.0
	 */
	public function admin_actions() {

		// add submenu salesforce in woocommerce top menu.
		add_action( 'admin_menu', array( &$this, 'add_saleswoo_org_submenu' ) );
	}

	/**
	 * add salesforce submenu in woocommerce menu..
	 *
	 * @since 1.0.0
	 */
	public function add_saleswoo_org_submenu() {
		
		add_submenu_page( 'woocommerce', __('Salesforce', 'saleswoo-org'), __('Salesforce', 'saleswoo-org'), 'manage_woocommerce', 'saleswoo_org', array(&$this, 'saleswoo_org_configurations') );
	}

	/**
	 * all the configuration related fields and settings.
	 * 
	 * @return html  all the settings and configuration options for salesforce.
	 * @since 1.0.0
	 */
	public function saleswoo_org_configurations() {

		include_once SALESWOO_ABSPATH . 'admin/templates/saleswoo_org_main_template.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		 
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwb-salesforce-woocommerce-integration-admin.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION );

		$locale  = localeconv();
		$decimal = isset( $locale['decimal_point'] ) ? $locale['decimal_point'] : '.';
		$params = array(
			'i18n_decimal_error'                => sprintf( __( 'Please enter in decimal (%s) format without thousand separators.', "saleswoo-org" ), $decimal ),
			'i18n_mon_decimal_error'            => sprintf( __( 'Please enter in monetary decimal (%s) format without thousand separators and currency symbols.', 'saleswoo-org' ), wc_get_price_decimal_separator() ),
			'i18n_country_iso_error'            => __( 'Please enter in country code with two capital letters.', 'saleswoo-org' ),
			'i18_sale_less_than_regular_error'  => __( 'Please enter in a value less than the regular price.', 'saleswoo-org' ),
			'decimal_point'                     => $decimal,
			'mon_decimal_point'                 => wc_get_price_decimal_separator(),
			'strings' => array(
				'import_products' => __( 'Import', 'saleswoo-org' ),
				'export_products' => __( 'Export', 'saleswoo-org' ),
			),
			'urls' => array(
				'import_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_importer' ) ),
				'export_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_exporter' ) ),
			),
		);
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_localize_script( 'woocommerce_admin', 'woocommerce_admin', $params );
		wp_enqueue_script( 'woocommerce_admin' );
		wp_register_script( 'saleswoo_org_admin_script', plugin_dir_url( __FILE__ ) . 'js/mwb-salesforce-woocommerce-integration-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( 'saleswoo_org_admin_script', 
			'saleswooi18n', array( 
				'ajaxUrl' 					=> admin_url( 'admin-ajax.php' ),
				'saleswooSecurity' 			=> wp_create_nonce( 'saleswoo_security' ), 
				'saleswooNoProducts'		=> __("Sorry no products found !","saleswoo-org"),
				'saleswooProductCreated' 	=> __('Product Uploaded on Salesforce ','saleswoo-org'),
				'productsUploaded'			=> __('Products uploaded successfully on Salesforce', 'saleswoo-org'),
				'productCreated'			=> __('Product Created on Salesforce : ', 'saleswoo-org'),
				'productNotCreated'			=> __('Product Not Created : ', 'saleswoo-org'),
				'saleswooFieldsTab' 		=> admin_url() . 'admin.php?page=saleswoo_org&saleswoo_org_tab=saleswoo_org_products',
				'saleswooConnectTab'		=> admin_url() . 'admin.php?page=saleswoo_org&saleswoo_org_tab=saleswoo_org_connect',
				'saleswooDeleteSuccess'		=> __('Product Deleted','saleswoo-org'),
				'saleswooDeleteFail'		=> __('Product Not Deleted','saleswoo-org'),
				'saleswooUploadSuccess'		=> __('Product Uploaded Successfully','saleswoo-org'),
				'saleswooUploadFail'		=> __('Product not uploaded','saleswoo-org'),
			)
		);

		wp_enqueue_script( 'saleswoo_org_admin_script' );
	}

	/**
	* Connect tab fields
	* @since 	1.0.0
	*/
	public static function saleswoo_org_connect_tab_fields(){

		$connect_tab_fields = array();

		$connect_tab_fields[] = array(
			"title" => __("Connect with Salesforce","saleswoo-org"),
			"id" 	=> "saleswoo_org_connect_tab_title",
			"type" 	=> "title" 
		);

		$connect_tab_fields[] = array(
			"title" => __("Enable/Disable","saleswoo-org"),
			"id" 	=> "saleswoo_org_enable_integration",
			"desc" 	=> __("Enable/Disable Integration","saleswoo-org"),
			"type" 	=> "checkbox" ,
		);

		$connect_tab_fields[] = array(
			"title" => __("Username","saleswoo-org"),
			"id" 	=> "saleswoo_org_username",
			"type" 	=> "text" 
		);

		$connect_tab_fields[] = array(
			"title" => __("Password","saleswoo-org"),
			"id" 	=> "saleswoo_org_password",
			"type" 	=> "password" 
		);

		$connect_tab_fields[] = array(
			"title" => __("Security Token","saleswoo-org"),
			"id" 	=> "saleswoo_org_security_token",
			"desc"	=> __('How to get Salesforce Security Token ? <button type="button" id="saleswoo_token_info">Click Here</button>', 'saleswoo-org'),
			"type" 	=> "text" 
		);

		$connect_tab_fields[] = array(
			"title" => __("Enable/ Disable Log","saleswoo-org"),
			"id" 	=> "saleswoo_org_log_enable",
			"desc"	=> sprintf( __('Enable logging of the requests. You can view Salesforce log file from <a href="%s">Here</a>', 'saleswoo-org'), '?page=wc-status&tab=logs'),
			"type" 	=> "checkbox" ,
		);


		$connect_tab_fields[] = array(
			"type" 	=> "sectionend",
			"id"	=> "saleswoo_org_connect_tab_ends"
		);

		return $connect_tab_fields;
	}

	/**
	* Connect tab fields for display
	* @since 	1.0.0
	*/
	public static function saleswoo_connect_tab_fields_display(){

		$connect_tab_fields = array();

		$connect_tab_fields[] = array(
			"title" => __("Connect with Salesforce","saleswoo-org"),
			"id" 	=> "saleswoo_org_connect_tab_title",
			"type" 	=> "title" 
		);

		$connect_tab_fields[] = array(
			"title" => __("Enable/Disable","saleswoo-org"),
			"id" 	=> "saleswoo_org_enable_integration",
			"desc" 	=> __("Enable/Disable Integration","saleswoo-org"),
			"type" 	=> "checkbox" ,
		);

		$connect_tab_fields[] = array(
			"title" => __("Username","saleswoo-org"),
			"id" 	=> "saleswoo_org_username",
			"type" 	=> "text" ,
			"custom_attributes" => array( "disabled" => 1 ),
		);

		$connect_tab_fields[] = array(
			"title" => __("Password","saleswoo-org"),
			"id" 	=> "saleswoo_org_password",
			"type" 	=> "password" ,
			"custom_attributes" => array( "disabled" => 1 ),
		);

		$connect_tab_fields[] = array(
			"title" => __("Security Token","saleswoo-org"),
			"id" 	=> "saleswoo_org_security_token",
			"type" 	=> "password" ,
			"custom_attributes" => array( "disabled" => 1 ),
		);

		$connect_tab_fields[] = array(
			"title" => __("Enable/ Disable Log","saleswoo-org"),
			"id" 	=> "saleswoo_org_log_enable",
			"desc"	=> sprintf( __('Enable logging of the requests. You can view Salesforce log file from <a href="%s">Here</a>', 'saleswoo-org'), '?page=wc-status&tab=logs'),
			"type" 	=> "checkbox" ,
		);

		$connect_tab_fields[] = array(
			"type" 	=> "sectionend",
			"id"	=> "saleswoo_org_connect_tab_ends"
		);

		return $connect_tab_fields;
	}

	/**
	* Verify Salesforce Account
	* @since 	1.0.0
	*/
	public static function saleswoo_org_verify_account(){

		check_ajax_referer('saleswoo_security', 'saleswooSecurity');

		global $saleswoo_org;

		$SF_USERNAME 		= get_option("saleswoo_org_username","");
		$SF_PASSWORD 		= get_option("saleswoo_org_password","");
		$SF_SECURITY_TOKEN 	= get_option("saleswoo_org_security_token","");

		$errorEnterprise 	= "";

		try{

			$soapEnterprise 			= new SforceEnterpriseClient();
			$soapEnterpriseConnection 	= $soapEnterprise->createConnection(SF_ENTERPRISE_WSDL);
			$soapEnterpriseLogin 		= $soapEnterprise->login($SF_USERNAME,$SF_PASSWORD.$SF_SECURITY_TOKEN);
		}

		catch(Exception $e){

			$e->faultstring;
			$errorEnterprise 	= $e->getMessage();

			$message 			= __('Error Establishing Connection','saleswoo-org');
			$saleswoo_org->saleswoo_org_create_log($message, $errorEnterprise);
			$return['code'] 	= 400;
			$return['message'] 	= $message;
		}

		if(empty($errorEnterprise)){

			$message 			= __('Connection Established','saleswoo-org');
			$saleswoo_org->saleswoo_org_create_log($message, $soapEnterprise);
			$return['code'] 	= 200;
			$return['message'] 	= $message;

			update_option('saleswoo_org_account_verified',true);
		}
		echo json_encode( $return );
		wp_die();
	}

	/**
	* Click on Get Started button
	* @since 	1.0.0
	*/
	public static function saleswoo_org_get_started_call(){

		check_ajax_referer('saleswoo_security', 'saleswooSecurity');
		update_option('saleswoo_org_get_started',true);
		return true;
	}

	/**
	* Get store products count
	* @since 	1.0.0
	*/
	public function saleswoo_org_get_products_count(){

		check_ajax_referer('saleswoo_security', 'saleswooSecurity');

		$args = array(
		    'numberposts' 	=> -1,
		    'post_type'		=> array( 'product','product_varitaion' ),
		    'post_status'	=> array( 'publish' ),
		);

		$wcProductsArray 	= get_posts( $args );
		
		$products_count 	= count( $wcProductsArray );

		echo $products_count;

		wp_die();
	}

	/**
	* Get product details to upload on Salesforce
	* @since 	1.0.0
	*/
	public function saleswoo_org_create_product(){

		check_ajax_referer('saleswoo_security', 'saleswooSecurity');

		$offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : 0 ;

		$args = array(
		    'posts_per_page' 		=> 1,
		    'offset' 				=> $offset,
		    'post_type'				=> array( 'product' ),
		    'post_status'			=> array( 'publish' ),
		);
		global $saleswoo;

		$return = array('code'=>400, 'message'=>"", 'product_name'=>"");

		$wcProductsArray = get_posts( $args );

		if( is_array( $wcProductsArray ) && count( $wcProductsArray ) ) {

			foreach( $wcProductsArray as $single_product ) {

				if( !empty( $single_product->ID ) ) {

					$id 				=  $single_product->ID ;

					$product 			= wc_get_product( $id );

					$product_description= wp_strip_all_tags($product->get_short_description());

					if(empty($product_description)){

						$product_description = wp_strip_all_tags($product->get_description());
					}

					$product_type = $product->get_type();

					if($product_type == "variable"){

						$variations=$product->get_available_variations();

						foreach ($variations as $value) {

							$variation_id 		= $value['variation_id'];

							$single_variation 	= wc_get_product($variation_id);

							$vartion_data 		= $single_variation->get_data();

							$variation_name 	= $vartion_data['name'];

							$variation_price 	= $single_variation->get_price();

							$variation_sku 		= get_post_meta($variation_id,'_sku',true);;

							$variation_description = $product_description;

							if(!empty($variation_price)){

								$upload_variation 	= self::saleswoo_org_upload_product($variation_id, $variation_name, $variation_description, $variation_sku, $variation_price);

								$return['code'] 		= $upload_variation['code'];
								$return['message'] 		= $upload_variation['message'];
								$return['product_name'] = $product->get_name();
							}
						}
						break;
					}
					else{

						$product_name 		= $product->get_name();

						$product_price 		= $product->get_price();

						$product_sku 		= $product->get_sku();

						$description 		= $product_description;

						if(!empty($product_price)){

							$upload_product 	= self::saleswoo_org_upload_product($id, $product_name, $description, $product_sku, $product_price);	

							$return['code'] 		= $upload_product['code'];
							$return['message'] 		= $upload_product['message'];
							$return['product_name'] = $product_name;
						}
					}
					break;	
				}
				break;
			}
		}
		echo json_encode($return);
		wp_die();
	}

	/**
	* Upload products on Salesforce
	* @since 	1.0.0
	*/
	public static function saleswoo_org_upload_product($id, $name, $description, $sku, $price){

		global $saleswoo_org;

		$SF_USERNAME 		= get_option("saleswoo_org_username","");
		$SF_PASSWORD 		= get_option("saleswoo_org_password","");
		$SF_SECURITY_TOKEN 	= get_option("saleswoo_org_security_token","");

		$errorEnterprise 		= "";
		$errorProduct 			= "";
		$errorPricebookEntry 	= "";
		$product_uploaded 		= false;

		$return = array("code" => 400, "message" => "");

		try{

			$soapEnterprise 			= new SforceEnterpriseClient();
			$soapEnterpriseConnection 	= $soapEnterprise->createConnection(SF_ENTERPRISE_WSDL);
			$soapEnterpriseLogin 		= $soapEnterprise->login($SF_USERNAME,$SF_PASSWORD.$SF_SECURITY_TOKEN);
		}

		catch(Exception $e){

			$e->faultstring;
			$errorEnterprise 	= $e->getMessage();

			$message 			= __('Error Establishing Connection','saleswoo-org');
			$saleswoo_org->saleswoo_org_create_log($message, $errorEnterprise);
			$return['code'] 	= 400;
			$return['message'] 	= $message;
		}

		if(empty($errorEnterprise)){

			$message 			= __('Connection Established','saleswoo-org');
			$saleswoo_org->saleswoo_org_create_log($message, $soapEnterprise);
			$return['code'] 	= 200;
			$return['message'] 	= $message;

		}

		if($return['code'] == 200){

			$product 		= new stdclass();

			$product->Name 	= $name;

			if(!empty($description)){

				$product->Description = $description;
			}

			if(!empty($sku)){

				$product->ProductCode = $sku;
	
			}
			try{
				$upload_product = $soapEnterprise->create(array($product),'Product2');

			}
			catch(Exception $e){
				$e->faultstring;
				$errorProduct 		= $e->getMessage();

				$message 			= __('Product Not Uploaded','saleswoo-org');
				$saleswoo_org->saleswoo_org_create_log($message." : ".$name, $errorProduct);
				$return['code'] 	= 400;
				$return['message'] 	= $message;
			}
		}

		if(empty($errorProduct)){

			$message 				= __('Product Uploaded','saleswoo-org');
			$saleswoo_org->saleswoo_org_create_log($message." : ".$name, $upload_product);

			if(isset($upload_product[0]->id)){

				$product_id 		= $upload_product[0]->id ;
				update_post_meta($id, "saleswoo_org_product_id" , $product_id);
				$product_uploaded 	= true;
				$return['code'] 	= 200;
				$return['message'] 	= $message;
			}
		}
		return $return;
	}

	/**
	* Mark product upload complete
	* @since 	1.0.0
	*/
	public function saleswoo_org_products_uploaded(){

		check_ajax_referer('saleswoo_security', 'saleswooSecurity');

		update_option('saleswoo_org_products_uploaded',true);

		return true;
	}

	/**
	* Delete single product on button click
	* @since 	1.0.0
	*/
	public function saleswoo_org_delete_single_product(){

		global $saleswoo_org;

		check_ajax_referer('saleswoo_security','saleswooSecurity');

		if(isset($_POST['product_id'])){

			$product_id = sanitize_text_field($_POST['product_id']);
		}	

		$return = array("code" => 400, "message" => "");

		if(!empty($product_id)){

			$salesforce_prod_id = get_post_meta($product_id,'saleswoo_org_product_id', true);

			$SF_USERNAME 		= get_option("saleswoo_org_username","");
			$SF_PASSWORD 		= get_option("saleswoo_org_password","");
			$SF_SECURITY_TOKEN 	= get_option("saleswoo_org_security_token","");

			$errorEnterprise 	= "";
			try{

				$mySforceConnection = new SforcePartnerClient();
				$mySoapClient 		= $mySforceConnection->createConnection(SF_PARTNER_WSDL);
				$myLoginResult 		= $mySforceConnection->login($SF_USERNAME,$SF_PASSWORD.$SF_SECURITY_TOKEN);
			}

			catch(Exception $e){

				$e->faultstring;
				$errorEnterprise 	= $e->getMessage();

				$message 			= __('Error Establishing Connection','saleswoo-org');
				$saleswoo_org->saleswoo_org_create_log($message, $errorEnterprise);
				$return['code'] 	= 400;
				$return['message'] 	= $message;
			}

			if(empty($errorEnterprise)){

				$message 			= __('Connection Established','saleswoo-org');
				$saleswoo_org->saleswoo_org_create_log($message, $mySforceConnection);
				$return['code'] 	= 200;
				$return['message'] 	= $message;

				$delete = "";
				if(!empty($salesforce_prod_id)){

					$delete = $mySforceConnection->delete(array($salesforce_prod_id));
				}
				if(!empty($delete) && $delete[0]->success){

					$return['code'] 	= 200;
					$return['message'] 	= "Product deleted";
					delete_post_meta($product_id,'saleswoo_org_product_id');
				}
			}
		}
		echo json_encode($return);
		wp_die();
	}	

	/**
	* Upload single product on button click
	* @since 	1.0.0
	*/
	public static function saleswoo_org_upload_single_product(){

		check_ajax_referer('saleswoo_security', 'saleswooSecurity');

		$id = isset($_POST['prodid']) ? sanitize_text_field($_POST['prodid']) : "";

		$return = array('code'=>400, 'message'=>"", 'product_name'=>"");
		
		if(!empty($id)){

			$product = wc_get_product( $id );

			$product_description = wp_strip_all_tags($product->get_short_description());

			if(empty($product_description)){

				$product_description = wp_strip_all_tags($product->get_description());
			}

			$product_type = $product->get_type();

			if($product_type == "variable"){

				$variations=$product->get_available_variations();

				foreach ($variations as $value) {

					$variation_id 		= $value['variation_id'];

					$single_variation 	= wc_get_product($variation_id);

					$vartion_data 		= $single_variation->get_data();

					$variation_name 	= $vartion_data['name'];

					$variation_price 	= $single_variation->get_price();

					$variation_sku 		= get_post_meta($variation_id,'_sku',true);;

					$variation_description = $product_description;

					if(!empty($variation_price)){

						$upload_variation 	= self::saleswoo_org_upload_product($variation_id, $variation_name, $variation_description, $variation_sku, $variation_price);

						$return['code'] 		= $upload_variation['code'];
						$return['message'] 		= $upload_variation['message'];
						$return['product_name'] = $product->get_name();
					}					
				}
			}
			else{

				$product_name 		= $product->get_name();

				$product_price 		= $product->get_price();

				$product_sku 		= $product->get_sku();

				$description 		= $product_description;

				if(!empty($product_price)){

					$upload_product 	= self::saleswoo_org_upload_product($id, $product_name, $description, $product_sku, $product_price);	

					$return['code'] 		= $upload_product['code'];
					$return['message'] 		= $upload_product['message'];
					$return['product_name'] = $product_name;
				}
			}
		}
		echo json_encode($return);
		wp_die();
	}
}
