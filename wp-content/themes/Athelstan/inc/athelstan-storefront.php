<?php
/**
 * Athelstan Class
 *
 * @author   WooThemes
 * @since    2.0.0
 * @package  Athelstan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Athelstan' ) ) :
	class Athelstan {
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
		}
		public function setup() {
			// Declare WooCommerce support.
			add_theme_support( 'woocommerce', apply_filters( 'athelstan_woocommerce_args', array(
				'single_image_width'    => 416,
				'thumbnail_image_width' => 324,
				'product_grid'          => array(
					'default_columns' => 3,
					'default_rows'    => 4,
					'min_columns'     => 1,
					'max_columns'     => 6,
					'min_rows'        => 1
				)
			) ) );
		}
	}
endif;

return new Athelstan();