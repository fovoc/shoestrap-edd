<?php

if ( function_exists( 'edd_get_checkout_uri' ) ) {
  
  function shoestrap_add_cart_to_navbar() { ?>
    <a class="btn btn-cart" href="<?php echo edd_get_checkout_uri(); ?>"><i class="icon-shopping-cart"></i> <?php _e( 'My Cart', 'shoestrap' ) ?></a>
  <?php }
  add_action( 'shoestrap_nav_top_right', 'shoestrap_add_cart_to_navbar' );
}