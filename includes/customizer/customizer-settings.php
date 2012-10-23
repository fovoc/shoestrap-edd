<?php

function shoestrap_edd_register_settings($wp_customize){

  $settings = array();
  $settings[] = array( 'slug'=> 'shoestrap_edd_show_text_in_lists', 'default' => 'show');

  foreach($settings as $setting){
    $wp_customize->add_setting( $setting['slug'], array( 'default' => $setting['default'], 'type' => 'theme_mod', 'capability' => 'edit_theme_options' ));
  }
}
add_action( 'customize_register', 'shoestrap_edd_register_settings' );
