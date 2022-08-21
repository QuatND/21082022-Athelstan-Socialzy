<?php
get_header();
get_template_part('stn/header-main');
?>
<section id="products-page">
    <div class="container">
        <div class="products-page">
            <div class="row">
                <div class="col-lg-12">
                    <?php $term = get_queried_object(); ?>
                    <?php $image = get_field('banner_category_products', $term); ?>
                    <?php if ($image != ''): ?>
                        <div class="banner-category">
                            <img src="<?php echo $image ['url'] ?>" alt="<?php echo $image ['alt'] ?>">
                        </div>
                    <?php endif; ?>
                    <?php
                    if (woocommerce_product_loop()) {
                        do_action('woocommerce_before_shop_loop');
                        woocommerce_product_loop_start();

                        if (wc_get_loop_prop('total')) {
                            while (have_posts()) {
                                the_post();

                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action('woocommerce_shop_loop');

                                wc_get_template_part('content', 'product');
                            }
                        }

                        woocommerce_product_loop_end();

                        do_action('woocommerce_after_shop_loop');
                        ?>
                        <?php
                    } else {

                        do_action('woocommerce_no_products_found');
                    }
                    do_action('woocommerce_after_main_content');
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer('shop'); ?>