<?php
/**
 * Plugin Name: WC Secondary Product Thumbnail
 * Plugin URI: https://wordpress.org/plugins/wc-secondary-product-thumbnail/
 * Description: WC Secondary Product Thumbnail (WCSPT) adds a hover effect that will reveal a secondary product thumbnail to product images on your WooCommerce product listings.
 * Version: 1.3.2
 * Author: Hendy Tarnando
 * Author URI: https://www.thewebflash.com/
 * Text Domain: wc-secondary-product-thumbnail
 * License: GPLv3
 * WC requires at least: 2.2
 * WC tested up to: 3.2
 */

/**
 * Copyright (c) 2015-2018 Hendy Tarnando <https://www.thewebflash.com/contact/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( ! class_exists( 'WCSPT' ) ) {

	/**
	 * WCSPT class
	 */
	class WCSPT {
		
		/**
		 * Plugin version.
		 *
		 * @var string
		 */
		const VERSION = '1.3.2';
		
		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;
		
		/**
		 * Initialize the plugin.
		 */
		private function __construct() {
			$this->register_update_hooks();
			
			if ( $this->is_woocommerce_activated() ) {
				if ( ! is_admin() ) {
					add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_scripts' ) );
					add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_secondary_product_thumbnail' ), 10 );
					add_filter( 'post_class', array( $this, 'set_product_post_class' ), 21, 3 );
				}
			} else {
				add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
			}
		}
		
		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		
		/**
		 * WCSPT update hooks.
		 */
		private function register_update_hooks() {
			add_action( 'upgrader_process_complete', array( $this, 'wcspt_update_complete' ), 10, 2 );
			
			if ( is_admin() ) {
				add_action( 'all_admin_notices', array( $this, 'wcspt_update_complete_notice' ) );
				add_action( 'wp_ajax_dismiss_wcspt_update_notice', array( $this, 'dismiss_update_notice' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_notices_script' ) );
			}
		}
		
		/**
		 * WCSPT update complete function.
		 */
		public function wcspt_update_complete( $upgrader_object, $options ) {
			if( $options['action'] === 'update' && $options['type'] === 'plugin' ) {
				$this_plugin = plugin_basename( __FILE__ );
				
				if ( ( isset( $options['plugins'] ) && in_array( $this_plugin, $options['plugins'] ) ) ||
					( isset( $options['plugin'] ) && $options['plugin'] === $this_plugin )
				) {
					set_transient( 'wcspt_updated', 1, 3 * DAY_IN_SECONDS );
				}
			}
		}
		
		/**
		 * WCSPT updated notice.
		 */
		public function wcspt_update_complete_notice() {
			if( get_transient( 'wcspt_updated' ) && current_user_can( 'update_plugins' ) ) {
				$classes = 'notice notice-success is-dismissible wcspt-update-notice';
				$line1 = __( 'Thank you for using WC Secondary Product Thumbnail.', 'wc-secondary-product-thumbnail' );
				$line2 = sprintf( __( 'If you like this plugin and find it useful, you can show your appreciation and support future development by %1$sdonating%2$s.', 'wc-secondary-product-thumbnail' ),
					'<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6AD46HAX3URN4" target="_blank">', '</a>');
				
				printf( '<div class="%1$s"><p>%2$s</p><p>%3$s</p></div>', $classes, $line1, $line2 );
			}
		}
		
		/**
		 * Dismiss update notice.
		 */
		public function dismiss_update_notice() {
			delete_transient( 'wcspt_updated' );
		}
		
		/**
		 * WooCommerce missing notice.
		 */
		public function woocommerce_missing_notice() {
			$classes = 'notice notice-error';
			$message = sprintf( __( '%1$sWC Secondary Product Thumbnail%2$s requires %1$sWooCommerce%2$s to be activated to work.', 'wc-secondary-product-thumbnail' ),
				'<strong>', '</strong>');
			
			printf( '<div class="%1$s"><p>%2$s</p></div>', $classes, $message );
		}
		
		/**
		 * Query whether WooCommerce is activated.
		 */
		public function is_woocommerce_activated() {
			return class_exists( 'WooCommerce' ) ? true : false;
		}
		
		/**
		 * Enqueue WCSPT admin notices script.
		 */
		public function load_admin_notices_script() {
			if ( get_transient( 'wcspt_updated' ) ) {
				wp_enqueue_script( 'wcspt-admin-script', plugins_url( '/assets/js/admin-notices.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
			}
		}
		
		/**
		 * Enqueue WCSPT front-end styles and scripts.
		 */
		public function load_frontend_scripts() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'wcspt-style', plugins_url( '/assets/css/wcspt' . $suffix . '.css', __FILE__ ), array(), self::VERSION );
			wp_enqueue_script( 'wcspt-script', plugins_url( '/assets/js/wcspt' . $suffix . '.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
		}
		
		/**
		 * Output the secondary product thumbnail.
		 */
		public function add_secondary_product_thumbnail() {
			global $product;

			$image_ids = $this->get_gallery_img_ids( $product );

			if ( $image_ids ) {
				$secondary_img_id = apply_filters( 'wcspt_reveal_last_img', false ) ? end( $image_ids ) : reset( $image_ids );
				$size             = 'shop_catalog';
				$classes          = 'attachment-' . $size . ' wcspt-secondary-img wcspt-transition wcspt-ie8-tempfix';
				echo wp_get_attachment_image( $secondary_img_id, $size, false, array( 'class' => $classes ) );
			}
		}
		
		/**
		 * Returns the gallery image ids.
		 *
		 * @param WC_Product $product
		 * @return array
		 */
		public function get_gallery_img_ids( $product ) {
			if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
				$image_ids = $product->get_gallery_image_ids();
			} else {
				// Deprecated in WC 3.0.0
				$image_ids = $product->get_gallery_attachment_ids();
			}
			
			return $image_ids;
		}

		/**
		 * Add wcspt-has-gallery class to products that have at least one gallery image.
		 *
		 * @param array $classes
		 * @param array $class
		 * @param int $post_id
		 * @return array
		 */
		public function set_product_post_class( $classes, $class, $post_id ) {
			if ( ! $post_id || get_post_type( $post_id ) !== 'product' ) {
				return $classes;
			}
			
			global $product;
			
			if ( is_object( $product ) ) {
				
				$image_ids = $this->get_gallery_img_ids( $product );
				
				if ( $image_ids ) {
					$classes[] = 'wcspt-has-gallery';
				}
			}
			
			return $classes;
		}

	}
	
	add_action( 'plugins_loaded', array( 'WCSPT', 'get_instance' ) );
}