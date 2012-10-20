<?php

if ( function_exists( 'edd_get_checkout_uri' ) ) {
  
  function bc_edd_add_cart_to_navbar() { ?>
    <a class="btn btn-cart" href="<?php echo edd_get_checkout_uri(); ?>"><i class="icon-shopping-cart"></i> <?php _e( 'My Cart', 'bootstrap_commerce' ) ?></a>
  <?php }
  add_action( 'bc_core_nav_top_right', 'bc_edd_add_cart_to_navbar' );
}