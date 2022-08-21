<div class="wrap">
    <h1>Epal Shipping Viettel Post</h1>
    <p>Plugin được viết và phát triển bởi <a href="https://epal.vn/" target="_blank" title="Đến web của Epal">Epal</a></p>
    <?php
    $account = get_option('epal_woo_setting_account');

    $store = get_option('epal_woo_setting_store');
    
    if (isset($account['username']) && isset($account['password']) && isset($account['token']) && $account['username'] && $account['password'] && $account['token']){
        $textSubmit = 'Đổi tài khoản';
        $isLogin = true;
    } else {
        $textSubmit = 'Đăng nhập';
        $isLogin = false;
    }
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'login'; 
    ?>
<div id="tabs">
      <h2 class="nav-tab-wrapper">
        <a href="?page=epal-setting&tab=login" class="nav-tab <?php echo $active_tab == 'login' ? 'nav-tab-active' : ''; ?>">Login</a>
        <a href="?page=epal-setting&tab=store" class="nav-tab <?php echo $active_tab == 'store' ? 'nav-tab-active' : ''; ?>">Kho hàng</a>
      </h2>
    <?php if ($active_tab == 'login'): ?>
        <h2>Cài đặt thông tin ViettelPost</h2>
        <p>Ghi chú: bạn chưa có tài khoản, đăng ký tài khoản tại <a href="https://viettelpost.vn" target="_blank">viettelpost.vn</a></p>
        <div id="tab-content" class="tab-content">
            <?php if($isLogin == true): ?>
                <div class="infor">
                    <h4>Xin chào, <?php echo $account['username']; ?></h4>
                    <a href="#showLogin-vtp">Đổi tài khoản</a>
                </div>
            <?php endif; ?>
            <form id="login-vtp" method="post" class="<?php echo $isLogin == true ? "hidden" : "show" ?>">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label for="username"><?php _e('Tài khoản','epal')?></label></th>
                                <td>
                                    <label><input id="username" type="text" name="username" value="" /></label>                      
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="password"><?php _e('Mật khẩu','epal')?></label></th>
                                <td>
                                    <label><input id="password" type="password" name="password" value="" /></label>                      
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:0 ">
                                    <div id="epal-error" style="color:red"></div>
                                    <div id="epal-success" style="color:green"></div>
                                    <span id="time" style="display:none">3</span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><button type="submit" class="button button-primary" name="submit" data-text="<?php echo $textSubmit ?>"><?php echo $textSubmit ?><span class="spinner" style="display:none"></span></button></label>
                                    <?php wp_nonce_field( 'epal-login-save', 'epal-login-save-nonce' ); ?>
                                    <input type="text" hidden value="<?php echo $textSubmit ?>">
                                </th>
                            </tr>
                        </tbody>
                    </table>
            </form>
        </div>
    <?php else : ?>
        <h2>Quản lý kho</h2>
        <div id="tab-content" class="tab-content flex">
            <?php if ($isLogin == false): ?>
                <p>Bạn đăng nhập mới có thể xem kho</p>
            <?php else : ?>
            <?php $listStore = epal_Ultility::get_store(); ?>
                <?php if (count($listStore) > 0): ?>
                <?php foreach ($listStore as $key => $value) :  ?>
                <div class="table item">
                    <table id="table-<?php echo $value['groupaddressId'] ?>" data-province="<?php echo $value['provinceId'] ?>" data-district="<?php echo $value['districtId'] ?>" class="<?php echo $store['value'] == $value['groupaddressId'] ? 'active' : '' ?>">
                        <thead>
                            <tr>
                              <th scope="col" colspan="2">Kho <?php echo '#'.$value['groupaddressId'] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tên kho: <?php echo $value['name'] ?></td>
                                <td>Xã, Phường: <?php echo epal_Ultility::get_detail_ward($value['districtId'],$value['wardsId']) ?></td>
                            </tr>
                            <tr>
                                <td>SĐT: <?php echo $value['phone'] ?></td>
                                <td>Quận, Huyện: <?php echo epal_Ultility::get_detail_district($value['provinceId'],$value['districtId']) ?></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ: <?php echo $value['address'] ?></td>
                                <td>Tỉnh, Thành Phố: <?php echo epal_Ultility::get_detail_province($value['provinceId']) ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><input id="<?php echo $value['groupaddressId'] ?>" type=radio name="store_main" value="<?php echo $value['groupaddressId'] ?>" <?php echo $store['value'] == $value['groupaddressId'] ? 'checked' : '' ?>><label for="<?php echo $value['groupaddressId'] ?>">Đặt làm kho chính</label></td>
                            </tr>
                            <tr>
                                <td colspan="2">Khu vực bán hàng<br>Comming soon !</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endforeach;else: ?>
                <p>Bạn chưa có kho hàng nào</p>
                <?php endif; ?>
                <div class="table item">
                    <div class="add-stores">
                        <a href="#addStore" class="button button-primary"><span class="dashicons dashicons-plus"></span><?php if($listStore > 0){echo "Thêm kho hàng";}else{echo "Tạo kho hàng";} ?></a>
                    </div>
                </div>
                <?php  ?>
            <?php endif; ?>
        </div>
        <?php if ($isLogin == true): ?>
        <button id="submitSaveStore" class="button button-primary" disabled>Lưu thay đổi <span class="spinner" style="display:none"></span></button>
        <?php endif; ?>
        <div class="cd-popup" role="alert">
            <div class="cd-popup-container">
                    <div id="epal-modal-create-order-shipping-vp">
                        <form id="addStore" method="post">
                            <h3>Thêm kho hàng mới</h3>
                            <table class="form-table">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width:28%"><label for="name"><?php _e('Tên','epal')?></label></th>
                                        <td>
                                            <label><input id="name" type="text" name="name" value="" style="width:100%" placeholder="Ví dụ: Kho Sài Gòn" /></label>                      
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width:28%"><label for="phone"><?php _e('Số điện thoại','epal')?></label></th>
                                        <td>
                                            <label><input id="phone" type="text" name="phone" value="" style="width:100%" placeholder="Ví dụ: 0907090909" /></label>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width:28%"><label for="address"><?php _e('Tỉnh, Thành Phố','epal')?></label></th>
                                        <td>
                                            <label>
                                                <?php $getProvince = epal_Ultility::get_province(); ?>
                                                <select id="woocommerce_epal_shipping_vtpost_sender_province" style="width:100%">
                                                    <?php foreach($getProvince as $key => $value): ?>
                                                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width:28%"><label for="address"><?php _e('Quận, Huyện','epal')?></label></th>
                                        <td>
                                            <label>
                                                <select id="woocommerce_epal_shipping_vtpost_sender_district" style="width:100%">
                                                    <option value="">Chọn Quận/ Huyện</option>
                                                </select>
                                            </label>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width:28%"><label for="address"><?php _e('Phường, Xã','epal')?></label></th>
                                        <td>
                                            <label>
                                                <select name="ward_id" id="woocommerce_epal_shipping_vtpost_sender_ward" style="width:100%">
                                                    <option value="">Chọn Phường/ Xã</option>
                                                </select>
                                            </label>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width:28%"><label for="address"><?php _e('Địa chỉ','epal')?></label></th>
                                        <td>
                                            <label><input id="address" type="text" name="address" value="" style="width:100%" placeholder="Ví dụ: SN 001, hẻm 205" /></label>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding:0 ">
                                            <div id="epal-error" style="color:red"></div>
                                            <div id="epal-success" style="color:green"></div>
                                            <span id="time" style="display:none">3</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align:center">
                                            <label><button type="submit" class="button button-primary" name="submit">Tạo kho hàng<span class="spinner" style="display:none"></span></button></label>
                                            <?php wp_nonce_field( 'epal-create-store-save', 'epal-create-store-save-nonce' ); ?>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                <a href="#0" class="cd-popup-close img-replace">Close</a>
            </div>
        </div>
    <?php 
    endif;
    ?>
</div>