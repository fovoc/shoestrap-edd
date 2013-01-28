<?php

if ( function_exists( 'edd_get_checkout_uri' ) ) {
  
  function shoestrap_add_cart_to_navbar() {
    if ( get_theme_mod( 'shoestrap_edd_navbar_cart' ) == 1 ) { ?>
      <a class="btn btn-primary btn-cart pull-right" href="<?php echo edd_get_checkout_uri(); ?>"><i class="icon-shopping-cart"></i> <?php _e( 'My Cart', 'shoestrap_edd' ) ?> (<span class="header-cart edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span>)</a>
      <?php
    }
  }
  add_action( 'shoestrap_nav_top_left', 'shoestrap_add_cart_to_navbar', 10 );
}