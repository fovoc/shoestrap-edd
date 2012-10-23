<?php
  
function shoestrap_load_single_template($template) {
  global $wp_query, $post, $edd_options;
  
  $frontpage_mode = get_theme_mod( 'shoestrap_edd_frontpage' );
  $purchase_page  = $edd_options['purchase_page'];
  $success_page   = $edd_options['success_page'];

  // single download template
  if ($wp_query->is_single && $wp_query->query_vars['post_type'] == 'download') { 
    return dirname(__FILE__) . '/templates/single-download.php';
  }
  
  // downloads category and tag template
  if ( isset( $wp_query->query_vars['taxonomy'] ) && ( $wp_query->query_vars['taxonomy'] == 'download_category' || $wp_query->query_vars['taxonomy'] == 'download_tag' ) ) {
    return dirname(__FILE__) . '/templates/downloads-taxonomy.php';
  }
  
  // Global products list (on frontpage, if selected so on the customizer)
  if ( is_front_page() && $frontpage_mode == 'edd_list' ) {
    return dirname(__FILE__) . '/templates/downloads-all.php';
  }
  
  // Checkout Page template
  if ( $post->ID == $purchase_page ) {
  }
  
  // Success Page Template
  if ( $post->ID == $success_page ) {
  }

  return $template;
}
add_filter('template_include', 'shoestrap_load_single_template', 1, 1);
