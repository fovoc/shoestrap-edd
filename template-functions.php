<?php
  
function bc_edd_load_single_template($template) {
  global $wp_query, $post;
 
  if ($wp_query->is_single && $wp_query->query_vars['post_type'] == 'download') { 
    return dirname(__FILE__) . '/templates/single-download.php'; 
  return $template; 
  }
}
add_filter('template_include', 'bc_edd_load_single_template', 1, 1); 
