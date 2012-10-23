<?php
/*
Plugin Name: Shoestrap EDD Addon
Plugin URI: http://bootstrap-commerce.com
Description: This plugin adds the necessary templates and functions to the shoestrap theme
Version: 1.0
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

// Check if the Shoestrap theme is enabled.
// Only process this plugin if the enabled theme is called shoestrap
$shoestrap_enabled = wp_get_theme( 'shoestrap' );
if ( $shoestrap_enabled->exists() ) {
  
  require_once dirname( __FILE__ ) . '/template-functions.php';             // Include template files for the appropriate post types etc.
  require_once dirname( __FILE__ ) . '/includes/customizer/customizer.php'; // Some Extra customizer functions
  require_once dirname( __FILE__ ) . '/templates/cart-button.php';          // The Cart button template (for the navbar)
  require_once dirname( __FILE__ ) . '/includes/updater/licencing.php';     // Licencing to provide automatic updates
    
  // Include the less compiler if not present
  if (!class_exists('lessc')){
    require_once dirname( __FILE__) . '/includes/lessphp/lessc.inc.php';
  }
  
  function shoestrap_enqueue_resources() {
    wp_enqueue_style('shoestrap_styles', plugins_url('assets/css/styles.css', __FILE__), false, null);
  }
  add_action('wp_enqueue_scripts', 'shoestrap_enqueue_resources', 102);
}