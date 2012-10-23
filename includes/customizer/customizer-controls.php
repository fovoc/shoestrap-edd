<?php

function shoestrap_edd_register_controls($wp_customize){
  
/*
 * EDD SECTION
 */
  $wp_customize->add_control( 'shoestrap_edd_show_text_in_lists', array(
    'label'       => __( 'Show description in Product Listings', 'shoestrap_edd' ),
    'section'     => 'shoestrap_edd',
    'settings'    => 'shoestrap_edd_show_text_in_lists',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'show'      => __('Show', 'shoestrap_edd'),
      'hide'      => __('Hide', 'shoestrap_edd'),
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_edd_frontpage', array(
    'label'       => __( 'Show description in Product Listings', 'shoestrap_edd' ),
    'section'     => 'shoestrap_edd',
    'settings'    => 'shoestrap_edd_frontpage',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'edd_list'  => __('Products List', 'shoestrap_edd'),
      'default'   => __('Site Default', 'shoestrap_edd'),
    ),
  ));
  

  if ( $wp_customize->is_preview() && ! is_admin() )
    add_action( 'wp_footer', 'shoestrap_preview', 21);
}
add_action( 'customize_register', 'shoestrap_edd_register_controls' );
