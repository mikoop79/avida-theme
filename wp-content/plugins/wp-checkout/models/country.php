<?php

class wpcoCountry extends wpCheckoutPlugin {

	var $model = 'Country';
	var $controller = 'countries';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'value'				=>	"VARCHAR(155) NOT NULL DEFAULT ''",
		'code'				=>	"CHAR(2) NOT NULL DEFAULT 'US'",
		'isocode'			=>	"CHAR(3) NOT NULL DEFAULT 'USA'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'value'				=>	array("VARCHAR(155)", "NOT NULL DEFAULT ''"),
		'code'				=>	array("CHAR(2)", "NOT NULL DEFAULT 'US'"),
		'isocode'			=> 	array("CHAR(3)", "NOT NULL DEFAULT 'USA'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoCountry($data = array()) {
		global $wpdb, $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function value_by_id($id = null) {
		if (!empty($id)) {
			global $wpcoDb;
			$wpcoDb -> model = $this -> model;
			
			if ($country = $wpcoDb -> find(array('id' => $id), array('value'))) {
				return $country -> value;	
			}
		}
	}
	
	function code_by_id($id = null) {
		$code = "US";
	
		if (!empty($id)) {
			global $wpcoDb;
			$wpcoDb -> model = $this -> model;
			
			if ($country = $wpcoDb -> find(array('id' => $id))) {
				$code = $country -> code;
			}
		}
		
		return $code;
	}
	
	function isocode_by_id($id = null) {
		$code = "USA";
		
		if (!empty($id)) {
			global $wpcoDb;
			
			if ($code = $wpcoDb -> field('isocode', array('id' => $id))) {
				return $code;
			}
		}
		
		return $ccode;
	}
	
	function select($domarkets = false) {
		global $wpcoDb;
		static $select = array();
		$markets = $this -> get_option('markets');
		
		$wpcoDb -> model = $this -> model;
		
		if ($countries = $wpcoDb -> find_all(false, false, array('value', "ASC"))) {
			foreach ($countries as $country) {
				$select[$country -> id] = $country -> value;
				
				if (!empty($domarkets) && $domarkets == true && !empty($markets)) {
					if (!in_array($country -> id, $markets)) {
						unset($select[$country -> id]);	
					}
				}
			}
		}
		
		return $select;
	}
	
	function initialize() {
		global $wpdb, $countries, $states, $wpcoDb, $wpcoState;
		
		$query = "SELECT `id` FROM `" . $wpdb -> prefix . "wpcocountries` LIMIT 1";
		if (!$wpdb -> get_results($query)) {
			$this -> check_table($this -> model);
			include $this -> plugin_base() . DS . 'includes' . DS . 'countries.php';			
			$wpdb -> query($countries);
			$this -> update_option('countriesadded', "Y");			
			if (!empty($states)) {					
				foreach ($states as $country_id => $allstates) {
					foreach ($allstates as $state) {
						$wpcoDb -> model = $wpcoState -> model;
						
						if (!$wpcoDb -> find(array('name' => $state))) {							
							$data = array('name' => $state, 'country_id' => $country_id);								
							$wpcoDb -> model = $wpcoState -> model;
							$wpcoDb -> save($data, true);
						}
					}
				}
			}
		}	
	}
}

?>