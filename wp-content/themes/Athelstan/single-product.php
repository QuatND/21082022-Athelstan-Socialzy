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
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

get_header();
get_template_part('stn/header-main');
get_template_part('stn/breadcrumb');
?>
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
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */?>
    </div>
</section>
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
                    $('#header-icon-cart').html(response.fragments['.cart-itemt']);
                }
            },
        });
        return false;
    });

</script>


