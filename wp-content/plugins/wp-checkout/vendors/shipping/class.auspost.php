<?php

class wpcoauspost extends wpCheckoutPlugin {

	var $api_url = "http://drc.edeliver.com.au/ratecalc.asp";	
	var $Pickup_Postcode = 3000;
	var $Destination_Postcode = 3000;
	var $Country = "AU";
	var $Weight = 0;
	var $Service_Type = "STANDARD";
	var $Length = 200;
	var $Width = 200;
	var $Height = 200;
	var $Quantity = 1;
	var $errors = array();

	function wpcoauspost() {
		$this -> servicetypes = array(
			'STANDARD'					=>	__('Standard', $this -> plugin_name),
			'EXPRESS'					=>	__('Express', $this -> plugin_name),
			'EXP_PLT'					=>	__('Express Platinum', $this -> plugin_name),
			'ECONOMY'					=>	__('Economy', $this -> plugin_name),
			'AIR'						=>	__('Air', $this -> plugin_name),
			'SEA'						=>	__('Sea', $this -> plugin_name),
			'EPI'						=>	__('Express International', $this -> plugin_name),
		);
	
		return true;
	}
	
	function savemethod($cu_prices = null, $cu_shipmethod = null) {
		global $Order, $wpdb, $wpcoDb, $wpcoShipmethod, $user_ID, $wpcoHtml;
	
		if (!empty($cu_shipmethod)) {							
			if ($order_id = $Order -> current_order_id()) {
				$wpcoDb -> model = $Order -> model;
				if ($order = $wpcoDb -> find(array('id' => $order_id))) {
					$wpcoDb -> model = $wpcoShipmethod -> model;
					if ($shipmethod = $wpcoDb -> find(array('id' => $order -> shipmethod_id))) {	
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('cu_shipmethod', $cu_shipmethod, array('id' => $order_id));
						if ($user_ID) { update_user_meta($user_ID, 'cu_shipmethod', $cu_shipmethod); }						
						$shipping = $cu_prices[$cu_shipmethod];
						$shipmethod_name = $wpcoHtml -> shipmethod_name($shipmethod -> id, $order_id);						
						$wpcoDb -> model = $Order -> model;	 $wpcoDb -> save_field('api_shipping', $shipping, array('id' => $order_id));	
						$wpcoDb -> model = $Order -> model;	 $wpcoDb -> save_field('shipmethod_name', $shipmethod_name, array('id' => $order_id));							
						$cp_saved = true;							
						return $shipping;
					}
				}
			}
		}
		
		return false;
	}
	
	function shipmethod($shipmethod = null) {
		global $wpdb, $wpcoDb, $wpcoHtml, $user_ID, $Order, $wpcoShipmethod;
		$order_id = $Order -> current_order_id();
		$wpcoDb -> model = $Order -> model;		
		if ($order = $wpcoDb -> find(array('id' => $order_id))) {
			if (!empty($shipmethod)) {
				$weight = $Order -> weight($order_id);
				$weightmeasurement = $this -> get_option('weightm');
				
				$api_options = maybe_unserialize($shipmethod -> api_options);
							
				if (!empty($api_options)) {
					$this -> Pickup_Postcode = $api_options['Pickup_Postcode'];
					$this -> Destination_Postcode = $order -> ship_zipcode;
					$this -> Country = $order -> ship_countrycode;
					
					//needs to be in Gram (g)
					switch ($weightmeasurement) {
						//Kilogram
						case 'kg'	:
							$nweight = ($weight * 1000);
							break;
						//Pound
						case 'lb'	:
							$nweight = ($weight * 453.6);
							break;
						//Ounce
						case 'oz'	:
							$nweight = ($weight * 28.35);
							break;
						default		:
							$nweight = $weight;
							break;
					}
					
					$this -> Weight = $nweight;
					$this -> Quantity = 1;
					
					$prices = array();
					$auspost_errors = array();
					
					foreach ($api_options['auspost_servicetypes'] as $servicetype) {													
						$this -> Service_Type = $servicetype;
						$result = $this -> shipping_by_weight($nweight);
						$prices[$servicetype] = array();
						
						foreach ($result as $res) {
							$resarr = split("=", $res);
							
							switch (trim($resarr[0])) {
								case 'charge'		:
									$price = trim($resarr[1]);
									$prices[$servicetype]['price'] = $price;
									break;
								case 'days'			:
									$prices[$servicetype]['days'] = trim($resarr[1]);
									break;
								case 'err_msg'		:
									$resarr[1] = trim($resarr[1]);
									$prices[$servicetype]['err_msg'] = trim($resarr[1]);
									
									if ($resarr[1] != "OK") {
										$auspost_errors[$servicetype] = trim($resarr[1]);
									}
									break;
							}
						}
					}
					
					if (!empty($prices)) {
						$this -> render('shipping' . DS . 'auspost', array('api_options' => $api_options, 'prices' => $prices, 'errors' => $auspost_errors, 'ajaxquote' => true), true, 'default');
					} else {
						$message = __('No prices are available.', $this -> plugin_name); 
					}
				} else {
					$message = __('No API options are available, please reconfigure this shipping method.', $this -> plugin_name);
				}
			}
		}
		
		return false;	
	}
	
	function shipping_by_weight($weight = null) {
		$this -> Weight = $weight;
		
		if ($this -> Country == "UK") {
			$this -> Country = "GB";
		}
		
		if (empty($this -> Pickup_Postcode)) $this -> Pickup_Postcode = '3000';
		if (empty($this -> Destination_Postcode)) $this -> Destination_Postcode = '3000';
		if (empty($this -> Country)) $this -> Country = 'AU';
	
		$url = rtrim($this -> api_url, '/') . '?' . 
		'Pickup_Postcode=' . $this -> Pickup_Postcode . '&' .
		'Destination_Postcode=' . urlencode($this -> Destination_Postcode) . '&' .
		'Country=' . $this -> Country . '&' .
		'Weight=' . $this -> Weight . '&' .
		'Service_Type=' . $this -> Service_Type . '&' .
		'Length=' . $this -> Length . '&' .
		'Width=' . $this -> Width . '&' .
		'Height=' . $this -> Height . '&' .
		'Quantity=' . $this -> Quantity;
		
		if ($result = file($url)) {										
			return $result;
		}
		
		return false;
	}
}

?>