<?php
/*
Plugin Name: Shoestrap EDD Addon
Plugin URI: http://bootstrap-commerce.com
Description: This plugin adds the necessary templates and functions to the shoestrap theme
Version: 1.22
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

// Check if the Shoestrap theme is enabled.
// Only process this plugin if the enabled theme is called shoestrap
$shoestrap_enabled = wp_get_theme( 'shoestrap' );
if ( $shoestrap_enabled->exists() && function_exists( 'edd_get_checkout_uri' ) ) {
  
  require_once dirname( __FILE__ ) . '/template-functions.php';             // Include template files for the appropriate post types etc.
  require_once dirname( __FILE__ ) . '/includes/customizer/customizer.php'; // Some Extra customizer functions
  require_once dirname( __FILE__ ) . '/templates/cart-button.php';          // The Cart button template (for the navbar)
  require_once dirname( __FILE__ ) . '/includes/updater/licencing.php';     // Licencing to provide automatic updates
    
  // Include the less compiler if not present
  if (!class_exists('lessc')){
    require_once dirname( __FILE__) . '/includes/lessphp/lessc.inc.php';
  }
  
  function shoestrap_enqueue_resources() {
    wp_enqueue_style('shoestrap_styles_edd', plugins_url('assets/css/styles.css', __FILE__), false, null);
  }
  add_action('wp_enqueue_scripts', 'shoestrap_enqueue_resources', 102);
}

/*
 * Take care of error reports in case dependencies are not met
 */
function shoestrap_edd_activation_error() {
  global $wp_version;
  $wp_version         = get_bloginfo( 'version' );    // Determine WordPress version
  $enabled_theme      = wp_get_theme();
  $shoestrap_enabled  = wp_get_theme( 'shoestrap' );  // Determine if the Shoestrap theme is enabled
  $shoestrap_version  = $enabled_theme->Version;

  // WordPress version is greater than or equal to 3.4
  if ( $wp_version <= 3.4 ) {
    // The enabled theme is shoestrap
    if ( $shoestrap_enabled -> exists() ) {
      // The enabled theme is shoestrap but Easy Digital Downloads is not enabled
      if ( !function_exists( 'edd_get_checkout_uri' ) ){
        $message = '<div class="error">
        <p>You must have both the <a href="http://bootstrap-commerce.com/downloads/downloads/shoestrap/" target="_blank">Shoestrap</a>
        theme and the <a href="http://easydigitaldownloads.com" target="_blank">Easy Digital Downloads</a> plugin enabled 
        in order to use the "Shoestrap EDD Addon" plugin.
        Though activated, the "Shoestrap EDD Addon" plugin will not have any impact to your site until you enable the above dependencies.</p>
        </div>';
      }
    } else {
      // The enabled theme is NOT shoestrap and Easy Digital Downloads is enabled
      if ( function_exists( 'edd_get_checkout_uri' ) ) {
        $message = '<div class="error">
        <p>You must have both the <a href="http://bootstrap-commerce.com/downloads/downloads/shoestrap/" target="_blank">Shoestrap</a>
        theme and the <a href="http://easydigitaldownloads.com" target="_blank">Easy Digital Downloads</a> plugin enabled 
        in order to use the "Shoestrap EDD Addon" plugin.
        Though activated, the "Shoestrap EDD Addon" plugin will not have any impact to your site until you enable the above dependencies.</p>
        </div>';
      } else {
        // The enbled theme is NOT shoestrap and Easy Digital Downloads is NOT enabled
        $message = '<div class="error">
        <p>You must have both the <a href="http://bootstrap-commerce.com/downloads/downloads/shoestrap/" target="_blank">Shoestrap</a>
        theme and the <a href="http://easydigitaldownloads.com" target="_blank">Easy Digital Downloads</a> plugin enabled 
        in order to use the "Shoestrap EDD Addon" plugin.
        Though activated, the "Shoestrap EDD Addon" plugin will not have any impact to your site until you enable the above dependencies.</p>
        </div>';
      }
    }
  } else {
    // WordPress version is lower than 3.4
    $message = '<div class="error">
    <p>The "Shoestrap EDD Addon is not compatible with WordPress versions prior to version 3.4"</p>
    </div>';
  }

  if ( $shoestrap_version == '1.0.2' || $shoestrap_version == '1.0.1' || $shoestrap_version == '1.0.0' || $shoestrap_version == '1.0') {
    
    $license_key = trim( get_option( 'shoestrap_edd_license_key' ) );
    $licence_url = admin_url( 'themes.php?page=shoestrap-license' );
    
    echo '<div class="error">
    <p> This version of the "Shoestrap EDD Addon" plugin requires <a href="http://bootstrap-commerce.com/downloads/downloads/shoestrap/" target="_blank">Shoestrap</a> version 1.1.
    Please visit <a href="http://bootstrap-commerce.com/downloads/downloads/shoestrap/" target="_blank">this page</a> to download the newest version.</p>';
    
    if ( strlen( $license_key ) <= 3 ) {
      echo '<p>We recommend you add your licence key (sent to your email when you get the shoestrap theme) and activate it on <a href="' . $licence_url . '"> this page </a>
      to get automatic update notifications about any future theme updates.</p>';
    }
    echo '</div>';
  }
  // If all dependencies are met, take no action
  if ( $shoestrap_enabled -> exists() && function_exists( 'edd_get_checkout_uri' ) && $wp_version >= 3.4 ) {
  } else {
    // If the dependencies are not met, echo the message
    echo $message;
  }
}
add_action('admin_notices', 'shoestrap_edd_activation_error');

function shoestrap_edd_phpless() {
  $less = new lessc;
  // $less->setFormatter( "compressed" );

  $less->checkedCompile( dirname( __FILE__ ) . '/assets/css/styles.less', dirname( __FILE__ ) . '/assets/css/styles.css' );
}
add_action( 'wp', 'shoestrap_edd_phpless' );

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
