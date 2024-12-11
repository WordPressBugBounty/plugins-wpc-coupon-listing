<?php
/*
Plugin Name: WPC Coupon Listing for WooCommerce
Plugin URI: https://wpclever.net/
Description: WPC Coupon Listing will display coupons in a list on the cart and checkout page for the buyer easy to use.
Version: 1.3.1
Author: WPClever
Author URI: https://wpclever.net
Text Domain: wpc-coupon-listing
Domain Path: /languages/
Requires Plugins: woocommerce
Requires at least: 4.0
Tested up to: 6.7
WC requires at least: 3.0
WC tested up to: 9.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

! defined( 'WPCCL_VERSION' ) && define( 'WPCCL_VERSION', '1.3.1' );
! defined( 'WPCCL_LITE' ) && define( 'WPCCL_LITE', __FILE__ );
! defined( 'WPCCL_FILE' ) && define( 'WPCCL_FILE', __FILE__ );
! defined( 'WPCCL_URI' ) && define( 'WPCCL_URI', plugin_dir_url( __FILE__ ) );
! defined( 'WPCCL_DIR' ) && define( 'WPCCL_DIR', plugin_dir_path( __FILE__ ) );
! defined( 'WPCCL_REVIEWS' ) && define( 'WPCCL_REVIEWS', 'https://wordpress.org/support/plugin/wpc-coupon-listing/reviews/?filter=5' );
! defined( 'WPCCL_CHANGELOG' ) && define( 'WPCCL_CHANGELOG', 'https://wordpress.org/plugins/wpc-coupon-listing/#developers' );
! defined( 'WPCCL_DISCUSSION' ) && define( 'WPCCL_DISCUSSION', 'https://wordpress.org/support/plugin/wpc-coupon-listing' );
! defined( 'WPC_URI' ) && define( 'WPC_URI', WPCCL_URI );

include 'includes/dashboard/wpc-dashboard.php';
include 'includes/kit/wpc-kit.php';
include 'includes/hpos.php';

if ( ! function_exists( 'wpccl_init' ) ) {
	add_action( 'plugins_loaded', 'wpccl_init', 11 );

	function wpccl_init() {
		if ( ! function_exists( 'WC' ) || ! version_compare( WC()->version, '3.0', '>=' ) ) {
			add_action( 'admin_notices', 'wpccl_notice_wc' );

			return null;
		}

		if ( ! class_exists( 'WPCleverWpccl' ) && class_exists( 'WC_Product' ) ) {
			class WPCleverWpccl {
				public function __construct() {
					require_once trailingslashit( WPCCL_DIR ) . 'includes/class-helper.php';
					require_once trailingslashit( WPCCL_DIR ) . 'includes/class-backend.php';
					require_once trailingslashit( WPCCL_DIR ) . 'includes/class-frontend.php';
				}
			}

			new WPCleverWpccl();
		}
	}
}

if ( ! function_exists( 'wpccl_notice_wc' ) ) {
	function wpccl_notice_wc() {
		?>
        <div class="error">
            <p><strong>WPC Coupon Listing</strong> requires WooCommerce version 3.0 or greater.</p>
        </div>
		<?php
	}
}
