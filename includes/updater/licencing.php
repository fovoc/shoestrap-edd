<?php

define( 'SS_EDD_STORE_URL', 'http://bootstrap-commerce.com/downloads' );
define( 'EDD_SL_ITEM_NAME', 'Shoestrap EDD Addon' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
  // load our custom updater
  include( dirname( __FILE__ ) . '/plugin_updater.php' );
}

// retrieve our license key from the DB
$license_key = trim( get_option( 'shoestrap_edd_license_key' ) );

// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater( SS_EDD_STORE_URL, __FILE__, array( 
    'version'   => '1.0.1',         // current version number
    'license'   => $license_key,
    'item_name' => EDD_SL_ITEM_NAME,
    'author'    => 'Aristeides Stathopoulos'
  )
);

function shoestrap_edd__license_menu() {
  add_plugins_page( 'Shoestrap EDD License', 'Shoestrap EDD License', 'manage_options', 'shoestrap_edd-license', 'shoestrap_edd__license_page' );
}
add_action('admin_menu', 'shoestrap_edd__license_menu');

function shoestrap_edd__license_page() {
  $license  = get_option( 'shoestrap_edd_license_key' );
  $status   = get_option( 'shoestrap_edd__license_status' );
  ?>
  <div class="wrap">
    <h2><?php _e('Shoestrap Easy Digital Downloads License Options'); ?></h2>
    <form method="post" action="options.php">
    
      <?php settings_fields('shoestrap_edd__license'); ?>
      
      <table class="form-table">
        <tbody>
          <tr valign="top"> 
            <th scope="row" valign="top">
              <?php _e('License Key'); ?>
            </th>
            <td>
              <input id="shoestrap_edd_license_key" name="shoestrap_edd_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
              <label class="description" for="shoestrap_edd_license_key"><?php _e('Enter your license key'); ?></label>
            </td>
          </tr>
          <?php if( false !== $license ) { ?>
            <tr valign="top"> 
              <th scope="row" valign="top">
                <?php _e('Activate License'); ?>
              </th>
              <td>
                <?php if( $status !== false && $status == 'valid' ) { ?>
                  <span style="color:green;"><?php _e('active'); ?></span>
                <?php } else {
                  wp_nonce_field( 'shoestrap_edd__nonce', 'shoestrap_edd__nonce' ); ?>
                  <input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>  
      <?php submit_button(); ?>
    
    </form>
  <?php
}

function shoestrap_edd__register_option() {
  // creates our settings in the options table
  register_setting('shoestrap_edd__license', 'shoestrap_edd_license_key', 'edd_sanitize_license' );
}
add_action('admin_init', 'shoestrap_edd__register_option');

function edd_sanitize_license( $new ) {
  $old = get_option( 'shoestrap_edd_license_key' );
  if( $old && $old != $new ) {
    delete_option( 'shoestrap_edd__license_status' ); // new license has been entered, so must reactivate
  }
  return $new;
}


function shoestrap_edd__activate_license() {

  // listen for our activate button to be clicked
  if( isset( $_POST['edd_license_activate'] ) ) {

    // run a quick security check 
    if( ! check_admin_referer( 'shoestrap_edd__nonce', 'shoestrap_edd__nonce' ) )   
      return; // get out if we didn't click the Activate button

    // retrieve the license from the database
    $license = trim( get_option( 'shoestrap_edd_license_key' ) );
      

    // data to send in our API request
    $api_params = array( 
      'edd_action'=> 'activate_license', 
      'license'   => $license, 
      'item_name' => urlencode( EDD_SL_ITEM_NAME ) // the name of our product in EDD
    );
    
    // Call the custom API.
    $response = wp_remote_get( add_query_arg( $api_params, SS_EDD_STORE_URL ) );

    // make sure the response came back okay
    if ( is_wp_error( $response ) )
      return false;

    // decode the license data
    $license_data = json_decode( wp_remote_retrieve_body( $response ) );
    
    // $license_data->license will be either "active" or "inactive"

    update_option( 'shoestrap_edd__license_status', $license_data->license );

  }
}
add_action('admin_init', 'shoestrap_edd__activate_license');


function shoestrap_edd__check_license() {

  global $wp_version;

  $license = trim( get_option( 'shoestrap_edd_license_key' ) );
    
  $api_params = array( 
    'edd_action' => 'check_license', 
    'license' => $license, 
    'item_name' => urlencode( EDD_SL_ITEM_NAME ) 
  );

  // Call the custom API.
  $response = wp_remote_get( add_query_arg( $api_params, SS_EDD_STORE_URL ) );


  if ( is_wp_error( $response ) )
    return false;

  $license_data = json_decode( wp_remote_retrieve_body( $response ) );

  if( $license_data->license == 'valid' ) {
    echo 'valid'; exit;
    // this license is still valid
  } else {
    echo 'invalid'; exit;
    // this license is no longer valid
  }
}

