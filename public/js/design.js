jQuery(document).ready(function(){
  jQuery('.wpcf7-woocommerce_product').each(function() {
    jQuery(this).select2({
      placeholder: "--- Select Product ---",
      minimumResultsForSearch: -1,
    });
  });
});