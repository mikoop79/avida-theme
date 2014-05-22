<?php

class wpcoProductsProduct extends wpCheckoutPlugin {

	var $model = 'wpcoProductsProduct';
	var $controller = 'productsproducts';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'related_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'related_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoProductsProduct($data = array()) {
		global $wpcoDb, $Product;
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
	
		if (!empty($data)) {		
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			if (empty($product_id)) { $this -> errors['product_id'] = __('No product was specified', $this -> plugin_name); }
			if (empty($related_id)) { $this -> errors['related_id'] = __('No related product was specified', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
}

?>