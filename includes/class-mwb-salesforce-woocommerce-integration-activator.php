<?php

/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Salesforce_Woocommerce_Integration_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$log_enable = get_option('saleswoo_org_log_enable', 'no');

		if ($log_enable == 'yes') {
			
			@fopen( WC_LOG_DIR.'saleswoo-org-logs.log', 'a' );
		}
	}

}
