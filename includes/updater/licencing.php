<?php

define( 'EDD_SL_STORE_URL',   'http://bootstrap-commerce.com/downloads' );
define( 'EDD_SL_ITEM_NAME',   'Bootstrap Commerce Easy Digital Downloads Addon' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
  include( dirname( __FILE__ ) . '/plugin_updater.php' );
}

// retrieve our license key from the DB
$license_key = trim( get_option( 'bc_edd_license_key' ) );

// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater( EDD_SL_STORE_URL, __FILE__, array( 
    'version'   => '1.0',                     // current version number
    'license'   => $license_key,              // license key (used get_option above to retrieve from DB)
    'item_name' => EDD_SL_ITEM_NAME,          // name of this plugin
    'author'    => 'Aristeides Stathopoulos'  // author of this plugin
  )
);


function bc_edd_license_menu() {
  add_plugins_page( 'Bootstrap Commerce Easy Digital Downloads Addon License', 'Bootstrap Commerce Easy Digital Downloads Addon License', 'manage_options', 'bc_edd-license', 'bc_edd_license_page' );
}
add_action('admin_menu', 'bc_edd_license_menu');

function bc_edd_license_page() {
  $license  = get_option( 'bc_edd_license_key' );
  $status   = get_option( 'bc_edd_license_status' );
  ?>
  <div class="wrap">
    <h2><?php _e('Bootstrap Commerce Easy Digital Downloads Addon License Options'); ?></h2>
    <form method="post" action="options.php">
    
      <?php settings_fields('bc_edd_license'); ?>
      
      <table class="form-table">
        <tbody>
          <tr valign="top"> 
            <th scope="row" valign="top">
              <?php _e('License Key'); ?>
            </th>
            <td>
              <input id="bc_edd_license_key" name="bc_edd_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
              <label class="description" for="bc_edd_license_key"><?php _e('Enter your license key'); ?></label>
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
                  wp_nonce_field( 'bc_edd_nonce', 'bc_edd_nonce' ); ?>
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

function bc_edd_register_option() {
  // creates our settings in the options table
  register_setting('bc_edd_license', 'bc_edd_license_key', 'edd_sanitize_license' );
}
add_action('admin_init', 'bc_edd_register_option');

function edd_sanitize_license( $new ) {
  $old = get_option( 'bc_edd_license_key' );
  if( $old && $old != $new ) {
    delete_option( 'bc_edd_license_status' ); // new license has been entered, so must reactivate
  }
  return $new;
}



function bc_edd_activate_license() {

  // listen for our activate button to be clicked
  if( isset( $_POST['edd_license_activate'] ) ) {

    // run a quick security check 
    if( ! check_admin_referer( 'bc_edd_nonce', 'bc_edd_nonce' ) )   
      return; // get out if we didn't click the Activate button

    // retrieve the license from the database
    $license = trim( get_option( 'bc_edd_license_key' ) );
      

    // data to send in our API request
    $api_params = array( 
      'edd_action'=> 'activate_license', 
      'license'   => $license, 
      'item_name' => urlencode( EDD_SL_ITEM_NAME ) // the name of our product in EDD
    );
    
    // Call the custom API.
    $response = wp_remote_get( add_query_arg( $api_params, EDD_SL_STORE_URL ) );

    // make sure the response came back okay
    if ( is_wp_error( $response ) )
      return false;

    // decode the license data
    $license_data = json_decode( wp_remote_retrieve_body( $response ) );
    
    // $license_data->license will be either "active" or "inactive"

    update_option( 'bc_edd_license_status', $license_data->license );

  }
}
add_action('admin_init', 'bc_edd_activate_license');

function bc_edd_check_license() {

  global $wp_version;

  $license = trim( get_option( 'bc_edd_license_key' ) );
    
  $api_params = array( 
    'edd_action' => 'check_license', 
    'license' => $license, 
    'item_name' => urlencode( EDD_SL_ITEM_NAME ) 
  );

  // Call the custom API.
  $response = wp_remote_get( add_query_arg( $api_params, EDD_SL_STORE_URL ) );


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

