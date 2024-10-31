<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mwb_Salesforce_Woocommerce_Integration
 * @subpackage Mwb_Salesforce_Woocommerce_Integration/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Salesforce_Woocommerce_Integration_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		$log_enable = get_option('saleswoo_org_log_enable', 'no');

		if ($log_enable == 'yes') {
		
			unlink( WC_LOG_DIR.'saleswoo-org-logs.log' );
		}
	}

}
