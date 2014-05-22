<?php

class wpcoFieldsOrder extends wpCheckoutPlugin {

	var $model = 'wpcoFieldsOrder';
	var $controller = 'fieldsorders';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'field_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'cart_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'order_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'value'				=>	"TEXT NOT NULL",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'field_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'cart_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'value'				=>	array("TEXT", "NOT NULL"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $errors = array();
	
	function wpcoFieldsOrder($data = array()) {
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
			'order_id'		=>	'0',
			'value'			=>	"",
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