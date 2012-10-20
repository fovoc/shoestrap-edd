<?php

function bootstrap_commerce_edd_customizations(){
  $color                  = get_theme_mod( 'background_color' );
  $link_color             = get_theme_mod( 'link_text_color' );
  
  ?>
  
  <style>
    .product-list .product .content .product-price,
    body.single-download .product-meta .single-product-price{
      background: #<?php echo $color; ?>;
      background: <?php echo $color; ?>;
      color: #<?php echo $link_color; ?>;
      color: <?php echo $link_color; ?>;
    }
  </style>
<?php }
