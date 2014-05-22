<?php

/*
Plugin Name: Checkout - Guest Checkout
Plugin URI: http://tribulant.com
Author: Tribulant Software
Author URI: http://tribulant.com
Description: Guest checkout capability for the <a href="http://tribulant.com/plugins/view/10/wordpress-shopping-cart-plugin">Shopping Cart plugin</a>.
Version: 1.0
*/

if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }

function wpcoguest_activation_hook() {
	require_once ABSPATH . 'wp-admin' . DS . 'admin-functions.php';
	$path = 'wp-checkout' . DS . 'wp-checkout.php';
	
	if (!is_plugin_active(plugin_basename($path))) {
		_e('You must have the Shopping Cart plugin installed and activated in order to use this.', 'checkout-guest');
		exit(); die();
	} else {
		
		$plugin_data = get_plugin_data(WP_CONTENT_DIR . DS . 'plugins' . DS . $path);
		$plugin_version = $plugin_data['Version'];
		
		$versiongood = false;
		if (version_compare($plugin_version, "1.6.8") >= 0) {
			$versiongood = true;	
		}
		
		if ($versiongood == true) {
			add_option('wpcoguestcheckout', "Y");
		} else {
			echo sprintf(__('The Zoom Effect extension requires the Shopping Cart plugin %s at least.', 'checkout-guest'), '1.6.8');
			exit(); die();	
		}
	}
	
	return true;
}

register_activation_hook(__FILE__, 'wpcoguest_activation_hook');

if (!class_exists('wpcoguest')) {
	require_once WP_CONTENT_DIR . DS . 'plugins' . DS . 'wp-checkout' . DS . 'wp-checkout.php';

	class wpcoguest extends wpCheckoutPlugin {
		
		var $plugin_name = 'checkout-guest';
		var $version = '1.0';
		
		function wpcoguest() {
			
			return;
		}
	}
	
	$wpcoguest = new wpcoguest();
}

?>