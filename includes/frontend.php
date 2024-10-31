<?php 
add_action( 'wpcf7_init' , 'pdfcf7_add_form_tag_woocommerce_product' , 10, 0 );
function pdfcf7_add_form_tag_woocommerce_product() {
	wpcf7_add_form_tag( array( 'woocommerce_product', 'woocommerce_product*' ), 'pdfcf7_woocommerce_product_tag_handler',array('name-attr' => true) );
}

function pdfcf7_woocommerce_product_tag_handler($tag){
	if ( empty( $tag->name ) ) {
		return '';
	}

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type );

	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}

	$atts = array();

	$class = $atts['class'] = $tag->get_class_option( $class );
	$id = $atts['id'] = $tag->get_id_option();
	$cat_id = $tag->get_option( 'category', '', true );
	$tags_id = $tag->get_option( 'tags', '', true );
	$in_stock = $tag->get_option( 'in_stock', '', true );
	$outofstock = $tag->get_option( 'out_of_stock', '', true );
	$multi_selection = $tag->has_option( 'multi_selection' );
	$pro_id = $tag->get_option('pro_id', '', true);
    $pro_ids = explode('-', $pro_id);

	if ( $tag->has_option( 'readonly' ) ) {
		$atts['readonly'] = 'readonly';
	}

	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';

	}

	if ( $validation_error ) {
		$atts['aria-invalid'] = 'true';
		$atts['aria-describedby'] = wpcf7_get_validation_error_reference(
			$tag->name
		);
	} else {
		$atts['aria-invalid'] = 'false';
	}

	$atts['name'] = $tag->name;
	$atts['type'] = 'hidden';

	$atts = wpcf7_format_atts( $atts );

	if(!empty($pro_id) && empty($cat_id) && empty($tags_id)) {
    	$new_post = get_posts(array(
	        'post_type' => 'product',
	        'post_status' => 'publish',
	        'numberposts' => -1,
	        'post__in' => $pro_ids,
	    ));
	}else if(!empty($cat_id) && empty($pro_id) && empty($tags_id)) {
		$new_post = get_posts(array(
	        'post_type'      => 'product',
	        'post_status' => 'publish',
	        'numberposts' => -1,
	        'tax_query' => array(
	            array(
		            'taxonomy' => 'product_cat',
		            'field' => 'term_id',
		            'terms' => $cat_id
	            )
	        )
    	));
	}else if(!empty($tags_id) && empty($pro_id) && empty($cat_id)) {
		$new_post = get_posts(array(
	        'post_type'      => 'product',
	        'post_status' => 'publish',
	        'numberposts' => -1,
	        'tax_query' => array(
	            array(
		            'taxonomy' => 'product_tag',
		            'field' => 'term_id',
		            'terms' => $tags_id
	            )
	        )
    	));
	}else{
    	$new_post = get_posts(array(
	        'post_type'      => 'product',
	        'post_status' => 'publish',
	        'numberposts' => -1,
    	));
    }

    if($multi_selection){
		$name = $tag->name.'[]';
	}else{
		$name = $tag->name;
	}

	$multiple_select = $multi_selection ? 'multiple' : '';

   	$html ='<div class="pdfcf7_woocommerce_product wpcf7-form-control-wrap" data-name="' . $tag->name . '">';
	$html = $html . '<select name="'.$tag->name.'" id="'.$id.'" class="'.$class.'" '.$multiple_select.'>';
	foreach($new_post as $pro_post){
		$pro_data = wc_get_product($pro_post);
	    $product_id= $pro_post->ID;
	    $product_name = $pro_post->post_title;
	    
		$html .= '<option value="' . $product_name . ' (product_id: ' . $product_id . ')">' . $product_name . '</option>';
	}
	$html = $html . '</select>';
	$html = $html . '</div>';
	return $html;
}

add_filter( 'wpcf7_validate_woocommerce_product' , 'pdfcf7_woocommerce_product_validation_filter' , 10, 2 );
add_filter( 'wpcf7_validate_woocommerce_product*' , 'pdfcf7_woocommerce_product_validation_filter' , 10, 2 ); 
function pdfcf7_woocommerce_product_validation_filter( $result, $tag ) {
    $pdfcf7data = sanitize_text_field($_POST[$tag->name]);

    $value = isset( $_POST[$tag->name] )    ? sanitize_text_field(trim( strtr( (string) $pdfcf7data, "\n", " " ) )) : '';
    if ( 'woocommerce_product' == $tag->basetype ) {
        if ( $tag->is_required() and '' === $value ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        }
    }
    return $result;
}