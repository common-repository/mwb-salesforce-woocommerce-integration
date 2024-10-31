<?php
$GLOBALS['hide_save_button']  = true;
?>
<div class="saleswoo-overview-wrapper">
    <div class="saleswoo-overview-header saleswoo-common-header">
        <h2><?php _e("How our Integration works?", "saleswoo-org") ?></h2>
    </div>
    <div class="saleswoo-overview-body">
        <div class="saleswoo-what-we-do saleswoo-overview-container">
            <h4><?php _e( "What we upload?", "saleswoo-org" );?></h4>
            <div class="saleswoo-custom-fields">
                <a class="saleswoo-anchors" href="#"><?php _e( "Products","saleswoo-org")?></a>
            </div>
            <p class="saleswoo-desc-num">1</p>
        </div>
        <div class="saleswoo-how-easy-to-setup saleswoo-overview-container">
            <h4><?php _e( "How easy is it?", "saleswoo-org" );?></h4>
            <div class="saleswoo-setup">
                <a class="saleswoo-anchors" href="#"><?php _e( "Just 1 steps to Go!","saleswoo-org")?></a>
            </div>
            <p class="saleswoo-desc-num">2</p>
        </div>
        <div class="saleswoo-what-you-achieve saleswoo-overview-container">
            <h4><?php _e( "What at the End?", "saleswoo-org" );?></h4>
            <div class="saleswoo-automation">
                <a class="saleswoo-anchors" href="#"><?php _e( "Product Details on Salesforce","saleswoo-org")?></a>
            </div>
            <p class="saleswoo-desc-num">3</p>
        </div>
    </div>
    <div class="saleswoo-overview-footer">
        <div class="saleswoo-overview-footer-content-2 saleswoo-footer-container">
            
            <?php
                if( get_option( 'saleswoo_org_get_started', false ) ) {
                    ?>
                        <a href="?page=saleswoo_org&saleswoo_org_tab=saleswoo_org_connect" class="saleswoo-overview-get-started"><?php echo __( 'Next', 'saleswoo-org' ) ?></a>
                    <?php
                }
                else {
                    ?>
                        <img width="40px" height="40px" src="<?php echo SALESWOO_URL . 'admin/images/right-direction-icon.png' ?>"/>
                        <a id="saleswoo-get-started" href="javascript:void(0)" class="saleswoo-overview-get-started"><?php echo __( 'Get Started', 'saleswoo-org' ) ?></a>
                    <?php
                }
            ?>
        </div>
    </div>
</div>