<?php
/*
Plugin Name: Bootstrap Commerce Easy Digital Downloads Plugin
Plugin URI: http://bootstrap-commerce.com
Description: To be used with the Bootstrap Customizer Core theme
Version: 1.0
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/


require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

//check if the Bootstrap Commerce Customizer plugin is enabled
if ( is_plugin_active( 'bc-customizer/bc_customizer.php' ) ) {
  require_once dirname( __FILE__ ) . '/template-functions.php';         // Include template files for the appropriate post types etc.
  require_once dirname( __FILE__ ) . '/includes/customizer.php';        // Some Extra customizer functions
  require_once dirname( __FILE__ ) . '/templates/cart-button.php';      // The Cart button template (for the navbar)
  
  // Include the less compiler if not present
  if (!class_exists('lessc')){
    require_once dirname( __FILE__) . '/includes/lessphp/lessc.inc.php';
  }
  
  function bc_edd_enqueue_resources() {
    wp_enqueue_style('bc_edd_styles', plugins_url('assets/css/styles.css', __FILE__), false, null);
  }
  add_action('wp_enqueue_scripts', 'bc_edd_enqueue_resources', 102);
} else {
    
  // Display error message if bc-customizer is not present
  
  function bc_edd_dependencies_error() {
    $message = '<div id="message" class="error">
    <p>The <a href="">Bootstrap Commerce Customizer</a> plugin is not enabled.
    You must enable it before using the Bootstrap Commerce Easy Digital Downloads Plugin.
    You can get the Bootstrap Commerce Customizer plugin 
    <a target="_blank" href="http://bootstrap-commerce.com/downloads/downloads/bootstrap-commerce-customizer/">here</a>';
    echo "<p><strong>$message</strong></p></div>";;
  }
  add_action('admin_notices', 'bc_edd_dependencies_error');     
}