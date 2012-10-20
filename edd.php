<?php
/*
Plugin Name: Bootstrap Commerce Easy Digital Downloads Plugin
Plugin URI: http://bootstrap-commerce.com
Description: To be used with the Bootstrap Customizer Core theme
Version: 1.0
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

require_once dirname( __FILE__ ) . '/template-functions.php';           // Include template files for the appropriate post types etc.
require_once dirname( __FILE__ ) . '/includes/customizer-output.php';   // Some Extra customizer functions
require_once dirname( __FILE__ ) . '/templates/cart-button.php';        // The Cart button template (for the navbar)


function bc_edd_enqueu_resources() {
  wp_enqueue_style('bc_edd_styles', plugins_url('assets/css/styles.css', __FILE__), false, null);
}
add_action('wp_enqueue_scripts', 'bc_edd_enqueu_resources', 102);
