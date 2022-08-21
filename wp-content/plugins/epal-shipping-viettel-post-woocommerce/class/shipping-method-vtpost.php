<?php
if ( class_exists( 'WC_Shipping_Method' ) ) {
    class EPAL_Shipping_Method_Vtpost extends WC_Shipping_Method {

        public function __construct() {
            $this->id                 = 'epal_shipping_vtpost';
            $this->method_title       = esc_html__( 'Viettel Post', 'epal' );
            $this->method_description = esc_html__( 'Kích hoạt tính năng ship hàng qua Viettel Post', 'epal' );
            $this->enabled            = $this->get_option( 'enabled' );
            $this->title              = $this->get_option( 'title' );

            $this->init();
        }

        function init() {
            $this->init_form_fields();
            $this->init_settings();

            // Save settings in admin if you have any defined
            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
        }

        public function is_method_enabled() {
            return $this->enabled == 'yes';
        }

        public function get_sender_store() {
            $store = get_option('epal_woo_setting_store');
            if (isset($store['value']) && $store['value']) {
                return $store['value'];
            } else {
                $listStore = epal_Ultility::get_store();
                if(count($listStore) > 0) {
                    return $listStore['0']['groupaddressId'];
                }
                return '';
            }
        }

        public function get_info_sender_store($groupaddressId = '') {
            $listStore = epal_Ultility::get_store();
            if (isset($groupaddressId) && $groupaddressId) {
                if(count($listStore) > 0) {
                    foreach ($listStore as $item) {
                        if ($groupaddressId == $item['groupaddressId']){
                            return $item;
                        }
                    }
                }
                return array();
            } else {
                if(count($listStore) > 0) {
                    return $listStore['0'];
                }
                return '';
            }
        }

        public function get_sender_province() {
            $store = get_option('epal_woo_setting_store');
            if (isset($store['province']) && $store['province']) {
                return $store['province'];
            } else {
                $listStore = epal_Ultility::get_store();
                if(count($listStore) > 0) {
                    return $listStore['0']['provinceId'];
                }
                return '';
            }
        }

        public function get_sender_district() {
            $store = get_option('epal_woo_setting_store');
            if (isset($store['district']) && $store['district']) {
                return $store['district'];
            } else {
                $listStore = epal_Ultility::get_store();
                if(count($listStore) > 0) {
                    return $listStore['0']['districtId'];
                }
                return '';
            } 
        }

        function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => esc_html__( 'Kích hoạt ship qua Viettel Post', 'epal' ),
                    'type'    => 'checkbox',
                    'label'   => esc_html__( 'Kích hoạt', 'epal' ),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => esc_html__( 'Tiêu đề', 'epal' ),
                    'type'        => 'text',
                    'description' => esc_html__( 'Tiêu đề hiển thị khi khách hàng thanh toán.', 'epal' ),
                    'default'     => esc_html__( 'Viettel Post', 'epal' ),
                    'desc_tip'    => true,
                ),
            );
        }

        public function calculate_shipping( $packages = array() ) {
            var_dump($packages);
            $products         = $packages['contents'];
            $from_province_id = $this->get_sender_province();
            $from_district_id = $this->get_sender_district();

            $to_province_id   = $packages['destination']['province'];
            $to_district_id   = $packages['destination']['district'];

            $amount           = 0.0;
            $total_weight     = 0;
            $total_price = $packages['cart_subtotal'];
            if ($products){
                foreach ( $products as $product ) {
                    $product_data = wc_get_product( $product['product_id'] )->get_data() ;
                    $weight       = (float) $product_data['weight'];

                    if ( $product['quantity'] > 1 && $weight > 0 ) {
                        $product_weight = $weight * $product['quantity'];
                    } else {
                        $product_weight = $weight;
                    }

                    $total_weight = $total_weight + $product_weight;
                }
            }

            $weight_unit = get_option('woocommerce_weight_unit');

            if ( $weight_unit == 'g' ) {
                $total_weight = $total_weight;
            } else {
                $total_weight = $total_weight * 1000;
            }
            
            if ( ! $this->is_method_enabled() ) {
                return;
            }
            
            if ( $products && $from_province_id && $from_district_id && $to_province_id && $to_district_id && $total_weight > 0 ) {
                $this->calculate_shipping_fee( $from_province_id, $from_district_id, $to_province_id, $to_district_id, $total_weight, $total_price);
            }
        }

        public function calculate_shipping_fee( $from_province_id, $from_district_id, $to_province_id, $to_district_id, $total_weight, $total_price ) {
            $body = array (
                "SENDER_PROVINCE" => $from_province_id,
                "SENDER_DISTRICT" => $from_district_id,
                "RECEIVER_PROVINCE"      =>  $to_province_id ,
                "RECEIVER_DISTRICT"      =>  $to_district_id ,
                "PRODUCT_TYPE" => "HH",
                "PRODUCT_WEIGHT" => $total_weight,
                "PRODUCT_PRICE" => $total_price,
                "MONEY_COLLECTION" => "0",
                "TYPE" => 1
            );

            $args = array(
                'body'        => json_encode($body),
                'method'      => 'POST',
                'timeout'     => '600',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking'    => true,
                'sslverify' => false,
                'headers'     => [
                    'Content-Type' => 'application/json',
                ],
                'cookies'     => array(),
                'data_format' => 'body',
            );
            $response = wp_remote_request( EPAL_API_VTPOST_URL . "/v2/order/getPriceAll", $args );
            if ( !is_wp_error( $response ) ) {
                $response =json_decode(wp_remote_retrieve_body( $response ), true );
                foreach($response as $respon){
                    if ( isset(  $respon['GIA_CUOC'] ) && $respon['GIA_CUOC'] > 0 && isset(  $respon['TEN_DICHVU'] ) && $respon['TEN_DICHVU']) {
                        $rate = array(
                            'id'    => $respon['MA_DV_CHINH'].'_'.$this->id,
                            'label' => $this->title . ': ' . $respon['TEN_DICHVU'],
                            'cost'  => $respon['GIA_CUOC'],
                            'meta_data' => array(
                                'total_weight'  => $total_weight,
                                'order_service' => $respon['MA_DV_CHINH'],
                            ),
                        );
                        $this->add_rate( $rate );
                    }
                }
            }
        }
    }
}