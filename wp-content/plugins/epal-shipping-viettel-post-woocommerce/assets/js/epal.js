jQuery(document).ready(function($) {
    jQuery(".epal-select-province").select2();
    setTimeout(function() {
        jQuery(".epal-select-district").select2();
        jQuery(".epal-select-ward").select2();
    }, 1000);

    // Khi chọn province thì lưu province_id vào session
    if (jQuery('.epal-select-province').length > 0) {
        jQuery('.epal-select-province').on('change', function() {

            jQuery.ajax({
                type: 'POST',
                url: epal.ajax.url,
                data: {
                    province_id: jQuery(this).val(),
                    action: 'update_checkout_district'
                }
            }).done(function(result) {
                jQuery('.epal-select-district').html(result);
            });
        });
    }

    if (jQuery('.epal-select-district').length > 0) {
        jQuery('.epal-select-district').on('change', function() {
            jQuery.ajax({
                type: 'POST',
                url: epal.ajax.url,
                data: {
                    district_id: jQuery(this).val(),
                    action: 'update_checkout_ward'
                }
            }).done(function(result) {
                jQuery('.epal-select-ward').html(result);
            });
        });
    }

    if (jQuery('.epal-select-ward').length > 0) {
        jQuery('.epal-select-ward').on('change', function() {
            jQuery.ajax({
                type: 'POST',
                url: epal.ajax.url,
                data: {
                    ward_id: jQuery(this).val(),
                    action: 'set_session_ward'
                }
            }).done(function(result) {});
        });
    }
    if ($('#calc_shipping_country_field').length > 0) {
        $('#calc_shipping_country_field #calc_shipping_country').prop('disabled', 'disabled');
    }
    var clickCalButton = function() {
        $('.shipping-calculator-button').on('click', function(event) {
            setTimeout(function() {
                getStateCity();
            }, 1000);
        });
    }
    clickCalButton();

    $('.woocommerce-shipping-calculator .button').on('click', function(event) {
        setTimeout(function() {
            clickCalButton();
        }, 7000);
    });

    var getStateCity = function() {
        if ($('#calc_shipping_state_field').length > 0) {
            var state_field = $('#calc_shipping_state_field');
            state_field.css('display', 'block').html('<select name="calc_shipping_state" id="calc_shipping_state" class="country_to_state country_select" rel="calc_shipping_state" disabled="" tabindex="100" aria-hidden="true"><option>Chọn tỉnh, thành phố</option></select>');
            state_field.find('select').select2();
            $.ajax({
                type: 'POST',
                url: epal.ajax.url,
                data: { action: "load_province" },
                success: function(response) {
                    if (response.success) {
                        var province = response.data;

                        var data = [];
                        $.each(province, function(index, value) {
                            data.push({ id: index, text: value });
                        });
                        state_field.find('select').html('').select2({
                            placeholder: 'Chọn Tỉnh/ Thành Phố',
                            data: data,
                        });
                        $('#calc_shipping_state_field select').prop('disabled', false);
                        disableChangeProvince();
                    }
                }
            });
        }
    }

    function disableChangeProvince() {
        $('#calc_shipping_state_field select').change(function(e) {
            e.preventDefault();
            addSelectCity();
            return false;
        });
        jQuery('#calc_shipping_state').on('change', function() {
            jQuery.ajax({
                type: 'POST',
                url: epal.ajax.url,
                data: {
                    province_id: jQuery(this).val(),
                    action: 'update_checkout_district'
                }
            }).done(function(result) {
                console.log('đã update tỉnh thành phố');
            });
        });
    }

    function addSelectCity() {
        if ($('#calc_shipping_city_field').length > 0) {
            var district_field = $('#calc_shipping_city_field #calc_shipping_city');
            var default_val = district_field.val();
            var state_default = $('#calc_shipping_state').val();

            district_field.select2();
            var loadingText = 'Chọn Quận/Huyện';
            $('#calc_shipping_city_field .select2-selection__placeholder').html(loadingText);

            var loading_cacl = false;
            var devvn_district_by_state = function(state_id) {
                $('#calc_shipping_city_field .select2-selection__placeholder').html(loadingText);
                if (state_id && !loading_cacl) {
                    $.ajax({
                        type: "post",
                        url: epal.ajax.url,
                        data: { action: "load_district", state_id: state_id },
                        success: function(response) {
                            if (response.success) {
                                var district = response.data;
                                var data = [];
                                $.each(district, function(index, value) {
                                    data.push({ id: index, text: value });
                                });
                                district_field.html('').select2({
                                    placeholder: 'Chọn Quận/Huyện',
                                    data: data,
                                });
                                jQuery('#calc_shipping_city').on('change', function() {
                                    jQuery.ajax({
                                        type: 'POST',
                                        url: epal.ajax.url,
                                        data: {
                                            district_id: jQuery(this).val(),
                                            action: 'update_checkout_ward'
                                        }
                                    }).done(function(result) {
                                        console.log('đã update quận huyện');
                                    });
                                });
                            }
                        }
                    });
                }
            };
            var epal_city_to_district_select2 = function() {
                var val = $('#calc_shipping_state').val();
                devvn_district_by_state(val);

            };
            epal_city_to_district_select2();
        }
    }
});