jQuery(document).ready(function($) {

    // Hàm Login trang setting ViettelPost
    jQuery('#login-vtp').submit(function(event) {
        event.preventDefault();
        const form = $(this);
        jQuery.ajax({
            type: 'POST',
            url: epal_admin_params.ajax.url,
            dataType: 'json',
            data: form.serialize() + '&action=login_viettel_post',
            beforeSend: function(response) {
                $('#login-vtp .spinner').css({ "display": "block", "visibility": "inherit" });
                $('#epal-error').html('');
            },
            success: function(response) {
                $('#login-vtp .spinner').css({ "display": "none", "visibility": "hidden" });
                var data = response.data;
                if (data.status == false) {
                    $('#epal-error').html(data.message);
                } else {
                    var text = $('#login-vtp button').data('text');
                    $('#epal-success').html(text + " thành công. Load lại trang sau:");
                    $('#time').css('display', 'block');
                    startTimer();
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(data) {
                console.log('Hệ thống lỗi vui lòng thử lại sau.');
            }
        })
    });

    // Hàm tạo kho hàng trang setting ViettelPost
    jQuery('#addStore').submit(function(event) {
        event.preventDefault();
        const form = $(this);
        jQuery.ajax({
            type: 'POST',
            url: epal_admin_params.ajax.url,
            dataType: 'json',
            data: form.serialize() + '&action=create_store_viettel_post',
            beforeSend: function(response) {
                $('#addStore .spinner').css({ "display": "block", "visibility": "inherit" });
                $('#addStore #epal-error').html('');
            },
            success: function(response) {
                $('#addStore .spinner').css({ "display": "none", "visibility": "hidden" });
                var data = response.data;
                console.log(response);
                console.log(data);
                if (data.status == false) {
                    $('#addStore #epal-error').html(data.message);
                } else {
                    $('#addStore #epal-success').html("Bạn tạo kho hàng thành công. Load lại trang sau:");
                    $('#addStore #time').css('display', 'block');
                    startTimer();
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }

            },
            error: function(data) {
                console.log('Hệ thống lỗi vui lòng thử lại sau.');
            }
        })
    });

    // Lưu cài đặt kho hàng
    jQuery('#submitSaveStore').click(function(event) {
        event.preventDefault();
        var value = $('input[name=store_main]:checked').val();
        var province = $('#table-' + value).data('province');
        var district = $('#table-' + value).data('district');
        if (value) {
            jQuery.ajax({
                type: 'POST',
                url: epal_admin_params.ajax.url,
                dataType: 'json',
                data: 'action=setting_store_viettel_post&value=' + value + '&province=' + province + '&district=' + district,
                beforeSend: function(response) {
                    $('#submitSaveStore .spinner').css({ "display": "block", "visibility": "inherit" });
                },
                success: function(response) {
                    $('#submitSaveStore .spinner').css({ "display": "none", "visibility": "hidden" });
                    var data = response.data;
                    if (data.status == false) {
                        alert('Không thể lưu bây giờ vui lòng thử lại sau');
                    } else {
                        location.reload();
                    }
                },
                error: function(data) {
                    alert('Hệ thống lỗi vui lòng thử lại sau.');
                }
            })
        }
    });

    $('input[name=store_main]').click(function(event) {
        $('#submitSaveStore').removeAttr('disabled');
    });

    jQuery('#username,#password,#name,#phone,#woocommerce_epal_shipping_vtpost_sender_province,#woocommerce_epal_shipping_vtpost_sender_district,#woocommerce_epal_shipping_vtpost_sender_ward,#address').click(function(event) {
        $('#epal-error').html('');
    });

    function startTimer() {
        var timer = parseInt(3);
        interval_obj = setInterval(function() {
            timer -= 1;
            $('#time').html(timer);
            if (timer < 1) {
                clearInterval(interval_obj);
            }
        }, 1000);
    }

    jQuery('a[href=#showLogin-vtp]').click(function(event) {
        event.preventDefault();
        $('#login-vtp').toggle('slow');
    });

    jQuery('a[href=#addStore]').on('click', function(event) {
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

    // jQuery("#woocommerce_epal_shipping_vtpost_sender_province").select2();
    // setTimeout(function(){
    //     jQuery("#woocommerce_epal_shipping_vtpost_sender_district").select2();
    // 	jQuery("#woocommerce_epal_shipping_vtpost_sender_ward ").select2();
    // }, 2000);

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
});