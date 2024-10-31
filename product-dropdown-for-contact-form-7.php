<?php 
/**
* Plugin Name: Product Dropdown For Contact Form 7
* Description: WooCommerce Product Dropdown List.
* Version: 1.0
* Copyright: 2023
* Text Domain: product-dropdown-for-contact-form-7
*/


if (!defined('ABSPATH')) {
    die('-1');
}

// define for base name
if (!defined('PDFCF7_BASE_NAME')) {
    define('PDFCF7_BASE_NAME', plugin_basename(__FILE__));
}

// define for plugin file
if (!defined('pdfcf7_plugin_file')) {
    define('pdfcf7_plugin_file', __FILE__);
}

if (!defined('PDFCF7_PLUGIN_DIR')) {
    define('PDFCF7_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('PDFCF7_PLUGIN_URL')) {
  define('PDFCF7_PLUGIN_URL',plugins_url('', __FILE__));
}

// Include function files
include_once(PDFCF7_PLUGIN_DIR.'includes/frontend.php');
include_once(PDFCF7_PLUGIN_DIR.'includes/admin.php');

function PDFCF7_load_admin_script(){
    wp_enqueue_media();
    wp_enqueue_style( 'jquery-backend-style', PDFCF7_PLUGIN_URL. '/admin/css/design.css', '', '1.0' );
    wp_enqueue_script( 'jquery-backend-js', PDFCF7_PLUGIN_URL . '/admin/js/design.js', array('jquery'), '1.0');
}
add_action( 'admin_enqueue_scripts', 'PDFCF7_load_admin_script' );

function PDFCF7_load_script_style(){
    wp_enqueue_script('jquery', false, array(), false, false);
    wp_enqueue_script( 'jquery-fronted-js', PDFCF7_PLUGIN_URL. '/public/js/design.js', array('jquery'), '1.0');
    wp_enqueue_style( 'jquery-fronted-select-css', PDFCF7_PLUGIN_URL. '/public/css/select2.min.css', '', '4.1.0' );
    wp_enqueue_script( 'jquery-fronted-select-js', PDFCF7_PLUGIN_URL. '/public/js/select2.min.js', '', '4.1.0');
}
add_action( 'wp_enqueue_scripts', 'PDFCF7_load_script_style' );

?>