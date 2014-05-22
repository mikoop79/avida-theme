<?php

class wpcoMetaboxHelper extends wpCheckoutPlugin {

	var $name = 'Metabox';
	
	function welcome_orders_total() {
		global $Order;
		$total = $Order -> alltotal();
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'orders-total', array('total' => $total), true, 'admin');
	}
	
	function welcome_shipping_total() {
		global $Order;
		$total = $Order -> shipping_alltotal();
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'shipping-total', array('total' => $total), true, 'admin');
	}
	
	function welcome_tax_total() {
		global $Order;
		$total = $Order -> tax_alltotal();
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'tax-total', array('total' => $total), true, 'admin');
	}
	
	function welcome_discounts_total() {
		global $Discount;
		$total = $Discount -> alltotal();
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'discounts-total', array('total' => $total), true, 'admin');
	}
	
	function welcome_chart() {
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'chart', false, true, 'admin');
	}
	
	function welcome_orders() {
		global $wpdb, $wpcoDb, $Order;
		$wpcoDb -> model = $Order -> model;
		$orders = $wpcoDb -> find_all(array('completed' => "Y"), false, array('completed_date', "DESC"), 10);
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'orders', array('orders' => $orders), true, 'admin');
	}
	
	function welcome_oosproducts() {
		global $wpdb, $Product;
		$productsquery = "SELECT `id`, `title`, `inventory` FROM `" . $wpdb -> prefix . $Product -> table . "` p WHERE `inventory` <= '10' AND `inventory` != '-1' ORDER BY `inventory` ASC";
		$products = $wpdb -> get_results($productsquery);
		$this -> render('metaboxes' . DS . 'welcome' . DS . 'oosproducts', array('products' => $products), true, 'admin');
	}
	
	function product_styles() {
		$this -> render('metaboxes' . DS . 'product-styles', false, true, 'admin');
	}
	
	function product_postpage() {
		$this -> render('metaboxes' . DS . 'product' . DS . 'postpage', false, true, 'admin');	
	}
	
	function product_cfields() {
		global $wpdb, $wpcoDb, $Product, $wpcoField, $wpcoFieldsProduct;
		
		$wpcoDb -> model = $wpcoField -> model;
		$fields = $wpcoDb -> find_all(null, array('id', 'title', 'order'), array('order', "ASC"));
		
		if (!empty($Product -> data -> id)) {
			$wpcoDb -> model = $wpcoFieldsProduct -> model;			
			if ($fieldsproducts = $wpcoDb -> find_all(array('product_id' => $Product -> data -> id))) {
				$fp = null;
			
				foreach ($fieldsproducts as $fieldsproduct) {
					$fp[] = $fieldsproduct -> field_id;
				}
			}
		}
	
		$this -> render('metaboxes' . DS . 'product-cfields', array('fields' => $fields, 'fieldsproducts' => $fp), true, 'admin');
	}
	
	function product_images() {
		global $wpdb, $wpcoDb, $Image, $Product;
		$wpcoDb -> model = $Image -> model;
		$images = $wpcoDb -> find_all(array('product_id' => $Product -> data -> id));
		
		$this -> render('metaboxes' . DS . 'product-images', array('images' => $images), true, 'admin');
	}
	
	function extensions_settings_submit() {
		$this -> render('metaboxes' . DS . 'extensions' . DS . 'submit', false, true, 'admin');
	}
	
	function settings_shippingfields() {
		$paymentfields = $this -> get_option('paymentfields');
		$this -> render('metaboxes' . DS . 'settings' . DS . 'shippingfields', array('paymentfields' => $paymentfields), true, 'admin');	
	}
	
	function settings_billingfields() {
		$paymentfields = $this -> get_option('paymentfields');
		$this -> render('metaboxes' . DS . 'settings' . DS . 'billingfields', array('paymentfields' => $paymentfields), true, 'admin');
	}
	
	function settings_submit() {
		$this -> render('metaboxes' . DS . 'settings-submit', false, true, 'admin');
	}
	
	function settings_favorites() {
		$this -> render('metaboxes' . DS . 'settings-favorites', false, true, 'admin');	
	}
	
	function settings_otheractions() {
		$this -> render('metaboxes' . DS . 'settings-otheractions', false, true, 'admin');
	}
	
	function settings_wprelated() {
		$this -> render('metaboxes' . DS . 'settings-wprelated', false, true, 'admin');
	}
	
	function settings_general() {
		$this -> render('metaboxes' . DS . 'settings-general', false, true, 'admin');
	}
	
	function settings_captions() {
		$this -> render('metaboxes' . DS . 'settings-captions', false, true, 'admin');
	}
	
	function settings_postspages() {
		$this -> render('metaboxes' . DS . 'settings-postspages', false, true, 'admin');	
	}
	
	function settings_urelated() {
		$this -> render('metaboxes' . DS . 'settings-urelated', false, true, 'admin');
	}
	
	function settings_cart() {
		$this -> render('metaboxes' . DS . 'settings-cart', false, true, 'admin');
	}
	
	function settings_checkout() {
		$this -> render('metaboxes' . DS . 'settings-checkout', false, true, 'admin');
	}
	
	function settings_products() {
		$this -> render('metaboxes' . DS . 'settings-products', false, true, 'admin');
	}
	
	function settings_ploop() {
		$this -> render('metaboxes' . DS . 'settings-ploop', false, true, 'admin');
	}
	
	function settings_variations() {
		$this -> render('metaboxes' . DS . 'settings-variations', false, true, 'admin');	
	}
	
	function settings_categories() {
		$this -> render('metaboxes' . DS . 'settings-categories', false, true, 'admin');
	}
	
	function settings_suppliers() {
		$this -> render('metaboxes' . DS . 'settings-suppliers', false, true, 'admin');
	}
	
	function settings_pimages() {
		$this -> render('metaboxes' . DS . 'settings-pimages', false, true, 'admin');
	}
	
	function settings_coupons() {
		$this -> render('metaboxes' . DS . 'settings-coupons', false, true, 'admin');
	}
	
	function settings_pmethods() {
		$this -> render('metaboxes' . DS . 'settings-pmethods', false, true, 'admin');
	}
	
	//Amazon FPS
	function settings_amazonfps() {
		if ($this -> is_plugin_active('amazonfps')) {
			$amazonfps = $this -> extension_vendor('amazonfps');
			$amazonfps -> settings();
		}
	}
	
	//Apco Limited
	function settings_apco() {
		if ($this -> is_plugin_active('apco')) {
			$apco = $this -> extension_vendor('apco');
			$apco -> settings();
		}
	}
	
	//eWay (Shared) settings
	function settings_eway_shared() {
		$this -> render('metaboxes' . DS . 'settings-eway_shared', false, true, 'admin');	
	}
	
	//Authorize.net (AIM) settings
	function settings_authorize_aim() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'authorize_aim', false, true, 'admin');
	}
	
	//BarterCard InternetPOS settings
	function settings_bartercard() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'bartercard', false, true, 'admin'); 	
	}
	
	/* BluePay 2.0 Redirect */
	function settings_bluepay() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'bluepay', false, true, 'admin');
	}
	
	/* iPay88 */
	function settings_ipay() {	
		if ($this -> is_plugin_active('ipay')) {
			$ipay = $this -> extension_vendor('ipay');
			$ipay -> settings();
		}
	}
	
	function settings_pp() {
		$this -> render('metaboxes' . DS . 'settings-pp', false, true, 'admin');
	}
	
	//PayPal (Website Payments Pro) settings
	function settings_pp_pro() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'paypal_pro', false, true, 'admin');	
	}
	
	function settings_payxml() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'paygate_xml', false, true, 'admin');	
	}
	
	function settings_tc() {
		$this -> render('metaboxes' . DS . 'settings-tc', false, true, 'admin');
	}
	
	function settings_lucy() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'lucy', false, true, 'admin');	
	}
	
	function settings_mb() {
		$this -> render('metaboxes' . DS . 'settings-mb', false, true, 'admin');
	}
	
	function settings_google_checkout() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'google_checkout', false, true, 'admin');
	}
	
	function settings_bw() {
		$this -> render('metaboxes' . DS . 'settings-bw', false, true, 'admin');
	}
	
	function settings_cc() {
		$this -> render('metaboxes' . DS . 'settings-cc', false, true, 'admin');
	}
	
	function settings_cu() {
		$this -> render('metaboxes' . DS . 'settings-cu', false, true, 'admin');
	}
	
	function settings_fd() {
		$this -> render('metaboxes' . DS . 'settings-fd', false, true, 'admin');
	}
	
	function settings_fdapi() {
		if ($this -> is_plugin_active('fdapi')) {
			$fdapi = $this -> extension_vendor('fdapi');
			$fdapi -> settings();
		}
	}
	
	/* Sage Pay (FORM) */
	function settings_sagepay() {	
		if ($this -> is_plugin_active('sagepay')) {
			$sagepay = $this -> extension_vendor('sagepay');	
			$sagepay -> settings();
		}	
	}
	
	/* SecureTrading */
	function settings_securetrading() {
		if ($this -> is_plugin_active('securetrading')) {
			$securetrading = $this -> extension_vendor('securetrading');
			$securetrading -> settings();
		}
	}
	
	function settings_re() {
		$this -> render('metaboxes' . DS . 'settings-re', false, true, 'admin');
	}
	
	/* Realex realauth remote */
	function settings_re_remote() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'realex-remote', false, true, 'admin');
	}
	
	//eMatters
	function settings_ematters() {
		$this -> render('metaboxes' . DS . 'settings-ematters', false, true, 'admin');
	}
	
	//Euro Payment Services SRL
	function settings_eupayment() {
		$this -> render('metaboxes' . DS . 'settings-eupayment', false, true, 'admin');
	}
	
	//Ogone (Basic e-Commerce)
	function settings_ogone_basic() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'ogone_basic', false, true, 'admin');	
	}
	
	//Virtual Merchant settings
	function settings_virtualmerchant() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'virtualmerchant', false, true, 'admin');
	}
	
	//WorldPay
	function settings_worldpay() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'worldpay', false, true, 'admin');	
	}
	
	//MonsterPay
	function settings_monsterpay() {
		$this -> render('metaboxes' . DS . 'pmethods' . DS . 'monsterpay', false, true, 'admin');	
	}
	
	//Netcash
	function settings_netcash() {
		if ($this -> is_plugin_active('netcash')) {
			$netcash = $this -> extension_vendor('netcash');	
			$netcash -> settings();
		}
	}
	
	function settings_stripe() {
		if ($this -> is_plugin_active('stripe')) {
			$stripe = $this -> extension_vendor('stripe');
			$stripe -> settings();
		}
	}
	
	function settings_email() {
		$this -> render('metaboxes' . DS . 'settings-email', false, true, 'admin');
	}
	
	//tax settings
	function settings_tax() {
		$this -> render('metaboxes' . DS . 'settings-tax', false, true, 'admin');
	}
	
	function settings_shipping() {
		$this -> render('metaboxes' . DS . 'settings-shipping', false, true, 'admin');
	}
	
	function settings_surcharge() {
		$this -> render('metaboxes' . DS . 'settings-surcharge', false, true, 'admin');
	}
	
	function settings_customcss() {
		$this -> render('metaboxes' . DS . 'settings-customcss', false, true, 'admin');
	}

	function settings_affiliatecode() {
		$this -> render('metaboxes' . DS . 'settings-affiliatecode', false, true, 'admin');
	}
}

?>