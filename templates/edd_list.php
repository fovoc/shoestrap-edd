<?php
get_defined_functions();

$current_page = get_query_var( 'page' );
$per_page = get_option( 'posts_per_page' );
$offset = $current_page > 0 ? $per_page * ($current_page-1) : 0;
$product_args = array(
  'post_type'       => 'download',
  'posts_per_page'  => $per_page,
  'meta_key'        => 'edd_price',
  'orderby'         => 'meta_value',
  'order'           => 'DESC',
  'offset'          => $offset
);
$products = new WP_Query($product_args);
?>
<div class="row-fluid product-list">
<?php if ($products->have_posts()) : $i = 1; ?>
  <?php while ($products->have_posts()) : $products->the_post(); ?>
    <div class="span4 threecol product<?php if($i % 3 == 0) { echo ' last'; } if($i % 3 == 1) { echo ' first'; } ?>">
      <div class="product-image">
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail( 'bc-product-thumb' ); ?>
        </a>
      </div>
      <div class="content">
        <a href="<?php the_permalink(); ?>">
          <h5 class="product_name"><?php the_title(); ?></h5>
        </a>
        <p><?php the_excerpt(); ?></p>
        
        <?php if(function_exists( 'edd_price' )) { ?>
          <div class="product-price">
            <?php 
              if(edd_has_variable_prices(get_the_ID())) {
                // if the download has variable prices, show the first one as a starting price
                echo 'Starting at: '; edd_price(get_the_ID());
              } else {
                edd_price(get_the_ID()); 
              }
            ?>
          </div><!--end .product-price-->
        <?php } ?>
        <?php if(function_exists( 'edd_price' )) { ?>
          <div class="product-buttons">
            <?php if(!edd_has_variable_prices(get_the_ID())) { ?>
              <?php echo edd_get_purchase_link(get_the_ID(), 'Add to Cart', 'button' ); ?>
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
      $big = 999999999; // need an unlikely intege          
      echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, $current_page ),
        'total' => $products->max_num_pages
      ) );
    ?>
  </div>
<?php else : ?>

  <h2 class="center">Not Found</h2>
  <p class="center">Sorry, but you are looking for something that isn't here.</p>
  <?php get_search_form(); ?>

<?php endif; ?>
