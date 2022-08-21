<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
include "helper.php";
/**
 * WC_Gateway_Paypal Class.
 */
class MomoQrScanGetWay extends QrScanGetWay {

	public function __construct() {
		//parent::__construct();
        $this->id                 = 'momo_qr_scan';
        $this->icon = sprintf("%s/public/images/logo-momo.png",MC_QUETMA_PLUGIN_URL);
        $this->has_fields         = false;
        //$this->order_button_text  = __( 'Thanh Toán', 'woocommerce' );
        $this->method_title       = __( 'Quét Mã QR Momo', 'woocommerce' );
        $this->method_description = 'Thanh toán qua cổng ứng dụng Momo';
        $this->supports           = array(
            'products',
            'refunds',
        );

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables.
        $this->title = $this->get_option( 'title' );
        $this->description = $this->get_option( 'description' );

        $this->partnercode = $this->get_option( 'partnercode' );
        $this->accesskey = $this->get_option( 'accesskey' );
        $this->serectkey = $this->get_option( 'serectkey' );
        $this->apienpoint = $this->get_option( 'apiendpoint' );
        $this->ordercodebefore = $this->get_option( 'ordercodebefore' );
      //  self::$log_enabled    = $this->debug;
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
        add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
    }
    public function init_form_fields() {
    
        $this->form_fields = array(
            'enabled' => array(
                'title' => __( 'Bật/Tắt', 'woocommerce' ),
                'type' => 'checkbox',
                'label' => __( 'Bật cổng thanh toán này', 'woocommerce' ),
                'default' => 'yes'
            ),
            'title' => array(
                'title' => __( 'Tên Cổng Thanh Toán', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Tên cổng thanh toán mà người dùng sẽ thấy khi thanh toán', 'woocommerce' ),
                'default' => 'Quét Mã MoMo',
                'desc_tip'      => true,
            ),
            'description' => array(
                'title' => __( 'Mô Tả Cho Khách', 'woocommerce' ),
                'type' => 'textarea',
                'description' => __( 'Đoạn mô tả giúp khách hiểu rõ hơn cách thức thanh toán', 'woocommerce' ),
                'default' => 'Hãy mở App Momo lên và nhấn Đặt Hàng để quét mã thanh toán'
            ),
            'partnercode' => array(
                'title' => __( 'PARTNER CODE', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Thông tin định danh tài khoản doanh nghiệp', 'woocommerce' ),
                'default' => '',
                'desc_tip' => true
            ),
            'accesskey' => array(
                'title' => __( 'ACCESS KEY', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Cấp quyền truy cập vào hệ thống MoMo', 'woocommerce' ),
                'default' => '',
                'desc_tip' => true
            ),
            'serectkey' => array(
                'title' => __( 'SECRET KEY', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Dùng để tạo chữ ký điện tử ', 'woocommerce' ),
                'default' => '',
                'desc_tip' => true
            ),
            'apiendpoint' => array(
                'title' => __( 'API ENDPOINT', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'API Endpoint', 'woocommerce' ),
                'default' => '',
                'desc_tip' => true
            ),
            'apiendpoint' => array(
                'title' => __( 'API ENDPOINT', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'API Endpoint', 'woocommerce' ),
                'default' => '',
                'desc_tip' => true
            ),
            'ordercodebefore' => array(
                'title' => __( 'Mã đơn hàng', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Tiền tố trước mã đơn hàng', 'woocommerce' ),
                'default' => '',
                'desc_tip' => true
            ),
        );
    }
    
    public function process_payment($order_id) {
        $order = wc_get_order($order_id);
        WC()->cart->empty_cart();
        return array(
            'result' => 'success',
            'redirect' => $this->redirect($order_id)
        );
    }
    
    public function redirect($order_id) {
       echo $order = wc_get_order($order_id);

        $endpoint=$this->apienpoint;

        $partnerCode=$this->partnercode;
        $accessKey=$this->accesskey;
        $serectKey = $this->serectkey;
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $order->order_total;
        $orderId =$this->ordercodebefore . $order->id;
        $returnUrl=$order->get_checkout_order_received_url();
        $notifyurl = $order->get_checkout_order_received_url();
        // Lưu ý: link notifyUrl không phải là dạng localhost
        $extraData = "merchantName=MoMo Partner";
        $requestId = time() . "";
        $requestType = "captureMoMoWallet";

        //before sign HMAC SHA256 signature
        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
        $signature = hash_hmac("sha256", $rawHash, $serectKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        if (curl_errno($ch)) {
            $error= curl_error($ch);
          }
        //close connection
        curl_close($ch);
       // $amount = number_format($order->order_total, 2, '.', '') * 100;

        return $jsonResult['payUrl'];
        //return 'http://momo.test/checkout/?'.$result;
    }
	public function thankyou_page( $order_id ) {
        $order = new WC_Order($order_id);
        $error= $_GET['errorCode'];
        if($error==0){
            $order->update_status('completed', 'order_note');
        }else{
            $order->update_status('pending', 'order_note');
        }
    }
}