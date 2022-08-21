jQuery(document).ready(function($) {
    //open popup
    jQuery('.cd-popup-trigger').on('click', function(event) {
        event.preventDefault();
        jQuery('.cd-popup').addClass('is-visible');
    });

    //close popup
    jQuery('.cd-popup').on('click', function(event) {
        if (jQuery(event.target).is('.cd-popup-close') || jQuery(event.target).is('.cd-popup')) {
            event.preventDefault();
            jQuery(this).removeClass('is-visible');
        }
    });

    //close popup when clicking the esc keyboard button
    jQuery(document).keyup(function(event) {
        if (event.which == '27') {
            jQuery('.cd-popup').removeClass('is-visible');
        }
    });

    jQuery("#woocommerce_epal_shipping_vtpost_sender_province").select2();
    setTimeout(function() {
        jQuery("#woocommerce_epal_shipping_vtpost_sender_district").select2();
        jQuery("#woocommerce_epal_shipping_vtpost_sender_ward ").select2();
    }, 2000);

    // Update Quận/ Huyện Khi Chọn Thành Phố Viettel Post
    if (jQuery('#woocommerce_epal_shipping_vtpost_sender_province').length > 0) {
        jQuery('#woocommerce_epal_shipping_vtpost_sender_province').on('change', function() {
            jQuery.ajax({
                type: 'POST',
                url: epal_admin_params.ajax.url,
                data: {
                    province_id: jQuery(this).val(),
                    action: 'admin_update_shipping_method_district'
                }
            }).done(function(result) {
                jQuery(' #woocommerce_epal_shipping_vtpost_sender_district').html(result);
            });
        });
    }

    // Update Xã / Phường Khi Chọn Thành Phố Viettel Post
    if (jQuery('#woocommerce_epal_shipping_vtpost_sender_district').length > 0) {
        jQuery('#woocommerce_epal_shipping_vtpost_sender_district').on('change', function() {
            jQuery.ajax({
                type: 'POST',
                url: epal_admin_params.ajax.url,
                data: {
                    district_id: jQuery(this).val(),
                    action: 'admin_update_shipping_method_ward'
                }
            }).done(function(result) {
                jQuery('#woocommerce_epal_shipping_vtpost_sender_ward').html(result);
            });
        });
    }

    // Tạo vận đơn trên Viettel Post
    if (jQuery('.epal-submit-order-shipping-vp').length > 0) {
        jQuery('.epal-submit-order-shipping-vp').on('click', function(e) {
            e.preventDefault();
            var groupaddress_id = $('#create_order select[name=groupaddress_id]').val();
            var order_number = $('#create_order input[name=order_number]').val();
            var receiver_email = $('#create_order input[name=receiver_email]').val();
            var receiver_address = $('#create_order input[name=receiver_address]').val();
            var product_name = $('#create_order input[name=product_name]').val();
            var product_weight = $('#create_order input[name=product_weight]').val();
            var order_note = $('#create_order select[name=order_note]').val();
            var product_length = $('#create_order input[name=product_length]').val();
            var product_width = $('#create_order input[name=product_width]').val();
            var product_height = $('#create_order input[name=product_height]').val();
            var money_collection = $('#create_order input[name=money_collection]').val();
            var order_payment = $('#create_order select[name=order_payment]').val();
            if (product_name == '') {
                alert('Vui lòng nhập tên gói hàng');
                $("#product_name").focus();
                return false;
            }
            data = {
                action: 'create_order_viettel_post',
                groupaddress_id: groupaddress_id,
                order_number: order_number,
                receiver_email: receiver_email,
                receiver_address: receiver_address,
                product_name: product_name,
                product_weight: product_weight,
                order_note: order_note,
                product_length: product_length,
                product_width: product_width,
                product_height: product_height,
                money_collection: money_collection,
                order_payment: order_payment
            };
            jQuery.ajax({
                type: 'POST',
                url: epal_admin_params.ajax.url,
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    jQuery('.epal-submit-order-shipping-vp').html('ĐANG XỬ LÝ ...');
                    jQuery('.epal-submit-order-shipping-vp').attr('disabled', 'disabled');
                },
                success: function(response) {
                    jQuery('.epal-submit-order-shipping-vp').removeAttr('disabled');
                    var data = response.data;
                    if (data.status == false) {
                        jQuery('.epal-response').html(data.message);
                    } else {
                        $('.epal-response').html("Bạn tạo vận đơn thành công");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(data) {
                    alert('Hệ thống lỗi vui lòng thử lại sau.');
                }
            });
        });
    }

    // Lấy trạng thái vận đơn
    if (jQuery('.epal-vp-status').length > 0) {
        jQuery.ajax({
            type: 'POST',
            url: epal_admin_params.ajax.url,
            data: {
                vp_code: jQuery('.epal-vp-status').data('vp_code'),
                action: 'get_status_order_vp',
                token: jQuery('.epal-vp-status').data('token')
            }
        }).done(function(result) {
            if (result == 'Cancel') {
                jQuery('.epal-vp-cancel-order').remove();
            }
            jQuery('.epal-vp-status span').html(result);
        });
    }

    if (jQuery('.epal-vp-cancel-order').length > 0) {
        jQuery('.epal-vp-cancel-order').click(function() {
            jQuery.ajax({
                type: 'POST',
                url: epal_admin_params.ajax.url,
                data: {
                    vp_code: jQuery('.epal-vp-cancel-order').data('vp_code'),
                    action: 'cancel_order_vp',
                    token: jQuery('.epal-vp-cancel-order').data('token'),
                    order_id: jQuery('.epal-vp-cancel-order').data('order_id')
                }
            }).done(function(result) {
                alert(result);
            });
        });
    }
});