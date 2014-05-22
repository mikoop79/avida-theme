<?php

if (!class_exists('wpCheckoutPlugin')) {
	class wpCheckoutPlugin extends wpCheckoutCheckinit {
	
		var $plugin_name = 'wp-checkout';
		var $plugin_base = '';
		var $pre = 'wpco';
		var $debugging = false; 		// set to true to turn on global debugging in the plugin
		var $debug_level = 2; 			// set to 1 for DB errors. set to 2 for DB and PHP errors.
		var $version = '1.7';
		
		var $sections = array(
			'welcome'					=> 	"checkout",
			'import_csv'				=>	"checkout-import-csv",
			'categories'				=>	"checkout-categories",
			'categories_save'			=>	"checkout-categories-save",
			'products'					=>	"checkout-products",
			'products_save'				=>	"checkout-products-save",
			'content'					=>	"checkout-content",
			'content_save'				=>	"checkout-content-save",
			'files'						=>	"checkout-files",
			'images'					=>	"checkout-images",
			'suppliers'					=>	"checkout-suppliers",
			'styles'					=>	"checkout-styles",
			'options'					=>	"checkout-options",
			'fields'					=>	"checkout-fields",
			'coupons'					=>	"checkout-coupons",
			'orders'					=>	"checkout-orders",
			'items'						=>	"checkout-items",
			'shipmethods'				=>	"checkout-shipmethods",
			'settings'					=>	"checkout-settings",
			'settings_general'			=>	"checkout-settings-general",
			'settings_invoice'			=>	"checkout-settings-invoice",
			'settings_pmethods'			=>	"checkout-settings-pmethods",
			'settings_products'			=>	"checkout-settings-products",
			'settings_taxshipping'		=>	"checkout-settings-taxshipping",
			'settings_paymentfields'	=>	"checkout-settings-paymentfields",
			'settings_affiliates'		=>	"checkout-settings-affiliates",
			'extensions'				=>	"checkout-extensions",
			'extensions_settings'		=>	"checkout-extensions-settings",
			'settings_updates'			=>	"checkout-settings-updates",
			'support'					=>	"checkout-support",
		);
		
		var $classes = array(
			'wpcoHtml'					=>	array('type' => 'helper', 'name' => 'wpcoHtmlHelper'),
			'wpcoMetabox'				=>	array('type' => 'helper', 'name' => 'wpcoMetaboxHelper'),
			'wpcoShortcode'				=>	array('type' => 'helper', 'name' => 'wpcoShortcodeHelper'),
			'wpcoAuth'					=>	array('type' => 'helper', 'name' => 'wpcoAuthHelper'),
			'wpcoForm'					=>	array('type' => 'helper', 'name' => 'wpcoFormHelper'),
			'wpcoDb'					=>	array('type' => 'helper', 'name' => 'wpcoDbHelper'),
			'Javascript'				=>	array('type' => 'helper', 'name' => 'wpcoJavascriptHelper'),
			'wpcoCategoriesProduct'		=>	array('type' => 'model', 'name' => 'wpcoCategoriesProduct'),
			'Category'					=>	array('type' => 'model', 'name' => 'wpcoCategory'),
			'Style'						=>	array('type' => 'model', 'name' => 'wpcoStyle'),
			'Option'					=>	array('type' =>	'model', 'name' => 'wpcoOption'),
			'wpcoOptionsOption'			=>	array('type' => 'model', 'name' => 'wpcoOptionsOption'),
			'ProductsStyle'				=>	array('type' => 'model', 'name' => 'wpcoProductsStyle'),
			'ProductsOption'			=>	array('type' => 'model', 'name' => 'wpcoProductsOption'),
			'wpcoProductsProduct'		=>	array('type' => 'model', 'name' => 'wpcoProductsProduct'),
			'wpcoProductsCoupon'		=>	array('type' => 'model', 'name' => 'wpcoProductsCoupon'),
			'wpcoField'					=>	array('type' => 'model', 'name' => 'wpcoField'),
			'wpcoFieldsProduct'			=>	array('type' => 'model', 'name' => 'wpcoFieldsProduct'),
			'wpcoFieldsOrder'			=>	array('type' => 'model', 'name' => 'wpcoFieldsOrder'),
			'wpcoContent'				=>	array('type' => 'model', 'name' => 'wpcoContent'),
			'Coupon'					=>	array('type' => 'model', 'name' => 'wpcoCoupon'),
			'Image'						=>	array('type' => 'model', 'name' => 'wpcoImage'),
			'Supplier'					=>	array('type' => 'model', 'name' => 'wpcoSupplier'),
			'wpcoCart'					=>	array('type' => 'model', 'name' => 'wpcoCart'),
			'Order'						=>	array('type' => 'model', 'name' => 'wpcoOrder'),
			'Item'						=>	array('type' => 'model', 'name' => 'wpcoItem'),
			'File'						=>	array('type' => 'model', 'name' => 'wpcoFile'),
			'Discount'					=>	array('type' => 'model', 'name' => 'wpcoDiscount'),
			'Country'					=>	array('type' => 'model', 'name' => 'wpcoCountry'),
			'wpcoKeyword'				=>	array('type' => 'model', 'name' => 'wpcoKeyword'),
			'wpcoShipmethod'			=>	array('type' => 'model', 'name' => 'wpcoShipmethod'),
			'wpcoState'					=>	array('type' => 'model', 'name' => 'wpcoState'),
			'wpcoTax'					=>	array('type' => 'model', 'name' => 'wpcoTax'),
			'wpcoShiprate'				=>	array('type' => 'model', 'name' => 'wpcoShiprate'),
			'wpcoFavorite'				=> 	array('type' => 'model', 'name' => 'wpcoFavorite'),
			'Product'					=>	array('type' => 'model', 'name' => 'wpcoProduct'),
		);
	
		function wpCheckoutPlugin() {
			//do nothing...	
			return true;
		}
		
		/**
		 * Register the plugin name and base.
		 * Initialize some options and classes.
		 *
		 * @param STRING $name
		 * @param STRING $base
		 * @return unknown
		 */
		function register_plugin($name = null, $base = null) {
			$this -> plugin_name = $name;
			$this -> plugin_base = rtrim(dirname($base), DS);
			
			//Sections typecast
			$this -> sections = (object) $this -> sections;
			
			include $this -> plugin_base() . DS . 'includes' . DS . 'extensions.php';
			$this -> extensions = apply_filters($this -> pre . '_extensions_list', $extensions);
			
			$this -> set_timezone();
			$this -> initialize_classes();
			
			global $wpdb;
			$wpdb -> query("SET sql_mode = '';");
			
			if ($this -> debugging == true) {
				$wpdb -> show_errors();
				
				if ($this -> debug_level == 2) {
					@error_reporting(E_ALL ^ E_NOTICE);
					@ini_set('display_errors', 1);
				}
			} else {
				$wpdb -> hide_errors();
				@error_reporting(0);
				@ini_set('display_errors', 0);
			}
			
			/* WordPress Ajax */
			add_action('wp_ajax_productsorder', array($this, 'ajax_productsorder'));
			add_action('wp_ajax_relatedproducts', array($this, 'ajax_relatedproducts'));
			add_action('wp_ajax_addproductvariationoption', array($this, 'ajax_addproductvariationoption'));
			add_action('wp_ajax_deleteproductvariation', array($this, 'ajax_deleteproductvariation'));
			add_action('wp_ajax_convertposttype', array($this, 'ajax_convertposttype'));
			add_action('wp_ajax_wpcoimportproducts', array($this, 'ajax_importproducts'));
			add_action('wp_ajax_updateproductprice', array($this, 'ajax_updateproductprice'));
			add_action('wp_ajax_nopriv_updateproductprice', array($this, 'ajax_updateproductprice'));
			add_action('wp_ajax_wpcochart', array($this, 'ajax_chart'));
			add_action('wp_ajax_addtocart', array($this, 'ajax_addtocart'));
			add_action('wp_ajax_nopriv_addtocart', array($this, 'ajax_addtocart'));
			add_action('wp_ajax_wpcofeaturedproduct', array($this, 'ajax_featuredproduct'));
			add_action('wp_ajax_ordershopcategories', array($this, 'ajax_ordershopcategories'));
			add_action('wp_ajax_ordersuppliers', array($this, 'ajax_ordersuppliers'));
			add_action('wp_ajax_wpcoserialkey', array($this, 'ajax_serialkey'));
			add_action('wp_ajax_wpcotestsettings', array($this, 'ajax_testsettings'));
			add_action('wp_ajax_shipmethodsorder', array($this, 'ajax_shipmethodsorder'));
			add_action('wp_ajax_wpcoliveproductsearch', array($this, 'ajax_liveproductsearch'));
			add_action('wp_ajax_wpcoliveproductadd', array($this, 'ajax_liveproductadd'));
			add_action('wp_ajax_wpcoaddtoproductformfields', array($this, 'ajax_addtoproductformfields'));
			add_action('wp_ajax_wpcoshipmethodchange', array($this, 'ajax_shipmethodchange'));
			add_action('wp_ajax_nopriv_wpcoshipmethodchange', array($this, 'ajax_shipmethodchange'));
			add_action('wp_ajax_wpcodialog', array($this, 'ajax_dialog'));
			add_action('wp_ajax_emptycart', array($this, 'ajax_emptycart'));
			add_action('wp_ajax_nopriv_emptycart', array($this, 'ajax_emptycart'));
			add_action('wp_ajax_cartsummary', array($this, 'ajax_cartsummary'));
			add_action('wp_ajax_nopriv_cartsummary', array($this, 'ajax_cartsummary'));
			add_action('wp_ajax_wpcoshiprate', array($this, 'ajax_shiprate'));
			add_action('wp_ajax_wpcodeleteoption', array($this, 'ajax_deleteoption'));
			add_action('wp_ajax_wpcoautocompletecategories', array($this, 'ajax_autocomplete_categories'));
			
			$this -> ci_initialize();		
			return;
		}
		
		function qtranslate_remove() {
			if (!$this -> is_plugin_active('cqtranslate') && in_array($_GET['page'], (array) $this -> sections)) {
				remove_filter('the_editor', 'qtrans_modifyRichEditor');
			}
		}
		
		function after_plugin_row($plugin_name = null) {
	        $key = $this -> get_option('serialkey');
	        $update = $this -> vendor('update');
	        $version_info = $update -> get_version_info();
	        
	        if (!empty($version_info) && $version_info['is_valid_key'] == "0") {
		        echo '<tr class="plugin-update-tr">';
		        echo '<td colspan="3" class="plugin-update">';
		        echo '<div class="update-message">';
		        echo sprintf('Your download for the Shopping Cart plugin has expired, please <a href="%s" target="_blank">renew it</a> for updates!', $version_info['url']);
		        echo '</div>';
		        echo '</td>';
		        echo '</tr>';
	        }
	    }
	    
	    /**
		 * This function outputs the changelog on the 'Plugins' page when the "View Details" link is clicked.
		 */
	    function display_changelog() {  
	    	if (!empty($_GET['plugin']) && $_GET['plugin'] == $this -> plugin_name) {			
		    	$update = $this -> vendor('update');
		    	if ($changelog = $update -> get_changelog()) {
					$this -> render('changelog', array('changelog' => $changelog), true, 'admin');
		    	}
		    	
		    	exit();
	    	}
	    }
		
		function has_update($cache = true) {
			$update = $this -> vendor('update');
	        $version_info = $update -> get_version_info($cache);
	        return version_compare($this -> version, $version_info["version"], '<');
	    }
		
		function check_update($option, $cache = true) {
			$update = $this -> vendor('update');
	        $version_info = $update -> get_version_info($cache);
	
	        if (!$version_info) { return $option; }
	
	        $plugin_path = 'wp-checkout/wp-checkout.php';
	        
	        if(empty($option -> response[$plugin_path])) {
				$option -> response[$plugin_path] = new stdClass();
	        }
	
	        //Empty response means that the key is invalid. Do not queue for upgrade
	        if(!$version_info["is_valid_key"] || version_compare($this -> version, $version_info["version"], '>=')){
	            unset($option -> response[$plugin_path]);
	        } else {
	            $option -> response[$plugin_path] -> url = "http://tribulant.com";
	            $option -> response[$plugin_path] -> slug = $this -> plugin_name;
	            $option -> response[$plugin_path] -> package = $version_info['url'];
	            $option -> response[$plugin_path] -> new_version = $version_info["version"];
	            $option -> response[$plugin_path] -> id = "0";
	        }
	
	        return $option;
	    }
		
		function set_timezone() {
			@putenv("TZ=" . get_option('timezone_string'));
			@ini_set('date.timezone', get_option('timezone_string'));
			
			if (function_exists('date_default_timezone_set')) {
				@date_default_timezone_set(get_option('timezone_string'));
			}
		}
		
		function ajax_deleteoption() {
			
			if (!empty($_POST['option_id'])) {
				global $wpdb, $wpcoDb, $Option;
				$wpcoDb -> model = $Option -> model;
				$wpcoDb -> delete($_POST['option_id']);
			}
			
			exit();
			die();
		}
		
		function ajax_autocomplete_categories() {
			global $wpdb, $Category;
			$json = "";
		
			if (!empty($_REQUEST['term'])) {
				$query = "SELECT `id`, `title` FROM `" . $wpdb -> prefix . $Category -> table . "` WHERE `title` LIKE '%" . $_REQUEST['term'] . "%'";
				$titles = array();
				
				if ($categories = $wpdb -> get_results($query)) {
					$t = 0;
				
					foreach ($categories as $category) {
						$titles[$t]['value'] = $category -> id;
						$titles[$t]['label'] = $category -> title;
						$t++;
					}
					
					$json = json_encode($titles);
				}
			}
			
			echo $json;
		
			exit();
			die();
		}
		
		function ajax_productsorder() {
			global $wpdb, $Category, $Supplier, $Product, $wpcoCategoriesProduct;
			
			if (!empty($_REQUEST['product'])) {
				foreach ($_REQUEST['product'] as $order => $product_id) {
					if (!empty($product_id)) {
						if (!empty($_GET['category_id'])) {
							$query = "UPDATE `" . $wpdb -> prefix . $Category -> table . "` SET `pordertype` = 'custom' WHERE `id` = '" . $_GET['category_id'] . "'";
							$wpdb -> query($query);
							$query = "UPDATE `" . $wpdb -> prefix . $wpcoCategoriesProduct -> table . "` SET `order` = '" . ($order + 1) . "' WHERE `product_id` = '" . $product_id . "' AND `category_id` = '" . $_GET['category_id'] . "' LIMIT 1";
							$wpdb -> query($query);
						} elseif (!empty($_GET['supplier_id'])) {
							$query = "UPDATE `" . $wpdb -> prefix . $Supplier -> table . "` SET `pordertype` = 'custom' WHERE `id` = '" . $_GET['supplier_id'] . "'";
							$wpdb -> query($query);
							$query = "UPDATE `" . $wpdb -> prefix . $Product -> table . "` SET `supplier_order` = '" . ($order + 1) . "' WHERE `id` = '" . $product_id . "' LIMIT 1";
							$wpdb -> query($query);
						} else {
							$this -> update_option('loop_ordertype', "custom");
							$query = "UPDATE `" . $wpdb -> prefix . $Product -> table . "` SET `order` = '" . ($order + 1) . "' WHERE `id` = '" . $product_id . "' LIMIT 1";
							$wpdb -> query($query);
						}
					}
				}
				
				_e('Products have been ordered.', $this -> plugin_name);
			}
			
			exit();
			die();
		}
		
		function ajax_relatedproducts() {			
			if (!empty($_REQUEST['product_id'])) {
				global $wpcoDb, $wpcoProductsProduct;
				$product_id = $_REQUEST['product_id'];
				
				$wpcoDb -> model = $wpcoProductsProduct -> model;
				$wpcoDb -> delete_all(array('product_id' => $product_id));
			
				if (!empty($_REQUEST['related'])) {			
					foreach ($_REQUEST['related'] as $order => $related_id) {					
						if (is_numeric($related_id)) {						
							$data = array($wpcoProductsProduct -> model => array('product_id' => $product_id, 'related_id' => $related_id, 'order' => ($order + 1)));
							$wpcoDb -> model = $wpcoProductsProduct -> model;
							$wpcoDb -> save($data, true);
						}
					}
					
					_e('Related products have been updated', $this -> plugin_name);
				}
			}
			
			exit(); die();
		}
		
		function ajax_chart() {
			define('DOING_AJAX', true);
			define('SHORTINIT', true);
		
			global $wpdb, $Order, $Item, $wpcoHtml;
		
			include $this -> plugin_base() . DS . 'vendors' . DS . 'ofc' . DS . 'open-flash-chart.php';
			
			$type = (empty($_GET['type'])) ? "days" : $_GET['type'];
			$fromdate = (empty($_GET['from'])) ? date("Y-m-d", strtotime("-31 days")) : $_GET['from'];
			$todate = (empty($_GET['to'])) ? date("Y-m-d", time()) : $_GET['to'];
			
			switch ($type) {
				case 'years'			:
					$orders_query = "SELECT DATE(`completed_date`) AS `orders_date`, COUNT(`id`) AS `orders_count`, SUM(`total`) AS `orders_total`, 
					SUM(`discount`) AS `discounts_total`, SUM(`tax`) AS `tax_total`, SUM(`shipping`) AS `shipping_total` FROM " . $wpdb -> prefix . $Order -> table . " 
					WHERE CAST(`completed_date` AS DATE) BETWEEN '" . $fromdate . "' AND '" . $todate . "' AND `completed` = 'Y' AND id IN (SELECT order_id FROM " . $wpdb -> prefix . $Item -> table . " WHERE paid = 'Y') GROUP BY YEAR(completed_date)";
					
					$orders_total = $wpdb -> get_results($orders_query);	
					
					$orders_array = array();
					$discounts_array = array();
					$shipping_array = array();
					$tax_array = array();
					$orders_count_array = array();
					$orders_total_array = array();
					$discounts_total_array = array();
					$shipping_total_array = array();
					$tax_total_array = array();
					$dates_array = array();
					
					foreach ($orders_total as $ot) {
						$orders_count_array[date("Y", strtotime($ot -> orders_date))] = $ot -> orders_count;
						$orders_total_array[date("Y", strtotime($ot -> orders_date))] = $ot -> orders_total;
						$discounts_total_array[date("Y", strtotime($ot -> orders_date))] = $ot -> discounts_total;
						$shipping_total_array[date("Y", strtotime($ot -> orders_date))] = $ot -> shipping_total;
						$tax_total_array[date("Y", strtotime($ot -> orders_date))] = $ot -> tax_total;
					}
					
					$fromstamp = strtotime($fromdate);
					$tostamp = strtotime($todate);
					$yearsdiff = round(abs($tostamp - $fromstamp) / (60 * 60 * 24 * 365));
					
					for ($i = 0; $i <= $yearsdiff; $i++) {
						$datestring = date("Y", strtotime("-" . $i . " years", $tostamp));
						$dates_array[] = date("Y", strtotime("-" . $i . " years", $tostamp));
						
						if (empty($orders_total_array[$datestring])) {
							$orders_array[] = (int) 0;
						} else {
							$orders_array[] = $orders_total_array[$datestring];
							
							if (empty($y_max) || $orders_total_array[$datestring] > $y_max) {
								$y_max = $orders_total_array[$datestring];
							}
						}
						
						if (empty($discounts_total_array[$datestring])) {
							$discounts_array[] = 0;
						} else {
							$discounts_array[] = $discounts_total_array[$datestring];
						}
						
						if (empty($shipping_total_array[$datestring])) {
							$shipping_array[] = 0;
						} else {
							$shipping_array[] = $shipping_total_array[$datestring];
						}
						
						if (empty($tax_total_array[$datestring])) {
							$tax_array[] = 0;
						} else {
							$tax_array[] = $tax_total_array[$datestring];
						}
					}
					
					$dates_array = array_reverse($dates_array);
					$orders_array = array_reverse($orders_array);
					$discounts_array = array_reverse($discounts_array);
					$shipping_array = array_reverse($shipping_array);
					$tax_array = array_reverse($tax_array);
					
					$g = new graph();
					$g -> set_data($orders_array);
					$g -> line_hollow(3, 5, '#21759B', 'Orders', 10);
					$g -> set_tool_tip('#key#: ' . html_entity_decode($wpcoHtml -> currency()) . '#val#<br>#x_label#');
					
					if ($this -> get_option('shippingcalc') == "Y") {
						$g -> set_data($shipping_array);
						$g -> line_hollow(3, 5, '#999999', 'Shipping', 10);
					}
					
					if ($this -> get_option('tax_calculate') == "Y") {
						$g -> set_data($tax_array);
						$g -> line_hollow(3, 5, '#CCCCCC', 'Tax', 10);
					}
					
					if ($this -> get_option('enablecoupons') == "Y") {
						$g -> set_data($discounts_array);
						$g -> line_hollow(3, 5, '#5FB7DD', 'Discounts', 10);
					}
					
					// label each point with its value
					$g -> set_x_labels($dates_array);
					$g -> set_x_label_style(10, '#000000', 0, 1, '#E4F5FC');
					$g -> set_y_legend(__('Amount', $this -> plugin_name), 12, '#21759B');
					$g -> set_y_max(round($y_max, -1));
					$g -> y_label_steps(5);
					$g -> set_y_min(0);
					$g -> set_num_decimals(2);
					$g -> set_is_fixed_num_decimals_forced(true);
					$g -> set_is_decimal_separator_comma(false);
					$g -> set_is_thousand_separator_disabled(true);
					$g -> set_inner_background( '#f5f5f5', '#CBD7E6', 90);
					$g -> x_axis_colour( '#000000', '#E4F5FC' );
					$g -> y_axis_colour( '#000000', '#E4F5FC' );
					$g -> bg_colour = "#f5f5f5";
					echo $g -> render();
					break;
				case 'months'			:
					$orders_query = "SELECT DATE(`completed_date`) AS `orders_date`, COUNT(`id`) AS `orders_count`, SUM(`total`) AS `orders_total`, 
					SUM(`discount`) AS `discounts_total`, SUM(`tax`) AS `tax_total`, SUM(`shipping`) AS `shipping_total` FROM " . $wpdb -> prefix . $Order -> table . " 
					WHERE CAST(`completed_date` AS DATE) BETWEEN '" . $fromdate . "' AND '" . $todate . "' AND `completed` = 'Y' AND id IN (SELECT order_id FROM " . $wpdb -> prefix . $Item -> table . " WHERE paid = 'Y') GROUP BY MONTH(completed_date)";
					
					$orders_total = $wpdb -> get_results($orders_query);	
					
					$orders_array = array();
					$discounts_array = array();
					$shipping_array = array();
					$tax_array = array();
					$orders_count_array = array();
					$orders_total_array = array();
					$discounts_total_array = array();
					$shipping_total_array = array();
					$tax_total_array = array();
					$dates_array = array();
					
					foreach ($orders_total as $ot) {
						$orders_count_array[date("mY", strtotime($ot -> orders_date))] = $ot -> orders_count;
						$orders_total_array[date("mY", strtotime($ot -> orders_date))] = $ot -> orders_total;
						$discounts_total_array[date("mY", strtotime($ot -> orders_date))] = $ot -> discounts_total;
						$shipping_total_array[date("mY", strtotime($ot -> orders_date))] = $ot -> shipping_total;
						$tax_total_array[date("mY", strtotime($ot -> orders_date))] = $ot -> tax_total;
					}
					
					$fromstamp = strtotime($fromdate);
					$tostamp = strtotime($todate);
					$monthsdiff = round(abs($tostamp - $fromstamp) / 2628000);
					
					for ($i = 0; $i <= $monthsdiff; $i++) {
						$datestring = date("mY", strtotime("-" . $i . " months", $tostamp));
						$dates_array[] = date("F Y", strtotime("-" . $i . " months", $tostamp));
						
						if (empty($orders_total_array[$datestring])) {
							$orders_array[] = (int) 0;
						} else {
							$orders_array[] = $orders_total_array[$datestring];
							
							if (empty($y_max) || $orders_total_array[$datestring] > $y_max) {
								$y_max = $orders_total_array[$datestring];
							}
						}
						
						if (empty($discounts_total_array[$datestring])) {
							$discounts_array[] = 0;
						} else {
							$discounts_array[] = $discounts_total_array[$datestring];
						}
						
						if (empty($shipping_total_array[$datestring])) {
							$shipping_array[] = 0;
						} else {
							$shipping_array[] = $shipping_total_array[$datestring];
						}
						
						if (empty($tax_total_array[$datestring])) {
							$tax_array[] = 0;
						} else {
							$tax_array[] = $tax_total_array[$datestring];
						}
					}
					
					$dates_array = array_reverse($dates_array);
					$orders_array = array_reverse($orders_array);
					$discounts_array = array_reverse($discounts_array);
					$shipping_array = array_reverse($shipping_array);
					$tax_array = array_reverse($tax_array);
					
					$g = new graph();
					$g -> set_data($orders_array);
					$g -> line_hollow(3, 5, '#21759B', 'Orders', 10);
					$g -> set_tool_tip('#key#: ' . html_entity_decode($wpcoHtml -> currency()) . '#val#<br>#x_label#');
					
					if ($this -> get_option('shippingcalc') == "Y") {
						$g -> set_data($shipping_array);
						$g -> line_hollow(3, 5, '#999999', 'Shipping', 10);
					}
					
					if ($this -> get_option('tax_calculate') == "Y") {
						$g -> set_data($tax_array);
						$g -> line_hollow(3, 5, '#CCCCCC', 'Tax', 10);
					}
					
					if ($this -> get_option('enablecoupons') == "Y") {
						$g -> set_data($discounts_array);
						$g -> line_hollow(3, 5, '#5FB7DD', 'Discounts', 10);
					}
					
					// label each point with its value
					$g -> set_x_labels($dates_array);
					$g -> set_x_label_style(10, '#000000', 0, 2, '#E4F5FC');
					$g -> set_y_legend(__('Amount', $this -> plugin_name), 12, '#21759B');
					$g -> set_y_max(round($y_max, -1));
					$g -> y_label_steps(5);
					$g -> set_y_min(0);
					$g -> set_num_decimals(2);
					$g -> set_is_fixed_num_decimals_forced(true);
					$g -> set_is_decimal_separator_comma(false);
					$g -> set_is_thousand_separator_disabled(true);
					$g -> set_inner_background( '#f5f5f5', '#CBD7E6', 90);
					$g -> x_axis_colour( '#000000', '#E4F5FC' );
					$g -> y_axis_colour( '#000000', '#E4F5FC' );
					$g -> bg_colour = "#f5f5f5";
					echo $g -> render();
					break;
				case 'days'				:
				default					:				
					$orders_query = "SELECT DATE(`completed_date`) AS `orders_date`, COUNT(`id`) AS `orders_count`, SUM(`total`) AS `orders_total`, 
					SUM(`discount`) AS `discounts_total`, SUM(`tax`) AS `tax_total`, SUM(`shipping`) AS `shipping_total` FROM " . $wpdb -> prefix . $Order -> table . " 
					WHERE CAST(`completed_date` AS DATE) BETWEEN '" . $fromdate . "' AND '" . $todate . "' AND `completed` = 'Y' AND id IN (SELECT order_id FROM " . $wpdb -> prefix . $Item -> table . " WHERE paid = 'Y') GROUP BY DATE(completed_date)";
					
					$orders_total = $wpdb -> get_results($orders_query);	
					
					$orders_array = array();
					$discounts_array = array();
					$shipping_array = array();
					$tax_array = array();
					$orders_count_array = array();
					$orders_total_array = array();
					$discounts_total_array = array();
					$shipping_total_array = array();
					$tax_total_array = array();
					$dates_array = array();
					
					foreach ($orders_total as $ot) {
						$orders_count_array[date("dmY", strtotime($ot -> orders_date))] = $ot -> orders_count;
						$orders_total_array[date("dmY", strtotime($ot -> orders_date))] = $ot -> orders_total;
						$discounts_total_array[date("dmY", strtotime($ot -> orders_date))] = $ot -> discounts_total;
						$shipping_total_array[date("dmY", strtotime($ot -> orders_date))] = $ot -> shipping_total;
						$tax_total_array[date("dmY", strtotime($ot -> orders_date))] = $ot -> tax_total;
					}
					
					$fromstamp = strtotime($fromdate);
					$tostamp = strtotime($todate);
					$daysdiff = round(abs($tostamp - $fromstamp) / 86400);
					
					for ($i = 0; $i <= $daysdiff; $i++) {
						$datestring = date("dmY", strtotime("-" . $i . " days", $tostamp));
						$dates_array[] = date("M j", strtotime("-" . $i . " days", $tostamp));
						
						if (empty($orders_total_array[$datestring])) {
							$orders_array[] = (int) 0;
						} else {
							$orders_array[] = $orders_total_array[$datestring];
							
							if (empty($y_max) || $orders_total_array[$datestring] > $y_max) {
								$y_max = $orders_total_array[$datestring];
							}
						}
						
						if (empty($discounts_total_array[$datestring])) {
							$discounts_array[] = 0;
						} else {
							$discounts_array[] = $discounts_total_array[$datestring];
						}
						
						if (empty($shipping_total_array[$datestring])) {
							$shipping_array[] = 0;
						} else {
							$shipping_array[] = $shipping_total_array[$datestring];
						}
						
						if (empty($tax_total_array[$datestring])) {
							$tax_array[] = 0;
						} else {
							$tax_array[] = $tax_total_array[$datestring];
						}
					}
					
					$dates_array = array_reverse($dates_array);
					$orders_array = array_reverse($orders_array);
					$discounts_array = array_reverse($discounts_array);
					$shipping_array = array_reverse($shipping_array);
					$tax_array = array_reverse($tax_array);
					
					$g = new graph();
					$g -> set_data($orders_array);
					$g -> line_hollow(3, 5, '#21759B', 'Orders', 10);
					$g -> set_tool_tip( '#key#: ' . html_entity_decode($wpcoHtml -> currency()) . '#val#<br>#x_label#' );
					
					if ($this -> get_option('shippingcalc') == "Y") {
						$g -> set_data($shipping_array);
						$g -> line_hollow(3, 5, '#999999', 'Shipping', 10);
					}
					
					if ($this -> get_option('tax_calculate') == "Y") {
						$g -> set_data($tax_array);
						$g -> line_hollow(3, 5, '#CCCCCC', 'Tax', 10);
					}
					
					if ($this -> get_option('enablecoupons') == "Y") {
						$g -> set_data($discounts_array);
						$g -> line_hollow(3, 5, '#5FB7DD', 'Discounts', 10);
					}
					
					// label each point with its value
					$g -> set_x_labels($dates_array);
					$g -> set_x_label_style(10, '#000000', 0, 4, '#E4F5FC');
					$g -> set_y_legend(__('Amount', $this -> plugin_name), 12, '#21759B');
					$g -> set_y_max(round($y_max, -1));
					$g -> y_label_steps(5);
					$g -> set_y_min(0);
					$g -> set_num_decimals(2);
					$g -> set_is_fixed_num_decimals_forced(true);
					$g -> set_is_decimal_separator_comma(false);
					$g -> set_is_thousand_separator_disabled(true);
					$g -> set_inner_background( '#f5f5f5', '#CBD7E6', 90);
					$g -> x_axis_colour( '#000000', '#E4F5FC' );
					$g -> y_axis_colour( '#000000', '#E4F5FC' );
					$g -> bg_colour = "#f5f5f5";
					echo $g -> render();	
					break;
			}
			
			die();
			exit();
		}
		
		function ajax_importproducts() {
			global $wpdb, $wpcoHtml, $Category, $Product;
		
			if (!empty($_POST)) {			
				$product = maybe_unserialize(stripslashes($_POST['product']));
				$importoptions = maybe_unserialize(stripslashes($_POST['importoptions']));
				
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
	
					if (!file_exists($imagefull) || filesize($imagefull) == 0) {						
						$remoteurl = "";
						$remoteurl = (!empty($importoptions['imageprepend'])) ? $importoptions['imageprepend'] : "";
						$remoteurl .= $product['image'];
						
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
				}
				
				$product['oldimage'] = $imagename;
				unset($product['image']);
				
				// Is this an existing product?
				$productquery = "SELECT `id` FROM `" . $wpdb -> prefix . $Product -> table . "` WHERE `nicetitle` = '" . $product['nicetitle'] . "'";
				$productquery .= (!empty($product['code'])) ? " OR `code` = '" . $product['code'] . "'" : '';
				if ($product_id = $wpdb -> get_var($productquery)) {
					$product['id'] = $product_id;
				}
						
				if ($Product -> save($product, true, false, false, true, true)) {
					$output .= "Y" . "<|>";
					$output .= $product['title'] . "<|>";
				} else {
					$errormessage = "<ul>";
					foreach ($Product -> errors as $error) {
						$errormessage .= "<li>" . $error . "</li>";
					}
					$errormessage .= "</ul>";
				
					$output .= "N" . "<|>";
					$output .= $product['title'] . "<|>";
					$output .= $errormessage;
				}
			}
			
			echo $output;
			exit();
		}
		
		function ajax_shipmethodchange() {
			global $wpdb, $wpcoHtml, $wpcoShipmethod, $wpcoDb, $Order, $Item, $user_ID;
			
			$errors = array();
			$order_id = $Order -> current_order_id();
			
			foreach ($_POST[$this -> pre . 'shipping'] as $pkey => $pval) {										
				if ($user_ID) {
					//delete old user meta
					delete_user_meta($user_ID, 'ship_' . $pkey);
					
					if (!empty($pval)) {
						update_user_meta($user_ID, 'ship_' . $pkey, $pval);
					}
				}
				
				$wpcoDb -> model = $Order -> model;
				$wpcoDb -> save_field('ship_' . $pkey, $pval, array('id' => $order_id));
			}
			
			/* Validation of fields */
			if ($paymentfields = $this -> get_option('paymentfields')) {
				$shippingfields = $paymentfields['shipping'];
				
				foreach ($shippingfields as $skey => $shippingfield) {
					if (!empty($shippingfield['show']) && !empty($shippingfield['required'])) {
						if (empty($_POST[$this -> pre . 'shipping'][$skey])) {
							$errors[$skey] = __('Please fill in your ', $this -> plugin_name) . strtolower($shippingfield['title']);
						}
					}
				}
			}
	
			if (empty($errors)) {	
				if (!empty($_REQUEST[$this -> pre . 'shipmethod'])) {
					$wpcoDb -> model = $Order -> model;
					$wpcoDb -> save_field('shipmethod_id', $_POST[$this -> pre . 'shipmethod'], array('id' => $order_id));
					if ($user_ID) { update_user_meta($user_ID, 'shipmethod', $_POST[$this -> pre . 'shipmethod']); }
						
					$shipmethodquery = "SELECT * FROM " . $wpdb -> prefix . $wpcoShipmethod -> table . " WHERE id = '" . $_REQUEST[$this -> pre . 'shipmethod'] . "'";
				
					if ($shipmethod = $wpdb -> get_row($shipmethodquery)) {	
						$wpcoDb -> model = $Order -> model;
						$order = $wpcoDb -> find(array('id' => $order_id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order_id));
								
						if (!empty($shipmethod -> api)) {						
							switch ($shipmethod -> api) {
								case 'usps'					:
									if ($usps = $this -> vendor('usps', 'shipping' . DS . 'usps' . DS)) {
										$usps -> shipmethod($shipmethod);
									}
									break;
								case 'fedex'				:							
									if ($fedex = $this -> vendor('fedex', 'shipping' . DS . 'fedex' . DS)) {								
										$fedex -> shipmethod($shipmethod);
									}
									break;
								case 'auspost'				:
									if ($auspost = $this -> vendor('auspost', 'shipping' . DS)) {
										$auspost -> shipmethod($shipmethod);
									}
									break;
								case 'canadapost'			:
									if ($canadapost = $this -> vendor('canadapost', 'shipping' . DS . 'canadapost' . DS)) {
										$canadapost -> shipmethod($shipmethod);
									}
									break;
								case 'ups'					:
									if ($ups = $this -> vendor('ups', 'shipping' . DS . 'ups' . DS)) {
										$ups -> shipmethod($shipmethod);
									}
									break;
							}
							
							do_action($this -> pre . '_shipmethod_quote', $order, $items, $shipmethod);
						} else {
							$subtotal = $Order -> total($order_id, false, false, true, true, false, false);
							$shipping = $Order -> shipping_total($subtotal, $order_id);
							
							?><p><?php
							if (!empty($shipping) && $shipping > 0) {
								echo sprintf(__('Shipping cost for this order will be %s', $this -> plugin_name), '<strong>' . $wpcoHtml -> currency_price($shipping, true, true) . '</strong>');
							} else {
								_e('There is no shipping charge for this order.', $this -> plugin_name);
							}
							?></p><?php
						}
					}
				}
			} else {
				?><p><?php _e('Some errors occurred, please correct them to get a shipping quote.', $this -> plugin_name); ?></p><?php
				$this -> render('errors', array('errors' => $errors), true, 'default');
			}
		
			exit();
			die();
		}
		
		function ajax_dialog() {
			include $this -> plugin_base() . DS . 'js' . DS . 'tinymce' . DS . 'dialog.php';
			
			exit();
			die();
		}
		
		function ajax_emptycart() {
			global $wpcoDb, $Product, $Order, $wpcoCart, $wpcoFieldsOrder, $wpcoAuth, $user_ID, $Item;
			
			$errors = false;
			$co_id = $Order -> cart_order();
			
			if (!empty($co_id['id'])) {
				$wpcoDb -> model = $Item -> model;
				if ($wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']))) {
					$wpcoDb -> model = $wpcoFieldsOrder -> model;
					$wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']));
					if ($co_id['type'] == "order") {
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> delete($co_id['id']);
					} else {
						$wpcoDb -> model = $wpcoCart -> model;
						$wpcoDb -> delete($co_id['id']);
					}
	
					$successmsg = __('All items removed', $this -> plugin_name);
				}
			}
			
			global $wp_registered_sidebars;
			if (!empty($wp_registered_sidebars)) {
				foreach ($wp_registered_sidebars as $skey => $sidebar) {
					$args = $sidebar;
					break 1;
				}
			}
			
			$number = $this -> widget_active('cart');
			$intnumber = preg_replace("/[^0-9]/si", "", $number);
			$alloptions = $this -> get_option('-widget');
			$options = $alloptions[$intnumber];
			
			if ($number == $this -> widget_active('cart')) {
				$options['title'] = $this -> get_option('cart_hardcodedtitle');
			}
			
			$this -> render('widget-cart', array('args' => $args, 'number' => $number, 'isajax' => true, 'options' => $options, 'errors' => $errors, 'successmsg' => $successmsg), true, 'default');
			
			exit(); die();
		}
		
		function ajax_cartsummary() {
			global $wpdb, $wpcoDb, $Order, $wpcoCart, $Item;
			
			$co_id = $Order -> cart_order();
			$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
			$co = $wpcoDb -> find(array('id' => $co_id['id']));
			$wpcoDb -> model = $Item -> model;
			$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
			$this -> render('cart-summary', array('order' => $co, 'items' => $items, 'navigation' => true, 'couponform' => false), true, 'default');
			
			exit(); die();
		}
		
		function ajax_shiprate() {
			switch ($_GET['method']) {
				case 'save'				:
				
					$this -> render('shiprates' . DS . 'save', false, true, 'admin');
					break;
			}
			
			exit(); die();
		}
		
		function ajax_liveproductadd() {
			global $wpdb, $wpcoHtml, $Product;
		
			if (!empty($_REQUEST['product_id'])) {
				$productquery = "SELECT * FROM `" . $wpdb -> prefix . $Product -> table . "` WHERE `id` = '" . $_REQUEST['product_id'] . "'";
				
				if ($product = $wpdb -> get_row($productquery)) {
					$product = $this -> init_class('Product', $product);
				
					?>
					
					<li id="addedproducts<?php echo $product -> id; ?>">
						<a href="" onclick="if (confirm('<?php _e('Are you sure you want to remove this product?', $this -> plugin_name); ?>')) { jQuery('#addedproducts<?php echo $product -> id; ?>').remove(); } return false;"><img src="<?php echo $this -> url(); ?>/images/deny.png" alt="delete" /></a>
						<?php echo $wpcoHtml -> timthumb_image($product -> image_url, 50, 50, 100); ?>
						<?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?>
						<input type="hidden" name="wpcoField[products][]" value="<?php echo $product -> id; ?>" />
					</li>
					
					<?php	
				}
			}
			
			exit();
			die();
		}
		
		function ajax_liveproductsearch() {
			global $wpdb, $wpcoHtml, $Product;
		
			if (!empty($_POST['searchterm'])) {
				$productsquery = "SELECT * FROM " . $wpdb -> prefix . $Product -> table . " WHERE title LIKE '%" . $_POST['searchterm'] . "%'";
				
				if ($products = $wpdb -> get_results($productsquery)) {
					foreach ($products as $pkey => $product) {
						$products[$pkey] = $this -> init_class('Product', $product);
					}
				
					?>
					
					<h3><?php _e('Search results', $this -> plugin_name); ?></h3>
					<ul class="productschecklist">
						<?php /*<li id="addtoproducts_r" class="<?php echo $this -> pre; ?>lineitemdisabled"><?php _e('Search for products above.', $this -> plugin_name); ?></li>*/ ?>
	
					
					<?php
				
					foreach ($products as $product) {
						?>
						
						<li id="searchedproducts<?php echo $product -> id; ?>">
							<input onclick="if (this.checked == true) { live_product_add('<?php echo $product -> id; ?>'); }" type="checkbox" name="productschecklist" value="<?php echo $product -> id; ?>" id="productschecklist<?php echo $product -> id; ?>" />
							<label for="productschecklist<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> timthumb_image($product -> image_url, 50, 50, 100); ?></label>
							<label for="productschecklist<?php echo $product -> id; ?>"><?php echo stripslashes(apply_filters($this -> pre . '_product_title', $product -> title)); ?></label>
						</li>
						
						<?php
					}
					
					?>
					
					</ul>			
					<?php
				}
			}
			
			exit();
			die();
		}
		
		function ajax_addtoproductformfields() {
			if (!empty($_POST['addtoproducts'])) {
				foreach ($_POST['addtoproducts'] as $product_id) {
					if (!empty($product_id) && $product_id != "r") {
						?><input type="hidden" name="wpcoField[products][]" value="<?php echo $product_id; ?>" /><?php
					}
				}
			}
		
			exit();
			die();
		}
		
		function ajax_shipmethodsorder() {
			if (!empty($_REQUEST)) {
				if (!empty($_REQUEST['shipmethod'])) {
					global $wpdb, $wpcoShipmethod;
					
					foreach ($_REQUEST['shipmethod'] as $shipmethod_order => $shipmethod_id) {
						$query = "UPDATE `" . $wpdb -> prefix . $wpcoShipmethod -> table . "` SET `order` = '" . $shipmethod_order . "' WHERE `id` = '" . $shipmethod_id . "'";
						$wpdb -> query($query);
					}
					
					$message = __('The order of shipping methods has been saved.', $this -> plugin_name);	
				} else {
					$message = __('No shipping methods were specified.', $this -> plugin_name);	
				}
			} else {
				$message = __('No data was posted.', $this -> plugin_name);
			}
			
			echo $message;
		
			exit(); die();	
		}
		
		function ajax_serialkey() {
			$errors = array();
			$success = false;
			
			if (!empty($_REQUEST['delete'])) {		
				$this -> delete_option('serialkey');
				$errors[] = __('Serial key has been deleted.', $this -> plugin_name);
			} else {
				if (!empty($_POST)) {
					if (empty($_REQUEST['serialkey'])) { $errors[] = __('Please fill in a serial key.', $this -> plugin_name); }
					else { 
						$this -> update_option('serialkey', $_REQUEST['serialkey']);	//update the DB option
						
						if (!$this -> ci_serial_valid()) { $errors[] = __('Serial key is invalid, please try again.', $this -> plugin_name); }
						else {
							delete_transient($this -> pre . 'update_info');
							$success = true; 
						}
					}
				}
			}
			
			if (empty($_POST)) { ?><div id="<?php echo $this -> pre; ?>submitserial"><?php }
			$this -> render('submitserial', array('errors' => $errors, 'success' => $success), true, 'admin');
			if (empty($_POST)) { ?></div><?php }
			
			exit();
			die();
		}
		
		function ajax_ordershopcategories() {
			global $wpdb, $wpcoDb, $Category;
			
			if (!empty($_REQUEST['category'])) {
				foreach ($_REQUEST['category'] as $order => $category_id) {
					$wpcoDb -> model = $Category -> model;
					$wpcoDb -> save_field('order', $order, array('id' => $category_id));	
				}
				
				$message = __('Categories have been ordered.', $this -> plugin_name);
			} else {
				$message = __('No categories were posted.', $this -> plugin_name);
			}
			
			echo $message;
		
			exit();
			die();	
		}
		
		function ajax_ordersuppliers() {
			global $wpdb, $wpcoDb, $Supplier;
		
			if (!empty($_POST['supplier'])) {
				foreach ($_POST['supplier'] as $order => $supplier_id) {
					$wpdb -> query("UPDATE `" . $wpdb -> prefix . $Supplier -> table . "` SET `order` = '" . ($order + 1) . "' WHERE `id` = '" . $supplier_id . "' LIMIT 1");
				}
				
				_e('Suppliers have been ordered.', $this -> plugin_name);
			}
			
			exit();
			die();
		}
		
		function ajax_addtocart() {
			return false;
		}
		
		function ajax_featuredproduct() {
			global $wpdb, $Product;
		
			if (!empty($_POST['product_id'])) {
				$product_id = $_POST['product_id'];
				$status = $_POST['status'];
				$featuredquery = "UPDATE `" . $wpdb -> prefix . $Product -> table . "` SET `featured` = '" . $status . "' WHERE `id` = '" . $product_id . "' LIMIT 1";
				
				if ($wpdb -> query($featuredquery)) {
					$title = (empty($status)) ? __('Set this product as featured', $this -> plugin_name) : __('Set this product as not featured', $this -> plugin_name);
					$class = (empty($status)) ? 'featured featured_off' : 'featured featured_on';
					$onclick = (empty($status)) ? "wpco_featuredproduct('" . $product_id . "', '1'); return false;" : "wpco_featuredproduct('" . $product_id . "', '0'); return false;";
					echo '<a href="" title="' . $title . '" class="' . $class . '" onclick="' . $onclick . '"></a>';
				}
			}
			
			exit();
			die();
		}
		
		function ajax_updateproductprice() {	
			define('DOING_AJAX', true);
		    define('SHORTINIT', true);
					
			global $Product, $wpcoHtml;
			if (empty($_REQUEST['Item']['count'])) { $_REQUEST['Item']['count'] = 1; }
			$price = ($Product -> product_price($_REQUEST) * $_REQUEST['Item']['count']);
			
			if (!empty($price) && $price > 0) {
				$price = $wpcoHtml -> currency_price($price, false, true);
			} else {
				$price = $this -> get_option('product_zerotext');
			}
			
			echo $price;
			
			exit(); die();
		}
		
		function ajax_convertposttype() {
			global $wpcoDb, $Product;
			
			if (!empty($_REQUEST['post_id']) && !empty($_REQUEST['post_type'])) {
				$post = array();
				$post['ID'] = $_REQUEST['post_id'];
				$post['post_type'] = $_REQUEST['post_type'];
				
				if (wp_update_post($post)) {
					$wpcoDb -> model = $Product -> model;
					$wpcoDb -> save_field('p_type', $_REQUEST['post_type'], array('id' => $_REQUEST['product_id']));
					
					$message = __('Your post/page has been converted.', $this -> plugin_name);
				} else {
					$message = __('Post/page could not be saved.', $this -> plugin_name);
				}
			} else {
				$message = __('No post/page ID was specified for conversion.', $this -> plugin_name);	
			}
			
			echo $message;
			
			exit();
			die();	
		}
		
		function ajax_addproductvariationoption() {
			global $wpdb, $wpcoDb, $Style, $Option;
			
			if (!empty($_POST)) {
				header('Content-Type: text/xml; charset=utf-8');
				$success = "N";
				$errors = false;
				
				if ($Style -> save($_POST['newvariation'], true)) {
					$style_id = $Style -> insertid;
					
					if (!empty($_POST['newoptions'])) {
						foreach ($_POST['newoptions'] as $option) {
							$option['style_id'] = $style_id;
							$option['condprices'] = "N";
							
							if (!empty($option['price']) && $option['price'] > 0) { 
								$option['addprice'] = "Y"; 
							} else { 
								$option['addprice'] = "N"; $option['price'] = false; 
							}
							
							$wpcoDb -> model = $Option -> model;
							$wpcoDb -> save($option, true);	
						}
						
						$success = "Y";
					} else {
						$wpcoDb -> model = $Style -> model;
						$wpcoDb -> delete($style_id);
						$errors[] = __('No variation options were specified.', $this -> plugin_name);	
					}
				} else {
					$errors = $Style -> errors;
				}
				
				if ($success == "N") {
					$message = __('Product variation or options could not be saved, please try again.', $this -> plugin_name);
					$html = $this -> render('styles' . DS . 'save-ajax', array('errors' => $errors), false, 'admin');	
				} else {
					if (!empty($_GET['product_id'])) {
						global $wpcoDb, $Product;
						$wpcoDb -> model = $Product -> model;
						$wpcoDb -> find(array('id' => $_GET['product_id']));	
					}
					
					$message = __('Product variation and options have been saved.', $this -> plugin_name);
					$html = $this -> render('styles' . DS . 'product', false, false, 'admin');	
				}
				
				?>
				
				<result>
					<success><?php echo $success; ?></success>
					<message><![CDATA[<?php echo $message; ?>]]></message>
					<html><![CDATA[<?php echo $html; ?>]]></html>
				</result>
				
				<?php
			} else {
				if (!empty($_GET['style_id'])) {
					$Style -> get($_GET['style_id']);
					$_POST['newvariation'] = (array) $Style -> data;
				}
					
				$this -> render('styles' . DS . 'save-ajax', false, true, 'admin');	
			}
			
			exit(); 
			die();
		}
		
		function ajax_deleteproductvariation() {
			if (!empty($_POST['style_id'])) {
				global $wpcoDb, $Style;
				$wpcoDb -> model = $Style -> model;
				$wpcoDb -> delete($_POST['style_id']);
			}
			
			if (!empty($_GET['product_id'])) {
				global $wpcoDb, $Product;
				$wpcoDb -> model = $Product -> model;
				$wpcoDb -> find(array('id' => $_GET['product_id']));	
			}
			
			$this -> render('styles' . DS . 'product', false, true, 'admin');
			
			exit();
			die();	
		}
		
		function ajax_testsettings() {
			$errors = array();
			$success = false;
			
			if (empty($_POST['submitform']) && !empty($_POST)) {		
				foreach ($_POST as $pkey => $pval) {
					$this -> update_option($pkey, $pval);
				}
			}
			
			if (!empty($_POST['submitform']) && !empty($_POST)) {		
				if (empty($_POST['testemail'])) { $errors[] = __('Please fill in an email address', $this -> plugin_name); }
				elseif (!is_email($_POST['testemail'])) { $errors[] = __('Please fill in a valid email address', $this -> plugin_name); }
				
				if (empty($errors)) {
					$subject = __('Test Email', $this -> plugin_name);
					$message = __('This is a test email sent from the Shopping Cart plugin.', $this -> plugin_name);
					 
					if ($this -> send_mail($_POST['testemail'], $subject, $message)) {
						$success = true;
						$errors[] = __('Email was successfully sent, your settings are working!', $this -> plugin_name);	
					} else {
						global $phpmailer;
						$errors[] = $phpmailer -> ErrorInfo;
					}
				}
			}
			
			echo '<div id="testsettingswrapper">';
			$this -> render('testsettings', array('errors' => $errors, 'success' => $success), true, 'admin');
			echo '</div>';
			
			exit();	
			die();
		}
		
		function is_plugin_screen() {
			if (!empty($_GET['page'])) {
				if (in_array($_GET['page'], (array) $this -> sections)) {
					return true;	
				}
			}
			
			return false;
		}
		
		function is_supplier() {
			global $user_ID, $wpcoDb, $Supplier;
			
			if ($userdata = get_userdata($user_ID)) {
				$wpcoDb -> model = $Supplier -> model;
				
				if ($supplier = $wpcoDb -> find(array('user_id' => $user_ID))) {
					return $supplier;
				}
			}
			
			return false;	
		}
		
		function import() {
			echo $path = dirname(__FILE__) . DS . 'vendors' . DS . 'transmission' . DS . 'class.download.php';
			require_once($path);
			$transmission = new Download('FTP');		
			$this -> render('import' . DS . 'index', false, true, 'admin');
		}
		
		function content_product_metabox() {
			$this -> render('metaboxes' . DS . 'content-product', false, true, 'admin');
		}
		
		function image_metabox() {
			$this -> render('metaboxes' . DS . 'product-image', false, true, 'admin');
		}
		
		function categories_metabox() {
			$this -> render('metaboxes' . DS . 'product-categories', false, true, 'admin');
		}
		
		function contents_metabox() {
			$this -> render('metaboxes' . DS . 'product-contents', false, true, 'admin');
		}
		
		function pricing_metabox() {
			$this -> render('metaboxes' . DS . 'product-pricing', false, true, 'admin');
		}
		
		function fields_metabox() {
			$this -> render('metaboxes' . DS . 'product-fields', false, true, 'admin');
		}
		
		function print_scripts() {	
			$this -> enqueue_scripts();
		}
		
		function enqueue_scripts() {
		
			$stoppages = array(
				'codestyling-localization/codestyling-localization.php'
			);
			
			if (!empty($_GET['page']) && in_array($_GET['page'], $stoppages)) return;
		
			global $wpdb, $wpcoField;
		
			$theme_folder = $this -> get_option('theme_folder');
			wp_enqueue_script('jquery');
					
			if (is_admin()) {						
				wp_enqueue_script('colorbox', plugins_url() . '/' . $this -> plugin_name . '/views/' . $theme_folder . '/js/colorbox.js', array('jquery'), false, true);
				wp_enqueue_script('jquery-ui-autocomplete');
			
				if ((!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) || preg_match("/(widgets\.php)/si", $this -> url) || preg_match("/(plugins\.php)/i", $this -> url)) {
					wp_enqueue_script('jquery-ui-tabs');
					wp_enqueue_script('jquery-ui-datepicker', plugins_url() . '/' . $this -> plugin_name . '/js/jquery-ui-datepicker.js', array('jquery'), false, true);
					wp_enqueue_script('wp-checkout', plugins_url() . '/' . $this -> plugin_name . '/js/' . $this -> plugin_name . '.js', array('jquery'), $this -> version, true);		
					wp_enqueue_script('autoheight', plugins_url() . '/' . $this -> plugin_name . '/js/autoheight.js', array('jquery'), $this -> version, true);
					wp_enqueue_script('jquery-watermark', plugins_url() . '/' . $this -> plugin_name . '/js/jquery.watermark.js', array('jquery'), '1.0', true);
					wp_enqueue_script('jquery-ajaxupload', $this -> render_url('js/jquery.ajaxupload.js', 'admin', false), array('jquery'), '1.0', true);
					wp_enqueue_script('jquery-ui-tooltip', plugins_url() . '/' . $this -> plugin_name . '/js/jquery-ui-tooltip.js', array('jquery'), false, true);
					
					//Sortables
					if (true || ($_GET['page'] == 'checkout-products' && (!empty($_GET['method']) && $_GET['method'] == "related")) ||
						($_GET['page'] == 'checkout-fields' && (!empty($_GET['method']) && $_GET['method'] == "order")) ||
						($_GET['page'] == 'checkout-styles' && (!empty($_GET['method']) && $_GET['method'] == "order")) || 
						($_GET['page'] == 'checkout-styles' && (!empty($_GET['method']) && $_GET['method'] == "sort")) ||
						($_GET['page'] == 'checkout-categories' && (!empty($_GET['method']) && $_GET['method'] == "order")) ||
						($_GET['page'] == 'checkout-shipmethods' && (!empty($_GET['method']) && $_GET['method'] == "order")) ||
						($_GET['page'] == 'checkout-fields') && (!empty($_GET['method']) && $_GET['method'] == "save")) {
											
						wp_enqueue_script('jquery-ui-sortable', false, array('jquery'), false, true);
					}
					
					/* Progress Bar */
					if ($_GET['page'] == $this -> sections -> import_csv) {
						wp_enqueue_script('jquery-ui-progressbar', plugins_url() . '/' . $this -> plugin_name . '/js/jquery-ui-progressbar.js', array('jquery-ui-core', 'jquery-ui-widget'));
					}
					
					if ($_GET['page'] == 'checkout' ||
						$_GET['page'] == 'checkout-products-save' ||
						$_GET['page'] == 'checkout-content-save' ||
						$_GET['page'] == 'checkout-settings' ||
						$_GET['page'] == 'checkout-settings-pmethods' ||
						$_GET['page'] == 'checkout-settings-products' ||
						$_GET['page'] == 'checkout-settings-taxshipping' ||
						$_GET['page'] == 'checkout-settings-paymentfields' ||
						$_GET['page'] == 'checkout-settings-affiliates' ||
						$_GET['page'] == 'checkout-extensions-settings') {	
						//wp_enqueue_script('autosave');
							
						//Meta Boxes
						wp_enqueue_script('common', false, array(), false, true);
						wp_enqueue_script('wp-lists', false, array(), false, true);
						wp_enqueue_script('postbox', false, array(), false, true);				
						
						//Editor
						wp_enqueue_script('editor', false, array(), false, true);
						wp_enqueue_script('word-count', false, array(), false, true);
						wp_enqueue_script('media-upload', false, array(), false, true);
						add_action('admin_head', 'wp_tiny_mce');
						
						if ($_GET['page'] == "checkout") { wp_enqueue_script('welcome-editor', plugins_url() . '/' . $this -> plugin_name . '/js/editors/welcome.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-products-save") { wp_enqueue_script('products-editor', plugins_url() . '/' . $this -> plugin_name . '/js/editors/products.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-content-save") { wp_enqueue_script('content-editor', plugins_url() . '/' . $this -> plugin_name . '/js/editors/content.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-settings") { wp_enqueue_script('settings-editor', plugins_url() . '/' . $this -> plugin_name . '/js/editors/settings.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-settings-pmethods") { wp_enqueue_script('settings-pmethods', plugins_url() . '/' . $this -> plugin_name . '/js/editors/settings-pmethods.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-settings-products") { wp_enqueue_script('settings-products', plugins_url() . '/' . $this -> plugin_name . '/js/editors/settings-products.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-settings-taxshipping") { wp_enqueue_script('settings-taxshipping', plugins_url() . '/' . $this -> plugin_name . '/js/editors/settings-taxshipping.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-settings-paymentfields") { wp_enqueue_script('settings-paymentfields', plugins_url() . '/' . $this -> plugin_name . '/js/editors/settings-paymentfields.js', array('jquery'), false, true); }
						if ($_GET['page'] == "checkout-extensions-settings") { wp_enqueue_script('settings-extensions', plugins_url() . '/' . $this -> plugin_name . '/js/editors/settings-extensions.js', array('jquery'), false, true); }
						
						if ($_GET['page'] == "checkout-settings-affiliates" && $this -> is_plugin_active('affiliates')) {
							$settingsjs = site_url() . '/wp-content/plugins/checkout-affiliates/js/settings.js';
							wp_enqueue_script('settings-affiliates', $settingsjs, array('jquery'), false, true);	
						}
					}
				}
			} else {		
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-widget');
				if ($this -> get_option('loadscript_colorbox') == "Y") { wp_enqueue_script($this -> get_option('loadscript_colorbox_handle'), $this -> render_url('js/colorbox.js', 'default', false), array('jquery'), false, true); }
				wp_enqueue_script('wp-checkout', $this -> render_url('js/wp-checkout.js', 'admin', false), array('jquery'), $this -> version, true);
				if ($this -> get_option('loadscript_jqueryuitabs') == "Y") { wp_enqueue_script('jquery-ui-tabs'); }
				if ($this -> get_option('loadscript_jqueryuidatepicker') == "Y") { wp_enqueue_script($this -> get_option('loadscript_jqueryuidatepicker_handle'), $this -> render_url('js/jquery-ui-datepicker.js', 'admin', false), array('jquery'), false, true); }				
				if ($this -> get_option('loadscript_jqueryuibutton') == "Y") { wp_enqueue_script($this -> get_option('loadscript_jqueryuibutton_handle'), $this -> render_url('js/jquery-ui-button.js', 'admin', false), array('jquery'), false, true); }
				wp_enqueue_script('autoheight', $this -> render_url('js/autoheight.js', 'admin', false), array('jquery'), false, true);
				wp_enqueue_script('jquery-ddslick', $this -> render_url('js/jquery.ddslick.js', 'default', false), array('jquery'), false, true);
				wp_enqueue_script('jquery-ui-tooltip', plugins_url() . '/' . $this -> plugin_name . '/js/jquery-ui-tooltip.js', array('jquery'), false, true);
				
				$filefieldquery = "SELECT EXISTS(SELECT 1 FROM " . $wpdb -> prefix . $wpcoField -> table . " WHERE `type` = 'file')";
				if ($wpdb -> get_var($filefieldquery)) {
					wp_enqueue_script('ajaxupload', $this -> render_url('js/jquery.ajaxupload.js', 'default', false), array('jquery'), false, true);
				}
			}	
			
			add_thickbox();
			
			return true;
		}
		
		function print_styles() {	
			$this -> enqueue_styles();
		}
		
		function enqueue_styles() {	
			$theme_folder = $this -> get_option('theme_folder');
			
			if (is_admin()) {
				$src = plugins_url() . '/' . $this -> plugin_name . '/css/admin/' . $this -> plugin_name . '.css';
				$colorbox_src = plugins_url() . '/' . $this -> plugin_name . '/css/colorbox.css';
				$jqueryui_src = plugins_url() . '/' . $this -> plugin_name . '/css/jquery-ui.css';
			} else {
				if ($this -> get_option('customcss') == "Y") {
					$customsrc = plugins_url() . '/' . $this -> plugin_name . '/css/default/' . $this -> plugin_name . '-css.php';
					wp_enqueue_style($this -> pre . '-custom', $customsrc, null, $this -> version, "screen");
				}
				
				if ($this -> get_option('theme_usestyle') == "Y") {
					$src = $this -> render_url('style.css', 'default', false);
				}
				
				$colorbox_src = $this -> render_url('css/colorbox.css', 'default', false);
				$jqueryui_src = $this -> render_url('css/jquery-ui.css', 'default', false);
			}
			
			$ajaxupload_src = plugins_url() . '/' . $this -> plugin_name . '/views/' . $theme_folder . '/css/ajaxupload.css';
			wp_enqueue_style('ajaxupload', $ajaxupload_src, null, $this -> version, "screen");
			
			wp_enqueue_style('colorbox', $colorbox_src, null, $this -> version, "screen");
			wp_enqueue_style($this -> pre, $src, null, $this -> version, "screen");
			
			if (!is_admin() || in_array($_GET['page'], (array) $this -> sections)) {
				wp_enqueue_style('jquery-ui', $jqueryui_src, null, $this -> version, "screen");
			}
			
			return;
		}
		
		function check_uploaddir() {
			if (!is_admin()) return;
		
			global $uploaddir;
			$uploaddir = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . '' . DS;
			$imagesdir = $uploaddir . 'images' . DS;
			$ajaxuploaddir = $uploaddir . 'ajaxupload' . DS;
			$tt_cache = $uploaddir . 'cache' . DS;
			$tt_temp = $uploaddir . 'temp' . DS;
			$suppliersdir = $uploaddir . 'suppliers' . DS;
			$catimagesdir = $uploaddir . 'catimages' . DS;
			$downloadsdir = $uploaddir . 'downloads' . DS;
			$csvdir = $uploaddir . 'csv' . DS;
			$xmldir = $uploaddir . 'xml' . DS;
			$invoicedir = $uploaddir . 'invoice' . DS;
			$customfiles = $uploaddir . 'customfiles' . DS;
			$optionimagesdir = $uploaddir . 'optionimages' . DS;
			
			if (!file_exists($uploaddir)) {
				if (!@mkdir($uploaddir, 0777)) {
					$this -> render_err(__('Failed to create upload directory inside "/wp-content/uploads/". Please check permissions', $this -> plugin_name));
				} else {
					@chmod($uploaddir, 0777);
				}
			}
				
			if (file_exists($uploaddir)) {	
				if (!file_exists($optionimagesdir)) {
					@mkdir($optionimagesdir, 0777);
					@chmod($optionimagesdir, 0777);	
				}
				
				if ($this -> is_plugin_active('fdapi')) {
					$fdapidir = $uploaddir . 'fdapi' . DS;
				
					if (!file_exists($fdapidir)) {
						@mkdir($fdapidir, 0777);
						@chmod($fdapidir, 0777);
					}
				}
			
				/* TimThumb Cache Folder */
				if (!file_exists($tt_cache)) {
					@mkdir($tt_cache, 0777);
					@chmod($tt_cache, 0777);	
				}
				
				/* TimThumb Temp Folder */
				if (!file_exists($tt_temp)) {
					@mkdir($tt_temp, 0777);
					@chmod($tt_temp, 0777);	
				}
			
				if (!file_exists($imagesdir)) {
					@mkdir($imagesdir, 0777);
					@chmod($imagesdir, 0777);
				}
				
				if (!file_exists($ajaxuploaddir)) {
					@mkdir($ajaxuploaddir, 0777);
					@chmod($ajaxuploaddir, 0777);
				} else {
					$ajaxuploadindex = $ajaxuploaddir . 'index.php';
					$ajaxuploadindexcontent = "<?php /* Silence */ ?>";
					$ajaxuploadhtaccess = $ajaxuploaddir . '.htaccess';
					$ajaxuploadhtaccesscontent = "order allow,deny\r\ndeny from all\r\n\r\nOptions All -Indexes";
					if (!file_exists($ajaxuploadindex) && $fh = fopen($ajaxuploadindex, "w")) { fwrite($fh, $ajaxuploadindexcontent); fclose($fh); }
					if (!file_exists($ajaxuploadhtaccess) && $fh = fopen($ajaxuploadhtaccess, "w")) { fwrite($fh, $ajaxuploadhtaccesscontent); fclose($fh); }
				}
				
				if (!file_exists($suppliersdir)) {
					@mkdir($suppliersdir, 0777);
					@chmod($suppliersdir, 0777);
				}
				
				if (!file_exists($catimagesdir)) {
					@mkdir($catimagesdir, 0777);
					@chmod($catimagesdir, 0777);
				}
				
				if (!file_exists($downloadsdir)) {
					@mkdir($downloadsdir, 0777);
					@chmod($downloadsdir, 0777);
				}
				
				//csv
				if (!file_exists($csvdir)) {
					@mkdir($csvdir, 0777);
					@chmod($csvdir, 0777);
				}
				
				//xml
				if (!file_exists($xmldir)) {
					@mkdir($xmldir, 0777);
					@chmod($xmldir, 0777);
				}
				
				//invoices
				if (!file_exists($invoicedir)) {
					@mkdir($invoicedir, 0777);
					@chmod($invoicedir, 0777);
				}
				
				//custom files
				if (!file_exists($customfiles)) {
					@mkdir($customfiles, 0777);
					@chmod($customfiles, 0777);	
				}
			}
			
			return false;
		}
		
		function plugin_base() {
			return rtrim(dirname(__FILE__), '/');
		}
		
		function url() {
			return site_url() . '/' . substr(preg_replace("/\\" . DS . "/si", "/", $this -> plugin_base()), strlen(ABSPATH));
		}
		
		function user_login($username = null, $password = null, $cookie = true) {
			if (!empty($username)) {
				if (!empty($password)) {
					require_once(ABSPATH . WPINC . DS . 'pluggable.php');
					$user = new WP_User(0, $username);
					
					if (wp_login($username, $password, $cookie)) {
						wp_setcookie($username, $password, false, '', '', $cookie);
						return true;
					}
				}
			}
			
			return false;
		}
		
		function users_select() {
			global $wpdb, $wpcoDb, $Order;
		
			$select = array();
			
			$query = "SELECT `ID` FROM `" . $wpdb -> users . "`";
			if ($users = $wpdb -> get_results($query)) {
				foreach ($users as $user) {
					if ($userdata = $this -> userdata($user -> ID)) {
						if (!empty($userdata -> bill_fname) && !empty($userdata -> bill_lname)) {
							$select[$user -> ID] = $userdata -> bill_fname . ' ' . $userdata -> bill_lname . ' (' . $userdata -> bill_email . ')';
						} elseif (!empty($userdata -> first_name) && !empty($userdata -> last_name)) {
							$select[$user -> ID] = $userdata -> first_name . ' ' . $userdata -> last_name . ' (' . $userdata -> bill_email . ')';
						} else {
							$select[$user -> ID] = $userdata -> user_login . ' (' . $userdata -> bill_email . ')';
						}
						
						$wpcoDb -> model = $Order -> model;
						$orderscount = $wpcoDb -> count(array('user_id' => $user -> ID, 'completed' => "Y"));
						if (!empty($orderscount)) { $select[$user -> ID] .= ' (' . $orderscount . ' ' . __('completed orders', $this -> plugin_name) . ')'; }
					}
				}
			}
			
			return $select;
		}
		
		function get_userdata($user_id) {
			global $wpdb;
	
			if ( ! is_numeric( $user_id ) )
				return false;
		
			$user_id = absint( $user_id );
			if ( ! $user_id )
				return false;
		
			$userquery = "SELECT * FROM " . $wpdb -> usermeta . " WHERE user_id = '" . $user_id . "'";
			
			$userdata = array();
			$wpuserdata = get_userdata($user_id);
			$version = get_bloginfo('version');
			
			if (version_compare($version, "3.3") >= 0) {
				//This version of WordPress is 3.3+			
				if ($user = $wpdb -> get_results($userquery)) {
					foreach ($user as $u) {
						$userdata[$u -> meta_key] = $u -> meta_value;	
					}
					
					foreach ($wpuserdata -> data as $wpukey => $wpuval) {
						$userdata[$wpukey] = $wpuval;	
					}
				}
				
				return (object) $userdata;
			} else {
				//This version of WordPress is lower than 3.3
				return (object) $wpuserdata;
			}
		}
		
		function userdata($user_id = null) {
			global $user_ID, $wpcoDb, $Order, $Country;
			$oldmodel = $wpcoDb -> model;
	
			if ($user_ID || $user_id) {	
				$id = (empty($user_id)) ? $user_ID : $user_id;
			
				if (!empty($id)) {
					$userdata = $this -> get_userdata($id);
					
					if (!empty($userdata)) {				
						foreach ($userdata as $ukey => $uval) {
							switch ($ukey) {
								case 'ship_country'					:
									global $wpcoDb, $Country;
									$wpcoDb -> model = $Country -> model;
									$userdata -> ship_countrycode = $wpcoDb -> field('code', array('id' => $uval));
									if ($userdata -> ship_countrycode == "UK") { $userdata -> ship_countrycode = "GB"; } 
									$userdata -> ship_isocountrycode = $wpcoDb -> field('isocode', array('id' => $uval));
									$userdata -> ship_countryname = $wpcoDb -> field('value', array('id' => $uval));
									break;
								case 'bill_country'					:
									global $wpcoDb, $Country;
									$wpcoDb -> model = $Country -> model;
									$userdata -> bill_countrycode = $wpcoDb -> field('code', array('id' => $uval));
									if ($userdata -> bill_countrycode == "UK") { $userdata -> bill_countrycode = "GB"; } 
									$userdata -> bill_isocountrycode = $wpcoDb -> field('isocode', array('id' => $uval));
									$userdata -> bill_countryname = $wpcoDb -> field('value', array('id' => $uval));
									break;
							}
						}
					
						return $userdata;
					}
				}
			}
			
			$wpcoDb -> model = $oldmodel;
			return false;
		}
		
		function init_class($name = null, $params = array()) {
			if (!empty($name)) {
				if (!preg_match("/" . $this -> pre . "/i", $name)) {
					$name = $this -> pre . $name;
				}
			
				if (class_exists($name)) {						
					if ($class = new $name($params)) {				
						//unset($class -> fields);
						unset($class -> fields_tv);
						unset($class -> sections);
						unset($class -> classes);
							
						return $class;
					}
				}
			}
			
			$this -> init_class('Country');		
			return false;
		}
		
		function orderscleanout() {
			global $wpdb, $Order, $Item;
			
			/*$itemsquery = 
			"DELETE " . $wpdb -> prefix . $Order -> table . ", " . $wpdb -> prefix . $Item -> table . 
			" FROM " . $wpdb -> prefix . $Order -> table . " LEFT JOIN " . $wpdb -> prefix . $Item -> table . 
			" ON " . $wpdb -> prefix . $Order -> table . ".id = " . $wpdb -> prefix . $Item -> table . ".order_id WHERE 
			" . $wpdb -> prefix . $Order -> table . ".completed = 'N' AND " . $wpdb -> prefix . $Order -> table . ".modified 
			< DATE_SUB(NOW(), INTERVAL " . $this -> get_option('orderscleanoutdays') . " DAY) AND " . $wpdb -> prefix . $Item -> table . ".completed = 'N';";
			$wpdb -> query($itemsquery);*/
			
			$ordersquery = 
			"DELETE " . $wpdb -> prefix . $Order -> table . 
			" FROM " . $wpdb -> prefix . $Order -> table . " WHERE " . $wpdb -> prefix . $Order -> table . ".completed = 'N' 
			AND " . $wpdb -> prefix . $Order -> table . ".modified < DATE_SUB(NOW(), INTERVAL " . $this -> get_option('orderscleanoutdays') . " DAY);";
			$wpdb -> query($ordersquery);
			
			return true;
		}
		
		function orderscleanoutdays($days = 7) {
			$this -> update_option('orderscleanoutdays', $days);
			do_action($this -> pre . '_orderscleanout');
			wp_clear_scheduled_hook($this -> pre . '_orderscleanout');	
			$schedules = wp_get_schedules();
			$interval = 'hourly';	
			$timestamp = time() + $schedules[$interval]['interval'];
			wp_schedule_event($new_timestamp, $interval, $this -> pre . '_orderscleanout');
			
			return true;
		}
		
		function init() {		
			return true;
		}
		
		function check_roles() {
			global $wp_roles;
			$permissions = $this -> get_option('permissions');
			
			if ($role = get_role('administrator')) {		
				if (!empty($this -> sections)) {
					foreach ($this -> sections as $section_key => $section_menu) {								
						if (empty($role -> capabilities['checkout_' . $section_key])) {
							$role -> add_cap('checkout_' . $section_key);
							$permissions[$section_key][] = 'administrator';
						}
					}
					
					$this -> update_option('permissions', $permissions);
				}
			}
			
			return false;		
		}
		
		function init_roles($sections = null) {
			global $wp_roles;
			$sections = $this -> sections;
		
			/* Get the administrator role. */
			$role =& get_role('administrator');
	
			/* If the administrator role exists, add required capabilities for the plugin. */
			if (!empty($role)) {
				if (!empty($sections)) {			
					foreach ($sections as $section_key => $section_menu) {
						$role -> add_cap('checkout_' . $section_key);
					}
				}
			} elseif (empty($role) && !is_multisite()) {
				add_role('checkout', _e('Checkout Manager', $this -> plugin_name), $newrolecapabilities);
				$role = get_role('checkout');
				$role -> add_cap('read');
				foreach ($this -> sections as $section_key => $section_menu) {
					$role -> add_cap('checkout_' . $section_key);
				}
			}
			
			$customercapabilities['read'] = 1;
			add_role('customer', __('Customer', $this -> plugin_name), $customercapabilities);
			$role = get_role('customer');
			$role -> add_cap('read');
			
			$suppliercapabilities['read'] = 1;
			add_role('supplier', __('Supplier', $this -> plugin_name), $suppliercapabilities);
			$role = get_role('supplier');
			$role -> add_cap('read');
			$role -> add_cap('checkout_welcome');
			$role -> add_cap('checkout_products');
			$role -> add_cap('checkout_products_save');
			
			if (!empty($sections)) {
				$permissions = $this -> get_option('permissions');
				if (empty($permissions)) { $permissions = array(); }
			
				foreach ($sections as $section_key => $section_menu) {
					$wp_roles -> add_cap('administrator', 'checkout_' . $section_key);
					$permissions[$section_key][] = 'administrator';
					
					if ($section_key == "welcome" || $section_key == "products" || $section_key == "products_save") {
						$permissions[$section_key][] = 'supplier';
					}
				}
				
				$this -> update_option('permissions', $permissions);
			}
		}
		
		function updating_plugin() {		
			if (!is_admin()) {
				return;
			}
			
			if (!$this -> get_option('version')) {
				$this -> add_option('version', $this -> version);
				$this -> initialize_options();
				return;
			}
			
			if ($cur_version = $this -> get_option('version')) {
				$new_version = $cur_version;
			
				if (version_compare("1.6", $cur_version) === 1) {															
					$this -> initialize_options();
					$this -> initialize_classes();
					
					/* Countries Update */
					global $wpdb, $Country;
					$query = "TRUNCATE TABLE `" . $wpdb -> prefix . $Country -> table . "`";
					$wpdb -> query($query);
					wpcoCountry::initialize();
					
					/* Currency Update */
					global $currencies;
					include_once($this -> plugin_base() . DS . 'includes' . DS . 'currencies.php');
					$this -> update_option('currencies', $currencies);
					
					/* Turn Off Gzip Compression */
					$this -> update_option('gzip', "N");
					
					/* Update Payment Methods */
					global $paymentmethods;
					$this -> update_option('allpaymentmethods', $paymentmethods);
					
					/* Manual POS cards */
					$cctypes = array(
						'mastercard'		=>	__('MasterCard', $this -> plugin_name),
						'visa'				=>	__('Visa', $this -> plugin_name),
						'discover'			=>	__('Discover', $this -> plugin_name),
						'jcb'				=>	__('JCB', $this -> plugin_name),
						'aexpress'			=>	__('American Express', $this -> plugin_name),
						'dinersclub'		=>	__('Diners Club', $this -> plugin_name),
						'laser'				=>	__('Laser', $this -> plugin_name),
					);
					
					$this -> update_option('cctypes', $cctypes);				
					$this -> update_option('choosepassword', "N");
					
					/* Payment Fields */
					include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php';
					$this -> update_option('paymentfields', $paymentfields);
					
					/* Update TEXT to LONGTEXT */
					global $wpdb, $Product, $Category, $wpcoContent;
					
					$db_queries = array(
						"ALTER TABLE `" . $wpdb -> prefix . $Product -> table . "` CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
						"ALTER TABLE `" . $wpdb -> prefix . $Product -> table . "` CHANGE `keywords` `keywords` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
						"ALTER TABLE `" . $wpdb -> prefix . $Category -> table . "` CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
						"ALTER TABLE `" . $wpdb -> prefix . $Category -> table . "` CHANGE `keywords` `keywords` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
						"ALTER TABLE `" . $wpdb -> prefix . $wpcoContent -> table . "` CHANGE `content` `content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
						//changing the price field for donations
						"ALTER TABLE `" . $wpdb -> prefix . $Product -> table . "` CHANGE `price_type` `price_type` ENUM('fixed','tiers','donate','square') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'fixed'",
					);
					
					foreach ($db_queries as $query) {
						$wpdb -> query($query);	
					}
					
					$new_version = "1.6";
				} elseif (version_compare("1.6.1.2", $cur_version) === 1) {
					$this -> initialize_options();
					
					/* Add the LUCY payment gateway */
					$allpaymentmethods = $this -> get_option('allpaymentmethods');
					array_push($allpaymentmethods, "lucy");
					$this -> update_option('allpaymentmethods', $allpaymentmethods);
					
					$new_version = "1.6.1.2";
				} elseif (version_compare("1.6.5", $cur_version) === 1) {	
					global $wpdb, $wpcoField;
							
					/* Integrated Realex Payments realauth remote */
					$this -> initialize_options();	
					
					$customfieldquery = "ALTER TABLE `" . $wpdb -> prefix . $wpcoField -> table . "` CHANGE `type` `type` ENUM('text','textarea','select','checkbox','radio','pre_date') NOT NULL DEFAULT 'text'";
					$wpdb -> query($customfieldquery);
					
					$fieldtypes = $this -> get_option('fieldtypes');
					$fieldtypes['pre_date'] = __('Date Picker', $this -> plugin_name);
					$this -> update_option('fieldtypes', $fieldtypes);
					
					//the new version number			
					$new_version = "1.6.5";	
				}
				
				if (version_compare($cur_version, "1.6.5.7") < 0) {				
					$this -> initialize_options();
					
					if (!$this -> is_plugin_active('jqzoom')) {
						$this -> update_option('product_imagegallery', "colorbox");
						$this -> update_option('variations_optionthumbzoom', "N");
					}
					
					/* Add the Bartercard InternetPOS payment gateway */
					$allpaymentmethods = array('pp', 'pp_pro', 'payxml', 'tc', 'google_checkout', 'lucy', 'mb', 'monsterpay', 'netcash', 'sagepay', 'bw', 'cc', 'fd', 'cu', 're', 're_remote', 'ematters', 'authorize_aim', 'bartercard', 'ogone_basic', 'eway_shared', 'eupayment');
					delete_option($this -> pre . 'allpaymentmethods');
					$this -> update_option('allpaymentmethods', $allpaymentmethods);
					
					$fieldtypes = $this -> get_option('fieldtypes');
					if (empty($fieldtypes['pre_date'])) {
						$fieldtypes['pre_date'] = __('Date Picker', $this -> plugin_name);
						$this -> update_option('fieldtypes', $fieldtypes);
					}
					
					$new_version = "1.6.5.7";	
				}
	
				if (version_compare($cur_version, "1.6.6.2") < 0) {
					global $wpdb, $wpcoField;
						
					$this -> initialize_options();
					
					$customfieldquery = "ALTER TABLE `" . $wpdb -> prefix . $wpcoField -> table . "` CHANGE `type` `type` ENUM('text','textarea','select','checkbox','radio','pre_date') NOT NULL DEFAULT 'text'";
					$wpdb -> query($customfieldquery);
					
					$fieldtypes = $this -> get_option('fieldtypes');
					if (empty($fieldtypes['pre_date'])) {
						$fieldtypes['pre_date'] = __('Date Picker', $this -> plugin_name);
						$this -> update_option('fieldtypes', $fieldtypes);
					}
					
					$new_version = "1.6.6.2";	
				}
				
				if (version_compare($cur_version, "1.6.7.4") < 0) {
					$this -> initialize_options();
					require_once $this -> plugin_base() . DS . 'includes' . DS . 'shipping' . DS . 'fedex.php';
					
					$new_version = "1.6.7.4";
				}
				
				if (version_compare($cur_version, "1.6.9") < 0) {
					global $wpdb, $Order, $wpcoField, $Product, $Supplier;
				
					$this -> initialize_options();
					$this -> initialize_classes();
					
					if (!empty($this -> tablenames)) {
						foreach ($this -> tablenames as $tablename) {
							$query = "ALTER TABLE `" . $tablename . "` ENGINE=MyISAM;";
							$wpdb -> query($query);
						}
					}
					
					$ordersquery = "UPDATE " . $wpdb -> prefix . $Order -> table . " SET `completed_date` = `modified`";
					$wpdb -> query($ordersquery);
					$fieldtypequery = "ALTER TABLE `" . $wpdb -> prefix . $wpcoField -> table . "` CHANGE `type` `type` VARCHAR(50) NOT NULL DEFAULT 'text'";
					$wpdb -> query($fieldtypequery);
					$productptypequery = "ALTER TABLE `" . $wpdb -> prefix . $Product -> table . "` CHANGE `p_type` `p_type` VARCHAR(20) NOT NULL DEFAULT 'custom'";
					$wpdb -> query($productptypequery);
					
					include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php';
					$this -> update_option('fieldtypes', $fieldtypes);
					
					$paymentfields = $this -> get_option('paymentfields');
					if (empty($paymentfields['shipping']['email'])) { $paymentfields['shipping']['email'] = array('title' => __('Email Address', $this -> plugin_name), 'show' => 1, 'required' => 1); }
					if (empty($paymentfields['billing']['email'])) { $paymentfields['billing']['email'] = array('title' => __('Email Address', $this -> plugin_name), 'show' => 1, 'required' => 1); }
					$this -> update_option('paymentfields', $paymentfields);
					
					// Update suppliers to the new 'supplier' role
					$supplierquery = "SELECT `id`, `user_id` FROM `" . $wpdb -> prefix . $Supplier -> table . "`";
					if ($suppliers = $wpdb -> get_results($supplierquery)) {
						foreach ($suppliers as $supplier) {
							$user = new WP_User($user_id);
							$user -> set_role("supplier");
						}
					}				
					
					$new_version = "1.6.9";
				}
				
				if (version_compare($cur_version, "1.6.9.5") < 0) {
					global $wpdb, $Country, $Coupon;
					$this -> initialize_options();
					
					$query = "TRUNCATE TABLE `" . $wpdb -> prefix . $Country -> table . "`";
					$wpdb -> query($query);
					wpcoCountry::initialize();
					
					$discounttypequery = "ALTER TABLE `" . $wpdb -> prefix . $Coupon -> table . "` CHANGE `discount_type` `discount_type` TEXT NOT NULL";
					$wpdb -> query($discounttypequery);
					
					$new_version = "1.6.9.5";
				}
				
				//update the database version to the file version.
				$this -> update_option('version', $new_version);
			}	
		}
		
		function initialize_options() {	
			if (!is_admin()) {
				return;
			}
			
			$this -> check_tables();
			
			if (!$this -> get_option('version')) {
				$this -> add_option('version', $this -> version);	
			}
			
			/* Roles & Permissions */
			$this -> init_roles();
			
			include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php';
			
			$this -> add_option('orderscleanoutdays', "7");
			$this -> add_option('enablefavorites', "Y");
			$this -> add_option('favoritesshow', "products"); // "productsandloop" to display on category pages as well
			
			$this -> add_option('showcase', "N");
			$this -> add_option('showcasemsg', __('Call for more info', $this -> plugin_name));
			//add a TinyMCE button to the editor
			$this -> add_option('tinymcebutton', "Y");
			$this -> add_option('gzip', "N");
			$this -> add_option('thumbw', 200);
			$this -> add_option('thumbh', 200);
			//no image available URL
			$this -> add_option('noimageurl', site_url() . '/wp-content/plugins/' . $this -> plugin_name . '/images/noimage.jpg');
			$this -> add_option('cropthumb', "Y");
			//crop product image thumbnails to exact dimensions or to proportion
			$this -> add_option('cropthumbs', "Y");
			//product thumbnail quality
			$this -> add_option('thumbq', 80);
			//crop products loop thumbnails to exact dimensions or to proportion
			$this -> add_option('croploopthumbs', "Y");
			//product loop thumbnail quality
			$this -> add_option('loopthumbq', 80);
			$this -> add_option('gallerytab', "N");
			$this -> add_option('fieldsintab', "N");
			//displays a quantity field on product page. "N" will hide this field
			$this -> add_option('howmany', "Y");
			$this -> add_option('relatedintab', "N");
			$this -> add_option('related_display', "list");
			//small images dimensions
			$this -> add_option('smallw', 50);
			$this -> add_option('smallh', 50);
			$this -> add_option('smallq', 100);
			
			$this -> add_option('optionslinktb', "B");
			//category thumbnail width in PX
			$this -> add_option('catthumbw', 200);
			//category thumbnail height in PX
			$this -> add_option('catthumbh', 200);
			$this -> add_option('scatthumbw', 125);
			$this -> add_option('scatthumbh', 125);
			//should category thumbnails be cropped to exact dimensions
			$this -> add_option('cropcatthumbs', "Y");
			$this -> add_option('catdesc', "Y");
			$this -> add_option('catkw', "Y");
			$this -> add_option('cattitleshow', "Y");
			//should category page image be shown when available for the category?
			$this -> add_option('catimgshow', "N");
			//category image size case "Y" for the above (catimgshow)
			$this -> add_option('catimg', 'thumb');
			$this -> add_option('showsubcats', "Y");
			$this -> add_option('subcatheading', "Y");
			$this -> add_option('subcatdisplay', "list");
			$this -> add_option('subcatimgdisplay', "thumb");
			//extra product image thumbnail width in PX
			$this -> add_option('ithumbw', 125);
			//extra product image thumbnail height in PX
			$this -> add_option('ithumbh', 125);
			//should extra product image thumbnails be cropped to exact dimensions?
			$this -> add_option('cropithumbs', "Y");
			$this -> add_option('enablecoupons', "N");
			$this -> add_option('multicoupon', "N");
			$this -> add_option('couponssubtotal', "Y");
			$this -> add_option('couponsaffectts', "N");
			$this -> add_option('ordersummarysections', array('shipping', 'billing'));
			$this -> add_option('buynow', "N");
			$this -> add_option('buynowpmethod', 'pp');
			
			/* Currencies */
			//include the file with the currencies Array
			require_once($this -> plugin_base() . DS . 'includes' . DS . 'currencies.php');
			$this -> add_option('currencies', $currencies);
			
			$this -> add_option('currency', "USD");
			$this -> add_option('currency_position', "before");
			$this -> add_option('currency_decimalseparator', ".");
			$this -> add_option('loggedinonly', "N");
			$this -> add_option('registercaptcha', "N");
			$this -> add_option('registercaptcha_theme', "red");
			$this -> add_option('usernamepreference', "N");
			//allow new customers to type/choose their own password?
			$this -> add_option('choosepassword', "N");
			$this -> add_option('newuserrole', "customer");
			$this -> add_option('newusernotification', "Y");
			$this -> add_option('cookieduration', 7);
			$this -> add_option('shippingdetails', "Y");
			$this -> add_option('defcountry', "");
			$this -> add_option('createpages', "Y");
			$this -> add_option('rawsupport', "N");
			$this -> add_option('post_type', "custom");
			/* Default Page Templates */
			$this -> add_option('products_pagetemplate', "default");
			$this -> add_option('categories_pagetemplate', "default");
			$this -> add_option('suppliers_pagetemplate', "default");
			//should the content of posts/pages be automatically updated?
			$this -> add_option('pp_updatecontent', "Y");
			$this -> add_option('pagesparent', 'none');
			$this -> add_option('pimgcount', 3);
			$this -> add_option('cart_layout', "theme");
			$this -> add_option('cart_addajax', "N");
			$this -> add_option('cart_summary_overlay', "N");
			$this -> add_option('cart_scrollajax', "Y");
			$this -> add_option('cartpageadded', "N");
			$this -> add_option('cartpage_id', 'none');
			$this -> add_option('cart_continuelink', "Y");		
			$this -> add_option('searchpageadded', "N");
			$this -> add_option('searchpage_id', 'none');
			$this -> add_option('shippingcalc', "N");
			$this -> add_option('shippingmethodsdisplay', "select");
			$this -> add_option('shippingtype', 'fixed');
			$this -> add_option('shippingprice', 0);
			$this -> add_option('shiptierstype', "price");
			$this -> add_option('shipping_appendshiprate', "N");
			$this -> add_option('shipping_globalminimum', "N");
			$this -> add_option('shipping_minimum', "0");
			$this -> add_option('shipping_minimumweight', "N");
			$this -> add_option('shipping_minimumweight_value', "0");
			$this -> add_option('shipping_minimumweight_notification', __('Your order requires a minimum weight of X, please add more.', $this -> plugin_name));
			$this -> add_option('handling', "N");
			$this -> add_option('handling_title', __('Handling/Surcharge', $this -> plugin_name));
			$this -> add_option('handling_amount', "0");
			$this -> add_option('handling_calculation', "always");
			$this -> add_option('countriesadded', "N");
			$this -> add_option('shopurl', home_url());
			$this -> add_option('shopname', "Y");
			$this -> add_option('shoplogo', "Y");
			$this -> add_option('shoplogourl', $this -> url() . '/images/logo.png');
			
			/* Default Invoice Settings */
			$this -> add_option('invoice_enabled', "Y");
			$this -> add_option('invoice_enablepdf', "Y");
			$this -> add_option('invoice_options', "N");
			$this -> add_option('invoice_pdfshowfields', "N");
			$this -> add_option('invoice_paidstatus', "Y");
			$this -> add_option('invoice_productcode', "N");
			$this -> add_option('invoice_updated', "N");
			$this -> add_option('invoice_companyname', get_bloginfo('name'));
			$this -> add_option('invoice_logotype', "text");
			$this -> add_option('invoice_companylogo', $this -> url() . '/images/company-logo.jpg');
			$this -> add_option('invoice_companytel', "0123456789");
			$this -> add_option('invoice_companyfax', "0123456789");
			$this -> add_option('invoice_companyweb', get_bloginfo('home'));
			$this -> add_option('invoice_companyaddress', "123 My Street\r\nMy City\r\nMy State\r\nMy Country\r\n012345");
			
			/* Product Page */
			$this -> add_option('product_imagegallery', "colorbox");
			
			$this -> add_option('product_defaulttype', "digital");
			$this -> add_option('product_infoholderwidth', '300');
			$this -> add_option('product_zerotext', __('Configure for price', $this -> plugin_name));
			$this -> add_option('product_descriptionposition', "below");
			$this -> add_option('product_showspecs', "Y");
			$this -> add_option('product_showcategories', "Y");
			$this -> add_option('product_showkeywords', "Y");
			//how should products be displayed in the products loop (category pages)?
			$this -> add_option('loop_display', "grid");
			$this -> add_option('loop_changeviewmode', "Y");
			$this -> add_option('loop_zerotext', __('Configure for price', $this -> plugin_name));
			//should sorting options (title, price & date) be shown in the products loop?
			$this -> add_option('loopsorting', "Y");
			$this -> add_option('loop_thumblink', "product");	//what should thumbnails link to? product, image
			$this -> add_option('loop_ordertype', "specific");
			$this -> add_option('loop_orderfield', "modified");
			$this -> add_option('loop_orderdirection', "DESC");
			$this -> add_option('loop_titleposition', "above");
			$this -> add_option('loop_truncatetitle', 0);
			$this -> add_option('loop_truncatedescription', "125");
			$this -> add_option('loop_perpage', 6);
			$this -> add_option('loop_addbutton', "Y");
			$this -> add_option('loop_howmany', "Y");
			$this -> add_option('product_showstock', "Y");			//show the inventory/stock of a product if available
			$this -> add_option('product_sharingbuttons', "Y");
			$this -> add_option('loop_btntxt', "btn");
			$this -> add_option('loop_btnlnktext', __('Add to Basket', $this -> plugin_name));
			$this -> add_option('loop_imgw', 125);
			$this -> add_option('loop_imgh', 125);
			$this -> add_option('loop_showfields', "N"); //should varieties and custom fields be shown in the products loop
			
			/* Email Configuration */
			$this -> add_option('mail_type', 'mail');
			$this -> add_option('mail_from', get_option('admin_email'));
			$this -> add_option('mail_name', get_bloginfo('name'));
			$this -> add_option('smtp_host', 'mail.' . $_SERVER['HTTP_HOST']);
			$this -> add_option('smtp_auth', "N");
			$this -> add_option('smtp_user', 'smtpuser@' . $_SERVER['HTTP_HOST']);
			$this -> add_option('smtp_pass', 'smtppassword');
			$this -> add_option('cookieformat', "D, j M Y H:i:s");
			$this -> add_option('billcvv', "Y");
			$this -> add_option('merchantemail', get_option('admin_email'));
			$this -> add_option('unitextbox', "N");
			$this -> add_option('unitextboxintabs', "N");
			$this -> add_option('unitextboxmessage', '');
			$this -> add_option('unitextfieldset', "N");
			
			/* Product Variations & Options */
			$this -> add_option('variations_optionlabel', "Y");
			$this -> add_option('variations_optionthumbzoom', "N");
			$this -> add_option('variations_optionthumbw', "45");
			$this -> add_option('variations_optionthumbh', "45");
			$this -> add_option('variations_optionthumbq', "100");
			
			/* Suppliers */
			$this -> add_option('supimg', "full");
			$this -> add_option('supthumbw', 200);
			$this -> add_option('supthumbh', 0);
			$this -> add_option('supplierpages', "Y");
			$this -> add_option('hidesuppliers', "Y");
			$this -> add_option('supplierlogin', "Y");
			$this -> add_option('suppliercategories', "N");
			
			$this -> add_option('shortsearchresults', "Y");
			
			//weight measurements
			$weights = array('lb', 'oz', 'kg', 'g');
			$this -> add_option('weights', $weights);
			$this -> add_option('weightm', "kg");
			
			//tax
			$this -> add_option('tax_calculate', "N");
			$this -> add_option('tax_name', "VAT");
			$this -> add_option('tax_percentage', "14");
			$this -> add_option('tax_includeshipping', "N");
			$this -> add_option('tax_includeinproductprice', "N");
			
			//Custom CSS
			$this -> add_option('theme_folder', "default");
			$this -> add_option('theme_usestyle', "Y");
			$this -> add_option('customcss', "N");
			$this -> add_option('loadscript_colorbox', "Y");
			$this -> add_option('loadscript_colorbox_handle', "colorbox");
			$this -> add_option('loadscript_jqueryuitabs', "Y");
			$this -> add_option('loadscript_jqueryuitabs_handle', "jquery-ui-tabs");
			$this -> add_option('loadscript_jqueryuibutton', "Y");
			$this -> add_option('loadscript_jqueryuibutton_handle', "jquery-ui-button");
			$this -> add_option('loadscript_jqueryuidatepicker', "Y");
			$this -> add_option('loadscript_jqueryuidatepicker_handle', "jquery-ui-datepicker");		
			$this -> add_option('fieldtypes', $fieldtypes);
			
			$wproles = array(
				'1'				=>	'Contributors',
				'2'				=>	'Authors',
				'3'				=>	'',
				'4'				=>	'',
				'5'				=>	'',
				'6'				=>	'',
				'7'				=>	'Editors',
				'8'				=>	'',
				'9'				=>	'',
				'10'			=>	'Administrators',
			);
			
			$this -> add_option('wproles', $wproles);
			
			$perm = array(
				'overview'			=>	1,
				'categories'		=>	10,
				'products'			=>	10,
				'content'			=>	10,
				'files'				=>	10,
				'images'			=>	10,
				'suppliers'			=>	10,
				'styles'			=>	10,
				'options'			=>	10,
				'fields'			=>	10,
				'coupons'			=>	10,
				'orders'			=>	10,
				'items'				=>	10,
				'import'			=>	10,
				'shipping'			=>	10,
				'settings'			=>	10,
				'support'			=>	10,
			);
			
			$this -> add_option('perm', $perm);
			$this -> add_option('allpaymentmethods', $paymentmethods);
			
			/* PayGate XML */
			$payxml = array(
				'title'				=>	__('PayGate (XML)', $this -> plugin_name),
				'ver'				=>	"4.0",
				'threed'			=>	"Y",
				'pgid'				=>	"10011013800",
				'pwd'				=>	"test",
				
			);
			
			$this -> add_option('payxml', $payxml);
			
			/* WorldPay */
			$this -> add_option('worldpay_title', __('Credit card payments via WorldPay', $this -> plugin_name));
			$this -> add_option('worldpay_testMode', "Y");
			$this -> add_option('worldpay_instId', "10175473");
			
			/* MonsterPay */
			$this -> add_option('monsterpay_title', __('Credit Card payments with MonsterPay', $this -> plugin_name));
			$this -> add_option('monsterpay_MerchantIdentifier', "testseller1");
			$this -> add_option('monsterpay_Usrname', "testseller1@MonsterPay.com");
			$this -> add_option('monsterpay_Pwd', "testseller");
			
			/* Realex REMOTE */
			$re_remote = array(
				'title'				=>	__("Credit card payments through Realex Payments", $this -> plugin_name),
				'merchantid'		=>	"yourbusinessname",
				'account'			=>	"internet",
				'secret'			=>	"Y0uRSec3et",
			);
			$this -> add_option('re_remote', $re_remote);
			
			$re_cards = array(
				'VISA'				=>	__('Visa', $this -> plugin_name),
				'MC'				=>	__('MasterCard', $this -> plugin_name),
				'AMEX'				=>	__('American Express', $this -> plugin_name),
				'LASER'				=>	__('Laser', $this -> plugin_name),
				'SWITCH'			=>	__('Switch', $this -> plugin_name),
				'DINERS'			=>	__('Diners Club', $this -> plugin_name),
			);
			
			$this -> add_option('re_cards', $re_cards);
			$this -> add_option('re_cards_use', $re_cards);
			
			//PayPal Settings
			//PayPal Email Address
			$this -> add_option('pp_email', get_option('admin_email'));
			//Should PayPal sandbox be used?
			$this -> add_option('pp_sandbox', "N");
			$this -> add_option('pp_invoiceprefix', "INV");
			$this -> add_option('pp_notiftype', "none");
			$this -> add_option('pp_addressoverride', "N");
			$this -> add_option('pp_surcharge', "N");
			$this -> add_option('pp_surcharge_amount', "0");
			$this -> add_option('pp_surcharge_percentage', "0");
			
			/* PayPal Pro */
			$this -> add_option('pp_pro_title', __('PayPal (Pro)', $this -> plugin_name));
			$this -> add_option('pp_pro_paymenttype', "sale");
			$this -> add_option('pp_pro_api_username', "sdk-three_api1.sdk.com");
			$this -> add_option('pp_pro_api_password', "QFZCWN5HZM8VBG7Q");
			$this -> add_option('pp_pro_api_signature', "A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI");
			$this -> add_option('pp_pro_api_endpoint', "https://api-3t.sandbox.paypal.com/nvp");
			
			//Euro Payment Services SRL
			$this -> add_option('eupayment_name', __('Euro Payment Services SRL', $this -> plugin_name));
			$this -> add_option('eupayment_merchid', "12341234123");
			$this -> add_option('eupayment_key', "00112233445566778899AABBCCDDEEFF");
			$this -> add_option('eupayment_orderdesc', __('Shopping cart items online', $this -> plugin_name));
			$this -> add_option('eupayment_key', "00112233445566778899aabbccddeeff");
			
			//Ogone (basic) settings
			$this -> add_option('ogone_basic_caption', __('Credit card payment with Ogone', $this -> plugin_name));
			$this -> add_option('ogone_basic_pspid', "yourpspid");
			$this -> add_option('ogone_basic_mode', "prod");
			$this -> add_option('ogone_basic_sha1', "sha1INpassword23456789");
			$this -> add_option('ogone_basic_sha1out', "sha1OUTpassword23456789");
			$this -> add_option('ogone_basic_title', __('Order', $this -> plugin_name));
			$this -> add_option('ogone_basic_bgcolor', "white");
			$this -> add_option('ogone_basic_txtcolor', "black");
			$this -> add_option('ogone_basic_tblbgcolor', "white");
			$this -> add_option('ogone_basic_tbltxtcolor', "black");
			$this -> add_option('ogone_basic_buttonbgcolor', "");
			$this -> add_option('ogone_basic_buttontxtcolor', "black");
			$this -> add_option('ogone_basic_fonttype', "Arial");
			$this -> add_option('ogone_basic_logo', $this -> url() . "/images/logo.png");
			
			//eWay Shared 
			$this -> add_option('eway_shared_title', __('eWay (Shared)', $this -> plugin_name));
			$this -> add_option('eway_shared_customerid', "87654321");
			$this -> add_option('eway_shared_username', "TestAccount");
			$this -> add_option('eway_shared_invoicedescription', get_bloginfo('name') . ' ' . __('Order', $this -> plugin_name));
			
			//2CheckOut Settings
			//2CO Vendor ID
			$this -> add_option('tc_vendorid', 12345);
			//2CO Vendor Secret
			$this -> add_option('tc_secret', 'secretstring');
			//Should 2CO be used in DEMO mode?
			$this -> add_option('tc_demo', "N");
			$this -> add_option('tc_method', 'multi');
			
			//MoneyBookers Settings
			$this -> add_option('mb_title', __('Credit and debit card payments with Skrill (Moneybookers)', $this -> plugin_name));
			//MoneyBookers email address
			$this -> add_option('mb_email', get_option('admin_email'));
			//MoneyBookers secret string
			$this -> add_option('mb_secret', 'secretstring');
			
			/* LUCY Gateway */
			$lucy = array(
				'title'			=>	__('Credit card payments with LUCY Gateway', $this -> plugin_name),
				'username'		=>	"TribulanPay",
				'password'		=>	"Test3375",
				'server'		=>	"staging",
			);
			
			$this -> add_option('lucy', $lucy);
			
			/* Virtual Merchant Settings */
			$this -> add_option('virtualmerchant_title', __('Virtual Merchant', $this -> plugin_name));
			$this -> add_option('virtualmerchant_showform', "Y");
			$this -> add_option('virtualmerchant_accountid', "321123");
			$this -> add_option('virtualmerchant_userid', "321123");
			$this -> add_option('virtualmerchant_userpin', "A8BCDE");
			$this -> add_option('virtualmerchant_demo', "N");
			$this -> add_option('virtualmerchant_testmode', "N");
			
			$shippingtiers = array(0 => array('min' => '1', 'max' => '100', 'price' => '10'), 1	=> array('min' => '101', 'max' => '250', 'price' => '15'), 2 => array('min' => '251', 'max' => '500', 'price' => '25'));		
			$this -> add_option('shippingtiers', $shippingtiers);
			
			$this -> add_option('gc_merchant_id', "merchantid");
			$this -> add_option('gc_merchant_key', "merchantkey");
			$this -> add_option('gc_sandbox', "N");
			
			
			$bwdetails = array(
				'beneficiary'		=>	__('Your Name', $this -> plugin_name),
				'name'				=>	__('Your Banks Name', $this -> plugin_name),
				'phone'				=>	'0123456789',
				'address'			=>	__('123 Street Name, Bank City, Bank State, Bank Country, 012345', $this -> plugin_name),
				'account'			=>	'987654321',
				'swift'				=>	"SW9IF3T",
			);
			
			$this -> add_option('bwdetails', $bwdetails);
			
			$cctypes = array(
				'mastercard'		=>	__('MasterCard', $this -> plugin_name),
				'visa'				=>	__('Visa', $this -> plugin_name),
				'discover'			=>	__('Discover', $this -> plugin_name),
				'jcb'				=>	__('JCB', $this -> plugin_name),
				'aexpress'			=>	__('American Express', $this -> plugin_name),
				'dinersclub'		=>	__('Diners Club', $this -> plugin_name),
				'laser'				=>	__('Laser', $this -> plugin_name),
			);
			
			$this -> add_option('cctypes', $cctypes);
			
			//Custom/Manual Payment Settings
			$this -> add_option('cu_title', __("Manual Payment", $this -> plugin_name));
			$this -> add_option('cu_message', __("Please contact us for further payment instructions.", $this -> plugin_name));
			$this -> add_option('cu_zerototal', "Y");
			$this -> add_option('cu_markpaid', "N");
	
			$this -> add_option('fd_title', __('Credit- and debit card payments via First Data', $this -> plugin_name));
			$this -> add_option('fd_store', "0123456789");
			$this -> add_option('fd_secret', "38303837383539343335343430393831303235303238303031383134313531303730323838393539333034313834353535343037323033313533393034353036");
			$this -> add_option('fd_test', "Y");
			$this -> add_option('fd_timezone', "EST");
			
			//Realex Payments
			$this -> add_option('re_title', __('Realex Payments', $this -> plugin_name));
			$this -> add_option('re_merchantid', 'realexmerchantid');
			$this -> add_option('re_secret', 'y0uRs3cRe7');
			$this -> add_option('re_test', "N");
			$this -> add_option('re_account', "internet");
			
			//eMatters
			$this -> add_option('ematters_title', __('eMatters', $this -> plugin_name));
			$this -> add_option('ematters_merchantid', 36);
			$this -> add_option('ematters_bank', "StGeorge");
			$this -> add_option('ematters_readers', "MEL036");
			$this -> add_option('ematters_bracket', "N");
			
			//Authorize.net AIM
			$this -> add_option('authorize_aim_title', __('Authorize.net AIM', $this -> plugin_name));
			$this -> add_option('authorize_aim_login', "4t24Ey8sB5");
			$this -> add_option('authorize_aim_trankey', "38b9J82h4zwCqML6");
			$this -> add_option('authorize_aim_test', "N");
			
			/* Bartercard InternetPOS settings */
			$this -> add_option('bartercard_url', "https://secure.spectrummessage.com.au:8893/InternetPOS/");
			$this -> add_option('bartercard_title', __('Bartercard InternetPOS', $this -> plugin_name)); 
			$this -> add_option('bartercard_trans', "PUR");
			$this -> add_option('bartercard_merchant', "MG440096");
			$this -> add_option('bartercard_TRN', "");
			$this -> add_option('bartercard_MerchantType', "1619991");
			
			/** Shipping Methods **/
			/* FedEx (Federal Express) */
			require_once($this -> plugin_base() . DS . 'includes' . DS . 'shipping' . DS . 'fedex.php');
			
			/* USPS (US Postal Service) */
			require_once($this -> plugin_base() . DS . 'includes' . DS . 'shipping' . DS . 'usps.php');		
			
			//Captions, texts, messages, etc...
			$wpcocaptions = array(
				'product'		=>	array(
					'keywords'				=>	__('Keywords', $this -> plugin_name),
					'supplier'				=>	__('Supplier', $this -> plugin_name),
					'category'				=>	__('Category', $this -> plugin_name),
					'categories'			=>	__('Categories', $this -> plugin_name),
					'clicktoenlarge'		=>	__('Click for large image', $this -> plugin_name),
					'oos'					=>	__('Out of Stock', $this -> plugin_name),
				)
			);
			
			$this -> add_option('captions', $wpcocaptions);
			
			require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php';
			$this -> add_option('paymentfields', $paymentfields);		
			$this -> add_option('allproductsppid', "0");
			$this -> add_option('cartpage_id', "0");
			$this -> add_option('accountpage_id', "0");
			
			/* Predefined Pages */
			$this -> predefined_pages();
		
			return true;
		}
		
		function is_plugin_active($name = null, $orinactive = false) {
			if (!empty($name)) {
				require_once ABSPATH . 'wp-admin' . DS . 'includes' . DS . 'admin.php';
				
				include $this -> plugin_base() . DS . 'includes' . DS . 'extensions.php';
				$this -> extensions = apply_filters($this -> pre . '_extensions_list', $extensions);
				
				if (!empty($this -> extensions)) {						
					$extensions = apply_filters($this -> pre . '_extensions_list', $this -> extensions);				
				
					foreach ($extensions as $extension) {
						if ($name == $extension['slug']) {									
							$path = $extension['plugin_name'] . DS . $extension['plugin_file'];
						}
					}
				}
				
				if (empty($path)) {
					switch ($name) {
						case 'qtranslate'			:
							$path = 'qtranslate' . DS . 'qtranslate.php';
							break;
						case 'captcha'				:
							$path = 'really-simple-captcha' . DS . 'really-simple-captcha.php';
							break;
						default						:
							$path = $name;
							break;
					}
				}
				
				$path2 = str_replace("\\", "/", $path);
				
				if (!empty($path)) {
					$plugins = get_plugins();
					
					if (!empty($plugins)) {
						if (array_key_exists($path, $plugins) || array_key_exists($path2, $plugins)) {
							/* Let's see if the plugin is installed and activated */
							if (is_plugin_active(plugin_basename($path)) ||
								is_plugin_active(plugin_basename($path2))) {
								return true;
							}
							
							/* Maybe the plugin is installed but just not activated? */
							if (!empty($orinactive) && $orinactive == true) {
								if (is_plugin_inactive(plugin_basename($path)) ||
									is_plugin_inactive(plugin_basename($path2))) {
									return true;	
								}
							}	
						}
					}
				}
			}
			
			return false;
		}
		
		function predefined_pages() {
			global $wp_rewrite, $user_ID;
			require_once(ABSPATH . WPINC . DS . 'rewrite.php');
			
			if (!is_object($wp_rewrite)) { $wp_rewrite = new WP_Rewrite(); }
			
			//set the layout to the WordPress theme
			$this -> update_option('cart_layout', "theme");
			
			/* Create a post for editor images */
			$createimagespost = false;
			if ($edimagespost = $this -> get_option('edimagespost')) {
				if ($imagespost = get_post($edimagespost)) {
					$createimagespost = false;	
				} else {
					$createimagespost = true;	
				}
			} else {
				$createimagespost = true;	
			}
			
			if ($createimagespost == true) {
				$post = array(
					'post_title'			=>	__('Shopping Cart plugin images', $this -> plugin_name),
					'post_content'			=>	__('This is a placeholder for the Shopping Cart plugin. You may edit and reuse this post but do not remove it.', $this -> plugin_name),
					'post_type'				=>	"post",
					'post_status'			=>	"draft",
					'post_author'			=>	$user_ID,
				);	
				
				if ($post_id = wp_insert_post($post)) {	
					$this -> update_option('edimagespost', $post_id);
				}
			}
			
			/* Create the "Shop" page */
			if ($this -> get_option('shop_page_added') != "Y" || !$this -> get_option('allproductsppid')) {
				$shop_page = array('post_title' => __('Shop', $this -> plugin_name), 'post_content' => "[" . $this -> pre . "products]", 'post_status' => "publish", 'post_type' => "page", 'post_parent' => $this -> get_option('pagesparent'), 'post_category' => false);
				$shop_page_id = wp_insert_post($shop_page);
				$this -> update_option('shop_page_added', "Y");
				$this -> update_option('allproductsppid', $shop_page_id);
			} else {
				$shop_page_id = $this -> get_option('allproductsppid');	
			}
			
			/* Create the "Shopping Cart" page */
			if ($this -> get_option('cart_page_added') != "Y" || !$this -> get_option('cartpage_id')) {
				$cart_page = array('post_title' => __('Shopping Cart', $this -> plugin_name), 'post_content' => "[" . $this -> pre . "cart]", 'post_status' => "publish", 'post_type' => "page", 'post_parent' => $shop_page_id, 'post_category' => false);
				$cart_page_id = wp_insert_post($cart_page);
				$this -> update_option('cart_page_added', "Y");
				$this -> update_option('cartpage_id', $cart_page_id);
			}
			
			/* Create the "Your Account" page */
			if ($this -> get_option('account_page_added') != "Y" || !$this -> get_option('accountpage_id')) {
				$account_page = array('post_title' => __('Your Account', $this -> plugin_name), 'post_content' => "[" . $this -> pre . "account]", 'post_status' => "publish", 'post_type' => "page", 'post_parent' => $shop_page_id, 'post_category' => false);
				$account_page_id = wp_insert_post($account_page);
				$this -> update_option('account_page_added', "Y");
				$this -> update_option('accountpage_id', $account_page_id);
			}
			
			/* Create the "Search Products" page */
			if ($this -> get_option('search_page_added') != "Y" || !$this -> get_option('searchpage_id')) {
				$search_page = array('post_title' => __('Search Products', $this -> plugin_name), 'post_content' => "[" . $this -> pre . "search]", 'post_status' => "publish", 'post_type' => "page", 'post_parent' => $shop_page_id, 'post_category' => false);
				$search_page_id = wp_insert_post($search_page);
				$this -> update_option('search_page_added', "Y");
				$this -> update_option('searchpage_id', $search_page_id);
			}
		}
		
		function product_permalink($post_link, $post, $leavename, $sample) {
		    if (false !== strpos($post_link, '%productcategory%')) {
		        $productcategory = get_the_terms($post -> ID, 'productcategory');
		        
		        if (!empty($productcategory) && is_array($productcategory)) {
		        	$post_link = str_replace('%productcategory%', array_pop($productcategory) -> slug, $post_link);
		        }
		    }
		    
		    return $post_link;
		}
		
		function updatepages($update = true) {
			$this -> predefined_pages();
			
			if ($this -> get_option('createpages') == "Y") {
				global $wpdb, $wpcoHtml, $wpcoDb, $Category, $Product, $Supplier;
				
				$post_type = $this -> get_option('post_type');
				$pagesparent = $this -> get_option('pagesparent');
				$categoriesparent = $this -> get_option('categoriesparent');
				
				//total pages updated
				$p = 0;
						
				/* Category Pages */	
				if ($categories = $Category -> find_all(false, "`id`, `title`, `parent_id`, `post_id`, `page_template`, `wpcat_id`, `wpcat_parent`")) {			
					foreach ($categories as $category) {
						$this -> remove_server_limits();
						$category_post_type = ($post_type == "custom") ? 'product-category' : $post_type;
						
						$cat_ID = false;
						$catparent = false;
						$catarr = false;
						$page = false;
						
						$default_categories_pagetemplate = $this -> get_option('categories_pagetemplate');
						$categories_pagetemplate = (empty($category -> page_template)) ? $default_categories_pagetemplate : $category -> page_template; //page template
						
						//WordPress Categories
						if (!empty($category -> parent_id)) {
							$wpcoDb -> model = $Category -> model;
							$catparent = $wpcoDb -> find(array('id' => $category -> parent_id));
						}
						
						$query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $category -> post_id . "'";
						
						//WordPress Post/Page
						$page = array(
							'ID'			=>	($wpdb -> get_var($query)) ? $category -> post_id : false,
							'post_title'	=>	$category -> title,
							'post_parent'	=>	(empty($category -> parent_id)) ? $pagesparent : $Category -> field('post_id', array('id' => $category -> parent_id)),
							'post_category'	=>	(empty($catarr['category_parent'])) ? array($categoriesparent) : array($catarr['category_parent']),
							'post_status'	=>	'publish',
							'post_type'		=>	$category_post_type,
							'pptype'		=>	$Category -> model,
							'rid'			=>	$category -> id,
						);
	
						if ($update == true || ($update == false && empty($page['ID']))) {
							
							$page['post_content'] = "[" . $this -> pre . "category id=" . $category -> id . "]";
							if ($this -> get_option('pp_updatecontent') == "N" && !empty($category -> post_id)) {
								if ($cur_page = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $category -> post_id . "' AND `post_status` = 'publish'")) {
									$page['post_content'] = $cur_page -> post_content;	
								}
							}
							
							if ($post_id = wp_insert_post($page)) {
								$p++;						
								$wpcoDb -> model = $Category -> model;
								$wpcoDb -> save_field('post_id', $post_id, array('id' => $category -> id));
								
								/* Page Template */
								if (!empty($post_type) && ($post_type == "page" || $post_type == "custom")) {								
									update_post_meta($post_id, '_wp_page_template', $categories_pagetemplate);
								}
							}
						}
						
						$catparent = false;
						$cat_ID = false;
						$post_id = false;
						$categories_pagetemplate = 'default';					
						flush();
					}
				}
				
				/* Product Pages */
				if ($products = $Product -> find_all(false, "`id`, `title`, `p_type`, `post_id`, `post_category`, `page_template`")) {								
					$product_post_type = ($post_type == "custom") ? 'product' : $post_type;
				
					foreach ($products as $product) {
						$this -> remove_server_limits();
						$query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $product -> post_id . "'";
						
						$default_products_pagetemplate = $this -> get_option('products_pagetemplate');
						$products_pagetemplate = (empty($product -> page_template)) ? $default_products_pagetemplate : $product -> page_template;
					
						$page = array(
							'ID'			=>	($wpdb -> get_var($query)) ? $product -> post_id : false,
							'post_title'	=>	$product -> title,
							//'post_content'	=>	"[" . $this -> pre . "product id=" . $product -> id . "]",
							'post_category'	=>	maybe_unserialize($product -> post_category),
							'post_status'	=>	'publish',
							//'post_type'		=>	(empty($product -> p_type) ? $post_type : $product -> p_type),
							'post_type'		=>	$product_post_type,
							'pptype'		=>	$Product -> model,
							'tags_input'	=>	$product -> keywords,
							'rid'			=>	$product -> id,
						);
						
						if ($post_type == "page" || $post_type == "custom") {
							$page['post_parent'] = (empty($product -> categories[0])) ? $pagesparent : $Category -> field('post_id', array('id' => $product -> categories[0]));	
						}
						
						// Does this product have a post/page password?
						if (!empty($product -> post_password)) {
							$page['post_password'] = $product -> post_password;	
						}
	
						if ($update == true || ($update == false && empty($page['ID']))) {					
							$page['post_content'] = "[" . $this -> pre . "product id=" . $product -> id . "]";
							if ($this -> get_option('pp_updatecontent') == "N" && !empty($product -> post_id)) {
								if ($cur_page = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $product -> post_id . "' AND `post_status` = 'publish'")) {
									$page['post_content'] = $cur_page -> post_content;	
								}
							}
							
							if ($post_id = wp_insert_post($page)) {
								$p++;
								$wpcoDb -> model = $Product -> model;
								$wpcoDb -> save_field('post_id', $post_id, array('id' => $product -> id));
								$wpcoDb -> save_field('p_type', ((empty($product -> p_type)) ? $post_type : $product -> p_type), array('id' => $product -> id));
								
								/* Page Template */
								if (!empty($post_type) && ($post_type == "page" || $post_type == "custom")) {
									update_post_meta($post_id, "_wp_page_template", $products_pagetemplate);
								}
							}
						}
						
						$products_pagetemplate = 'default';					
						flush();
					}
				}
		
				/* Supplier Pages */
				if ($this -> get_option('supplierpages') == "Y") {				
					$wpcoDb -> model = $Supplier -> model;
					if ($suppliers = $wpcoDb -> find_all(false, "`id`, `name`, `post_id`, `page_template`")) {
						//shuffle($suppliers);
						$supplier_post_type = ($post_type == "custom") ? 'product-supplier' : $post_type;
					
						foreach ($suppliers as $supplier) {
							$this -> remove_server_limits();
							$query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $supplier -> post_id . "'";
							
							$default_suppliers_pagetemplate = $this -> get_option('suppliers_pagetemplate');
							$suppliers_pagetemplate = (empty($supplier -> page_template)) ? $default_suppliers_pagetemplate : $supplier -> page_template;
					
							$page = array(
								'ID'			=>	(!empty($supplier -> post_id) && $wpdb -> get_var($query)) ? $supplier -> post_id : false,
								'post_title'	=>	$supplier -> name,
								'post_parent'	=>	$pagesparent,
								'post_category'	=>	array($categoriesparent),
								'post_status'	=>	'publish',
								'post_type'		=>	$supplier_post_type,
								'pptype'		=>	$Supplier -> model,
								'rid'			=>	$supplier -> id,
							);
	
							if ($update == true || ($update == false && empty($page['ID']))) {							
								$page['post_content'] = "[" . $this -> pre . "supplier id=" . $supplier -> id . "]";
								if ($this -> get_option('pp_updatecontent') == "N" && !empty($supplier -> post_id)) {
									if ($cur_page = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $supplier -> post_id . "' AND `post_status` = 'publish'")) {
										$page['post_content'] = $cur_page -> post_content;	
									}
								}
								
								if ($post_id = wp_insert_post($page)) {
									$p++;
									$wpcoDb -> model = $Supplier -> model;
									$wpcoDb -> save_field('post_id', $post_id, array('id' => $supplier -> id));
									
									/* Page Template */
									if (!empty($post_type) && $post_type == "page") {
										update_post_meta($post_id, "_wp_page_template", $suppliers_pagetemplate);	
									}
								}
							}
							
							$suppliers_pagetemplate = 'default';
							flush();
						}
					}
				}
				
				global $wp_rewrite;
				$wp_rewrite -> flush_rules();
				return $p;
			}
			
			return false;
		}
		
		function wpimporting() {
			@define("WP_IMPORTING", true);
			global $wp_rewrite;
			$wp_rewrite -> permalink_structure = false;
			
			return true;
		}
		
		function remove_server_limits() {
			if (!ini_get('safe_mode')) {
				@set_time_limit(0);
				@ini_set('memory_limit', '256M');
				@ini_set('upload_max_filesize', '128M');
				@ini_set('post_max_size', '256M');
				@ini_set('max_input_time', 0);
				@ini_set('max_execution_time', 0);
				@ini_set('expect.timeout', 0);
				@ini_set('default_socket_timeout', 0);
				return true;
			}
				
			return false;
		}
		
		function initialize_pages() {
			global $wpdb;
			return;
			
			if ($this -> get_option('createpages') == "Y") {		
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
			}
			
			return true;
		}
		
		function add_option($name = null, $value = null) {
			if (add_option($this -> pre . $name, $value)) {
				return true;
			}
			
			return false;
		}
		
		function update_option($name = null, $value = null) {
			if (update_option($this -> pre . $name, $value)) {
				return true;
			}
			
			return false;
		}
		
		function delete_option($name = null) {
			if (!empty($name)) {
				if (delete_option($this -> pre . $name)) {
					return true;
				}
			}
			
			return false;
		}
		
		function get_option($name = null, $stripslashes = true) {
			if ($option = get_option($this -> pre . $name)) {
				if (maybe_unserialize($option) !== false) {
					return maybe_unserialize($option);
				}
				
				if ($stripslashes == true) {
					$option = stripslashes_deep($option);
				}
				
				$option = apply_filters($this -> pre . '_get_option_' . $name, $option);			
				return $option;
			}
			
			return false;
		}
		
		function can_download($file_id = null) {
			global $wpdb, $wpcoDb, $Item, $Product, $File, $user_ID;
		
			if (!empty($file_id)) {
				if ($user_ID) {
					$wpcoDb -> model = $File -> model;
					
					if ($file = $wpcoDb -> find(array('id' => $file_id))) {
						$wpcoDb -> model = $Product -> model;
					
						if ($product = $wpcoDb -> find(array('id' => $file -> product_id))) {
							$wpcoDb -> model = $Item -> model;
							
							if ($items = $wpcoDb -> find_all(array('product_id' => $product -> id, 'paid' => "Y", 'user_id' => $user_ID))) {
								if (!empty($items)) {
									return true;
								}
							}
						}
					}
				}
			}
			
			return false;
		}
		
		function has_downloads($user_id = null) {
			global $wpdb, $wpcoDb, $Item, $File, $user_ID;
			$id = (empty($user_id)) ? $user_ID : $user_id;
			
			if (!empty($id)) {
				$wpcoDb -> model = $Item -> model;
				
				$itemsquery = "SELECT * FROM " . $wpdb -> prefix . $Item -> table . " as i LEFT JOIN " . $wpdb -> prefix . $File -> table . " as f ON i.product_id = f.product_id WHERE i.paid = 'Y' AND i.user_id = '" . $id . "'";
				if ($items = $wpdb -> get_results($itemsquery)) {
					return true;
				}
			}
		
			return false;
		}
		
		function finalize_order($order_id = null, $pmethod = 'pp', $buynow = false, $paid = "Y") {
			global $wpdb, $wpcoHtml, $wpcoAuth, $Javascript, $user_ID, $wpcoDb, $Product, $Supplier, 
			$Style, $Category, $Coupon, $Discount, $Option, $ProductsOption, $Order, $Item, $File, $wpcoField; 
			
			if (!empty($order_id)) {
				$wpcoDb -> model = $Order -> model;
			
				if ($order = $wpcoDb -> find(array('id' => $order_id))) {				
					$user_id = $order -> user_id;	// ID of the WordPress user				
					// 'wpco_order_finished' action hook
					do_action($this -> pre . '_order_finished', $order_id, $pmethod, $paid);
					
					$orderquery = "UPDATE `" . $wpdb -> prefix . $Order -> table . "` SET 
					`completed_date` = '" . date("Y-m-d H:i:s") . "', 
					`modified` = '" . date("Y-m-d H:i:s") . "',
					`completed` = 'Y',
					`pmethod` = '" . $pmethod . "'
					WHERE `id` = '" . $order_id . "'";
					$wpdb -> query($orderquery);
					
					$order -> pmethod = $pmethod;									
					$wpcoDb -> model = $Item -> model;
				
					if ($items = $wpcoDb -> find_all(array('order_id' => $order_id))) {	
						if ($order -> completed != "Y" && $order -> paid != "Y") {
							if (!empty($paid) && $paid == "Y") {
								$order -> paid = "Y";	
							}
						
							$sarray = array();
						
							foreach ($items as $ikey => $item) {					
								$wpcoDb -> model = $Item -> model;
								$items[$ikey] -> completed = "Y";
								$wpcoDb -> save_field('completed', "Y", array('id' => $item -> id));
								$items[$ikey] -> paid = "Y";
								$wpcoDb -> save_field('paid', $paid, array('id' => $item -> id));
		
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
							
							$user = $this -> userdata($order -> user_id);
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
				$this -> redirect($wpcoHtml -> retainquery("wpcomethod=cosuccess&order_id=" . $order -> id, $wpcoHtml -> cart_url()), false, false, true);
			} elseif ($pmethod == "worldpay") {
				?>
	            
	            <meta http-equiv="refresh" content="0;url=<?php echo $worldpay_url; ?>" /> 
	            
				<?php	
				
				exit(); die();
			}
				
			$userdata = $this -> userdata();			
			$title = __('Order Completed', $this -> plugin_name);
			
			ob_start();
			
			?>
			
			<h2><?php _e('Order Completed', $this -> plugin_name); ?></h2>
			
			<?php
			
			$content = ob_get_contents();
			ob_end_clean();
			
			$content .= $this -> render('success', array('order' => $order, 'items' => $items, 'user' => $userdata), false, 'default');
			global $wpcothemedoutput;
			$wpcothemedoutput = $content;		
			return $content;
		}
		
		function process_order($title = null, $order = null, $user = null, $pmethod = null, $params = null) {
			global $user_ID, $wpdb, $wpcoDb, $wpcoHtml, $Order, $Product, $ProductsOption, $Item, $wpcothemedoutput;
			$content = "";
			
			$order_id = $Order -> current_order_id();
			$wpcoDb -> model = $Order -> model;
			$order = $wpcoDb -> find(array('id' => $order_id));
			$wpcoDb -> model = $Item -> model;
			$items = $wpcoDb -> find_all(array('order_id' => $order_id));
			
			if (!$user_ID) {
				$user = $order;
			}
		
			if (!empty($pmethod)) {
				$order -> pmethod = $pmethod;		
				switch ($pmethod) {
					/* Google Checkout payment method */
					case 'gc'					:
						$gCheckout = $this -> vendor('googlecheckout');
						$content = $this -> render('checkout-gc', array('order' => $order, 'user' => $user, 'params' => $params), false, 'default');
						$gCheckout -> post_args = $content;
						
						$response = $gCheckout -> send_request();											
						$headers = $gCheckout -> parse_headers($response);											
						$body = $gCheckout -> get_body_x($response);
						
						$status_code = array();
						preg_match('/\d\d\d/', $headers[0], $status_code);
						
						require_once($this -> plugin_base . DS . 'vendors' . DS . 'gc' . DS . 'xml' . DS . 'class.gc_xmlparser.php');
						$xml_parser = new gc_xmlparser($body);
						$root = $xml_parser -> GetRoot();
						$data = $xml_parser -> GetData();
						
						header('Location: ' . $data[$root]['redirect-url']['VALUE']);
						exit();
						break;
					/* Bank Wire payment method */
					case 'bw'					:
						global $Order, $Item;
					
						$this -> finalize_order($order -> id, "bw", false, "N");
					
						$title = __('Order Completed', $this -> plugin_name);
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						//show the user that the checkout procedure has been completed
						$this -> render('steps', array('step' => "finished", 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Order Completed', $this -> plugin_name); ?></h3>
						
						<?php
						
						//clean the output buffer and obtain the content of it
						$content = ob_get_clean();
						$content .= $this -> render('checkout-bw', array('order' => $order, 'items' => $items, 'user' => $user), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					/* Custom/Manual Payment Method */
					case 'cu'					:
						$cu_markpaid = $this -> get_option('cu_markpaid');
						$cu_paid = (!empty($cu_markpaid) && $cu_markpaid == "Y") ? "Y" : "N";
						$this -> finalize_order($order -> id, "cu", false, $cu_paid);
						$title = __('Order Completed', $this -> plugin_name);
						ob_start();
						$this -> render('steps', array('step' => "finished", 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Order Completed', $this -> plugin_name); ?></h3>
						
						<?php
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout-cu', array('order' => $order, 'items' => $items, 'user' => $user), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					/* Manual POS (CC) payment mehtod */
					case 'cc'					:	
						$this -> finalize_order($order -> id, "cc", false, "N");				
						$title = __('Order Completed', $this -> plugin_name);
					
						//start output buffering
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						//show the user that the checkout procedure has been completed
						$this -> render('steps', array('step' => "finished", 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Order Completed', $this -> plugin_name); ?></h3>
						
						<?php
						
						//clean the output buffer and obtain the content of it
						$content = ob_get_clean();
						$content .= $this -> render('checkout-cc', array('order' => $order, 'items' => $items, 'user' => $user), false, 'default');
						
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						break;
					/* eMatters payment method */
					case 'ematters'				:
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your card number, CVV, expiry date and cardholder name.', $this -> plugin_name); ?></p>
						
						<?php
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout-' . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					/* PayGate (XML) */
					case 'payxml'				:
						$errors = false;
						
						$content = "";
						ob_start();
						$this -> render('steps', array('step' => "checkout", 'order' => $order), true, 'default');					
						?><h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3><?php
						?><p><?php _e('Please fill in your card number, expiry date and CVV to place your order.', $this -> plugin_name); ?></p><?php
						
						global $wpcoDb, $wpcoHtml, $Order, $Item;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						$content = ob_get_clean();
						$content .= $this -> render('checkout' . DS . 'paygate_xml', array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					/* Realex realauth remote */
					case 're_remote'			:
						$errors = false;
						
						$content = "";
						ob_start();
						$this -> render('steps', array('step' => "checkout", 'order' => $order), true, 'default');					
						?><h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3><?php
						?><p><?php _e('Please fill in your card number, expiry date and CVV to place your order.', $this -> plugin_name); ?></p><?php
						
						global $wpcoDb, $wpcoHtml, $Order, $Item;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						$content = ob_get_clean();
						$content .= $this -> render('checkout' . DS . 'realex-remote', array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					/* Authorize.net AIM payment method */
					case 'authorize_aim'		:
						$errors = null;
					
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
	
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout-' . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
					//Bartercard InternetPOS
					case 'bartercard'			:
						$errors = null;
					
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Bartercard Details', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your Bartercard customer card number to proceed.', $this -> plugin_name); ?></p>
						
						<?php
						//neha
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout' . DS . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						break;
					//PayPal website payments pro
					case 'pp_pro' :
						$errors = null;
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your card number, expiry date and CVV to place your order.', $this -> plugin_name); ?></p>
	
						<?php
						
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout-' . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						break;
					case 'lucy'					:
						$errors = null;
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Payment Information', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your payment information in order to complete your order.', $this -> plugin_name); ?></p>
	
						<?php
						
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout' . DS . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						break;
					case 'mb'					:
						$errors = null;
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Payment Information', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your payment information in order to complete your order.', $this -> plugin_name); ?></p>
	
						<?php
						
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						$content .= $this -> render('checkout-' . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
						
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						break;
					/* APCO Limited */
					case 'apco'					:
						ob_start();
						
						if ($this -> is_plugin_active('apco')) {
							if ($apco = $this -> extension_vendor('apco')) {
								$apco -> iframe($order -> id);
							}
						}
						
						$content = ob_get_clean();
						$wpcothemedoutput = $content;
						break;
					/* BluePay 2.0 Redirect */
					case 'bluepay'				:
						$errors = null;
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your card number, expiry date and CVV to place your order.', $this -> plugin_name); ?></p>
	
						<?php
						
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						if ($bluepay = $this -> extension_vendor('bluepay')) {
							$content .= $bluepay -> form($order, $items, $user, $params);
						}
						
							global $wpcothemedoutput;
							$wpcothemedoutput = $content;
						break;
					case 'fdapi'				:
						$errors = null;
						ob_start();					
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						?>
						
						<h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3>
						<p><?php _e('Please fill in your card number and expiry date to place your order.', $this -> plugin_name); ?></p>
	
						<?php
						
						global $Order;
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('modified', $wpcoHtml -> gen_date(), array('id' => $order -> id));
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						if ($fdapi = $this -> extension_vendor('fdapi')) {
							$content .= $fdapi -> form($order, $items, $user, $params);
						}
						
						$wpcothemedoutput = $content;					
						break;
					case 'stripe'				:
						ob_start();
						
						$content = ob_get_clean();
						
						if ($stripe = $this -> extension_vendor('stripe')) {
							$content .= $stripe -> form($order, $items, $user, $params);
						}
						
						$wpcothemedoutput = $content;
						break;
					/* Default for all other payment methods */
					default						:							
						ob_start();
						
						if ($this -> get_option('cart_layout') != "theme") {
							$this -> render('head-wpdie', false, true, 'default');
						}
						
						$this -> render('steps', array('step' => 'checkout', 'order' => $order), true, 'default');
						
						if ($pmethod != "eway_shared") {
						
						?>
						
						<h3><?php _e('Processing Order', $this -> plugin_name); ?></h3>
						<?php _e('Please wait while your order is being processed.', $this -> plugin_name); ?><br/>
						<?php _e('If you do not get redirected within 3 seconds, please click the "Continue" button below.', $this -> plugin_name); ?><br/><br/>
						
						<?php
						
						}
						
						$wpcoDb -> model = $Item -> model;
						$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
						
						$content = ob_get_clean();
						
						ob_start();
						do_action($this -> pre . '_process_order_' . $pmethod, $order, $user, $params);
						$actioncontent = ob_get_clean();					
						
						if (empty($actioncontent)) {
							switch ($pmethod) {
								case 'amazonfps'				:
									if ($this -> is_plugin_active('amazonfps')) {
										if ($amazonfps = $this -> extension_vendor('amazonfps')) {
											$amazonfps -> cbui($order, $items, $user, $params);
										}
									}
									break;
								case 'virtualmerchant'			:
								case 'worldpay'					:
								case 'monsterpay'				:
									$content .= $this -> render('checkout' . DS . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
									break;
								case 'netcash'					:
									if ($netcash = $this -> extension_vendor('netcash')) {
										$content .= $netcash -> form($order, $items, $user, $params);	
									}
									break;
								case 'sagepay'					:
									if ($sagepay = $this -> extension_vendor('sagepay')) {
										$content .= $sagepay -> form($order, $items, $user, $params);	
									}
									break;
								case 'securetrading'			:
									if ($securetrading = $this -> extension_vendor('securetrading')) {
										$content .= $securetrading -> form($order, $items, $user, $params);
									}
									break;
								case 'bluepay'					:						
									if ($bluepay = $this -> extension_vendor('bluepay')) {
										$content .= $bluepay -> form($order, $items, $user, $params);
									}
									break;
								case 'ipay'						:
									if ($ipay = $this -> extension_vendor('ipay')) {
										$content .= $ipay -> form($order, $items, $user, $params);
									}
									break;
								default							:
									$content .= $this -> render('checkout-' . $pmethod, array('order' => $order, 'items' => $items, 'user' => $user, 'params' => $params), false, 'default');
									break;
							}
						} else {
							$content .= $actioncontent;
						}
						
						global $wpcothemedoutput;
						$wpcothemedoutput = $content;
						break;
				}
			}
			
			return $content;
		}
		
		function widget_options($number = null) {
			global $wp_registered_widgets;
			
			if (!empty($wp_registered_widgets[$number])) {
				return $wp_registered_widgets[$number];
			}
			
			return false;
		}
		
		function widget_active($type = 'cart') {
			$number = false;
			$widgettype = $this -> get_option('cart_widgettype');
		
			if (empty($widgettype) || $widgettype == "normal") {
				global $wp_registered_widgets;
				
				$matches = false;
				$number = $this -> pre . '-' . $type;
				
				if (!empty($wp_registered_widgets)) {									
					if ($options = $this -> get_option('-widget')) {						
						if (function_exists('array_reverse')) {
							$wp_registered_widgets = array_reverse($wp_registered_widgets);
						}
								
						foreach ($wp_registered_widgets as $wkey => $widget) {															
							if (preg_match("/^" . $this -> pre . "\-(.*)$/i", $wkey, $matches)) {						
								$intnumber = $matches[1];
								unset($widget['callback']);
								
								if (!empty($options[$intnumber])) {							
									if (!empty($options[$intnumber]['display'])) {								
										if ($options[$intnumber]['display'] == $type) {									
											if (is_active_widget(false, $wkey, $this -> pre, true)) {										
												$number = $this -> pre . '-' . $intnumber;
												break 1;
											}
										}
									}
								}			
							}
						}
						
						$number .= '-inside';
					}
				}
			} else {
				$id = $this -> get_option('cart_hardcodedid');
				$number = (empty($id)) ? "hardcodedcart" : $id;
			}
			
			return $number;
		}
		
		function debug($var = array(), $return = false) {
			if ($this -> debugging == true) {
				$string = '<pre>' . print_r($var, true) . '</pre>';
			
				if (!empty($return) && $return == true) {
					return $string;
				} else {
					echo $string;
				}
			}
		}
		
		function paginate($model = null, $fields = '*', $sub = null, $conditions = false, $searchterm = null, $per_page = 10, $order = array('modified', "DESC")) {
			global $wpdb, ${$model};
		
			if (!empty($model)) {
				switch ($model) {
					case 'Order'			:
						if (!empty($conditions['completed']) && $conditions['completed'] == "all") {
							unset($conditions['completed']);	
						}
						break;
				}
				
				global $paginate;
				$paginate = $this -> vendor('Paginate');
				$paginate -> table = $wpdb -> prefix . $this -> pre . ${$model} -> controller;
				$paginate -> sub = (empty($sub)) ? ${$model} -> controller : $sub;
				$paginate -> fields = (empty($fields)) ? '*' : $fields;
				$paginate -> where = (empty($conditions)) ? false : $conditions;
				$paginate -> searchterm = (empty($searchterm)) ? false : $searchterm;
				$paginate -> per_page = $per_page;
				$paginate -> order = $order;
				
				$data = $paginate -> start_paging($_GET[$this -> pre . 'page']);
				
				if (!empty($data)) {
					$newdata = array();
				
					foreach ($data as $record) {
						$newdata[] = $this -> init_class($model, $record);
					}
					
					$data = array();
					$data[$model] = $newdata;
					$data['Paginate'] = $paginate;
				}
		
				return $data;
			}
			
			return false;
		}
		
		function check_tables() {
			$this -> initialize_classes();
			
			if (!empty($this -> tablenames)) {		
				foreach ($this -> tablenames as $model => $tablename) {			
					$this -> check_table($model);
				}
			}
		}
		
		function check_table($model = null) {	
			if (!is_admin()) return false;
		
			global $wpdb;
		
			if (!empty($model)) {
				global ${$model};
				${$model} = apply_filters($this -> pre . '_check_table', ${$model});
				$name = $wpdb -> prefix . $this -> pre . ${$model} -> controller;
				
				if (!empty(${$model} -> fields_tv)) {			
					if (!$wpdb -> get_var("SHOW TABLES LIKE '" . $name . "'")) {				
						$query = "CREATE TABLE `" . $name . "` (";
						$c = 1;
						
						foreach (${$model} -> fields_tv as $field => $attributes) {
							if ($field != "key") {
								$query .= "`" . $field . "` " . $attributes[0] . " " . $attributes[1] . "";
							} else {
								$query .= "" . $attributes . "";
							}
							
							if ($c < count(${$model} -> fields)) {
								$query .= ",";
							}
							
							$c++;
						}
						
						$query .= ") ENGINE=MyISAM AUTO_INCREMENT=1 CHARSET=UTF8 COLLATE=utf8_general_ci;";
						
						if (!empty($query)) {
							$this -> table_query[] = $query;
						}
					} else {
						$field_array = $this -> get_fields($name);
						$fields_tv = apply_filters($this -> pre . '_check_table_fields', ${$model} -> fields_tv, $name);
						
						foreach ($fields_tv as $field => $attributes) {					
							if ($field != "key") {						
								$this -> add_field_new($name, $field, $attributes);
							}
						}
					}
					
					if (!empty($this -> table_query)) {				
						require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
						dbDelta($this -> table_query, true);
					}
				}
			}
			
			return false;
		}
		
		function initialize_classes() {	
			global $wpdb;
			
			$this -> classes = apply_filters($this -> pre . '_classes', $this -> classes);
		
			if (!empty($this -> classes)) {
				foreach ($this -> classes as $key => $class) {			
					if (class_exists($class['name'])) {
						global ${$key};
						
						if (!is_object(${$key})) {
							${$key} = new $class['name'];
							${$key} = apply_filters($this -> pre . '_class_init', ${$key}, $key, $class);
						}
						
						if ($class['type'] == "model") {
							$this -> tablenames[${$key} -> model] = $wpdb -> prefix . ${$key} -> table;
						}
					}
				}
			}
			
			return false;
		}
		
		function get_fields($table = null) {	
			global $wpdb;
		
			if (!empty($table)) {
				$fullname = $table;			
				$field_array = array();
				if ($fields = $wpdb -> get_results("SHOW COLUMNS FROM " . $fullname)) {
					foreach ($fields as $field) {
						$field_array[] = $field -> Field;
					}
				}
				
				return apply_filters($this -> pre . '_get_db_fields', $field_array, $table);
			}
			
			return false;
		}
		
		function delete_field($table = null, $field = null) {
			global $wpdb;
			
			if (!empty($table)) {
				if (!empty($field)) {
					$query = "ALTER TABLE `" . $wpdb -> prefix . "" . $table . "` DROP `" . $field . "`";
					
					if ($wpdb -> query($query)) {
						return false;
					}
				}
			}
			
			return false;
		}
		
		function change_field($table = null, $field = null, $newfield = null, $attributes = "TEXT NOT NULL") {
			global $wpdb;
			
			if (!empty($table)) {		
				if (!empty($field)) {			
					if (!empty($newfield)) {
						$field_array = $this -> get_fields($table);
						
						if (!in_array($field, $field_array)) {
							if ($this -> add_field($table, $newfield)) {
								return true;
							}
						} else {
							$query = "ALTER TABLE `" . $table . "` CHANGE `" . $field . "` `" . $newfield . "` " . $attributes . "";						
							if ($wpdb -> query($query)) {
								return true;
							}
						}
					}
				}
			}
			
			return false;
		}
		
		function add_field_new($table = null, $field = null, $attributes = array("TEXT", "NOT NULL")) {
			global $wpdb;
		
			if (!empty($table)) {
				if (!empty($field)) {
					$field_array = $this -> get_fields($table);
					
					if (!empty($field_array)) {				
						if (!in_array($field, $field_array)) {					
							$query = "ALTER TABLE `" . $table . "` ADD `" . $field . "` " . $attributes[0] . " " . $attributes[1] . ";";
							
							if ($wpdb -> query($query)) {
								return true;
							}
						}
					}
				}
			}	
		}
		
		function add_field($table = null, $field = null, $attributes = "TEXT NOT NULL") {
			global $wpdb;
		
			if (!empty($table)) {
				if (!empty($field)) {
					$field_array = $this -> get_fields($table);
					
					if (!empty($field_array)) {				
						if (!in_array($field, $field_array)) {					
							$query = "ALTER TABLE `" . $table . "` ADD `" . $field . "` " . $attributes . ";";
							
							if ($wpdb -> query($query)) {
								return true;
							}
						}
					}
				}
			}
			
			return false;
		}
		
		function send_mail($to = null, $subject = null, $message = null) {
			$mail_type = $this -> get_option('mail_type');
			$mail_from = $this -> get_option('mail_from');
			$mail_name = $this -> get_option('mail_name');
			
			if ($mail_type != "mail") {
				global $phpmailer;
				
				if (!is_object($phpmailer) || !is_a($phpmailer, 'PHPMailer')) {
					include_once(ABSPATH . WPINC . DS . 'class-phpmailer.php');
					include_once(ABSPATH . WPINC . DS . 'class-smtp.php');
					$phpmailer = new PHPMailer();
				}
				
				$phpmailer -> ClearAllRecipients();
				$phpmailer -> ClearAttachments();
				
				$phpmailer -> Subject = $subject;
				$phpmailer -> Body = $message;
				
				if ($mail_type == "smtp") {
					$phpmailer -> IsSMTP();
					$phpmailer -> CharSet = get_option('blog_charset');
					
					if ($this -> get_option('smtp_auth') == "Y") {
						$phpmailer -> SMTPAuth = true;
						
						$phpmailer -> Host = $this -> get_option('smtp_host');
						$phpmailer -> Username = $this -> get_option('smtp_user');
						$phpmailer -> Password = $this -> get_option('smtp_pass');
					} else {
						$phpmailer -> SMTPAuth = false;
					}
				} else {
					$phpmailer -> IsMail();
				}		
				
				$phpmailer -> IsHtml(true);
				$phpmailer -> From = $mail_from;
				$phpmailer -> FromName = $mail_name;
				$phpmailer -> Sender = $mail_from;
				$phpmailer -> AddReplyTo($mail_from, $mail_name);
				
				if (($multiple = @explode(",", $to)) !== false && is_array($multiple) && count($multiple) > 1) {
					foreach ($multiple as $memail) {
						$phpmailer -> AddAddress($memail);
					}
				} else {
					$phpmailer -> AddAddress($to);
				}
				
				if ($phpmailer -> Send()) {
					return true;
				}
			} else {
				/* WP Mail */
				$subject = $subject;
				$message = stripslashes($message);
				
				$headers = '';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-Type: text/html; charset="UTF-8"' . "\r\n";
				$headers .= 'From: ' . $mail_name . ' <' . $mail_from . '>' . "\r\n";
				
				if (($multiple = explode(",", $to)) !== false && is_array($multiple) && count($multiple) > 1) {			
					foreach ($multiple as $memail) {
						wp_mail($memail, $subject, $message, $headers);
					}
				} else {					
					if (wp_mail($to, $subject, $message, $headers)) {
						return true;
					} else {
						return false;
					}
				}
				
				return true;	
			}
			
			return false;
		}
		
		function add_action($action, $function = null, $priority = 10, $params = 1) {	
			if (add_action($action, array($this, (empty($function)) ? $action : $function), $priority, $params)) {
				return true;
			}
			
			return false;
		}
		
		function add_filter($filter, $function = null, $priority = 10, $params = 1) {
			if (add_filter($filter, array($this, (empty($function)) ? $filter : $function), $priority, $params)) {
				return true;
			}
			
			return false;
		}
		
		function vendor($name = null, $folder = null) {
			if (!empty($name)) {
				$filename = 'class.' . strtolower($name) . '.php';
				$filepath = rtrim(dirname(__FILE__), DS) . DS . 'vendors' . DS . $folder;
				$filefull = $filepath . $filename;
			
				if (file_exists($filefull)) {
					require_once($filefull);
					$class = $this -> pre . $name;
					
					if (class_exists($class)) {
						if (${$name} = new $class) {
							return ${$name};
						}
					}
				}
			}
		
			return false;
		}
		
		function extension_vendor($name = null) {
			if (!empty($name)) {
				include $this -> plugin_base() . DS . 'includes' . DS . 'extensions.php';
				$this -> extensions = apply_filters($this -> pre . '_extensions_list', $extensions);
				
				if (!empty($this -> extensions)) {						
					$extensions = apply_filters($this -> pre . '_extensions_list', $this -> extensions);				
				
					foreach ($extensions as $extension) {
						if ($name == $extension['slug']) {					
							$filepath = $extension['plugin_name'] . DS . $extension['plugin_file'];
						}
					}
				}
			
				if (empty($filepath)) {
					switch ($name) {
						/* Amazon FPS */
						case 'amazonfps'					:
							$filepath = 'checkout-amazonfps' . DS . 'amazonfps.php';
							break;
						/* APCO Limited */
						case 'apco'							:
							$filepath = 'checkout-apco' . DS . 'apco.php';
							break;
						case 'euvatex'						:
							$filepath = 'checkout-euvatex' . DS . 'euvatex.php';
							break;
						/* iPay88 */
						case 'ipay'							:
							$filepath = 'checkout-ipay' . DS . 'ipay.php';
							break;
						/* Netcash integration */
						case 'netcash'						:
							$filepath = 'checkout-netcash' . DS . 'netcash.php';
							break;	
						/* First Data API */
						case 'fdapi'						:
							$filepath = 'checkout-fdapi' . DS . 'fdapi.php';
							break;
						/* Sage Pay (FORM) protocol */
						case 'sagepay'						:
							$filepath = 'checkout-sagepay' . DS . 'sagepay.php';
							break;
						case 'securetrading'				:
							$filepath = 'checkout-securetrading' . DS . 'securetrading.php';
							break;
						case 'affiliates'					:
							$filepath = 'checkout-affiliates' . DS . 'affiliates.php';
							break;
						/* BluePay 2.0 Redirect */
						case 'bluepay'						:
							$filepath = 'checkout-bluepay' . DS . 'bluepay.php';
							break;
						/* Stripe */
						case 'stripe'						:
							$filepath = 'checkout-stripe' . DS . 'stripe.php';
							break;
					}
				}
				
				$filefull = WP_CONTENT_DIR . DS . 'plugins' . DS . $filepath;
				
				if (file_exists($filefull)) {
					
					require_once $filefull;
					$class = $this -> pre . $name;
					
					if (class_exists($class)) {
						${$name} = new $class;
						return ${$name};	
					}
				}
			}
		}
		
		function db_save_field($model = null, $field = null, $value = null, $conditions = array()) {
			if (!empty($model)) {
				global $wpdb, ${$model};
				
				if (!empty($field)) {
					$query = "UPDATE `" . $wpdb -> prefix . "" . ${$model} -> table . "` SET `" . $field . "` = '" . $value . "'";
					
					if (!empty($conditions) && is_array($conditions)) {
						$query .= " WHERE";
						$c = 1;
						
						foreach ($conditions as $ckey => $cval) {
							$query .= " `" . $ckey . "` = '" . $cval . "'";
							
							if ($c < count($conditions)) {
								$query .= " AND";
							}
							
							$c++;
						}
					}
					
					if ($wpdb -> query($query)) {
						return true;
					}
				}
			}
			
			return false;		
		}
		
		function redirect($location = null, $msgtype = null, $message = null, $jsredirect = false) {
			global $wpcoHtml;
	
			if (!empty($message)) {
				$url = rtrim($location, '/');
				
				if ($msgtype == "message") {
					$url = $wpcoHtml -> retainquery($this -> pre . 'updated=true', $url);
				} elseif ($msgtype == "error") {
					$url = $wpcoHtml -> retainquery($this -> pre . 'error=true', $url);
				}
				
				$url = $wpcoHtml -> retainquery($this -> pre . 'message=' . urlencode($message), $url);
			} else {
				$url = $location;
			}
			
			if (headers_sent() || $jsredirect == true) {
				?>
				
				<script type="text/javascript">
				window.location.href = '<?php echo (empty($url)) ? get_option('home') : $url; ?>';
				</script>
				
				<?php
				
				flush();
			} else {
				header("Location: " . $url . "");
				exit();		
			}
		}
		
		function render_msg($message = null) {		
			$this -> render('msg-top', array('message' => $message), true, 'admin');
		}
		
		function render_err($message = null) {
			$this -> render('err-top', array('message' => $message), true, 'admin');
		}
		
		function render_style($style_id = null, $options = array(), $fieldset = true, $product_id = null) {
			if (!empty($style_id)) {
				if (!empty($options)) {
					global $wpdb, $wpcoDb, $wpcoHtml, $Style, $Option, $ProductsOption, $ProductsStyle;				
					$wpcoDb -> model = $Style -> model;
					
					if ($style = $wpcoDb -> find(array('id' => $style_id))) {				
						ob_start();
						
						if (!empty($product_id)) {
							$productsstylequery = "SELECT * FROM `" . $wpdb -> prefix . $ProductsStyle -> table . "` WHERE `style_id` = '" . $style_id . "' AND `product_id` = '" . $product_id . "'";
							$productsstyle = $wpdb -> get_row($productsstylequery);
						}
						
						if (!empty($fieldset) && $fieldset == true) {
						
						?>
						
						<fieldset class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>variation" id="<?php echo $this -> pre; ?>variation<?php echo $style_id; ?>">
							<legend class="<?php echo $this -> pre; ?>style_required"><?php echo $style -> title; ?> <sup class="<?php echo $this -> pre; ?>required">&#42;</sup></legend>
						
							<?php
							
							$inventory = false;
							$showstock = ($this -> get_option('product_showstock') == "Y") ? true : false;
							
							}
						
							switch ($style -> type) {
								case 'select'				:							
									?>
									
									<input type="hidden" name="Item[styles][<?php echo $style_id; ?>]" value="" id="Item_style_<?php echo $style_id; ?>_<?php echo $product_id; ?>" />
									<div id="Item_style_<?php echo $style_id; ?>_<?php echo $product_id; ?>_dropdown"></div>
									
									<?php
									
									$ddData = array();
									foreach ($options as $option_id) {
										$wpcoDb -> model = $Option -> model;
										$option = $wpcoDb -> find(array('id' => $option_id));
										$inventoryquery = "SELECT `inventory` FROM `" . $wpdb -> prefix . $ProductsOption -> table . "` WHERE `option_id` = '" . $option_id . "' AND `product_id` = '" . $product_id . "'";
										$inventory = $wpdb -> get_var($inventoryquery);
										if (empty($inventory) && $inventory != "0") { $inventory = '-1'; }
										
										$description = "";
										if (!empty($option -> addprice) && $option -> addprice == "Y" && $option -> condprices == "N" && $option -> price > 0) { $description .= $option -> symbol . ((!empty($option -> operator) && $option -> operator == "curr") ? $wpcoHtml -> currency() : '') . $option -> price . ((!empty($option -> operator) && $option -> operator == "perc") ? '&#37;' : ''); }
										if (!empty($showstock) && $showstock == true && $inventory > 0) { $description .= ' (' . $inventory . ' ' . __('in stock', $this -> plugin_name) . ')'; }

										if ($inventory != "0") {										
											$ddData[] = array(
												'text'			=>	$option -> title,
												'value'			=>	$option -> id,
												'selected'		=>	((!empty($_POST['Item']['styles'][$style_id]) && $_POST['Item']['styles'][$style_id] == $option_id) || (!empty($productsstyle -> defaultoption) && $productsstyle -> defaultoption == $option -> id) ? true : false),
												'description'	=>	$description,
												'imageSrc'		=>	(!empty($option -> image) ? $wpcoHtml -> timthumb_image_src($option -> image_url, $this -> get_option('variations_optionthumbw'), $this -> get_option('variations_optionthumbh'), 100) : false),
											);
										}
									}
									
									$ddData = json_encode($ddData);
									
									?>
									
									<script type="text/javascript">
									jQuery(document).ready(function() {
										jQuery('#Item_style_<?php echo $style_id; ?>_<?php echo $product_id; ?>_dropdown').ddslick({
										    data: <?php echo $ddData; ?>,
										    width: <?php echo $this -> get_option('product_infoholderwidth'); ?>,
										    height: false,
										    imagePosition: "left",
										    selectText: "<?php _e('Select', $this -> plugin_name); ?>",
										    onSelected: function (data) {
										        jQuery('#Item_style_<?php echo $style_id; ?>_<?php echo $product_id; ?>').val(data.selectedData.value);
										        wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');
										    }
										});
									});
									</script>
									
									<?php
									break;
								case 'radio'				:
									?>
									
									<?php foreach ($options as $option_id) : ?>
										<?php $wpcoDb -> model = $Option -> model; ?>
										<?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'image', 'addprice', 'price', 'symbol', 'operator', 'condprices'))) : ?>                                    
											<?php
											
											$inventoryquery = "SELECT `inventory` FROM `" . $wpdb -> prefix . $ProductsOption -> table . "` WHERE `option_id` = '" . $option_id . "' AND `product_id` = '" . $product_id . "'";
											$inventory = $wpdb -> get_var($inventoryquery);
											if (empty($inventory) && $inventory != "0") { $inventory = '-1'; }
											
											?>									
											<?php if (!empty($option -> image)) : ?>
	                                            <label class="<?php echo $this -> pre; ?>style_radio <?php echo $this -> pre; ?>style_withimage <?php echo $this -> pre; ?>style_float">
	                                                <input <?php echo ($inventory == 0) ? 'disabled="disabled"' : ''; ?> onclick="wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');" <?php echo ((!empty($_POST['Item']['styles'][$style_id]) && $_POST['Item']['styles'][$style_id] == $option_id) || (!empty($productsstyle -> defaultoption) && $productsstyle -> defaultoption == $option_id)) ? 'checked="checked"' : ''; ?> type="radio" class="wpcostyle_radio_inputwithimage" name="Item[styles][<?php echo $style_id; ?>]" id="Item_style<?php echo $style_id; ?>_option<?php echo $option -> id; ?>" value="<?php echo $option -> id; ?>" /> 
	                                                <a onclick="wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>'); return false;" href="<?php echo site_url(); ?>/<?php echo $option -> image_url; ?>" <?php if ($this -> get_option('variations_optionthumbzoom') == "Y" && $this -> is_plugin_active('jqzoom')) : ?>class="jqzoom" id="jqzoom<?php echo $option -> id; ?>"<?php else : ?>class="colorbox"<?php endif; ?> title="<?php echo esc_attr($option -> title); ?>">
	                                                    <?php echo $wpcoHtml -> timthumb_image($option -> image_url, $this -> get_option('variations_optionthumbw'), $this -> get_option('variations_optionthumbh'), $this -> get_option('variations_optionthumbq')); ?>
	                                                </a>
	                                                <?php if ($this -> get_option('variations_optionlabel') == "Y") : ?>
	                                                    <span class="<?php echo $this -> pre; ?>style_optionlabel"><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && $option -> condprices == "N") ? ' <span class="' . $this -> pre . 'option_price">(' . $option -> symbol . ((!empty($option -> operator) && $option -> operator == "curr") ? $wpcoHtml -> currency() : '') . $option -> price . ((!empty($option -> operator) && $option -> operator == "perc") ? '&#37;' : '') . ')</span>' : ''; ?></span>
	                                                    <span class="<?php echo $this -> pre; ?>option_stock"><?php echo (!empty($showstock) && $showstock == true && $inventory > 0) ? ' (' . $inventory . ' ' . __('in stock', $this -> plugin_name) . ')' : ''; ?><?php echo ($inventory == "0") ? ' (' . __('out of stock', $this -> plugin_name) . ')' : ''; ?></span>
	                                                <?php endif; ?>
	                                            </label>
	                                            <?php if ($this -> get_option('variations_optionlabel') == "Y") : ?>
	                                            	<br class="<?php echo $this -> pre; ?>cleaner" />
	                                            <?php endif; ?>
	                                        <?php else : ?>
	                                            <label class="<?php echo $this -> pre; ?>style_radio">
	                                            <input <?php echo ($inventory == 0) ? 'disabled="disabled"' : ''; ?> onclick="wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');" <?php echo ((!empty($_POST['Item']['styles'][$style_id]) && $_POST['Item']['styles'][$style_id] == $option_id) || (!empty($productsstyle -> defaultoption) && $productsstyle -> defaultoption == $option_id)) ? 'checked="checked"' : ''; ?> type="radio" class="wpcostyle_radio_input" name="Item[styles][<?php echo $style_id; ?>]" value="<?php echo $option -> id; ?>" /> 
	                                            <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && $option -> condprices == "N") ? ' <span class="' . $this -> pre . 'option_price">(' . $option -> symbol . ((!empty($option -> operator) && $option -> operator == "curr") ? $wpcoHtml -> currency() : '') . $option -> price . ((!empty($option -> operator) && $option -> operator == "perc") ? '&#37;' : '') . ')</span>' : ''; ?>
	                                            <span class="<?php echo $this -> pre; ?>option_stock"><?php echo (!empty($showstock) && $showstock == true && $inventory > 0) ? ' (' . $inventory . ' ' . __('in stock', $this -> plugin_name) . ')' : ''; ?><?php echo ($inventory == "0") ? ' (' . __('out of stock', $this -> plugin_name) . ')' : ''; ?></span>
	                                            </label>
	                                        <?php endif; ?>
										<?php endif; ?>
									<?php endforeach; ?>
									
									<?php
									break;
								case 'checkbox'				:
									?>
									
									<?php foreach ($options as $option_id) : ?>
										<?php $wpcoDb -> model = $Option -> model; ?>
										<?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'image', 'addprice', 'price', 'operator', 'condprices'))) : ?>
											<?php
											
											$inventoryquery = "SELECT `inventory` FROM `" . $wpdb -> prefix . $ProductsOption -> table . "` WHERE `option_id` = '" . $option_id . "' AND `product_id` = '" . $product_id . "'";
											$inventory = $wpdb -> get_var($inventoryquery);
											if (empty($inventory) && $inventory != "0") { $inventory = '-1'; }
											
											?>	
	                                    	<?php if (!empty($option -> image)) : ?>
	                                        	<label class="<?php echo $this -> pre; ?>style_checkbox <?php echo $this -> pre; ?>style_withimage <?php echo $this -> pre; ?>style_float">
	                                                <input <?php echo ($inventory == 0) ? 'disabled="disabled"' : ''; ?> onclick="wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');" type="checkbox" <?php echo ((!empty($_POST['Item']['styles'][$style_id]) && in_array($option_id, $_POST['Item']['styles'][$style_id])) || (!empty($productsstyle -> defaultoption) && $productsstyle -> defaultoption == $option_id) && $inventory != 0) ? 'checked="checked"' : ''; ?> class="<?php echo $this -> pre; ?>style_checkbox_inputwithimage" name="Item[styles][<?php echo $style_id; ?>][]" id="Item_style<?php echo $style_id; ?>_option<?php echo $option -> id; ?>" value="<?php echo $option -> id; ?>" /> 
	                                                <a onclick="wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>'); return false;" href="<?php echo site_url(); ?>/<?php echo $option -> image_url; ?>" <?php if ($this -> get_option('variations_optionthumbzoom') == "Y" && $this -> is_plugin_active('jqzoom')) : ?>class="jqzoom" id="jqzoom<?php echo $option -> id; ?>"<?php else : ?>class="colorbox"<?php endif; ?> title="<?php echo esc_attr($option -> title); ?>">
	                                                    <?php echo $wpcoHtml -> timthumb_image($option -> image_url, $this -> get_option('variations_optionthumbw'), $this -> get_option('variations_optionthumbh'), $this -> get_option('variations_optionthumbq')); ?>
	                                                </a>
	                                                <?php if ($this -> get_option('variations_optionlabel') == "Y") : ?>
	                                                	<span class="<?php echo $this -> pre; ?>style_optionlabel"><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && $option -> condprices == "N") ? ' <span class="' . $this -> pre . 'option_price">(' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, true) . ')</span>' : ''; ?></span>
	                                                	<span class="<?php echo $this -> pre; ?>option_stock"><?php echo (!empty($showstock) && $showstock == true && $inventory > 0) ? ' (' . $inventory . ' ' . __('in stock', $this -> plugin_name) . ')' : ''; ?><?php echo ($inventory == "0") ? ' (' . __('out of stock', $this -> plugin_name) . ')' : ''; ?></span>
	                                                <?php endif; ?>
	                                            </label>
	                                            <?php if ($this -> get_option('variations_optionlabel') == "Y") : ?>
	                                            	<br class="<?php echo $this -> pre; ?>cleaner" />
	                                            <?php endif; ?>
	                                        <?php else : ?>
												<label class="<?php echo $this -> pre; ?>style_checkbox">
	                                        	<input <?php echo ($inventory == 0) ? 'disabled="disabled"' : ''; ?> onclick="wpco_updateproductprice('<?php echo $product_id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');" type="checkbox" <?php echo ((!empty($_POST['Item']['styles'][$style_id]) && in_array($option_id, $_POST['Item']['styles'][$style_id])) || (!empty($productsstyle -> defaultoption) && $productsstyle -> defaultoption == $option_id) && $inventory != 0) ? 'checked="checked"' : ''; ?> class="<?php echo $this -> pre; ?>style_checkbox_input" name="Item[styles][<?php echo $style_id; ?>][]" value="<?php echo $option -> id; ?>" /> <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && $option -> condprices == "N") ? ' <span class="' . $this -> pre . 'option_price">(' . $option -> symbol . ((!empty($option -> operator) && $option -> operator == "curr") ? $wpcoHtml -> currency() : '') . $option -> price . ((!empty($option -> operator) && $option -> operator == "perc") ? '&#37;' : '') . ')</span>' : ''; ?>
	                                        	<span class="<?php echo $this -> pre; ?>option_stock"><?php echo (!empty($showstock) && $showstock == true && $inventory > 0) ? ' (' . $inventory . ' ' . __('in stock', $this -> plugin_name) . ')' : ''; ?><?php echo ($inventory == "0") ? ' (' . __('out of stock', $this -> plugin_name) . ')' : ''; ?></span>
	                                            </label>
	                                        <?php endif; ?>
										<?php endif; ?>
									<?php endforeach; ?>
									<?php
									break;
							}
							
							if (!empty($style -> caption)) {
								echo '<br class="wpcocleaner" />';
								echo '<span class="notation">' . stripslashes($style -> caption) . '</span>';	
							}
							
							if (!empty($fieldset) && $fieldset == true) {
							
							?>
						
						</fieldset>
						
						<?php
						
						}
						
						$style = ob_get_clean();
						return $style;
					}
				}
			}
			
			return false;
		}
		
		function render_field($field_id = null, $fieldset = true, $value = null, $product_id = null, $globalfield = false) {
			global $wpcoDb, $wpcoField, $wpcoHtml;
		
			if (!empty($field_id)) {
				$wpcoDb -> model = $wpcoField -> model;
			
				if ($field = $wpcoDb -> find(array('id' => $field_id))) {			
					if ($fieldset == true) {
						echo '<fieldset class="' . $this -> pre . ' ' . $this -> pre . 'field" id="' . $this -> pre . 'field' . $field_id . '">';
						echo '<legend>';
						echo $field -> title;
						if ($field -> required == "Y") { echo ' <sup class="' . $this -> pre . 'required">&#42;</sup>'; };
						if (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) { echo ' (' . __('+', $this -> plugin_name) . $wpcoHtml -> currency_price($field -> price, true, true) . ')'; };
						echo '</legend>';
					}
					
					
					$fieldvalue = (empty($value)) ? $_POST[$field -> slug] : $value;
					
					if (empty($fieldvalue)) {
						$fieldvalue = $_POST['Item']['fields'][$field -> id];	
					}
					
					$fieldvalue = stripslashes_deep(esc_attr($fieldvalue));
					
					if (empty($globalfield) || $globalfield == false) {
						$jsoutput = 'wpco_updateproductprice(\'' . $product_id . '\', \'' . __('Calculating...', $this -> plugin_name) . '\');';
					} else {
						$jsoutput = "";	
					}
				
					switch ($field -> type) {
						case 'text'				:
							echo '<input onkeyup="' . $jsoutput . '" id="' . $field -> slug . $product_id . '" type="text" class="widefat" name="Item[fields][' . $field -> id . ']' . '" value="' . $fieldvalue . '" />';
							break;
						case 'file'				:						
							?>
							
							<input type="file" name="file_upload_<?php echo $field -> id; ?>" value="" id="file_upload_<?php echo $field -> id; ?><?php echo $product_id; ?>" />
							<input type="hidden" name="Item[fields][<?php echo $field -> id; ?>]" value="<?php echo esc_attr(stripslashes($fieldvalue)); ?>" id="<?php echo $this -> pre . '-' . $product_id . '' . $field -> slug; ?>" />
							
							<script type="text/javascript">
							jQuery(function() {
								if (jQuery.isFunction(jQuery.fn.uploadify)) {
									jQuery('#file_upload_<?php echo $field -> id; ?><?php echo $product_id; ?>').uploadify({
										'multi'				:	false,
										'uploadLimit'		:	1,
										'swf'      			: 	'<?php echo $this -> url(); ?>/views/<?php echo $this -> get_option('theme_folder'); ?>/img/ajaxupload.swf',
										'uploader' 			: 	'<?php echo $this -> url(); ?>/vendors/ajaxupload/upload.php',
										'buttonText'		:	'<?php _e('Select File', $this -> plugin_name); ?>',
										'debug'				:	false,
										<?php /*<?php if (!empty($filetypes)) : ?>'fileTypeExts'	:	'<?php echo $filetypes; ?>',<?php endif; ?>*/ ?>
										<?php /*<?php if (!empty($field -> filesizelimit)) : ?>'fileSizeLimit'	:	'<?php echo $field -> filesizelimit; ?>',<?php endif; ?>*/ ?>
										'removeCompleted'	:	false,
										'onCancel'			:	function(file) { jQuery('#<?php echo $this -> pre . '-' . $product_id . '' . $field -> slug; ?>').removeAttr("value"); },
										'onUploadStart'		:	function(file) {
											<?php if (!is_admin()) : ?>jQuery('#submit<?php echo $product_id; ?> input').button('option', "disabled", true);<?php endif; ?>
										},
										'onUploadError' 	: 	function(file, errorCode, errorMsg, errorString) {
											//do nothing...
										},
										'onUploadSuccess' 	: 	function(file, data, response) {
											jQuery('#<?php echo $this -> pre . '-' . $product_id . '' . $field -> slug; ?>').val(data);
										},
										'onUploadComplete'	:	function(file) {
											<?php if (!is_admin()) : ?>jQuery('#submit<?php echo $product_id; ?> input').button('option', "disabled", false);<?php endif; ?>
										}
									});
								}
							});
							</script>
							<?php
							
							break;
						case 'textarea'			:
							echo '<textarea class="widefat" onkeyup="' . $jsoutput . '" id="' . $field -> slug . $product_id . '" rows="3" cols="98%" style="width:98%;" name="Item[fields][' . $field -> id . ']' . '">' . strip_tags(esc_attr($fieldvalue)) . '</textarea>';
							break;
						case 'select'			:
							echo '<select class="widefat" style="width:auto;" onchange="' . $jsoutput . '" id="' . $field -> slug . $product_id . '" name="Item[fields][' . $field -> id . ']' . '">';
							echo '<option value="">- ' . __('Select', $this -> plugin_name) . ' -</option>';
							
							$options = unserialize($field -> fieldoptions);
							if (!empty($options)) {
								foreach ($options as $name => $value) {
									if (!empty($value) || $value == "0") {
										$select = (!empty($fieldvalue) && ($fieldvalue - 1) == $name) ? 'selected="selected"' : '';
										echo '<option ' . $select . ' value="' . ($name + 1) . '">' . $value . '</option>';
									}
								}
							}
							
							echo '</select>';
							break;
						case 'radio'			:
							$options = maybe_unserialize($field -> fieldoptions);
							
							if (!empty($options)) {
								foreach ($options as $name => $value) {
									$checked = (!empty($fieldvalue) && (($fieldvalue - 1) == $name)) ? 'checked="checked"' : '';
									echo '<label><input onclick="' . $jsoutput . '" type="radio" ' . $checked . ' name="Item[fields][' . $field -> id . ']' . '" value="' . ($name + 1) . '" /> ' . $value . '</label><br/>';
								}
							}
							break;
						case 'checkbox'			:
							$options = maybe_unserialize($field -> fieldoptions);
							
							if (!empty($_POST[$field -> slug])) {
								$foptions = maybe_unserialize($_POST[$field -> slug]);
							} elseif (!empty($_POST['Item']['fields'][$field -> id])) {
								$foptions = $_POST['Item']['fields'][$field -> id];	
							}
							
							if (!empty($options)) {
								foreach ($options as $name => $value) {							
									$checked = (!empty($foptions) && in_array(($name + 1), $foptions)) ? 'checked="checked"' : '';
									echo '<label><input onclick="' . $jsoutput . '" type="checkbox" ' . $checked . ' name="Item[fields][' . $field -> id . ']' . '[]" value="' . ($name + 1) . '" /> ' . $value . '</label><br/>';
								}
							}
							break;
						case 'pre_date'			:
							echo '<input onblur="' . $jsoutput . '" id="' . $field -> slug . $product_id . '" class="datepicker widefat" type="text" name="Item[fields][' . $field -> id . ']' . '" value="' . $fieldvalue . '" />';
							
							$dpoptions = "{";
							$dpoptions .= "beforeShowDay: function(date) {
							        var day = date.getDay().toString();
							        var activedays = '" . $field -> activedays . "';
							        var activedaysarray = activedays.split(',');	
							        					        
							        if (jQuery.inArray(day, activedaysarray) >= 0) {
							        	return [true];
							        } else { 
							        	return [false, '', '" . __('Unavailable', $this -> plugin_name) . "']; 
							        }
							    }
							";
							
							if (!empty($field -> mindateop) && $field -> mindateop == "fixed") {
								if (!empty($field -> mindate)) { $dpoptions .= ", minDate:'" . $field -> mindate . "'"; }
							} else {
								if (!empty($field -> mindate) || $field -> mindate == "0") { $dpoptions .= ", minDate:" . ((empty($field -> mindateop) || $field -> mindateop == "neg") ? '-' : '+') . $field -> mindate; }
							}
							
							if (!empty($field -> maxdateop) && $field -> maxdateop == "fixed") {
								if (!empty($field -> maxdate)) { $dpoptions .= ", maxDate:'" . $field -> maxdate . "'"; }	
							} else {
								if (!empty($field -> maxdate) || $field -> maxdate == "0") { $dpoptions .= ", maxDate:" . ((empty($field -> maxdateop) || $field -> maxdateop == "pos") ? '+' : '-') . $field -> maxdate; }
							}
								
							$dpoptions .= "}";
							
							?>
	                        
	                        <script type="text/javascript">
							jQuery(document).ready(function() {
								if (jQuery.isFunction(jQuery.fn.datepicker)) {
									jQuery('#<?php echo $field -> slug . $product_id; ?>').datepicker(<?php echo $dpoptions; ?>).attr("readonly", true);	
								}
							});
							</script>
	                        
	                        <?php
							
							break;
					}
					
					if (!empty($field -> caption)) {
						echo '<span class="notation">' . stripslashes($field -> caption) . '</span>';
					}
					
					if (!empty($field -> type) && $field -> type == "file") {
						if (!empty($field -> filesizelimit)) { echo '<small>' . sprintf(__('Maximum file size of <strong>%s</strong>', $this -> plugin_name), $field -> filesizelimit) . '</small><br/>'; }	
						if (!empty($filetypes)) { echo '<small>' . sprintf(__('Allowed file types are <strong>%s</strong>', $this -> plugin_name), $filetypes) . '</small><br/>'; }
						
						if (!empty($fieldvalue)) {
							echo $wpcoHtml -> file_custom_field($fieldvalue, $field -> filesizelimit, $filetypes);
						}
					}
						
					if ($fieldset == true) {			
						echo '</fieldset>';
					}
				}
			}
			
			return false;
		}
		
		function get_themefolders() {
			$dir = $this -> plugin_base() . DS . 'views' . DS;
			$themefolders = array();
			
			if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) {
						$filetype = filetype($dir . $file);
						if (!empty($filetype) && $filetype == "dir") {
							if ($file != "admin" && $file != "email" && $file != "." && $file != "..") {
								$themefolders[] = $file;
							}
						}
					}
					
					closedir($dh);	
				}
			}
			
			return $themefolders;
		}
		
		function render_url($file = null, $folder = 'admin', $extension = null) {	
			if (!empty($file)) {		
				if (!empty($folder) && $folder != "admin") {
					$theme_folder = $this -> get_option('theme_folder');
					$folder = (!empty($theme_folder)) ? $theme_folder : $folder;
					$folderurl = plugins_url() . '/' . $this -> plugin_name . '/views/' . $folder . '/';
				
					$template_url = get_stylesheet_directory_uri();
					$theme_path = get_stylesheet_directory();
					$full_path = $theme_path . DS . 'checkout' . DS . $file;
					
					if (!empty($theme_path) && file_exists($full_path)) {
						$folderurl = $template_url . '/checkout/';
					}
				} else {
					$folderurl = plugins_url() . '/' . $this -> plugin_name . '/';
				}
				
				$url = $folderurl . $file;
				return $url;
			}
			
			return false;
		}
		
		function render($file = null, $params = array(), $output = true, $folder = 'admin', $extension = false) {
			$this -> plugin_base = rtrim(dirname(__FILE__), DS);
			$this -> sections = (object) $this -> sections;
		
			if (!empty($file)) {
				$filename = $file . '.php';
			
				if (!empty($folder) && $folder != "admin") {
					$theme_folder = $this -> get_option('theme_folder');
					$folder = (!empty($theme_folder)) ? $theme_folder : $folder;
					
					$template_url = get_stylesheet_directory_uri();
					$theme_path = get_stylesheet_directory();
					$full_path = $theme_path . DS . 'checkout' . DS . $filename;
					
					if (!empty($theme_path) && file_exists($full_path)) {
						$folder = $theme_path . DS . 'checkout';
						$theme_serve = true;
					}
				}
				
				if (!empty($extension)) {
					include $this -> plugin_base() . DS . 'includes' . DS . 'extensions.php';
					$extensions = apply_filters($this -> pre . '_extensions_list', $extensions);
					
					if (!empty($extensions)) {
						foreach ($extensions as $ext) {
							if ($extension == $ext['slug']) {
								$extension_folder = $ext['plugin_name'];
							}
						}
					}
				
					if (empty($extension_folder)) {
						switch ($extension) {
							case 'amazonfps'			:
								$extension_folder = 'checkout-amazonfps';
								break;
							case 'apco'					:
								$extension_folder = 'checkout-apco';
								break;
							case 'euvatex'				:
								$extension_folder = 'checkout-euvatex';
								break;
							case 'ipay'					:
								$extension_folder = 'checkout-ipay';
								break;
							case 'netcash'				:
								$extension_folder = 'checkout-netcash';
								break;	
							case 'fdapi'				:
								$extension_folder = 'checkout-fdapi';
								break;
							case 'sagepay'				:
								$extension_folder = 'checkout-sagepay';
								break;
							case 'securetrading'		:
								$extension_folder = 'checkout-securetrading';
								break;
							case 'affiliates'			:
								$extension_folder = 'checkout-affiliates';
								break;
							case 'bluepay'				:
								$extension_folder = 'checkout-bluepay';
								break;
							case 'stripe'				:
								$extension_folder = 'checkout-stripe';
								break;
						}
					}
					
					$filepath = WP_CONTENT_DIR . DS . 'plugins' . DS . $extension_folder . DS;
				} else {
					if (empty($theme_serve)) {
						$filepath = $this -> plugin_base() . DS . 'views' . DS . $folder . DS;
					} else {
						$filepath = $folder . DS;
					}
				}
				
				$filefull = $filepath . $filename;
			
				if (file_exists($filefull)) {
					if (!empty($params)) {
						foreach ($params as $pkey => $pval) {
							${$pkey} = $pval;
						}
					}
					
					//get plugin styles saved in "Settings"
					//$css = $this -> get_option('styles');
					//captions, texts & messages...
					global $wpcocaptions;
					if (empty($wpcocaptions)) {
						$wpcocaptions = $this -> get_option('captions');
					}
					
					if (!empty($this -> classes)) {
						foreach ($this -> classes as $key => $class) {
							global ${$key};
						}
					}
				
					if ($output == false) {
						ob_start();
					}
					
					include($filefull);
					
					if ($output == false) {					
						$data = ob_get_clean();					
						
						if ($folder == 'email') {
							$content = $data;
							$data = '';
							ob_start();
							include($filepath . 'head.php');
							echo apply_filters('the_content', $content);
							include($filepath . 'foot.php');
							$data = ob_get_clean();
						}
						
						return $data;
					} else {
						flush();
						return true;
					}
				} else {
					echo __('File could not be rendered:', $this -> plugin_name) . ' ' . $filefull;
				}
			} else {
				_e('No file was specified to render.', $this -> plugin_name);	
			}
			
			return false;
		}
	
		function is_loggedin() {
			if ($this -> get_option('loggedinonly') == "Y") {
				global $user_ID;
	
				if (!$user_ID) {
					return false;
				}
			}
	
			return true;
		}
		
	}
}

?>