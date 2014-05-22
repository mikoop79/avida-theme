<?php

class wpcoKeyword extends wpCheckoutPlugin {

	//Keyword model name
	var $model = 'wpcoKeyword';
	var $controller = 'keywords';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'keyword'			=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'category_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'keyword'			=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'category_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoKeyword($data = array()) {
		global $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			
				switch ($dkey) {
					default			:
						//do nothing...
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function validate($data = array()) {
		global $wpdb, $wpcoDb, $Style, $Product, $Order;
	
		$this -> errors = array();
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
		
		if (empty($keyword)) { $this -> errors['keyword'] = __('Please specify a keyword/tag', $this -> plugin_name); }
	
		$wpcoDb -> model = $this -> model;
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'keyword'			=>	'',
			'product_id'		=>	0,
			'category_id'		=>	0,
			'created' 			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
}

?>