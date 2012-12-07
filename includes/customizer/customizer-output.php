<?php

function shoestrap_edd_customizations(){
  $color      = get_theme_mod( 'background_color' );
  $link_color = get_theme_mod( 'shoestrap_link_color' );
  $btn_color  = get_theme_mod( 'shoestrap_buttons_color' );
  $text_light = get_theme_mod( 'shoestrap_text_variation' );
  
  if (strlen($btn_color) <= 2 ){ $btn_color = '#0066cc'; }

  ?>
  
  <style>
    .product-list .product .content h5.product_name{
      color: <?php echo $link_color; ?>;
      color: #<?php echo $link_color; ?>;
    }
    .product-list .product .content .product-price,
    body.single-download .product-meta .single-product-price{
      <?php if ( !empty($color) ) { ?>
        background: <?php echo $color; ?>;
        background: #<?php echo $color; ?>;
      <?php } else {
        if ( $text_light == 'light' ) { ?>
          background: #333;
        <?php } else { ?>
          background: #fff;
        <?php } ?>
      <?php } ?>
      color: <?php echo $link_color; ?>;
      color: #<?php echo $link_color; ?>;
    }
    <?php if ( $text_light == 'light' ) { ?>
      .product-list .product{
        background: #333;
      }
    <?php } ?>
  </style>
<?php }
add_action( 'wp_head', 'shoestrap_edd_customizations', 200 );

function shoestrap_edd_footer_scripts() { ?>
  <script>$(".edd-add-to-cart, .edd-submit").addClass("btn btn-primary");</script>
  <?php
}
add_action( 'wp_footer', 'shoestrap_edd_footer_scripts' );
