<?php

class wpcoShiprate extends wpCheckoutPlugin {

	var $model = 'wpcoShiprate';
	var $controller = 'shiprates';
	var $table = '';
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'price'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'pricetype'			=>	"VARCHAR(100) NOT NULL DEFAULT 'curr'",
		'shipmethod_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'country_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'state'				=>	"VARCHAR(250) NOT NULL DEFAULT ''",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'price'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'pricetype'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT 'curr'"),
		'shipmethod_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'country_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'state'				=>	array("VARCHAR(250)", "NOT NULL DEFAULT ''"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_country_id` (`country_id`), KEY `index_state` (`state`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoShiprate($data = array()) {
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
			
			if (empty($shipmethod_id)) { $this -> errors['shipmethod_id'] = __('Please choose a shipping method.', $this -> plugin_name); }
			if (empty($price)) $this -> errors['price'] = __('Please fill in a price', $this -> plugin_name);
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
	
	function shipping($order_id = null, $type = "price") {
		global $wpdb, $wpcoDb, $Order;
	
		if (!empty($order_id)) {
			$wpcoDb -> model = $Order -> model; 
			
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {
				if (!empty($order -> ship_country)) {
					$wpcoDb -> model = $this -> model;
					
					$shipmethod_id = $order -> shipmethod_id;
					$country_id = $order -> ship_country;
					$state = $order -> ship_state;
					
					if ($shiprate = $wpcoDb -> find(array('shipmethod_id' => $shipmethod_id, 'country_id' => $country_id, 'state' => $state))) {
						if ($type == "price") {
							return $shiprate -> price;
						} else {
							return $shiprate -> pricetype;
						}
					} elseif ($shiprate = $wpcoDb -> find(array('shipmethod_id' => $shipmethod_id, 'country_id' => $country_id, 'state' => ""))) {
						if ($type == "price") {
							return $shiprate -> price;
						} else {
							return $shiprate -> pricetype;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function type($order_id = null) {
		$type = "curr";
		$type = $this -> shipping($order_id, "type");		
		return $type;
	}
}

?>