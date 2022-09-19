<?php
/*
Plugin Name: Mini Cart Drawer for WooCommerce
Plugin URI: http://appsbd.com/
Description: it's a plugin for WooCommerce Mini Cart.
Version: 3.3.1
Author: appsbd
Author URI: http://www.appsbd.com
Slug: woo-mini-cart-drawer
Tested up to: 6.0
WC requires at least: 3.3
WC tested up to: 6.5
Text Domain: woo-mini-cart-drawer
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( !is_plugin_active( 'woominicartpro/woominicartpro.php' ) ) {
		global $wpdb;
		include_once 'core/helper_lite.php';
		include_once 'appcore/plugin_helper.php';
		include_once 'appcore/APBDAjaxMiniCart.php';
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			add_action( 'admin_notices', function () {
				?>
                <div id="message" class="error animated delay-3s  ape-shake">
                    <p><?php echo sprintf( __( "Please install and activate WooCommerce to use %s ", 'woo-mini-cart-drawer' ), '<strong>Mini Cart Drawer for WooCommerce</strong>' ); ?></p>
                </div>
				<?php
			} );
		}
		
		
		$appwoomc=new APBDAjaxMiniCart(__FILE__,"3.3.1");
		

		$appwoomc->StartPlugin();
		




		
	}