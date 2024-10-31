jQuery( document ).ready(function() {
	// console.log("product backend");
	jQuery(".product_list_id").hide();
	jQuery(".product_category").hide();
	jQuery(".product_tag").hide();

	jQuery('body').on('change', function (argument) {
		var product_options = jQuery('input[name="productoptions"]:checked').val();

		if(product_options == 'product_id'){
			jQuery(".product_list_id").show(); 
			jQuery(".product_category").hide(); 
			jQuery(".product_tag").hide(); 
		}
		if(product_options == 'category'){
			jQuery(".product_category").show(); 
			jQuery(".product_tag").hide(); 
			jQuery(".product_list_id").hide();
		}
		if(product_options == 'tag'){
			jQuery(".product_tag").show(); 
			jQuery(".product_category").hide(); 
			jQuery(".product_list_id").hide();
		}
	});

	jQuery('#pscfw_image_upload_button').click(function() {
        var customUploader = wp.media({
            title: 'Choose Image',
            button: {
              text: 'Choose Image'
            },
            multiple: false
        });

        customUploader.on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            jQuery('#pscfw_cart_image').val(attachment.url);
            jQuery('#pscfw_image_upload_button').hide();
            jQuery('#pscfw_image_remove_button').show();
        });

        customUploader.open();
    });
});