<?php
/**
 * Plugin Name: Epal Shipping Viettel Post WooCommerce
 * Description: Plugin hỗ trợ giao vận tại Việt Nam cho WooCommerce. Quản trị shop dễ dàng đăng vận đơn lên đơn vị giao vận tuỳ theo lựa chọn của khách hàng khi đặt hàng chỉ với 1 Click, cùng với đó là tra cứu trạng thái vận đơn ngay từ trang quản trị.
 * Version: 1.0.1
 * Author: Epal
 * Author URI: https://epal.vn/
 *
 */

define( 'epal_DIR', plugin_dir_url(__FILE__) );
define( 'epal_DIR_PATH', plugin_dir_path(__FILE__) );

define( 'EPAL_DIR_PATH', plugin_dir_path(__FILE__) );
define( 'EPAL_API_VTPOST_URL', 'https://partner.viettelpost.vn');

add_action( 'plugins_loaded', array( 'Epal_Shipping_Viettel_Post_Woocommerce', 'plugins_loaded' ) );
add_action( 'after_setup_theme', array( 'Epal_Shipping_Viettel_Post_Woocommerce', 'after_setup_theme' ), 5 );

class Epal_Shipping_Viettel_Post_Woocommerce {

	function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_script' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_script' ) );
        //add_action( 'woocommerce_shipping_methods', array( $this, 'register_shipping_methods' ) );
        add_filter( 'woocommerce_shipping_methods', array( $this, 'register_shipping_methods' ) );

        // Thêm thông tin khách hàng vào đơn hàng khi thêm sản phẩm vào giỏ
        add_filter( 'woocommerce_cart_shipping_packages', array( $this, 'add_shipping_packages' ) );

        //Options
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'register_mysettings'));

        add_action( 'load-tools_page_epal-setting', $this, 'epal_save_options' );

        add_option($this->_optionName, $this->_defaultOptions);

        add_shortcode('epal_traking_viettel_post', array( $this, 'render_tracking_form'));
	}

    function wp_enqueue_script() {
        if ( is_checkout() || is_cart()) {
            wp_enqueue_script( 'epal-select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), false, true );
            wp_enqueue_script( 'epal', epal_DIR.'assets/js/epal.js', array('jquery'), false, true );
            wp_enqueue_style( 'epal-select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', false, '1.0.0' );
            wp_localize_script( 'epal', 'epal', array(
                'ajax' => array(
                    'url' => admin_url( 'admin-ajax.php' )
                )
            ));
        }
    }

    function admin_enqueue_script() {
        $screen       = get_current_screen();
        $screen_id    = $screen ? $screen->id : '';
        
        wp_enqueue_style( 'epal-admin', epal_DIR.'assets/css/admin.css', false, '1.0.0' );

        if ( $screen_id == 'woocommerce_page_wc-settings' || $screen_id == 'shop_order' ) {
            wp_enqueue_script( 'epal-admin', epal_DIR.'assets/js/admin.js', array('jquery'), false, true );
            wp_localize_script( 'epal-admin', 'epal_admin_params', array(
                'ajax' => array(
                    'url' => admin_url( 'admin-ajax.php' )
                )
            ));
        }

        if ($screen_id == 'woocommerce_page_epal-setting'){
            wp_enqueue_script( 'epal-admin-setting', epal_DIR.'assets/js/admin-setting.js', array('jquery'), false, true );
            wp_localize_script( 'epal-admin-setting', 'epal_admin_params', array(
                'ajax' => array(
                    'url' => admin_url( 'admin-ajax.php' )
                )
            ));
        }
    }

    function register_shipping_methods( $methods ) {
        $methods['epal_shipping_vtpost'] = 'EPAL_Shipping_Method_Vtpost';
        return $methods;
    }

    // Thêm thông tin quận huyện vào package khi thêm sản phẩm vào giỏ hàng
    function add_shipping_packages( $packages ) {
        $province_id = WC()->session->get( 'province_id' );
        $district_id = WC()->session->get( 'district_id' );
        $ward_id     = WC()->session->get( 'ward_id' );
        
        if ( $province_id ) {
            $packages[0]['destination']['province'] = $province_id;
        } else {
            $packages[0]['destination']['province'] = get_user_meta( get_current_user_id(), 'billing_epal_province', true );
        }

        if ( $district_id ) {
            $packages[0]['destination']['district'] = $district_id;
        } else {
            $packages[0]['destination']['district'] = get_user_meta( get_current_user_id(), 'billing_epal_district', true );
        }

        if ( $ward_id ) {
            $packages[0]['destination']['ward'] = $ward_id;
        } else {
            $packages[0]['destination']['ward'] = get_user_meta( get_current_user_id(), 'billing_epal_ward', true );
        }

        return $packages;
    }

	public static function plugins_loaded() {
        include_once epal_DIR_PATH.'/class/shipping-custom-fields.php';
        include_once epal_DIR_PATH.'/class/shipping-custom-fields-order.php';
        include_once epal_DIR_PATH.'/class/shipping-method-vtpost.php';
        include_once epal_DIR_PATH.'/class/ajax.php';
        include_once epal_DIR_PATH.'/class/ultility.php';
	}

    function admin_menu() {
        add_submenu_page(
            'woocommerce',
            __('Epal Shipping Viettel Post', 'Epal'),
            __('Epal Shipping Viettel Post', 'Epal'),
            'manage_woocommerce',
            'epal-setting',
            array($this, 'epal_setting'),
            null
        );
    }

    function register_mysettings() {
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'login';
        
        if( isset( $_GET[ 'tab' ] ) ) {
            $active_tab = $_GET[ 'tab' ];
        } // end if
    }

    function epal_setting() {
        include 'class/options-page.php';
    }
    
    function render_tracking_form(){
        ?>
        <link href="<?php echo epal_DIR ?>/assets/css/tracking.css" rel="stylesheet" type="text/css">
        <div id="trackingContent">
            <div class="PaneTop"> <span class="title">Mã phiếu gửi (Tra nhiều bill bằng cách thêm dấu phẩy giữa các bill VD: 392773302,392447363)</span>
                <div class="PaneTopdiv1"> <input type="text" maxlength="220" id="txtSearch" class="input" placeholder="Mã phiếu gửi (Phân tách nhau bởi dấu , )"></div>
                <div class="PaneTopdiv2"> <img id="imgCaptcha" class="imgCaptcha" src=""> <input type="text" maxlength="220" id="txtCaptcha" class="input" placeholder="Nhập mã captcha..."> <input type="hidden" id="idCaptcha" value="34c49d31-8862-4edc-9861-43a7c9af92fe"><button type="button" id="btnSearch" class="button-tracking" onclick="trackOrder()">Tra cứu</button></div>
            </div>
            <div class="trackingItem">
                <div id="headerTracking"></div>
                <div id="contentTracking"></div>
            </div>
            <div id="multiTracking"></div>
        </div>
        <script src="<?php echo epal_DIR ?>/assets/js/epal-tracking.js" type="text/javascript" defer=""></script>
        <?php
    }

	public static function after_setup_theme() {
		new Epal_Shipping_Viettel_Post_Woocommerce();
	}
}