<?php

class wpcoTax extends wpCheckoutPlugin {

	var $model = 'wpcoTax';
	var $controller = 'taxes';
	var $table = '';
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'percentage'		=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'country_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'state'				=>	"VARCHAR(250) NOT NULL DEFAULT ''",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_country_id` (`country_id`), KEY `index_state` (`state`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'percentage'		=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'country_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'state'				=>	array("VARCHAR(250)", "NOT NULL DEFAULT ''"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_country_id` (`country_id`), KEY `index_state` (`state`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoTax($data = array()) {
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
		}
		$wpcoDb = new StdClass;
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			if (empty($percentage)) $this -> errors['percentage'] = __('Please fill in a percentage', $this -> plugin_name);
			if (empty($country_id)) { $this -> errors['country_id'] = __('No country was specified for this tax rate', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=> 	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function get_override_tax_percentage($product_id = null, $taxrate = null, $taxrates = null, $doshipping = false) {
		global $wpdb, $wpcoDb, $Order, $wpcoCart, $wpcoTax;
		$percentage = $this -> get_option('tax_percentage');
		$newpercentage = 0;
		
		if ($co_id = $Order -> cart_order()) {
			$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
			
			if ($co = $wpcoDb -> find(array('id' => $co_id['id']))) {	
				$country = "";
				$state = "";
				
				if (!empty($co -> user_id) && $user = $this -> userdata($co -> user_id)) {
					if (!empty($user -> ship_country)) { $country = $user -> ship_country; }
					elseif (!empty($user -> bill_country)) { $country = $user -> bill_country; }
					if (!empty($user -> ship_state)) { $state = $user -> ship_state; }
					elseif (!empty($user -> bill_state)) { $state = $user -> bill_state; }
				} else {
					if (!empty($co -> ship_country)) { $country = $co -> ship_country; }
					elseif (!empty($co -> bill_country)) { $country = $co -> bill_country; }
					if (!empty($co -> ship_state)) { $state = $co -> ship_state; }
					elseif (!empty($co -> bill_state)) { $state = $co -> bill_state; }
				}
				
				if (!empty($taxrates) && !empty($country)) {										
					// Try to get percentage by both country and state
					foreach ($taxrates as $trate) {
						if ($trate['country_id'] == $country && $trate['state'] == $state) {
							if (!empty($trate['percentage'])) {
								$newpercentage = $trate['percentage'];	
							}
						}
					}
					
					//if all fails, try to get by country?
					if (empty($newpercentage)) {
						foreach ($taxrates as $trate) {
							if ($trate['country_id'] == $country) {
								if (!empty($trate['percentage'])) {
									$newpercentage = $trate['percentage'];	
								}
							}
						}
					}
					
					//lastly... just default to the product taxrate
					if (empty($percentage)) {
						$newpercentage = $taxrate;
					}
					
					$percentage = $newpercentage;
				} else {
					$percentage = $taxrate;	
				}
			}
		}
		
		return $percentage;
	}
	
	function get_tax_percentage($doshipping = false) {
		global $wpdb, $wpcoDb, $Order, $wpcoTax;
		$percentage = $this -> get_option('tax_percentage');
		
		if ($order_id = $Order -> current_order_id()) {		
			$wpcoDb -> model = $Order -> model;
			
			if (empty($doshipping) || $doshipping == false) {
				if ($Order -> do_shipping($order_id)) {
					$doshipping = true;
				}
			}
			
			//$order_query = "SELECT * FROM `" . $wpdb -> prefix . $Order -> table . "` WHERE `id` = '" . $order_id . "'";
			//if ($order = $wpdb -> get_row($order_query)) {			
			$wpcoDb -> model = $Order -> model;
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {			
				$country = "";
				$state = "";
				
				if (!empty($order -> user_id) && $user = $this -> userdata($order -> user_id)) {
					if (!empty($user -> ship_country)) { $country = $user -> ship_country; }
					elseif (!empty($user -> bill_country)) { $country = $user -> bill_country; }
					if (!empty($user -> ship_state)) { $state = $user -> ship_state; }
					elseif (!empty($user -> bill_state)) { $state = $user -> bill_state; }
				} else {
					if (!empty($order -> ship_country)) { $country = $order -> ship_country; }
					elseif (!empty($order -> bill_country)) { $country = $order -> bill_country; }
					if (!empty($order -> ship_state)) { $state = $order -> ship_state; }
					elseif (!empty($order -> bill_state)) { $state = $order -> bill_state; }
				}
				
				if (!empty($country)) {							
					$wpcoDb -> model = $wpcoTax -> model;
					
					if ($taxrate = $wpcoDb -> find(array('country_id' => $country, 'state' => $state))) {
						$percentage = $taxrate -> percentage;	
					} else {
						$wpcoDb -> model = $wpcoTax -> model;
						if ($taxrate = $wpcoDb -> find(array('country_id' => $country, 'state' => ""))) {
							$percentage = $taxrate -> percentage;	
						} else {
							if ($taxrate = $wpcoDb -> find(array('country_id' => $country, 'state' => "undefined"))) {
								$percentage = $taxrate -> percentage;	
							}
						}
					}
				}
			}
		}
		
		return $percentage;
	}
	
	function get_taxpercentage_final($product = null) {
		global $Order, $Product;
		$co_id = $Order -> cart_order();
		$percentage = 0;
		
		if (!empty($product)) {
			if (!empty($product -> taxoverride) && $product -> taxoverride == "Y") {
				$percentage = $this -> get_override_tax_percentage($product -> id, $product -> taxrate, maybe_unserialize($product -> taxrates), $Order -> do_shipping($co_id['id']));
			} else {
				$percentage = $this -> get_tax_percentage($Order -> do_shipping($co_id['id']));	
			}
		}
		
		$Product -> tax_percentage = $percentage;
		return $percentage;
	}
	
	function product_tax($product_id = null, $productprice = null, $backwards = false) {
		global $wpdb, $wpcoDb, $Product, $Order;
		$product_tax = 0;
		$co_id = $Order -> cart_order();
		
		if (!empty($product_id)) {
			//$product_query = "SELECT `id`, `taxexempt`, `taxoverride`, `taxrate`, `taxrates` FROM `" . $wpdb -> prefix . $Product -> table . 
			//				"` WHERE `id` = '" . $product_id . "' LIMIT 1";
			//if ($product = $wpdb -> get_row($product_query)) {
			
			$wpcoDb -> model = $Product -> model;
			if ($product = $wpcoDb -> find(array('id' => $product_id))) {
				if (empty($product -> taxexempt) || $product -> taxexempt == "N") {
					$percentage = $this -> get_taxpercentage_final($product);
					
					if (empty($productprice)) {
						$productprice = $Product -> unit_price($product -> id, 999999, false, true, true, false, false);
					}
					
					if ($backwards == true || (!empty($product -> taxincluded) && $product -> taxincluded == 1)) {					
						// Backwards calculate the tax from the total and percentage
						$product_tax = ($productprice - ($productprice / ((100 + $percentage) / 100)));
					} else {
						$product_tax = (($productprice * $percentage) / 100);
					}
				}
			}
		}
	
		return $product_tax;	
	}
}

?>