<?php

class Mc_Quetma_Public {

	private $plugin_name;

	private $version;

	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'plugins_loaded', array($this,'init_gateway_class') );
		add_filter( 'woocommerce_payment_gateways', array($this,'add_gateway_class') );
	}

	public function init_gateway_class() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/getways/qrscan-getway.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/getways/momo-getway.php';
	}

	public function add_gateway_class($methods ){
		$methods[] = 'MomoQrScanGetWay';
	    return $methods;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mc-quetma-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

	//	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mc-quetma-public.js', array( 'jquery' ), $this->version, false );

	}

}
