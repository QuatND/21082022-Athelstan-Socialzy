<?php

if ( !class_exists( 'epal_Custom_Fields_Order' ) ) {
	class epal_Custom_Fields_Order {

		function __construct() {

			// Thêm các fields quận/huyện và xã/phường và truyền id để sử dụng trong format.
			add_filter( 'woocommerce_get_order_address', array( $this, 'epal_woocommerce_get_order_address' ), 3, 999 );

			// Tuỳ chỉnh format thông tin thanh toán và thông tin giao hàng.
			add_filter( 'woocommerce_localisation_address_formats', array( $this, 'epal_woocommerce_localisation_address_formats' ), 999 );

			// Khai cách replace mảng và xử lý dữ liệu các fields mới vào, thay id bằng tên.
			add_filter( 'woocommerce_formatted_address_replacements', array( $this, 'epal_woocommerce_formatted_address_replacements' ), 2, 999 );

			// Khai báo các fields nào được hiển thị, fields nào không và label của chúng khi xem chi tiết 1 order trong admin thông qua giá trị show
			add_filter( 'woocommerce_admin_billing_fields', array( $this, 'epal_woocommerce_admin_billing_fields' ), 999 );
			add_filter( 'woocommerce_admin_shipping_fields', array( $this, 'epal_woocommerce_admin_shipping_fields' ), 999 );

			// Gõ bỏ các fields không sử dụng.
			add_filter( 'woocommerce_order_formatted_billing_address', array( $this, 'epal_woocommerce_order_formatted_billing_address' ), 999 );
			add_filter( 'woocommerce_order_formatted_shipping_address', array( $this, 'epal_woocommerce_order_formatted_shipping_address' ), 999 );

			// Thêm box tạo vận đơn vào sidebar trong admin
			add_action( 'add_meta_boxes', array( $this, 'epal_add_meta_boxes' ), 30 );
		}

		function epal_woocommerce_get_order_address( $array, $type, $order ) {
			$shipping_province_id = get_post_meta( $order->get_id(), '_shipping_epal_province', true );
			$shipping_district_id = get_post_meta( $order->get_id(), '_shipping_epal_district', true );
			$shipping_ward_id     = get_post_meta( $order->get_id(), '_shipping_epal_ward', true );

			$billing_province_id = get_post_meta( $order->get_id(), '_billing_epal_province', true );
			$billing_district_id = get_post_meta( $order->get_id(), '_billing_epal_district', true );
			$billing_ward_id     = get_post_meta( $order->get_id(), '_billing_epal_ward', true );

			if ( $type === 'billing' ) {
				$array['province'] = $billing_province_id;
				$array['district'] = $billing_district_id;
				$array['ward']     = $billing_ward_id;
			} elseif ( $type === 'shipping' ) {
				$array['province'] = $shipping_province_id;
				$array['district'] = $shipping_district_id;
				$array['ward']     = $shipping_ward_id;
			}

			return $array;
		}

		function epal_woocommerce_localisation_address_formats( $array ) {
			$array['default'] = "Họ Tên : {name}\nCông Ty : {company}\nĐịa Chỉ : {address_1}\nPhường/ Xã : {ward}\nQuận/ Huyện : {district}\nTỉnh/ Thành Phố: {province}";
			$array['VN'] = "Quận/ Huyện : {district}, Tỉnh/ Thành Phố : {province}";
			return $array;
		}

		function epal_woocommerce_formatted_address_replacements( $array, $args ) {
			 
			if ( isset( $args['province'] ) && $args['province'] ) {
				$province_id = $args['province'];
			}

			if ( isset( $args['district'] ) && $args['district'] ) {
				$district_id = $args['district'];
			}

			if ( isset( $args['ward'] ) && $args['ward'] ) {
				$ward_id     = $args['ward'];
			}

			if ( isset( $province_id ) && $province_id ) {
				$array['{province}'] = epal_Ultility::get_detail_province( $province_id );
			} else {
				$array['{province}'] = '';
			}

			if ( isset( $district_id ) && $district_id ) {
				$array['{district}'] = epal_Ultility::get_detail_district( $province_id , $district_id );
			} else {
				$array['{district}'] = '';
			}

			if ( isset( $ward_id ) && $ward_id ) {
				$array['{ward}'] = epal_Ultility::get_detail_ward($district_id, $ward_id );
			} else	{
				$array['{ward}'] = '';
			}

			return $array;
		}

		function epal_woocommerce_admin_billing_fields( $array ) {
			$array['company']['show'] = false;

			return $array;
		}

		function epal_woocommerce_admin_shipping_fields( $array ) {
			$array['company']['show'] = false;
			$array['phone']['label']  = esc_html__( 'Điện Thoại', 'epal' );
			$array['phone']['show']   = true;

			return $array;
		}

		function epal_woocommerce_order_formatted_billing_address( $array ) {
			unset($array['address_2']);
			unset($array['state']);
			unset($array['postcode']);
			unset($array['country']);

			return $array;
		}

		function epal_woocommerce_order_formatted_shipping_address( $array ) {
			unset($array['address_2']);
			unset($array['state']);
			unset($array['postcode']);
			unset($array['country']);

			return $array;
		}

		// Thêm box tạo vận đơn vào sidebar trong admin
		public function epal_add_meta_boxes() {
			$screen    = get_current_screen();
			$screen_id = $screen ? $screen->id : '';

			// Orders.
			foreach ( wc_get_order_types( 'order-meta-boxes' ) as $type ) {
				$order_type_object = get_post_type_object( $type );
				add_meta_box( 'woocommerce-shipping-actions', esc_html__( 'Vận Đơn', 'epal' ), 'epal_Custom_Fields_Order::output', $type, 'side', 'high' );
			}
		}

		public static function output( $post ) {
			?>
			<ul class="shipping_actions submitbox">

				<?php do_action( 'epal_woocommerce_shipping_actions_start', $post->ID ); ?>

				<li class="wide" id="actions">
					<?php
						$order                = wc_get_order( $post->ID );
						$order_data           = $order->get_data();
						
						$payment_method = $order->get_payment_method();
						$payment_method_title = $order->get_payment_method_title();
						$shipping_total = $order->get_shipping_total();

						$recipient_fullname      = get_post_meta( $post->ID, '_shipping_first_name', true ).' '.get_post_meta( $post->ID, '_shipping_last_name', true );
						$recipient_phone         = get_post_meta( $post->ID, '_shipping_phone', true );
						$recipient_email         = get_post_meta( $post->ID, '_shipping_email', true );
						$recipient_province_id   = (int) get_post_meta( $post->ID, '_shipping_epal_province', true );

						$recipient_province_name = epal_Ultility::get_detail_province( $recipient_province_id );
						$recipient_district_id   = (int) get_post_meta( $post->ID, '_shipping_epal_district', true );
						$recipient_district_name = epal_Ultility::get_detail_district( $recipient_province_id,$recipient_district_id );
						$recipient_ward_id       = get_post_meta( $post->ID, '_shipping_epal_ward', true );
						$recipient_ward_name     = epal_Ultility::get_detail_ward($recipient_district_id, $recipient_ward_id );
						$recipient_address       = get_post_meta( $post->ID, '_shipping_address_1', true ).', '. $recipient_ward_name.', '. $recipient_district_name.', '.$recipient_province_name;
						// Get Order Payment Details
						foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) {
							// Data dùng cho Viettel Post
							$service_id       =  $shipping_item_obj['order_service'];

							$total_weight     =  $shipping_item_obj['total_weight'];

							$shipping_method_title     = $shipping_item_obj->get_method_title();
						    $shipping_method_id        = $shipping_item_obj->get_method_id(); // The method ID
						    $shipping_method_total     = $shipping_item_obj->get_total();
						}
						
						if ( isset( $recipient_province_id ) && isset( $recipient_district_id ) && $recipient_province_id > 0 && $recipient_district_id > 0) {
							if (isset( $total_weight ) && isset( $service_id )){
								if ( $shipping_method_id == 'epal_shipping_vtpost' ){
									$sender_data = new EPAL_Shipping_Method_Vtpost();

									$store_data_id = EPAL_Shipping_Method_Vtpost::get_sender_store();
									$store_data_province = EPAL_Shipping_Method_Vtpost::get_sender_province();
									$store_data_district = EPAL_Shipping_Method_Vtpost::get_sender_district();

									// Néu chưa cấu hình giao hàng nhanh trong setting woo
									if ( isset( $store_data_id ) && isset( $store_data_province ) && isset( $store_data_district ) && $store_data_id && $store_data_province && $store_data_district
									){
										$cod_fee = 0;
										if ($payment_method == 'cod') {
											$cod_fee = $order_data['total'] - $shipping_method_total;
										}
										$vtpost_code_exist = get_post_meta( $post->ID, '_vt_post_code', true );
										if ( !$vtpost_code_exist ){
										?>
										<div class="cd-popup-trigger epal-create-order"><?php esc_html_e( 'TẠO VẬN ĐƠN', 'epal' ); ?></div>
										<div class="cd-popup" role="alert">
											<div class="cd-popup-container">
												<form id="createOrder" method="post">
													<div id="epal-modal-create-order-shipping-vp">
													    <div id="create_order">
													    	<div class="epal-row"><h3 style="margin: 0 0 30px 0;">Đăng đơn hàng lên Viettel Post</h3></div>
													    	<div class="epal-row">
												                <div class="epal-col-5 shipping-custom-fields-order">
												                    <div class="epal-col-12 card-header">
												                        <div class="title"><?php esc_html_e( 'Người gửi', 'epal' ); ?></div>
												                    </div>
												                    <div class="sub-content">
																		<div class="epal-row item">
												                            <div class="epal-col-12">
												                            	<select name="groupaddress_id">
												                            		<?php 
																					$listStore = epal_Ultility::get_store();
																					$store = get_option('epal_woo_setting_store');
																					?>
												                            		<?php if (count($listStore) > 0): foreach($listStore as $value) : ?>
												                                	<option value="<?php echo $value['groupaddressId'] ?>" <?php echo $store['value'] == $value['groupaddressId'] ? 'selected' : '' ?>><?php echo '#'.$value['groupaddressId'].' - '.$value['name'].' - '.$value['phone'] ?></option>
												                                	<?php endforeach; endif; ?>
												                                </select>
												                            </div>
												                        </div>
												                    </div>
												                </div>
												                <div class="epal-col-7 recipient">
												                    <div class="epal-col-12 card-header">
												                        <div class="title"><?php esc_html_e( 'Người nhận', 'epal' ); ?></div>
												                        <i class="fa fa-angle-up"></i>
												                    </div>
												                    <div class="sub-content">
												                        <div class="epal-row item">
												                            <div class="epal-col-3">
												                                <label><?php esc_html_e( 'Họ tên:', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-9">
												                                <?php echo wp_kses_post( $recipient_fullname ); ?>
																				<input type="text" name="receiver_fullname" value="<?php echo $recipient_fullname; ?>" hidden>
																				<input type="text" name="receiver_email" value="<?php echo $recipient_email; ?>" hidden>
												                            </div>
												                        </div>
												                        <div class="epal-row item">
												                            <div class="epal-col-3">
												                                <label><?php esc_html_e( 'Số điện thoại:', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-9">
												                                <?php echo wp_kses_post( $recipient_phone ); ?>
																				<input type="text" name="receiver_phone" value="<?php echo $recipient_phone; ?>" hidden>
												                            </div>
												                        </div>
												                        <div class="epal-row item">
												                            <div class="epal-col-3">
												                                <label><?php esc_html_e( 'Địa chỉ:', 'epal' ); ?></label>
												                            </div>
												                           	<div class="epal-col-9">
												                                <?php echo wp_kses_post( $recipient_address ); ?>
																				<input type="text" name="receiver_address" value="<?php echo $recipient_address; ?>" hidden>
												                            </div>
												                        </div>
												                        <div class="epal-row item">
												                            <div class="epal-col-3">
												                                <label><?php esc_html_e( 'Xã/ Phường:', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-9">
												                                <?php echo wp_kses_post( $recipient_ward_name ); ?>
																				<input type="text" name="receiver_ward" value="<?php echo $recipient_ward_id; ?>" hidden>
												                            </div>
												                        </div>
												                        <div class="epal-row item">
												                            <div class="epal-col-3">
												                                <label><?php esc_html_e( 'Quận/ Huyện:', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-9">
												                                <?php echo wp_kses_post( $recipient_district_name ); ?>
																				<input type="text" name="receiver_district" value="<?php echo $recipient_district_id; ?>" hidden>
												                            </div>
												                        </div>
												                       	<div class="epal-row item">
												                            <div class="epal-col-3">
												                                <label><?php esc_html_e( 'Tỉnh/ Thành Phố:', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-9">
												                                <?php echo wp_kses_post( $recipient_province_name ); ?>
																				<input type="text" name="receiver_province" value="<?php echo $recipient_province_id; ?>" hidden>
												                            </div>
												                        </div>
												                    </div>
												                </div>
												            </div>
												            <hr>
												            <div class="epal-row">
												                <div class="epal-col-6 parcel">
												                    <div class="epal-col-12 card-header">
												                        <div class="title"><?php esc_html_e( 'Thông Tin Hàng Hoá', 'epal' ); ?></div>
												                        <i class="fa fa-angle-up"></i>
												                    </div>
												                    <div class="sub-content">
												                        <div class="epal-row order">
												                            <div class="epal-col-5">
												                                <label><?php esc_html_e( 'Mã đơn hàng:', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-7">
												                                <?php echo wp_kses_post( '#'.$post->ID ); ?>
																				<input type="text" name="order_number" value="<?php echo $post->ID; ?>" hidden>
												                            </div>
												                        </div>
																		<div class="epal-row">
											                                <div class="epal-col-5">
											                                    <label for="#product_name">Tên gói hàng<span class="required"> *</span>:</label>
											                                </div>
											                                <div class="epal-col-7">
											                                    <input name="product_name" id="product_name" style="width:100%" type="text" value="" placeholder="Nhập tên gói hàng">
											                                </div>
											                            </div>
												                        <div class="epal-row">
											                                <div class="epal-col-5">
											                                    <label for="#product_price"><?php esc_html_e( 'Giá trị gói hàng:', 'epal' ); ?></label>
											                                </div>
											                                <div class="epal-col-7">
											                                    <input name="product_price" id="product_price" style="width:100%" type="text" value="<?php echo number_format( $cod_fee ).' VNĐ'; ?>" disabled>
											                                </div>
											                            </div>
												                       	<div class="epal-row">
												                            <div class="epal-col-5">
												                                <label><?php esc_html_e( 'Khối lượng (gram):', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-7">
												                            	<input name="product_weight" type="text" value="<?php echo wp_kses_post( $total_weight ); ?>" required>
												                            </div>
												                        </div>
																		<div class="epal-row">
												                            <div class="epal-col-4">
												                                <label><?php esc_html_e( 'Kích thước(cm):', 'epal' ); ?></label>
												                            </div>
												                            <div class="epal-col-8 epal-row" style="padding-right:0;flex-direction: row-reverse;">
																				<input style="width:30.333%" name="product_length" type="text" value="" placeholder="Dài(cm)">
																				<input style="width:36.333%" name="product_width" type="text" value="" placeholder="Rộng(cm)">
																				<input style="width:30.333%" name="product_height" type="text" value="" placeholder="Cao(cm)">
												                            </div>
												                        </div>
												                        <div class="epal-row">
												                            <div class="epal-col-5">
												                                <label>Chú ý <span class="required">*</span>:</label>
												                            </div>
												                            <div class="epal-col-7">
												                                <select name="order_note">
												                                	<option value="Không cho xem hàng"><?php esc_html_e( 'Không cho xem hàng', 'epal' ); ?></option>
												                                	<option value="Cho xem hàng không thử"><?php esc_html_e( 'Cho xem hàng, không thử', 'epal' ); ?></option>
												                                	<option value="Cho xem thử hàng"><?php esc_html_e( 'Cho thử hàng', 'epal' ); ?></option>
												                                </select>
												                            </div>
												                        </div>
												                    </div>
												                </div>
												                <div class="epal-col-6 package">
												                    <div class="epal-col-12 card-header">
												                        <div class="title"><?php esc_html_e( 'Gói Cước', 'epal' ); ?></div>
												                        <i class="fa fa-angle-up"></i>
												                    </div>
												                    <div class="sub-content">
												                    	<div class="epal-row">
											                                <div class="epal-col-7">
											                                    <label for="#money_collection"><?php esc_html_e( 'Tiền thu hộ (COD)(VNĐ):', 'epal' ); ?></label>
											                                </div>
											                                <div class="epal-col-5">
											                                    <input name="money_collection" id="money_collection" style="width:100%" type="text" value="<?php echo wp_kses_post( $cod_fee ); ?>">
											                                </div>
											                            </div>
											                            <div class="epal-row">
											                                <div class="epal-col-5">
											                                    <label><?php esc_html_e( 'Loại vận đơn:', 'epal' ); ?></label>
											                                </div>
											                                <div class="epal-col-7">
											                                    <select name="order_payment">
												                                	<option value="1"><?php esc_html_e( 'Không thu tiền', 'epal' ); ?></option>
												                                	<option value="2" selected><?php esc_html_e( 'Thu hộ tiền cước và tiền hàng', 'epal' ); ?></option>
												                                	<option value="3"><?php esc_html_e( 'Thu hộ tiền hàng', 'epal' ); ?></option>
												                                	<option value="4"><?php esc_html_e( 'Thu hộ tiền cước', 'epal' ); ?></option>
												                                </select>
											                                </div>
											                            </div>
																		<div class="epal-row">
											                                <div class="epal-col-3">
											                                    <label><?php esc_html_e( 'Dịch vụ:', 'epal' ); ?></label>
											                                </div>
											                                <div class="epal-col-9">
											                                    <div class="radio">
																					<input name="order_service" id="order_service" value="<?php echo $service_id ?>" type="radio" checked style="width:auto;position:relative;top:7px">
																					<label for="order_service" style="font-weight: 400;"><?php echo number_format($shipping_total).'đ - '.$service_id.': '.str_replace('Viettel Post:','',$shipping_method_title) ?></label>
																				</div>
											                                </div>
											                            </div>
												                    </div>
												                </div>
												            </div>
												            <hr>
											                <div class="epal-row">
											                    <div class="epal-col-12">
											                        <div class="title"><?php esc_html_e( 'Cước Phí', 'epal' ); ?></div>
											                        <div class="desc"><?php esc_html_e( 'Thời gian và chi phí giao hàng được tính tại thời điểm khách hàng đặt hàng. Chi phí và thời gian giao hàng dự kiến có thể sẽ thay đổi nếu Viettel Post thay đổi biểu phí tại thời điểm tạo vận đơn', 'epal' ); ?></div>
											                    </div>
											                </div>
											                <div class="epal-row">
											                	<div class="epal-col-12">
											                		<div class="epal-response"></div>
											                	</div>
											                </div>
															<div class="epal-row">
																<div class="epal-col-12" style="text-align: center;">
																	<button type="submit" class="button button-primary epal-submit-order-shipping-vp"><?php esc_html_e( 'Đăng Đơn', 'epal' ); ?></button>
																</div>
															</div>
											            </div>
													</div>
												</form>
												<a href="#0" class="cd-popup-close img-replace">Close</a>
											</div> <!-- cd-popup-container -->
										</div> 
										<?php
										} else { ?>
										<div class="epal-exits">
											<div class="vp-code">
												<p><?php esc_html_e( 'Mã đơn Viettel Post', 'epal' ); ?></p>
												<p><?php echo $vtpost_code_exist; ?></p>
											</div>
											<div class="epal-viettel-post-status viettel-post-status" data-viettel_post_code="<?php echo esc_attr( $vtpost_code_exist ); ?>" >
												<p><?php esc_html_e( 'TRẠNG THÁI ĐƠN', 'epal' ); ?></p>
												<span></span>
											</div>
										</div>
									<?php
										}
									} else {
										esc_html_e( 'Bạn chưa nhập đầy đủ thông tin người gửi hàng hoặc chưa kích hoạt phương thức này trong cài đặt Viettel Post', 'epal' );
									}
								}
							}
							else {
								esc_html_e( 'Bạn không thể tạo vận đơn vì đơn hàng này không chọn giao hàng Viettel Post.', 'epal' );	
							}
						} else {
							esc_html_e( 'Bạn không thể tạo vận đơn vì đơn hàng này được tạo trước khi active Epal Shipping Viettel Post WooCommerce.', 'epal' );
						}
						
						?>
						
				</li>

				<?php do_action( 'epal_woocommerce_shipping_actions_end', $post->ID ); ?>

			</ul>
			<?php
		}
	}

	new epal_Custom_Fields_Order();
}