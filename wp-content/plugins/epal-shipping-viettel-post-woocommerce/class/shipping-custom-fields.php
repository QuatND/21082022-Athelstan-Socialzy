<?php
if ( !class_exists( 'epal_Custom_Fields' ) ) {
	class epal_Custom_Fields {

		function __construct() {

			// Add thêm field khi checkout, sắp xếp lại thứ tự fields và ẩn một số field không sử dụng.
			add_filter( 'woocommerce_checkout_fields', array( $this, 'epal_woocommerce_checkout_fields' ), 99 );

			// Add thêm field lưu tỉnh/ thành phố, quận/huyện, phường/ xã vào thông tin của user .
			add_filter( 'woocommerce_customer_meta_fields', array( $this, 'epal_woocommerce_customer_meta_fields' ) );
			
			// Xoá trong trang giỏ hàng
			add_filter( 'woocommerce_shipping_calculator_enable_postcode', '__return_false');
			add_filter('woocommerce_default_address_fields', array($this, 'epal_custom_override_default_address_fields'),9999999);

		}

		// Add thêm field khi checkout, sắp xếp lại thứ tự fields và ẩn một số field không sử dụng.
		function epal_woocommerce_checkout_fields( $fields ) {
			$province_args = array(
				'label'   => esc_html__( 'Tỉnh/ Thành Phố', 'epal' ),
				'type'    => 'select',
				'required' => true,
				'options' => epal_Ultility::get_province(),
				'input_class' => array(
					'wc-enhanced-select epal-select-province',
				),
				'priority' => 90,
				'default'  => WC()->session->get( 'province_id' ),
			);
			$fields['shipping']['shipping_epal_province'] = $province_args;
			$fields['billing']['billing_epal_province']   = $province_args;

			$district_args = array(
				'label'    => esc_html__( 'Quận/ Huyện', 'epal' ),
				'type'     => 'select',
				'required' => true,
				'options'  => epal_Ultility::get_district( WC()->session->get( 'province_id' ) ),
				'input_class' => array(
					'wc-enhanced-select epal-select-district',
				),
				'class' => array (
					0 => 'form-row-wide',
				),
				'priority' => 90,
				'default'  => WC()->session->get( 'district_id' )
			);
			$fields['shipping']['shipping_epal_district'] = $district_args;
			$fields['billing']['billing_epal_district']   = $district_args;

			$ward_args = array(
				'label'    => esc_html__( 'Phường/ Xã', 'epal' ),
				'type'     => 'select',
				'required' => true,
				'options'  => epal_Ultility::get_ward( WC()->session->get( 'district_id' ) ),
				'input_class' => array(
					'wc-enhanced-select epal-select-ward',
				),
				'class' => array (
					0 => 'form-row-wide',
					2 => 'update_totals_on_change',
				),
				'priority' => 100,
				'default'  => WC()->session->get( 'ward_id' )
			);

			$fields['shipping']['shipping_epal_ward'] = $ward_args;
			$fields['billing']['billing_epal_ward']   = $ward_args;

			unset($fields['shipping']['shipping_city']);
			unset($fields['billing']['billing_city']);
			unset($fields['billing']['billing_address_2']);

			unset($fields['shipping']['shipping_postcode']);
			unset($fields['billing']['billing_postcode']);

			unset($fields['shipping']['shipping_last_name']);
			unset($fields['billing']['billing_last_name']);
			unset($fields['billing']['billing_country']);

			$fields['shipping']['shipping_phone']['priority'] = 30;
			$fields['billing']['billing_phone']['priority']   = 30;

			$fields['shipping']['shipping_email']['priority'] = 40;
			$fields['billing']['billing_email']['priority']   = 40;

			$fields['shipping']['shipping_country']['priority'] = 50;
			$fields['billing']['billing_country']['priority']   = 50;

			$fields['shipping']['shipping_address_1']['priority'] = 1000;
			$fields['billing']['billing_address_1']['priority']   = 1000;

			return $fields;
		}

		function epal_woocommerce_customer_meta_fields( $show_fields ) {
			$show_fields['billing']['fields']['billing_epal_province'] = array(
				'label'       => esc_html__( 'Tình/ Thảnh Phố', 'epal' ),
				'description' => '',
			);
		    $show_fields['billing']['fields']['billing_epal_district'] = array(
				'label'       => esc_html__( 'Quận/ Huyện', 'epal' ),
				'description' => '',
			);
			$show_fields['billing']['fields']['billing_epal_ward'] = array(
				'label'       => esc_html__( 'Xã/ Phường', 'epal' ),
				'description' => '',
			);

			$show_fields['shipping']['fields']['shipping_epal_province'] = array(
				'label'       => esc_html__( 'Tỉnh/ Thành Phố', 'epal' ),
				'description' => '',
			);
			$show_fields['shipping']['fields']['shipping_epal_district'] = array(
				'label'       => esc_html__( 'Quận/ Huyện', 'epal' ),
				'description' => '',
			);
			$show_fields['shipping']['fields']['shipping_epal_ward'] = array(
				'label'       => esc_html__( 'Xã/ Phường', 'epal' ),
				'description' => '',
			);

			return $show_fields;
		}

		function epal_custom_override_default_address_fields($address_fields)
        {
            $address_fields['state']['placeholder'] = 'Chọn Tỉnh/ Thành Phố';
            $address_fields['city'] = array(
                'label' => __('Chọn Quận/Huyện', 'Epal'),
                'type' => 'select',
                'required' => true,
                'class' => array('form-row-wide'),
                'priority' => 20,
                'placeholder' => 'Chọn Quận/Huyện',
                'options' => array(
                    '' => ''
                ),
                'default' => ''
            );
            return $address_fields;
        }
	}

	new epal_Custom_Fields();
}