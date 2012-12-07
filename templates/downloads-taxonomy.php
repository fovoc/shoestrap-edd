<div class="row-fluid product-list">
<?php
$per_row = get_theme_mod( 'shoestrap_edd_products_row' );
if ( $per_row == '1' ) { $spanclass = 'span12'; }
if ( $per_row == '2' ) { $spanclass = 'span6'; }
if ( $per_row == '3' ) { $spanclass = 'span4'; }
if ( $per_row == '4' ) { $spanclass = 'span3'; }
?>
<?php if (have_posts()) : $i = 1; ?>
  <?php while (have_posts()) : the_post(); ?>
    <div style="margin-right: -2px;" class="<?php echo $spanclass; ?> threecol product<?php if($i % $per_row == 0) { echo ' last'; } if($i % $per_row == 1) { echo ' first'; } ?>">
      <div class="product-image">
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail( 'bc-product-thumb' ); ?>
        </a>
      </div>
      <div class="content">
        <a href="<?php the_permalink(); ?>">
          <h5 class="product_name"><?php the_title(); ?></h5>
        </a>
        <?php $show_content = get_theme_mod( 'shoestrap_edd_show_text_in_lists' );
        if ( $show_content == 'show' ) { ?>
          <p><?php the_excerpt(); ?></p>
        <?php } ?>
        
        <?php if(function_exists( 'edd_price' )) { ?>
          <div class="product-price">
            <?php 
              if(edd_has_variable_prices(get_the_ID())) {
                // if the download has variable prices, show the first one as a starting price
                _e('Starting at: ', 'shoestrap_edd'); edd_price(get_the_ID());
              } else {
                edd_price(get_the_ID()); 
              }
            ?>
          </div><!--end .product-price-->
        <?php } ?>
        <?php if(function_exists( 'edd_price' )) { ?>
          <div class="product-buttons">
            <?php if(!edd_has_variable_prices(get_the_ID())) { ?>
              <?php echo edd_get_purchase_link(get_the_ID(), __('Add to Cart', 'shoestrap_edd'), 'button' ); ?>
            <?php } ?>
          </div><!--end .product-buttons-->
        <?php } ?>
      </div>
    </div><!--end .product-->
    <?php $i+=1; ?>
  <?php endwhile; ?>
</div>
  <div class="pagination">
    <?php 
      global $wp_query;
      
      $big = 999999999; // need an unlikely integer
      
      echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages
      ) );
    ?>
  </div>
<?php else : ?>

  <h2 class="center"><?php _e( 'Not Found', 'shoestrap_edd' ); ?></h2>
  <p class="center"><?php _e("Sorry, but you are looking for something that isn't here.", "shoestrap_edd"); ?></p>
  <?php get_search_form(); ?>

<?php endif; ?>
