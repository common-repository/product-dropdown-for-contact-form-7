<?php 
add_action('wpcf7_admin_init','pdfcf7_woocommerce_product_tag_generator');
function pdfcf7_woocommerce_product_tag_generator($post){
    if (!class_exists('WPCF7_TagGenerator')) {
        return;
    }
    $tag_generator = WPCF7_TagGenerator::get_instance();
    $tag_generator->add( 'woocommerce_product', __( 'woocommerce_product', 'product-dropdown-for-contact-form-7' ) , 'pdwfcf7_tag_generator_woocommerce_product' );
}


function pdwfcf7_tag_generator_woocommerce_product($contact_form, $args = '' ){


	$args = wp_parse_args( $args, array() );
	
	$wpcf7_contact_form = WPCF7_ContactForm::get_current();
	$contact_form_tags = $wpcf7_contact_form->scan_form_tags();
	$type = 'woocommerce_product';
	$description = __( "Generate a form-tag for a Input woocommerce product dropdown.", 'product-dropdown-for-contact-form-7' );
	?>
	<div class="control-box">
		<fieldset>
			<legend><?php echo esc_attr($description); ?></legend>
			<table class="form-table">
				<tr>
					<th>
						<label for="<?php echo esc_attr( $args['content'] . '-filed_type' ); ?>"><?php echo esc_html( __( 'Field type', 'product-dropdown-for-contact-form-7' ) ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="required" class=" required_files" required>
						<label><?php echo esc_html( __( 'Required Field', 'product-dropdown-for-contact-form-7' ) ); ?></label>
					</td>
				</tr>
				<tr>
					<th><?php echo esc_html( __( 'Name', 'product-dropdown-for-contact-form-7' ) ); ?></th>
					<td>
						<input type="text" name="name">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id Attribute', 'product-dropdown-for-contact-form-7' ) ); ?></label></th>
					<td><input type="text" name="id" class="product_id oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class Attribute', 'product-dropdown-for-contact-form-7' ) ); ?></label></th>
					<td><input type="text" name="class" class="product_value oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
				</tr>
                <tr>
                	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Select Filter Option', 'product-dropdown-for-contact-form-7' )); ?></label></th>
                    <td>
                    	<input type="radio" name="productoptions" value="product_id"><?php echo esc_html( __( 'Product Id', 'product-dropdown-for-contact-form-7-pro' )); ?>
                    	<input type="radio" name="productoptions" value="category"><?php echo esc_html( __( 'Category', 'product-dropdown-for-contact-form-7' )); ?>
                    	<input type="radio" name="productoptions" value="tag"><?php echo esc_html( __( 'Tag', 'product-dropdown-for-contact-form-7' )); ?><br>
                    	<input type="radio" name="productoptions" value="color" disabled><?php echo esc_html( __( 'Color', 'product-dropdown-for-contact-form-7' )); ?>
                    	<input type="radio" name="productoptions" value="size" disabled><?php echo esc_html( __( 'Size', 'product-dropdown-for-contact-form-7' )); ?>
                    	<label class="pdfcf7_comman_link"><?php echo __('This Option Are Only Available in ','product-dropdown-for-contact-form-7');?> <a href="https://topsmodule.com/product/product-dropdown-for-contact-form-7/" target="_blank"><?php echo esc_html( __( 'Pro Version', 'product-dropdown-for-contact-form-7' ) ); ?></a></label>
                    </td>
                </tr>
                <tr class="product_list_id">
    				<th scope="row"></th>
    				<td>
			            <input type="text" name="pro_id" class="pro_id oneline option" id="<?php echo esc_attr( $args['content'] . '-pro_id' ); ?>"><br>
			            <label><?php echo esc_html('Use product id separated by hyphen. For eg: 21-22', 'product-dropdown-for-contact-form-7-pro'); ?></label>
		    		</td>
		    	</tr>
			    <tr class="product_category">
    				<th scope="row"></th>
    				<td>
			            <?php

			                $orderby = 'name';
			                $order = 'asc';
			                $hide_empty = true;
			                $cat_args = array(
			                    'orderby'    => $orderby,
			                    'order'      => $order,
			                    'hide_empty' => $hide_empty,
			                );

			                $product_categories = get_terms( 'product_cat', $cat_args );


			                if( !empty($product_categories) ){
			                foreach ($product_categories as $key => $category) {
			                
			            ?>
			            <input type="radio" name="category" id="<?php echo esc_attr( $args['content'] . '-category' ); ?>" value="<?php echo esc_attr($category->term_taxonomy_id);?>" class="option"> <?php echo esc_attr($category->name);?>
			            <?php } } ?>
		    		</td>
		    	</tr>
		    	<tr class="product_tag">
	                <th scope="row"></th>
	                <td>
                        <?php
                            $tag_terms = get_terms( 'product_tag' );
                            if ( ! empty( $tag_terms ) && ! is_wp_error( $tag_terms ) ){
                              foreach ( $tag_terms as $tag_term ) {
                        ?>
                       <input type="radio" name="tags" id="<?php echo esc_attr( $args['content'] . '-tags' ); ?>" value="<?php echo esc_attr($tag_term->term_taxonomy_id);?>" class="option"> <?php echo esc_attr($tag_term->name);?>
                        <?php } } ?>
	                </td>
                </tr>
                <tr>
                	<th scope="row"><label><?php echo esc_html( __( 'Select Stock Status', 'product-dropdown-for-contact-form-7' )); ?></label></th>
                    <td>
                    	<input type="radio" name="pdfcf7_stock" value="in_stock" disabled><?php echo esc_html( __( 'In Stock', 'product-dropdown-for-contact-form-7-pro' )); ?>
                        <input type="radio" name="pdfcf7_stock" value="out_stock" disabled><?php echo esc_html( __( 'Out of stock', 'product-dropdown-for-contact-form-7-pro' )); ?>
                        <label class="pdfcf7_comman_link"><?php echo __('This Option Are Only Available in ','product-dropdown-for-contact-form-7');?> <a href="https://topsmodule.com/product/product-dropdown-for-contact-form-7/" target="_blank"><?php echo esc_html( __( 'Pro Version', 'product-dropdown-for-contact-form-7' ) ); ?></a></label>
                    </td>
                </tr>
                <tr>
			      	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-multi_selection' ); ?>"><?php echo esc_html( __( 'Multiple Selection', 'product-dropdown-for-contact-form-7-pro' ) ); ?></label>
			        </th>
			      	<td>
			          <label><input type="checkbox" name="multi_selection" class="option"/> <?php echo esc_html( __( 'Allow Multiple Product Selection', 'product-dropdown-for-contact-form-7-pro' ) ); ?>
			        </td>
		    	</tr>
		    	<tr>
			      	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-enable_price' ); ?>"><?php echo esc_html( __( 'Show Price', 'product-dropdown-for-contact-form-7-pro' ) ); ?></label>
			        </th>
			      	<td>
			          <label><input type="checkbox" name="enable_price" class="option" disabled/> <?php echo esc_html( __( 'Enable / Disable Product Price', 'product-dropdown-for-contact-form-7-pro' ) ); ?><br>
			          <label class="pdfcf7_comman_link"><?php echo __('This Option Are Only Available in ','product-dropdown-for-contact-form-7');?> <a href="https://topsmodule.com/product/product-dropdown-for-contact-form-7/" target="_blank"><?php echo esc_html( __( 'Pro Version', 'product-dropdown-for-contact-form-7' ) ); ?></a></label>
			        </td>
		    	</tr>
		    	<tr>
			      	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-enable_search' ); ?>"><?php echo esc_html( __( 'Search Box', 'product-dropdown-for-contact-form-7-pro' ) ); ?></label>
			        </th>
			      	<td>
			          <label><input type="checkbox" name="enable_search" class="option" disabled/> <?php echo esc_html( __( 'Enable / Disable Search Product', 'product-dropdown-for-contact-form-7-pro' ) ); ?><br>
			          <label class="pdfcf7_comman_link"><?php echo __('This Option Are Only Available in ','product-dropdown-for-contact-form-7');?> <a href="https://topsmodule.com/product/product-dropdown-for-contact-form-7/" target="_blank"><?php echo esc_html( __( 'Pro Version', 'product-dropdown-for-contact-form-7' ) ); ?></a></label>
			        </td>
		    	</tr>
			</table>
		</fieldset>
	</div>
	<div class="insert-box"> 
		<input type="text" name="<?php echo esc_attr($type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
		<div class="submitbox">
			<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'product-dropdown-for-contact-form-7' ) ); ?>" />
		</div>
		<br class="clear" />
		<p class="description mail-tag">
			<label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'product-dropdown-for-contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?>
				<input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" />
			</label>
		</p>
	</div>
	<?php
	}
?>
