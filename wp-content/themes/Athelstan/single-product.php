<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */


get_header();
get_template_part('sections/breadcrumb') ?>
<?php global $product;
?>
<section id="single-product" class="pt-5">
    <div class="container">
        <?php
        do_action('woocommerce_before_main_content');
        while (have_posts()) : the_post();
            wc_get_template_part('content', 'single-product');
        endwhile;
        do_action('woocommerce_after_main_content'); ?>
        <div class="info-product">
            <ul class="nav nav-tabs">
                <li class="active"><a class="active" data-toggle="tab" href="#single-tab-1">Ý nghĩa sản phẩm</a></li>
                <li><a data-toggle="tab" href="#single-tab-2">Hướng dẫn đặt hàng-thanh toán</a></li>
                <li><a data-toggle="tab" href="#single-tab-3">Chính sách vận chuyển</a></li>
                <li><a data-toggle="tab" href="#single-tab-4">Chính sách đổi trả/ hoàn tiền</a></li>
            </ul>
            <div class="tab-content">
                <div id="single-tab-1" class="tab-pane fade in show active"> <?php the_content(); ?> </div>
                <div id="single-tab-2"
                     class="tab-pane fade"> <?php echo get_field('tutorial_order_checkout', 'option') ?> </div>
                <div id="single-tab-3"
                     class="tab-pane fade"> <?php echo get_field('shipping_policy', 'option') ?> </div>
                <div id="single-tab-4" class="tab-pane fade"> <?php echo get_field('return_policy', 'option') ?> </div>
            </div>
        </div>
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
        <div class="related-products">
            <ul>
                <?php
                $cat = $product -> category_ids;
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 10,
                    'cat' => $cat
                );
                ?>
                <?php $getposts = new WP_query( $args);?>
                <?php global $wp_query; $wp_query->in_the_loop = true; ?>
                <?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
                    <?php global $product; ?>
                    <li class="item-product">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo get_the_post_thumbnail(get_the_ID(), 'thumnail', array( 'class' =>'thumnail') ); ?>
                        </a>
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="price-product"><?php echo $product->get_price_html(); ?></div>
                        <a href="<?php bloginfo('url'); ?>?add-to-cart=<?php the_ID(); ?>">Thêm vào giỏ</a>
                    </li>
                <?php endwhile; wp_reset_postdata();?>
            </ul>
        </div>
    </div>
</section>
<?php
get_template_part('sections/customer-feedback');
//get_template_part('sections/special-offers');
?>

<?php
get_footer('shop'); ?>
<script>
    $(document).on('click', '.single_add_to_cart_button', function (e) {
        e.preventDefault();
        if ($(this).hasClass('disabled')) {
            return false;
        }
        var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            product_qty = $form.find('input[name=quantity]').val() || 1,
            product_id = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;
        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,
        };
        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);
        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
                $thisbutton.addClass('loading')
            },
            complete: function (response) {
                $thisbutton.removeClass('loading')
            },
            success: function (response) {
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    $('.cart-ajax').html(response.fragments['.cart-item']);
                }
            },
        });
        return false;
    });

</script>


