<?php
/**
 * Plugin Name:       Thanh Toán Quét Mã QR API- Momo
 * Plugin URI:        testwp.epalshop.com
 * Description:       Thanh toán quét mã QR, hổ trợ Momo
 * Version:           0.0.1
 * Author:            Epal
 * Author URI:        Epal.vn
 * Text Domain:       testwp.epalshop.com
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MC_QUETMA_VERSION', '1.0.2' );
define( 'MC_QUETMA_PLUGIN_URL', esc_url( plugins_url( '', __FILE__ ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mc-quetma-activator.php
 */
function activate_mc_quetma() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mc-quetma-activator.php';
	Mc_Quetma_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mc-quetma-deactivator.php
 */
function deactivate_mc_quetma() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mc-quetma-deactivator.php';
	Mc_Quetma_Deactivator::deactivate();
}



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mc_quetma() {

	$plugin = new Mc_Quetma();
	$plugin->run();

 }


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
	register_activation_hook( __FILE__, 'activate_mc_quetma' );
	register_deactivation_hook( __FILE__, 'deactivate_mc_quetma' );
	require plugin_dir_path( __FILE__ ) . 'includes/class-mc-quetma.php';

	run_mc_quetma();
}

function mc_quetma_installed_notice() {
	if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	    $class = 'notice notice-error';
		$message = __( 'Plugin Thanh Toán Quét Mã QR cần Woocommerce kích hoạt trước khi sử dụng. Vui lòng kiểm tra Woocommerce', 'qr_auto' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }
}
add_action( 'admin_notices', 'mc_quetma_installed_notice' );

function filter_woocommerce_thankyou_order_received_text( $var, $order ) { 
	$order = new WC_Order($order_id);
    $error= $_GET['errorCode'];
	switch ($error) {
        case '0':
            $var= "đã được thanh toán";
            break;
        case '1':
        	$var= "đã nhận";
        break;
        default:
			$var= "đã nhận";
        break;
    } 
	return 'Cám ơn. Đơn hàng của bạn '.$var; 
}
add_filter( 'woocommerce_thankyou_order_received_text', 'filter_woocommerce_thankyou_order_received_text', 10, 2 ); 