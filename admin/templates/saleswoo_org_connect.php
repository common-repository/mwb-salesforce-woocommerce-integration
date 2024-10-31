<?php

global $saleswoo_org;

if(isset($_POST['saleswoo_connect_org']) && check_admin_referer('saleswoo-settings')){

	unset($_POST['saleswoo_connect_org']);

	woocommerce_update_options( Mwb_Salesforce_Woocommerce_Integration_Admin::saleswoo_org_connect_tab_fields() );

	$message = __( 'Settings saved successfully.' , 'saleswoo-org' );

	$saleswoo_org->saleswoo_org_notice( $message, 'success' );
}
if($saleswoo_org->is_org_integration_enabled() && !$saleswoo_org->saleswoo_org_account_verified() && !empty(get_option('saleswoo_org_username','')) && !empty('saleswoo_org_password') && !empty('saleswoo_org_security_token')){
	?>
	<span class="saleswoo_oauth_span">
	<label><?php _e('Please Click this button to Authorize with Salesforce.','saleswoo-org'); ?></label>
	<input type="submit" id="saleswoo_org_verify" value="<?php _e("Authorize","saleswoo-org")?>" class="button-primary" />
	</span>
	<?php
}
if($saleswoo_org->saleswoo_org_account_verified()){
	?>
	<div class="saleswoo-connection-container">
		<form class="saleswoo-connect-form" action="" method="post">
		    <?php woocommerce_admin_fields( Mwb_Salesforce_Woocommerce_Integration_Admin::saleswoo_connect_tab_fields_display() ); ?>
		    <div class="saleswoo-connect-form-submit">
			    <p class="submit">
			        <input type="submit" name="saleswoo_connect_org" value="<?php _e("Save","saleswoo-org")?>" class="button-primary" />
			    </p>
			    <?php wp_nonce_field( 'saleswoo-settings' ); ?>
		    </div>
	    </form>
	</div>
<?php
}
else{
	?>
	<div class="saleswoo-connection-container">
		<form class="saleswoo-connect-form" action="" method="post">
		    <?php woocommerce_admin_fields( Mwb_Salesforce_Woocommerce_Integration_Admin::saleswoo_org_connect_tab_fields() ); ?>
		    <div class="saleswoo-connect-form-submit">
			    <p class="submit">			        
			    	<input type="submit" name="saleswoo_connect_org" value="<?php _e("Save","saleswoo-org")?>" class="button-primary" />
			    </p>
			    <?php wp_nonce_field( 'saleswoo-settings' ); ?>
		    </div>
	    </form>
	</div>
	<?php
}
?>
<div class="saleswoo_pop_up_wrap" id="saleswoo_pop_up_wrap" style="display: none">
	<div class="pop_up_sub_wrap">
		<p>
			<?php _e('Congratulations! Your are now connected to your Salesforce Account.','saleswoo-org'); ?>
		</p>
		<div class="button_wrap">
			<a href="javascript:void(0);" class="saleswoo_org_next_step"><?php _e('Proceed to Next Step','saleswoo-org'); ?></a>
		</div>
	</div> 
</div>

<div class="saleswoo_pop_up_wrap" id="saleswoo_pop_up_wrap1" style="display: none">
	<div class="pop_up_sub_wrap">
		<p>		
			<?php _e('How to get Salesforce Security Token ?', 'saleswoo-org'); ?>
		</p>
		<p>		
			<?php _e('Login to your organisation and Navigate to the top navigation bar go to "your name" <strong>My Settings > Personal  >  Reset My Security Token.</strong>', 'saleswoo-org'); ?>
		</p>
		<div class="button_wrap">
			<a href="javascript:void(0);" class="saleswoo_token_continue"><?php _e('Continue','saleswoo-org'); ?></a>
		</div>
	</div> 
</div>