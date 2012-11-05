<?php

function shoestrap_edd_register_settings($wp_customize){

  $settings = array();
  $settings[] = array( 'slug'=> 'shoestrap_edd_show_text_in_lists', 'default' => 'show');
  $settings[] = array( 'slug'=> 'shoestrap_edd_show_meta_on_top',   'default' => 'no');
  $settings[] = array( 'slug'=> 'shoestrap_edd_frontpage',          'default' => 'edd_list');

  foreach($settings as $setting){
    $wp_customize->add_setting( $setting['slug'], array( 'default' => $setting['default'], 'type' => 'theme_mod', 'capability' => 'edit_theme_options' ));
  }
  $wp_customize->add_setting( 'posts_per_page', array(
    'default'        => 'posts_per_page',
    'type'           => 'option',
    'capability'     => 'manage_options',
) );
  
}
add_action( 'customize_register', 'shoestrap_edd_register_settings' );
