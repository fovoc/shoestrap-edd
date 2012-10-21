<?php
  
function bc_edd_load_single_template($template) {
  global $wp_query, $post;
  
  // single download template
  if ($wp_query->is_single && $wp_query->query_vars['post_type'] == 'download') { 
    return dirname(__FILE__) . '/templates/single-download.php';
  }
  
  // downloads category and tag template
  if ( isset( $wp_query->query_vars['taxonomy'] ) && ( $wp_query->query_vars['taxonomy'] == 'download_category' || $wp_query->query_vars['taxonomy'] == 'download_tag' ) ) {
    return dirname(__FILE__) . '/templates/downloads-taxonomy.php';
  }

  return $template;
}
add_filter('template_include', 'bc_edd_load_single_template', 1, 1); 
