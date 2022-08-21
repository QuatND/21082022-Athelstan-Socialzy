<?php

class epal_Ultility {

    // Array code, name tỉnh/ thành phố
    public static function get_province() {
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listProvinceById?provinceId=-1", array(
        ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
            $province[] = esc_html__( 'Chọn Tỉnh/ Thành Phố', 'epal' );
            foreach( $body as $item ) {
                $province[$item['PROVINCE_ID']] = $item['PROVINCE_NAME'];
            }
            return $province;
        }
    }

    // Array code, name quận/ huyện
    public static function get_district( $province_id ) {
        if ( isset( $province_id ) && $province_id ) {
            $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listDistrict?provinceId=".$province_id, array(
            ));
            if ( is_array( $response ) && ! is_wp_error( $response ) ) {
                $body = json_decode( $response['body'] , true )['data'];
                $province[] = esc_html__( 'Chọn Quận/ Huyện', 'epal' );
                if ($body){
                    foreach( $body as $item ) {
                        $province[$item['DISTRICT_ID']] = $item['DISTRICT_NAME'];
                    }
                }
                return $province;
            }
        } else {
            return array( '' => esc_html__( 'Chọn Quận/ Huyện', 'epal' ) );
        }
    }

    // Array code, name xã/ phường
    public static function get_ward( $district_id ) {
        if ( isset( $district_id ) && $district_id ) {
            $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listWards?districtId=".$district_id , array(
            ));
            if ( is_array( $response ) && ! is_wp_error( $response ) ) {
                $body = json_decode( $response['body'] , true )['data'];
                $province[] = esc_html__( 'Chọn Phường/ Xã', 'epal' );
                if($body){
                    foreach( $body as $item ) {
                        $province[$item['WARDS_ID']] = $item['WARDS_NAME'];
                    }
                }
                return $province;
            }

        } else {
            return array( '' => esc_html__( 'Chọn Phường/ Xã', 'epal' ) );
        }
    }

    // Option quận huyện
    public static function show_option_district( $province_id ) {
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listDistrict?provinceId=".$province_id, array(
            ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
            echo '<option value="">'.esc_html__( 'Chọn Quận/ Huyện', 'epal' ).'</option>';
            foreach( $body as $item ) {
                echo '<option value="'.esc_attr( $item['DISTRICT_ID'] ).'">'.esc_attr( $item['DISTRICT_NAME'] ).'</option>';
            }
        }
    }

    // Option quận huyện
    public static function show_option_ward( $district_id ) {
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listWards?districtId=".$district_id , array(
            ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
            echo '<option value="">'.esc_html__( 'Chọn Phường/ Xã', 'epal' ).'</option>';
            foreach( $body as $item ) {
                echo '<option value="'.esc_attr( $item['WARDS_ID'] ).'">'.esc_attr( $item['WARDS_NAME'] ).'</option>';
            }
        }
    }

    // Lấy tên một tỉnh/ thành phố từ province_id
    public static function get_detail_province( $province_id ) {
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listProvinceById?provinceId=".$province_id, array(
        ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
            foreach( $body as $item ) {
                if ($province_id == $item['PROVINCE_ID']){
                    return $item['PROVINCE_NAME'];
                }
                return '--';
            }
        }
        return '--';
    }

    // Lấy tên một quận/huyện từ district_id
    public static function get_detail_district( $province_id , $district_id ) {
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listDistrict?provinceId=".$province_id, array(
            ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
            if ($body){
                foreach( $body as $item ) {
                    if ($district_id == $item['DISTRICT_ID']){
                        return $item['DISTRICT_NAME'];
                    }
                }
            }
        }
    }

    // Lấy tên môt phường/xã từ ward_id
    public static function get_detail_ward( $district_id,$ward_id ) {
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/categories/listWards?districtId=".$district_id , array(
            ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
            if ($body){
               foreach( $body as $item ) {
                    if ($ward_id == $item['WARDS_ID']){
                        return $item['WARDS_NAME'];
                    }
                } 
            }
            
        }
    }

    // Lấy store của user
    public static function get_store() {
        $account = get_option('epal_woo_setting_account');
        $body = [];
        if (isset($account['token']) && $account['token']) {
            $token = $account['token'];
        }
        $params = array(
            'headers' => array(
                'token' => $token
            )
        );
        $response = wp_remote_get(EPAL_API_VTPOST_URL."/v2/user/listInventory",$params);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( $response['body'] , true )['data'];
        }
        return $body;
    }

    // Tính cước của một

}
