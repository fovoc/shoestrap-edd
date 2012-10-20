<?php
  
function bc_edd_load_single_template() {
  global $wp_query;

  // Only run on single pages of post type = download
  if ($wp_query->is_single && $wp_query->query_vars['post_type'] == 'download') {

    //only filter public side
    if (is_admin()){
      return;
    } else {
      
      // Include the actual template file
      include_once dirname( __FILE__ ) . '/templates/single-download.php';
    }
  }
}
add_action('template_redirect', 'bc_edd_load_single_template');