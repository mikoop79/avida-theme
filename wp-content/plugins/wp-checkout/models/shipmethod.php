<?php

class wpcoShipmethod extends wpCheckoutPlugin {

	var $model = 'wpcoShipmethod';
	var $controller = 'shipmethods';
	var $table = '';
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'name'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'fixed'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'api'				=> 	"TEXT NOT NULL",
		'api_options'		=>	"TEXT NOT NULL",
		'tiers'				=>	"TEXT NOT NULL",
		'status'			=>	"ENUM('active','inactive') NOT NULL DEFAULT 'active'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'name'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'fixed'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'api'				=> 	array("TEXT", "NOT NULL"),
		'api_options'		=>	array("TEXT", "NOT NULL"),
		'tiers'				=>	array("TEXT", "NOT NULL"),
		'status'			=>	array("ENUM('active','inactive')", "NOT NULL DEFAULT 'active'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoShipmethod($data = array()) {
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			
				switch ($dkey) {
					case 'tiers'	:
						$this -> tiers = maybe_unserialize($dval);
						break;
					default			:
						//do nothing...
						break;
				}
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
			
			if (empty($name)) $this -> errors['name'] = __('Please fill in a shipping method name', $this -> plugin_name);
			if (empty($status)) { $this -> errors['status'] = __('Please choose a status for this shipping method', $this -> plugin_name); }
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
	
	function get_canadapost_shipmethod($order = null, $items = null) {
		global $wpcoDb, $Order, $Item, $wpcoShipmethod;
		$cp_shipmethod = false;
		
		if (!empty($order) && !empty($items)) {
			$wpcoDb -> model = $wpcoShipmethod -> model;
			if ($shipmethod = $wpcoDb -> find(array('id' => $order -> shipmethod_id))) {
				if (!empty($shipmethod -> api) && $shipmethod -> api == "canadapost") {
					if ($cp = $this -> vendor('canadapost', "shipping" . DS . "canadapost" . DS)) {
						$api_options = maybe_unserialize($shipmethod -> api_options);
						
						$userdata = $this -> userdata($order -> user_id);
						$cp_city = $userdata -> ship_city;
						$cp_state = $userdata -> ship_state;
						$cp_country = $userdata -> ship_countrycode;
						$cp_zip = $userdata -> ship_zipcode;
						
						$cp -> merchant_cpcid = $api_options['CSCID'];
						$cp -> from_postal_code = $api_options['ORIGZIP'];
						$cp -> turn_around_time = $api_options['TURNAROUND'];
						$cp -> CanadaPost();
						
						if (!empty($items)) {								
							foreach ($items as $item) {
								if ($item -> product -> type == "tangible" && $item -> product -> excludeglobal == "N") {
									$cp -> addItem($item -> count, $item -> product -> weight, $item -> product -> width, $item -> product -> length, $item -> product -> height, apply_filters($this -> pre . '_product_title', $item -> product -> title));
								}
							}
						}
						
						$cp -> getQuote($cp_city, $cp_state, $cp_country, $cp_zip);
						
						if (!empty($cp -> shipping_methods)) {
							foreach ($cp -> shipping_methods as $shipping_mkey => $shipping_method) {
								if (!empty($order -> cp_shipmethod) && $order -> cp_shipmethod == ($shipping_mkey + 1)) {
									$cp_shipmethod = $shipping_method;	
								}
							}
						}
					}	
				}
			}
		}
		
		return $cp_shipmethod;
	}
	
	function price($shipmethod_id = null, $order_id = null) {
		global $wpcoDb, $Order, $Item, $Product, $Country;
		$price = 0;
	
		if (!empty($shipmethod_id) && !empty($order_id)) {
			$wpcoDb -> model = $Order -> model;
			$order = $wpcoDb -> find(array('id' => $order_id));
			$weight = $Order -> weight($order_id);
			
			$wpcoDb -> model = $this -> model;
			
			if ($shipmethod = $wpcoDb -> find(array('id' => $shipmethod_id))) {				
				switch ($shipmethod -> api) {
					/*
					case 'auspost'				:					
						if (!empty($didbase) || $didbase == false) {
							global $auspost;
							if (!is_object($auspost)) {
								$auspost = $this -> vendor('auspost', 'shipping' . DS);
							}
							
							//needs to be in Gram (g)
							switch ($this -> get_option('weightm')) {
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
							
							if (!empty($shipmethod -> api_options)) {
								$api_options = maybe_unserialize($shipmethod -> api_options);
							
								if (is_array($api_options)) {
									foreach ($api_options as $akey => $aval) {
										$auspost -> {$akey} = $aval;
									}
								}
							}
							
							$auspost -> Weight = $nweight;
							$auspost -> Quantity = 1;
							
							$userdata = $this -> userdata();
							$auspost -> Destination_Postcode = $userdata -> ship_zipcode;
							$auspost -> Country = $userdata -> ship_countrycode;
							
							if ($result = $auspost -> shipping_by_weight($nweight)) {												
								foreach ($result as $res) {
									$resarr = split("=", $res);
									
									switch (trim($resarr[0])) {
										case 'charge'		:
											$price = trim($resarr[1]);
											break;
										case 'days'			:
										
											break;
										case 'err_msg'		:
											$resarr[1] = trim($resarr[1]);
											if ($resarr[1] != "OK") {
												$price = "N";	
												$auspost -> errors[$api_options['Service_Type']] = $resarr[1];
											}
											break;
									}
								}
							}
							
							$didbase = true;
						}
						break;*/
					default						:
						if ($shippingtype = $this -> get_option('shippingtype')) {					
							switch ($shippingtype) {
								case 'fixed'			:
									$price = number_format($shipmethod -> fixed, 2, '.', '');
									break;
								case 'tiers'			:
									$total = $Order -> total($order_id, false, false);							
									$shippingtiers = $shipmethod -> tiers;
									
									if ($this -> get_option('shiptierstype') == "units") {
										$order_units = $Order -> order_units($order_id);
									
										if (!empty($shippingtiers) && is_array($shippingtiers)) {
											$s = 1;
										
											foreach ($shippingtiers as $tier) {
												if (($order_units >= $tier['min'] && $order_units <= $tier['max']) || $s == count($shippingtiers)) {
													$price = number_format($tier['price'], 2, '.', '');
													break 1;
												}
												
												$s++;
											}
										}
									} elseif ($this -> get_option('shiptierstype') == "price") {
										if (!empty($shippingtiers) && is_array($shippingtiers)) {
											$s = 1;
										
											foreach ($shippingtiers as $tier) {
												if (($total >= $tier['min'] && $total <= $tier['max']) || $s == count($shippingtiers)) {
													$price = number_format($tier['price'], 2, '.', '');
													break 1;
												}
												
												$s++;
											}
										}
									} elseif ($this -> get_option('shiptierstype') == "weight") {
										global $Order;
																			
										switch ($shipmethod -> api) {
											/*
											case 'auspost'				:
												
												break;*/
											default						:											
												if (!empty($shippingtiers) && is_array($shippingtiers)) {
													if (empty($didbase) || $didbase == false) {
														$s = 1;
														
														foreach ($shippingtiers as $tier) {
															if (($weight >= $tier['min'] && $weight <= $tier['max']) || $s == count($shippingtiers)) {													
																$price = $tier['price'];
																break 1;
															}
															
															$s++;
														}
														
														$didbase = true;
													}
												}
												break;
										}
									}
									break;
							}
						}
						break;
				}
			}
		}
		
		return $price;
	}
}

?>