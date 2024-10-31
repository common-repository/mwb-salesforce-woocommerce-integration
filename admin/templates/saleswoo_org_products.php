<?php
global $saleswoo_org;
?>
<div id="saleswoo-setup-process" style="display:none;">
	<div class="popupwrap">
      	<p>
		  <?php _e('We are uploading products from your store to Salesforce.', 'saleswoo-org')?>
		  <?php _e('Please do not navigate or reload the page before our confirmation message.','saleswoo-org')?>
		</p>
        <div class="saleswoo-message-area">
		</div>
		
    </div>
</div>
<?php
if(!$saleswoo_org->is_org_products_uploaded()){
	?>
	<div class="saleswoo-settings-container">
		<div class="saleswoo-general-settings">
			<div class="saleswoo-fields-header saleswoo-common-header">
	            <h2><?php _e("Upload Products to Salesforce","saleswoo-org") ?></h2>
	        </div>
	        <form method="post" action="" id="otrawoo-contact-record">
	        	<div class="saleswoo-order-status">
	        		<label for="saleswoo-org-upload-products"><?php _e("Start Uploading Products to Salesforce  ",'saleswoo-org');?></label>
					<a id="saleswoo-org-upload-products" href="javascript:void(0)" class="button button-primary"> <?php _e( 'Upload Now', 'saleswoo-org' )?> </a>	
	        	</div>
	        </form>
		</div>
	</div>
<?php
}   
else{
	?>
	<div class="saleswoo_data_table">
		<div class="saleswoo_heading_wrap">
			<p class="saleswoo_table_heading">
				<h2><?php _e("Uploaded Product Details","saleswoo-org");?></h2>
			</p>
		</div>
		<?php include SALESWOO_ABSPATH.'admin/templates/saleswoo_org_product_table.php';?>
	</div>
	<?php
} 
?>
<div class="saleswoo_pop_up_wrap" id="saleswoo_pop_up_wrap" style="display: none">
	<div class="pop_up_sub_wrap" style="min-height: 0px;">
		<p class="pop_up_text">
		</p>
		<div class="button_wrap">
			<a href="javascript:void(0);" style="width: 35%;" class="saleswoo_okay"><?php _e('Continue','saleswoo-org'); ?></a>
		</div>
	</div> 
</div>
