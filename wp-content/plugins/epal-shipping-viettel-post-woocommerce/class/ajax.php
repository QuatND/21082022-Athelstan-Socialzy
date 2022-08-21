<?php
if ( !class_exists( 'epal_Ajax' ) ) {
	class epal_Ajax {

		function __construct() {

			// Lấy option quận/ huyện khi chọn tỉnh/thành phố và lưu province_id vào session
			add_action( 'wp_ajax_update_checkout_district', array( $this, 'update_checkout_district' ) );
			add_action( 'wp_ajax_nopriv_update_checkout_district', array( $this, 'update_checkout_district' ) );

			// Lấy option phường/ xã khi chọn quận/huyện và lưu district_id vào session
			add_action( 'wp_ajax_update_checkout_ward', array( $this, 'update_checkout_ward' ) );
			add_action( 'wp_ajax_nopriv_update_checkout_ward', array( $this, 'update_checkout_ward' ) );

			// Lưu district_id vào session
			add_action( 'wp_ajax_set_session_ward', array( $this, 'set_session_ward' ) );
			add_action( 'wp_ajax_nopriv_set_session_ward', array( $this, 'set_session_ward' ) );

			// Lấy option quận/ huyện khi chọn tỉnh/ thành phố trong cài đặt phương thức thanh toán của woo
			add_action( 'wp_ajax_admin_update_shipping_method_district', array( $this, 'admin_update_shipping_method_district' ) );
			add_action( 'wp_ajax_nopriv_admin_update_shipping_method_district', array( $this, 'admin_update_shipping_method_district' ) );

			// Lấy option phường/ xã khi chọn quận/ huyện trong cài đặt phương thức thanh toán của woo
			add_action( 'wp_ajax_admin_update_shipping_method_ward', array( $this, 'admin_update_shipping_method_ward' ) );
			add_action( 'wp_ajax_nopriv_admin_update_shipping_method_ward', array( $this, 'admin_update_shipping_method_ward' ) );

			// Lấy option tỉnh thành phố trang cart
			add_action( 'wp_ajax_load_province', array( $this, 'load_province' ) );
			add_action( 'wp_ajax_nopriv_load_province', array( $this, 'load_province' ) );

			// Lấy quận/ huyện khi chọn tỉnh/ thành phố trang cart
			add_action( 'wp_ajax_load_district', array( $this, 'load_district' ) );
			add_action( 'wp_ajax_nopriv_load_district', array( $this, 'load_district' ) );

			// Đăng đơn lên Viettel Post
			add_action( 'wp_ajax_create_order_viettel_post', array( $this, 'create_order_viettel_post' ) );
			add_action( 'wp_ajax_nopriv_create_order_viettel_post', array( $this, 'create_order_viettel_post' ) );

			// // Check trạng thái đơn hàng khi xem chi tiết order giao hàng nhanh
			// add_action( 'wp_ajax_get_status_order_ghn', array( $this, 'get_status_order_ghn' ) );
			// add_action( 'wp_ajax_nopriv_get_status_order_ghn', array( $this, 'get_status_order_ghn' ) );

			// add_action( 'wp_ajax_cancel_order_ghn', array( $this, 'cancel_order_ghn' ) );
			// add_action( 'wp_ajax_nopriv_cancel_order_ghn', array( $this, 'cancel_order_ghn' ) );

			//Cài đặt tài khoản
			add_action( 'wp_ajax_login_viettel_post', array( $this, 'login_viettel_post' ) );
			add_action( 'wp_ajax_nopriv_login_viettel_post', array( $this, 'login_viettel_post' ) );

			//Tạo kho hàng
			add_action( 'wp_ajax_create_store_viettel_post', array( $this, 'create_store_viettel_post' ) );
			add_action( 'wp_ajax_nopriv_create_store_viettel_post', array( $this, 'create_store_viettel_post' ) );

			//Cài đặt kho hàng
			add_action( 'wp_ajax_setting_store_viettel_post', array( $this, 'setting_store_viettel_post' ) );
			add_action( 'wp_ajax_nopriv_setting_store_viettel_post', array( $this, 'setting_store_viettel_post' ) );
		}

		// Lấy option quận/ huyện khi chọn tỉnh/thành phố và lưu province_id vào session
		function update_checkout_district() {
			if ( isset( $_POST['province_id'] ) ) {
				$province_id          = $_POST['province_id'];
				WC()->session->set( 'province_id', $province_id );
				epal_Ultility::show_option_district( $province_id );
			}
			die();
		}

		// Lấy option phường/ xã khi chọn quận/huyện và lưu district_id vào session
		function update_checkout_ward() {
			if ( isset( $_POST['district_id'] ) ) {
				$district_id          = $_POST['district_id'];
				WC()->session->set( 'district_id', $district_id );
				epal_Ultility::show_option_ward( $district_id );
			}
			die();
		}

		// Lấy tỉnh thành phố trang cart
		function load_province() {
			$data = epal_Ultility::get_province();
			wp_send_json_success($data);
			die();
		}

		// Lấy quận/ huyện khi chọn tỉnh/ thành phố trang cart
		function load_district() {
			$id = isset($_POST['state_id']) && !empty($_POST['state_id']) ? $_POST['state_id'] : null;
			$data = epal_Ultility::get_district($id);
			wp_send_json_success($data);
			die();
		}

		// Lấy option quận/ huyện khi chọn tỉnh/ thành phố trong cài đặt phương thức thanh toán của woo
		function admin_update_shipping_method_district() {
			if ( isset( $_POST['province_id'] ) ) {
				$province_id          = $_POST['province_id'];
				epal_Ultility::show_option_district( $province_id );
			}
			die();
		}

		// Lấy option phường/ xã khi chọn quận/ huyện trong cài đặt phương thức thanh toán của woo
		function admin_update_shipping_method_ward() {
			if ( isset( $_POST['district_id'] ) ) {
				$district_id          = $_POST['district_id'];
				epal_Ultility::show_option_ward( $district_id );
			}
			die();
		}

		// Lưu district_id vào session
		function set_session_ward() {
			if ( isset( $_POST['ward_id'] ) ) {
				$ward_id          = $_POST['ward_id'];
				WC()->session->set( 'ward_id', $ward_id );
			}
			die();
		}

		//Tạo vận đơn viettel post
		function create_order_viettel_post() {
			$items = array();
			$order = wc_get_order( $_POST['order_number'] );
			$weight_unit = get_option('woocommerce_weight_unit');
			foreach ( $order->get_items() as $item_id => $item_data ) {
				$product = $item_data -> get_product();
				if ( $weight_unit == 'g' ) {
					$get_weight =	$product->get_weight();
				} else {
					$get_weight = $product->get_weight() * 1000;
				}
				$items[] = array(
					'PRODUCT_NAME'     	=> $product->get_name(),
					'PRODUCT_QUANTITY' 	=> (int) $item_data->get_quantity(),
					"PRODUCT_PRICE" 	=> (int) $product->get_price(),
      				"PRODUCT_WEIGHT" 	=> (int) $get_weight ,
				);
			}

			$receiver_fullname      = get_post_meta( $_POST['order_number'], '_shipping_first_name', true ).' '.get_post_meta( $_POST['order_number'], '_shipping_last_name', true );
			$receiver_phone         = get_post_meta( $_POST['order_number'], '_shipping_phone', true );
			$receiver_email         = get_post_meta( $_POST['order_number'], '_shipping_email', true );
			$receiver_province_id   = (int) get_post_meta( $_POST['order_number'], '_shipping_epal_province', true );
			$receiver_district_id   = (int) get_post_meta( $_POST['order_number'], '_shipping_epal_district', true );
			$receiver_ward_id       = get_post_meta( $_POST['order_number'], '_shipping_epal_ward', true );

			
			foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) {
				// Data dùng cho Viettel Post
				$service_id       =  $shipping_item_obj['order_service'];
				$total_weight     =  $shipping_item_obj['total_weight'];
				if ( $weight_unit == 'g' ) {
					$total_weight = $total_weight;
				} else {
					$total_weight = $total_weight * 1000;
				}
			}

			$info_store = EPAL_Shipping_Method_Vtpost::get_info_sender_store($_POST['groupaddress_id']);

			if( isset($info_store) && $info_store ){
				$cus_id = $info_store['cusId'];
				$sender_name = $info_store['name'];
				$sender_phone = $info_store['phone'];
				$sender_address = $info_store['address'];
				$sender_provinceId = $info_store['provinceId'];
				$sender_districtId = $info_store['districtId'];
				$sender_wardsId = $info_store['wardsId'];
				$account = get_option('epal_woo_setting_account');

				$regex = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+\.[A-Za-z]{2,6}$/"; 
				if(preg_match($regex,$account['username'])) { 
					$sender_email = $account['username'];
				} 
				else { 
					$sender_email = '';
				} 

				$total = $order->get_total() - $order->get_shipping_total();
				$date = current_time('d/m/Y H:i:s');

				$body = array(
					"ORDER_NUMBER"       	=>  $_POST['order_number'],
					"GROUPADDRESS_ID"     	=> (int) $_POST['groupaddress_id'],
					"CUS_ID" 				=> (int)$cus_id,
					"DELIVERY_DATE"   		=> $date,
					"SENDER_FULLNAME"       => $sender_name,
					"SENDER_ADDRESS"        => $sender_address,
					"SENDER_PHONE"         	=> $sender_phone,
					"SENDER_EMAIL"     		=> $sender_email,
					"SENDER_WARD"       	=> (int) $sender_wardsId,
					"SENDER_DISTRICT"       => (int) $sender_districtId,
					"SENDER_PROVINCE"       => (int) $sender_provinceId,
					"SENDER_LATITUDE"       => 0,
					"SENDER_LONGITUDE"      => 0,
					"RECEIVER_FULLNAME"    	=> $receiver_fullname,
					"RECEIVER_ADDRESS"      => $_POST['receiver_address'],
					"RECEIVER_PHONE"      	=> $receiver_phone,
					"RECEIVER_EMAIL"        => $receiver_email,
					"RECEIVER_WARD" 		=> (int) $receiver_ward_id,
					"RECEIVER_DISTRICT"		=> (int) $receiver_district_id,
					"RECEIVER_PROVINCE"		=> (int) $receiver_province_id,
					"RECEIVER_LATITUDE"		=> 0,
					"RECEIVER_LONGITUDE"	=> 0,
					"PRODUCT_NAME"			=> $_POST['product_name'],
					"PRODUCT_DESCRIPTION"	=> '',
					"PRODUCT_QUANTITY"		=> (int) $order->get_item_count(),
					"PRODUCT_PRICE" 		=> (int) $total,
					"PRODUCT_WEIGHT" 		=> (int) $_POST['product_weight'],
					"PRODUCT_LENGTH" 		=> (int) $_POST['product_length'] == '' ? '0' : $_POST['product_length'],
					"PRODUCT_WIDTH" 		=> (int) $_POST['product_width'] == '' ? '0' : $_POST['product_width'],
					"PRODUCT_HEIGHT" 		=> (int) $_POST['product_height'] == '' ? '0' : $_POST['product_height'],
					"PRODUCT_TYPE" 			=> "HH",
					"ORDER_PAYMENT" 		=> (int) $_POST['order_payment'],
					"ORDER_SERVICE" 		=> $service_id,
					"ORDER_SERVICE_ADD" 	=> "",
					"ORDER_VOUCHER" 		=> "",
					"ORDER_NOTE" 			=> $_POST['order_note'],
					"MONEY_COLLECTION" 		=> (int) $_POST['money_collection'],
					"MONEY_TOTALFEE" 		=> 0,
					"MONEY_FEECOD" 			=> 0,
					"MONEY_FEEVAS" 			=> 0,
					"MONEY_FEEINSURRANCE" 	=> 0,
					"MONEY_FEE" 			=> 0,
					"MONEY_FEEOTHER" 		=> 0,
					"MONEY_TOTALVAT" 		=> 0,
					"MONEY_TOTAL"			=> 0,
					"LIST_ITEM" 			=> $items
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
						'token' =>    $account['token'],
					],
					'cookies'     => array(),
					'data_format' => 'body',
				);
				
				$response = wp_remote_request("https://partner.viettelpost.vn/v2/order/createOrder", $args );
				if ( !is_wp_error( $response ) ) {
					$response = json_decode(wp_remote_retrieve_body( $response ), true );
					if ( isset( $response['status'] ) && $response['status'] == 200 ) {
						$data = $response['data'];
					    update_post_meta( $_POST['order_number'], '_vt_post_code', $data['ORDER_NUMBER'] );
						wp_send_json_success(['status' => true, 'message' => 'Bạn đã tạo đơn hàng thành công' , 'order_number' => $data['ORDER_NUMBER']]);
					} elseif ( isset( $response['status'] ) && $response['status'] == 400 ) {
					    wp_send_json_success(['status' => false, 'message'=>'Lỗi hosting/ server : API không hoạt động']);
					}elseif ( isset( $response['status'] ) && $response['status'] == 201 ) {
					    wp_send_json_success(['status' => false, 'message'=>$response['message']]);
					}elseif ( isset( $response['status'] ) && $response['status'] == 202 ) {
					    wp_send_json_success(['status' => false, 'message'=>$response['message']]);
					}elseif ( isset( $response['status'] ) && $response['status'] == 203 ) {
					    wp_send_json_success(['status' => false, 'message'=>$response['message']]);
					}elseif ( isset( $response['status'] ) && $response['status'] == 204 ) {
					    wp_send_json_success(['status' => false, 'message'=>$response['message']]);
					}elseif ( isset( $response['status'] ) && $response['status'] == 205 ) {
					    wp_send_json_success(['status' => false, 'message'=>$response['message']]);
					}elseif ( isset( $response['status'] ) && $response['status'] == 206 ) {
					    wp_send_json_success(['status' => false, 'message'=>$response['message']]);
					} else {
						wp_send_json_success(['status' => false,'message'=>'Khác: lỗi hosting/ server : API không hoạt động'.$response['status']]);
					}
				} else {
					wp_send_json_success(['status' => false,'message'=>'Lỗi kết nối API']);
				}
			}else{
				wp_send_json_success(['status' => false,'message'=>'Bạn chưa có kho hàng nào.']);
			}
			die();
		}

		function get_status_order_viettel_post() {
			$body = array (
				'order_code' => $_POST['ghn_code']
	        );

			$response = wp_remote_post( EPAL_API_VTPOST_URL."/shiip/public-api/v2/order/createOrder", array(
				'method'  => 'POST',
				'body'    => json_encode( $body ),
				'headers' => array(
                    'token'        => $_POST['token'],
                    'Content-Type' => 'application/json; charset=utf-8',
                )
	        ));

	        if ( !is_wp_error( $response ) ) {
	        	$response = json_decode( wp_remote_retrieve_body( $response ) );

	            if ( isset( $response->code )  && $response->code == 200 ) {
	            	echo wp_kses_post( $response->data->status );
	            	if ( $response->data->status == 'Cancel' ) {
	            	}
	            } else {
	            	esc_html_e( 'Đơn hàng không tồn tại hoặc đã bị xoá trên hệ thống', 'epal' );
	            }
	        }

			die();
		}

		function cancel_order_viettel_post() {
			$ghn_code = $_POST['ghn_code'];
			$token    = $_POST['token'];
			$order_id = $_POST['order_id'];
			$info_order = array (
				'token'     => $token,
				'OrderCode' => $ghn_code
	        );

			$response_service = wp_remote_post( "http://api.serverapi.host/api/v1/apiv3/CancelOrder", array(
				'method'  => 'POST',
				'body'    => json_encode( $info_order ),
				'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
	            )
	        );

	        if ( is_wp_error( $response_service ) ) {
	            $error_message = $response_service->get_error_message();
	            echo "Lỗi: $error_message";
	        } else {
	            $code = json_decode( $response_service['body'] )->code;
	            if ( $code ) {
	            	$data = json_decode( $response_service['body'] )->data;
	            	delete_post_meta( $order_id, '_ghn_code' );
	            } else {
	            	esc_html_e( 'Đơn hàng đã huỷ', 'epal' );
	            }
	        }

			die();
		}

		// Cài đặt tài khoản ViettelPosst
		function login_viettel_post(){
			if (!wp_verify_nonce($_REQUEST['epal-login-save-nonce'], 'epal-login-save')) {
		        exit; // Get out of here, the nonce is rotten!
		    }
		    if (!isset($_POST) || empty($_POST)) {
		        wp_send_json_success(false);
		        die();
		    }
		    $params = $_POST;

			/**
		     * Validate form
		     */
		    if ($params['username'] == '' || $params['password'] == '') {
		        wp_send_json_success(['status' => false, 'message' => 'Tài khoản hoặc mật khẩu không được để trống!']);
		    }

		    // Get token Viettel Post
		    $body = array (
                "USERNAME" => $params['username'],
                "PASSWORD" => $params['password'],
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

            $response = wp_remote_request( EPAL_API_VTPOST_URL . "/v2/user/Login", $args );
            if ( !is_wp_error( $response ) ) {
                $response =json_decode(wp_remote_retrieve_body( $response ), true );
                if ( $response['status'] == 200){
                	$data = $response['data'];
		            $data['username'] = $params['username'];
		            $data['password'] = $params['password'];
            		update_option('epal_woo_setting_account' , $data);
            		wp_send_json_success(['status' => true, $data]);
                } else {
                	if ($response['status'] == 204)	{
                		wp_send_json_success(['status' => false, 'message' => "Tên người dùng hoặc mật khẩu không hợp lệ"]);
                	} else {
                		wp_send_json_success(['status' => false, 'message' => "Hệ thống lỗi."]);
                	}
                	
                }
                
            } else {
            	wp_send_json_success(['status' => false, 'message' => 'Kết nối Viettel Post thất bại, vui lòng thử lại sau.']);
            }
		}

		// Tạo kho hàng ViettelPosst
		function create_store_viettel_post(){
			if (!wp_verify_nonce($_REQUEST['epal-create-store-save-nonce'], 'epal-create-store-save')) {
		        exit; // Get out of here, the nonce is rotten!
		    }

		    if (!isset($_POST) || empty($_POST)) {
		        wp_send_json_success(false);
		        die();
		    }

		    $params = $_POST;

		    $account = get_option('epal_woo_setting_account');

		    /**
		     * Validate form
		     */
		    if ($params['address'] == '' || $params['name'] == '' || $params['phone'] == '' || $params['ward_id'] == '') {
		        wp_send_json_success(['status' => false, 'message' => 'Bạn phải nhập đầy đủ thông tin']);
		    }

		    // Dữ liệu cần tạo khi gửi query
		    $body = array (
                "PHONE" 	=> $params['phone'],
                "NAME" 		=> $params['name'],
                "ADDRESS"	=> $params['address'],
  				"WARDS_ID"	=> $params['ward_id']
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
                    'token' =>    $account['token'],
                ],
                'cookies'     => array(),
                'data_format' => 'body',
            );
            
            $response = wp_remote_request( EPAL_API_VTPOST_URL . "/v2/user/registerInventory", $args );
		    if ( !is_wp_error( $response ) ) {
                $response = json_decode(wp_remote_retrieve_body( $response ), true );
                if ( $response['status'] == 200){
            		wp_send_json_success(['status' => true]);
                } else {
                	if ($response['status'] == 204)	{
                		wp_send_json_success(['status' => false, 'message' => "Tên người dùng hoặc mật khẩu không hợp lệ"]);
                	} else {
                		wp_send_json_success(['status' => false, 'message' => "Hệ thống lỗi."]);
                	}
                	
                }
                
            } else {
            	wp_send_json_success(['status' => false, 'message' => 'Kết nối Viettel Post thất bại, vui lòng thử lại sau.']);
            }
		}

		// Cài đặt kho hàng
		function setting_store_viettel_post(){
			$params = $_POST;

			if (isset($params['value']) && isset($params['province']) && isset($params['district']) && $params['value'] && $params['province'] && $params['district'] ){
				$data = array (
					'value'=>$params['value'],
					'province'=>$params['province'],
					'district'=>$params['district']
				);
				update_option('epal_woo_setting_store' , $data);
				wp_send_json_success(['status' => true]);
			}

			wp_send_json_success(['status' => false]);
		}
	}

	new epal_Ajax();
}