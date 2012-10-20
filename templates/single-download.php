<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <div itemscope itemtype="http://schema.org/Product" class="product-single">
      <article <?php post_class() ?> id="post-<?php the_ID(); ?>">

        <header>
          <?php if ( current_user_can( 'manage_options' ) ){ ?>
            <div class="EditProductEntryButton" style="float: right;">
              <a class="btn" href="<?php echo admin_url(); ?>post.php?post=<?php the_ID(); ?>&action=edit"><?php _e( 'Edit Product', 'bootstrap_commerce' ) ?></a>
            </div>
          <?php } ?>
          <h1 itemprop="name" class="mp_product_name" class="entry-title"><?php the_title(); ?></h1>
          
        </header>

        <div class="product-meta content clearfix">
          <?php if(!edd_has_variable_prices($post->ID)) { ?>
            <h4 class="single-product-price pull-left"><?php edd_price($post->ID); ?></h4>
          <?php } ?>
          <div class="purchase-button pull-right">
            <?php echo edd_get_purchase_link($post->ID, 'Add to Cart', 'button', 'blue'); ?>
          </div>
        </div>
        <?php the_content(); ?>
      </article>
    </div>
  <?php endwhile; ?>
  <div class="navigation">
    <div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
    <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
  </div><!--end .navigation-->
<?php else : ?>
  <div class="entry product-content not-found">
    <h2>Not Found</h2>
    <p>Sorry, but you are looking for something that isn't here.</p>
    <?php get_search_form(); ?>
  </div><!--end .product-content.entry-->
<?php endif; ?>
