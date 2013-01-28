<?php
/*
Plugin Name: Shoestrap EDD Addon
Plugin URI: http://shoestrap.org
Description: This plugin adds the necessary templates and functions to the shoestrap theme
Version: 1.23
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

require_once dirname( __FILE__ ) . '/template-functions.php';             // Include template files for the appropriate post types etc.
require_once dirname( __FILE__ ) . '/includes/customizer/customizer.php'; // Some Extra customizer functions
require_once dirname( __FILE__ ) . '/templates/cart-button.php';          // The Cart button template (for the navbar)
require_once dirname( __FILE__ ) . '/includes/updater/licencing.php';     // Licencing to provide automatic updates
    
function shoestrap_enqueue_resources() {
  wp_enqueue_style('shoestrap_styles_edd', plugins_url('assets/css/styles.css', __FILE__), false, null);
}
add_action('wp_enqueue_scripts', 'shoestrap_enqueue_resources', 102);

function shoestrap_edd_sl_show_key_in_history( $payment_id, $purchase_data ) {

  $licensing = $GLOBALS['EDD_Software_Licenseing'];
  $downloads = edd_get_downloads_of_purchase( $payment_id, $purchase_data );
  if( $downloads) :
    echo '<script>$(document).ready(function() { $(function () { $(".edd_sl_show_key").popover() }) }); </script>';
    echo '<style>.popover.top{width: auto !important;}</style>';
    echo '<td class="edd_license_key">';
      foreach( $downloads as $download ) {
        $license = $licensing->get_license_by_purchase( $payment_id, $download['id'] );
        if( $license ) {
          echo '<div class="edd_sl_license_wrap alert alert-info"><small>';
            $key = $licensing->get_license_key( $license->ID );
            echo get_the_title( $download['id'] ) . ' Licence Key: <p>' . $key . '</p>';
          echo '</small></div>';
        }
      }
    echo '</td>';
  endif;
}
remove_action( 'edd_purchase_history_row_end', 'edd_sl_show_key_in_history', 10, 2 );
