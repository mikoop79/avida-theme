<?php

/*
Plugin Name: Checkout
Plugin URI: http://tribulant.com/plugins/view/10/wordpress-shopping-cart-plugin
Author: Tribulant Software
Author URI: http://tribulant.com
Description: Robust shopping cart plugin for WordPress with multiple payment gateways, shipping modules, tangible & digital products, incredible SEO help and much more.
Version: 1.7
License: CC
*/

if (!defined('WP_MEMORY_LIMIT')) { define('WP_MEMORY_LIMIT', "1024M"); }
if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }

//include the wpCheckoutPlugin class file.
require_once(dirname(__FILE__) . DS . 'includes' . DS . 'constants.php');
require_once(dirname(__FILE__) . DS . 'includes' . DS . 'checkinit.php');
require_once(dirname(__FILE__) . DS . 'wp-checkout-plugin.php');
require_once(dirname(__FILE__) . DS . 'wp-checkout-views.php');

if (!class_exists('wpCheckout')) {
	class wpCheckout extends wpCheckoutPlugin {
	
		var $name = 'Checkout';
		var $plugin_file;
		var $plugin_name = 'wp-checkout';
		var $url;
		var $menus = array();
		
		function admin_menu_order() {
			return true;
		}
	
		function menu_order($menu_order) {
			return $menu_order;
		}
		
		function add_menus() {	
			global $user_ID;
			if ($this -> get_option('supplierlogin') == "Y") { $perm['products'] = 1; }			
			//$userdata = $this -> userdata($user_ID);
			$this -> sections = (object) $this -> sections;
			$update_icon = ($this -> has_update()) ? '<span class="update-plugins count-1"><span class="update-count">1</span></span>' : '';
			
			$this -> check_roles();
		
																					add_object_page($this -> name, $this -> name . $update_icon, 'checkout_welcome', $this -> sections -> welcome, array($this, 'admin'), $this -> url() . '/images/icon-16.png');		
			$this -> menus['checkout'] 											= 	add_submenu_page($this -> sections -> welcome, __('Overview', $this -> plugin_name), __('Overview', $this -> plugin_name), 'checkout_welcome', $this -> sections -> welcome, array($this, 'admin'));
			$this -> menus['checkout-settings'] 								= 	add_submenu_page($this -> sections -> welcome, __('Configuration Settings', $this -> plugin_name), __('Configuration', $this -> plugin_name), 'checkout_settings', $this -> sections -> settings, array($this, 'admin_settings'));
			$this -> menus['checkout-settings-general']							=	add_submenu_page($this -> menus['checkout-settings'], __('General Configuration', $this -> plugin_name), __('General Configuration', $this -> plugin_name), 'checkout_settings', $this -> sections -> settings_general, array($this, 'admin_settings_general'));
			$this -> menus['checkout-settings-invoice']							=	add_submenu_page($this -> menus['checkout-settings'], __('Purchase Invoice Settings', $this -> plugin_name), __('Purchase Invoice Settings', $this -> plugin_name), 'checkout_settings_invoice', $this -> sections -> settings_invoice, array($this, 'admin_settings_invoice'));
			$this -> menus['checkout-settings-pmethods']						=	add_submenu_page($this -> menus['checkout-settings'], __('Payment Methods', $this -> plugin_name), __('Payment Methods', $this -> plugin_name), 'checkout_settings_pmethods', $this -> sections -> settings_pmethods, array($this, 'admin_settings_pmethods'));
			$this -> menus['checkout-settings-products']						=	add_submenu_page($this -> menus['checkout-settings'], __('Product Settings', $this -> plugin_name), __('Product Settings', $this -> plugin_name), 'checkout_settings_products', $this -> sections -> settings_products, array($this, 'admin_settings_products'));
			$this -> menus['checkout-settings-taxshipping']						=	add_submenu_page($this -> menus['checkout-settings'], __('Calculations Settings', $this -> plugin_name), __('Calculations Settings', $this -> plugin_name), 'checkout_settings_taxshipping', $this -> sections -> settings_taxshipping, array($this, 'admin_settings_taxshipping'));
			$this -> menus['checkout-settings-paymentfields']					=	add_submenu_page($this -> menus['checkout-settings'], __('Payment Fields', $this -> plugin_name), __('Payment Fields', $this -> plugin_name), 'checkout_settings_paymentfields', $this -> sections -> settings_paymentfields, array($this, 'admin_settings_paymentfields'));
			
			if ($this -> is_plugin_active('affiliates')) {
				$affiliates = $this -> extension_vendor('affiliates');
				$this -> menus['checkout-settings-affiliates']					= 	add_submenu_page($this -> menus['checkout-settings'], __('Affiliates Tracking', $this -> plugin_name), __('Affiliates Tracking', $this -> plugin_name), 'checkout_settings_affiliates', $this -> sections -> settings_affiliates, array($affiliates, 'settings'));	
			}
			
			$this -> menus['checkout-import-csv']								=	add_submenu_page($this -> sections -> welcome, __('Import Products', $this -> plugin_name), __('Import Products', $this -> plugin_name), 'checkout_import_csv', $this -> sections -> import_csv, array($this, 'admin_import_csv'));
			$this -> menus['checkout-categories'] 								= 	add_submenu_page($this -> sections -> welcome, __('Shop Categories', $this -> plugin_name), __('Shop Categories', $this -> plugin_name), 'checkout_categories', $this -> sections -> categories, array($this, 'admin_categories'));
			$this -> menus['checkout-categories-save']							= 	add_submenu_page($this -> menus['checkout-categories'], __('Save Category', $this -> plugin_name), false, 'checkout_categories_save', $this -> sections -> categories_save, array($this, 'admin_categories'));
			$this -> menus['checkout-products'] 								= 	add_submenu_page($this -> sections -> welcome, __('Products', $this -> plugin_name), __('Products', $this -> plugin_name), 'checkout_products', $this -> sections -> products, array($this, 'admin_products'));
			$this -> menus['checkout-products-save']							= 	add_submenu_page($this -> menus['checkout-products'], __('Save Product', $this -> plugin_name), false, 'checkout_products_save', $this -> sections -> products_save, array($this, 'admin_products'));
			$this -> menus['checkout-content'] 									= 	add_submenu_page($this -> menus['checkout-products'], __('Product Content', $this -> plugin_name), __('Product Content', $this -> plugin_name), 'checkout_content', $this -> sections -> content, array($this, 'admin_content'));
			$this -> menus['checkout-content-save']								= 	add_submenu_page($this -> menus['checkout-content'], __('Save Content', $this -> plugin_name), false, 'checkout_content_save', $this -> sections -> content_save, array($this, 'admin_content'));
			$this -> menus['checkout-files']									= 	add_submenu_page($this -> sections -> welcome, __('Digital Files', $this -> plugin_name), __('Digital Files', $this -> plugin_name), 'checkout_files', $this -> sections -> files, array($this, 'admin_files'));
			$this -> menus['checkout-images']									= 	add_submenu_page($this -> menus['checkout-products'], __('Product Images', $this -> plugin_name), __('Product Images', $this -> plugin_name), 'checkout_images', $this -> sections -> images, array($this, 'admin_images'));
			$this -> menus['checkout-suppliers'] 								= 	add_submenu_page($this -> sections -> welcome, __('Suppliers', $this -> plugin_name), __('Suppliers', $this -> plugin_name), 'checkout_suppliers', $this -> sections -> suppliers, array($this, 'admin_suppliers'));
			$this -> menus['checkout-styles'] 									= 	add_submenu_page($this -> sections -> welcome, __('Product Variations', $this -> plugin_name), __('Product Variations', $this -> plugin_name), 'checkout_styles', $this -> sections -> styles, array($this, 'admin_styles'));
			$this -> menus['checkout-options'] 									= 	add_submenu_page($this -> sections -> welcome, __('Variation Options', $this -> plugin_name), __('Variation Options', $this -> plugin_name), 'checkout_options', $this -> sections -> options, array($this, 'admin_options'));
			$this -> menus['checkout-fields'] 									= 	add_submenu_page($this -> sections -> welcome, __('Custom Fields', $this -> plugin_name), __('Custom Fields', $this -> plugin_name), 'checkout_fields', $this -> sections -> fields, array($this, 'admin_fields'));
			$this -> menus['checkout-coupons'] 									= 	add_submenu_page($this -> sections -> welcome, __('Discount Coupons', $this -> plugin_name), __('Discount Coupons', $this -> plugin_name), 'checkout_coupons', $this -> sections -> coupons, array($this, 'admin_coupons'));
			$this -> menus['checkout-orders'] 									= 	add_submenu_page($this -> sections -> welcome, __('Orders', $this -> plugin_name), __('Orders', $this -> plugin_name), 'checkout_orders', $this -> sections -> orders, array($this, 'admin_orders'));
			$this -> menus['checkout-items'] 									= 	add_submenu_page($this -> menus['checkout-orders'], __('Order Items', $this -> plugin_name), __('Order Items', $this -> plugin_name), 'checkout_items', $this -> sections -> items, array($this, 'admin_items'));
			$this -> menus['checkout-shipmethods'] 								= 	add_submenu_page($this -> sections -> welcome, __('Shipping Methods', $this -> plugin_name), __('Shipping Methods', $this -> plugin_name), 'checkout_shipmethods', $this -> sections -> shipmethods, array($this, 'admin_shipmethods'));
			
			if (WPCO_SHOW_EXTENSIONS) { 
				$this -> menus['checkout-extensions'] 	=	add_submenu_page($this -> sections -> welcome, __('Extensions', $this -> plugin_name), __('Extensions', $this -> plugin_name), 'checkout_extensions', $this -> sections -> extensions, array($this, 'admin_extensions')); 
				$this -> menus['checkout-extensions-settings'] = add_submenu_page($this -> menus['checkout-extensions-settings'], __('Extensions Settings', $this -> plugin_name), __('Extensions Settings', $this -> plugin_name), 'checkout_extensions_settings', $this -> sections -> extensions_settings, array($this, 'admin_extensions_settings')); 
			}
			
			$this -> menus['checkout-settings-updates']							=	add_submenu_page($this -> sections -> welcome, __('Updates', $this -> plugin_name), __('Updates', $this -> plugin_name) . $update_icon, 'checkout_settings_updates', $this -> sections -> settings_updates, array($this, 'admin_settings_updates'));
			if (WPCO_SHOW_SUPPORT) { $this -> menus['checkout-support'] 		= 	add_submenu_page($this -> sections -> welcome, __('Support &amp; Help', $this -> plugin_name), __('Support &amp; Help', $this -> plugin_name), 'checkout_support', $this -> sections -> support, array($this, 'admin_support')); }
			
			add_filter('custom_menu_order', array($this, 'admin_menu_order'));
			add_filter('menu_order', array($this, 'menu_order'));
			
			add_action('admin_head-' . $this -> menus['checkout'], array($this, 'admin_head_welcome'));
			add_action('admin_head-' . $this -> menus['checkout-products-save'], array($this, 'admin_head_products_save'));
			add_action('admin_head-' . $this -> menus['checkout-content-save'], array($this, 'admin_head_content_save'));
			add_action('admin_head-' . $this -> menus['checkout-settings'], array($this, 'admin_head_settings'));
			add_action('admin_head-' . $this -> menus['checkout-settings-products'], array($this, 'admin_head_settings_products'));
			add_action('admin_head-' . $this -> menus['checkout-settings-taxshipping'], array($this, 'admin_head_settings_taxshipping'));
			add_action('admin_head-' . $this -> menus['checkout-settings-pmethods'], array($this, 'admin_head_settings_pmethods'));
			add_action('admin_head-' . $this -> menus['checkout-settings-paymentfields'], array($this, 'admin_head_settings_paymentfields'));
			add_action('admin_head-' . $this -> menus['checkout-extensions-settings'], array($this, 'admin_head_settings_extensions_settings'));
			
			if ($this -> is_plugin_active('affiliates')) {
				$affiliates = $this -> extension_vendor('affiliates');
				add_action('admin_head-' . $this -> menus['checkout-settings-affiliates'], array($affiliates, 'admin_head_settings'));
			}
			
			return;
		}
		
		function admin_head() {
			$this -> render('head', false, true, 'admin');
		}
		
		function admin_head_welcome() {
			global $wpcoMetabox;
			add_meta_box('orderstotaldiv', __('Total Income', $this -> plugin_name), array($wpcoMetabox, 'welcome_orders_total'), "checkout_page_" . $this -> sections -> welcome, 'side', 'core');
			if ($this -> get_option('shippingcalc') == "Y") { add_meta_box('shippingtotaldiv', __('Total Shipping', $this -> plugin_name), array($wpcoMetabox, 'welcome_shipping_total'), "checkout_page_" . $this -> sections -> welcome, 'side', 'core'); }
			if ($this -> get_option('tax_calculate') == "Y") { add_meta_box('taxtotaldiv', __('Total Tax', $this -> plugin_name), array($wpcoMetabox, 'welcome_tax_total'), "checkout_page_" . $this -> sections -> welcome, 'side', 'core'); }
			if ($this -> get_option('enablecoupons') == "Y") { add_meta_box('discountstotaldiv', __('Total Discount', $this -> plugin_name), array($wpcoMetabox, 'welcome_discounts_total'), "checkout_page_" . $this -> sections -> welcome, 'side', 'core'); }
			add_meta_box('chartdiv', __('Statistics Overview', $this -> plugin_name), array($wpcoMetabox, 'welcome_chart'), "checkout_page_" . $this -> sections -> welcome, 'normal', 'core');
			add_meta_box('ordersdiv', __('Recent Orders', $this -> plugin_name), array($wpcoMetabox, 'welcome_orders'), "checkout_page_" . $this -> sections -> welcome, 'normal', 'core');
			add_meta_box('oosproductsdiv', __('Low &amp; Out of Stock Products', $this -> plugin_name), array($wpcoMetabox, 'welcome_oosproducts'), "checkout_page_" . $this -> sections -> welcome, 'normal', 'core');
			
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> welcome, 'normal', false);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> welcome, 'advanced', false);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> welcome, 'side', false);
		}
		
		function admin_head_products_save() {
			global $Product, $wpcoMetabox, $wpcoHtml;
			$page = "admin_page_" . $this -> sections -> products_save;
			
			add_meta_box('imagediv', __('Product Image', $this -> plugin_name), array($this, 'image_metabox'), "admin_page_" . $this -> sections -> products_save, 'side', 'core');
			add_meta_box('imagesdiv', __('Extra Images', $this -> plugin_name), array($wpcoMetabox, 'product_images'), "admin_page_" . $this -> sections -> products_save, 'side', 'core');
			add_meta_box('submitdiv', __('Categories', $this -> plugin_name), array($this, 'categories_metabox'), "admin_page_" . $this -> sections -> products_save, 'side', 'core');
			if (!$this -> is_supplier()) { add_meta_box('postpagediv', __('Product Post/Page', $this -> plugin_name), array($wpcoMetabox, 'product_postpage'), "admin_page_" . $this -> sections -> products_save, 'side', 'core'); }
			add_meta_box('cfieldsdiv', __('Custom Fields', $this -> plugin_name), array($wpcoMetabox, 'product_cfields'), "admin_page_" . $this -> sections -> products_save, 'side', 'core');
			add_meta_box('contentsdiv', __('Additional Descriptions', $this -> plugin_name) . $wpcoHtml -> help(__('Using additional descriptions makes use of the content tabs feature on product pages', $this -> plugin_name)), array($this, 'contents_metabox'), "admin_page_" . $this -> sections -> products_save, 'normal', 'core');
			add_meta_box('pricingdiv', __('Product Pricing &amp; Shipping', $this -> plugin_name), array($this, 'pricing_metabox'), "admin_page_" . $this -> sections -> products_save, 'normal', 'core');
			add_meta_box('stylesdiv', __('Product Variations &amp; Options', $this -> plugin_name), array($wpcoMetabox, 'product_styles'), "admin_page_" . $this -> sections -> products_save, 'normal', 'core');
			add_meta_box('fieldsdiv', __('Additional Fields', $this -> plugin_name), array($this, 'fields_metabox'), "admin_page_" . $this -> sections -> products_save, 'normal', 'core');
			
			do_action('checkout_admin_product_save_metaboxes', $page);
			
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> products_save, 'normal', $Product);
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> products_save, 'advanced', $Product);
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> products_save, 'side', $Product);
		}
		
		function admin_head_content_save() {
			global $Content, $wpcoMetabox;		
			add_meta_box('submitdiv', __('Product', $this -> plugin_name), array($this, 'content_product_metabox'), "admin_page_" . $this -> sections -> content_save, 'side', 'core');		
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> content_save, 'side', $Content);
		}
		
		function admin_head_settings() {
			global $post, $wpcoMetabox;
			
			//register some meta boxes with the WordPress core
			add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_submit'), "checkout_page_" . $this -> sections -> settings, 'side', 'core');
			add_meta_box('pmethods', __('Payment Methods', $this -> plugin_name), array($wpcoMetabox, 'settings_pmethods'), "checkout_page_" . $this -> sections -> settings, 'side', 'core');
			add_meta_box('wprelated', __(WPCO_CMS_NAME . ' Related', $this -> plugin_name), array($wpcoMetabox, 'settings_wprelated'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('general', __('General Configuration', $this -> plugin_name), array($wpcoMetabox, 'settings_general'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('postspages', __('Posts/Pages and Categories Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_postspages'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('captions', __('Captions, Texts &amp; Messages', $this -> plugin_name), array($wpcoMetabox, 'settings_captions'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('urelated', __('User Related Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_urelated'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('cart', __('Shopping Cart', $this -> plugin_name), array($wpcoMetabox, 'settings_cart'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('checkout', __('Checkout Configuration', $this -> plugin_name), array($wpcoMetabox, 'settings_checkout'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('categories', __('Category Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_categories'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('suppliers', __('Supplier Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_suppliers'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('coupons', __('Discount Coupons', $this -> plugin_name), array($wpcoMetabox, 'settings_coupons'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('favorites', __('Favorite Products', $this -> plugin_name), array($wpcoMetabox, "settings_favorites"), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');			
			add_meta_box('email', __('Email Configuration', $this -> plugin_name), array($wpcoMetabox, 'settings_email'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			add_meta_box('customcss', __('Theme, Scripts &amp; Custom CSS', $this -> plugin_name), array($wpcoMetabox, 'settings_customcss'), "checkout_page_" . $this -> sections -> settings, 'normal', 'core');
			
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings, "side", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings, "normal", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings, "advanced", $post);
		}
		
		function admin_head_settings_pmethods() {	
			global $post, $wpcoMetabox;
				
			add_meta_box('submitdiv', __('Save Payment Methods', $this -> plugin_name), array($wpcoMetabox, 'settings_submit'), "admin_page_" . $this -> sections -> settings_pmethods, 'side', 'core');
			add_meta_box('pmethods', __('Payment Methods', $this -> plugin_name), array($wpcoMetabox, 'settings_pmethods'), "admin_page_" . $this -> sections -> settings_pmethods, 'side', 'core');		
			
			if ($this -> is_plugin_active('amazonfps')) {
				add_meta_box('amazonfps', __('Amazon FPS', $this -> plugin_name), array($wpcoMetabox, 'settings_amazonfps'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			if ($this -> is_plugin_active('apco')) {
				add_meta_box('apco', __('APCO Limited', $this -> plugin_name), array($wpcoMetabox, 'settings_apco'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			add_meta_box('authorize_aim', __('Authorize.net (AIM)', $this -> plugin_name), array($wpcoMetabox, 'settings_authorize_aim'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('bartercard', __('BarterCard InternetPOS', $this -> plugin_name), array($wpcoMetabox, 'settings_bartercard'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			
			if ($this -> is_plugin_active('bluepay')) {
				add_meta_box('bluepay', __('BluePay 2.0 Redirect', $this -> plugin_name), array($wpcoMetabox, 'settings_bluepay'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
				
			add_meta_box('eway_shared', __('eWay AU (Shared)', $this -> plugin_name), array($wpcoMetabox, 'settings_eway_shared'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('pp', __('PayPal (Website Payments Standard)', $this -> plugin_name), array($wpcoMetabox, 'settings_pp'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('pp_pro', __('PayPal (Website Payments Pro)', $this -> plugin_name), array($wpcoMetabox, 'settings_pp_pro'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('payxml', __('PayGate (XML)', $this -> plugin_name), array($wpcoMetabox, 'settings_payxml'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('tc', __('2CheckOut', $this -> plugin_name), array($wpcoMetabox, 'settings_tc'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			
			if ($this -> is_plugin_active('ipay')) {
				add_meta_box('ipay', __('iPay88', $this -> plugin_name), array($wpcoMetabox, 'settings_ipay'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			add_meta_box('lucy', __('LUCY Gateway', $this -> plugin_name), array($wpcoMetabox, 'settings_lucy'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('mb', __('Skrill (Moneybookers)', $this -> plugin_name), array($wpcoMetabox, 'settings_mb'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('monsterpay', __('MonsterPay', $this -> plugin_name), array($wpcoMetabox, 'settings_monsterpay'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			
			if ($this -> is_plugin_active('netcash')) {
				add_meta_box('netcash', __('Netcash', $this -> plugin_name), array($wpcoMetabox, 'settings_netcash'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			add_meta_box('google_checkout', __('Google Checkout Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_google_checkout'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('bw', __('Bank Wire', $this -> plugin_name), array($wpcoMetabox, 'settings_bw'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('cc', __('Credit Cart (Manual POS)', $this -> plugin_name), array($wpcoMetabox, 'settings_cc'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('cu', __('Custom/Manual Payment', $this -> plugin_name), array($wpcoMetabox, 'settings_cu'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('fd', __('First Data Connect 2.0', $this -> plugin_name), array($wpcoMetabox, 'settings_fd'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			
			if ($this -> is_plugin_active('fdapi')) {
				add_meta_box('fdapi', __('First Data API', $this -> plugin_name), array($wpcoMetabox, 'settings_fdapi'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			if ($this -> is_plugin_active('sagepay')) {
				add_meta_box('sagepay', __('Sage Pay (Form Protocol)', $this -> plugin_name), array($wpcoMetabox, 'settings_sagepay'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');	
			}
			
			if ($this -> is_plugin_active('securetrading')) {
				add_meta_box('securetrading', __('SecureTrading Payment Pages', $this -> plugin_name), array($wpcoMetabox, 'settings_securetrading'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			add_meta_box('re', __('Realex Payments (realauth redirect)', $this -> plugin_name), array($wpcoMetabox, 'settings_re'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('re_remote', __('Realex Payments (realauth remote)', $this -> plugin_name), array($wpcoMetabox, 'settings_re_remote'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('ematters', __('eMatters (HTTPS POST)', $this -> plugin_name_), array($wpcoMetabox, 'settings_ematters'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('eupayment', __('Euro Payment Services S.R.L', $this -> plugin_name), array($wpcoMetabox, 'settings_eupayment'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			add_meta_box('ogone_basic', __('Ogone (Basic e-Commerce)', $this -> plugin_name), array($wpcoMetabox, 'settings_ogone_basic'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			
			if ($this -> is_plugin_active('stripe')) {
				add_meta_box('stripe', __('Stripe', $this -> plugin_name), array($wpcoMetabox, 'settings_stripe'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			}
			
			add_meta_box('virtualmerchant', __('Virtual Merchant', $this -> plugin_name), array($wpcoMetabox, 'settings_virtualmerchant'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');	
			add_meta_box('worldpay', __('WorldPay', $this -> plugin_name), array($wpcoMetabox, 'settings_worldpay'), "admin_page_" . $this -> sections -> settings_pmethods, 'normal', 'core');
			
			do_action($this -> pre . '_pmethods_metaboxes', "admin_page_" . $this -> sections -> settings_pmethods, "normal", $post);
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> settings_pmethods, "side", $post);
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> settings_pmethods, "normal", $post);
			do_action('do_meta_boxes', "admin_page_" . $this -> sections -> settings_pmethods, "advanced", $post);
		}
		
		function admin_head_settings_products() {
			global $post, $wpcoMetabox;
			
			add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_submit'), "checkout_page_" . $this -> sections -> settings_products, 'side', 'core');
			add_meta_box('products', __('Product Page Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_products'), "checkout_page_" . $this -> sections -> settings_products, 'normal', 'core');
			add_meta_box('ploop', __('Products Loop/Paging', $this -> plugin_name), array($wpcoMetabox, 'settings_ploop'), "checkout_page_" . $this -> sections -> settings_products, 'normal', 'core');	
			add_meta_box('pimages', __('Extra Product Images', $this -> plugin_name), array($wpcoMetabox, 'settings_pimages'), "checkout_page_" . $this -> sections -> settings_products, 'normal', 'core');
			add_meta_box('variations', __('Product Variation &amp; Options', $this -> plugin_name), array($wpcoMetabox, 'settings_variations'), "checkout_page_" . $this -> sections -> settings_products, 'normal', 'core');
			
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_products, "side", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_products, "normal", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_products, "advanced", $post);
		}
		
		function admin_head_settings_taxshipping() {
			global $post, $wpcoMetabox;
			
			add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_submit'), "checkout_page_" . $this -> sections -> settings_taxshipping, 'side', 'core');
			add_meta_box('tax', __('Tax Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_tax'), "checkout_page_" . $this -> sections -> settings_taxshipping, 'normal', 'core');
			add_meta_box('shipping', __('Global Shipping Configuration', $this -> plugin_name), array($wpcoMetabox, 'settings_shipping'), "checkout_page_" . $this -> sections -> settings_taxshipping, 'normal', 'core');
			add_meta_box('surcharge', __('Handling &amp; Surcharge', $this -> plugin_name), array($wpcoMetabox, 'settings_surcharge'), "checkout_page_" . $this -> sections -> settings_taxshipping, 'normal', 'core');
			
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_taxshipping, "side", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_taxshipping, "normal", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_taxshipping, "advanced", $post);
		}
		
		function admin_head_settings_paymentfields() {
			global $post, $wpcoMetabox;
			
			add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($wpcoMetabox, 'settings_submit'), "checkout_page_" . $this -> sections -> settings_paymentfields, 'side', 'core');
			add_meta_box('shippingdiv', __('Shipping Fields', $this -> plugin_name), array($wpcoMetabox, 'settings_shippingfields'), "checkout_page_" . $this -> sections -> settings_paymentfields, 'normal', 'core');
			add_meta_box('billingdiv', __('Billing Fields', $this -> plugin_name), array($wpcoMetabox, 'settings_billingfields'), "checkout_page_" . $this -> sections -> settings_paymentfields, 'normal', 'core');
			
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_paymentfields, "side", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_paymentfields, "normal", $post);
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> settings_paymentfields, "advanced", $post);
		}
		
		function admin_head_settings_extensions_settings() {
			global $wpcoMetabox;
			
			add_meta_box('submitdiv', __('Extensions Settings', $this -> plugin_name), array($wpcoMetabox, 'extensions_settings_submit'), "checkout_page_" . $this -> sections -> extensions_settings, 'side', 'core');
			do_action($this -> pre . '_metaboxes_extensions_settings', "checkout_page_" . $this -> sections -> extensions_settings);
			
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> extensions_settings, 'side');
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> extensions_settings, 'normal');
			do_action('do_meta_boxes', "checkout_page_" . $this -> sections -> extensions_settings, 'advanced');
		}
		
		function tinymce() {
			if (current_user_can('edit_posts') || current_user_can('edit_pages')) {
				if ($this -> get_option('tinymcebutton') == "Y" && get_user_option('rich_editing') == 'true') {		
					add_filter('mce_buttons', array($this, 'mcebutton'));
					add_filter('mce_buttons_3', array($this, 'mcebutton3'));
					add_filter('mce_external_plugins', array($this, 'mceplugin'));
				}
			}

			return;				
		}
		
		function mcebutton($buttons) {	
			array_push($buttons, "Checkout");
			return $buttons;
		}
		
		function mcebutton3($buttons) {
			//Viper's Video Quicktags compatibility
			if (!empty($_GET['page']) && ($_GET['page'] == $this -> sections -> products_save || $_GET['page'] == $this -> sections -> content_save)) {
				if (!empty($buttons)) {
					foreach ($buttons as $bkey => $bval) {
						if (preg_match("/\v\v\q(.*)?/si", $bval, $match)) {
							unset($buttons[$bkey]);
						}
					}
				}
			}
			
			return $buttons;
		}
	
		function mceplugin($plugins) {
			$plugins['Checkout'] = $this -> url() . '/js/tinymce/editor_plugin.js';			
			return $plugins;
		}	
	
		function my_change_mce_settings( $init_array ) {
			$init_array['disk_cache'] = false; // disable caching
			$init_array['compress'] = false; // disable gzip compression
			$init_array['old_cache_max'] = 3; // keep 3 different TinyMCE configurations cached (when switching between several configurations regularly)
		}
	
		function mceupdate($ver) {
			$ver += 3;
			return $ver;
		}
		
		function wp_head() {
			global $wpcoAuth, $wpcojsalerts;
			$wpcoAuth -> check_user();
			
			$this -> render('head', false, true, 'default');
			
			?>
            
            <script type="text/javascript">
            jQuery(document).ready(function() { 
				if (jQuery.isFunction(jQuery.fn.colorbox)) { jQuery('.colorbox').colorbox({maxWidth:'100%', maxHeight:'90%'}); }
				if (jQuery.isFunction(jQuery.fn.button)) { jQuery('.productsubmit input, .wpcobutton').button(); }
			});
            
            <?php if ($this -> is_plugin_active('qtranslate')) : ?>
            	var wpcoajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>?lang=<?php echo qtrans_getLanguage(); ?>&';
            <?php else : ?>
				var wpcoajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>?";
			<?php endif; ?>
			var wpcoDoAjax = <?php if ($this -> get_option('cart_addajax') == "Y") : ?>true<?php else : ?>false<?php endif; ?>;
			var wpcoScrollAjax = <?php if ($this -> get_option('cart_scrollajax') == "Y") : ?>true<?php else : ?>false<?php endif; ?>;
			
			<?php if (!empty($wpcojsalerts) && is_array($wpcojsalerts)) : ?>
				<?php foreach ($wpcojsalerts as $wpcojsalert) : ?>
					<?php echo $wpcojsalert; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			</script>
            
            <?php
		}
		
		function clear_auth_cookie() {
			global $wpdb, $user_ID, $wpcoDb, $Order, $wpcoAuth;
			$order_id = $Order -> current_order_id();
			$wpcoDb -> model = $Order -> model;
			$wpcoDb -> delete($order_id);
			$wpcoAuth -> delete_cookie();
		}
		
		function init_posttypes() {	
			if ($this -> get_option('post_type') == "custom") {		
				/* Product Categories */
				$category_args = array(
					'label'					=>	__('Product Categories', $this -> plugin_name),
					'labels'				=>	array('name' => __('Product Categories', $this -> plugin_name), 'singular' => __('Product Category', $this -> plugin_name)),
					'description'			=>	__('Shop categories.', $this -> plugin_name),
					'public'				=>	true,
					'show_ui'				=>	false,
					'hierarchical'			=>	true,
					'rewrite'				=>	array('slug' => 'product-category', 'with_front' => false),
					'supports'				=>	array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail', 'page-attributes'),
				);
				
				register_post_type('product-category', $category_args);
				
				/* Product Suppliers */
				$supplier_args = array(
					'label'					=>	__('Product Suppliers', $this -> plugin_name),
					'labels'				=>	array('name' => __('Product Suppliers', $this -> plugin_name), 'singular' => __('Product Suplier', $this -> plugin_name)),
					'description'			=>	__('Shop suppliers.', $this -> plugin_name),
					'public'				=>	true,
					'show_ui'				=>	false,
					'hierarchical'			=>	true,
					'rewrite'				=>	array('slug' => 'product-supplier', 'with_front' => false),
					'supports'				=>	array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail', 'page-attributes'),
				);
				
				register_post_type('product-supplier', $supplier_args);
				
				/* Products */	
				$product_args = array(
					'label'					=>	__('Products', $this -> plugin_name),
					'labels'				=>	array('name' => __('Products', $this -> plugin_name), 'singular_name' => __('Product', $this -> plugin_name)),
					'description'			=>	__('Shop products.', $this -> plugin_name),
					'public'				=>	true,
					'show_ui'				=>	false,
					'hierarchical'			=>	true,
					'rewrite'				=>	array('slug' => 'product', 'with_front' => false),
					'supports'				=>	array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail', 'page-attributes'),
				);
				
				register_post_type('product', $product_args);
				
				add_rewrite_rule('^product/.*?/([^/]+)/?$', 'index.php?product=$matches[1]', 'top');
			}
		}
		
		function init_textdomain() {		
			if (function_exists('load_plugin_textdomain')) {			
				load_plugin_textdomain($this -> plugin_name, 'wp-checkout' . DS . 'languages', dirname(plugin_basename(__FILE__)) . DS . 'languages');
			}	
		}
		
		function wp_foot() {			
			if ($this -> is_plugin_active('affiliates')) {
				if ($affiliates = $this -> extension_vendor('affiliates')) {
					$affiliates -> wp_footer();	
				}
			}
			
			return;
		}
		
		function wp_dashboard_setup() {
			wp_add_dashboard_widget('checkout', __('Checkout', $this -> plugin_name), array($this, 'dashboard_widget'), false);
		}
		
		function dashboard_widget() {
			$this -> render('dashboard', false, true, 'admin');
		}
		
		function admin_notices() {
			global $wpcoHtml;
			$this -> check_uploaddir();
			
			//Open the menu accordingly
			if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) {
				$wpcoHtml -> wp_has_current_submenu($_GET['page']);
			}
			
			if (!$this -> ci_serial_valid()) {
				$message = __('Please fill in a serial key for the Shopping Cart plugin to continue use.', $this -> plugin_name);
				$message .= ' <a id="' . $this -> pre . 'submitseriallink" href="" title="' . __('Shopping Cart plugin - Serial Key', $this -> plugin_name) . '">' . __('Submit Serial Key', $this -> plugin_name) . '</a>';
				$this -> render_err($message);	
				
				?>
            
				<script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery('#<?php echo $this -> pre; ?>submitseriallink').click(function() {					
                        jQuery.colorbox({href:ajaxurl + "?action=<?php echo $this -> pre; ?>serialkey"});
                        return false;
                    });
                });
                </script>
                
                <?php
			}
			
			if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections) && $_GET['page'] != $this -> sections -> settings_invoice) {				
				if ($this -> get_option('invoice_updated') == "N") {
					$this -> render_msg(__("You haven't set your invoice settings. You can configure it under Checkout > Configuration > Invoices.", $this -> plugin_name));	
				}
			}
	
			if (!empty($_GET[$this -> pre . 'message'])) {		
				$msg_type = (!empty($_GET[$this -> pre . 'updated'])) ? 'msg' : 'err';
				call_user_func(array(&$this, 'render_' . $msg_type), stripslashes($_GET[$this -> pre . 'message']));
			}
		}
		
		function widget_register() {
			if (function_exists('register_sidebar_widget')) {
				if (!$options = get_option($this -> pre . '-widget')) {
					$options = array();
				}
			
				$widget_options = array('classname' => $this -> pre . '-widget', 'description' => __('Shopping cart categories, products and more inside your sidebars', $this -> plugin_name));	
				$control_options = array('id_base' => $this -> pre, 'width' => 350, 'height' => 300);	
				$name = __('Checkout', $this -> plugin_name);
				
				if (!empty($options)) {
					foreach ($options as $okey => $oval) {
						$id = $this -> pre . '-' . $okey;
											
						wp_register_sidebar_widget($id, $name, array($this, $this -> pre . '_widget'), $widget_options, array('number' => $okey));
						wp_register_widget_control($id, $name, array($this, $this -> pre . '_widget_control'), $control_options, array('number' => $okey));
					}
				} else {
					$id = $this -> pre . '-1';
					wp_register_sidebar_widget($id, $name, array($this, $this -> pre . '_widget'), $widget_options, array('number' => -1));
					wp_register_widget_control($id, $name, array($this, $this -> pre . '_widget_control'), $control_options, array('number' => -1));
				}
			}
		}
		
		function widget($display = 'cart', $args = array()) {
			$args['before_title'] = '<h2 class="widgettitle">';
			$args['after_title'] = '</h2>';
				
			if (!empty($display)) {
				foreach ($args as $akey => $aval) {
					$this -> update_option($display . '_' . $akey, $aval);
				}
	
				$show = (!empty($args['show']) && $args['show'] == "minimal") ? "minimal" : "normal";
				$number = $this -> pre . '-' . $display;
				
				$args['before_widget'] = '<div id="' . $number  . '" class="widget ' . $this -> pre . '-widget">';
				$args['after_widget'] = '</div>';
				
				echo $args['before_widget'];
				$this -> render('widget-' . $display, array('args' => $args, 'number' => $number, 'options' => array('number' => $number, 'show' => $show, 'title' => $this -> get_option($display . '_title'))), true, 'default');
				echo $args['after_widget'];
			}
			
			return false;
		}
		
		function wpco_widget($args = array(), $widget_args = array()) {
			global $wpcoHtml;
			extract($args, EXTR_SKIP);
			
			if (is_numeric($widget_args)) {
				$widget_args = array('number' => $widget_args);
			}
				
			$widget_args = wp_parse_args($widget_args, array('number' => -1));
			extract($widget_args, EXTR_SKIP);
			$intnumber = preg_replace("/wpco\-/i", "", $number);
		
			$options = get_option($this -> pre . '-widget');		
			if (empty($options[$intnumber])) {
				return;
			}
			
			$options[$intnumber]['number'] = 'wpco-' . $intnumber;
			
			if ($this -> is_loggedin()) {
				echo $args['before_widget'];
				$this -> render('widget-' . $options[$intnumber]['display'], array('args' => $args, 'options' => $options[$intnumber], 'number' => 'wpco-' . $intnumber), true, 'default');
				
				if (!empty($options[$intnumber]['shlink']) && $options[$intnumber]['shlink'] == "Y") {
					$shlinktitle = (empty($options[$intnumber]['shlinktitle'])) ? __('More great products...', $this -> plugin_name) : $options[$intnumber]['shlinktitle'];
					
					?>
					
					<ul>
						<li><?php echo $wpcoHtml -> link($shlinktitle, $options[$intnumber]['shlinkurl'], array('title' => $shlinktitle)); ?></li>
					</ul>
					
					<?php
				}
				
				echo $args['after_widget'];
			}
		}
		
		function wpco_widget_control($widget_args = array()) {
			global $wp_registered_widgets;
			$updated = false;
			
			if (is_numeric($widget_args)) {
				$widget_args = array('number' => $widget_args);
			}
				
			$widget_args = wp_parse_args($widget_args, array('number' => -1));
			
			if (!empty($widget_args['number']) && is_array($widget_args['number'])) {
				extract($widget_args['number'], EXTR_SKIP);
			} else {
				extract($widget_args, EXTR_SKIP);
			}
			
			$options = get_option($this -> pre . '-widget');
			if (empty($options) || !is_array($options)) {
				$options = array();
			}
		
			if (!$updated && !empty($_POST['sidebar'])) {			
				$sidebar = $_POST['sidebar'];
				$sidebars_widgets = wp_get_sidebars_widgets();
				
				if (!empty($sidebars_widgets[$sidebar])) {
					$this_sidebar = $sidebars_widgets[$sidebar];
				} else {
					$this_sidebar = array();
				}
				
				$activewidgets = array();
				for ($s = 1; $s < 99; $s++) {
					if (isset($sidebars_widgets[$sidebar]) && !empty($sidebars_widgets[$sidebar]) && is_array($sidebars_widgets[$sidebar])) {
						foreach ($sidebars_widgets[$sidebar] as $snumber => $sid) {
							$activewidgets[$snumber] = $sid;
						}
					} else { break 1; }
				}
				
				if (!empty($options)) {
					foreach ($options as $onumber => $owidget) {
						if (!in_array($this -> pre . '-' . $onumber, $activewidgets) || !is_active_widget(false, $this -> pre . '-' . $onumber, $this -> pre, true)) {
							//unset($options[$onumber]);
						}
					}
				}
	
				if (!empty($_POST[$this -> pre . '-widget'])) {					
					foreach ($_POST[$this -> pre . '-widget'] as $widget_number => $widget_values) {
						if (!isset($widget_values['title']) && isset($options[$widget_number])) {
							continue;
						}
						
						$title = strip_tags(stripslashes($widget_values['title']));
						$display = $widget_values['display'];
						$maincategories = $widget_values['maincategories'];
						$productcount = $widget_values['productcount'];
						$show = $widget_values['show'];
						$showproducts = $widget_values['showproducts'];
						$hide_when_empty = $widget_values['hide_when_empty'];
						$enablecoupons = $widget_values['enablecoupons'];
						$domain = $widget_values['domain'];
						$iframeheight = $widget_values['iframeheight'];
						$count = $widget_values['count'];
						$thumbs = $widget_values['thumbs'];
						$shlink = $widget_values['shlink'];
						$shlinktitle = $widget_values['shlinktitle'];
						$shlinkurl = $widget_values['shlinkurl'];
						$dropdown = $widget_values['dropdown'];
						$categories_sortby = $widget_values['categories_sortby'];
						$categories_sort = $widget_values['categories_sort'];
						
						$options[$widget_number] = compact('title', 'display', 'maincategories', 'productcount', 'categories_sortby', 'categories_sort', 'show', 'showproducts', 'hide_when_empty', 'enablecoupons', 'domain', 'iframeheight', 'count', 'thumbs', 'shlink', 'shlinktitle', 'shlinkurl', 'dropdown');
					}
				}
		
				update_option($this -> pre . '-widget', $options);
				$updated = true;
			}
			
			if (empty($number) || -1 == $number) {
				$number = '%i%';
				$options[$number]['maincategories'] = "N";
				$options[$number]['productcount'] = "N";
				$options[$number]['show'] = "normal";
				$options[$number]['showproducts'] = "N";
				$options[$number]['count'] = 0;
				$options[$number]['domain'] = "http://";
				$options[$number]['iframeheight'] = "350";
				$options[$number]['thumbs'] = "Y";
				$options[$number]['shlink'] = "N";
				$options[$number]['shlinktitle'] = __('More top products…', $this -> plugin_name);
				$options[$number]['dropdown'] = "N";
				$options[$number]['hide_when_empty'] = false;
			}
			
			if (empty($_POST)) {
				$this -> render('widget', array('options' => $options, 'number' => $number), true, 'admin');
			}
		}
		
		function filter_content($content = null) {
			if (!empty($content)) {
				if (preg_match("/\{" . $this -> pre . "\_(.*?)\}/i", $content, $matches)) {
					$content = preg_replace_callback("/\{" . $this -> pre . "\_(.*?)\}/i", array($this, 'replace_tags'), $content);
				}
			}
		
			return $content;
		}
		
		function search_template($content = null) {
			
			
			return $content;
		}
		
		function delete_post($post_id = null) {
			global $wpcoDb, $Category, $Product;
		
			if ($post = get_post($post_id)) {
				$wpcoDb -> model = $Category -> model;
				$wpcoDb -> save_field('post_id', 'none', array('post_id' => $post_id));
				$wpcoDb -> model = $Product -> model;
				$wpcoDb -> save_field('post_id', 'none', array('post_id' => $post_id));
			}
			
			return true;
		}
			
		function gzip_compression() {
			if ($this -> get_option('gzip') == "Y") {
				ob_start('ob_gzhandler');	
			}
		}
		
		function init_getpost() {
			global $wpdb, $wpcoHtml, $wpcoAuth, $Javascript, $user_ID, $wpcoDb, $Product, $Supplier, $Style, $Category, $Coupon, $Discount, $Order, $Item, $File, $wpcoField;
			
			$method = (empty($_GET[$this -> pre . 'method'])) ? false : $_GET[$this -> pre . 'method'];
			$method = (empty($_POST[$this -> pre . 'method'])) ? $method : $_POST[$this -> pre . 'method'];
			
			if (!empty($_POST)) {
				if (!empty($_POST['_wp_http_referer']) && !empty($_POST['user_id'])) {			
					if (preg_match("/^\/wp\-admin\/user\-edit\.php(.*)$/i", $_POST['_wp_http_referer'])) {				
						if (!empty($_POST['billingsameshipping']) && $_POST['billingsameshipping'] == "Y") {
							$_POST['bill_address'] = $_POST['ship_address'];
							$_POST['bill_address2'] = $_POST['ship_address2'];
							$_POST['bill_city'] = $_POST['ship_city'];
							$_POST['bill_state'] = $_POST['ship_state'];
							$_POST['bill_country'] = $_POST['ship_country'];
							$_POST['bill_zipcode'] = $_POST['ship_zipcode'];
						}
					
						foreach ($_POST as $pkey => $pval) {
							if (preg_match("/^(bill|ship)\_(.*)$/i", $pkey) || $pkey == "billingsameshipping") {
								update_user_meta($_POST['user_id'], $pkey, $pval);
							}
						}
					}
				}
			}
			
			if ($_SERVER['REQUEST_METHOD'] == "GET" && $_SERVER['HTTP_ORIGIN'] == "https://www.apsp.biz") {
				$method = "apco";
			}
			
			do_action($this -> pre . '_initgetpost', $method);
				
			if (!empty($method)) {
				switch ($method) {
					case 'apco'					:
						if ($this -> is_plugin_active('apco')) {
							$apco = $this -> extension_vendor('apco');
							$apco -> response();
						}
						break;
					case 'apco_iframe'			:
						if ($this -> is_plugin_active('apco')) {
							$apco = $this -> extension_vendor('apco');
							$apco -> iframe_post();
						}
						break;
					case 'mb_iframe'			:
						if (!empty($_GET['order_id'])) {
							global $wpcoDb, $Order;
							$order_id = $Order -> current_order_id();
							$wpcoDb -> model = $Order -> model;
							$order = $wpcoDb -> find(array('id' => $order_id));	
							$user = $this -> userdata($order -> user_id);
						}
					
						$this -> render('checkout' . DS . 'moneybookers-iframe', array('order' => $order, 'user' => $user), true, 'default');
						
						exit();
						die();
						break;
					case 'submitserial'			:
						$errors = array();
						$success = false;
					
						if (!empty($_POST)) {
							if (empty($_POST['serialkey'])) { $errors[] = __('Please fill in a serial key', $this -> plugin_name); }
							else { $this -> update_option('serialkey', $_POST['serialkey']); }
							
							if (!$this -> ci_serial_valid()) { $errors[] = __('Serial key is invalid, please try again', $this -> plugin_name); }
							else { $success = true; }
						}
						
						$this -> render('submitserial', array('errors' => $errors, 'success' => $success), true, 'admin');
									
						exit();
						break;
					case 'pdfinvoice'						:
						global $wpcoDb, $Order, $Item, $user_ID;
						$wpcoDb -> model = $Order -> model;
											
						if ($order = $wpcoDb -> find(array('id' => $_GET['id']))) {		
							if ($this -> get_option('invoice_enabled') == "Y") {					
								$wpcoDb -> model = $Item -> model;
								
								if ($items = $wpcoDb -> find_all(array('order_id' => $order -> id))) {														
									$html = stripslashes($this -> render('invoice', array('user' => $userdata, 'order' => $order, 'items' => $items, 'pdf' => true), false, 'email'));
									
									$invoicefile = 'Order' . $order -> id . '.pdf';
									$invoicepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'invoice' . DS;
									$invoicefull = $invoicepath . $invoicefile;
									
									require_once($this -> plugin_base() . DS . 'vendors' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
									$dompdf = new DOMPDF();
									$dompdf -> load_html($html);
									$dompdf -> set_paper('letter', 'portrait');
									$dompdf -> render();
									$dompdf -> stream("order" . $order -> id . ".pdf");
								}
							}
						}
												
						exit();
						break;
					case 'remoteproducts'					:
						global $wpcoDb, $Product;
						$Product -> recursive = false;
						$wpcoDb -> model = $Product -> model;
						
						if ($products = $wpcoDb -> find_all(false, "`id`, `title`, `post_id`, `image`", array('modified', "DESC"), $_REQUEST['count'])) {
							?>
							
							<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							
							<html>
								<head>
									<title><?php bloginfo('name'); ?></title>
									
									<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
									<link rel="stylesheet" href="<?php echo $this -> url(); ?>/css/<?php echo $this -> plugin_name; ?>.css" type="text/css" media="screen" />
								</head>
								<body style="background:none; padding:0; margin:0;">
									<div class="widget" style="padding:0; margin:0; background:none; border:none;">
										<ul>
											<?php foreach ($products as $product) : ?>
												<li>
													<?php if (!empty($_REQUEST['thumbs']) && $_REQUEST['thumbs'] == "Y") : ?>
														<span class="<?php echo $this -> pre; ?>widgetthumb"><?php echo $wpcoHtml -> link($wpcoHtml -> image($wpcoHtml -> thumb_name($product -> image -> name, "small"), array('folder' => "images", 'style' => "width:33px; height:50px;")), get_permalink($product -> post_id), array('target' => "_top", 'title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => $this -> pre . "widgetthumblink")); ?></span>
													<?php endif; ?>
													<span class="<?php echo $this -> pre; ?>widgetitem"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('target' => "_top", 'title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?></span>
													<br class="<?php echo $this -> pre; ?>cleaner" />
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</body>
							</html>
													
							<?php
						}
						
						flush();
						
						$Product -> recursive = true;
						
						exit();
						break;
					case 'updatepages'						:
						$this -> updatepages();
						break;
					case 'ajaxupload'						:
						define('DONOTCACHEPAGE', true);
						define('DONOTCACHEDB', true);
						define('DONOTMINIFY', true);
						define('DONOTCDN', true);
						define('DONOTCACHCEOBJECT', true);
					
						if (!empty($_GET['file'])) {
							$uploaddir = wp_upload_dir();
							$filename = urldecode($_GET['file']);
							$filepath = $uploaddir['basedir'] . DS . $this -> plugin_name . DS . 'ajaxupload' . DS;
							$filefull = $filepath . $filename;
						
							if (file_exists($filefull)) {
								if(ini_get('zlib.output_compression')) { 
									ini_set('zlib.output_compression', 'Off'); 
								}			
								
								$contenttype = (function_exists('mime_content_type')) ? mime_content_type($filefull) : "application/force-download";
								header("Pragma: public");
								header("Expires: 0");
								header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
								header("Cache-Control: public", false);
								header("Content-Description: File Transfer");
								header("Content-Type: " . $contenttype);
								header("Accept-Ranges: bytes");
								header("Content-Disposition: attachment; filename=\"" . $filename . "\";");
								header("Content-Transfer-Encoding: binary");
								header("Content-Length: " . filesize($filefull));
								
								if ($fh = fopen($filefull, 'rb')){
									while (!feof($fh) && connection_status() == 0) {
										@set_time_limit(0);
										print(fread($fh, (1024 * 8)));
										flush();
									}
									
									fclose($fh);
								}
							}
						}
						break;
					case 'download'							:
					
						define('DONOTCACHEPAGE', true);
						define('DONOTCACHEDB', true);
						define('DONOTMINIFY', true);
						define('DONOTCDN', true);
						define('DONOTCACHCEOBJECT', true);
					
						if ($user_ID) {
							if (!empty($_GET['id'])) {
								$wpcoDb -> model = $File -> model;
							
								if ($file = $wpcoDb -> find(array('id' => $_GET['id']))) {							
									if ($this -> can_download($file -> id)) {
										$wpcoDb -> model = $File -> model;
										$wpcoDb -> save_field('downloads', ($file -> downloads + 1), array('id' => $file -> id));
									
										switch ($file -> type) {
											case 'link'				:										
												header("Location: " . $file -> url . "");
												exit();
												break;
											default					:
												$filename = $file -> filename;
												$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'downloads' . DS;
												$filefull = $filepath . $filename;
												
												$fname = $file -> title;
												$fext = $wpcoHtml -> strip_ext($filename, 'ext');
											
												if(ini_get('zlib.output_compression')) { 
													ini_set('zlib.output_compression', 'Off'); 
												}			
												
												header("Pragma: public");
												header("Expires: 0");
												header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
												header("Cache-Control: public", false);
												header("Content-Description: File Transfer");
												//header("Content-Type: " . $file -> filetype . "");
												header("Content-Type: application/force-download");
												header("Accept-Ranges: bytes");
												header("Content-Disposition: attachment; filename=\"" . $wpcoHtml -> sanitize($fname) . '.' . $fext . "\";");
												header("Content-Transfer-Encoding: binary");
												header("Content-Length: " . filesize($filefull));
												
												if ($fh = fopen($filefull, 'rb')){
													while (!feof($fh) && connection_status() == 0) {
														@set_time_limit(0);
														print(fread($fh, (1024 * 8)));
														flush();
													}
													
													fclose($fh);
												} else {
													$message = __('File cannot be read. Please contact us', $this -> plugin_name);
												}
												break;
										}
									} else {
										$message = __('You are not allowed to download this file', $this -> plugin_name);
									}
								} else {
									$message = __('File cannot be read', $this -> plugin_name);
								}
							} else {
								$message = __('No file was specified', $this -> plugin_name);
							}
						} else {
							$message = __('Please register/login to use this feature', $this -> plugin_name);
						}
						
						$Javascript -> alert($message);
						$this -> redirect($this -> referer);
						break;
					case 'additem'							:										
						if (!empty($_GET['cmd']) && ($_GET['cmd'] == "add_to_cart" || $_GET['cmd'] == "updateproductprice")) {
							return false;	
						}
					
						//global variables
						global $errors, $wpcoCart, $user_ID, $wpdb, $wpcoAuth, $Order, $wpcoDb, $Product, $wpcoTax, $Discount,
						$Option, $ProductsOption, $Item, $wpcoFieldsOrder;
					
						$redirect = $this -> referer;
						$doredirect = true;
						$co_id = $Order -> cart_order();
						
						if (!empty($_POST['buynow']) && $_POST['buynow'] == "Y") {												
							$wpcoDb -> model = $Item -> model;
							$wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']));
							$wpcoDb -> model = $wpcoFieldsOrder -> model;
							$wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']));
							
							if (!$user_ID && $this -> get_option('guestcheckout') != "Y") {
								$doredirect = false;
								global $wpcothemedoutput;
								$wpcothemedoutput = $this -> render('contacts', array('order' => $order, 'gotoaccount' => false, 'fromcart' => true), false, 'default');
							}
						} else {
							$nbuynowquery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `buynow` = 'N' WHERE `id` = '" . $order_id . "'";
							$wpdb -> query($nbuynowquery);
						}
										
						if (!empty($_POST)) {
							if (!empty($_POST['Item']['product_id'])) {
								$wpcoDb -> model = $Product -> model;
								
								if ($product = $wpcoDb -> find(array('id' => $_POST['Item']['product_id']))) {
									$redirect = get_permalink($product -> post_id);						
									$stylesvalidate = true;
								
									if (!empty($product -> styles)) {
										foreach ($product -> styles as $style_id) {
											$wpcoDb -> model = $Style -> model;
										
											if ($style = $wpcoDb -> find(array('id' => $style_id))) {
												if (empty($_POST['Item']['styles'][$style_id])) {
													$stylesvalidate = false;
													$errors['styles_' . $style_id] = sprintf(__('Please select %s', $this -> plugin_name), $style -> title);
												}
											}
										}
									}
									
									$countgood = true;
									if ($product -> inventory != "999" && $product -> inventory > 0) {
										if (!empty($_POST['Item']['count'])) {
											if ($_POST['Item']['count'] <= $product -> inventory) {
												//check all items of the order for this product
												$wpcoDb -> model = $Item -> model;
												if ($otheritems = $wpcoDb -> find_all(array('order_id' => $co_id['id'], 'product_id' => $product -> id))) {
													$count = $_POST['Item']['count'];
													
													foreach ($otheritems as $otheritem) {
														if (!empty($otheritem -> count)) {
															$count += $otheritem -> count;
														}
													}
													
													if ($count >= $product -> inventory) {
														$countgood = false;
														$errors['count'] = __('The total number of units in the inventory is', $this -> plugin_name) . ' ' . $product -> inventory . '';
													}
												}
											} else {
												$countgood = false;
												$errors['count'] = __('The total number of units in the inventory is', $this -> plugin_name) . ' ' . $product -> inventory . '';
											}
										} else {
											$countgood = false;
											$errors['count'] = __('Please choose how many you want', $this -> plugin_name);
										}
									}
									
									if (!empty($product -> styles)) {
										foreach ($product -> styles as $style_id) {
											$wpcoDb -> model = $Style -> model;
										
											if ($style = $wpcoDb -> find(array('id' => $style_id))) {
												if (empty($_POST['Item']['styles'][$style_id])) {
													$stylesvalidate = false;
													//$errors[] = __('Please select', $this -> plugin_name) . ' ' . $style -> title;
												} else {
													//check stock on this…
													$itemoption = $_POST['Item']['styles'][$style_id];
													
													$itemsquery = "SELECT * FROM `" . $wpdb -> prefix . $Item -> table . "` WHERE `product_id` = '" . $product -> id . "' AND `order_id` = '" . $co_id['id'] . "'";
													$allitems = $wpdb -> get_results($itemsquery);
													
													if (!empty($itemoption)) {
														if (is_array($itemoption)) {
															//checkboxes...
															foreach ($itemoption as $io) {
																$optionquery = 
																"SELECT " . $wpdb -> prefix . $Option -> table . ".id, 
																" . $wpdb -> prefix . $Option -> table . ".title, 
																" . $wpdb -> prefix . $ProductsOption -> table . ".inventory FROM " . $wpdb -> prefix . $Option -> table . 
																" LEFT JOIN " . $wpdb -> prefix . $ProductsOption -> table . 
																" ON " . $wpdb -> prefix . $Option -> table . ".id = 
																" . $wpdb -> prefix . $ProductsOption -> table . ".option_id WHERE 
																" . $wpdb -> prefix . $Option -> table . ".id = '" . $io . "' AND 
																" . $wpdb -> prefix . $ProductsOption -> table . ".product_id = '" . $product -> id . "'";
																
																if ($option = $wpdb -> get_row($optionquery)) {
																	if ($option -> inventory >= 0) {
																		if ($_POST['Item']['count'] <= $option -> inventory) {
																			if (!empty($allitems)) {
																				$otheritemcount = 0;
																			
																				foreach ($allitems as $allitem) {
																					$allitem_styles = maybe_unserialize($allitem -> styles);
																					
																					if (!empty($allitem_styles[$style_id])) {
																						if (in_array($option -> id, $allitem_styles[$style_id])) {
																							$otheritemcount += $allitem -> count;
																						}
																					}
																				}
																				
																				$count = ($_POST['Item']['count'] + $otheritemcount);																
																				if ($count > $option -> inventory) {
																					$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $option -> inventory);
																					$countgood = false;
																				}
																			} else {
																				$countgood = true;
																			}
																		} else {
																			$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $option -> inventory);
																			$countgood = false;
																		}
																	}
																}
															}
														} else {
															$optionquery = "SELECT * FROM `" . $wpdb -> prefix . $Option -> table . "` WHERE `id` = '" . $itemoption . "'";
															$option = $wpdb -> get_row($optionquery);
															$productsoptionquery = "SELECT * FROM `" . $wpdb -> prefix . $ProductsOption -> table . "` WHERE `option_id` = '" . $itemoption . "' AND `product_id` = '" . $product -> id . "'";
															if ($productsoption = $wpdb -> get_row($productsoptionquery)) {
																if ($productsoption -> inventory >= 0) {
																	if ($_POST['Item']['count'] <= $productsoption -> inventory) {
																		if (!empty($allitems)) {
																			$otheritemcount = 0;
																		
																			foreach ($allitems as $allitem) {
																				$allitem_styles = maybe_unserialize($allitem -> styles);																
																				if (!empty($allitem_styles[$style_id]) && $allitem_styles[$style_id] == $productsoption -> option_id) {
																					$otheritemcount += $allitem -> count;
																				}
																			}
																			
																			$count = ($_POST['Item']['count'] + $otheritemcount);															
																			if ($count > $productsoption -> inventory) {
																				$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $productsoption -> inventory);
																				$countgood = false;
																			}
																		} else {
																			$countgood = true;
																		}
																	} else {
																		$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $productsoption -> inventory);
																		$countgood = false;
																	}
																}
															}
														}
													}
												}
											}
										}
									}
									
									if (!empty($product -> min_order) && $product -> min_order > 1) {
										if ($_POST['Item']['count'] < $product -> min_order) {
											$countgood = false;
											$errors['count'] = sprintf(__('Minimum order is %s', $this -> plugin_name), $product -> min_order);
										}
									}
									
									$fieldsvalidate = true;
									if (!empty($product -> cfields)) {
										foreach ($product -> cfields as $field_id) {
											$value = "";
											$wpcoDb -> model = $wpcoField -> model;
											
											if ($field = $wpcoDb -> find(array('id' => $field_id))) {
												if (!empty($field -> required) && $field -> required == "Y") {
													if (empty($_POST['Item']['fields'][$field -> id]) && $_POST['Item']['fields'][$field -> id] != "0") {
														$errors['fields_' . $field_id] = (empty($field -> error)) ? sprintf(__('Please fill in', $this -> plugin_name), $field -> title) : $field -> error;
														$fieldsvalidate = false;
													}
												}
												
												if (!empty($_POST['Item']['fields'][$field -> id])) {
													$value = $_POST['Item']['fields'][$field -> id];
																
													if (is_array($value) || is_object($value)) {
														$value = serialize($value);
													}
													
													$_POST['Item'][$field -> slug] = $value;
												}
											}
										}
									}
									
									if (($stylesvalidate == true && $fieldsvalidate == true && $countgood == true)) {
										$wpcoDb -> model = $Item -> model;
										
										if ($wpcoDb -> save($_POST, true)) {
											$Order -> update_totals();
											$doredirect = true;
											
											if ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) {
												$buynowpmethod = $this -> get_option('buynowpmethod');
												$wpcoCart -> cart_to_order();
												$order_id = $Order -> current_order_id();	
												$orderquery = "UPDATE " . $wpdb -> prefix . $Order -> table . " SET `buynow` = 'Y', `pmethod` = '" . $buynowpmethod . "' WHERE `id` = '" . $order_id . "' LIMIT 1";
												$wpdb -> query($orderquery);
												
																							
												$tempmethod = ($Order -> do_shipping($order_id)) ? 'shipping' : 'billing';
												$method = ($user_ID || $this -> get_option('guestcheckout') == "Y") ? $tempmethod : 'contacts';
												
												switch ($method) {
													case 'contacts'			:
														$redirect = $wpcoHtml -> contacts_url();
														break;
													case 'shipping'			:
														$redirect = $wpcoHtml -> ship_url();
														break;
													case 'billing'			:
														$redirect = $wpcoHtml -> bill_url();
														break;
													case 'cart'				:
													default					:
														$redirect = $wpcoHtml -> cart_url();
														break;
												}
												
												$doredirect = true;
												$redirect = $wpcoHtml -> retainquery('pmethod=' . $buynowpmethod . '&order_id=' . $order_id, $redirect);
											} else {
												$redirect = $wpcoHtml -> cart_url();
											}
										} else {
											$errors = array_merge((array) $errors, (array) $Item -> errors);
											$doredirect = false;
										}
									} else {										
										$message = '';										
										if (!empty($_POST['fromproductpage'])) {
											$doredirect = false;
										}
									}
								} else {
									$message = __('Product cannot be read', $this -> plugin_name);
								}
							} else {
								$message = __('No product was specified', $this -> plugin_name);
							}
						} else {
							$message = __('No data was posted', $this -> plugin_name);
						}
						
						if (!empty($doredirect) && $doredirect == true) {
							if (!empty($message)) {
								$Javascript -> alert($message, false, true);
							}
						
							$this -> redirect($redirect);
						}
						break;
					case 'affiliate'						:
						if (!empty($_GET['id'])) {
							global $wpcoDb, $Product;
							$wpcoDb -> model = $Product -> model;
							
							if ($product = $wpcoDb -> find(array('id' => $_GET['id']))) {
								if (!empty($product -> affiliate) && $product -> affiliate == "Y") {
									if (!empty($product -> affiliateurl)) {
										$wpcoDb -> save_field('affiliatehits', ($product -> affiliatehits + 1), array('id' => $product -> id));
										$this -> redirect($product -> affiliateurl);
										
										exit();
									} else {
										$message = __('No referral URL is available', $this -> plugin_name);
									}
								} else {
									$message = __('This is not an affiliate product', $this -> plugin_name);
								}
							} else {
								$message = __('Product cannot be read', $this -> plugin_name);
							}
						} else {
							$message = __('No product was specified', $this -> plugin_name);
						}
					
						$Javascript -> alert($message);
						$this -> redirect($_SERVER['HTTP_REFERER']);
						break;
					case 'deleteitem'						:
						global $wpdb, $Javascript, $wpcoDb, $Order, $Item, $Product, $Discount;
						$wpcoDb -> model = $Item -> model;
							
						if (!empty($_GET['item_id'])) {	
							if ($item = $wpcoDb -> find(array('id' => $_GET['item_id']))) {	
								$authuser = $wpcoAuth -> check_user();
								
								$discount = $Discount -> total($item -> order_id);
								$total = $Order -> total($item -> order_id, true, true, true, true, true);
								$itemprice = ($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true, false, true) * $item -> count);
								$newtotal = ($total - $itemprice);
													
								if (empty($discount) || (!empty($discount) && $newtotal > 0)) {
									if ($item -> user == $authuser && $item -> completed == "N" && $item -> paid == "N") {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> delete($_GET['item_id']);
									} else {
										$message = __('This item is not associated with you, clear your cookies and try again.', $this -> plugin_name);
									}
								} else {
									$message = __('Deleting this item will make the order total smaller than zero. Please delete your discount first.', $this -> plugin_name);
								}
							} else {
								$message = __('Order item could not be read, please try again.', $this -> plugin_name);
							}
						} else {
							$message = __('No order item was specified, please try again.', $this -> plugin_name);
						}
						
						if (!empty($message)) {
							$Javascript -> alert($message, false, false);
						}
						
						$this -> redirect($this -> referer);
						break;
					case 'updatecart'						:
						global $wpcoHtml, $wpcoDb, $wpcoCart, $Order, $wpcoFieldsOrder;
						$errors = null;
						$wpcoCart -> cart_to_order();
								
						if (!empty($_POST['Item']['checklist'])) {
							$items = $_POST['Item']['checklist'];
							
							foreach ($items as $item_id) {
								$wpcoDb -> model = $Item -> model;
							
								if ($item = $wpcoDb -> find(array('id' => $item_id))) {							
									$wpcoDb -> model = $Item -> model;
									$wpcoDb -> delete($item_id);
								}
							}
						}
						
						if (!empty($_POST['Item']['count'])) {						
							foreach ($_POST['Item']['count'] as $item_id => $count) {
								$wpcoDb -> model = $Item -> model;
							
								if ($item = $wpcoDb -> find(array('id' => $item_id))) {							
									if (empty($count) || $count == 0) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> delete($item_id);
									} else {			
										$countgood = true;
																
										if (empty($item -> product -> min_order) || (!empty($item -> product -> min_order) && $count >= $item -> product -> min_order)) {
											if (!empty($item -> product -> inventory) && $item -> product -> inventory > 0) {
												$wpcoDb -> model = $Item -> model;
												if ($otheritems = $wpcoDb -> find_all(array('order_id' => $item -> order_id, 'product_id' => $item -> product_id))) {
													$itemscount = $count;
													
													foreach ($otheritems as $otheritem) {
														if ($otheritem -> id != $item_id) {
															if (!empty($otheritem -> count)) {
																$itemscount += $otheritem -> count;
															}
														}
													}
													
													if ($itemscount > $item -> product -> inventory) {
														$countgood = false;
													}
												}
											}
										} else {
											$countgood = false;	
										}
										
										if (!empty($countgood) && $countgood == true) {													
											$wpcoDb -> model = $Item -> model;
											$wpcoDb -> save_field('count', $count, array('id' => $item_id));	
										}
									}
								}
							}
						} else {
							$errors[] = __('No item quantities available', $this -> plugin_name);
						}
						
						$order_id = $Order -> current_order_id();
					
						/* Global Custom Fields */
						$globalerrors = array();
						$wpcoDb -> model = $wpcoField -> model;
						
						if ($fields = $wpcoDb -> find_all(array('globalf' => "Y", 'globalp' => "cart"))) {
							foreach ($fields as $field) {
								$wpcoDb -> model = $wpcoFieldsOrder -> model;
								$wpcoDb -> delete_all(array('order_id' => $order_id, 'field_id' => $field -> id));
							
								if (empty($_POST['Item']['fields'][$field -> id])) {
									if (!empty($field -> required) && $field -> required == "Y") {
										$globalerrors[$field -> slug] = (empty($field -> error)) ? __('Please fill in', $this -> plugin_name) . ' ' . $field -> title : $field -> error;
									}
								} else {
									$wpcoDb -> model = $wpcoFieldsOrder -> model;
									$fieldorder_data = array('field_id' => $field -> id, 'order_id' => $order_id, 'value' => $_POST['Item']['fields'][$field -> id]);
									$wpcoDb -> save($fieldorder_data);
								}
							}
						}
						
						/* Minimum Order Weight */
						if ($weight_minimum = $this -> get_option('weight_minimum')) {						
							if (!empty($weight_minimum) && $weight_minimum > 0) {
								$co_id = $Order -> cart_order();
								$weight = $Order -> weight($co_id);
								$weightm = $this -> get_option('weightm');
								if (empty($weight) || $weight < $weight_minimum) {
									$errors[] = sprintf(__('The minimum required weight for all orders is %s. Please add more to your order.', $this -> plugin_name), $weight_minimum . $weightm);
								}
							}
						}
						
						$errors = apply_filters($this -> pre . '_cart_validation', $errors, $_POST, $order_id);
						
						if (!empty($errors) || !empty($globalerrors)) {								
							global $wpcoerrors, $wpcoglobalerrors;
							$wpcoerrors = $errors;
							$wpcoglobalerrors = $globalerrors;
						} else {
							if (!empty($_POST['update'])) {
								$this -> redirect($this -> referer);
							} else {		
								$redirect = $wpcoHtml -> cart_url();		
								$tempmethod = ($this -> get_option('shippingdetails') == "Y") ? 'shipping' : 'billing';
								global $user_ID;
								$method = ($user_ID || $this -> get_option('guestcheckout') == "Y") ? $tempmethod : 'contacts';
								
								switch ($method) {
									case 'contacts'			:
										$redirect = $wpcoHtml -> contacts_url();
										break;
									case 'shipping'			:
										$redirect = $wpcoHtml -> ship_url();
										break;
									case 'billing'			:
										$redirect = $wpcoHtml -> bill_url();
										break;
									case 'cart'				:
									default					:
										$redirect = $wpcoHtml -> cart_url();
										break;
								}
									
								$this -> redirect($redirect);
							}
						}
						break;
					case 'deleteitems'						:
						if ($user_ID) {
							if (!empty($_POST['Item']['checklist'])) {
								$items = $_POST['Item']['checklist'];
								
								foreach ($items as $item_id) {
									$wpcoDb -> model = $Item -> model;
								
									if ($item = $wpcoDb -> find(array('id' => $item_id))) {
										if ($item -> user_id == $user_ID) {
											$wpcoDb -> delete($item_id);
										}
									}
								}
								
								$message = __('Selected order items have been removed', $this -> plugin_name);
							} else {
								$message = __('No order items were selected', $this -> plugin_name);
							}
						} else {
							$message = __('You are not logged in', $this -> plugin_name);
						}
						
						$Javascript -> alert($message);
						$this -> redirect($this -> referer);
						break;
					case 'updateqty'						:
						if ($user_ID) {
							if (!empty($_POST['Item']['count'])) {
								foreach ($_POST['Item']['count'] as $item_id => $count) {
									$wpcoDb -> model = $Item -> model;
								
									if ($item = $wpcoDb -> find(array('id' => $item_id))) {
										if ($item -> user_id == $user_ID) {
											if (empty($item -> product -> min_order) || (!empty($item -> product -> min_order) && $count >= $item -> product -> min_order)) {
												$wpcoDb -> save_field('count', $count, array('id' => $item_id));
											}
										}
									}
								}
								
								$message = __('Item quantities have been updated', $this -> plugin_name);
							} else {
								$message = __('No item quantities available', $this -> plugin_name);
							}
						} else {
							$message = __('You are not logged in', $this -> plugin_name);
						}
						
						$Javascript -> alert($message);
						$this -> redirect($this -> referer);
						break;
					case 'deletecoupon'						:
						if (!empty($_GET['id'])) {
							if ($co_id = $Order -> cart_order()) {
							//if ($order_id = $Order -> current_order_id()) {
								$wpcoDb -> model = $Discount -> model;
								if ($discount = $wpcoDb -> find(array('id' => $_GET['id'], $co_id['type'] . '_id' => $co_id['id']))) {
									$wpcoDb -> model = $Discount -> model;
									if ($wpcoDb -> delete($_GET['id'])) {
										//nothing...
									} else {
										$message = __('Discount coupon cannot be removed', $this -> plugin_name);
									}
								} else {
									$message = __('Discount coupon cannot be found', $this -> plugin_name);
								}
							} else {
								$message = __('No active order can be found', $this -> plugin_name);
							}
						} else {
							$message = __('No discount coupon was specified', $this -> plugin_name);
						}
						
						if (!empty($message)) { $Javascript -> alert($message); }
						$this -> redirect($this -> referer);
						break;
					case 'applycoupon'						:
						$co_id = $Order -> cart_order();
						$wpcoDb -> model = $Discount -> model;
						$dcount = $wpcoDb -> count(array($co_id['type'] . '_id' => $co_id['id']));
						$total = $Order -> total($co_id, true, false, true, true, true);
						
						if (empty($dcount) || $this -> get_option('multicoupon') == "Y") {
							if (!empty($_POST['code'])) {
								$wpcoDb -> model = $Coupon -> model;
								$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $Coupon -> table . "` WHERE `code` = '" . mysql_escape_string($_POST['code']) . "'";
													
								if ($coupon = $wpcoDb -> find(array('code' => $_POST['code']))) {									
									if ($coupon -> active == "Y") {										
										if ((!empty($coupon -> expiry) && $coupon -> expiry != "0000-00-00" && $coupon -> expiry >= date("Y-m-d", time())) || empty($coupon -> expiry) || $coupon -> expiry == "0000-00-00") {
											if (empty($coupon -> maxuse) || (!empty($coupon -> maxuse) && $coupon -> used < $coupon -> maxuse)) {
												$wpcoDb -> model = $Discount -> model;
											
												if (!$wpcoDb -> find(array($co_id['type'] . '_id' => $co_id['id'], 'coupon_id' => $coupon -> id))) {												
													if (($total >= $Coupon -> discount($coupon -> id, $co_id)) && ($total >= ($Coupon -> discount($coupon -> id, $co_id) + $Discount -> total($co_id)))) {
														$wpcoDb -> model = $Discount -> model;
													
														$discount_data = array(
															$co_id['type'] . '_id'			=>	$co_id['id'],
															'user'							=>	$wpcoAuth -> check_user(),
															'user_id'						=>	($user_ID) ? $user_ID : 0,
															'coupon_id'						=>	$coupon -> id,
														);
														
														if ($wpcoDb -> save($discount_data, true)) {
															//$message = __('Discount coupon has been applied', $this -> plugin_name);
														} else {
															$message = __('Coupon cannot be applied', $this -> plugin_name);
														}
													} else {
														$message = __('Too much discount being applied', $this -> plugin_name);
													}
												} else {
													$message = __('You have already applied this coupon code', $this -> plugin_name);
												}
											} else {
												$message = __('This coupon has exceeded its usage count.', $this -> plugin_name);	
											}
										} else {
											$message = __('This discount coupon has expired', $this -> plugin_name);
										}
									} else {
										$message = __('Discount coupon is inactive', $this -> plugin_name);
									}
								} else {
									$message = __('No coupon with this code could be found', $this -> plugin_name);
								}
							} else {
								$message = __('Please fill in a discount coupon code', $this -> plugin_name);
							}
						} else {
							$message = __('You have already submitted a coupon code', $this -> plugin_name);
						}
						
						if (!empty($message)) { $Javascript -> alert($message); }
						$this -> redirect($this -> referer);
						break;
					case 'cart'								:
						global $wpcoDb, $Order, $wpcoCart, $wpcoFieldsOrder;
					
						$title = __('Shopping Cart', $this -> plugin_name);
						ob_start();					
						
						?>
						
						<h2><?php _e('Shopping Cart', $this -> plugin_name); ?></h2>
						
						<?php
						
						$content = ob_get_clean();
	
						if (!empty($_GET['empty'])) {
							$co_id = $Order -> cart_order();
							$wpcoDb -> model = $Item -> model;
							if (!empty($co_id)) {
								if ($wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']))) {
									$wpcoDb -> model = $wpcoFieldsOrder -> model;
									$wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']));
									
									if ($co_id['type'] == "order") {	
										$wpcoDb -> model = $Order -> model;
									} else {
										$wpcoDb -> model = $wpcoCart -> model;
									}
									
									$wpcoDb -> delete($co_id['id']);								
									$successmsg = __('All items removed', $this -> plugin_name);
								}
							}
							
							$this -> redirect($this -> referer);
						}
						
						$order_id = $Order -> current_order_id();					
						$wpcoDb -> model = $Order -> model;
						$order = $wpcoDb -> find(array('id' => $order_id));					
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order_id));
						
						if (empty($items) && empty($_GET['empty'])) {
							$message = __('There are no items in your shopping cart', $this -> plugin_name);
							$Javascript -> alert($message);
							$this -> redirect($this -> get_option('shopurl'));
						}
						
						$this -> redirect($this -> referer);
						break;
					case 'contacts'							:
						global $wpdb, $wpcoDb, $Order, $wpcoCart;
						$errors = array();
						$co_id = $Order -> cart_order();
						$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
						$wpcoDb -> save_field('fromcontacts', 1, array('id' => $co_id['id']));
						
						if ($this -> get_option('guestcheckout') == "Y") {
							$location = ($Order -> do_shipping($co_id)) ? $wpcoHtml -> ship_url() : $wpcoHtml -> bill_url();
							header("Location: " . $location);
						}
						
						if (!empty($_POST)) {						
							if (!empty($_GET['login'])) {
								//do nothing...
							} elseif (!empty($_GET['register'])) {
								if (empty($_POST['fname'])) { $errors['fname'] = __('Please fill in your first name', $this -> plugin_name); }
								if (empty($_POST['lname'])) { $errors['lname'] = __('Please fill in your last name', $this -> plugin_name); }
								if (empty($_POST['email'])) { $errors['email'] = __('Please fill in your email address', $this -> plugin_name); }
								elseif (!is_email($_POST['email'])) { $errors['email'] = __('Please fill in a valid email address', $this -> plugin_name); }
								elseif (email_exists($_POST['email'])) { $errors['email'] = __('Email address is already in use', $this -> plugin_name); }
								
								if ($this -> get_option('usernamepreference') == "Y") {
									if (empty($_POST['username'])) { $errors['username'] = __('Please fill in a username', $this -> plugin_name); }	
								}
								
								//if password preference was turned ON
								if ($this -> get_option('choosepassword') == "Y") {
									if (empty($_POST['password1'])) { $errors['password1'] = __('Please fill in a password', $this -> plugin_name); }
									if (empty($_POST['password2'])) { $errors['password2'] = __('Please retype your password', $this -> plugin_name); }
									
									if (!empty($_POST['password1']) && !empty($_POST['password2'])) {
										if ($_POST['password1'] !== $_POST['password2']) {
											$errors['password1'] = $errors['password2'] = __('Passwords do not match', $this -> plugin_name);
										}
									}
								}
								
								//reCAPTCHA validation/verification
								$registercaptcha = $this -> get_option('registercaptcha');
								if (!empty($registercaptcha) && $registercaptcha == "Y") {
									require_once($this -> plugin_base() . DS . 'vendors' . DS . 'recaptcha' . DS . 'recaptchalib.php');
									$privatekey = $this -> get_option('registercaptcha_privatekey');
									$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
									
									if (!$resp -> is_valid) {
										$errors['captcha'] = __('Please fill in the correct value in the image', $this -> plugin_name);
									}
								}
								
								//Honeypot validation/verification
								if (!empty($_POST['namefield'])) {
									$errors['namefield'] = __('Verification error, this may be an automated submission', $this -> plugin_name);
								}
								
								$errors = apply_filters($this -> pre . '_contacts_register_validation', $errors, $_POST, $co_id);
								
								if (empty($errors)) {
									$user = (!empty($_GET['userstring'])) ? $_GET['userstring'] : $wpcoAuth -> check_user();
									$username = ($this -> get_option('usernamepreference') == "N" || empty($_POST['username'])) ? $_POST['email'] : $_POST['username'];
									//password. either input by user or generate a random one
									$password = ($this -> get_option('choosepassword') == "Y") ? $_POST['password1'] : substr(md5(uniqid(microtime())), 0, 6);
									
									if ($user_id = wp_insert_user(array('user_login' => $username, 'user_pass' => $password, 'user_email' => $_POST['email'], 'first_name' => $_POST['fname'], 'last_name' => $_POST['lname'], 'display_name' => $_POST['fname'] . ' ' . $_POST['lname'], 'user_nicename ' => $_POST['fname'] . ' ' . $_POST['lname']))) {
										$wpuser = new WP_User($user_id);
										$wpuser -> set_role("customer");
									
										if ($this -> get_option('newusernotification') == "Y") {
											wp_new_user_notification($user_id, $password);
										}
									
										if ($this -> user_login($username, $password, true)) {											
											$wpcoDb -> model = $Order -> model;
											$wpcoDb -> save_field('fname', $_POST['fname'], array('user' => $user, 'completed' => "N", 'user_id' => '0'));
											$wpcoDb -> model = $Order -> model;
											$wpcoDb -> save_field('lname', $_POST['lname'], array('user' => $user, 'completed' => "N", 'user_id' => '0'));
											$wpcoDb -> model = $Order -> model;
											$wpcoDb -> save_field('email', $_POST['email'], array('user' => $user, 'completed' => "N", 'user_id' => '0'));
											$wpcoDb -> model = $Order -> model;
											$wpcoDb -> save_field('user_id', $user_id, array('user' => $user, 'completed' => "N", 'user_id' => '0'));
											$wpcoDb -> model = $Item -> model;
											$wpcoDb -> save_field('user_id', $user_id, array('user' => $user, 'completed' => "N", 'user_id' => '0'));
											$wpcoDb -> model = $Discount -> model;
											$wpcoDb -> save_field('user_id', $user_id, array('user' => $user, 'user_id' => '0'));
											
											//current order ID
											//$order_id = $Order -> current_order_id();
											//$wpcoDb -> model = $Order -> model;
											//$wpcoDb -> save_field('user', $user, array('id' => $order_id));
											if ($co_id['type'] == "order") {
												$userquery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `user` = '" . $user . "' WHERE `id` = '" . $co_id['id'] . "' LIMIT 1";
											} else {
												$userquery = "UPDATE `" . $wpdb -> prefix . $wpcoCart -> table . "` SET `userauth` = '" . $user . "' WHERE `id` = '" . $co_id['id'] . "' LIMIT 1";
											}
											$wpdb -> query($userquery);
											
											if (!empty($_POST['incheckout']) && $_POST['incheckout'] == 1) {
												$location = ($Order -> do_shipping($co_id)) ? $wpcoHtml -> ship_url() : $wpcoHtml -> bill_url();
											} else {
												$location = $wpcoHtml -> account_url();
											}
											
											//redirect the customer
											header("Location: " . $location);
											exit();									
										}
									}
								}
							}
						}
						
						global $wpcoerrors;
						$wpcoerrors = $errors;
						break;
					case 'shipping'							:											
						global $wpdb, $wpcoDb, $wpcoCart, $wpcoHtml, $wpcoField, $wpcoFieldsOrder, $Order, $wpcoShipmethod;
						$errors = false;
						$wpcoCart -> cart_to_order();
						$order_id = $Order -> current_order_id();
						
						if (!$Order -> do_shipping($order_id)) {
							$location = $wpcoHtml -> bill_url();
							header("Location: " . $location);
							exit();	
						}
					
						if (!empty($_POST[$this -> pre . 'shipping'])) {
							if ($Order -> do_shipping($order_id) && empty($_POST[$this -> pre . 'shipmethod'])) {
								$errors['shipmethod'] = __('Please select a shipping method', $this -> plugin_name);
							}
						
							foreach ($_POST[$this -> pre . 'shipping'] as $pkey => $pval) {
								if ($user_ID) {
									delete_user_meta($user_ID, 'ship_' . $pkey);
									
									if (!empty($pval)) {
										update_user_meta($user_ID, 'ship_' . $pkey, $pval);
									}
									
									$wpcoDb -> model = $Order -> model;
									$wpcoDb -> save_field('email', get_user_meta($user_ID, 'user_email', true));
								}
								
								$updatequery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `ship_" . $pkey . "` = '" . esc_sql($pval) . "' WHERE `id` = '" . $order_id . "' LIMIT 1";
								$wpdb -> query($updatequery);
							}
							
							/* Validation of fields */
							if ($paymentfields = $this -> get_option('paymentfields')) {
								$shippingfields = $paymentfields['shipping'];								
								foreach ($shippingfields as $skey => $shippingfield) {
									if (!empty($shippingfield['show']) && !empty($shippingfield['required'])) {
										if (empty($_POST[$this -> pre . 'shipping'][$skey])) {
											$errors[$skey] = __('Please fill in your ', $this -> plugin_name) . strtolower($shippingfield['title']);
										}
										
										switch($skey) {
											case 'email'		:
												if (!is_email($_POST[$this -> pre . 'shipping'][$skey])) {
													$errors[$skey] = __('Please fill in a valid email address.', $this -> plugin_name);
												}
												break;
										}
									}
								}
							}
							
							/* Global Custom Fields */
							$globalerrors = array();
							$wpcoDb -> model = $wpcoField -> model;
							
							if ($fields = $wpcoDb -> find_all(array('globalf' => "Y", 'globalp' => "ship"))) {
								foreach ($fields as $field) {
									$wpcoDb -> model = $wpcoFieldsOrder -> model;
									$wpcoDb -> delete_all(array('order_id' => $order_id, 'field_id' => $field -> id));
								
									if (empty($_POST['Item']['fields'][$field -> id])) {
										if (!empty($field -> required) && $field -> required == "Y") {
											$globalerrors[$field -> slug] = (empty($field -> error)) ? __('Please fill in', $this -> plugin_name) . ' ' . $field -> title : $field -> error;
										}
									} else {
										$wpcoDb -> model = $wpcoFieldsOrder -> model;
										$fieldorder_data = array('field_id' => $field -> id, 'order_id' => $order_id, 'value' => $_POST['Item']['fields'][$field -> id]);
										$wpcoDb -> save($fieldorder_data);
									}
								}
							}
							
							$errors = apply_filters($this -> pre . '_shipping_validation', $errors, $_POST, $order_id);
							
							if (!empty($_POST[$this -> pre . 'shipmethod'])) {
								$wpcoDb -> model = $Order -> model;
								$wpcoDb -> save_field('shipmethod_id', $_POST[$this -> pre . 'shipmethod'], array('id' => $order_id));
								if ($user_ID) { update_user_meta($user_ID, 'shipmethod', $_POST[$this -> pre . 'shipmethod']); }
							}
							
							if (empty($errors) && empty($globalerrors)) {										
								$location = $wpcoHtml -> bill_url();
								$wpcoDb -> model = $wpcoShipmethod -> model;
								
								do_action($this -> pre . '_shipping_saved', $order_id, $_POST);
								
								if (!empty($_POST[$this -> pre . 'shipmethod']) && $shipmethod = $wpcoDb -> find(array('id' => $_POST[$this -> pre . 'shipmethod']))) {											
									$subtotal = $Order -> total($order_id, false, false, true, true, false);
									$subtotaltax = $Order -> total($order_id, false, false, true, true, true);
									
									if (!empty($shipmethod -> api)) {
										if (!empty($_POST['cu_shipmethod'])) {
											switch ($shipmethod -> api) {
												case 'usps'					:
													if ($usps = $this -> vendor('usps', 'shipping' . DS . 'usps' . DS)) {
														$shipping = $usps -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
												case 'fedex'				:
													if ($fedex = $this -> vendor('fedex', 'shipping' . DS . 'fedex' . DS)) {
														$shipping = $fedex -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
												case 'auspost'				:
													if ($auspost = $this -> vendor('auspost', 'shipping' . DS)) {
														$shipping = $auspost -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
												case 'canadapost'			:
													if ($canadapost = $this -> vendor('canadapost', 'shipping' . DS . 'canadapost' . DS)) {
														$shipping = $canadapost -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
												case 'ups'					:
													if ($ups = $this -> vendor('ups', 'shipping' . DS . 'ups' . DS)) {
														$shipping = $ups -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
												case 'echo'					:
													if ($this -> is_plugin_active('echo') && $echo = $this -> extension_vendor('echo')) {
														$shipping = $echo -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
												case 'upsfreight'					:
													if ($this -> is_plugin_active('upsfreight') && $upsfreight = $this -> extension_vendor('upsfreight')) {
														$shipping = $upsfreight -> savemethod($_POST['cu_prices'], $_POST['cu_shipmethod']);
													}
													break;
											}
											
											$wpcoDb -> model = $Order -> model;
											$wpcoDb -> save_field('shipping', $shipping, array('id' => $order_id));
											$wpcoDb -> save_field('total', ($subtotaltax + $shipping), array('id' => $order_id));											
										} else {
											$errors['shipmethod'] = __('Please choose your preferred shipping service.', $this -> plugin_name);
										}
									} else {
										$shipping = $Order -> shipping_total($subtotal, $order_id);
										$shipmethod_name = $wpcoHtml -> shipmethod_name($shipmethod -> id);										
										$wpcoDb -> model = $Order -> model;
										$wpcoDb -> save_field('shipping', $shipping, array('id' => $order_id));	
										$wpcoDb -> save_field('shipmethod_name', $shipmethod_name, array('id' => $order_id));
										$wpcoDb -> save_field('total', ($subtotaltax + $shipping), array('id' => $order_id));
									}
									
									$Order -> update_totals();
								}
								
								if (empty($_GET['updateshipping']) && empty($errors)) {									
									header("Location: " . $location);
									exit();
								} else {
									global $wpcoerrors;
									$wpcoerrors = $errors;	
								}
							}
						}
						
						global $wpcoerrors, $wpcoglobalerrors;
						$wpcoerrors = $errors;
						$wpcoglobalerrors = $globalerrors;
						break;
					case 'billing'							:
						global $wpdb, $wpcoCart, $wpcoDb, $wpcoField, $wpcoFieldsOrder, $wpcoTax, $Order, $Discount;
						$errors = false;
						$wpcoCart -> cart_to_order();
						$order_id = $Order -> current_order_id();
						$paymentfields = $this -> get_option('paymentfields');
					
						if ($user_ID || $this -> get_option('guestcheckout') == "Y") {
							if (!empty($_POST)) {						
								if (!empty($_POST[$this -> pre . 'billing'])) {
									$billing = $_POST[$this -> pre . 'billing'];
	
									if (empty($_POST['pmethod'])) { $errors['pmethod'] = __('Please choose a payment method', $this -> plugin_name); }
									else { 
										if ($user_ID) { update_user_meta($user_ID, 'bill_pmethod', $_POST['pmethod']); }
										$wpdb -> query("UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `pmethod` = '" . $_POST['pmethod'] . "' WHERE `id` = '" . $order_id . "' LIMIT 1");
										
										switch ($_POST['pmethod']) {
											case 'cc'					:
												if (empty($billing['cc_name'])) { $errors['cc_name'] = __('Please fill in the name on the card', $this -> plugin_name); };
												if (empty($billing['cc_type'])) { $errors['cc_type'] = __('Please select the credit card type', $this -> plugin_name); };
												if (empty($billing['cc_number'])) { $errors['cc_number'] = __('Please fill in your card number', $this -> plugin_name); }
												elseif (!is_numeric($billing['cc_number'])) { $errors['cc_number'] = __('Only numbers are allowed', $this -> plugin_name); }
												if (empty($billing['cc_exp_m'])) { $errors['cc_exp_m'] = __('Please select the expiry date month', $this -> plugin_name); };
												if (empty($billing['cc_exp_y'])) { $errors['cc_exp_y'] = __('Please select the expiry date year', $this -> plugin_name); };
												if (!$this -> get_option('billcvv') || $this -> get_option('billcvv') == "Y") { if (empty($billing['cc_cvv'])) { $errors['cc_cvv'] = __('Please fill in your CVV code on the back', $this -> plugin_name); } }
												break;
										}
									}
									
									if (!empty($_POST['sameasshipping']) && $_POST['sameasshipping'] == "Y") {
										if ($user_ID) { update_user_meta($user_ID, 'billingsameshipping', "Y"); }
										$bsquery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `billsameasship` = 'Y' WHERE `id` = '" . $order_id . "' LIMIT 1";
										$wpdb -> query($bsquery);
										$orderquery = "SELECT * FROM " . $wpdb -> prefix . $Order -> table . " WHERE `id` = '" . $order_id . "' LIMIT 1";
										if ($order = $wpdb -> get_row($orderquery)) {
											if (!empty($paymentfields['billing'])) {
												foreach ($paymentfields['billing'] as $bkey => $bfield) {
													$_POST[$this -> pre . 'billing'][$bkey] = $order -> {'ship_' . $bkey};
												}
											}
										}
									} else {
										if ($user_ID) { update_user_meta($user_ID, 'billingsameshipping', "N"); }
										$bsquery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `billsameasship` = 'N' WHERE `id` = '" . $order_id . "' LIMIT 1";
										$wpdb -> query($bsquery);
										if (!empty($paymentfields['billing'])) {
											$billingfields = $paymentfields['billing'];
											
											foreach ($billingfields as $bkey => $billingfield) {
												if (!empty($billingfield['show']) && !empty($billingfield['required'])) {
													if (empty($_POST[$this -> pre . 'billing'][$bkey])) {
														$errors[$bkey] = __('Please fill in your ', $this -> plugin_name) . strtolower($billingfield['title']);
													}
													
													switch($bkey) {
														case 'email'		:
															if (!is_email($_POST[$this -> pre . 'billing'][$bkey])) {
																$errors[$bkey] = __('Please fill in a valid email address.', $this -> plugin_name);
															}
															break;
													}
												}
											}
										}
									}
									
									if ($user_ID) { delete_user_meta($user_ID, 'bill_address2'); }
									$notcolumns = array('countrycode', 'isocountrycode', 'countryname', 'cc_name', 'cc_type', 'cc_number', 'cc_exp_m', 'cc_exp_y', 'cc_cvv');
									
									foreach ($_POST[$this -> pre . 'billing'] as $pkey => $pval) {	
										if ($user_ID) { delete_user_meta($user_ID, 'bill_' . $pkey); }
										$wpcoDb -> model = $Order -> model;																								
										if (empty($errors[$pkey])) {
											if ($user_ID) { update_user_meta($user_ID, 'bill_' . $pkey, $pval); }											
											if (!in_array($pkey, $notcolumns)) {
												$wpcoDb -> save_field('bill_' . $pkey, $pval, array('id' => $order_id));
											}
										} else {
											if (!in_array($pkey, $notcolumns)) {
												$wpcoDb -> save_field('bill_' . $pkey, $pval, array('id' => $order_id));
											}
										}
									}
									
									# Manual POS fields
									if (!empty($_POST['pmethod']) && $_POST['pmethod'] == "cc") {
										$ccquery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET
										`cc_name` = '" . $billing['cc_name'] . "', 
										`cc_type` = '" . $billing['cc_type'] . "', 
										`cc_number` = '" . $billing['cc_number'] . "', 
										`cc_exp_m` = '" . $billing['cc_exp_m'] . "', 
										`cc_exp_y` = '" . $billing['cc_exp_y'] . "', 
										`cc_cvv` = '" . $billing['cc_cvv'] . "' 
										WHERE `id` = '" . $order_id . "' LIMIT 1";
										
										$wpdb -> query($ccquery);
									}
									
									/* Global Custom Fields */
									$globalerrors = array();
									$wpcoDb -> model = $wpcoField -> model;
									
									if ($fields = $wpcoDb -> find_all(array('globalf' => "Y", 'globalp' => "bill"))) {
										foreach ($fields as $field) {
											$wpcoDb -> model = $wpcoFieldsOrder -> model;
											$wpcoDb -> delete_all(array('order_id' => $order_id, 'field_id' => $field -> id));
										
											if (empty($_POST['Item']['fields'][$field -> id])) {
												if (!empty($field -> required) && $field -> required == "Y") {
													$globalerrors[$field -> slug] = (empty($field -> error)) ? __('Please fill in', $this -> plugin_name) . ' ' . $field -> title : $field -> error;
												}
											} else {
												$wpcoDb -> model = $wpcoFieldsOrder -> model;
												$fieldorder_data = array('field_id' => $field -> id, 'order_id' => $order_id, 'value' => $_POST['Item']['fields'][$field -> id]);
												$wpcoDb -> save($fieldorder_data);
											}
										}
									}
									
									$errors = apply_filters($this -> pre . '_billing_validation', $errors, $_POST, $order_id);									
									$Order -> update_totals();
									
									if (empty($errors) && empty($globalerrors) && empty($_GET['updatebilling'])) {									
										$wpcoDb -> model = $Order -> model;
										$order_id = $Order -> current_order_id();
										$order = $wpcoDb -> find(array('id' => $order_id));									
										$user = $this -> userdata();
										
										$title = __('Processing Order', $this -> plugin_name);
										$this -> process_order($title, $order, $user, $_POST['pmethod']);
									}
								}
							}
						}
					
						global $wpcoerrors, $wpcoglobalerrors;
						$wpcoerrors = $errors;
						$wpcoglobalerrors = $globalerrors;
						break;
					case 'payment'							:
						$pmethod = (empty($_GET['pmethod'])) ? $_POST['pmethod'] : $_GET['pmethod'];
						do_action($this -> pre . '_payment', $pmethod);
					
						switch ($pmethod) {
							case 'lucy'						:
								global $errors, $wpcoDb, $wpcoHtml, $Order;
								
								$success = false;
								$errors = false;
								
								if (!empty($_POST)) {
									if (empty($_POST['lucy_nameoncard'])) { $errors[] = __('Please fill in a card holder name.', $this -> plugin_name); }
									if (empty($_POST['lucy_cardnum'])) { $errors[] = __('Please fill in a credit card number.', $this -> plugin_name); }
									if (empty($_POST['lucy_expm']) || empty($_POST['lucy_expy'])) { $errors[] = __('Please choose an expiry date.', $this -> plugin_name); }
									if (empty($_POST['lucy_cvnum'])) { $errors[] = __('Please fill in a security code.', $this -> plugin_name); }
									elseif (!is_numeric($_POST['lucy_cvnum'])) { $errors[] = __('Only numbers are allowed for the security code.', $this -> plugin_name); }
								} else {
									$errors[] = __('Please fill in your billing information.', $this -> plugin_name);
								}
								
								if (empty($errors)) {
									$lucy = maybe_unserialize($this -> get_option('lucy'));
									
									/* Get the current order details */
									$order_id = $Order -> current_order_id();
									$wpcoDb -> model = $Order -> model;
									$order = $wpcoDb -> find(array('id' => $order_id));									
									$ExpDate = $_POST['lucy_expm'] . substr($_POST['lucy_expy'], -2);
									$Amount = $wpcoHtml -> number_format_price($Order -> total($order_id, true, true, true, true, true));
									$Street = $order -> bill_address . ', ' . $order -> bill_address2;
									
									$lucyg = $this -> vendor('lucycardtxn', 'gateways' . DS . 'lucy' . DS);
									$lucyg -> base = ($lucy['server'] == "live") ? 
									"https://payments.cynergydata.com/SmartPayments/transact2.asmx/ProcessCreditCard" :
									"https://cpgtest.cynergydata.com/SmartPayments/transact2.asmx/ProcessCreditCard";
									$lucyg -> userid = $lucy['username'];
									$lucyg -> password = $lucy['password'];
									
									$lucy_xml_response = $lucyg -> CURLTxn(
										'Sale',							//TransType
										$_POST['lucy_cardnum'],			//CardNum
										$ExpDate,						//ExpDate
										false,							//MagData
										$_POST['lucy_nameoncard'],		//NameOnCard
										$Amount,						//Amount
										$order -> id,					//InvNum
										false,							//PNRef
										$order -> bill_zipcode,			//Zip
										$Street,						//Street
										$_POST['lucy_cvnum'],			//CVNum
										false							//ExtData
									);									
									
									$resultarray = $lucyg -> notify($lucy_xml_response);
									
									if (!empty($resultarray)) {
										if (empty($resultarray['Result']) && $resultarray['Result'] == "0") {											
											$success = true;
											$message = __('Transaction has been processed.', $this -> plugin_name);
											$user_id = $user -> ID;											
											$this -> finalize_order($order_id, 'lucy', false, "Y");
										} else {
											$success = false;
											$message = $resultarray['RespMSG'];
										}
									} else {
										$success = false;
										$message = __('There was a problem connecting to the payment gateway, please contact the administrator.', $this -> plugin_name);
									}
									
									$lucyg -> message = $message;
								} else {
									$title = __('Processing Order', $this -> plugin_name);
									$this -> process_order($title, $order, $user, "lucy", array('errors' => $errors));	
								}
								break;
							/* Realex realauth remote */
							case 're_remote'				:
								global $errors, $wpcoDb, $wpcoHtml, $Order;
							
								$success = false;
								$errors = false;
								$processagain = true;
								
								/* Get the current order details */
								$order_id = $Order -> current_order_id();
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));
								
								if (!empty($_POST['re_remote'])) {
									$re_remote = $_POST['re_remote'];
									
									if (empty($re_remote['card_chname'])) { $errors[] = __('Please fill in a card holder name.', $this -> plugin_name); }
									if (empty($re_remote['card_type'])) { $errors[] = __('Please choose a card type.', $this -> plugin_name); }
									if (empty($re_remote['card_number'])) { $errors[] = __('Please fill in a credit card number.', $this -> plugin_name); }
									if (empty($re_remote['card_expdate_m']) || empty($re_remote['card_expdate_y'])) { $errors[] = __('Please choose an expiry date.', $this -> plugin_name); }
									if (empty($re_remote['card_cvn_number'])) { $errors[] = __('Please fill in a security code.', $this -> plugin_name); }
									elseif (!is_numeric($re_remote['card_cvn_number'])) { $errors[] = __('Only numbers are allowed for the security code.', $this -> plugin_name); }
								} else {
									$errors[] = __('Please fill in your credit card details.', $this -> plugin_name);	
								}
								
								if (empty($errors)) {									
									$re_remote_settings = maybe_unserialize($this -> get_option('re_remote'));
									$re_remote['merchantid'] = $re_remote_settings['merchantid'];
									$re_remote['secret'] = $re_remote_settings['secret'];
									$re_remote['account'] = $re_remote_settings['account'];
									$re_remote['currency'] = $this -> get_option('currency');
									$re_remote['amount'] = preg_replace("/[^0-9]+/", "", $wpcoHtml -> number_format_price($Order -> total($order_id, true, true, true, true, true)));
									$re_remote['card_expdate'] = $re_remote['card_expdate_m'] . substr($re_remote['card_expdate_y'], -2);
									
									$tmp = $re_remote['timestamp'] . "."
									. $re_remote['merchantid'] . "." 
									. $order -> id . "." 
									. $re_remote['amount'] . "." 
									. $re_remote['currency'] . "." 
									. $re_remote['card_number'];
									
									$realex = $this -> vendor('re_remote', 'gateways' . DS . 'realex-remote' . DS);
									$xml_result = $realex -> request($re_remote, $order, $user);
									$resultarray = $realex -> notify($xml_result);
									
									if (!empty($resultarray)) {										
										if ($resultarray['result'] == "00") {										
											$success = true;
											$processagain = false;
											$message = __('Transaction has been processed.', $this -> plugin_name);
											$user_id = $user -> ID;
											
											$this -> finalize_order($order -> id, "re_remote", false, "Y");
											$this -> redirect($wpcoHtml -> retainquery("type=re_remote&order_id=" . $order_id, $wpcoHtml -> success_url()));
										} else {
											$success = false;
											$message = $resultarray['message'];
										}
									} else {
										$success = false;
										$message = __('There was a problem connecting to the payment gateway, please contact the administrator.', $this -> plugin_name);
									}
									
									$realex -> message = $message;
									$errors[] = $message;
									
									if ($processagain == true) {
										$this -> process_order(__('Processing Order', $this -> plugin_name), $order, $user, "re_remote", false);
									}
								} else {
									$title = __('Processing Order', $this -> plugin_name);
									$this -> process_order($title, $order, $user, "re_remote", false);	
								}
								break;
							case 'payxml'					:
								global $errors, $wpcoDb, $wpcoHtml, $Order;
							
								$success = false;
								$errors = false;
								
								/* Get the current order details */
								$order_id = $Order -> current_order_id();
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));
								
								if (!empty($_POST['payxml'])) {
									$payxml = $_POST['payxml'];
									
									if (empty($payxml['cname'])) { $errors[] = __('Please fill in a card holder name.', $this -> plugin_name); }
									if (empty($payxml['cc'])) { $errors[] = __('Please fill in a credit card number.', $this -> plugin_name); }
									if (empty($payxml['exp_m']) || empty($payxml['exp_y'])) { $errors[] = __('Please choose an expiry date.', $this -> plugin_name); }
									if (empty($payxml['cvv'])) { $errors[] = __('Please fill in a security code.', $this -> plugin_name); }
									elseif (!is_numeric($payxml['cvv'])) { $errors[] = __('Only numbers are allowed for the security code.', $this -> plugin_name); }
								} else {
									$errors[] = __('Please fill in your credit card details.', $this -> plugin_name);	
								}
								
								if (empty($errors)) {
									$pg_settings = maybe_unserialize($this -> get_option('payxml'));									
									$payxml['ver'] = $pg_settings['ver'];
									$payxml['threed'] = (($pg_settings['threed'] == "Y") ? true : false);
									$payxml['pgid'] = $pg_settings['pgid'];
									$payxml['pwd'] = $pg_settings['pwd'];
									$payxml['exp'] = $payxml['exp_m'] . $payxml['exp_y'];
									$payxml['amt'] = preg_replace("/[^0-9]+/", "", $wpcoHtml -> number_format_price($Order -> total($order_id, true, true, true, true, true)));									
									$payxml['cur'] = $this -> get_option('currency');							
									
									/* Initialize the PayGate XML request */
									$pg = $this -> vendor('payxml', 'gateways' . DS);
									$pg -> request($payxml, $order, $user);
									
									$content = "";
									
									if ($pg -> dataSecure && !empty($pg -> requireRedirect) && $pg -> requireRedirect == true) {
										$content .= $this -> render('checkout' . DS . 'paygate_xml_redirect', array('payxml' => $payxml, 'secure' => $pg -> dataSecure), false, 'default');	
										
										global $wpcothemedoutput;
										$wpcothemedoutput = $content;
									} else {
										if ($pg -> dataError) {
											$errors[] = $pg -> dataError['EDESC'];
											$this -> process_order(__('Processing Order', $this -> plugin_name), $order, $user, "payxml", false);	
										} elseif ($pg -> dataAuth) {
											$processagain = true;
											
											if (!empty($pg -> dataAuth)) {
												if (!empty($pg -> dataAuth['STAT']) && $pg -> dataAuth['STAT'] == 1) {
													$this -> finalize_order($order_id, "payxml", false);
													$this -> redirect($wpcoHtml -> retainquery("type=payxml&order_id=" . $order_id, $wpcoHtml -> success_url()));
													$processagain = false;
												} else {
													$errors[] = $pg -> dataAuth['RDESC'];	
												}
											}
											
											if ($processagain == true) {
												$this -> process_order(__('Processing Order', $this -> plugin_name), $order, $user, "payxml", false);
											}
										}
									}
								} else {
									$title = __('Processing Order', $this -> plugin_name);
									$this -> process_order($title, $order, $user, "payxml", false);	
								}
								break;
							case 'pp_pro'		:
								global $errors, $wpcoDb, $Product, $Order, $Item, $Country, $wpcoHtml, $Discount;
								require_once(dirname(__FILE__) . DS . 'includes' . DS . 'constants.php');

								$order_id = $Order -> current_order_id();
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));
								$wpcoDb -> model = $Item -> model;
								$items = $wpcoDb -> find_all(array('order_id' => $order_id));
								$pmethod = "pp_pro";
								
								$success = false;
								$errors = null;
								if (empty($_POST['creditCardNumber'])) { $errors['creditCardNumber'] = __('Please fill in a credit card number.', $this -> plugin_name); }
								elseif (!is_numeric($_POST['creditCardNumber'])) { $errors['creditCardNumber'] = __('Only numbers are allowed in the credit card number.', $this -> plugin_name); }
								if (empty($_POST['expDateMonth']) || empty($_POST['expDateYear'])) { $errors['expDate'] = __('Please choose an expiry date.', $this -> plugin_name); }
								if (empty($_POST['cvv2Number'])) { $errors['cvv2Number'] = __('Please fill in a security code.', $this -> plugin_name); }
								elseif (!is_numeric($_POST['cvv2Number'])) { $errors['cvv2Number'] = __('Only numbers are allowed for the security code.', $this -> plugin_name); }

								if (empty($errors)) {									
									require_once $this -> plugin_base() . DS . 'vendors' . DS . 'gateways' . DS . 'class.pp_pro.php';
									
									$api_username = $this -> get_option('pp_pro_api_username');
									$api_password = $this -> get_option('pp_pro_api_password');
									$api_signature = $this -> get_option('pp_pro_api_signature');
									$api_endpoint = $this -> get_option('pp_pro_api_endpoint');
									$paymenttype = $this -> get_option('pp_pro_paymenttype');
									
									$email = urlencode($order -> bill_email);
									$firstName = urlencode($order -> bill_fname);
									$lastName = urlencode($order -> bill_lname);
									$creditCardType = urlencode($_POST['creditCardType']);
									$creditCardNumber = urlencode($_POST['creditCardNumber']);
									$expDateMonth = urlencode($_POST['expDateMonth']);
									$expDateYear = urlencode($_POST['expDateYear']);
									$cvv2Number = urlencode($_POST['cvv2Number']);
									$address1 = urlencode($order -> bill_address);
									$address2 = urlencode($order -> bill_address2);
									$city = urlencode($order -> bill_city);
									$state = urlencode($order -> bill_state);
									$zip = urlencode($order -> bill_zipcode);
									$amount = urlencode($order -> total);
									$currencyCode = urlencode($this -> get_option('currency'));
									$shiptophonenum = urlencode($order -> ship_phone);
									$SHIPTONAME = urlencode($order -> ship_fname . ' ' . $order -> ship_lname);
									$SHIPTOSTREET = urlencode($order -> ship_address);
									$SHIPTOSTREET2 = urlencode($order -> ship_address2);
									$shiptocity = urlencode($order -> ship_city);
									$shiptostate = urlencode($order -> ship_state);
									$shiptozip = urlencode($order -> ship_zipcode);
									$wpcoDb -> model = $Country -> model;
									$shiptocountry = $wpcoDb -> field('code', array('id' => $order -> ship_country));
									//$paymentAction = urlencode("Sale");
									//$paymentAction = "Authorization";
									$paymentAction = (empty($paymenttype) || $paymenttype == "sale") ? "Sale" : "Authorization";
									$IPADDRESS = urlencode($_SERVER['REMOTE_ADDR']);
									$nvpRecurring = '';
									$methodToCall = 'DoDirectPayment';	
									
									$wpcoDb -> model = $Country -> model;
									$countrycode = $wpcoDb -> field('code', array('id' => $order -> bill_country));	
									
									if ($countrycode == "UK") { $countrycode = "GB"; }
									if ($shiptocountry == "UK") { $shiptocountry = "GB"; }					
									
									$nvpstr =
									'&PAYMENTACTION=' . $paymentAction . 
									'&CUSTOM=' . $shipmethod_name . 
									'&IPADDRESS=' . $IPADDRESS . 
									'&AMT=' . $amount . 
									'&CREDITCARDTYPE=' . $creditCardType . 
									'&ACCT=' . $creditCardNumber . 
									'&EXPDATE=' . $expDateMonth . $expDateYear . 
									'&CVV2=' . $cvv2Number . 
									'&EMAIL=' . $email . 
									'&FIRSTNAME=' . $firstName . 
									'&LASTNAME=' . $lastName . 
									'&STREET=' . $address1 . 
									'&STREET2=' . $address2 .									
									'&CITY=' . $city . 
									'&STATE=' . $state . 
									'&ZIP=' . $zip . 
									'&COUNTRYCODE=' . $countrycode . 
									'&CURRENCYCODE=' . $currencyCode . 
									'&SHIPTOPHONENUM=' . $shiptophonenum .
									'&SHIPTONAME=' . $SHIPTONAME .
									'&SHIPTOSTREET=' . $SHIPTOSTREET .
									'&SHIPTOSTREET2=' . $SHIPTOSTREET2 .
									'&SHIPTOCITY=' . $shiptocity .
									'&SHIPTOSTATE=' . $shiptostate .
									'&SHIPTOZIP=' . $shiptozip .
									'&SHIPTOCOUNTRY=' . $shiptocountry;
									
									if ($Order -> do_shipping($order_id)) {
										$shipmethod_name = $wpcoHtml -> shipmethod_name($order -> shipmethod_id);
										$nvpstr .= '&CUSTOM=' . urlencode($shipmethod_name);
										
										if (!empty($order -> cu_shipmethod)) {
											$nvpstr .= urlencode(' - ' . html_entity_decode($order -> cu_shipmethod));
										}
									}
									
									$subtotal = $Order -> total($order_id, false, false, true, true, false);
									$shipping = $Order -> shipping_total($subtotal, $order_id);
									$tax = $Order -> tax_total($order_id);
									
									$discount = $Discount -> total($order_id);
									if ($this -> get_option('enablecoupons') == "Y" && $discount > 0) {
										
									} else {
										$n = 0;
										$itemamt = 0;
	
										if (!empty($items)) {									
											foreach ($items as $item) {
												$itemamount = ($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true, false, false));
												$nvpstr .= '&L_NAME' . $n . '=' . urlencode(apply_filters($this -> pre . '_product_title', $item -> product -> title));
												$nvpstr .= '&L_DESC' . $n . '=' . urlencode(substr(strip_tags($item -> product -> description), 0, 125));
												$nvpstr .= '&L_AMT' . $n . '=' . urlencode(number_format($itemamount, 2, '.', ''));
												$nvpstr .= '&L_NUMBER' . $n . '=' . urlencode($item -> product -> code);
												$nvpstr .= '&L_QTY' . $n . '=' . urlencode($item -> count);
												
												$n++;
												$itemamt += ($itemamount * $item -> count);
												$itemamount = 0;
											}
											
											$nvpstr .= '&ITEMAMT=' . urlencode(number_format($itemamt, 2, '.', ''));
											$nvpstr .= '&SHIPPINGAMT=' . urlencode(number_format($shipping, 2, '.', ''));
											$nvpstr .= '&TAXAMT=' . urlencode(number_format($tax, 2, '.', ''));
										}
									}
									
									$nvpstr .= $nvpRecurring;
									
									$paypalPro = new wpcopp_pro($api_username, $api_password, $api_signature, '', '', false, false, '57.0', $api_endpoint);
									$resArray = $paypalPro -> hash_call($methodToCall, $nvpstr);
									$ack = strtoupper($resArray["ACK"]);

									$ack = strtoupper($resArray["ACK"]);
									if($ack != "SUCCESS")  {
										$success = false;
										$message = __('The transaction has been declined. Please try again.', $this -> plugin_name);											
										
										global $errors;
										$errors[] = $resArray['L_ERRORCODE0'] . ' (' . $resArray['L_SHORTMESSAGE0'] . '): ' . $resArray['L_LONGMESSAGE0'];
										$this -> process_order($title, $order, $user, $pmethod);
									} else {																		   
										$success = true;
										$message = __('The transaction was successful.', $this -> plugin_name);
										$user_id = $user -> ID;		
										$wpcoDb -> model = $Order -> model;
										$wpcoDb -> save_field('transid', $resArray['TRANSACTIONID'], array('id' => $order_id));
										$wpcoDb -> model = $Order -> model;
										$transstatus = (empty($paymenttype) || $paymenttype == "sale") ? "captured" : "authorized";
										$wpcoDb -> save_field('transstatus', $transstatus, array('id' => $order_id));
										$this -> finalize_order($order_id, 'pp_pro', false, "N");									
									}
									
									$paypalPro -> message = $message;
								} else {
									$title = __('Processing Order', $this -> plugin_name);
									$this -> process_order($title, $order, $user, $pmethod);	
								}
								break;
							case 'fdapi'					:
								global $errors, $wpcoDb, $Order;
								
								$order_id = $Order -> current_order_id();
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));								
								$success = false;
								$processagain = true;
								$errors = null;
								
								if (!$this -> is_plugin_active('fdapi')) { $errors['extension'] = __('You do not have the First Data API extension plugin active.', $this -> plugin_name); }
								if (empty($_POST['CardNumber'])) { $errors['CardNumber'] = __('Please fill in a credit card number.', $this -> plugin_name); }
								elseif (!is_numeric($_POST['CardNumber'])) { $errors['CardNumber'] = __('Only numbers are allowed in the credit card number.', $this -> plugin_name); }
								if (empty($_POST['ExpMonth']) || empty($_POST['ExpYear'])) { $errors['Exp'] = __('Please choose an expiry date.', $this -> plugin_name); }
								if ($this -> get_option('fdapi_cvv') == "Y" && empty($_POST['Cvv'])) { $errors['Cvv'] = __('Please fill in your card verification value.', $this -> plugin_name); }
								
								if (empty($errors)) {
									if ($fdapi = $this -> extension_vendor('fdapi')) {
										$fdapi -> fdapi_StoreID = $this -> get_option('fdapi_storeid');
										$fdapi -> fdapi_ChargeTotal = number_format($Order -> total($order_id, $shipping = true, $applydiscount = true, $styles = true, $fields = true), 2, '.', '');
										$fdapi -> fdapi_CardNumber = $_POST['CardNumber'];
										$fdapi -> fdapi_ExpMonth = $_POST['ExpMonth'];
										$fdapi -> fdapi_ExpYear = $_POST['ExpYear'];
										$fdapi -> fdapi_Cvv = $_POST['Cvv'];
										$fdapiresult = $fdapi -> process($order, $user);
										
										if (!empty($fdapiresult)) {
											if ($fdapiresult['r_approved'] == "APPROVED") {
												$success = true;
												$processagain = false;
												$message = __('Transaction has been processed.', $this -> plugin_name);
												$user_id = $user -> ID;
												
												$this -> finalize_order($order -> id, "fdapi", false, "Y");
												$this -> redirect($wpcoHtml -> retainquery("type=fdapi&order_id=" . $order_id, $wpcoHtml -> success_url()));
											} else {
												$success = false;
												$message = $fdapiresult['r_error'];
											}
										} else {
											$success = false;
											$message = __('No response was received from the gateway server.', $this -> plugin_name);
										}
									}
									
									if ($success == false && !empty($message)) {
										global $errors;
										$errors = array($message);
									}
									
									if (!empty($processagain) && $processagain == true) {
										$title = __('Processing Order', $this -> plugin_name);
										$this -> process_order($title, $order, $user, 'fdapi', false);
									}
								} else {
									$title = __('Processing Order', $this -> plugin_name);
									$this -> process_order($title, $order, $user, 'fdapi', false);
								}
							
								break;
							case 'amazonfps'				:
								global $wpdb, $wpcoDb, $Order;
								$success = false;
							
								if ($this -> is_plugin_active('amazonfps')) {
									if ($amazonfps = $this -> extension_vendor('amazonfps')) {
										if ($amazonfps -> validate_return($_GET)) {
											if ($amazonfps -> pay_request($_GET)) {
												$order_id = $Order -> current_order_id();
												$orderquery = "SELECT * FROM `" . $wpdb -> prefix . $Order -> table . "` WHERE `id` = '" . $order_id . "'";
												$order = $wpdb -> get_row($orderquery);
												$user_id = $user -> ID;
												$success = true;
												$processagain = false;
												$message = __('Transaction has been processed.', $this -> plugin_name);
												
												$this -> finalize_order($order -> id, "amazonfps", false, "Y");
												$this -> redirect($wpcoHtml -> retainquery("type=amazonfps&order_id=" . $order_id, $wpcoHtml -> success_url()));
												
											} else {
												$success = false;
												$message = __('Transaction failed, please try again.', $this -> plugin_name);
											}
										}
									}
								}
								break;
							case 'authorize_aim'			:							
								global $errors, $success, $wpcoDb, $Order;
							
								$order_id = $Order -> current_order_id();
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));								
								$success = false;
								$errors = null;
								
								$ccdetails = array('type' => false, 'number' => $_POST['cc_number'], 'expm' => $_POST['cc_exp_m'], 'expy' => $_POST['cc_exp_y'], 'cvv' => $_POST['cc_cvv']);
								do_action($this -> pre . '_ccdetails', $ccdetails, $user, $order);
								
								if ($success == false) {
									if (empty($_POST['cc_number'])) { $errors['cc_number'] = __('Please fill in a credit card number.', $this -> plugin_name); }
									elseif (!is_numeric($_POST['cc_number'])) { $errors['cc_number'] = __('Only numbers are allowed in the credit card number.', $this -> plugin_name); }
									if (empty($_POST['cc_exp_m']) || empty($_POST['cc_exp_y'])) { $errors['cc_exp'] = __('Please choose an expiry date.', $this -> plugin_name); }
									if (empty($_POST['cc_cvv'])) { $errors['cc_cvv'] = __('Please fill in a security code.', $this -> plugin_name); }
									elseif (!is_numeric($_POST['cc_cvv'])) { $errors['cc_cvv'] = __('Only numbers are allowed for the security code.', $this -> plugin_name); }
									
									if (empty($errors)) {								
										$order -> cc_number = $_POST['cc_number'];
										$order -> cc_exp_m = $_POST['cc_exp_m'];
										$order -> cc_exp_y = $_POST['cc_exp_y'];
										$order -> cc_cvv = $_POST['cc_cvv'];
									
										$authorize_aim = $this -> vendor('authorize_aim', "gateways" . DS);
										$authorize_aim -> build($order);
										$response = $authorize_aim -> send();
										
										if (!empty($response)) {
											switch ($response -> code) {
												case 1		:
													$success = true;
													$user_id = $user -> ID;
													
													$this -> finalize_order($order_id, 'authorize_aim', false, "Y");
													break;
												case 2		:
													$success = false;
													$message = __('The transaction has been declined. Please try again.', $this -> plugin_name);
													break;
												case 3		:
													$success = false;
													$message = $response -> reasontext;
													break;
												case 4		:
													$success = false;
													$message = __('Transaction is being held for review.', $this -> plugin_name);
													break;
											}
										} else {
											$success = false;
											$message = __('No response was received from the payment gateway. Please try again.', $this -> plugin_name);
										}
										
										if ($success == false) {
											global $errors;
											$errors[] = $message;
											$this -> process_order($title, $order, $user, 'authorize_aim', false);
										}
									} else {	
										$title = __('Processing Order', $this -> plugin_name);
										$this -> process_order($title, $order, $user, $pmethod);
									}
								}
								break;
						}
						break;
					case 'cosuccess'						:
						do_action($this -> pre . '_cosuccess');
																											
						$title = __('Order Finished', $this -> plugin_name);							
						$content = "";
						ob_start();
						
						?>
						
						<h2><?php _e('Order Finished', $this -> plugin_name); ?></h2>
						
						<?php
						
						$content = ob_get_clean();
						
						switch ($_GET['type']) {
							case 'pp'							:
								$order_id = $_GET['order_id'];
								if (!empty($_POST['payment_status']) && $_POST['payment_status'] == "Completed") {								
									$this -> finalize_order($order_id, "pp", false, "Y");
								} else {
									$this -> finalize_order($order_id, "pp", false, "N");
								}
								break;
							case 'monsterpay'					:
								$tnxid = $_GET['tnxid'];
								$checksum = $_GET['checksum'];
								$parity = $_GET['parity'];
								
								$identifier = $this -> get_option('monsterpay_MerchantIdentifier');
								$usrname = $this -> get_option('monsterpay_Usrname');
								$pwd = $this -> get_option('monsterpay_Pwd');
								
								if (!empty($tnxid) && !empty($checksum) && !empty($parity)) {
									if ($monsterpay = $this -> vendor('monsterpay', 'gateways' . DS)) {
										$monsterpay -> tnxid = $tnxid;
										$monsterpay -> checksum = $checksum;
										$monsterpay -> parity = $parity;
										$monsterpay -> identifier = $identifier;
										$monsterpay -> usrname = $usrname;
										$monsterpay -> pwd = $pwd;
										
										if ($synchro = $monsterpay -> request()) {
											$tnx_status = $synchro -> outcome -> status;
											$error_code = $synchro -> outcome -> error_code;
											$error_desc = $synchro -> outcome -> error_desc;
											$error_solution = $synchro -> outcome -> error_solution;
											$seller_reference = $synchro -> seller -> reference;
											
											$_GET['order_id'] = $seller_reference;
										}
									}
								}
								break;
							default								:
							
								break;
						}
						
						if (!empty($_GET['order_id'])) {
							global $wpdb, $wpcoDb, $Order, $Item, $user_ID, $wpcoTax, $Country;
							$order_id = $_GET['order_id'];
							
							$wpcoDb -> model = $Order -> model;
							if ($order = $wpcoDb -> find(array('id' => $_GET['order_id']))) {
								$wpcoDb -> model = $Order -> model;
								$wpcoDb -> save_field('completed', "Y", array('id' => $order -> id));
								
								if (!empty($_GET['type'])) {
									$wpcoDb -> model = $Order -> model;
									$wpcoDb -> save_field('pmethod', $_GET['type'], array('id' => $order -> id));
								}
								
								$wpcoDb -> model = $Item -> model;
								if ($items = $wpcoDb -> find_all(array('order_id' => $order -> id))) {
									foreach ($items as $item) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('completed', "Y", array('id' => $item -> id));
									}
								}
							}
						}
						
						$userdata = $this -> userdata();
						$content .= $this -> render('success', array('order' => $order, 'items' => $items, 'user' => $userdata), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					case 'cofailed'							:
						do_action($this -> pre . '_cofailed');
					
						$title = __('Order Failed', $this -> plugin_name);						
						ob_start();						
						$this -> render('steps', array('step' => 'finished'), true, 'default');
						
						?>
						
						<h2><?php _e('Order Failed', $this -> plugin_name); ?></h2>
						
						<?php
						
						$content = ob_get_clean();
						$content .= $this -> render('failed', false, false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					case 'realexreturn'						:
						global $wpcoHml, $Javascript;
						$success = false;
						$errors = array();
								
						$timestamp = $_POST['TIMESTAMP'];
						$result = $_POST['RESULT'];
						$orderid = $_POST['ORDER_ID'];
						$message = $_POST['MESSAGE'];
						$authcode = $_POST['AUTHCODE'];
						$pasref = $_POST['PASREF'];
						$realexmd5 = $_POST['MD5HASH'];
						$merchantid = $this -> get_option('re_merchantid');
						$secret = $this -> get_option('re_secret');								
						$tmp = "$timestamp.$merchantid.$orderid.$result.$message.$pasref.$authcode";
						$md5hash = md5($tmp);
						$tmp = "$md5hash.$secret";
						$md5hash = md5($tmp);
						
						if ($md5hash != $realexmd5) {						
							$message = __('Hashes do not match - response not authenticated!', $this -> plugin_name);
						}
						
						if ($result == "00") {												
							$order_id = $_POST[$this -> pre . 'order_id'];
							$user_id = $_POST[$this -> pre . 'user_id'];
							$order -> pmethod = $pmethod = "re";
							$success = true;
							$this -> finalize_order($order_id, 're', false, "Y");
							$this -> redirect('type=re&order_id=' . $order_id, $wpcoHtml -> success_url());
						} else {						
							?>
							
							<script type="text/javascript">
							alert('<?php echo $_POST['MESSAGE']; ?>');
							</script>
							
							<?php
							
							$this -> redirect($wpcoHtml -> bill_url());	
						}
						
						exit();
						break;
					case 'coreturn'							:
						//global variables
						global $Country, $user_ID, $Javascript;
					
						$order = null;
						$success = false;
						$buynow = false;
						
						$type = (empty($_GET['type'])) ? null : $_GET['type'];
						$type = (empty($_POST['type'])) ? $type : $_POST['type'];
											
						switch ($type) {
							case 'ipay'				:
								if ($this -> is_plugin_active('ipay')) {
									$ipay = $this -> extension_vendor('ipay');
									
									if ($ipay -> response()) {
										$success = true;
										$order_id = $_POST['RefNo'];
										$order -> pmethod = $pmethod = "ipay";
									} else {
										$success = false;
										$message = $ipay -> ErrDesc;
									}
								}
								break;
							case 'apco'				:
								if ($this -> is_plugin_active('apco')) {
									$apco = $this -> extension_vendor('apco');
									$apco -> response();
								}
								break;
							case 'payxml'			:
								$success = false;
								$order -> pmethod = $pmethod = "payxml";
							
								if ($rawXML = file_get_contents("php://input")) {									
									if ($pg = $this -> vendor('payxml', 'gateways' . DS)) {										
										if ($pg -> notify($rawXML)) {											
											if (!empty($pg -> dataAuth['STAT']) && $pg -> dataAuth['STAT'] == 1) {												
												$success = true;
												$order_id = $pg -> dataAuth['CREF'];
												global $wpcothemedoutput;
												$content = $this -> finalize_order($order_id, "payxml", false);
												$wpcothemedoutput = $content;
											} else {
												$message = $this -> dataAuth['RDESC'];
											}
										} else {
											$message = $this -> dataError['EDESC'];
										}
									} else {
										$message = __('Gateway class could not be initialized, please contact the administrator.', $this -> plugin_name);	
									}
								} else {
									$message = __('No response notification was received from the gateway.', $this -> plugin_name);
								}
								
								exit();
								break;
							/* PayPal (Website Payments Standard) */
							case 'pp'				:																									
								$req = 'cmd=_notify-validate';
								$_POST = $_REQUEST;
								
								foreach ($_POST as $pkey => $pval) {
									$pval = urlencode(stripslashes($pval));
									$req .= "&" . $pkey . "=" . $pval . "";
								}
								
								$header = "";
								$header .= "POST /cgi-bin/webscr HTTP/1.1" . "\r\n";
								$header .= "Content-Type: application/x-www-form-urlencoded" . "\r\n";
								$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
								$ppurl = ($this -> get_option('pp_sandbox') == "Y") ? 'www.sandbox.paypal.com' : 'www.paypal.com';
								$fp = fsockopen($ppurl, 80, $errno, $errstr, 30);
								
								$item_name = $_POST['item_name'];
								$item_number = $_POST['item_number'];
								$payment_status = $_POST['payment_status'];
								$payment_amount = $_POST['mc_gross'];
								$payment_currency = $_POST['mc_currency'];
								$txn_id = $_POST['txn_id'];
								$receiver_email = $_POST['receiver_email'];
								$payer_email = $_POST['payer_email'];
								$custom = unserialize(urldecode($_POST['custom']));
								$order_id = $custom['order_id'];
								$user_id = $custom['user_id'];
								
								echo " ";
								
								if (!$fp) {
									$message = __('An HTTP error has occurred', $this -> plugin_name);
								} else {
									fputs($fp, $header . $req);
								
									while (!feof($fp)) {
										$res = null;
										$res = trim(fgets($fp, 1024));
								
										if (strcmp($res, "VERIFIED") == 0) {										
											if ($payment_status == "Completed" || (!empty($_POST['test_ipn']) && $payment_status == "Pending")) {
												//if (strtolower($receiver_email) == strtolower($this -> get_option('pp_email'))) {
													$wpcoDb -> model = $Order -> model;
												
													if ($order = $wpcoDb -> find(array('id' => $order_id))) {
														//if ($this -> get_option('pp_surcharge') == "Y" || $payment_amount == number_format($Order -> total($order_id, true, true), 2, '.', '')) {
															$order -> pmethod = $pmethod = "pp";
															$success = true;
															
															if (!empty($custom['buynow']) && $custom['buynow'] == "Y" && $this -> get_option('buynow') == "Y") {
																$buynow = true;
															}
														//} else {
														//	$message = __('Payment amount does not match', $this -> plugin_name);
														//}
													} else {
														$message = __('Order cannot be read', $this -> plugin_name);
													}
												//} else {
												//	$message = __('PayPal receiver email does not match', $this -> plugin_name);
												//}
											} elseif ($payment_status == "Denied") {
												$message = __('Payment was denied', $this -> plugin_name);
											} elseif ($payment_status == "Failed") {
												$message = __('Payment has failed', $this -> plugin_name);
											} elseif ($payment_status == "Pending") {
												$message = __('Payment is pending', $this -> plugin_name);
											} else {
												$message = __('Payment has not been completed. Status is', $this -> plugin_name) . ' : ' . $payment_status;
											}
											
											break;
										} elseif (strcmp($res, "INVALID") == 0) {
											$message = __('PayPal has marked this transaction as INVALID', $this -> plugin_name);
											
											break;
										}
									}
									
									fclose($fp);
								}
								break;
							case 'bartercard'		:
								$success = false;
							
								if (!empty($_GET)) {
									if (!empty($_GET['Result'])) {
										if ($_GET['Result'] == "Processed") {
											$order -> pmethod = $pmethod = "bartercard";
											$order_id = $_GET['Reference'];
											$wpcoDb -> model = $Order -> model;
											$order = $wpcoDb -> find(array('id' => $order_id));
											$user_id = $order -> user_id;
											$success = true;
										} else {
											$message = __('Transaction has been declined, please try again.', $this -> plugin_name);
										}
									} else {
										$message = __('No transaction result was sent back, please try again.', $this -> plugin_name); 
									}
								} else {
									$message = __('No data was sent back from Bartercard, please try again.', $this -> plugin_name);
								}
								
								//continue
								break;
							/* BluePay 2.0 Redirect */
							case 'bluepay'			:
								global $wpdb, $wpcoDb, $Order, $Item, $wpcoFieldsOrder, $wpcoAuth;
								$success = false;
								$errors = array();
														
								if ($this -> is_plugin_active('bluepay')) {
									if ($bluepay = $this -> extension_vendor('bluepay')) {
										if (!empty($_REQUEST['Result'])) {
											switch ($_REQUEST['Result']) {
												case 'ERROR'					:
												case 'DECLINED'					:
												case 'MISSING'					:
													$success = false;
													$message = $_REQUEST['MESSAGE'];
													break;
												case 'APPROVED'					:
													$order_id = $_REQUEST['ORDER_ID'];
													$orderquery = "SELECT * FROM `" . $wpdb -> prefix . $Order -> table . "` WHERE `id` = '" . $order_id . "'";
												
													if ($order = $wpdb -> get_row($orderquery)) {
														$success = true;
														$order -> pmethod = $pmethod = "bluepay";
														$user_id = $order -> user_id;
													} else {
														$message = __('Order could not be found.', $this -> plugin_name);
													}
													break;
											}
										} else {
											$message = __('No result was returned, please try again.', $this -> plugin_name);
										}
									} else {
										$message = __('Extension vendor could not be loaded, please contact the site administrator.', $this -> plugin_name);
									}
								} else {
									$message = __('Extension is not active, please contact the site administrator.', $this -> plugin_name);
								}
								break;
							//eWay (Shared)
							case 'eway_shared'		:
								$success = false;
								
								if ($eway = $this -> vendor('eway_shared', 'gateways' . DS)) {
									$eway -> CustomerID = $this -> get_option('eway_shared_customerid');
									$eway -> UserName = $this -> get_option('eway_shared_username');
									$eway -> AccessPaymentCode = $_REQUEST['AccessPaymentCode'];
									$result = $eway -> get_result();
									
									if ($result['responsecode'] == "00" || $result['responsecode'] == "08" || $result['responsecode'] == "10" || $result['responsecode'] == "11" || $result['responsecode'] == "16") {
										$order -> pmethod = $pmethod = "eway_shared";
										$order_id = $_REQUEST['order_id'];
										$wpcoDb -> model = $Order -> model;
										$order = $wpcoDb -> find(array('id' => $_REQUEST['orderID']));
										$user_id = $order -> user_id;
										$success = true;
									} else {
										$message = __('The transaction has been declined. Please try again.', $this -> plugin_name);
										$message .= $eway -> responsecode($result['responsecode']);
										$success = false;
									}
								}							
								break;
							//Skrill (MoneyBookers)
							case 'mb'				:																																			
								if (!empty($_POST)) {																				
									if ($_POST['status'] == 2) {										
										$merchant_id = $_POST['merchant_id'];
										$transaction_id = $_POST['transaction_id'];
										$secret = strtoupper(md5($this -> get_option('mb_secret')));
										$mb_amount = $_POST['mb_amount'];
										$mb_currency = $_POST['mb_currency'];
										$status = $_POST['status'];
										
										$mystring = $merchant_id . $transaction_id . $secret . $mb_amount . $mb_currency . $status;
										$my_md5 = strtoupper(md5($mystring));
										
										if ($my_md5 == $_POST['md5sig']) {											
											$order_id = $_REQUEST['order_id'];
											$user_id = $_POST['user_id'];
											$order -> pmethod = $pmethod = "mb";
											$wpcoDb -> model = $Order -> model;
											$order = $wpcoDb -> find(array('id' => $_REQUEST['order_id']));
											$success = true;
										} else {
											$message = __('Hash encryption has failed', $this -> plugin_name);
										}
									} else {
										$message = __('The payment could not be completed', $this -> plugin_name);
									}
								} else {
									if (!empty($_GET['order_id'])) {
										$wpcoDb -> model = $Order -> model;
										
										if ($order = $wpcoDb -> find(array('id' => $_GET['order_id']))) {								
											$wpcoDb -> model = $Item -> model;
										
											if ($items = $wpcoDb -> find_all(array('order_id' => $order -> id))) {
												$success = true;
											}
										}
									}
								}											
								break;
							//2CheckOut
							case 'tc'				:																		
								if (!empty($_POST)) {
									if ($_POST['credit_card_processed'] == "Y") {
										$vendor = $this -> get_option('tc_vendorid');
										$secret = $this -> get_option('tc_secret');
										
										if ($_POST['demo'] == "Y") {
											$order_number = 1;
										} else {
											$order_number = $_POST['order_number'];
										}
										
										$total = $_POST['total'];
										$mykey = $secret . $vendor . $order_number . $total;
										$mykey = strtoupper(md5($mykey));
										
										if ($mykey == $_POST['key']) {
											$order_id = $_POST[$this -> pre . 'order_id'];
											$user_id = $_POST[$this -> pre . 'user_id'];
											$order -> pmethod = $pmethod = "tc";
											$success = true;
										} else {
											$message = __('Hash encryption failed', $this -> plugin_name);
										}
									} else {
										$message = __('Your payment could not be processed', $this -> plugin_name);
									}
								} else {
									$message = __('No data was posted', $this -> plugin_name);
								}
								break;
							case 'fd'				:
								$success = false;
							
								if (!empty($_POST)) {
									$status = strtolower($_POST['status']);
									
									switch ($status) {
										case 'approved'		:
											$order -> pmethod = $pmethod = "fd";
											$order_id = $_REQUEST['oid'];
											$success = true;
											break;
										case 'declined'		:
											$message = __('The transaction has been declined. Please try again.', $this -> plugin_name);
											$success = false;
											break;
										case 'duplicate'	:
											$message = __('This is a duplicate order. Please clear your cart and try again.', $this -> plugin_name);
											$success = false;
											break;
										case 'fraud'		:
											$message = __('We are sorry but this appears to be a fraudulent transaction', $this -> plugin_name);
											$success = false;
											break;
									}
								}
								break;
							case 're'				:
								$success = false;
								
								$timestamp = $_POST['TIMESTAMP'];
								$result = $_POST['RESULT'];
								$orderid = $_POST['ORDER_ID'];
								$message = $_POST['MESSAGE'];
								$authcode = $_POST['AUTHCODE'];
								$pasref = $_POST['PASREF'];
								$realexmd5 = $_POST['MD5HASH'];
								$merchantid = $this -> get_option('re_merchantid');
								$secret = $this -> get_option('re_secret');								
								$tmp = "$timestamp.$merchantid.$orderid.$result.$message.$pasref.$authcode";
								$md5hash = md5($tmp);
								$tmp = "$md5hash.$secret";
								$md5hash = md5($tmp);
								
								if ($md5hash != $realexmd5) {
									$message = __('hashes do not match - response not authenticated!', $this -> plugin_name);
								}
								
								if ($result == "00") {
									$order_id = $_POST[$this -> pre . 'order_id'];
									$user_id = $_POST[$this -> pre . 'user_id'];
									$order -> pmethod = $pmethod = "re";
									$success = true;
								} else {
									$message = __('There was an error processing your payment. Please try again.', $this -> plugin_name);
								}
								break;
							case 'ematters'			:
								global $wpcoDb, $Order;
								$success = false;
							
								$r = $_GET['rcode'];
								$merchant_id = $this -> get_option('ematters_merchantid');
								$uid = $_GET['uid'];
								$cctype = $_GET['cctype'];
								$total_price = $Order -> total($uid, true, true, true, true);							
								$response_code = $r - ($merchant_id * $uid) - ($total_price * 100);
								
								if ($response_code == 8) {
									$success = true;
								} else {
									$success = false;
									
									//load the eMatters class
									$eMatters = $this -> vendor('ematters', "gateways" . DS);
									$message = $eMatters -> responsetext($response_code);
								}
								
								//the ID of the order
								$order_id = $uid;
								
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));
								$order -> pmethod = $pmethod = "ematters";
								$user_id = $order -> user_id;
								break;
							case 'eupayment'		:
								//global variables
								global $wpcoHtml, $Order;
								
								$key = $this -> get_option('eupayment_key');
								$data_all =  array (
									'amount'     => addslashes(trim(@$_POST['amount'])),  //original amount
									'curr'       => addslashes(trim(@$_POST['curr'])),    //original currency
									'invoice_id' => addslashes(trim(@$_POST['invoice_id'])),//original invoice id
									'ep_id'      => addslashes(trim(@$_POST['ep_id'])), //Euplatesc.ro unique id
									'merch_id'   => addslashes(trim(@$_POST['merch_id'])), //your merchant id
									'action'     => addslashes(trim(@$_POST['action'])), // if action ==0 transaction ok
									'message'    => addslashes(trim(@$_POST['message'])),// transaction responce message
									'approval'   => addslashes(trim(@$_POST['approval'])),// if action!=0 empty
									'timestamp'  => addslashes(trim(@$_POST['timestamp'])),// meesage timestamp
									'nonce'      => addslashes(trim(@$_POST['nonce'])),
								);
								 
								$new_fp_hash = strtoupper($wpcoHtml -> eu_mac($data_all, $key));					
								$data_all['fp_hash'] = $new_fp_hash;
								$fp_hash = addslashes(trim(@$_POST['fp_hash']));							
								$success = false;				
								
								if ($data_all['fp_hash'] === $fp_hash) {
									if($data_all['action'] == "0") {
										$message = __("Successfully completed", $this -> plugin_name);
										$success = true;
									} else {
										$message = __("Transaction failed", $this -> plugin_name) . " " . $data_all['message'];
									}
								} else {
									$message = __('Invalid signature', $this -> plugin_name);
								}
								
								$order_id = $data_all['invoice_id'];							
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $order_id));
								$order -> pmethod = $pmethod = "eupayment";
								$user_id = $order -> user_id;
								break;
							case 'ogone_basic'			:							
								//global variables
								global $wpcoHtml, $Order;
								$success = false;					

								//SHA1 check
								$sha1out = $this -> get_option('ogone_basic_sha1out');
								// create the SHASIGN OUT String 
								$checkArr = array();

								foreach ($_REQUEST as $k => $v) {
									$checkArr[strToUpper($k)] = $v;
								}

								kSort($checkArr);
								$checkStr = "";

								foreach ($checkArr as $k => $v) {
									if (strToUpper($k) == "SHASIGN" || strToUpper($k) == "TXTCOLOR" || strToUpper($k) == "WPCOMETHOD" || strToUpper($k) == "TYPE" || $v == "") continue;
									$checkStr .= strToUpper($k) . "=" . $v . $sha1out;
								}

								$shasign = strToUpper(sha1($checkStr));								

								if ($shasign === $_REQUEST['SHASIGN']) {
									if (!empty($_REQUEST['STATUS']) && ($_REQUEST['STATUS'] == 4 || $_REQUEST['STATUS'] == 9 || $_REQUEST['STATUS'] == 5)) {
										$message = __('Successfully completed', $this -> plugin_name);
										$success = true;
									} else {
										$message = __('Transaction failed', $this -> plugin_name);
									}
								} else {
									$message = __('Invalid signature', $this -> plugin_name);
								}							

								$order_id = $_REQUEST['orderID'];
								$wpcoDb -> model = $Order -> model;
								$order = $wpcoDb -> find(array('id' => $_REQUEST['orderID']));
								$order -> pmethod = $pmethod = "ogone_basic";
								$user_id = $order -> user_id;
								break;
							case 'google_checkout'		:
								global $wpdb, $wpcoDb, $Order;
								$success = false;
							
								if (!empty($_POST['_type'])) {
									switch ($_POST['_type']) {
										case 'new-order-notification'			:
											if (!empty($_POST['shopping-cart_merchant-private-data'])) {
												$order_id = $_POST['shopping-cart_merchant-private-data'];
												
												$wpcoDb -> model = $Order -> model;
												$wpcoDb -> save_field('gc_order_id', $_POST['google-order-number'], array('id' => $order_id));
												
												if (!empty($_POST['financial-order-state']) && $_POST['financial-order-state'] == "CHARGED") {
													$success = true;
												}

											}
											break;
										case 'order-state-change-notification'	:
											if (!empty($_POST['new-financial-order-state']) && $_POST['new-financial-order-state'] == "CHARGED") {
												if (!empty($_POST['google-order-number'])) {
													$wpcoDb -> model = $Order -> model;
													
													if ($order = $wpcoDb -> find(array('gc_order_id' => $_POST['google-order-number']))) {
														$success = true;
														$order -> pmethod = $pmethod = "google_checkout";
														$order_id = $order -> id;
														$user_id = $order -> user_id;
													}
												}
											}
											break;
									}
								}
								break;
							/* WorldPay */
							case 'worldpay'			:														
								if (!empty($_REQUEST['transStatus']) && $_REQUEST['transStatus'] == "Y") {
									$worldpay_url = $wpcoHtml -> retainquery($this -> pre . 'method=cosuccess&type=worldpay&order_id=' . $_POST['cartId'], $wpcoHtml -> cart_url());
								} else {
									$worldpay_url = $wpcoHtml -> fail_url();
								}
							
								global $wpcoDb, $Order;
								$success = false;
							
								if (!empty($_POST)) {
									if ($_POST['transStatus'] == "Y") {
										if (!empty($_POST['cartId'])) {
											$order_id = $_POST['cartId'];
											$wpcoDb -> model = $Order -> model;
											
											if ($order = $wpcoDb -> find(array('id' => $order_id))) {												
												$success = true;
												$order -> pmethod = $pmethod = "worldpay";
												$user_id = $order -> user_id;	
											}
										}
									} else {
										$message = __('Transaction was not approved, please try again', $this -> plugin_name);
									}
								} else {
									$message = __('No data was posted back from the payment gateway', $this -> plugin_name);	
								}
								break;
							case 'monsterpay'			:								
								$tnxid = $_GET['tnxid'];
								$checksum = $_GET['checksum'];
								$parity = $_GET['parity'];
								
								$identifier = $this -> get_option('monsterpay_MerchantIdentifier');
								$usrname = $this -> get_option('monsterpay_Usrname');
								$pwd = $this -> get_option('monsterpay_Pwd');
								
								if (!empty($tnxid) && !empty($checksum) && !empty($parity)) {
									if ($monsterpay = $this -> vendor('monsterpay', 'gateways' . DS)) {
										$monsterpay -> tnxid = $tnxid;
										$monsterpay -> checksum = $checksum;
										$monsterpay -> parity = $parity;
										$monsterpay -> identifier = $identifier;
										$monsterpay -> usrname = $usrname;
										$monsterpay -> pwd = $pwd;
										
										if ($synchro = $monsterpay -> request()) {											
											$tnx_status = $synchro -> outcome -> status;
											$error_code = $synchro -> outcome -> error_code;
											$error_desc = $synchro -> outcome -> error_desc;
											$error_solution = $synchro -> outcome -> error_solution;
											$seller_reference = $synchro -> seller -> reference;
											
											if (!empty($tnx_status) && $tnx_status == "Complete") {
												if (!empty($seller_reference)) {
													$order_id = $seller_reference;
													$wpcoDb -> model = $Order -> model;	
											
													if ($order = $wpcoDb -> find(array('id' => $order_id))) {
														$success = true;
														$order -> pmethod = $pmethod = "monsterpay";
														$order -> paid = "Y";
														$user_id = $order -> user_id;
													} else {
														$message = __('Order could not be read, please try ordering again.', $this -> plugin_name);	
													}
												} else {
													$message = __('No order ID/reference was sent back from MonsterPay.', $this -> plugin_name);
												}
											} else {
												$message = __('Your order has been declined:', $this -> plugin_name); 
												$message .= ' ' . $error_desc;
											}
										} else {
											$message = __('Could not communicate with MonsterPay. Please check that CURL and PHP5 (with SimpleXML) are installed.', $this -> plugin_name);
										}
									} else {
										$message = __('MonsterPay class could not be loaded, please try again.', $this -> plugin_name);
									}
								} else {
									$message = __('No GET variables were received from MonsterPay, please try again.', $this -> plugin_name);
								}						
								break;
							case 'netcash'				:
								global $wpdb, $wpcoDb, $wpcoHtml, $Javascript, $Order, $Item, $wpcoFieldsOrder, $wpcoAuth;
								$success = false;
							
								if (!empty($_REQUEST)) {
									if (!empty($_REQUEST['TransactionAccepted'])) {									
										$TransactionAccepted = $_REQUEST['TransactionAccepted'];
										$Reference = $_REQUEST['Reference'];
										
										if ($TransactionAccepted == "true") {
											$order_id = $Reference;
											$wpcoDb -> model = $Order -> model;	
											
											if ($order = $wpcoDb -> find(array('id' => $order_id))) {
												$success = true;
												$order -> pmethod = $pmethod = "netcash";
												$user_id = $order -> user_id;	
											}
										} else {
											$message = __('This transaction was declined, please try again.', $this -> plugin_name);	
											$message .= " " . $_REQUEST['Reason'];
										}
									} else {
										$message = __('No transaction status was passed back.', $this -> plugin_name);	
									}
								} else {
									$message = __('No data was passed back.', $this -> plugin_name);
								}
								break;
							case 'sagepay'				:
								global $wpdb, $wpcoDb, $Order, $Item, $wpcoFieldsOrder, $wpcoAuth;
								$success = false;
														
								if ($this -> is_plugin_active('sagepay')) {
									if ($sagepay = $this -> extension_vendor('sagepay')) {
										if ($values = $sagepay -> order_successful()) {
											if (!empty($values)) {
												if (!empty($values['Status']) && $values['Status'] == "OK") {
													$order_id = $_REQUEST['order_id'];
													$wpcoDb -> model = $Order -> model;	
													
													if ($order = $wpcoDb -> find(array('id' => $order_id))) {
														$success = true;
														$order -> pmethod = $pmethod = "sagepay";
														$user_id = $order -> user_id;	
													}
												} else {
													$message = __('This transaction was declined, please try again.', $this -> plugin_name);
													$message .= "\n" . $values['StatusDetail'];
												}
											} else {
												$message = __('This transaction was declined, please try again.', $this -> plugin_name);	
											}
										} else {
											$message = __('String passed back could not be decrypted, please contact the site administrator.', $this -> plugin_name);
										}
									} else {
										$message = __('Extension vendor could not be loaded, please contact the site administrator.', $this -> plugin_name);
									}
								} else {
									$message = __('Extension is not active, please contact the site administrator.', $this -> plugin_name);
								}
								break;
							case 'virtualmerchant'		:							
								global $wpcoDb, $Order;
								$success = false;
							
								if (!empty($_POST)) {
									if ($_POST['ssl_result'] == 0) {
										$order_id = $_REQUEST['ssl_invoice_number'];
										if (empty($order_id) && !empty($_REQUEST['order_id'])) { $order_id = $_REQUEST['order_id']; }
										$amount = number_format($Order -> total($order_id, true, true, true, true, true), 2, '.', '');
									
										if (!empty($order_id)) {
											$wpcoDb -> model = $Order -> model;	
											
											if ($order = $wpcoDb -> find(array('id' => $order_id))) {
												if ($amount == $_REQUEST['ssl_amount']) {												
													$success = true;
													$order -> pmethod = $pmethod = "virtualmerchant";
													$user_id = $order -> user_id;	
												}
											}
										}
									} else {
										$message = __('Transaction was not approved, please try again', $this -> plugin_name);
									}
								} else {
									$message = __('No data was posted back from the payment gateway', $this -> plugin_name);	
								}
								break;
						}
						
						do_action($this -> pre . '_coreturn');
						
						if ($success == true) {	
							global $ProductsOption;
										
							if (!empty($order_id)) {
								$wpcoDb -> model = $Order -> model;
															
								if ($order = $wpcoDb -> find(array('id' => $order_id))) {	
									$user_id = $order -> user_id;	// ID of the WordPress user
									
									// 'wpco_order_finished' action hook
									do_action($this -> pre . '_order_finished', $order_id, $pmethod, "Y");
									
									$wpcoDb -> save_field('modified', date("Y-m-d H:i:s", time()), array('id' => $order_id));	
									$wpcoDb -> save_field('completed_date', date("Y-m-d H:i:s", time()), array('id' => $order_id));						
									$wpcoDb -> save_field('completed', "Y", array('id' => $order_id));
									$wpcoDb -> save_field('pmethod', $pmethod, array('id' => $order_id));
									$order -> pmethod = $pmethod;									
									$wpcoDb -> model = $Item -> model;
								
									if ($items = $wpcoDb -> find_all(array('order_id' => $order_id))) {	
										$sarray = array();
									
										foreach ($items as $item) {
											$wpcoDb -> model = $Item -> model;
											$wpcoDb -> save_field('completed', "Y", array('id' => $item -> id));
											$wpcoDb -> save_field('paid', "Y", array('id' => $item -> id));
											
											/* Product Inventory */
											if ($item -> product -> inventory != "999" && $item -> product -> inventory > 0) {										
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('inventory', ($item -> product -> inventory - $item -> count), array('id' => $item -> product_id));
											}
											
											/* Variation Option Inventory */
											$styles = maybe_unserialize($item -> styles);
											$usedoptions = array();
											if (!empty($styles)) {
												foreach ($styles as $style_id => $options) {
													if (is_array($options)) {
														foreach ($options as $option_id) {
															$usedoptions[] = $option_id;
														}
													} else {
														$usedoptions[] = $options;
													}
												}
											}
											$usedoptions = array_unique($usedoptions);
						
											if (!empty($item -> product -> optionstock) && is_array($item -> product -> optionstock)) {
												foreach ($item -> product -> optionstock as $option_id => $option_inventory) {
													if ($option_inventory > 0 && !empty($usedoptions) && in_array($option_id, $usedoptions)) {
														$wpcoDb -> model = $ProductsOption -> model;
														$wpcoDb -> save_field('inventory', ($option_inventory - $item -> count), array('option_id' => $option_id, 'product_id' => $item -> product_id));
													}
												}
											}
											
											if (!empty($item -> product -> supplier_id)) {
												$sarray[$item -> product -> supplier_id][] = $item;
											}
										}		
										
										if ($order -> completed == "N") {											
											//get the User data
											$order -> paid = "Y";
											$user = $this -> userdata($user_id);
											$subject = __('Order #', $this -> plugin_name) . $order -> id . ' ' .  __('receipt', $this -> plugin_name);
											
											if ($this -> get_option('invoice_enabled') == "Y") {
												$to = $order -> bill_email;
												$message = $this -> render('invoice', array('order' => $order, 'items' => $items, 'user' => $user, 'touser' => true), false, 'email');
												$this -> send_mail($to, $subject, $message);
											}
											
											$message = $this -> render('invoice', array('order' => $order, 'items' => $items, 'user' => $user), false, 'email');
											$to = $this -> get_option('merchantemail');
											$this -> send_mail($to, $subject, $message);
											
											//In Honor Of donation products
											foreach ($items as $item) {
												if (!empty($item -> product -> price_type) && $item -> product -> price_type == "donate") {
													if (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") {
														$to = $item -> iof_benemail;
														$subject = __('Donation Made In Honor of', $this -> plugin_name);
														$message = $this -> render('products' . DS . 'inhonorof', array('item' => $item), false, 'email');
														$this -> send_mail($to, $subject, $message);
													}
												}
											}
											
											if (!empty($sarray) && is_array($sarray)) {													
												foreach ($sarray as $supplier_id => $supplier_items) {													
													$wpcoDb -> model = $Supplier -> model;
													
													if ($supplier = $wpcoDb -> find(array('id' => $supplier_id))) {
														if ($supplier -> notify == "Y") {
															if (!empty($supplier -> email) && is_email($supplier -> email)) {
																$to = $supplier -> email;
																$subject = __('Order #', $this -> plugin_name) . $order -> id . ' ' .  __('receipt', $this -> plugin_name);
																$message = $this -> render('suppliers' . DS . 'order', array('order' => $order, 'items' => $supplier_items, 'user' => $user, 'supplier' => $supplier), false, 'email');
																$this -> send_mail($to, $subject, $message);
															}
														}
													}
												}
											}
										}
									}
								}
							}
							
							if ($pmethod == "re") {
								global $wpcoHtml;
								$this -> redirect($wpcoHtml -> retainquery("wpcomethod=cosuccess&order_id=" . $order -> id, $wpcoHtml -> cart_url()), false, false, $jsredirect = true);
							} elseif ($pmethod == "worldpay") {
								?>
                                
                                <meta http-equiv="refresh" content="0;url=<?php echo $worldpay_url; ?>" /> 
                                
								<?php	
								
								exit(); die();
							}
							
							$userdata = $this -> userdata();				
							$title = __('Order Finished', $this -> plugin_name);
							
							ob_start();							
							//$this -> render('steps', array('step' => 'finished', 'order' => $order), true, 'default');
							
							?>
							
							<h2><?php _e('Order Finished', $this -> plugin_name); ?></h2>
							
							<?php
							
							$content = ob_get_contents();
							ob_end_clean();
							
							$content .= $this -> render('success', array('order' => $order, 'items' => $items, 'user' => $userdata), false, 'default');
							
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						} else {
							if ($pmethod == "worldpay") {
								?>
                                
                                <meta http-equiv="refresh" content="0;url=<?php echo $worldpay_url; ?>" /> 
                                
								<?php	
								
								exit(); die();
							}
							
							$Javascript -> alert($message, $wpcoHtml -> bill_url(), true);					
						}
						break;
				}
			}
		}
		
		function delete_user($user_id = null) {
			global $wpdb, $wpcoDb, $Order, $Item, $Discount;
		
			if (!empty($user_id)) {
				$wpcoDb -> model = $Order -> model;
				$wpcoDb -> delete_all(array('user_id' => $user_id));
				
				$wpcoDb -> model = $Item -> model;
				$wpcoDb -> delete_all(array('user_id' => $user_id));
				
				$wpcoDb -> model = $Discount -> model;
				$wpcoDb -> delete_all(array('user_id' => $user_id));
				
				return true;
			}
		
			return false;
		}
		
		function show_user_profile() {
			if ($this -> get_option('shippingdetails') == "Y") {
				global $user_ID;
				$this -> render('profile', array('userid' => $user_ID), true, 'default');
			}
		}
		
		function edit_user_profile() {
			if ($this -> get_option('shippingdetails') == "Y") {
				$this -> render('profile', array('userid' => $_GET['user_id']), true, 'default');
			}
		}
		
		function personal_options_update($user_id = null) {		
			global $errors;
			$errors = new WP_error();
			
			if ($paymentfields = $this -> get_option('paymentfields')) {				
				$shippingfields = $paymentfields['shipping'];
				
				foreach ($shippingfields as $skey => $shippingfield) {				
					if (!empty($shippingfield['show'])) {
						if (empty($_POST[$this -> pre . 'shipping'][$skey])) {
							if (!empty($shippingfield['required'])) {
								$errors -> add('ship_' . $skey, __('<strong>ERROR</strong>: Please fill in your shipping ', $this -> plugin_name) . strtolower($shippingfield['title']));
							}
						}
					}
				}
				
				if (empty($_POST['billingsameshipping']) || $_POST['billingsameshipping'] == "N") {
					$billingfields = $paymentfields['billing'];
				
					foreach ($billingfields as $bkey => $billingfield) {					
						if (!empty($billingfield['show'])) {
							if (empty($_POST[$this -> pre . 'billing'][$bkey])) {
								if (!empty($billingfield['required'])) {
									$errors -> add('bill_' . $bkey, __('<strong>ERROR</strong>: Please fill in your billing ', $this -> plugin_name) . strtolower($billingfield['title']));
								}
							}
						}
					}
				}
			}
			
			if (!empty($errors)) {
				return false;
			}
		}
		
		function profile_update($user_id = null) {		
			$errors = array();
			
			if (!empty($user_id) && !empty($_POST)) {
				if ($paymentfields = $this -> get_option('paymentfields')) {				
					$shippingfields = $paymentfields['shipping'];
					
					foreach ($shippingfields as $skey => $shippingfield) {
						delete_usermeta($user_id, 'ship_' . $skey);
					
						if (!empty($shippingfield['show'])) {
							if (empty($_POST[$this -> pre . 'shipping'][$skey])) {
								if (!empty($shippingfield['required'])) {
									$errors['ship_' . $skey] = __('Please fill in your ', $this -> plugin_name) . strtolower($shippingfield['title']);
								}
							} else {
								update_user_meta($user_id, 'ship_' . $skey, $_POST[$this -> pre . 'shipping'][$skey]);
								
								if (!empty($_POST['billingsameshipping']) && $_POST['billingsameshipping'] == "Y") {
									update_user_meta($user_id, 'bill_' . $skey, $_POST[$this -> pre . 'shipping'][$skey]);
								}
							}
						}
					}
					
					if (empty($_POST['billingsameshipping']) || $_POST['billingsameshipping'] == "N") {
						update_user_meta($user_id, 'billingsameshipping', "N");
						$billingfields = $paymentfields['billing'];
					
						foreach ($billingfields as $bkey => $billingfield) {
							delete_usermeta($user_id, 'bill_' . $bkey);
						
							if (!empty($billingfield['show'])) {
								if (empty($_POST[$this -> pre . 'billing'][$bkey])) {
									if (!empty($billingfield['required'])) {
										$errors['bill_' . $bkey] = __('Please fill in your ', $this -> plugin_name) . strtolower($billingfield['title']);
									}
								} else {
									update_user_meta($user_id, 'bill_' . $bkey, $_POST[$this -> pre . 'billing'][$bkey]);
								}
							}
						}
					} else {
						update_user_meta($user_id, 'billingsameshipping', "Y");
					}
				}
			}
			
			return true;
		}
		
		function plugin_action_links($actions = null, $plugin_file = null, $plugin_data = null, $context = null) {
			$this_plugin = plugin_basename(__FILE__);
			
			if (!empty($plugin_file) && $plugin_file == $this_plugin) {
				$actions[] = '<a href="" onclick="jQuery.colorbox({href:ajaxurl + \'?action=' . $this -> pre . 'serialkey\'}); return false;" id="' . $this -> pre . 'submitseriallink" title="' . __('Serial Key', $this -> plugin_name) . '">' . __('Serial Key', $this -> plugin_name) . '</a>';
			}
			
			return $actions;
		}
		
		function phpmailer_init($phpmailer = null) {
			$mail_from = $this -> get_option('mail_from');
			$mail_name = $this -> get_option('mail_name');
		
			$phpmailer -> CharSet = "UTF-8";
			$phpmailer -> From = $mail_from;
			$phpmailer -> Sender = $mail_from;
			$phpmailer -> AddReplyTo($mail_from, $mail_name);
		
			return $phpmailer;	
		}
		
		function the_title($wp_title = null) {
			if (!empty($_GET[$this -> pre . 'method'])) {
				switch ($_GET[$this -> pre . 'method']) {
					case 'contacts'				:
						return __('Contact Details', $this -> plugin_name);
						break;
					case 'shipping'				:
						return __('Shipping Details', $this -> plugin_name);
						break;
					case 'billing'				:
						return __('Billing Details', $this -> plugin_name);
						break;
					case 'cofailed'				:
						return __('Order Failed', $this -> plugin_name);
						break;
					case 'coreturn'				:
						return __('Order Finished', $this -> plugin_name);
						break;
				}
			}
				
			return $wp_title;
		}
		
		function admin() {	
			$this -> render('index', false, true, 'admin');
		}
		
		function admin_import() {
			$this -> import();
		}
		
		/**
		 * Import a CSV file with products into the database
		 *
		 */
		function admin_import_csv() {
			global $wpdb, $wpcoDb, $wpcoHtml, $Product, $Category;
			$renderagain = true;
			$errors = array();
			
			if (!empty($_POST)) {
				if (!empty($_POST['source'])) {
					switch ($_POST['source']) {
						case 'oscommerce'			:						
							$os_user = $_POST['oscommerce']['user'];
							$os_pass = $_POST['oscommerce']['pass'];
							$os_db = $_POST['oscommerce']['db'];
							$os_host = $_POST['oscommerce']['host'];
							
							if ($osDb = new wpdb($os_user, $os_pass, $os_db, $os_host)) {
								$os_query = "SELECT * FROM `products`";
							
								if ($os_products = $osDb -> get_results($os_query)) {
									$products = array();
									$imported = 0;
									$p = 1;
									
									foreach ($os_products as $os_product) {
										$this -> remove_server_limits();
										$os_query2 = "SELECT * FROM `products_description` WHERE `products_id` = '" . $os_product -> products_id . "' LIMIT 1;";
											
										if ($os_product_desc = $osDb -> get_row($os_query2)) {										
											/* Images */										
											if (!empty($os_product -> products_image)) {
												$filename = basename($os_product -> products_image);
												$imagename = $wpcoHtml -> sanitize($os_product_desc -> products_name) . '.' . $wpcoHtml -> strip_ext($filename, "ext");
												$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
												$imagefull = $imagepath . $imagename;
					
												$remoteurl = "";
												$remoteurl = (!empty($_POST['oscommerce']['imagesurl'])) ? rtrim($_POST['oscommerce']['imagesurl'], '/') . '/' : "";
												$remoteurl .= $os_product -> products_image;
												$remoteurl = str_replace(" ", "%20", $remoteurl);
												
												if (file_exists($imagefull)) {
													unlink($imagefull);
												}
												
												if ($ch = curl_init($remoteurl)) {					
													curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
													curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
													curl_setopt($ch, CURLOPT_HEADER, 0);
													curl_setopt($ch, CURLOPT_TIMEOUT, 180);
													$imagedata = curl_exec($ch);
													curl_close($ch);
					
													if (!empty($imagedata)) {													
														if ($fk = fopen($imagefull, "w")) {														
															fwrite($fk, $imagedata);
															fclose($fk);
															@chmod($imagefull, 0777);
														}
													}
												}
											}
										
											/* Categories */
											$categories = array(1);
											$os_query3 = "SELECT categories_description.categories_name, products_to_categories.products_id, products_to_categories.categories_id FROM `categories_description`, `products_to_categories` WHERE categories_description.categories_id = products_to_categories.categories_id AND products_to_categories.products_id = " . $os_product -> products_id;
											
											if ($os_product_categories = $osDb -> get_results($os_query3)) {
												$categories = array();
											
												foreach ($os_product_categories as $os_product_category) {
													$wpcoDb -> model = $Category -> model;
												
													if ($category = $wpcoDb -> find(array('title' => mysql_escape_string($os_product_category -> categories_name)))) {
														$categories[] = $category -> id;
													} else {
														$category = array(
															'title'			=>	mysql_escape_string($os_product_category -> categories_name),
															'useimage'		=>	"N",
															'name'			=>	$wpcoHtml -> sanitize($os_product_category -> categories_name),
															'description'	=>	$os_product_category -> categories_name,
														);
														
														if ($Category -> save($category, $validate = false, $savepp = false)) {
															$categories[] = $Category -> insertid;
														}
													}
												}
											}
											
											$product = array(
												'code'					=>	$os_product -> products_id,
												'title'					=>	$os_product_desc -> products_name,
												'nicetitle'				=>	$wpcoHtml -> sanitize($os_products_desc -> products_name),
												'description'			=>	$os_product_desc -> products_description,
												'keywords'				=>	$os_product_desc -> products_keywords,
												'oldimage'				=>	$imagename,
												'price'					=>	number_format($os_product -> products_price, 2, '.', ''),
												'price_fixed'			=>	number_format($os_product -> products_price, 2, '.', ''),
												'price_type'			=>	"fixed",
												'excludeglobal'			=>	"N",
												'shipping'				=>	"N",
												'affiliate'				=>	"N",
												'min_order'				=>	1,
												'inventory'				=>	"-1",
												'weight'				=>	$os_product -> products_weight,
												'created'				=>	$wpcoHtml -> gen_date(),
												'modified'				=>	$wpcoHtml -> gen_date(),
												'categories'			=>	$categories,
											);
											
											$defaults = array(
												'code'				=>	$p,
												'title'				=>	"Product " . $p,
												'description'		=>	"Product " . $p . " Description",
												'keywords'			=>	"",
												'price'				=>	"0.00",
												'sprice'			=>	"",
												'type'				=>	"tangible",
												'min_order'			=>	"1",
												'inventory'			=>	"-1",
												'measurement'		=>	"units",
												'weight'			=>	"",
												'categories'		=>	array(1),
											);
											
											$product = wp_parse_args($product, $defaults);
											
											$wpcoDb -> model = $Product -> model;
											if ($cur_product = $wpcoDb -> find(array('code' => $os_product -> products_id))) {
												$product['id'] = $cur_product -> id;
											}
											
											//prevent flushing of rewrite rules
											$this -> wpimporting();
											
											if ($Product -> save($product, $validate = true, $imageupload = false, $fromeditor = false, $savepp = false)) {
												$imported++;
											}
											
											$Product -> id = false;
											$Product -> errors = false;
											
											$p++;
											flush();
										}
										
										$this -> updatepages($update = false);
										$message = $imported . " " . __('Products have been imported', $this -> plugin_name);
									}
								} else {
									$message = __('Products could not be retrieved', $this -> plugin_name);
								}
							} else {
								$message = __('Could not connect to the database', $this -> plugin_name);
							}
							
							$osDb -> print_error();
							break;
						case 'csvfile'					:
							if (!empty($_POST['fields'])) {
								if (!empty($_FILES)) {
									if (!empty($_FILES['csv']['name'])) {
										$filename = $_FILES['csv']['name'];
										$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'csv' . DS;
										$filefull = $filepath . $filename;
										
										if (move_uploaded_file($_FILES['csv']['tmp_name'], $filefull)) {
											@chmod($filefull, 0777);
										
											if ($fh = fopen($filefull, "r")) {
												$data = array();
												$delimiter = (empty($_POST['delimiter'])) ? "," : $_POST['delimiter'];
												$r = 0;
												$imported = 0;
												$products = array();
												
												while (($row = fgetcsv($fh, 1000, $delimiter)) !== false) {
													if (!empty($_POST['csvheadings']) && $_POST['csvheadings'] == "Y") {
														//continue;
													}
												
													$data[$r] = $row;
													$product = array(
														'price_type'			=> 	"fixed",
													);
													
													foreach (array_keys($_POST['fields']) as $field) {													
														if (!empty($_POST['columns'][$field])) {															
															switch ($field) {
																case 'price'		:
																case 'sprice'		:
																case 'wholesale'	:
																	$product[$field] = preg_replace("/[^0-9.,]/si", "", $data[$r][($_POST['columns'][$field] - 1)]);
																	break;
																default				:
																	$product[$field] = $data[$r][($_POST['columns'][$field] - 1)];
																	break;
															}
														}
													}
													
													$product['price_fixed'] = $product['price'];
													
													$categories = array();
													if (!empty($product['categories'])) {
														if (($categoriesarray = explode(",", $product['categories'])) !== false) {
															if (!empty($categoriesarray) && is_array($categoriesarray)) {
																foreach ($categoriesarray as $category_title) {																
																	if ($category_id = $wpdb -> get_var("SELECT `id` FROM `" . $wpdb -> prefix . $Category -> table . "` WHERE `title` = '" . mysql_escape_string($category_title) . "'")) {
																		$categories[] = $category_id;
																	} else {
																		$category = array(
																			'title'			=>	$category_title,
																			'useimage'		=>	"N",
																			'name'			=>	$wpcoHtml -> sanitize($category_title),
																			'description'	=>	$category_title,
																		);
																		
																		if ($Category -> save($category, $validate = false, $savepp = false)) {
																			$categories[] = $Category -> insertid;
																		}
																	}					
																}
															}
														}
													}
													
													$product['categories'] = $categories;
													$product['nicetitle'] = $wpcoHtml -> sanitize($product['title']);
													
													if (!empty($product['title']) && !empty($product['image'])) {										
														$filename = basename($product['image']);
														$imagename = $wpcoHtml -> sanitize($product['title']) . '.' . $wpcoHtml -> strip_ext($filename, "ext");
														$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
														$imagefull = $imagepath . $imagename;
										
														$remoteurl = "";
														$remoteurl = (!empty($_POST['imageprependurl'])) ? $_POST['imageprependurl'] : "";
														$remoteurl .= $product['image'];
														$remoteurl = str_replace(" ", "%20", $remoteurl);
														
														if ($ch = curl_init($remoteurl)) {					
															curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");							
															curl_setopt($ch, CURLOPT_URL, $remoteurl);
															curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
															curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
															curl_setopt($ch, CURLOPT_HEADER, false);
															curl_setopt($ch, CURLOPT_REFERER, $remoteurl);
															$imagedata = curl_exec($ch);
															curl_close($ch);
									
															if (!empty($imagedata)) {													
																if ($fk = fopen($imagefull, "w")) {								
																	fwrite($fk, $imagedata);
																	fclose($fk);
																	@chmod($imagefull, 0777);																	
																}
															}
														}
													}
													
													$product['oldimage'] = $imagename;
													unset($product['image']);
													$product['p_type'] = $this -> get_option('post_type');
													
													// Is this an existing product?
													$productquery = "SELECT `id` FROM `" . $wpdb -> prefix . $Product -> table . "` WHERE `nicetitle` = '" . $product['nicetitle'] . "'";
													$productquery .= (!empty($product['code'])) ? " OR `code` = '" . $product['code'] . "'" : '';
													if ($product_id = $wpdb -> get_var($productquery)) {
														$product['id'] = $product_id;
													}
													
													if ($Product -> save($product, true, false, false, true, true)) {
														$product_id = $Product -> insertid;
													
														/* Extra Images */
														if (!empty($_POST['extraimages'])) {
															global $Image;
															$wpcoDb -> model = $Image -> model;
															$wpcoDb -> delete_all(array('product_id' => $product_id));
														
															$e = 1;
															foreach ($_POST['extraimages'] as $extraimage_column) {
																$extraimage = $data[$r][($extraimage_column - 1)];	
																
																if (!empty($extraimage)) {														
																	$filename = basename($extraimage);
																	$imagename = sanitize_title($product['title']) . '-' . $e . '.' . $wpcoHtml -> strip_ext($filename, 'ext');
																	$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
																	$imagefull = $imagepath . $imagename;
																	
																	$saveimage = false;
																	if (!file_exists($imagefull)) {
																		$remoteurl = "";
																		$remoteurl = (!empty($_POST['imageprependurl'])) ? $_POST['imageprependurl'] : "";
																		$remoteurl .= $extraimage;
																		
																		if ($ch = curl_init($remoteurl)) {					
																			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");							
																			curl_setopt($ch, CURLOPT_URL, $remoteurl);
																			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
																			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
																			curl_setopt($ch, CURLOPT_HEADER, false);
																			curl_setopt($ch, CURLOPT_REFERER, $remoteurl);
																			$imagedata = curl_exec($ch);
																			curl_close($ch);
													
																			if (!empty($imagedata)) {													
																				if ($fk = fopen($imagefull, "w")) {								
																					fwrite($fk, $imagedata);
																					fclose($fk);
																					@chmod($imagefull, 0777);	
																					$saveimage = true;																
																				}
																			}
																		}
																	} else {
																		$saveimage = true;
																	}
																	
																	if ($saveimage == true) {
																		$imagearray = array(
																			'Image' => array(
																				'title'					=>	$product['title'] . ' ' . $e,
																				'product_id'			=>	$product_id,
																				'oldfile'				=>	$imagename,
																				'oldsize'				=>	filesize($imagefull),
																			)
																		);
																		
																		$Image -> save($imagearray, true);
																		$Image -> data -> id = false;
																	}
																	
																	$e++;
																}
															}
														}
													
														$imported++;
													} else {													
														if (!empty($Product -> errors)) {
															foreach ($Product -> errors as $err) {
																$errors[] = $err;
															}
														}
													}
													
													$products[] = $product;
													$r++;
													$Product -> id = false;
													$Product -> errors = false;
												}
												
												$this -> render_msg($imported . ' ' . __('products were imported.', $this -> plugin_name));
											} else {
												$this -> render_err(__('CSV file could not be opened for reading.', $this -> plugin_name));
											}
										} else {
											$this -> render_err(__('CSV file could not be moved from TMP.', $this -> plugin_name));
										}
									} else {
										$this -> render_err(__('No CSV file was chosen for importing.', $this -> plugin_name));
									}
								} else {
									$this -> render_err(__('No data was posted.', $this -> plugin_name));
								}
							} else {
								$this -> render_err(__('No import fields were specified.', $this -> plugin_name));
							}
							break;
					}
				} else {
					$message = __('Please select an import source', $this -> plugin_name);
				}
			}
			
			if ($renderagain) {
				if (!empty($message)) { $this -> render_msg($message); }		
				$this -> render('import' . DS . 'csv', array('errors' => $errors), true, 'admin');
			}
		}
		
		function admin_categories() {
			global $wpdb, $wpcoDb, $wpcoHtml, $Category, $Product, $wpcoCategoriesProduct;
			$wpcoDb -> model = $Category -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-categories\-/si", "", $_GET['page']) : $_GET['method'];
		
			switch ($method) {
				case 'view'				:
					if (!empty($_GET['id'])) {
						if ($category = $Category -> get($_GET['id'])) {
							$perpage = (isset($_COOKIE[$this -> pre . 'productsperpage'])) ? $_COOKIE[$this -> pre . 'productsperpage'] : 10;
							$order = array($wpdb -> prefix . $Product -> table . '.modified', "DESC");
							
							$data = $this -> paginate($wpcoCategoriesProduct -> model, "*", $this -> sections -> categories . "&amp;method=view&amp;id=" . $category -> id, array($wpdb -> prefix . $wpcoCategoriesProduct -> table . '.category_id' => $category -> id), false, $perpage, $order);
							$products = $data[$wpcoCategoriesProduct -> model];
							
							if (!empty($products)) {
								foreach ($products as $pkey => $product) {
									$products[$pkey] = $this -> init_class($Product -> model, $product);
								}
							}
							
							$this -> render('categories' . DS . 'view', array('category' => $category, 'products' => $products, 'paginate' => $data['Paginate']), true, 'admin');
						} else {
							$message = __('Category cannot be read', $this -> plugin_name);
							$this -> redirect('?page=checkout-categories', 'error', $message);
						}
					} else {
						$message = __('No category was specified', $this -> plugin_name);
						$this -> redirect('?page=checkout-categories', 'error', $message);
					}
					break;
				case 'save'				:			
					if (!empty($_POST)) {				
						if ($Category -> save($_POST, true)) {
							$message = __('Category has been saved', $this -> plugin_name);
							$this -> redirect("?page=" . $this -> sections -> categories, 'message', $message);
						} else {
							$this -> render_err(__('Category cannot be saved', $this -> plugin_name));
							$this -> render('categories' . DS . 'save');
						}
					} else {
						$category = $Category -> find(array('id' => $_GET['id']), false, false, true);
						$this -> render('categories' . DS . 'save');
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Category has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Category cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No category was specified', $this -> plugin_name);
					}
					
					$this -> redirect('?page=checkout-categories', $msg_type, $message);
					break;
				case 'mass'				:			
					if (!empty($_POST['action'])) {
						if (!empty($_POST['Category']['checklist'])) {
							$categories = $_POST['Category']['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'				:
									foreach ($categories as $category_id) {
										$wpcoDb -> model = $Category -> model;
										$wpcoDb -> delete($category_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected categories removed', $this -> plugin_name);
									break;
								//categorize categories using a parent
								case 'setparent'			:
									if (!empty($_POST['parentcategory'])) {
										foreach ($categories as $category_id) {
											$wpcoDb -> model = $Category -> model;
											$wpcoDb -> save_field('parent_id', $_POST['parentcategory'], array('id' => $category_id));
										}
										
										$msg_type = 'message';
										$message = __('Selected categories have been assigned the chosen parent category', $this -> plugin_name);
									} else {
										$msg_type = 'error';
										$message = __('Please select a parent category', $this -> plugin_name);
									}
									break;
								case 'merge'				:
								
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No categories were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was selected', $this -> plugin_name);
					}
					
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				case 'order'			:
					$wpcoDb -> model = $Category -> model;
					$categories = $wpcoDb -> find_all(array('parent_id' => "0"), array('id', 'title', 'order'), array('order', "ASC"));
					$this -> render('categories' . DS . 'order', array('categories' => $categories), true, 'admin');
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'categoriesperpage'])) ? $_COOKIE[$this -> pre . 'categoriesperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect('?page=checkout-categories&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($wpdb -> prefix . $Category -> table . '.' . $ofield, $odir);
					$data = $this -> paginate('Category', "*", $this -> sections -> categories, $conditions, $searchterm, $perpage, $order);
					$this -> render('categories' . DS . 'index', array('categories' => $data['Category'], 'paginate' => $data['Paginate']));
					break;
			}
		}
		
		function admin_products() {
			global $wpdb, $user_ID, $wpcoDb, $wpcoHtml, $Product, $Supplier, $Category, $wpcoCategoriesProduct, $ProductsStyle, 
			$ProductsOption, $wpcoCategoriesProduct, $wpcoProductsProduct, $wpcoKeyword,
			$Supplier;
						
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-products\-/si", "", $_GET['page']) : $_GET['method'];
		
			$stop = true;
			$issupplier = false;
			$perm = $this -> get_option('perm');
			
			if ($supplier = $this -> is_supplier()) {
				$issupplier = true;
				$stop = false;
			} elseif (current_user_can('checkout_products') || current_user_can('checkout_products_save')) {
				$stop = false;
			}
			
			//set the current model to work with
			$wpcoDb -> model = $Product -> model;
		
			if (!$stop) {
				if ($issupplier) {
					switch ($method) {
						case 'save'		:
							if (!empty($_POST)) {
								$_POST['Product']['status'] = (!empty($supplier -> autoapprove) && $supplier -> autoapprove == "Y") ? "active" : "inactive";
								
								if ($Product -> save($_POST, true)) {
									$wpcoDb -> model = $Product -> model;
									$product = $wpcoDb -> find(array('id' => $Product -> insertid));
									
									$to = $this -> get_option('merchantemail');
									$subject = __('New supplier product', $this -> plugin_name);
									$message = $this -> render('suppliers' . DS . 'newproduct', array('product' => $product, 'supplier' => $supplier), false, 'email');
									$this -> send_mail($to, $subject, $message);
									
									if (!empty($supplier -> autoapprove) && $supplier -> autoapprove == "Y") {
										$message = __('Your product has been saved and approved.', $this -> plugin_name);	
									} else {
										$message = __('Product has been saved, the merchant will review your product shortly.', $this -> plugin_name);
									}
									
									if (!empty($_POST['continueediting']) && $_POST['continueediting'] == "1") {
										$this -> redirect('?page=' . $this -> sections -> products_save . '&continueediting=1&id=' . $product -> id, 'message', $message);
									} else {
										$this -> redirect('?page=' . $this -> sections -> products, 'message', $message);
									}
								} else {
									$this -> render_msg(__('Product cannot be saved.', $this -> plugin_name) . ' (' . count($Product -> errors) . ' ' . __('errors', $this -> plugin_name) . ')');
									$this -> render('products' . DS . 'save');
								}
							} else {
								if (!empty($_GET['id'])) {
									$wpcoDb -> model = $Product -> model;
									$product = $wpcoDb -> find(array('id' => $_GET['id']));
								}
								
								if (empty($product) || (!empty($product) && $product -> supplier_id == $supplier -> id)) {								
									$this -> render('products' . DS . 'save');
								} else {
									$this -> redirect($this -> referer, 'error', __('This product does not belong to this supplier account.', $this -> plugin_name));
								}
							}
							break;
						default			:
							$perpage = (isset($_COOKIE[$this -> pre . 'productsperpage'])) ? $_COOKIE[$this -> pre . 'productsperpage'] : 10;
							$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
							$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
							
							if (!empty($_POST['searchterm'])) {
								$this -> redirect($wpcoHtml -> retainquery('page=checkout-products&' . $this -> pre . 'searchterm=' . urlencode($searchterm), $this -> url, false));
							}
							
							$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%'") : false;
							$conditions['supplier_id'] = $supplier -> id;
							$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
							$odir = strtoupper((empty($_GET['order'])) ? 'DESC' : $_GET['order']);
							$order = array($ofield, $odir);
							$data = $this -> paginate($Product -> model, "*", $this -> sections -> products, $conditions, $searchterm, $perpage, $order);
							$this -> render('products' . DS . 'index', array('products' => $data[$Product -> model], 'paginate' => $data['Paginate']));
							break;	
					}
				} else {
					//administrator
					switch ($method) {
						case 'purge'			:
							if ($products = $wpcoDb -> find_all(false, "`id`")) {
								foreach ($products as $product) {
									$this -> remove_server_limits();
									$this -> wpimporting();
									
									$wpcoDb -> model = $Product -> model;
									$wpcoDb -> delete($product -> id);
								}
								
								global $wpdb;
								$query = "TRUNCATE TABLE `" . $wpdb -> prefix . "" . $Product -> table . "`";
								$wpdb -> query($query);
								
								$msg_type = 'message';
								$message = __('All products have been deleted', $this -> plugin_name);
							} else {
								$msg_type = 'error';
								$message = __('No products could be found', $this -> plugin_name);
							}
							
							$this -> redirect($this -> url, $msg_type, $message);
							break;
						case 'order'			:
							if (!empty($_POST)) {
								if (!empty($_POST['category_id'])) {
									global $wpdb, $Category;
									$query = "UPDATE `" . $wpdb -> prefix . $Category -> table . "` 
									SET `pordertype` = '" . $_POST['ordertype'] . "'";
									
									if ($_POST['ordertype'] == "specific") { $query .= ", `porderfield` = '" . $_POST['orderfield'] . "', `porderdirection` = '" . $_POST['orderdirection'] . "'"; }
									
									$query .= " WHERE `id` = '" . $_POST['category_id'] . "' LIMIT 1";
									
									$wpdb -> query($query);
								} elseif (!empty($_POST['supplier_id'])) {
									global $wpdb, $Supplier;
									$query = "UPDATE `" . $wpdb -> prefix . $Supplier -> table . "` 
									SET `pordertype` = '" . $_POST['ordertype'] . "'";
									
									if ($_POST['ordertype'] == "specific") { $query .= ", `porderfield` = '" . $_POST['orderfield'] . "', `porderdirection` = '" . $_POST['orderdirection'] . "'"; }
									
									$query .= " WHERE `id` = '" . $_POST['supplier_id'] . "' LIMIT 1";
									
									$wpdb -> query($query);
								} else {
									$this -> update_option('loop_ordertype', $_POST['ordertype']);
									if ($_POST['ordertype'] == "specific") {
										$this -> update_option('loop_orderfield', $_POST['orderfield']);
										$this -> update_option('loop_orderdirection', $_POST['orderdirection']);
									}
								}
								
								$this -> render_msg(__('Order has been saved.', $this -> plugin_name));
							}
						
							$wpcoDb -> model = $Product -> model;
							if (!empty($_GET['supplier_id'])) {
								$wpcoDb -> model = $Supplier -> model;
								$supplier = $wpcoDb -> find(array('id' => $_GET['supplier_id']));
								$wpcoDb -> model = $Product -> model;
								$products = $wpcoDb -> find_all(array('supplier_id' => $supplier -> id), array('id', 'title', 'order', 'image'), array('supplier_order', "ASC"));
								$this -> render('products' . DS . 'order', array('supplier' => $supplier, 'products' => $products), true, 'admin');
							} elseif (!empty($_GET['category_id'])) {
								$wpcoDb -> model = $Category -> model;
								$category = $wpcoDb -> find(array('id' => $_GET['category_id']));
							
								$productsquery = "SELECT p.id, p.title, p.image, cp.order FROM " . 
								$wpdb -> prefix . $wpcoCategoriesProduct -> table . " cp LEFT JOIN " . 
								$wpdb -> prefix . $Product -> table . " p ON cp.product_id = p.id WHERE cp.category_id = '" .
								$_GET['category_id'] . "' AND p.status = 'active' ORDER BY cp.order ASC";
								
								$products = stripslashes_deep($wpdb -> get_results($productsquery));
								
								if (!empty($products)) {
									foreach ($products as $pkey => $product) {
										$products[$pkey] = $this -> init_class($Product -> model, $product);
									}
								}
								
								$this -> render('products' . DS . 'order', array('category' => $category, 'products' => $products), true, 'admin');
							} else {
								$category = false;
								$products = $wpcoDb -> find_all(array('status' => "active"), array('id', 'title', 'order', 'image'), array('order', "ASC"));
								$this -> render('products' . DS . 'order', array('products' => $products), true, 'admin');
							}
							break;
						case 'related'			:
							if (!empty($_GET['id'])) {
								if ($product = $wpcoDb -> find(array('id' => $_GET['id']))) {
									$productsquery = "SELECT p.id, p.title FROM " . $wpdb -> prefix . $Product -> table . " p ORDER BY p.title ASC";
									$products = stripslashes_deep($wpdb -> get_results($productsquery));
									$relatedquery = "SELECT pp.id, pp.related_id FROM " . $wpdb -> prefix . $wpcoProductsProduct -> table . " pp LEFT JOIN " . $wpdb -> prefix . $Product -> table . " p ON pp.product_id = p.id WHERE pp.product_id = '" . $product -> id . "' ORDER BY pp.order ASC";
									$related = stripslashes_deep($wpdb -> get_results($relatedquery));
									$this -> render('products' . DS . 'related', array('product' => $product, 'related' => $related, 'products' => $products), true, 'admin');
								} else {
									$message = __('Product cannot be read', $this -> plugin_name);
									$this -> redirect($this -> referer, 'error', $message);
								}
							} else {
								$message = __('No product was specified', $this -> plugin_name);
								$this -> redirect($this -> referer, 'error', $message);
							}
							break;
						case 'duplicate'		:
							if (!empty($_GET['product_id'])) {
								if ($Product -> duplicate($_GET['product_id'])) {
									$msg_type = 'message';
									$message = __('Product has been copied.', $this -> plugin_name);
								} else {
									$msg_type = 'error';
									$message = __('Product could not be copied.', $this -> plugin_name);
								}
							} else {
								$msg_type = 'error';
								$message = __('No product was specified to copy.', $this -> plugin_name);
							}
							
							$this -> redirect($this -> referer, $msg_type, $message);
							break;
						case 'view'				:
							if (!empty($_GET['id'])) {				
								if ($product = $wpcoDb -> find(array('id' => $_GET['id']))) {
									$this -> render('products' . DS . 'view', array('product' => $product));
								} else {
									$message = __('Product cannot be read', $this -> plugin_name);
									$this -> redirect($this -> referer, 'error', $message);
								}
							} else {
								$message = __('No product was specified', $this -> plugin_name);
								$this -> redirect($this -> referer, 'error', $message);
							}
							break;
						case 'save'				:		
							if (!empty($_POST)) {
								if ($Product -> save($_POST, true)) {
									$message = __('Product has been saved.', $this -> plugin_name);									
									if (!empty($_POST['continueediting']) && $_POST['continueediting'] == "1") {
										$this -> redirect('?page=' . $this -> sections -> products_save . '&continueediting=1&id=' . $Product -> insertid, 'message', $message);
									} else {
										$this -> redirect('?page=' . $this -> sections -> products, 'message', $message);
									}
								} else {									
									$this -> render_msg(__('Product cannot be saved.', $this -> plugin_name) . ' (' . count($Product -> errors) . ' ' . __('errors', $this -> plugin_name) . ')');
									$this -> render('products' . DS . 'save');
								}
							} else {
								$wpcoDb -> model = $Product -> model;
								$wpcoDb -> find(array('id' => $_GET['id']));
								$this -> render('products' . DS . 'save');
							}
							break;
						case 'delete'			:
							$wpcoDb -> model = $Product -> model;
							
							if (!empty($_GET['id'])) {
								if ($wpcoDb -> delete($_GET['id'])) {
									$msg_type = 'message';
									$message = __('Product has been removed', $this -> plugin_name);
								} else {
									$msg_type = 'error';
									$message = __('Product cannot be removed', $this -> plugin_name);
								}
							} else {
								$msg_type = 'error';
								$message = __('No product was specified', $this -> plugin_name);
							}
							
							$this -> redirect('?page=' . $this -> sections -> products, $msg_type, $message);
							break;
						case 'mass'				:
							if (!empty($_POST['action'])) {
								if (!empty($_POST['Product']['checklist'])) {
									$products = $_POST['Product']['checklist'];
									
									switch ($_POST['action']) {
										case 'ptypepost'		:
											if ($Product -> mass($_POST['action'], $products)) {
												$msg_type = 'message';
												$message = __('Selected products have been changed to posts.', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('Selected products could not be changed to posts.', $this -> plugin_name);
											}
											break;
										case 'ptypepage'		:
											if ($Product -> mass($_POST['action'], $products)) {
												$msg_type = 'message';
												$message = __('Selected products have been changed to pages.', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('Selected products could not be changed to pages.', $this -> plugin_name);	
											}
											break;
										case 'buynowY'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('buynow', "Y", array('id' => $product_id));	
											}
											
											$msg_type = 'message';
											$message = __('Selected products have been changed to BUY NOW purchase type.', $this -> plugin_name);
											break;
										case 'buynowN'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('buynow', "N", array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Selected products have been changed to ADD TO BASKET purchase type.', $this -> plugin_name);
											break;
										case 'inventory'		:
											if (!empty($_POST['Product']['inventory']) || $_POST['Product']['inventory'] == "0") {
												foreach ($products as $product_id) {
													$wpcoDb -> model = $Product -> model;
													$wpcoDb -> save_field('inventory', $_POST['Product']['inventory'], array('id' => $product_id));
												}
												
												$msg_type = 'message';
												$message = __('Inventory of the selected products have been saved', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('Please fill in an inventory unit count', $this -> plugin_name);
											}
											break;
										case 'minorder'			:
											if (!empty($_POST['Product']['min_order']) || $_POST['Product']['min_order'] == "0") {
												foreach ($products as $product_id) {
													$wpcoDb -> model = $Product -> model;
													$wpcoDb -> save_field('min_order', $_POST['Product']['min_order'], array('id' => $product_id));
												}
												
												$msg_type = 'message';
												$message = __('Minimum order quantity of the selected products have been changed.', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('Please fill in a minimum order value.', $this -> plugin_name);
											}
											break;
										case 'addcategories'	:
											if (!empty($_POST['Product']['categories'])) {
												foreach ($products as $product_id) {
													foreach ($_POST['Product']['categories'] as $category_id) {
														$wpcoDb -> model = $wpcoCategoriesProduct -> model;
														$cp = array('product_id' => $product_id, 'category_id' => $category_id);
														$wpcoDb -> save($cp, true);
													}
												}
											} else {
												$msg_type = 'error';
												$message = __('No categories were chosen', $this -> plugin_name);
											}
											break;
										case 'setcategories'	:
											if (!empty($_POST['Product']['categories'])) {								
												foreach ($products as $product_id) {
													$wpcoDb -> model = $wpcoCategoriesProduct -> model;
													$wpcoDb -> delete_all(array('product_id' => $product_id));
												
													foreach ($_POST['Product']['categories'] as $category_id) {
														$wpcoDb -> model = $wpcoCategoriesProduct -> model;
														$cp = array('product_id' => $product_id, 'category_id' => $category_id);
														$wpcoDb -> save($cp, true);
													}
												}
											} else {
												$msg_type = 'error';
												$message = __('No categories were chosen', $this -> plugin_name);
											}
											break;
										case 'addstyles'		:
											if (!empty($_POST['Product']['styles'])) {
												foreach ($products as $product_id) {
													foreach ($_POST['Product']['styles'] as $style_id) {										
														if (!empty($_POST['Product']['options'][$style_id])) {
															$ps = array('product_id' => $product_id, 'style_id' => $style_id);
															$ProductsStyle -> save($ps);
														
															foreach ($_POST['Product']['options'][$style_id] as $option_id) {
																$po = array('product_id' => $product_id, 'option_id' => $option_id);
																$ProductsOption -> save($po);
															}
														}
													}
												}
												
												$msg_type = 'message';
												$message = __('The chosen styles (and options) have been associated with the selected products', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('No product styles were chosen', $this -> plugin_name);
											}
											break;
										case 'setstyles'		:
											if (!empty($_POST['Product']['styles'])) {
												foreach ($products as $product_id) {
													$ProductsStyle -> delete_all(array('product_id' => $product_id));
													$ProductsOption -> delete_all(array('product_id' => $product_id));
												
													foreach ($_POST['Product']['styles'] as $style_id) {
														if (!empty($_POST['Product']['options'][$style_id])) {
															$ps = array('product_id' => $product_id, 'style_id' => $style_id);
															$ProductsStyle -> save($ps);
														
															foreach ($_POST['Product']['options'][$style_id] as $option_id) {
																$po = array('product_id' => $product_id, 'option_id' => $option_id);
																$ProductsOption -> save($po);
															}
														}
													}
												}
												
												$msg_type = 'message';
												$message = __('The chosen styles (and options) have been associated with the selected products. Previous associations were removed', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('No product styles were chosen', $this -> plugin_name);
											}
											break;
										case 'showcasemsg'		:
											if (!empty($_POST['Product']['showcasemsg'])) {
												foreach ($products as $product_id) {
													$wpcoDb -> model = $Product -> model;
													$wpcoDb -> save_field('showcasemsg', stripslashes($_POST['Product']['showcasemsg']), array('id' => $product_id));
												}
												
												$msg_type = 'message';
												$message = __('Showcase message has been saved on the seleted products.', $this -> plugin_name);
											} else {
												$msg_type = 'message';
												$message = __('Please fill in a showcase message to display.', $this -> plugin_name);	
											}
											break;
										case 'buttontext'		:
											if (!empty($_POST['Product']['buttontext'])) {
												foreach ($products as $product_id) {
													$wpcoDb -> model = $Product -> model;
													$wpcoDb -> save_field('buttontext', stripslashes($_POST['Product']['buttontext']), array('id' => $product_id));
												}
												
												$msg_type = 'message';
												$message = __('Button text has been saved on the seleted products.', $this -> plugin_name);
											} else {
												$msg_type = 'message';
												$message = __('Please fill in the button text to display.', $this -> plugin_name);	
											}
											break;
										case 'showcaseY'		:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('showcase', "Y", array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Selected products set as showcase products.', $this -> plugin_name);
											break;
										case 'showcaseN'		:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('showcase', "N", array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Selected products set as for sale products.', $this -> plugin_name);
											break;
										case 'activate'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('status', 'active', array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Selected products have been activated.', $this -> plugin_name);
											break;
										case 'deactivate'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('status', 'inactive', array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Selected products have been deactivated.', $this -> plugin_name);
											break;
										case 'delete'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> delete($product_id);
											}
											
											$msg_type = 'message';
											$message = __('Selected products removed', $this -> plugin_name);
											break;
										case 'categorize'		:
											if (!empty($_POST['category_id'])) {
												foreach ($products as $product_id) {
													$wpcoDb -> model = $Product -> model;
													$wpcoDb -> save_field('category_id', $_POST['category_id'], array('id' => $product_id));
												}
												
												$msg_type = 'message';
												$message = __('Selected products have been categorized', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('Please select a category to categorize to', $this -> plugin_name);
											}
											break;
										case 'supplier'			:
											if (!empty($_POST['supplier_id'])) {
												foreach ($products as $product_id) {
													$wpcoDb -> model = $Product -> model;
													$wpcoDb -> save_field('supplier_id', $_POST['supplier_id'], array('id' => $product_id));
												}
												
												$msg_type = 'message';
												$message = __('Selected products have been assigned to the supplier', $this -> plugin_name);
											} else {
												$msg_type = 'error';
												$message = __('Please select a supplier', $this -> plugin_name);
											}
											break;
										case 'typed'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('type', "digital", array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Selected products have been changed to DIGITAL', $this -> plugin_name);
											break;
										case 'typet'			:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('type', "tangible", array('id' => $product_id));
											}
										
											$msg_type = 'message';
											$message = __('Selected products have been changed to TANGIBLE', $this -> plugin_name);
											break;
										case 'price_increase'	:
											if (!empty($_POST['price_incdec_val'])) {
												if (!empty($_POST['price_incdec_type'])) {
													$price_value = $_POST['price_incdec_val'];
													$price_type = $_POST['price_incdec_type'];
													
													foreach ($products as $product_id) {
														$new_price = 0;
														$old_price = 0;
														$wpcoDb -> model = $Product -> model;
														
														if ($product = $wpcoDb -> find(array('id' => $product_id))) {																				 
															switch ($product -> price_type) {
																case 'fixed'					:
																	if ($price_type == "fixed") {
																		$old_price = $product -> price;
																		$new_price = ($product -> price + $price_value);	
																	} elseif ($price_type == "percentage") {
																		$old_price = $product -> price;
																		$new_price = ($product -> price + (($product -> price * $price_value) / 100));
																	}
																	break;
																case 'tiers'					:
																	$price = @unserialize($product -> price);
																
																	if ($price_type == "fixed") {
																		$t = 1;
																		$new_price = array();
																		
																		foreach ($price as $key => $tier) {
																			$price[$key]['price'] = ((float) $price[$key]['price'] + $price_value);	
																			
																			if ($t == count($price)) {
																				$old_price = $tier['price'];	
																			}
																			
																			$t++;
																		}
																	} elseif ($price_type == "percentage") {
																		$t = 1;
																		$new_price = array();
																		
																		foreach ($price as $key => $tier) {
																			$price[$key]['price'] = ((float) $price[$key]['price'] + (($price[$key]['price'] * $price_value) / 100));	
																			
																			if ($t == count($price)) {
																				$old_price = $tier['price'];	
																			}
																			
																			$t++;
																		}
																	}
																	
																	$new_price = serialize($price);
																	break;
															}
														}
														
														$wpcoDb -> model = $Product -> model;
														$wpcoDb -> save_field('price', $new_price, array('id' => $product_id));
														
														if (!empty($_POST['price_incdec_sprice'])) {
															if (!empty($old_price)) {
																$wpcoDb -> model = $Product -> model;
																$wpcoDb -> save_field('sprice', $old_price, array('id' => $product_id));
															}
														}
													}
													
													$msg_type = 'message';
													$message = __('Prices have been increased for the selected products as specified.', $this -> plugin_name);
												} else {
													$msg_type = 'error';
													$message = __('Please fill in a value for increasing.', $this -> plugin_name);
												}
											} else {
												$msg_type = 'error';
												$message = __('Please select a fixed amount or percent.', $this -> plugin_name);
											}
											break;
										case 'price_decrease'	:
											if (!empty($_POST['price_incdec_val'])) {
												if (!empty($_POST['price_incdec_type'])) {
													$price_value = $_POST['price_incdec_val'];
													$price_type = $_POST['price_incdec_type'];
													
													foreach ($products as $product_id) {
														$new_price = 0;
														$old_price = 0;
														$wpcoDb -> model = $Product -> model;
														
														if ($product = $wpcoDb -> find(array('id' => $product_id))) {																				 
															switch ($product -> price_type) {
																case 'fixed'					:
																	if ($price_type == "fixed") {
																		$old_price = $product -> price;
																		$new_price = ($product -> price - $price_value);	
																	} elseif ($price_type == "percentage") {
																		$old_price = $product -> price;
																		$new_price = ($product -> price - (($product -> price * $price_value) / 100));
																	}
																	break;
																case 'tiers'					:
																	$price = @unserialize($product -> price);
																
																	if ($price_type == "fixed") {
																		$t = 1;
																		$new_price = array();
																		
																		foreach ($price as $key => $tier) {
																			$price[$key]['price'] = ((float) $price[$key]['price'] - $price_value);	
																			
																			if ($t == count($price)) {
																				$old_price = $tier['price'];	
																			}
																			
																			$t++;
																		}
																	} elseif ($price_type == "percentage") {
																		$t = 1;
																		$new_price = array();
																		
																		foreach ($price as $key => $tier) {
																			$price[$key]['price'] = ((float) $price[$key]['price'] - (($price[$key]['price'] * $price_value) / 100));	
																			
																			if ($t == count($price)) {
																				$old_price = $tier['price'];	
																			}
																			
																			$t++;
																		}
																	}
																	
																	$new_price = serialize($price);
																	break;
															}
														}
														
														$wpcoDb -> model = $Product -> model;
														$wpcoDb -> save_field('price', $new_price, array('id' => $product_id));
														
														if (!empty($_POST['price_incdec_sprice'])) {
															if (!empty($old_price)) {
																$wpcoDb -> model = $Product -> model;
																$wpcoDb -> save_field('sprice', $old_price, array('id' => $product_id));
															}
														}
													}
													
													$msg_type = 'message';
													$message = __('Prices have been decreased for the selected products as specified.', $this -> plugin_name);
												} else {
													$msg_type = 'error';
													$message = __('Please fill in a value for decreasing.', $this -> plugin_name);
												}
											} else {
												$msg_type = 'error';
												$message = __('Please select fixed amount or percent.', $this -> plugin_name);
											}
											break;
										case 'clear_sprice'		:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('sprice', "0", array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Retail/Suggested price has been removed from the selected products.', $this -> plugin_name);
											break;
										case 'vtaxprice'		:
											foreach ($products as $product_id) {
												$wpcoDb -> model = $Product -> model;
												$wpcoDb -> save_field('vtax', $_POST['vtax'], array('id' => $product_id));
											}
											
											$msg_type = 'message';
											$message = __('Variations tax calculation has been updated for the selected products.', $this -> plugin_name);
											break;
										default					:
											$msg_type = 'error';
											$message = __('That is an invalid action', $this -> plugin_name);
											break;
									}
								} else {
									$msg_type = 'error';
									$message = __('No products were selected', $this -> plugin_name);
								}
							} else {
								$msg_type = 'error';
								$message = __('No action was specified', $this -> plugin_name);
							}
							
							$this -> redirect($this -> referer, $msg_type, $message);
							break;
						default					:
							$perpage = (isset($_COOKIE[$this -> pre . 'productsperpage'])) ? $_COOKIE[$this -> pre . 'productsperpage'] : 10;
							$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
							$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
							
							if (!empty($_POST['searchterm'])) {
								$this -> redirect($wpcoHtml -> retainquery('page=checkout-products&' . $this -> pre . 'searchterm=' . urlencode($searchterm), $this -> url, false));
							}
							
							$filters = array();
							$filters['status'] = (isset($_COOKIE[$this -> pre . 'filter_status'])) ? $_COOKIE[$this -> pre . 'filter_status'] : false;
							$filters['status'] = (!empty($_POST['filter_status'])) ? $_POST['filter_status'] : $filters['status'];
							$filters['type'] = (!empty($_COOKIE[$this -> pre . 'filter_type'])) ? $_COOKIE[$this -> pre . 'filter_type'] : false;
							$filters['type'] = (!empty($_POST['filter_type'])) ? $_POST['filter_type'] : $filters['type'];
							$filters['price_type'] = (isset($_COOKIE[$this -> pre . 'filter_price_type'])) ? $_COOKIE[$this -> pre . 'filter_price_type'] : false;
							$filters['price_type'] = (!empty($_POST['filter_price_type'])) ? $_POST['filter_price_type'] : $filters['price_type'];
							$filters['p_type'] = (isset($_COOKIE[$this -> pre . 'filter_p_type'])) ? $_COOKIE[$this -> pre . 'filter_p_type'] : false;
							$filters['p_type'] = (!empty($_POST['filter_p_type'])) ? $_POST['filter_p_type'] : $filters['p_type'];
							
							$conditions = (!empty($searchterm)) ? array('(title' => "LIKE '%" . $searchterm . "%' OR code LIKE '%" . $searchterm . "%' OR keywords LIKE '%" . $searchterm . "%')") : false;
							
							if (!empty($filters)) {								
								$emptyfilters = true;
							
								foreach ($filters as $filter_field => $filter_value) {
									if (!empty($filter_field) && !empty($filter_value)) {
										$conditions[$filter_field] = $filter_value;	
										$emptyfilters = false;
									}
								}
								
								if (!$emptyfilters) { $this -> render_msg(__('You are currently using some of the filters below.', $this -> plugin_name)); };
							}
							
							$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
							$odir = strtoupper((empty($_GET['order'])) ? 'DESC' : $_GET['order']);
							$order = array($ofield, $odir);
							$data = $this -> paginate($Product -> model, "*", $this -> sections -> products, $conditions, $searchterm, $perpage, $order);
							$this -> render('products' . DS . 'index', array('filters' => $filters, 'products' => $data[$Product -> model], 'paginate' => $data['Paginate']));
							break;
					}
					//end administrator
				}
			} else {
				$this -> render_err(__('Unfortunately you do not have the required permissions to access products', $this -> plugin_name));	
			}
		}
		
		function admin_content() {
			global $wpcoDb, $wpcoContent;
			$wpcoDb -> model = $wpcoContent -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-content\-/si", "", $_GET['page']) : $_GET['method'];
		
			switch ($method) {
				case 'save'				:
					if (!empty($_POST[$wpcoContent -> model])) {
						$_POST[$wpcoContent -> model]['content'] = stripslashes($_POST['content']);
					
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Content has been saved', $this -> plugin_name);
							$this -> redirect("?page=checkout-content", 'message', $message);
						} else {
							$message = __('Content cannot be saved', $this -> plugin_name);
							$this -> render_err($message);
							$this -> render('content' . DS . 'save', false, true, 'admin');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('content' . DS . 'save', false, true, 'admin');
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Content has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Content cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No content was specified', $this -> plugin_name);
					}
					
					$this -> redirect("?page=checkout-content", $msg_type, $message);
					break;
				case 'mass'				:
					if (!empty($_POST[$wpcoContent -> model]['checklist'])) {
						if (!empty($_POST['action'])) {
							$contents = $_POST[$wpcoContent -> model]['checklist'];
						
							switch ($_POST['action']) {
								case 'delete'					:
									foreach ($contents as $content_id) {
										$wpcoDb -> model = $wpcoContent -> model;
										$wpcoDb -> delete($content_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected contents have been removed', $this -> plugin_name);
									break;
								case 'setproduct'				:
									if (!empty($_POST['product'])) {
										foreach ($contents as $content_id) {
											$wpcoDb -> model = $wpcoContent -> model;
											$wpcoDb -> save_field('product_id', $_POST['product'], array('id' => $content_id));
										}
										
										$msg_type = 'message';
										$message = __('Selected contents have been assigned to the specified product', $this -> plugin_name);
									} else {
										$msg_type = 'error';
										$message = __('No product was specified', $this -> plugin_name);
									}
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No action was selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No contents were selected', $this -> plugin_name);
					}
					
					$this -> redirect("?page=checkout-content", $msg_type, $message);
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'contentsperpage'])) ? $_COOKIE[$this -> pre . 'contentsperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect('?page=checkout-content&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%'") : false;
					$data = $this -> paginate($wpcoContent -> model, "*", $this -> sections -> content, $conditions, $searchterm, $perpage);
					$this -> render('content' . DS . 'index', array('contents' => $data[$wpcoContent -> model], 'paginate' => $data['Paginate']), true, 'admin');
					break;	
			}
		}
		
		function admin_files() {
			global $wpcoDb, $File;
			$wpcoDb -> model = $File -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-files\-/si", "", $_GET['page']) : $_GET['method'];
		
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('File has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$this -> render_err(__('File cannot be saved', $this -> plugin_name));
							$this -> render('files' . DS . 'save');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('files' . DS . 'save');
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('File has been deleted', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('File cannot be deleted', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No file was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'mass'				:
					if (!empty($_POST['action'])) {
						if (!empty($_POST['File']['checklist'])) {
							$files = $_POST['File']['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'			:
									foreach ($files as $file_id) {
										$wpcoDb -> model = $File -> model;
										$wpcoDb -> delete($file_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected files have been removed', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No files were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was selected', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'filesperpage'])) ? $_COOKIE[$this -> pre . 'filesperpage'] : 5;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%' OR `filename` LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($File -> model, "*", $this -> sections -> files, $conditions, $searchterm, $perpage, $order);
					$this -> render('files' . DS . 'index', array('files' => $data[$File -> model], 'paginate' => $data['Paginate']));
					break;
			}
		}
		
		function admin_images() {
			global $wpcoDb, $Image;
			$wpcoDb -> model = $Image -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-images\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {
						if ($Image -> save($_POST, true)) {
							$message = __('Image has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$this -> render_err(__('Image cannot be saved', $this -> plugin_name));
							$this -> render('images' . DS . 'save');
						}
					} else {
						$Image -> get($_GET['id']);
						$this -> render('images' . DS . 'save');
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Image has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Image could not be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No image was specified', $this -> plugin_name);
					}
					
					$this -> redirect('?page=' . $this -> sections -> images, $msg_type, $message);
					break;
				case 'mass'				:
					if (!empty($_POST['action'])) {
						if (!empty($_POST['Image']['checklist'])) {
							$images = $_POST['Image']['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'				:
									$wpcoDb -> model = $Image -> model;
								
									foreach ($images as $image_id) {
										$wpcoDb -> delete($image_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected images have been removed', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No images were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'imagesperpage'])) ? $_COOKIE[$this -> pre . 'imagesperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%' OR `filename` LIKE '%" . $searchterm . "%'") : false;
					$data = $this -> paginate($Image -> model, "*", $this -> sections -> images, $conditions, $searchterm, $perpage);
					$this -> render('images' . DS . 'index', array('images' => $data[$Image -> model], 'paginate' => $data['Paginate']));
					break;
			}
		}
		
		function admin_suppliers() {
			global $wpdb, $wpcoDb, $Supplier, $Product, $wpcoCategoriesProduct;
			$wpcoDb -> model = $Supplier -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-suppliers\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {							
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Supplier has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$message = __('Supplier cannot be saved', $this -> plugin_name);
							$this -> render_err($message);
							$this -> render('suppliers' . DS . 'save', false, true, 'admin');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('suppliers' . DS . 'save', false, true, 'admin');
					}
					break;
				case 'view'				:
					if (!empty($_GET['id'])) {
						$wpcoDb -> model = $Supplier -> model;
						if ($supplier = $wpcoDb -> find(array('id' => $_GET['id']))) {
							$conditions = array('supplier_id' => $supplier -> id);
							$perpage = (isset($_COOKIE[$this -> pre . 'productsperpage'])) ? $_COOKIE[$this -> pre . 'productsperpage'] : 10;
							$order = array($wpdb -> prefix . $Product -> table . '.modified', "DESC");
							$data = $this -> paginate($Product -> model, "*", $this -> sections -> suppliers . '&amp;method=view&amp;id=' . $supplier -> id, $conditions, $searchterm, $perpage, $order);
							$this -> render('suppliers' . DS . 'view', array('supplier' => $supplier, 'products' => $data[$Product -> model], 'paginate' => $data['Paginate']), true, 'admin');
						} else {
							$this -> redirect($this -> referer, 'error', __('Supplier could not be read.', $this -> plugin_name));
						}
					} else {
						$this -> redirect($this -> referer, 'error', __('No supplier was specified.', $this -> plugin_name));
					}
					break;
				case 'order'			:
					$wpcoDb -> model = $Supplier -> model;
					$suppliers = $wpcoDb -> find_all(false, array('id', 'name', 'order'), array('order', "ASC"));
					$this -> render('suppliers' . DS . 'order', array('suppliers' => $suppliers), true, 'admin');
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Supplier has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Supplier cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No supplier was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'mass'				:
					if (!empty($_POST['Supplier']['checklist'])) {
						if (!empty($_POST['action'])) {
							$suppliers = $_POST['Supplier']['checklist'];
						
							switch ($_POST['action']) {
								case 'delete'				:
									foreach ($suppliers as $supplier_id) {
										$wpcoDb -> model = $Supplier -> model;
										$wpcoDb -> delete($supplier_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected suppliers have been removed', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No action was selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No suppliers were selected', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'suppliersperpage'])) ? $_COOKIE[$this -> pre . 'suppliersperpage'] : 15;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('name' => "LIKE '%" . $searchterm . "%' OR `email` LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($Supplier -> model, "*", $this -> sections -> suppliers, $conditions, $searchterm, $perpage, $order);
					$this -> render('suppliers' . DS . 'index', array('suppliers' => $data[$Supplier -> model], 'paginate' => $data['Paginate']), true, 'admin');
					break;
			}
		}
		
		function admin_styles() {
			global $wpcoDb, $Style, $Option;
			$wpcoDb -> model = $Style -> model;
		
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-styles\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {
						if ($Style -> save($_POST)) {
							$message = __('Variation has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$this -> render_err(__('Variation cannot be saved', $this -> plugin_name));
							$this -> render('styles' . DS . 'save');
						}
					} else {
						$Style -> get($_GET['id']);
						$this -> render('styles' . DS . 'save');
					}
					break;
				case 'view'				:
					if (!empty($_GET['id'])) {
						if ($style = $Style -> get($_GET['id'])) {
							$data = $this -> paginate($Option -> model, false, $this -> sections -> styles, array('style_id' => $style -> id));
							$this -> render('styles' . DS . 'view', array('style' => $style, 'options' => $data[$Option -> model], 'paginate' => $data['Paginate']));
						} else {
							$message = __('Variation cannot be read', $this -> plugin_name);
							$this -> redirect($this -> url, 'error', $message);
						}
					} else {
						$message = __('No variation was specified', $this -> plugin_name);
						$this -> redirect($this -> url, 'error', $message);
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Variation has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Variation could not be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No variation was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'sort'				:			
					global $wpdb, $wpcoDb, $Style, $Option;
					$wpcoDb -> model = $Style -> model;
					$style = $wpcoDb -> find_all();
					$this -> render('styles' . DS . 'sort', array('style' => $style), true, 'admin');
					break;
				case 'order'			:
					global $wpdb, $wpcoDb, $Style, $Option;
					$wpcoDb -> model = $Style -> model;				
					if (!empty($_GET['id']) && $style = $wpcoDb -> find(array('id' => $_GET['id']))) {
						$wpcoDb -> model = $Option -> model;
						$options = $wpcoDb -> find_all(array('style_id' => $style -> id), false, array('order', "ASC"));
						$this -> render('styles' . DS . 'order', array('style' => $style, 'options' => $options), true, 'admin');
					} else {
						$this -> redirect($this -> referer, 'error', __('Variation cannot be read.', $this -> plugin_name));	
					}				
					break;
				case 'mass'				:			
					if (!empty($_POST['action'])) {
						if (!empty($_POST[$Style -> model]['checklist'])) {
							$styles = $_POST[$Style -> model]['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'				:
									foreach ($styles as $style_id) {
										$wpcoDb -> model = $Style -> model;
										$wpcoDb -> delete($style_id);
									}
									
									$msg_type = 'message';
									$message = __('Variations have been removed', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No variations were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was selected', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'stylesperpage'])) ? $_COOKIE[$this -> pre . 'stylesperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($Style -> model, "*", $this -> sections -> styles, $conditions, $searchterm, $perpage, $order);
					$this -> render('styles' . DS . 'index', array('styles' => $data[$Style -> model], 'paginate' => $data['Paginate']));
					break;
			}
		}
		
		function admin_options() {
			global $wpcoDb, $Option;		
			$wpcoDb -> model = $Option -> model;
		
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-options\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Option has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$this -> render_msg(__('Option cannot be saved', $this -> plugin_name));
							$this -> render('options' . DS . 'save');
						}
					} else {				
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('options' . DS . 'save');
					}
					break;
				case 'delete'				:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Style option has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Style option cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No style option was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'mass'				:
					if (!empty($_POST['action'])) {
						if (!empty($_POST[$Option -> model]['checklist'])) {
							$options = $_POST[$Option -> model]['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'			:
									foreach ($options as $option_id) {
										$wpcoDb -> model = $Option -> model;
										$wpcoDb -> delete($option_id);
									}	
									
									$msg_type = 'message';
									$message = __('Selected options have been removed', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No options were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				default					:
					$perpage = (isset($_COOKIE[$this -> pre . 'optionsperpage'])) ? $_COOKIE[$this -> pre . 'optionsperpage'] : 15;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($Option -> model, "*", $this -> sections -> options, $conditions, $searchterm, $perpage, $order);
					$this -> render('options' . DS . 'index', array('options' => $data[$Option -> model], 'paginate' => $data['Paginate']));
					break;
			}
		}
		
		function admin_fields() {
			global $wpcoDb, $wpcoField;
			$wpcoDb -> model = $wpcoField -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-fields\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'					:				
					if (!empty($_POST[$wpcoField -> model])) {
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Custom field has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$message = __('Custom field cannot be saved', $this -> plugin_name);
							$this -> render_err($message);
							$this -> render('fields' . DS . 'save', false, true, 'admin');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('fields' . DS . 'save', false, true, 'admin');
					}
					break;
				case 'delete'				:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Custom field has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Custom field cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No custom field was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'order'				:
					$fields = $wpcoDb -> find_all(null, array('id', 'title', 'order'), array('order', "ASC"));
					$this -> render('fields' . DS . 'order', array('fields' => $fields), true, 'admin');
					break;
				case 'mass'					:
					if (!empty($_POST)) {
						if (!empty($_POST['wpcoField']['checklist'])) {
							if (!empty($_POST['action'])) {
								$fields = $_POST['wpcoField']['checklist'];
							
								switch ($_POST['action']) {
									case 'delete'				:
										foreach ($fields as $field_id) {
											$wpcoDb -> model = $wpcoField -> model;
											$wpcoDb -> delete($field_id);
										}
										
										$msg_type = 'message';
										$message = __('Selected custom fields have been removed', $this -> plugin_name);
										break;
									case 'required'				:
										foreach ($fields as $field_id) {
											$wpcoDb -> model = $wpcoField -> model;
											$wpcoDb -> save_field('required', "Y", array('id' => $field_id));
										}
										
										$msg_type = 'message';
										$message = __('Selected custom fields have been set as required', $this -> plugin_name);
										break;
									case 'notrequired'			:
										foreach ($fields as $field_id) {
											$wpcoDb -> model = $wpcoField -> model;
											$wpcoDb -> save_field('required', "N", array('id' => $field_id));
										}
										
										$msg_type = 'message';
										$message = __('Selected custom fiels have been set as not required', $this -> plugin_name);
										break;
									case 'globalf'				:
										$globalp = "cart";
										if (!empty($_POST['wpcoField']['globalp'])) { $globalp = $_POST['wpcoField']['globalp']; }
									
										foreach ($fields as $field_id) {
											$wpcoDb -> model = $wpcoField -> model;
											$wpcoDb -> save_field('globalf', "Y", array('id' => $field_id));
											$wpcoDb -> model = $wpcoField -> model;
											$wpcoDb -> save_field('globalp', $globalp, array('id' => $field_id));
										}
										
										$msg_type = 'message';
										$message = __('Selected custom fields have been set as global order options', $this -> plugin_name);
										break;
									case 'notglobalf'			:
										foreach ($fields as $field_id) {
											$wpcoDb -> model = $wpcoField -> model;
											$wpcoDb -> save_field('globalf', "N", array('id' => $field_id));
										}
										
										$msg_type = 'message';
										$message = __('Selected custom fields have been removed from global order options', $this -> plugin_name);
										break;
								}
							} else {
								$msg_type = 'error';
								$message = __('No action was specified', $this -> plugin_name);
							}
						} else {
							$msg_type = 'error';
							$message = __('No custom fields were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No data was posted', $this -> plugin_name);
					}
					
					$this -> redirect($_SERVER['HTTP_REFERER'], $msg_type, $message);
					break;
				default						:
					$perpage = (isset($_COOKIE[$this -> pre . 'fieldsperpage'])) ? $_COOKIE[$this -> pre . 'fieldsperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($wpcoField -> model, "*", $this -> sections -> fields, $conditions, $searchterm, $perpage, $order);
					$this -> render('fields' . DS . 'index', array('fields' => $data[$wpcoField -> model], 'paginate' => $data['Paginate']), true, 'admin');
					break;
			}
		}
		
		function admin_coupons() {
			global $wpdb, $wpcoDb, $Coupon;		
			$wpcoDb -> model = $Coupon -> model;
		
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-coupons\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {					
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Coupon code has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$this -> render_err(__('Coupon cannot be saved', $this -> plugin_name));
							$this -> render('coupons' . DS . 'save');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('coupons' . DS . 'save');
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Coupon has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Coupon cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No coupon was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'bulk'				:
					if (!empty($_POST)) {
						$errors = array();
						
						if (!empty($_POST['Coupon']['numbertogenerate']) && is_numeric($_POST['Coupon']['numbertogenerate'])) {
							$code = strtoupper(md5(microtime()));
							$data = $_POST['Coupon'];
							$data['code'] = $data['title'] = $code;
							$c = 1;
							
							$errors = $Coupon -> validate($data);
							
							if (empty($errors)) {
								while ($c <= ((int) $_POST['Coupon']['numbertogenerate'])) {
									$data['code'] = $data['title'] = strtoupper(md5(microtime()));
									$wpcoDb -> model = $Coupon -> model;
									$wpcoDb -> save($data, false);							
									$Coupon -> id = false;
									$Coupon -> data -> id = false;		
									
									$c++;
								}
							}
						} else {
							$errors['numbertogenerate'] = __('Please fill in the number of coupons to generate.', $this -> plugin_name);	
						}
						
						if (!empty($errors)) {
							$Coupon -> errors = $errors;
							$this -> render('coupons' . DS . 'bulk', array('errors' => $errors), true, 'admin');
						} else {
							$message = __('Bulk coupons have been generated.', $this -> plugin_name);
							$this -> redirect('?page=' . $this -> sections -> coupons, 'message', $message);	
						}
					} else {
						$this -> render('coupons' . DS . 'bulk', false, true, 'admin');	
					}
					break;
				case 'mass'				:				
					if (!empty($_POST['export'])) {
						$query = "SELECT * FROM " . $wpdb -> prefix . $Coupon -> table . "";
				
						if (!empty($_POST['Coupon']['checklist'])) {
							$query .= " WHERE";
							$c = 1;
							
							foreach ($_POST['Coupon']['checklist'] as $coupon_id) {
								$query .= " id = '" . $coupon_id . "'";
								
								if ($c < count($_POST['Coupon']['checklist'])) {
									$query .= " OR";	
								}
								
								$c++;
							}
							
							if ($coupons = $wpdb -> get_results($query)) {
								$csvdata = "";
								$csvdata .= '"' . __('Title', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Code', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Discount Type', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Discount', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Status', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Expiry', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Max Use', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Used', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Created', $this -> plugin_name) . '",';
								$csvdata .= '"' . __('Modified', $this -> plugin_name) . '",';
								$csvdata .= "\r\n";
								
								foreach ($coupons as $coupon) {
									$csvdata .= '"' . $coupon -> title . '",';
									$csvdata .= '"' . $coupon -> code . '",';
									$csvdata .= '"' . apply_filters($this -> pre . '_coupon_discount_text', (($coupon -> discount_type == "fixed") ? __('Price', $this -> plugin_name) : __('Percentage', $this -> plugin_name)), $coupon) . '",';
									$csvdata .= '"' . apply_filters($this -> pre . '_coupon_discount', ($coupon -> discount), $coupon) . '",';
									$csvdata .= '"' . (($coupon -> active == "Y") ? __('Active', $this -> plugin_name) : __('Inactive', $this -> plugin_name)) . '",';
									$csvdata .= '"' . ($coupon -> expiry) . '",';
									$csvdata .= '"' . ($coupon -> maxuse) . '",';
									$csvdata .= '"' . ($coupon -> used) . '",';
									$csvdata .= '"' . ($coupon -> created) . '",';
									$csvdata .= '"' . ($coupon -> modified) . '",';
									$csvdata .= "\r\n";
								}
								
								if (!empty($csvdata)) {
									$path = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS;
									$file = 'coupons' . time() . '.csv';
									$full = $path . $file;
									
									if (file_exists($full)) { @unlink($full); }
									
									if ($fh = fopen($full, "w")) {
										fwrite($fh, $csvdata);
										fclose($fh);
										
										$url = WP_CONTENT_URL . DS . 'uploads' . DS . $this -> plugin_name . DS . $file;
										
										$msg_type = 'message';
										$message = sprintf(__('Export successful. %s', $this -> plugin_name), '<a href="' . $url . '">' . __('Download CSV', $this -> plugin_name) . '</a>');
									} else {
										$msg_type = 'error';
										$message = __('CSV file cannot be created, please make sure "wp-content/uploads/wp-checkout/" is writable.', $this -> plugin_name);
									}
								} else {
									$msg_type = 'error';
									$message = __('No CSV data is available to write to file.', $this -> plugin_name);
								}
							} else {
								$msg_type = 'error';
								$message = __('No coupon codes could be found in the database.', $this -> plugin_name);	
							}
						} else {
							$msg_type = 'error';
							$message = __('No coupon codes were selected, please tick/check some.', $this -> plugin_name);	
						}
						
						$this -> redirect('?page=' . $this -> sections -> coupons, $msg_type, $message);
					} else {
						if (!empty($_POST['action'])) {
							if (!empty($_POST['Coupon']['checklist'])) {
								$coupons = $_POST['Coupon']['checklist'];
								
								switch ($_POST['action']) {
									case 'delete'				:
										foreach ($coupons as $coupon_id) {
											$wpcoDb -> model = $Coupon -> model;
											$wpcoDb -> delete($coupon_id);
										}
										
										$msg_type = 'message';
										$message = __('Selected coupons have been removed', $this -> plugin_name);
										break;
								}
							} else {
								$msg_type = 'error';
								$message = __('No coupons were selected', $this -> plugin_name);
							}
						} else {
							$msg_type = 'error';
							$message = __('No action was selected', $this -> plugin_name);
						}
						
						$this -> redirect($this -> url, $msg_type, $message);
					}
					break;
				default					:
					if ($this -> get_option('enablecoupons') == "N") {
						$message = __('Discount coupons is turned off in the plugin. Please turn it on in the configuration.', $this -> plugin_name);
						$this -> render_err($message);
					}
				
					$perpage = (isset($_COOKIE[$this -> pre . 'couponsperpage'])) ? $_COOKIE[$this -> pre . 'couponsperpage'] : 15;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('title' => "LIKE '%" . $searchterm . "%' OR `code` LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($Coupon -> model, "*", $this -> sections -> coupons, $conditions, $searchterm, $perpage, $order);
					$this -> render('coupons' . DS . 'index', array('coupons' => $data[$Coupon -> model], 'paginate' => $data['Paginate']));
					break;
			}
		}
		
		function admin_orders() {
			global $wpdb, $wpcoDb, $Order, $Item;
			$wpcoDb -> model = $Order -> model;
		
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-orders\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'capture'				:
					if (!empty($_GET['id'])) {
						$wpcoDb -> model = $Order -> model;
						if ($order = $wpcoDb -> find(array('id' => $_GET['id']))) {
							if (!empty($order -> pmethod)) {
								switch ($order -> pmethod) {
									case 'pp_pro'					:
										$pp_pro_paymenttype = $this -> get_option('pp_pro_paymenttype');
										if (!empty($pp_pro_paymenttype) && $pp_pro_paymenttype == "authcapture") {
											if (empty($order -> paid) || $order -> paid == "N") {
												if (!empty($order -> transid)) {
													if (!empty($order -> transstatus) && $order -> transstatus == "authorized") {
														$api_username = $this -> get_option('pp_pro_api_username');
														$api_password = $this -> get_option('pp_pro_api_password');
														$api_signature = $this -> get_option('pp_pro_api_signature');
														$api_endpoint = $this -> get_option('pp_pro_api_endpoint');
														$methodToCall = "DoCapture";
														$authorizationid = $order -> transid;
														$amt = $order -> total;
														$completetype = "Complete";
														
														$nvpstr = "";
														$nvpstr .= "&AUTHORIZATIONID=" . urlencode($authorizationid);
														$nvpstr .= "&AMT=" . urlencode($amt);
														$nvpstr .= "&COMPLETETYPE=" . urlencode($completetype);
														
														require_once $this -> plugin_base() . DS . 'vendors' . DS . 'gateways' . DS . 'class.pp_pro.php';
														$paypalPro = new wpcopp_pro($api_username, $api_password, $api_signature, '', '', false, false, '57.0', $api_endpoint);
														$resArray = $paypalPro -> hash_call($methodToCall, $nvpstr);
														
														if (!empty($resArray)) {
															if (!empty($resArray['ACK']) && $resArray['ACK'] == "Success") {
																$query = "UPDATE `" . $wpdb -> prefix . $Item -> table . "` SET `paid` = 'Y' WHERE `order_id` = '" . $order -> id . "'";
																$wpdb -> query($query);
																$wpcoDb -> model = $Order -> model;
																$wpcoDb -> save_field('transstatus', "captured", array('id' => $order -> id));
															
																$msg_type = 'message';
																$message = __('Charge/capture successful!', $this -> plugin_name);
															} else {
																$msg_type = 'error';
																$message = $resArray['L_ERRORCODE0'] . ' - ' . $resArray['L_SHORTMESSAGE0'] . ' (' . $resArray['L_LONGMESSAGE0'] . ')';
															}
														} else {
															$msg_type = 'error';
															$message = __('No response from PayPal', $this -> plugin_name);
														}		
													} else {
														$msg_type = 'error';
														$message = __('No transaction status or this order may have already been captured', $this -> plugin_name);
													}
												} else {
													$msg_type = 'error';
													$message = __('No transaction/authorization ID is available', $this -> plugin_name);
												}
											} else {
												$msg_type = 'error';
												$message = __('This order may be marked as paid already', $this -> plugin_name);
											}
										} else {
											$msg_type = 'error';
											$message = __('PayPal Pro is not configured to auth and capture at the moment, it is most likely set to Sale', $this -> plugin_name);
										}
										break;
								}
							} else {
								$msg_type = 'error';
								$message = __('No payment method is specified on this order', $this -> plugin_name);
							}
						} else {
							$msg_type = 'error';
							$message = __('Order cannot be read', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				case 'cleanoutdays'			:
					if ($this -> orderscleanoutdays($_POST['orderscleanoutdays'])) {
						$msg_type = 'message';
						$message = __('Uncompleted/abandoned orders cleanout interval has been set.', $this -> plugin_name);
					} else {
						$msg_type = 'error';
						$message = __('Uncompleted/abandoned orders cleanout interval could not be set.', $this -> plugin_name);
					}
					
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				case 'invoice'				:
					$wpcoDb -> model = $Order -> model;
				
					if ($order = $wpcoDb -> find(array('id' => $_GET['id']))) {
						$wpcoDb -> model = $Item -> model;						
						if ($items = $wpcoDb -> find_all(array('order_id' => $order -> id))) {
							$to = $order -> bill_email;
							$subject = __('Order #', $this -> plugin_name) . $order -> id . ' ' .  __('receipt', $this -> plugin_name);
							$message = $this -> render('invoice', array('user' => $userdata, 'order' => $order, 'items' => $items), false, 'email');
							
							if ($this -> send_mail($to, $subject, $message)) {
								$msg_type = 'message';
								$message = __('Order invoice has been sent', $this -> plugin_name);	
							}
						}
					} else {
						$msg_type = 'error';
						$message = __('Order cannot be read', $this -> plugin_name);	
					}
					
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				case 'view'					:
					if (!empty($_GET['id'])) {				
						if ($order = $wpcoDb -> find(array('id' => $_GET['id']))) {
							$perpage = (isset($_COOKIE[$this -> pre . 'itemsperpage'])) ? $_COOKIE[$this -> pre . 'itemsperpage'] : 10;
							$conditions = array('order_id' => $_GET['id']);
							$data = $this -> paginate($Item -> model, '*', $this -> sections -> orders, $conditions, false, $perpage);
							$this -> render('orders' . DS . 'view', array('order' => $order, 'items' => $data[$Item -> model], 'paginate' => $data['Paginate']), true, 'admin');
						} else {
							$message = __('Order cannot be read', $this -> plugin_name);
							$this -> redirect($this -> referer, 'error', $message);
						}
					} else {
						$message = __('No order was specified', $this -> plugin_name);
						$this -> redirect($this -> referer, 'error', $message);
					}
					break;
				case 'save'					:			
					if (!empty($_POST)) {
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Order has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$this -> render('orders' . DS . 'save', false, true, 'admin');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('orders' . DS . 'save', false, true, 'admin');
					}
					break;
				case 'delete'				:
					if (!empty($_GET['id'])) {				
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Order and all order items have been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Order cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'mass'					:
					if (!empty($_POST['action']) || !empty($_POST['export'])) {
						if (!empty($_POST['Order']['checklist'])) {
							$orders = $_POST['Order']['checklist'];
							$action = (empty($_POST['action'])) ? 'export' : $_POST['action'];
							
							switch ($action) {
								case 'delete'				:
									foreach ($orders as $order_id) {
										$wpcoDb -> model = $Order -> model;
										$wpcoDb -> delete($order_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected orders have been removed', $this -> plugin_name);
									break;
								case 'completed'			:
									foreach ($orders as $order_id) {
										$wpcoDb -> model = $Order -> model;
										$wpcoDb -> save_field($field = 'completed', $value = "Y", $conditions = array('id' => $order_id));
										
										//set the order items as shipped
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('completed', "Y", array('order_id' => $order_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected orders (and all their order items) have been set as completed/processed.', $this -> plugin_name);
									break;
								case 'notcompleted'			:
									foreach ($orders as $order_id) {
										$wpcoDb -> model = $Order -> model;
										$wpcoDb -> save_field($field = 'completed', $value = "N", $conditions = array('id' => $order_id));
										
										//set the order items as shipped
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('completed', "N", array('order_id' => $order_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected orders (and all their order items) have been set as NOT completed/processed.', $this -> plugin_name);
									break;
								case 'paid'					:
									foreach ($orders as $order_id) {										
										//set the order items as shipped
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('paid', "Y", array('order_id' => $order_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected orders (and all their order items) have been set as paid', $this -> plugin_name);
									break;
								case 'notpaid'				:
									foreach ($orders as $order_id) {										
										//set the order items as shipped
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('paid', "N", array('order_id' => $order_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected orders (and all their order items) have been set as NOT paid', $this -> plugin_name);
									break;
								case 'shipped'				:
									foreach ($orders as $order_id) {
										//$wpcoDb -> model = $Item -> model;
										//$wpcoDb -> save_field($field = 'shipped', $value = "Y", $conditions = array('order_id' => $order_id));
										
										//set the order items as shipped
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('shipped', "Y", array('order_id' => $order_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected orders (and all their order items) have been set as shipped', $this -> plugin_name);
									break;
								case 'notshipped'			:
									foreach ($orders as $order_id) {										
										//set the order items as shipped
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('shipped', "N", array('order_id' => $order_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected orders (and all their order items) have been set as NOT shipped', $this -> plugin_name);
									break;
								case 'export'				:
									global $wpdb, $wpcoHtml, $wpcoDb, $Order, $wpcoField, $wpcoFieldsOrder, $Country, $Product, $Item, $Style, $Option;
									
									if (!empty($_POST['Order']['checklist'])) {
										$o = 1;
										$ordersquery = "SELECT * FROM `" . $wpdb -> prefix . $Order -> table . "`";
										$ordersquery .= " WHERE (";
										foreach ($_POST['Order']['checklist'] as $order_id) {
											$ordersquery .= "`id` = '" . $order_id . "'";
											if ($o < count($_POST['Order']['checklist'])) { $ordersquery .= " OR "; }
											$o++;
										}
										$ordersquery .= ") ORDER BY `completed_date` DESC";
									
										if ($orders = $wpdb -> get_results($ordersquery)) {
										//if ($orders = $wpcoDb -> find_all(array('completed' => "Y"), false, array('modified', "DESC"))) {
											$data = "";																	//empty $data string type
											$data .= '"' . __('ID', $this -> plugin_name) . '",';						//ID of the order
											$data .= '"' . __('User', $this -> plugin_name) . '",';						//User
											$data .= '"' . __('Payment Method', $this -> plugin_name) . '",';			//Payment Method
											$data .= '"' . __('Shipping Method', $this -> plugin_name) . '",';			//Shipping Method
											$data .= '"' . __('Paid', $this -> plugin_name) . '",';						//Paid status
											$data .= '"' . __('Shipped', $this -> plugin_name) . '",';					//Shipped status
											$data .= '"' . __('Sub total', $this -> plugin_name) . '",';				//Subtotal
											$data .= '"' . __('Discount', $this -> plugin_name) . '",';					//Discount
											$data .= '"' . __('Shipping', $this -> plugin_name) . '",';					//Shipping
											$data .= '"' . __('Tax', $this -> plugin_name) . '",';						//Tax
											$data .= '"' . __('Total', $this -> plugin_name) . '",';					//Total
											$data .= '"' . __('Items', $this -> plugin_name) . '",';
											$data .= '"' . __('Products', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship First Name', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Last Name', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Email', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Company Name', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Phone Number', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Fax Number', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Address', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Address (continued)', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship City', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship State/Province', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Country', $this -> plugin_name) . '",';
											$data .= '"' . __('Ship Zip/Postal Code', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill First Name', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Last Name', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Email', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Company Name', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Phone Number', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Fax Number', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Address', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Address (continued)', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill City', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill State/Province', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Country', $this -> plugin_name) . '",';
											$data .= '"' . __('Bill Zip/Postal Code', $this -> plugin_name) . '",';
											$data .= '"' . __('Created', $this -> plugin_name) . '",';					//Created date
											$data .= '"' . __('Modified', $this -> plugin_name) . '",';					//Modified date
											
											$ofieldsquery = "SELECT * FROM `" . $wpdb -> prefix . $wpcoFieldsOrder -> table . "` GROUP BY `field_id`";
											if ($ofields = $wpdb -> get_results($ofieldsquery)) {
												$f = 1;
												foreach ($ofields as $ofield) {
													$wpcoDb -> model = $wpcoField -> model;
													if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) {
														$data .= '"' . __($field -> title) . '"';
														if ($f < count($ofields)) { $data .= ','; }
														$f++;
													}
												}
											}
											
											$data .= "\r\n";															//end the ROW	
											
											foreach ($orders as $order) {
												$order = $this -> init_class($Order -> model, $order);
											
												if (!empty($order -> user_id)) {
													$userdata = $this -> userdata($order -> user_id);
												}
											
												$data .= '"' . $order -> id . '",';										//ID of the order
												$data .= '"' . $order -> bill_fname . ' ' . $order -> bill_lname . '",';	//User
												$data .= '"' . $wpcoHtml -> pmethod($order -> pmethod) . '",';			//Payment method
												$data .= '"' . ((!empty($order -> shipmethod_name)) ? $order -> shipmethod_name : '') . '",';
												$data .= '"' . ((!empty($order -> paid) && $order -> paid == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name)) . '",';
												
												if (!empty($order -> hastangible) && $order -> hastangible == "Y") {
													$data .= '"' . ((!empty($order -> shipped) && $order -> shipped == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name)) . '",';
												} else {
													$data .= '"' . __('N/A', $this -> plugin_name) . '",';	
												}
												
												$data .= '"' . ( number_format($order -> subtotal, 2, '.', '')) . '",';
												$data .= '"' . ((!empty($order -> discount)) ? number_format($order -> discount, 2, '.', '') : '') . '",';
												$data .= '"' . ((!empty($order -> shipping)) ? number_format($order -> shipping, 2, '.', '') : '') . '",';
												$data .= '"' . ((!empty($order -> tax)) ? number_format($order -> tax, 2, '.', '') : '') . '",';
												$data .= '"' . (number_format($order -> total, 2, '.', '')) . '",';
												$wpcoDb -> model = $Item -> model;
												$data .= '"' . ($wpcoDb -> count(array('order_id' => $order -> id))) . '",';
												
												$wpcoDb -> model = $Item -> model;
												$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
												$i = 1;
												$countvariations = count($items);
												foreach($items as $item) :
													$itemsarray .= '(' . (int) $item -> count . ') ' . apply_filters($this -> pre . '_product_title', $item -> product -> title);
													if ($styles = maybe_unserialize($item -> styles)) :
														$itemsarray .= ' [';
														$s = 1;
														foreach ($styles as $style_id => $option_id) :
															$wpcoDb -> model = $Style -> model;
															if ($style = $wpcoDb -> find(array('id' => $style_id), array('id', 'title'))) :
																if (!empty($option_id) && is_array($option_id)) :
																	$option_ids = $option_id;
																	$itemsarray .= $style -> title;
																	$itemsarray .= ': ';
																	$o = 1;
																	foreach ($option_ids as $option_id) :
																		$wpcoDb -> model = $Option -> model;														
																		if ($option = $wpcoDb -> find($conditions = array('id' => $option_id), $fields = array('id', 'title', 'addprice', 'price', 'operator', 'symbol'), array('id', "DESC"), $assign = true)) :
																			$itemsarray .= $option -> title; echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, true, $option -> operator) . ')' : '';
																			$itemsarray .= ($o < count($option_ids)) ? ', ' : '';
																		endif;
																		$o++;
																	endforeach;
																else :
																	$wpcoDb -> model = $Option -> model;
																	$option = $wpcoDb -> find(array('id' => $option_id), false, array('id', "DESC"), $assign = true, $atts = array('otheroptions' => $styles));
																	$itemsarray .= $style -> title;
																	$itemsarray .= ': ';
																	$itemsarray .= $option -> title;
																endif;
															endif;
															if ($s < count($styles)) { $itemsarray .= ", "; }
															$s++;
														endforeach;
														$itemsarray .= "]";
													endif;
													if (!empty($item -> product -> cfields)) {
														$itemsarray .= "[";
														$c = 1;
														foreach ($item -> product -> cfields as $field_id) {
															$wpcoDb -> model = $wpcoField -> model;
															if ($field = $wpcoDb -> find(array('id' => $field_id))) {
																$itemsarray .= __($field -> title);
																$itemsarray .= ': ';
																$itemsarray .= $wpcoField -> get_value($field_id, $item -> {$field -> slug}, true);
																if ($c < count($item -> product -> cfields)) { $itemsarray .= ", "; }
																$c++;
															}
														}
														$itemsarray .= "]";
													}
													if($i < $countvariations) {
														$itemsarray .= "; ";
													}								
													$i++;
												endforeach;
												$data .= '"' . $itemsarray . '",';
												unset($itemsarray);
												
												//Shipping info
												$data .= '"' . ($order -> ship_fname) . '",';
												$data .= '"' . ($order -> ship_lname) . '",';
												$data .= '"' . ((empty($order -> ship_email)) ? $userdata -> user_email : $order -> ship_email) . '",';
												$data .= '"' . ($order -> ship_company) . '",';
												$data .= '"' . ($order -> ship_phone) . '",';
												$data .= '"' . ($order -> ship_fax) . '",';
												$data .= '"' . ($order -> ship_address) . '",';
												$data .= '"' . ($order -> ship_address2) . '",';
												//$data .= '"' . ($order -> ship_fax) . '",';
												$data .= '"' . ($order -> ship_city) . '",';
												$data .= '"' . ($order -> ship_state) . '",';
												$wpcoDb -> model = $Country -> model;
												$country = $wpcoDb -> field('value', array('id' => $order -> ship_country));
												$data .= '"' . ($country) . '",';
												$data .= '"' . ($order -> ship_zipcode) . '",';
					
												//Billing info
												$data .= '"' . ($order -> bill_fname) . '",';
												$data .= '"' . ($order -> bill_lname) . '",';
												$data .= '"' . ((empty($order -> bill_email)) ? $userdata -> user_email : $order -> bill_email) . '",';
												$data .= '"' . ($order -> bill_company) . '",';
												$data .= '"' . ($order -> bill_phone) . '",';
												$data .= '"' . ($order -> bill_fax) . '",';
												$data .= '"' . ($order -> bill_address) . '",';
												$data .= '"' . ($order -> bill_address2) . '",';
												$data .= '"' . ($order -> bill_city) . '",';
												$data .= '"' . ($order -> bill_state) . '",';
												$wpcoDb -> model = $Country -> model;
												$country = $wpcoDb -> field('value', array('id' => $order -> bill_country));
												$data .= '"' . ($country) . '",';
												$data .= '"' . ($order -> bill_zipcode) . '",';
					
												$data .= '"' . ($order -> created) . '",';
												$data .= '"' . ($order -> modified) . '",';
												
												$ofieldsquery = "SELECT * FROM `" . $wpdb -> prefix . $wpcoFieldsOrder -> table . "` WHERE `order_id` = '" . $order -> id . "'";
												if ($ofields = $wpdb -> get_results($ofieldsquery)) {
													$f = 1;
													foreach ($ofields as $ofield) {
														$wpcoDb -> model = $wpcoField -> model;
														if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) {
															$data .= '"' . $wpcoField -> get_value($field -> id, $ofield -> value) . '"';
															if ($f < count($ofields)) { $data .= ','; }
															$f++;
														}
													}
												}
												
												$data .= "\r\n";														//end the ROW
											}
											
											if (!empty($data)) {
												$exportfile = 'orders.csv';
												$exportpath = WP_CONTENT_DIR . DS . 'uploads' . DS;
												$exportfull = $exportpath . $exportfile;
												
												if ($fh = fopen($exportfull, "w")) {
													fwrite($fh, $data);
													fclose($fh);
													
													$exportlink = site_url() . '/wp-content/uploads/' . $exportfile;
													$msg_type = 'message';
													$message = __('CSV with completed orders has been saved to "wp-content/uploads/' . $exportfile . '"', $this -> plugin_name) . ' <a href="' . $exportlink . '" title="' . __('Download the CSV', $this -> plugin_name) . '">' . __('Download the CSV', $this -> plugin_name) . '</a>';
												} else {
													$msg_type = 'error';
													$message = __('CSV file could not be created, please check permissions on "wp-content/uploads/" folder.', $this -> plugin_name);	
												}
											} else {
												$msg_type = 'error';
												$message = __('CSV data is empty, no completed orders?', $this -> plugin_name);
											}
										} else {
											$msg_type = 'error';
											$message = __('There are no completed/processed orders to export to CSV at this time.', $this -> plugin_name);
										}
									} else {
										$msg_type = 'error';
										$message = __('No orders were selected to export.', $this -> plugin_name);
									}
									
									$this -> redirect('?page=' . $this -> sections -> orders, $msg_type, $message);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No orders were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				case 'markasshipped'		:
					global $wpcoDb, $Order, $Item;
				
					if (!empty($_GET['order_id'])) {
						$wpcoDb -> model = $Item -> model;
						if ($wpcoDb -> save_field('shipped', "Y", array('order_id' => $_GET['order_id']))) {
							$msg_type = 'message';
							$message = __('Order has been marked as shipped', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Order could not be marked as shipped', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order was specified', $this -> plugin_name);
					}
					
					$this -> redirect("?page=" . $this -> sections -> orders . "&method=view&id=" . $_GET['order_id'], $msg_type, $message);
					break;
				case 'markasnotshipped'		:
					global $wpcoDb, $Order, $Item;
				
					if (!empty($_GET['order_id'])) {
						$wpcoDb -> model = $Item -> model;
						if ($wpcoDb -> save_field('shipped', "N", array('order_id' => $_GET['order_id']))) {
							$msg_type = 'message';
							$message = __('Order has been marked as NOT shipped', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Order could not be marked as NOT shipped', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order was specified', $this -> plugin_name);
					}
					
					$this -> redirect("?page=" . $this -> sections -> orders . "&method=view&id=" . $_GET['order_id'], $msg_type, $message);
					break;
				case 'delete-cc'            :
					if (!empty($_GET['user_id'])) {
						$order_id = $_GET['id'];
						$ccmeta = array('cc_name', 'cc_type', 'cc_number', 'cc_exp_m', 'cc_exp_y', 'cc_cvv');
	
						foreach ($ccmeta as $ccmeta_key) {
							delete_user_meta($_GET['user_id'], 'bill_' . $ccmeta_key);
							$query = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET `" . $ccmeta_key . "` = '' WHERE `id` = '" . $order_id . "' LIMIT 1";
							$wpdb -> query($query);
						}
	
						$msg_type = 'message';
						$message = __('The credit card details for this customer has been permanently removed.', $this -> plugin_name);
					} else {
						$msg_type = 'error';
						$message = __('No user was specified', $this -> plugin_name);
					}
	
					$this -> redirect('?page=' . $this -> sections -> orders . '&method=view&id=' . $_GET['id']);
					break;					
				default						:
					$perpage = (isset($_COOKIE[$this -> pre . 'ordersperpage'])) ? $_COOKIE[$this -> pre . 'ordersperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					

					$filters = array();
					$filters['completed'] = (isset($_COOKIE[$this -> pre . 'filter_completed'])) ? $_COOKIE[$this -> pre . 'filter_completed'] : "Y";
					$filters['completed'] = (!empty($_POST['filter_completed'])) ? $_POST['filter_completed'] : $filters['completed'];
					$filters['pmethod'] = (isset($_COOKIE[$this -> pre . 'filter_pmethod'])) ? $_COOKIE[$this -> pre . 'filter_pmethod'] : false;
					$filters['pmethod'] = (!empty($_POST['filter_pmethod'])) ? $_POST['filter_pmethod'] : $filters['pmethod'];
					$filters['shipmethod_id'] = (isset($_COOKIE[$this -> pre . 'filter_shipmethod_id'])) ? $_COOKIE[$this -> pre . 'filter_shipmethod_id'] : false;
					$filters['shipmethod_id'] = (!empty($_POST['filter_shipmethod_id'])) ? $_POST['filter_shipmethod_id'] : $filters['shipmethod_id'];
					$filters['user_id'] = (isset($_COOKIE[$this -> pre . 'filter_user_id'])) ? $_COOKIE[$this -> pre . 'filter_user_id'] : false;
					$filters['user_id'] = (!empty($_POST['filter_user_id'])) ? $_POST['filter_user_id'] : $filters['user_id'];
					$filters['fromdate'] = (empty($_REQUEST['fromdate'])) ? "0000-00-00 00:00:00" : $_REQUEST['fromdate'];
					$filters['todate'] = (empty($_REQUEST['todate'])) ? date("Y-m-d H:i:s", strtotime("-1day")) : $_REQUEST['todate'];

					if (!empty($searchterm)) {
						$conditions['(`id`'] .= "LIKE '%" . $searchterm . "%'";
						foreach ($Order -> fields as $fkey => $fattr) {
							if ($fkey != "id" && $fkey != "key") {
								$conditions['(`id`'] .= " OR `" . $fkey . "` ";
								$conditions['(`id`'] .= "LIKE '%" . $searchterm . "%'";
							}
						}
						$conditions['(`id`'] .= ")";
					}

					if (!empty($filters)) {								
						$emptyfilters = true;
						$daterangeadded = false;
					
						foreach ($filters as $filter_field => $filter_value) {
							if (!empty($filter_field) && !empty($filter_value)) {
								switch ($filter_field) {
									case 'fromdate'			:
									case 'todate'			:
										if (!$daterangeadded) {
											$conditions['completed_date'] = "LE '" . date("Y-m-d H:i:s", strtotime($filters['fromdate'])) . "'";
											$conditions['completed_date'] .= " AND `completed_date` <= '" . date("Y-m-d H:i:s", strtotime($filters['todate'] . " + 1day")) . "'";
											$daterangeadded = true;
										}
										break;
									default					:
										$conditions[$filter_field] = $filter_value;	
										break;
								}
								
								$emptyfilters = false;
								
								if ($filter_field == "completed" && $filter_value == "Y") {
									$emptyfilters = true;	
								}
							}
						}
					}
					
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($Order -> model, "*", $this -> sections -> orders, $conditions, $searchterm, $perpage, $order);
					$this -> render('orders' . DS . 'index', array('filters' => $filters,'orders' => $data[$Order -> model], 'paginate' => $data['Paginate']), true, 'admin');
					break;
			}
		}
		
		function admin_items() {
			global $wpdb, $wpcoDb, $Order, $Item;
			$wpcoDb -> model = $Item -> model;
			
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-items\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'view'					:
					if (!empty($_GET['id'])) {
						if ($item = $wpcoDb -> find(array('id' => $_GET['id']))) {
							$this -> render('items' . DS . 'view', array('item' => $item), true, 'admin');
						} else {
							$message = __('Item cannot be read', $this -> plugin_name);
							$this -> redirect($this -> url, 'error', $message);
						}
					} else {
						$message = __('No item was specified', $this -> plugin_name);
						$this -> redirect($this -> url, 'error', $message);
					}
					break;
				case 'shipped'				:
					if (!empty($_GET['id'])) {
						if ($item = $wpcoDb -> find(array('id' => $_GET['id']))) {
							if ($item -> product -> type == "tangible") {
								if ($item -> shipped == "N") {
									if ($wpcoDb -> save_field('shipped', "Y", array('id' => $item -> id))) {
										$msg_type = 'message';
										$message = __('Order item has been marked as shipped', $this -> plugin_name);
									} else {
										$msg_type = 'error';
										$message = __('Order item cannot be marked as shipped', $this -> plugin_name);
									}
								} else {
									$msg_type = 'error';
									$message = __('Order item has already been marked as shipped', $this -> plugin_name);
								}
							} else {
								$msg_type = 'error';
								$message = __('Product of this order item is not tangible', $this -> plugin_name);
							}
						} else {
							$msg_type = 'error';
							$message = __('Order item cannot be read', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order item was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url . '&method=view&id=' . $_GET['id'], $msg_type, $message);
					break;
				case 'notshipped'			:
					if (!empty($_GET['id'])) {
						if ($item = $wpcoDb -> find(array('id' => $_GET['id']))) {
							if ($item -> product -> type == "tangible") {
								if ($item -> shipped == "Y") {
									if ($wpcoDb -> save_field('shipped', "N", array('id' => $_GET['id']))) {
										$msg_type = 'message';
										$message = __('Order item has been marked as NOT shipped', $this -> plugin_name);
									} else {
										$msg_type = 'error';
										$message = __('Order item cannot be marked as not shipped', $this -> plugin_name);
									}
								} else {
									$msg_type = 'error';
									$message = __('Order item has not been marked as shipped yet', $this -> plugin_name);
								}
							} else {
								$msg_type = 'error';
								$message = __('Product of this order item is not tangible', $this -> plugin_name);
							}
						} else {
							$msg_type = 'error';
							$message = __('Order item cannot be read', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order item was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url . '&method=view&id=' . $_GET['id'], $msg_type, $message);
					break;
				case 'save'					:
					if (!empty($_POST)) {
						if ($wpcoDb -> save($_POST, true)) {
							$Order -> update_totals($Item -> data -> order_id);
							$message = __('Order item has been saved', $this -> plugin_name);
							$this -> redirect('?page=' . $this -> sections -> orders . '&method=view&id=' . $Item -> data -> order_id, 'message', $message);
						} else {
							$this -> render_err(__('Order item cannot be saved', $this -> plugin_name));
							$this -> render('items' . DS . 'save');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						if (!empty($_GET['order_id'])) { $Item -> data -> order_id = $_GET['order_id']; }
						$this -> render('items' . DS . 'save');
					}
					break;
				case 'delete'				:
					if (!empty($_GET['id']) && $item = $wpcoDb -> find(array('id' => $_GET['id']))) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$Order -> update_totals($item -> order_id);
							
							$msg_type = 'message';
							$message = __('Order item has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Order item cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No order item was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'mass'					:
					if (!empty($_POST['action'])) {
						if (!empty($_POST['Item']['checklist'])) {
							$items = $_POST['Item']['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'				:
									foreach ($items as $item_id) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> delete($item_id);
									}
									
									$msg_type = 'message';
									$message = count($items) . ' ' . __('order items have been removed', $this -> plugin_name);
									break;
								case 'paid'					:
									foreach ($items as $item_id) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('completed', "Y", array('id' => $item_id));
										$wpcoDb -> save_field('paid', "Y", array('id' => $item_id));
									}
									
									$msg_type = 'message';
									$message = count($items) . ' ' . __('order items have been set as paid', $this -> plugin_name);
									break;
								case 'notpaid'				:
									foreach ($items as $item_id) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('paid', "N", array('id' => $item_id));
									}
									
									$msg_type = 'message';
									$message = count($items) . ' ' . __('order items have been set as NOT paid', $this -> plugin_name);
									break;
								case 'shipped'				:
									foreach ($items as $item_id) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('shipped', "Y", array('id' => $item_id));
									}
									
									$msg_type = 'message';
									$message = count($items) . ' ' . __('order items have been marked as shipped', $this -> plugin_name);
									break;
								case 'notshipped'			:
									foreach ($items as $item_id) {
										$wpcoDb -> model = $Item -> model;
										$wpcoDb -> save_field('shipped', "N", array('id' => $item_id));
									}
									
									$msg_type = 'message';
									$message = count($items) . ' ' . __('order items have been marked as not shipped', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No order items were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was selected', $this -> plugin_name);
					}
					
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				default						:
					$perpage = (isset($_COOKIE[$this -> pre . 'itemsperpage'])) ? $_COOKIE[$this -> pre . 'itemsperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('id' => "LIKE '%" . $searchterm . "%' OR `order_id` LIKE '%" . $searchterm . "%'") : false;
					$conditions['completed'] = "Y";
					$data = $this -> paginate($Item -> model, "*", $this -> sections -> items, $conditions, $searchterm, $perpage);
					$this -> render('items' . DS . 'index', array('items' => $data[$Item -> model], 'paginate' => $data['Paginate']), true, 'admin');
					break;
			}
		}
		
		function admin_shipmethods() {
			global $wpdb, $wpcoDb, $wpcoShipmethod;
			$wpcoDb -> model = $wpcoShipmethod -> model;
		
			$method = (empty($_GET['method'])) ? preg_replace("/checkout\-shipmethods\-/si", "", $_GET['page']) : $_GET['method'];
			switch ($method) {
				case 'save'				:
					if (!empty($_POST)) {
						if ($wpcoDb -> save($_POST, true)) {
							$message = __('Shipping method has been saved', $this -> plugin_name);
							$this -> redirect($this -> url, 'message', $message);
						} else {
							$message = __('Shipping method could not be saved', $this -> plugin_name);
							$this -> render_err($message);
							$this -> render('shipmethods' . DS . 'save', false, true, 'admin');
						}
					} else {
						$wpcoDb -> find(array('id' => $_GET['id']));
						$this -> render('shipmethods' . DS . 'save', false, true, 'admin');
					}
					break;
				case 'delete'			:
					if (!empty($_GET['id'])) {
						if ($wpcoDb -> delete($_GET['id'])) {
							$msg_type = 'message';
							$message = __('Shipping method has been removed', $this -> plugin_name);
						} else {
							$msg_type = 'error';
							$message = __('Shipping method cannot be removed', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No shipping method was specified', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'order'			:
					$query = "SELECT * FROM " . $wpdb -> prefix . $wpcoShipmethod -> table . " ORDER BY `order` ASC";
					$shipmethods = $wpdb -> get_results($query);
					
					$this -> render('shipmethods' . DS . 'order', array('shipmethods' => $shipmethods), true, 'admin');
					break;
				case 'mass'				:						
					if (!empty($_POST['action'])) {
						if (!empty($_POST['Shipmethod']['checklist'])) {
							$shipmethods = $_POST['Shipmethod']['checklist'];
							
							switch ($_POST['action']) {
								case 'delete'				:
									foreach ($shipmethods as $shipmethod_id) {
										$wpcoDb -> model = $wpcoShipmethod -> model;
										$wpcoDb -> delete($shipmethod_id);
									}
									
									$msg_type = 'message';
									$message = __('Selected shipping methods have been removed', $this -> plugin_name);
									break;
								case 'activate'				:
									foreach ($shipmethods as $shipmethod_id) {
										$wpcoDb -> model = $wpcoShipmethod -> model;
										$wpcoDb -> save_field('status', "active", array('id' => $shipmethod_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected shipping methods have been activated.', $this -> plugin_name);
									break;
								case 'deactivate'			:
									foreach ($shipmethods as $shipmethod_id) {
										$wpcoDb -> model = $wpcoShipmethod -> model;
										$wpcoDb -> save_field('status', "inactive", array('id' => $shipmethod_id));
									}
									
									$msg_type = 'message';
									$message = __('Selected shipping methods have been deactivated.', $this -> plugin_name);
									break;
							}
						} else {
							$msg_type = 'error';
							$message = __('No shipping methods were selected', $this -> plugin_name);
						}
					} else {
						$msg_type = 'error';
						$message = __('No action was selected', $this -> plugin_name);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				default					:
					if ($this -> get_option('shippingcalc') == "N") {
						$message = __('Shipping calculation is turned off. Please turn it on in the configuration.', $this -> plugin_name);
						$this -> render_err($message);
					}
				
					$perpage = (isset($_COOKIE[$this -> pre . 'shipmethodsperpage'])) ? $_COOKIE[$this -> pre . 'shipmethodsperpage'] : 10;
					$searchterm = (!empty($_GET[$this -> pre . 'searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : false;
					$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : $searchterm;
					
					if (!empty($_POST['searchterm'])) {
						$this -> redirect($this -> url . '&' . $this -> pre . 'searchterm=' . urlencode($searchterm));
					}
					
					$conditions = (!empty($searchterm)) ? array('name' => "LIKE '%" . $searchterm . "%'") : false;
					$ofield = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
					$odir = strtoupper((empty($_GET['order'])) ? "DESC" : $_GET['order']);
					$order = array($ofield, $odir);
					$data = $this -> paginate($wpcoShipmethod -> model, "*", $this -> sections -> shipmethods, $conditions, $searchterm, $perpage, $order);
					$this -> render('shipmethods' . DS . 'index', array('shipmethods' => $data[$wpcoShipmethod -> model], 'paginate' => $data['Paginate']), true, 'admin');
					break;
			}
		}
		
		function admin_settings_paymentfields() {
			if (!empty($_POST)) {
				foreach ($_POST as $pkey => $pval) {
					$this -> update_option($pkey, $pval);	
				}
				
				$this -> render_msg(__('Payment fields have been updated.', $this -> plugin_name));
			}
			
			$this -> render('settings' . DS . 'paymentfields', false, true, 'admin');
		}
		
		function admin_settings_updates() {
			switch ($_GET['method']) {
				case 'check'				:
					delete_transient($this -> pre . 'update_info');
					$this -> redirect($this -> referer);
					break;
			}
			
			$this -> render('settings-updates', false, true, 'admin');
		}
		
		function admin_settings_invoice() {
			if (!empty($_POST)) {
				foreach ($_POST as $pkey => $pval) {
					$this -> update_option($pkey, $pval);	
				}
				
				$this -> update_option('invoice_updated', "Y");
				$this -> render_msg(__('Purchase invoice settings have been saved.', $this -> plugin_name));
			}
			
			if ($this -> get_option('invoice_logotype') == "image") {
				if (!empty($_FILES['invoice_companylogo']['name'])) {				
					if ($_FILES['invoice_companylogo']['error'] <= 0) {
						if (is_uploaded_file($_FILES['invoice_companylogo']['tmp_name'])) {
							$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS;
							$filename = $_FILES['invoice_companylogo']['name'];
							$filefull = $filepath . $filename;
							
							if (move_uploaded_file($_FILES['invoice_companylogo']['tmp_name'], $filefull)) {
								$this -> update_option('invoice_companylogo', $_FILES['invoice_companylogo']['name']);
							} else {
								$message = __('Logo could not be moved to destination', $this -> plugin_name);
								$this -> render_err($message);
							}
						} else {
							$message = __('Logo could not be uploaded, please try again', $this -> plugin_name);
							$this -> render_err($message);
						}
					} else {
						$message = __('Logo could not be uploaded, please try again', $this -> plugin_name);	
						$this -> render_err($message);
					}
				}
			}
		
			$this -> render('settings-invoice', false, true, 'admin');	
		}
		
		function admin_settings_pmethods() {
			if (!empty($_POST)) {
				foreach ($_POST as $pkey => $pval) {
					$this -> update_option($pkey, $pval);
				}
				
				/** FILES **/
				/* First Data API Certificate PEM File */
				if ($this -> is_plugin_active('fdapi')) {
					if (!empty($_FILES['fdapi_keyfile']['name'])) {
						$filename = $_FILES['fdapi_keyfile']['name'];
						$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'fdapi' . DS;
						$filefull = $filepath . $filename;
						
						if (move_uploaded_file($_FILES['fdapi_keyfile']['tmp_name'], $filefull)) {
							@chmod($filefull, 0755);
							$this -> update_option('fdapi_keyfile', $filefull);
						} else {
							$this -> render_err(__('First Data API Certificate PEM file could not be moved from TMP.', $this -> plugin_name));
						}
					}
				}
				
				$this -> render_msg(__('Payment methods have been saved.', $this -> plugin_name));
			}
				
			$this -> render('settings-pmethods', false, true, 'admin');
		}
		
		function admin_settings_products() {
			if (!empty($_POST)) {
				foreach ($_POST as $pkey => $pval) {
					$this -> update_option($pkey, $pval);	
				}
				
				$this -> render_msg(__('Product settings have been saved.', $this -> plugin_name));
			}		
		
			$this -> render('settings-products', false, true, 'admin');	
		}
		
		function admin_settings_taxshipping() {	
			global $wpdb, $wpcoDb, $wpcoShiprate;
					
			if (!empty($_POST)) {
				foreach ($_POST as $pkey => $pval) {
					switch ($pkey) {
						case 'shiprates'				:
							if (!empty($pval['shipmethod'])) {
								$wpdb -> query("TRUNCATE TABLE " . $wpdb -> prefix . $wpcoShiprate -> table);
							
								for ($i = 0; $i < count($pval['shipmethod']); $i++) {
									$shiprate = array(
										'shipmethod_id'		=>	$pval['shipmethod'][$i],
										'country_id'		=>	$pval['country'][$i],
										'state'				=>	$pval['state'][$i],
										'price'				=>	$pval['price'][$i],
										'pricetype'			=>	$pval['pricetype'][$i],
									);
									
									$wpcoDb -> model = $wpcoShiprate -> model;
									$wpcoDb -> save($shiprate);
								}
							}
							break;
						default							:
							$this -> update_option($pkey, $pval);
							break;
					}
						
				}
				
				$this -> render_msg(__('Calculations settings have been saved acccordingly.', $this -> plugin_name));
			}
			
			$this -> render('settings-taxshipping', false, true, 'admin');	
		}
		
		function admin_settings_general() {
			global $wpdb, $wpcoDb, $wpcoHtml;
			$method = (empty($_GET['method'])) ? null : $_GET['method'];
		
			switch ($method) {
				default					:
					global $wpdb, $wpcoDb, $wpcoShipmethod;
					
					if (!$wpdb -> get_results("SELECT 1 FROM `" . $wpdb -> options . "` WHERE `option_name` LIKE '" . $this -> pre . "%';")) {
						$this -> render_err(__('No configuration settings were found, please click the "Reset to Defaults" link on the right', $this -> plugin_name));	
					}
				
					if (!empty($_POST)) {
						$this -> update_option('cropthumbs', "N");
						$this -> update_option('croploopthumbs', "N");
						$this -> update_option('cropithumbs', "N");
						$this -> update_option('cropcatthumbs', "N");
					
						unset($_POST['save-configuration']);
					
						foreach ($_POST as $pkey => $pval) {						
							switch ($pkey) {
								case 'permissions'			:
									global $wp_roles;
									$role_names = $wp_roles -> get_names();
								
									if (!empty($_POST['permissions'])) {
										$permissions = $_POST['permissions'];
										
										foreach ($this -> sections as $section_key => $section_menu) {
											foreach ($role_names as $role_key => $role_name) {
												$wp_roles -> remove_cap($role_key, 'checkout_' . $section_key);
											}
											
											if (!empty($permissions[$section_key])) {
												foreach ($permissions[$section_key] as $role) {
													$wp_roles -> add_cap($role, 'checkout_' . $section_key);
												}
											} else {
												/* No roles were selected for this capability, at least add 'administrator' */
												$wp_roles -> add_cap('administrator', 'checkout_' . $section_key);
												$permissions[$section_key][] = 'administrator';
											}
										}
									}
									
									$this -> update_option('permissions', $permissions);
									break;
								case 'shipmethods'			:
									$shipmethods = $_POST['shipmethods'];
									
									if (!empty($shipmethods['fixed'])) {
										foreach ($shipmethods['fixed'] as $shipmethod_id => $shipmethod_fixed) {
											$wpcoDb -> model = $wpcoShipmethod -> model;
											$wpcoDb -> save_field("fixed", number_format($shipmethod_fixed, 2, '.', ''), array('id' => $shipmethod_id));
										}
									}
									break;
								case 'shippingtiers'		:
									$shippingtiers = $_POST['shippingtiers'];
									$shipmethodstiers = array();
									
									if (!empty($shippingtiers) && is_array($shippingtiers)) {
										foreach ($shippingtiers as $shippingtier) {
											if (!empty($shippingtier['price']) && is_array($shippingtier['price'])) {
												foreach ($shippingtier['price'] as $shipmethod_id => $price) {
													if (!isset($shipmethodstiers[$shipmethod_id])) {
														$shipmethodstiers[$shipmethod_id] = array();
													}
												
													array_push($shipmethodstiers[$shipmethod_id], array('min' => $shippingtier['min'], 'max' => $shippingtier['max'], 'price' => number_format($price, 2, '.', '')));
												}
											}
										}
										
										if (!empty($shipmethodstiers)) {
											foreach ($shipmethodstiers as $shipmethod_id => $shipmethodtier) {										
												$wpcoDb -> model = $wpcoShipmethod -> model;
												$wpcoDb -> save_field("tiers", serialize($shipmethodtier), array('id' => $shipmethod_id));
											}
										}
									}
									break;
								case 'cart_layout'			:
									if ($pval == "theme") {
										$post_parent = $this -> get_option('pagesparent');
			
										$cart_query = "SELECT (`ID`) FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $this -> get_option('cartpage_id') . "'";
										if ($this -> get_option('cartpageadded') != "Y" || !$wpdb -> get_var($cart_query)) {
											$cart = array(
												'post_title'			=>	__('Shopping Cart', $this -> plugin_name),
												'post_content'			=>	"[" . $this -> pre . "cart]",
												'post_status'			=>	"publish",
												'post_type'				=>	$this -> get_option('post_type'),
												'post_parent'			=>	$post_parent,
												'post_category'			=>	false,
											);
											
											$cartpage_id = wp_insert_post($cart);
											$this -> update_option('cartpageadded', "Y");
											$this -> update_option('cartpage_id', $cartpage_id);
										}
									} else {
										if ($this -> get_option('cartpageadded') == "Y" && $cartpage_id = $this -> get_option('cartpage_id')) {
											wp_delete_post($cartpage_id);
										}
									}
									break;
								case 'customcss'			:
								case 'customcsscode'		:
									if (!empty($_POST['customcss']) && $_POST['customcss'] == "Y") {
										$this -> update_option('customcss', "Y");
										$this -> update_option('customcsscode', $_POST['customcsscode']);
									} else {
										$this -> update_option('customcss', "N");	
									}
									break;
							}
							
							$this -> update_option($pkey, $pval);
						}
						
						$message = __('Configuration settings have been saved.', $this -> plugin_name);
					}
					break;
			}
			
			$this -> redirect('?page=' . $this -> sections -> settings, 'message', $message);
		}
		
		function admin_settings() {
			global $wpdb, $wpcoDb, $wpcoHtml;
			$method = (empty($_GET['method'])) ? null : $_GET['method'];
			
			if (!empty($_GET['reset']) && $_GET['reset'] == 1) {
				$this -> initialize_options();
				$this -> redirect($this -> url);	
			}
		
			switch ($method) {
				case 'checkdb'			:
					$this -> check_tables();
					
					if (!empty($this -> tablenames)) {
						foreach ($this -> tablenames as $table) {
							$query = "OPTIMIZE TABLE `" . $table . "`";
							$wpdb -> query($query);
						}
					}
					
					$msg_type = 'message';
					$message = __('All database tables have been checked and optimized.', $this -> plugin_name);
					$this -> redirect($this -> referer, $msg_type, $message);
					break;
				case 'loadcountries'	:
					global $Country;
					$Country -> initialize();
					$this -> redirect($this -> referer, 'message', __('Countries have been loaded successfully.', $this -> plugin_name));
					break;
				case 'reset'			:
					global $wpdb, $Country, $wpcoState;
					$query = "DELETE FROM `" . $wpdb -> prefix . "options` WHERE `option_name` LIKE '" . $this -> pre . "%' AND `option_name` != '" . $this -> pre . "serialkey';";
					
					if ($wpdb -> query($query)) {
						$message = __('All configuration settings have been reset to their defaults, redirecting now...', $this -> plugin_name);
						$msg_type = 'message';
						$this -> render_msg($message);	
					} else {
						$message = __('Configuration settings could not be reset', $this -> plugin_name);
						$msg_type = 'error';
						$this -> render_err($message);
					}
					
					$query = "DROP TABLE `" . $wpdb -> prefix . "" . $Country -> table . "`, `" . $wpdb -> prefix . "" . $wpcoState -> table . "`;";
					$wpdb -> query($query);
					
					$this -> redirect($wpcoHtml -> retainquery('reset=1'), $msg_type, $message);
					break;
				case 'updatepages'		:			
					if ($this -> get_option('createpages') == "Y") {
						$totalp = $this -> updatepages($update = true);
						$message = $totalp . __(' Wordpress pages for categories, products &amp; suppliers have been updated.', $this -> plugin_name);
					} else {
						$message = __('Wordpress page creation setting is turned off. Please turn it on first.', $this -> plugin_name);
					}
					
					$this -> redirect($this -> referer, "message", $message);
					break;
				case 'updatethumbs'		:					
					$message = __('This feature is not available anymore, TimThumb is used now.', $this -> plugin_name);
					//$message = __('All product and image thumbnails have been resized', $this -> plugin_name);
					$this -> redirect($this -> referer, "message", $message);
					break;
				default					:
					global $wpdb, $wpcoDb, $wpcoShipmethod;
					
					if (!$wpdb -> get_results("SELECT 1 FROM `" . $wpdb -> options . "` WHERE `option_name` LIKE '" . $this -> pre . "%';")) {
						$this -> render_err(__('No configuration settings were found, please click the "Reset to Defaults" link on the right', $this -> plugin_name));	
					}
				
					if (!empty($_POST)) {
						$this -> update_option('cropthumbs', "N");
						$this -> update_option('croploopthumbs', "N");
						$this -> update_option('cropithumbs', "N");
						$this -> update_option('cropcatthumbs', "N");
					
						unset($_POST['save-configuration']);
					
						foreach ($_POST as $pkey => $pval) {						
							switch ($pkey) {
								case 'shipmethods'			:
									$shipmethods = $_POST['shipmethods'];
									
									if (!empty($shipmethods['fixed'])) {
										foreach ($shipmethods['fixed'] as $shipmethod_id => $shipmethod_fixed) {
											$wpcoDb -> model = $wpcoShipmethod -> model;
											$wpcoDb -> save_field("fixed", number_format($shipmethod_fixed, 2, '.', ''), array('id' => $shipmethod_id));
										}
									}
									break;
								case 'shippingtiers'		:
									$shippingtiers = $_POST['shippingtiers'];
									$shipmethodstiers = array();
									
									if (!empty($shippingtiers) && is_array($shippingtiers)) {
										foreach ($shippingtiers as $shippingtier) {
											if (!empty($shippingtier['price']) && is_array($shippingtier['price'])) {
												foreach ($shippingtier['price'] as $shipmethod_id => $price) {
													if (!isset($shipmethodstiers[$shipmethod_id])) {
														$shipmethodstiers[$shipmethod_id] = array();
													}
												
													array_push($shipmethodstiers[$shipmethod_id], array('min' => $shippingtier['min'], 'max' => $shippingtier['max'], 'price' => number_format($price, 2, '.', '')));
												}
											}
										}
										
										if (!empty($shipmethodstiers)) {
											foreach ($shipmethodstiers as $shipmethod_id => $shipmethodtier) {										
												$wpcoDb -> model = $wpcoShipmethod -> model;
												$wpcoDb -> save_field("tiers", serialize($shipmethodtier), array('id' => $shipmethod_id));
											}
										}
									}
									break;
								case 'cart_layout'			:
									if ($pval == "theme") {
										$post_parent = $this -> get_option('pagesparent');
			
										$cart_query = "SELECT (`ID`) FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $this -> get_option('cartpage_id') . "'";
										if ($this -> get_option('cartpageadded') != "Y" || !$wpdb -> get_var($cart_query)) {
											$cart = array(
												'post_title'			=>	__('Shopping Cart', $this -> plugin_name),
												'post_content'			=>	"[" . $this -> pre . "cart]",
												'post_status'			=>	"publish",
												'post_type'				=>	$this -> get_option('post_type'),
												'post_parent'			=>	$post_parent,
												'post_category'			=>	false,
											);
											
											$cartpage_id = wp_insert_post($cart);
											$this -> update_option('cartpageadded', "Y");
											$this -> update_option('cartpage_id', $cartpage_id);
										}
									} else {
										if ($this -> get_option('cartpageadded') == "Y" && $cartpage_id = $this -> get_option('cartpage_id')) {
											wp_delete_post($cartpage_id);
										}
									}
									break;
								case 'customcss'			:
								case 'customcsscode'		:
									if (!empty($_POST['customcss']) && $_POST['customcss'] == "Y") {
										$this -> update_option('customcss', "Y");
										$this -> update_option('customcsscode', $_POST['customcsscode']);
									} else {
										$this -> update_option('customcss', "N");	
									}
									break;
							}
							
							$this -> update_option($pkey, $pval);
						}
						
						$message = __('Configuration settings have been saved.', $this -> plugin_name);
						$this -> render_msg($message);
					}
					break;
			}
			
			$this -> render('settings');
		}
		
		/* Plugin Extensions Section */
		function admin_extensions() {
			switch ($_GET['method']) {
				case 'activate'				:
					activate_plugin(plugin_basename($_GET['plugin']));
					$this -> redirect($this -> url, 'message', __('Extension has been activated.', $this -> plugin_name));
					break;
				case 'deactivate'			:
					deactivate_plugins(array(plugin_basename($_GET['plugin'])));
					$this -> redirect($this -> url, 'error', __('Extension has been deactivated.', $this -> plugin_name));
					break;
				default						:
					$this -> render('extensions' . DS . 'index', false, true, 'admin');
					break;
			}
		}
		
		function admin_extensions_settings() {
			switch ($_REQUEST['method']) {
				default							:
					if (!empty($_POST)) {
						foreach ($_POST as $pkey => $pval) {
							$this -> update_option($pkey, $pval);
						}
					
						do_action($this -> pre . '_extensions_settings_saved', $_POST);
						$this -> render_msg(__('Extensions settings have been saved.', $this -> plugin_name));
					}
				
					$this -> render('extensions' . DS . 'settings', false, true, 'admin');
					break;
			}
		}
		
		function admin_support() {
			$this -> render('support');
		}
		
		function wpCheckout() {
			$this -> name = WPCO_PLUGIN_NAME;
			$this -> plugin_file = plugin_basename(__FILE__);
			
			$url = explode("&", $_SERVER['REQUEST_URI']);		
			$this -> url_args = explode("/", $_SERVER['REQUEST_URI']);
			$this -> url = $url[0];
			
			if (!empty($_SERVER['HTTP_REFERER'])) {
				$this -> referer = $_SERVER['HTTP_REFERER'];
			}
			
			$this -> register_plugin($this -> plugin_name, __FILE__);
		}
		
		function plugins_loaded() {
			$this -> initialize_classes();
		}
	}
}	// class_exists('wpCheckout');

//include necessary libraries
require_once(ABSPATH . WPINC . DS . 'pluggable.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'html.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'metabox.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'shortcode.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'auth.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'form.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'db.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'javascript.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'category.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'categories_product.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'product.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'style.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'option.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'options_option.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'products_style.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'products_option.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'products_product.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'products_coupon.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'field.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'fields_product.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'fields_order.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'content.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'keyword.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'coupon.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'image.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'supplier.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'cart.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'order.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'item.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'file.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'discount.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'country.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'shipmethod.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'state.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'tax.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'shiprate.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'favorite.php');

$wpCheckout = new wpCheckout();
require_once(dirname(__FILE__) . DS . 'wp-checkout-functions.php');
register_activation_hook(plugin_basename(__FILE__), array($wpCheckout, 'initialize_options'));

?>