(function( $ ) {
	'use strict';
 
	var ajaxUrl 					= saleswooi18n.ajaxUrl;
	var productCreated 				= saleswooi18n.productCreated;
	var productsUploaded 			= saleswooi18n.productsUploaded;
	var saleswooFieldsTab		 	= saleswooi18n.saleswooFieldsTab;
	var saleswooSecurity 			= saleswooi18n.saleswooSecurity;
	var productNotCreated 			= saleswooi18n.productNotCreated;
	var saleswooNoProducts 			= saleswooi18n.saleswooNoProducts;
	var saleswooConnectTab 			= saleswooi18n.saleswooConnectTab;
	var saleswooDeleteFail 			= saleswooi18n.saleswooDeleteFail;
	var saleswooUploadFail 			= saleswooi18n.saleswooUploadFail;
	var saleswooDeleteSuccess 		= saleswooi18n.saleswooDeleteSuccess;
	var saleswooUploadSuccess 		= saleswooi18n.saleswooUploadSuccess;
	var saleswooProductCreated 		= saleswooi18n.saleswooProductCreated;

	jQuery(document).ready(function(){

		// Click on Get Started button
		jQuery('a#saleswoo-get-started').on("click",function(e){
			e.preventDefault();
			jQuery('#saleswoo_org_loader').show();
			jQuery.post( ajaxUrl,{ 'action' : 'saleswoo_org_get_started_call', 'saleswooSecurity' : saleswooSecurity, async: false }, function( status ){
				window.location.href = saleswooConnectTab;
			});
		});

		// Get token information
		jQuery('#saleswoo_token_info').on('click',function(){

			jQuery('#saleswoo_pop_up_wrap1').show();

			jQuery('a.saleswoo_token_continue').on('click',function(){

				jQuery('#saleswoo_pop_up_wrap1').hide();
			});
		});

		// verify Salesfrce Account
		jQuery('#saleswoo_org_verify').on('click',function(){

			jQuery('#saleswoo_org_loader').show();

			jQuery.post(ajaxUrl, {'action' : 'saleswoo_org_verify_account', 'saleswooSecurity': saleswooSecurity}, function(response){
				
				response = jQuery.parseJSON(response);

				if(response.code == 200 && response.message == "Connection Established"){
					jQuery('#saleswoo_org_loader').hide();
					jQuery('#saleswoo_pop_up_wrap').show();
				}
			});
		});

		//Click on next step button
		jQuery('a.saleswoo_org_next_step').on("click", function(e) {

			jQuery('#saleswoo_org_loader').show();
			window.location.href = saleswooFieldsTab;
		});

		// Upload Products
		jQuery('#saleswoo-org-upload-products').on('click',function(e){

			jQuery('#saleswoo-setup-process').show();

			jQuery.post(ajaxUrl,{'action' : 'saleswoo_org_get_products_count','saleswooSecurity' : saleswooSecurity},function(count){

				if(count > 0){

					var total_count = count;
					var offset = 0;
					var msg = "";

					while(offset < total_count){

						jQuery.ajax( {url : ajaxUrl, dataType:'json', type : 'POST', async:false , data : {'action': 'saleswoo_org_create_product', 'offset' : offset , 'saleswooSecurity' : saleswooSecurity}}).done(function(response){

							if(response.code == 200){

								msg = "<div class='notice updated'><p> " + productCreated + "<strong>" + response.product_name +  "</strong></p></div>";
							}
							else{
								msg = "<div class='notice error'><p> "+ productNotCreated + response.product_name +  " </p></div>";

							}

							jQuery('.saleswoo-message-area').append(msg);
						});

						offset += 1;
					}

					// Mark product uploaded complete
					jQuery.post(ajaxUrl, {action: 'saleswoo_org_products_uploaded','saleswooSecurity' : saleswooSecurity}, function(product_uploaded){

						alert(productsUploaded);

						location.reload();
					});

				}
				else{

					alert(saleswooNoProducts);
					location.reload();
				}
			});
		});

		// Delete single Product
		jQuery(document).on('click','#saleswoo_single_product',function(){
			var product_id = $(this).data('prodid');

			jQuery('#saleswoo_org_loader').show();

			jQuery.ajax( {url : ajaxUrl, dataType : 'json', type : 'POST', async : false, data : {'action' : 'saleswoo_org_delete_single_product','saleswooSecurity' : saleswooSecurity, 'product_id' : product_id}}).done(function(response){

				if(response.code == 200){
					jQuery('#saleswoo_org_loader').hide();
					jQuery('.pop_up_text').html(saleswooDeleteSuccess);
					jQuery('#saleswoo_pop_up_wrap').show();

				}
				else{
					jQuery('#saleswoo_org_loader').hide();
					jQuery('.pop_up_text').html(saleswooDeleteFail);
					jQuery('#saleswoo_pop_up_wrap').show();
				}
			});
		});	
		
		// Click on pop up button
		jQuery('a.saleswoo_okay').on('click',function(){

			location.reload();
		});

		// Upload single Product
		jQuery(document).on('click','#saleswoo_single_product_upload',function(){

			jQuery('#saleswoo_org_loader').show();

			var product_id = $(this).data('prodid');

			jQuery.ajax( { url : ajaxUrl, dataType : 'json', type : 'POST', async : false, data: {'action' : 'saleswoo_org_upload_single_product', 'prodid' : product_id, 'saleswooSecurity' : saleswooSecurity}}).done(function(response){

				if(response.code == 200){
					jQuery('#saleswoo_org_loader').hide();

					jQuery('.pop_up_text').html(saleswooUploadSuccess);
					jQuery('#saleswoo_pop_up_wrap').show();

				}
				else{
					jQuery('#saleswoo_org_loader').hide();

					jQuery('.pop_up_text').html(saleswooUploadFail);
					jQuery('#saleswoo_pop_up_wrap1').show();
				}
			});
		});
	});

})( jQuery );
