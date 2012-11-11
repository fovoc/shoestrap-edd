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
    
    <?php
    $less = new lessc;
    
    $less->setVariables(array(
        "btnColor"  => $btn_color,
    ));
    $less->setFormatter("compressed");
    
    if (shoestrap_get_brightness($btn_color) <= 160){
      // The following is taken directly from bootstrap's buttons.less file
      echo $less->compile("
        @btnColorHighlight: darken(spin(@btnColor, 5%), 10%);

        .gradientBar(@primaryColor, @secondaryColor, @textColor: #fff, @textShadow: 0 -1px 0 rgba(0,0,0,.25)) {
          color: @textColor;
          text-shadow: @textShadow;
          #gradient > .vertical(@primaryColor, @secondaryColor);
          border-color: @secondaryColor @secondaryColor darken(@secondaryColor, 15%);
          border-color: rgba(0,0,0,.1) rgba(0,0,0,.1) fadein(rgba(0,0,0,.1), 15%);
        }

        #gradient {
          .vertical(@startColor: #555, @endColor: #333) {
            background-color: mix(@startColor, @endColor, 60%);
            background-image: -moz-linear-gradient(top, @startColor, @endColor); // FF 3.6+
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(@startColor), to(@endColor)); // Safari 4+, Chrome 2+
            background-image: -webkit-linear-gradient(top, @startColor, @endColor); // Safari 5.1+, Chrome 10+
            background-image: -o-linear-gradient(top, @startColor, @endColor); // Opera 11.10
            background-image: linear-gradient(to bottom, @startColor, @endColor); // Standard, IE10
            background-repeat: repeat-x;
          }
        }

        .buttonBackground(@startColor, @endColor, @textColor: #fff, @textShadow: 0 -1px 0 rgba(0,0,0,.25)) {
          .gradientBar(@startColor, @endColor, @textColor, @textShadow);
          *background-color: @endColor; /* Darken IE7 buttons by default so they stand out more given they won't have borders */
          .reset-filter();
          &:hover, &:active, &.active, &.disabled, &[disabled] {
            color: @textColor;
            background-color: @endColor;
            *background-color: darken(@endColor, 5%);
          }
        }
        .edd-submit.button.blue,
        .edd-submit.button.gray,
        .edd-submit.button.green,
        .edd-submit.button.yellow,
        .edd-submit.button.dark-gray,
        .edd_purchase_submit_wrapper .edd-submit.button.blue,
        .edd_purchase_submit_wrapper .edd-submit.button.gray,
        .edd_purchase_submit_wrapper .edd-submit.button.green,
        .edd_purchase_submit_wrapper .edd-submit.button.yellow,
        .edd_purchase_submit_wrapper .edd-submit.button.dark-gray,
        .edd-add-to-cart.blue, .edd-add-to-cart.gray, .edd-add-to-cart.green, .edd-add-to-cart.yellow, .edd-add-to-cart.dark-gray,
        .navbar-inner a.btn-cart,
        .widget_edd_cart_widget ul.edd-cart .edd_checkout a{
          .buttonBackground(@btnColor, @btnColorHighlight);
        }
      ");
    } else {
      echo $less->compile("
        @btnColorHighlight: darken(@btnColor, 15%);

        .gradientBar(@primaryColor, @secondaryColor, @textColor: #333, @textShadow: 0 -1px 0 rgba(0,0,0,.25)) {
          color: @textColor;
          text-shadow: @textShadow;
          #gradient > .vertical(@primaryColor, @secondaryColor);
          border-color: @secondaryColor @secondaryColor darken(@secondaryColor, 15%);
          border-color: rgba(0,0,0,.1) rgba(0,0,0,.1) fadein(rgba(0,0,0,.1), 15%);
        }

        #gradient {
          .vertical(@startColor: #555, @endColor: #333) {
            background-color: mix(@startColor, @endColor, 60%);
            background-image: -moz-linear-gradient(top, @startColor, @endColor); // FF 3.6+
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(@startColor), to(@endColor)); // Safari 4+, Chrome 2+
            background-image: -webkit-linear-gradient(top, @startColor, @endColor); // Safari 5.1+, Chrome 10+
            background-image: -o-linear-gradient(top, @startColor, @endColor); // Opera 11.10
            background-image: linear-gradient(to bottom, @startColor, @endColor); // Standard, IE10
            background-repeat: repeat-x;
          }
        }

        .buttonBackground(@startColor, @endColor, @textColor: #333, @textShadow: 0 -1px 0 rgba(0,0,0,.25)) {
          .gradientBar(@startColor, @endColor, @textColor, @textShadow);
          *background-color: @endColor; /* Darken IE7 buttons by default so they stand out more given they won't have borders */
          .reset-filter();
          &:hover, &:active, &.active, &.disabled, &[disabled] {
            color: @textColor;
            background-color: @endColor;
            *background-color: darken(@endColor, 5%);
          }
        }
        .edd-submit.button.blue,
        .edd-submit.button.gray,
        .edd-submit.button.green,
        .edd-submit.button.yellow,
        .edd-submit.button.dark-gray,
        .edd_purchase_submit_wrapper .edd-submit.button.blue,
        .edd_purchase_submit_wrapper .edd-submit.button.gray,
        .edd_purchase_submit_wrapper .edd-submit.button.green,
        .edd_purchase_submit_wrapper .edd-submit.button.yellow,
        .edd_purchase_submit_wrapper .edd-submit.button.dark-gray,
        .edd-add-to-cart.blue, .edd-add-to-cart.gray, .edd-add-to-cart.green, .edd-add-to-cart.yellow, .edd-add-to-cart.dark-gray,
        .navbar-inner a.btn-cart,
        .widget_edd_cart_widget ul.edd-cart .edd_checkout a{
          .buttonBackground(@btnColor, @btnColorHighlight);
        }
      ");
    }?>
  </style>
<?php }
add_action( 'wp_head', 'shoestrap_edd_customizations', 200 );
