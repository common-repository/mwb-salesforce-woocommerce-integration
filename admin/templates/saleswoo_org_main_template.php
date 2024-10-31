<?php

if ( ! defined ( 'ABSPATH' ) ) {

     exit (); // Exit if accessed directly
}
     
global $saleswoo_org;
$active_tab = isset( $_GET['saleswoo_org_tab'] ) ? filter_var($_GET['saleswoo_org_tab'],FILTER_SANITIZE_URL) : 'saleswoo_org_overview';
$default_tabs = $saleswoo_org->saleswoo_org_default_tabs();
?>
<div class="saleswoo-go-pro">
	<div class="saleswoo-go-pro-banner">
		<div class="saleswoo-inner-container">
			<div class="saleswoo-name-wrapper"><p><?php _e("MWB Salesforce WooCommerce Integration", "saleswoo-org") ?></p></div>
			<div class="saleswoo-static-menu">
				<ul>
					<li><a href="https://makewebbetter.com/contact-us/" target="_blank"><?php _e("Contact US", "saleswoo-org")?></a></li>
					<li><a href="https://docs.makewebbetter.com/salesforce-woocommerce-integration/" target="_blank"><?php _e("Go to Docs", "saleswoo-org") ?></a></li>
					<li class="saleswoo-main-menu-button"><a id="saleswoo-go-pro-link" href="https://makewebbetter.com/product/salesforce-woocommerce-integration-pro" class="" title="" target="_blank"><?php _e("GO PRO NOW", "saleswoo-org")?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="saleswoo-main-template"> 
     <div class="saleswoo-header-template">
          <div class="saleswoo-salesforce-icon">
               <img width="90px" height="90px" src="<?php echo SALESWOO_URL . 'admin/images/salesforce-icon.png' ?>" class=""/>
          </div>
          <div class="saleswoo-header-text">
               <h2><?php _e( "MWB Salesforce WooCommerce Integration", "saleswoo-org" ) ?></h2>
          </div>
          <div class="saleswoo-woo-icon">
               <img width="90px" height="90px" src="<?php echo SALESWOO_URL . 'admin/images/woo-icon.png' ?>" class=""/>
          </div>
     </div>
     <div class="saleswoo-body-template">
          <div class="saleswoo-navigator-template">
               <div class="saleswoo-navigations">
                    <?php
					if( is_array( $default_tabs ) && count( $default_tabs ) ) {

						foreach( $default_tabs as $tab_key => $single_tab ) {

							$tab_classes = "saleswoo-nav-tab";
							
							$dependency = $single_tab["dependency"];

							if( !empty( $active_tab ) && $active_tab == $tab_key ) {
								
								$tab_classes .= " nav-tab-active";
							} 
							
							if( $tab_key == "saleswoo_org_account" || $tab_key == "saleswoo_org_contract" || $tab_key == "saleswoo_org_contact" || $tab_key == "icontact_woo_ocs" || $tab_key == "saleswoo_org_lead" || $tab_key == "saleswoo_org_opportunity" || $tab_key == "saleswoo_org_order" || $tab_key == "saleswoo_org_settings" ){

								if( !empty( $dependency ) && !$saleswoo_org->check_dependencies( $dependency ) ) {

									$tab_classes .= " saleswoo-disabled";
									$tab_classes .= " saleswoo-lock";
									?>
										<div class="saleswoo-tabs"><a class="<?php echo $tab_classes; ?>" id="<?php echo $tab_key; ?>" href="javascript:void(0);"><?php echo $single_tab["name"]; ?><img src="<?php echo SALESWOO_URL . 'admin/images/lock.png' ?>"></a></div>
									<?php
								}
								else {

									$tab_classes .= " saleswoo-lock";
									?>
										<div class="saleswoo-tabs"><a class="<?php echo $tab_classes; ?>" id="<?php echo $tab_key; ?>" href="<?php echo admin_url('admin.php?page=saleswoo_org').'&saleswoo_org_tab='.$tab_key; ?>"><?php echo $single_tab["name"]; ?><img src="<?php echo SALESWOO_URL . 'admin/images/lock.png' ?>"></a></div>
									<?php
								}
							}
							else{
								if( !empty( $dependency ) && !$saleswoo_org->check_dependencies( $dependency ) ) {
									
									$tab_classes .= " saleswoo-disabled";
									?>
										<div class="saleswoo-tabs"><a class="<?php echo $tab_classes; ?>" id="<?php echo $tab_key; ?>" href="javascript:void(0);"><?php echo $single_tab["name"]; ?></a></div>
	
									<?php
								}
								else {
	
									?>
										<div class="saleswoo-tabs"><a class="<?php echo $tab_classes; ?>" id="<?php echo $tab_key; ?>" href="<?php echo admin_url('admin.php?page=saleswoo_org').'&saleswoo_org_tab='.$tab_key; ?>"><?php echo $single_tab["name"]; ?></a></div>
	
									<?php
								}
							}
						}
					}
				?>
               </div>
          </div>
          <div class="saleswoo-content-template">
               <div class="saleswoo-content-container">
                    <?php
                         // if submenu is directly clicked on woocommerce.
	                     if( empty( $active_tab ) ){

	                        $active_tab = "saleswoo_overview";
	                     }
	                     
	                     $tab_content_path = 'admin/templates/'.$active_tab.'.php';
	                     
	                     $saleswoo_org->load_template_view( $tab_content_path );
                        
                    ?>
               </div>
          </div>
     </div>
     <div style="display: none;" class="loading-style-bg" id="saleswoo_org_loader">
          <img src="<?php echo SALESWOO_URL;?>admin/images/loader.gif">
     </div>
</div>