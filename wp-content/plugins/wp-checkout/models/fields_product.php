<?php

class wpcoFieldsProduct extends wpCheckoutPlugin {

	var $model = 'wpcoFieldsProduct';
	var $controller = 'fieldsproducts';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'field_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'field_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $errors = array();
	
	function wpcoFieldsProduct($data = array()) {
		global $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data) && (is_array($data) || is_object($data))) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'field_id'		=>	'0',
			'product_id'	=>	'0',
			'created'		=>	$wpcoHtml -> gen_date(),
			'modified'		=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
	
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
}

?>