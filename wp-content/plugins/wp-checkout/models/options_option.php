<?php

class wpcoOptionsOption extends wpCheckoutPlugin {

	var $model = 'wpcoOptionsOption';
	var $controller = 'optionsoptions';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'cond_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'option_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'price'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'cond_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'option_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'price'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoOptionsOption($data = array()) {
		global $wpdb, $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		if (!empty($data)) {
			$data = (!empty($data[$this -> model])) ? $data[$this -> model] : $data;
			extract($data, EXTR_SKIP);
			
			if (empty($cond_id)) { $this -> errors['cond_id'] = __('No condition option was specified', $this -> plugin_name); }
			if (empty($option_id)) { $this -> errors['option_id'] = __('No conditional option was specified', $this -> plugin_name); }
			if (empty($price) && $price != "0.00") { $this -> errors['price'] = __('No price was specified', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted for validation', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'cond_id'			=>	0,
			'option_id'			=>	0,
			'price'				=>	"0.00",
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
}

?>